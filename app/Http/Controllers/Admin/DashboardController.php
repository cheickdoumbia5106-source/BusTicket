<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\Trajet;
use App\Models\User;
use App\Models\Ville;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users' => User::count(),
            'total_reservations' => Reservation::count(),
            'total_trajets' => Trajet::where('date_depart', '>=', now())->count(),
            'total_villes' => Ville::count(),
            'reservations_mois' => Reservation::whereMonth('created_at', now()->month)->count(),
            'chiffre_affaires' => Reservation::where('statut', 'confirmee')->sum('montant_total'),
        ];

        $recentReservations = Reservation::with(['user', 'trajet'])
            ->latest()
            ->take(5)
            ->get();

        $upcomingTrajets = Trajet::with(['villeDepart', 'villeArrivee'])
            ->where('date_depart', '>=', now())
            ->orderBy('date_depart')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentReservations', 'upcomingTrajets'));
    }
}