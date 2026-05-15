<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ville;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class VilleController extends Controller
{
    public function index()
    {
        $villes = Ville::orderBy('nom')->paginate(10);
        return view('admin.villes.index', compact('villes'));
    }

    public function create()
    {
        return view('admin.villes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255|unique:villes',
        ]);

        Ville::create([
            'nom' => $request->nom,
            'slug' => Str::slug($request->nom),
        ]);

        return redirect()->route('admin.villes.index')->with('success', 'Ville ajoutée avec succès.');
    }

    public function edit(Ville $ville)
    {
        return view('admin.villes.edit', compact('ville'));
    }

    public function update(Request $request, Ville $ville)
    {
        $request->validate([
            'nom' => 'required|string|max:255|unique:villes,nom,' . $ville->id,
        ]);

        $ville->update([
            'nom' => $request->nom,
            'slug' => Str::slug($request->nom),
        ]);

        return redirect()->route('admin.villes.index')->with('success', 'Ville modifiée avec succès.');
    }

    public function destroy(Ville $ville)
    {
        // Vérifier si la ville est utilisée dans des trajets
        if ($ville->trajetsDepart()->count() > 0 || $ville->trajetsArrivee()->count() > 0) {
            return back()->with('error', 'Impossible de supprimer cette ville car elle est utilisée dans des trajets.');
        }

        $ville->delete();
        return redirect()->route('admin.villes.index')->with('success', 'Ville supprimée avec succès.');
    }
}