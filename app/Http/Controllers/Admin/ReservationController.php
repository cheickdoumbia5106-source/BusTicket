<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function index(Request $request)
    {
        $query = Reservation::with(['user', 'trajet.villeDepart', 'trajet.villeArrivee', 'sieges']);

        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }

        if ($request->filled('date_debut')) {
            $query->whereDate('created_at', '>=', $request->date_debut);
        }

        if ($request->filled('date_fin')) {
            $query->whereDate('created_at', '<=', $request->date_fin);
        }

        $reservations = $query->orderBy('created_at', 'desc')->paginate(20);
        $statuts = ['en_attente', 'confirmee', 'annulee'];

        return view('admin.reservations.index', compact('reservations', 'statuts'));
    }

    public function show(Reservation $reservation)
    {
        $reservation->load(['user', 'trajet', 'sieges', 'paiement']);
        return view('admin.reservations.show', compact('reservation'));
    }

    public function updateStatus(Request $request, Reservation $reservation)
    {
        $request->validate([
            'statut' => 'required|in:en_attente,confirmee,annulee',
        ]);

        $reservation->update(['statut' => $request->statut]);

        return back()->with('success', 'Statut de la réservation mis à jour.');
    }

    public function destroy(Reservation $reservation)
    {
        $reservation->sieges()->detach();
        if ($reservation->paiement) {
            $reservation->paiement()->delete();
        }
        $reservation->delete();

        return redirect()->route('admin.reservations.index')->with('success', 'Réservation supprimée.');
    }
}