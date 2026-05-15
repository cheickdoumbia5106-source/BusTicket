<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bus;
use App\Models\Trajet;
use App\Models\Ville;
use Illuminate\Http\Request;

class TrajetController extends Controller
{
    public function index()
    {
        $trajets = Trajet::with(['villeDepart', 'villeArrivee', 'bus'])
            ->orderBy('date_depart', 'desc')
            ->paginate(15);
        return view('admin.trajets.index', compact('trajets'));
    }

    public function create()
    {
        $villes = Ville::orderBy('nom')->get();
        $buses = Bus::all();
        return view('admin.trajets.create', compact('villes', 'buses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'ville_depart_id' => 'required|exists:villes,id|different:ville_arrivee_id',
            'ville_arrivee_id' => 'required|exists:villes,id',
            'bus_id' => 'required|exists:buses,id',
            'date_depart' => 'required|date|after_or_equal:today',
            'heure_depart' => 'required',
            'heure_arrivee' => 'required|after:heure_depart',
            'prix' => 'required|numeric|min:0',
        ]);

        Trajet::create($request->all());

        return redirect()->route('admin.trajets.index')->with('success', 'Trajet ajouté avec succès.');
    }

    public function edit(Trajet $trajet)
    {
        $villes = Ville::orderBy('nom')->get();
        $buses = Bus::all();
        return view('admin.trajets.edit', compact('trajet', 'villes', 'buses'));
    }

    public function update(Request $request, Trajet $trajet)
    {
        $request->validate([
            'ville_depart_id' => 'required|exists:villes,id|different:ville_arrivee_id',
            'ville_arrivee_id' => 'required|exists:villes,id',
            'bus_id' => 'required|exists:buses,id',
            'date_depart' => 'required|date',
            'heure_depart' => 'required',
            'heure_arrivee' => 'required|after:heure_depart',
            'prix' => 'required|numeric|min:0',
        ]);

        $trajet->update($request->all());

        return redirect()->route('admin.trajets.index')->with('success', 'Trajet modifié avec succès.');
    }

    public function destroy(Trajet $trajet)
    {
        if ($trajet->reservations()->count() > 0) {
            return back()->with('error', 'Impossible de supprimer ce trajet car il a des réservations.');
        }

        $trajet->delete();
        return redirect()->route('admin.trajets.index')->with('success', 'Trajet supprimé avec succès.');
    }
}