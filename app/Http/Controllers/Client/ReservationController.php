<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\Siege;
use App\Models\Trajet;
use App\Models\Paiement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class ReservationController extends Controller
{
    public function prepare(Request $request)
    {
        // Vérifier que l'utilisateur est connecté
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Veuillez vous connecter pour réserver.');
        }

        $request->validate([
            'trajet_id' => 'required|exists:trajets,id',
            'sieges' => 'required|json',
        ]);

        $trajet = Trajet::findOrFail($request->trajet_id);
        $siegeIds = json_decode($request->sieges, true);
        
        if (empty($siegeIds)) {
            return back()->with('error', 'Veuillez sélectionner au moins un siège.');
        }
        
        $sieges = Siege::whereIn('id', $siegeIds)->get();
        
        // Vérifier que les sièges sont toujours disponibles
        $siegesReserves = $trajet->reservations()
            ->where('statut', 'confirmee')
            ->with('sieges')
            ->get()
            ->pluck('sieges')
            ->flatten()
            ->pluck('id')
            ->toArray();

        foreach ($sieges as $siege) {
            if (in_array($siege->id, $siegesReserves)) {
                return back()->with('error', 'Un ou plusieurs sièges ne sont plus disponibles.');
            }
        }

        $montantTotal = count($sieges) * $trajet->prix;
        
        // Stocker en session
        session([
            'reservation_temp' => [
                'trajet_id' => $trajet->id,
                'sieges' => $siegeIds,
                'montant_total' => $montantTotal,
                'expires_at' => now()->addMinutes(15),
            ]
        ]);

        return redirect()->route('reservation.recap');
    }
    
    public function recap()
    {
        $temp = session('reservation_temp');
        
        if (!$temp || now() > $temp['expires_at']) {
            session()->forget('reservation_temp');
            return redirect()->route('home')->with('error', 'Votre session a expiré, veuillez recommencer.');
        }

        $trajet = Trajet::with(['villeDepart', 'villeArrivee', 'bus'])->find($temp['trajet_id']);
        $sieges = Siege::whereIn('id', $temp['sieges'])->get();
        $montantTotal = $temp['montant_total'];

        return view('client.payment-recap', compact('trajet', 'sieges', 'montantTotal'));
    }

    public function confirm(Request $request)
    {
        $temp = session('reservation_temp');
        
        if (!$temp || now() > $temp['expires_at']) {
            return redirect()->route('home')->with('error', 'Session expirée.');
        }

        $request->validate([
            'mode_paiement' => 'required|in:simule,especes',
        ]);

        // Créer la réservation
        $reservation = Reservation::create([
            'user_id' => Auth::id(),
            'trajet_id' => $temp['trajet_id'],
            'reference' => 'TKT-' . strtoupper(Str::random(8)),
            'statut' => $request->mode_paiement === 'simule' ? 'confirmee' : 'en_attente',
            'montant_total' => $temp['montant_total'],
            'date_reservation' => now(),
        ]);

        // Attacher les sièges
        foreach ($temp['sieges'] as $siegeId) {
            $reservation->sieges()->attach($siegeId, [
                'prix_unitaire' => $temp['montant_total'] / count($temp['sieges'])
            ]);
        }

        // Générer un transaction_id unique
        $transactionId = $request->mode_paiement === 'simule' 
            ? 'SIM_' . strtoupper(Str::random(15)) . '_' . time()
            : null;

        // Créer le paiement avec TOUS les champs requis
        $paiementData = [
            'reservation_id' => $reservation->id,
            'montant' => $temp['montant_total'], // AJOUTER LE MONTANT
            'mode_paiement' => $request->mode_paiement,
            'statut' => $request->mode_paiement === 'simule' ? 'paye' : 'en_attente',
            'transaction_id' => $transactionId,
            'date_paiement' => $request->mode_paiement === 'simule' ? now() : null, // AJOUTER LA DATE
        ];
        
        $paiement = Paiement::create($paiementData);

        // Nettoyer la session
        session()->forget('reservation_temp');

        // Si le paiement est simulé, envoyer l'email
        if ($request->mode_paiement === 'simule') {
            $this->sendTicketEmail($reservation);
        }

        return redirect()->route('reservation.confirmation', $reservation)->with('success', 'Réservation effectuée avec succès !');
    }

    public function confirmation(Reservation $reservation)
    {
        // Vérifier que la réservation appartient à l'utilisateur connecté
        if ($reservation->user_id !== Auth::id()) {
            abort(403);
        }

        $reservation->load(['trajet.villeDepart', 'trajet.villeArrivee', 'trajet.bus', 'sieges', 'paiement']);

        return view('client.reservation-confirmation', compact('reservation'));
    }

    public function downloadTicket(Reservation $reservation)
    {
        // Vérifier que la réservation appartient à l'utilisateur connecté
        if ($reservation->user_id !== Auth::id()) {
            abort(403);
        }

        $reservation->load(['trajet.villeDepart', 'trajet.villeArrivee', 'trajet.bus', 'sieges', 'user', 'paiement']);

        $pdf = PDF::loadView('pdf.ticket', compact('reservation'));
        
        return $pdf->download('Ticket_' . $reservation->reference . '.pdf');
    }

    private function sendTicketEmail($reservation)
    {
        try {
            $reservation->load(['trajet.villeDepart', 'trajet.villeArrivee', 'trajet.bus', 'sieges', 'user', 'paiement']);
            
            // Générer le PDF
            $pdf = PDF::loadView('pdf.ticket', compact('reservation'));
            
            // Envoyer l'email avec le PDF en pièce jointe
            Mail::send('emails.ticket', ['reservation' => $reservation], function($message) use ($reservation, $pdf) {
                $message->to($reservation->user->email, $reservation->user->name)
                        ->subject('Votre ticket BusTicket - ' . $reservation->reference)
                        ->attachData($pdf->output(), 'Ticket_' . $reservation->reference . '.pdf', [
                            'mime' => 'application/pdf',
                        ]);
            });
            
            Log::info('Ticket email sent to: ' . $reservation->user->email);
        } catch (\Exception $e) {
            Log::error('Failed to send ticket email: ' . $e->getMessage());
        }
    }
}