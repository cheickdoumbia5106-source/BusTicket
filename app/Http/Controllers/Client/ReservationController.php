<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\Siege;
use App\Models\Trajet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

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

        // Rediriger vers le paiement
        return redirect()->route('paiement.process', [
            'reservation' => $reservation->id,
            'mode' => $request->mode_paiement
        ]);
    }
}