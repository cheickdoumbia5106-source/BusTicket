@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-800">
            Trajets de {{ $villeDepart->nom }} à {{ $villeArrivee->nom }}
        </h1>
        <p class="text-gray-600">Date : {{ \Carbon\Carbon::parse($request->date_depart)->format('d/m/Y') }}</p>
    </div>

    @if($trajets->count() > 0)
        <div class="space-y-4">
            @foreach($trajets as $trajet)
            <div class="bg-white rounded-xl shadow-md p-6 hover:shadow-lg transition">
                <div class="flex flex-wrap justify-between items-center">
                    <div class="flex-1">
                        <div class="flex items-center space-x-4">
                            <div>
                                <p class="text-2xl font-bold">{{ $trajet->heure_depart->format('H:i') }}</p>
                                <p class="text-gray-600">{{ $trajet->villeDepart->nom }}</p>
                            </div>
                            <div class="text-gray-400">→</div>
                            <div>
                                <p class="text-2xl font-bold">{{ $trajet->heure_arrivee->format('H:i') }}</p>
                                <p class="text-gray-600">{{ $trajet->villeArrivee->nom }}</p>
                            </div>
                        </div>
                        <div class="mt-2">
                            <p class="text-gray-600">{{ $trajet->bus->compagnie }} - {{ $trajet->bus->nom }}</p>
                            <p class="text-green-600 text-sm">Places disponibles : {{ $trajet->places_libres }}</p>
                        </div>
                    </div>
                    
                    <div class="text-right">
                        <p class="text-3xl font-bold text-indigo-600">{{ number_format($trajet->prix, 0, ',', ' ') }} FCFA</p>
                        <a href="{{ route('sieges.show', $trajet->id) }}" 
                           class="mt-2 inline-block bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700 transition">
                            Choisir mes sièges
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @else
        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-8 text-center">
            <p class="text-yellow-800">Aucun trajet trouvé pour cette date.</p>
            <a href="{{ route('home') }}" class="mt-4 inline-block text-indigo-600 hover:text-indigo-700">
                ← Modifier ma recherche
            </a>
        </div>
    @endif
</div>
@endsection