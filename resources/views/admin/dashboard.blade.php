@extends('admin.layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 bg-indigo-100 rounded-full">
                <span class="text-2xl">👥</span>
            </div>
            <div class="ml-4">
                <p class="text-gray-500 text-sm">Utilisateurs</p>
                <p class="text-2xl font-bold">{{ $stats['total_users'] }}</p>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 bg-green-100 rounded-full">
                <span class="text-2xl">🎫</span>
            </div>
            <div class="ml-4">
                <p class="text-gray-500 text-sm">Réservations</p>
                <p class="text-2xl font-bold">{{ $stats['total_reservations'] }}</p>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 bg-blue-100 rounded-full">
                <span class="text-2xl">🗺️</span>
            </div>
            <div class="ml-4">
                <p class="text-gray-500 text-sm">Trajets à venir</p>
                <p class="text-2xl font-bold">{{ $stats['total_trajets'] }}</p>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 bg-yellow-100 rounded-full">
                <span class="text-2xl">💰</span>
            </div>
            <div class="ml-4">
                <p class="text-gray-500 text-sm">Chiffre d'affaires</p>
                <p class="text-2xl font-bold">{{ number_format($stats['chiffre_affaires'], 0, ',', ' ') }} FCFA</p>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <div class="bg-white rounded-lg shadow">
        <div class="border-b px-6 py-4">
            <h3 class="font-semibold text-gray-800">Dernières réservations</h3>
        </div>
        <div class="p-6">
            @foreach($recentReservations as $reservation)
                <div class="border-b last:border-0 py-3">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="font-semibold">{{ $reservation->user->name }}</p>
                            <p class="text-sm text-gray-600">{{ $reservation->trajet->villeDepart->nom }} → {{ $reservation->trajet->villeArrivee->nom }}</p>
                        </div>
                        <div class="text-right">
                            <p class="font-bold text-indigo-600">{{ number_format($reservation->montant_total, 0, ',', ' ') }} FCFA</p>
                            <p class="text-xs text-gray-500">{{ $reservation->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow">
        <div class="border-b px-6 py-4">
            <h3 class="font-semibold text-gray-800">Prochains départs</h3>
        </div>
        <div class="p-6">
            @foreach($upcomingTrajets as $trajet)
                <div class="border-b last:border-0 py-3">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="font-semibold">{{ $trajet->villeDepart->nom }} → {{ $trajet->villeArrivee->nom }}</p>
                            <p class="text-sm text-gray-600">{{ $trajet->date_depart->format('d/m/Y') }} à {{ $trajet->heure_depart->format('H:i') }}</p>
                        </div>
                        <div class="text-right">
                            <p class="font-bold text-green-600">{{ $trajet->places_libres }} places libres</p>
                            <p class="text-xs text-gray-500">{{ $trajet->prix }} FCFA</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection