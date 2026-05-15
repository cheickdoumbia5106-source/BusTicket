@extends('layouts.app')

@section('content')
<div class="bg-orange-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800">
                Trajets de {{ $villeDepart->nom }} à {{ $villeArrivee->nom }}
            </h1>
            <p class="text-gray-600">
                {{ \Carbon\Carbon::parse($request->date_depart)->format('d/m/Y') }} • 
                {{ $trajets->count() }} trajet(s) trouvé(s)
            </p>
        </div>

        @if($trajets->count() > 0)
            <div class="space-y-4">
                @foreach($trajets as $trajet)
                <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition p-5 border-l-4 border-l-orange-500">
                    <div class="flex flex-wrap justify-between items-center">
                        <!-- Info trajet -->
                        <div class="flex-1">
                            <div class="flex items-center space-x-6 mb-3">
                                <div class="text-center">
                                    <p class="text-2xl font-bold text-gray-800">{{ $trajet->heure_depart->format('H:i') }}</p>
                                    <p class="text-gray-500 text-sm">{{ $trajet->villeDepart->nom }}</p>
                                </div>
                                <div class="text-gray-400 text-xl">→</div>
                                <div class="text-center">
                                    <p class="text-2xl font-bold text-gray-800">{{ $trajet->heure_arrivee->format('H:i') }}</p>
                                    <p class="text-gray-500 text-sm">{{ $trajet->villeArrivee->nom }}</p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-4">
                                <span class="bg-gray-100 px-3 py-1 rounded-full text-sm">
                                    {{ $trajet->bus->compagnie }}
                                </span>
                                <span class="text-sm text-gray-500">{{ $trajet->bus->nom }}</span>
                                <span class="text-green-600 text-sm font-semibold">
                                    ✓ {{ $trajet->places_libres }} places disponibles
                                </span>
                            </div>
                        </div>
                        
                        <!-- Prix et bouton -->
                        <div class="text-right mt-4 md:mt-0">
                            <p class="text-3xl font-bold text-orange-600">
                                {{ number_format($trajet->prix, 0, ',', ' ') }} FCFA
                            </p>
                            <a href="{{ route('sieges.show', $trajet->id) }}" 
                               class="mt-2 inline-block bg-gradient-to-r from-orange-500 to-orange-600 text-white px-6 py-2 rounded-full font-semibold hover:from-orange-600 hover:to-orange-700 transition shadow">
                                Choisir sièges →
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <div class="bg-white rounded-xl shadow-md p-12 text-center">
                <div class="text-6xl mb-4">🚌</div>
                <h3 class="text-xl font-semibold text-gray-800 mb-2">Aucun trajet trouvé</h3>
                <p class="text-gray-600 mb-4">Aucun trajet disponible pour cette date.</p>
                <a href="{{ route('home') }}" class="text-orange-600 hover:text-orange-700 font-semibold">
                    ← Modifier ma recherche
                </a>
            </div>
        @endif
    </div>
</div>
@endsection