<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    public function show(Reservation $reservation)
    {
        if ($reservation->user_id !== Auth::id()) {
            abort(403);
        }

        $reservation->load(['trajet.villeDepart', 'trajet.villeArrivee', 'trajet.bus', 'sieges', 'paiement']);
        
        return view('client.ticket', compact('reservation'));
    }

    public function download(Reservation $reservation)
    {
        if ($reservation->user_id !== Auth::id()) {
            abort(403);
        }

        $reservation->load(['trajet.villeDepart', 'trajet.villeArrivee', 'trajet.bus', 'sieges', 'paiement']);
        
        $pdf = Pdf::loadView('client.ticket-pdf', compact('reservation'));
        
        return $pdf->download('ticket-' . $reservation->reference . '.pdf');
    }
}