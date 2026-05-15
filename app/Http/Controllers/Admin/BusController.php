<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bus;
use App\Models\Siege;
use Illuminate\Http\Request;

class BusController extends Controller
{
    public function index()
    {
        $buses = Bus::withCount('sieges')->paginate(10);
        return view('admin.buses.index', compact('buses'));
    }

    public function create()
    {
        return view('admin.buses.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'compagnie' => 'required|string|max:255',
            'nombre_places' => 'required|integer|min:1|max:100',
        ]);

        $bus = Bus::create($request->all());

        // Générer automatiquement les sièges
        $this->genererSieges($bus);

        return redirect()->route('admin.buses.index')->with('success', 'Bus ajouté avec succès.');
    }

    private function genererSieges($bus)
    {
        $nombrePlaces = $bus->nombre_places;
        $cols = 5;
        $rows = ceil($nombrePlaces / $cols);
        $numero = 1;

        for ($rang = 1; $rang <= $rows; $rang++) {
            for ($colonne = 1; $colonne <= $cols; $colonne++) {
                if ($numero <= $nombrePlaces) {
                    Siege::create([
                        'bus_id' => $bus->id,
                        'numero_siege' => $numero,
                        'rang' => $rang,
                        'colonne' => $colonne,
                    ]);
                    $numero++;
                }
            }
        }
    }

    public function edit(Bus $bus)
    {
        return view('admin.buses.edit', compact('bus'));
    }

    public function update(Request $request, Bus $bus)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'compagnie' => 'required|string|max:255',
            'nombre_places' => 'required|integer|min:1|max:100',
        ]);

        $oldPlaces = $bus->nombre_places;
        $bus->update($request->all());

        // Si le nombre de places a changé, régénérer les sièges
        if ($oldPlaces != $bus->nombre_places) {
            $bus->sieges()->delete();
            $this->genererSieges($bus);
        }

        return redirect()->route('admin.buses.index')->with('success', 'Bus modifié avec succès.');
    }

    public function destroy(Bus $bus)
    {
        if ($bus->trajets()->count() > 0) {
            return back()->with('error', 'Impossible de supprimer ce bus car il est utilisé dans des trajets.');
        }

        $bus->sieges()->delete();
        $bus->delete();

        return redirect()->route('admin.buses.index')->with('success', 'Bus supprimé avec succès.');
    }
}