<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Trajet;
use App\Models\Ville;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $request->validate([
            'ville_depart' => 'required|exists:villes,id',
            'ville_arrivee' => 'required|exists:villes,id|different:ville_depart',
            'date_depart' => 'required|date|after_or_equal:today',
        ]);

        $trajets = Trajet::with(['villeDepart', 'villeArrivee', 'bus'])
            ->where('ville_depart_id', $request->ville_depart)
            ->where('ville_arrivee_id', $request->ville_arrivee)
            ->whereDate('date_depart', $request->date_depart)
            ->orderBy('heure_depart')
            ->get();

        // Calculer les places libres pour chaque trajet
        foreach ($trajets as $trajet) {
            $trajet->places_libres = $trajet->places_libres;
        }

        $villeDepart = Ville::find($request->ville_depart);
        $villeArrivee = Ville::find($request->ville_arrivee);

        return view('client.search-results', compact('trajets', 'villeDepart', 'villeArrivee', 'request'));
    }

    public function showSieges($id, Request $request)
    {
        $trajet = Trajet::with(['villeDepart', 'villeArrivee', 'bus.sieges'])->findOrFail($id);
        
        // Récupérer les sièges déjà réservés pour ce trajet
        $siegesReserves = $trajet->reservations()
            ->where('statut', 'confirmee')
            ->with('sieges')
            ->get()
            ->pluck('sieges')
            ->flatten()
            ->pluck('id')
            ->toArray();

        $tousLesSieges = $trajet->bus->sieges;
        
        // Marquer les sièges comme disponibles ou non
        foreach ($tousLesSieges as $siege) {
            $siege->est_libre = !in_array($siege->id, $siegesReserves);
        }

        return view('client.select-seats', compact('trajet', 'tousLesSieges'));
    }
}