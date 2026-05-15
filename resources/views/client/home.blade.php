@extends('layouts.app')

@section('content')
<div class="bg-gradient-to-r from-indigo-600 to-blue-600 text-white py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-5xl font-bold mb-4">Voyagez en toute simplicité</h1>
        <p class="text-xl mb-8">Réservez vos billets de bus en quelques clics</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-16">
    <div class="bg-white rounded-xl shadow-xl p-6 md:p-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Rechercher un trajet</h2>
        
        <form action="{{ route('search') }}" method="GET">
            <div class="grid md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Ville de départ</label>
                    <select name="ville_depart" required class="w-full border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">Sélectionnez</option>
                        @foreach($villes as $ville)
                            <option value="{{ $ville->id }}">{{ $ville->nom }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Ville d'arrivée</label>
                    <select name="ville_arrivee" required class="w-full border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">Sélectionnez</option>
                        @foreach($villes as $ville)
                            <option value="{{ $ville->id }}">{{ $ville->nom }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Date de départ</label>
                    <input type="date" name="date_depart" required min="{{ date('Y-m-d') }}" 
                           class="w-full border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                </div>
            </div>
            
            <div class="mt-6">
                <button type="submit" class="w-full bg-indigo-600 text-white py-3 rounded-lg font-semibold hover:bg-indigo-700 transition">
                    Rechercher un trajet
                </button>
            </div>
        </form>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Trajets populaires</h2>
    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($trajetsRecents as $trajet)
        <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <p class="text-lg font-semibold">{{ $trajet->villeDepart->nom }}</p>
                    <p class="text-gray-600">{{ $trajet->heure_depart->format('H:i') }}</p>
                </div>
                <div class="text-center">
                    <p class="text-gray-400">→</p>
                </div>
                <div class="text-right">
                    <p class="text-lg font-semibold">{{ $trajet->villeArrivee->nom }}</p>
                    <p class="text-gray-600">{{ $trajet->heure_arrivee->format('H:i') }}</p>
                </div>
            </div>
            <div class="border-t pt-4">
                <p class="text-gray-600">{{ $trajet->bus->compagnie }} - {{ $trajet->bus->nom }}</p>
                <p class="text-2xl font-bold text-indigo-600 mt-2">{{ number_format($trajet->prix, 0, ',', ' ') }} FCFA</p>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection