<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Trajet;
use App\Models\Ville;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $villes = Ville::orderBy('nom')->get();
        $trajetsRecents = Trajet::with(['villeDepart', 'villeArrivee', 'bus'])
            ->where('date_depart', '>=', now())
            ->orderBy('date_depart')
            ->take(5)
            ->get();

        return view('client.home', compact('villes', 'trajetsRecents'));
    }
}