<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Paiement;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    public function process($reservationId, $mode)
    {
        $reservation = Reservation::with(['trajet', 'sieges'])->findOrFail($reservationId);
        
        // Vérifier que la réservation appartient à l'utilisateur connecté
        if ($reservation->user_id !== auth()->id()) {
            abort(403);
        }

        return view('client.payment-form', compact('reservation', 'mode'));
    }

    public function simulatePayment(Request $request, Reservation $reservation)
    {
        if ($reservation->user_id !== auth()->id()) {
            abort(403);
        }

        // Créer le paiement
        Paiement::create([
            'reservation_id' => $reservation->id,
            'mode_paiement' => $request->mode,
            'statut' => $request->mode === 'simule' ? 'paye' : 'en_attente',
            'transaction_id' => $request->mode === 'simule' ? 'SIM_' . Str::random(10) : 'ESP_' . Str::random(10),
        ]);

        // Mettre à jour le statut de la réservation si paiement simulé
        if ($request->mode === 'simule') {
            $reservation->update(['statut' => 'confirmee']);
            $message = 'Paiement effectué avec succès ! Votre ticket a été généré.';
        } else {
            $message = 'Réservation confirmée. Veuillez payer à l\'embarquement.';
        }

        // Nettoyer la session
        session()->forget('reservation_temp');

        return redirect()->route('ticket.show', $reservation)->with('success', $message);
    }
}