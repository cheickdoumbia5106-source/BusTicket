<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\Trajet;
use App\Models\User;
use App\Models\Ville;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Définir la locale française pour Carbon
        Carbon::setLocale('fr');
        
        $stats = [
            'total_users' => User::count(),
            'total_reservations' => Reservation::count(),
            'total_trajets' => Trajet::where('date_depart', '>=', now())->count(),
            'total_villes' => Ville::count(),
            'reservations_mois' => Reservation::whereMonth('created_at', now()->month)->count(),
            'chiffre_affaires' => Reservation::where('statut', 'confirmee')->sum('montant_total'),
            'taux_occupation' => $this->calculateOccupationRate(),
        ];

        $chartData = $this->getChartData();
        $topDestinations = $this->getTopDestinations();

        $recentReservations = Reservation::with(['user', 'trajet.villeDepart', 'trajet.villeArrivee'])
            ->latest()
            ->take(5)
            ->get();

        $upcomingTrajets = Trajet::with(['villeDepart', 'villeArrivee', 'bus'])
            ->where('date_depart', '>=', now())
            ->orderBy('date_depart')
            ->take(5)
            ->get()
            ->map(function ($trajet) {
                $reservedSeats = $trajet->reservations()
                    ->where('statut', 'confirmee')
                    ->count();
                
                $capacite = $trajet->bus->nombre_places ?? 50;
                $trajet->places_libres = max(0, $capacite - $reservedSeats);
                return $trajet;
            });

        return view('admin.dashboard', compact('stats', 'chartData', 'topDestinations', 'recentReservations', 'upcomingTrajets'));
    }

    private function getChartData()
    {
        $days = [];
        $reservationsData = [];
        
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $days[] = $date->translatedFormat('D'); // Lun, Mar, Mer, Jeu, Ven, Sam, Dim
            
            $count = Reservation::whereDate('created_at', $date)
                ->where('statut', 'confirmee')
                ->count();
            
            $reservationsData[] = $count;
        }
        
        return [
            'labels' => $days,
            'data' => $reservationsData
        ];
    }

    private function getTopDestinations()
    {
        $topDestinations = Trajet::with(['villeDepart', 'villeArrivee'])
            ->withCount(['reservations as total_reservations' => function($query) {
                $query->where('statut', 'confirmee');
            }])
            ->withSum(['reservations as revenu_total' => function($query) {
                $query->where('statut', 'confirmee');
            }], 'montant_total')
            ->having('total_reservations', '>', 0)
            ->orderByDesc('total_reservations')
            ->limit(3)
            ->get()
            ->map(function ($trajet, $index) {
                $growth = $this->calculateGrowth($trajet);
                
                return [
                    'nom' => $trajet->villeDepart->nom . ' → ' . $trajet->villeArrivee->nom,
                    'count' => (int) $trajet->total_reservations,
                    'revenu' => (float) ($trajet->revenu_total ?? 0),
                    'growth' => $growth,
                    'medal' => $index == 0 ? '🥇' : ($index == 1 ? '🥈' : '🥉'),
                ];
            });

        if ($topDestinations->isEmpty()) {
            $topDestinations = collect([
                ['nom' => 'Dakar → Thiès', 'count' => 0, 'revenu' => 0, 'growth' => 0, 'medal' => '🥇'],
                ['nom' => 'Dakar → Mbour', 'count' => 0, 'revenu' => 0, 'growth' => 0, 'medal' => '🥈'],
                ['nom' => 'Bamako → Kayes', 'count' => 0, 'revenu' => 0, 'growth' => 0, 'medal' => '🥉']
            ]);
        }

        return $topDestinations;
    }

    private function calculateGrowth($trajet)
    {
        $thisWeek = $trajet->reservations()
            ->where('statut', 'confirmee')
            ->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
            ->count();
        
        $lastWeek = $trajet->reservations()
            ->where('statut', 'confirmee')
            ->whereBetween('created_at', [Carbon::now()->subWeek()->startOfWeek(), Carbon::now()->subWeek()->endOfWeek()])
            ->count();
        
        if ($lastWeek == 0) {
            return $thisWeek > 0 ? 100 : 0;
        }
        
        return round((($thisWeek - $lastWeek) / $lastWeek) * 100);
    }

    private function calculateOccupationRate()
    {
        $totalTrajets = Trajet::where('date_depart', '>=', now()->subDays(30))->count();
        if ($totalTrajets == 0) return 0;
        
        $totalReservations = Reservation::where('statut', 'confirmee')->count();
        $taux = round(($totalReservations / ($totalTrajets * 50)) * 100);
        
        return min(100, max(0, $taux));
    }
}