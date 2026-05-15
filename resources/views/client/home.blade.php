@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<div class="relative bg-gradient-to-br from-orange-50 via-orange-100 to-orange-200 overflow-hidden">
    <div class="absolute inset-0 bg-pattern opacity-10"></div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 lg:py-20">
        <div class="text-center">
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-gray-900 mb-4">
                Réservez vos billets de bus
                <span class="text-orange-600">en moins de 2 minutes</span>
            </h1>
            <p class="text-lg md:text-xl text-gray-600 mb-8 max-w-2xl mx-auto">
                Accédez à <span class="font-semibold text-orange-600">100+ opérateurs</span>, profitez des meilleurs prix, 
                et payez facilement en ligne ou en cash.
            </p>
        </div>

        <!-- Formulaire de recherche -->
        <div class="bg-white rounded-2xl shadow-2xl p-6 md:p-8 max-w-5xl mx-auto">
            <form action="{{ route('search') }}" method="GET">
                <div class="grid md:grid-cols-4 gap-4">
                    <!-- Ville départ -->
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2 text-sm">
                            📍 VILLE DE DÉPART
                        </label>
                        <select name="ville_depart" required 
                                class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 focus:border-orange-500 focus:ring-orange-500">
                            <option value="">Sélectionnez</option>
                            @foreach($villes as $ville)
                                <option value="{{ $ville->id }}">{{ $ville->nom }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <!-- Ville arrivée -->
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2 text-sm">
                            🎯 VILLE D'ARRIVÉE
                        </label>
                        <select name="ville_arrivee" required 
                                class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 focus:border-orange-500 focus:ring-orange-500">
                            <option value="">Sélectionnez</option>
                            @foreach($villes as $ville)
                                <option value="{{ $ville->id }}">{{ $ville->nom }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <!-- Date départ -->
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2 text-sm">
                            📅 DATE DE DÉPART
                        </label>
                        <input type="date" name="date_depart" required min="{{ date('Y-m-d') }}" 
                               class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 focus:border-orange-500 focus:ring-orange-500">
                    </div>
                    
                    <!-- Bouton recherche -->
                    <div class="flex items-end">
                        <button type="submit" 
                                class="w-full bg-gradient-to-r from-orange-500 to-orange-600 text-white font-bold py-3 rounded-xl hover:from-orange-600 hover:to-orange-700 transition shadow-lg">
                            🔍 RECHERCHER
                        </button>
                    </div>
                </div>
            </form>
            
            <!-- Info cookies -->
            <div class="mt-6 text-center">
                <p class="text-xs text-gray-400">
                    En utilisant notre service, vous acceptez notre politique de confidentialité
                </p>
            </div>
        </div>
    </div>
</div>

<!-- Avantages -->
<div class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">
                Pourquoi choisir <span class="text-orange-600">BusTicket</span> ?
            </h2>
            <p class="text-gray-600">Une expérience de réservation simple, rapide et sécurisée</p>
        </div>
        
        <div class="grid md:grid-cols-3 gap-8">
            <div class="text-center p-6">
                <div class="w-16 h-16 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="text-3xl">🚀</span>
                </div>
                <h3 class="font-bold text-xl mb-2">Rapide & Simple</h3>
                <p class="text-gray-600">Réservez votre trajet en moins de 2 minutes</p>
            </div>
            <div class="text-center p-6">
                <div class="w-16 h-16 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="text-3xl">💰</span>
                </div>
                <h3 class="font-bold text-xl mb-2">Meilleurs Prix</h3>
                <p class="text-gray-600">Comparez 100+ opérateurs au Maroc</p>
            </div>
            <div class="text-center p-6">
                <div class="w-16 h-16 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="text-3xl">🔒</span>
                </div>
                <h3 class="font-bold text-xl mb-2">Paiement Sécurisé</h3>
                <p class="text-gray-600">Payez en ligne ou en espèces</p>
            </div>
        </div>
    </div>
</div>

<!-- Trajets populaires -->
<div class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-2xl font-bold text-gray-900">Trajets populaires</h2>
            <a href="#" class="text-orange-600 hover:text-orange-700 font-semibold">Voir tout →</a>
        </div>
        
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($trajetsRecents as $trajet)
            <div class="bg-white rounded-xl shadow-md hover:shadow-xl transition p-5 border border-gray-100">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <div class="flex items-center space-x-2 mb-2">
                            <span class="text-lg">{{ $trajet->villeDepart->nom }}</span>
                            <span class="text-gray-400">→</span>
                            <span class="text-lg font-semibold">{{ $trajet->villeArrivee->nom }}</span>
                        </div>
                        <p class="text-gray-500 text-sm">
                            {{ $trajet->date_depart->format('d/m/Y') }}
                        </p>
                    </div>
                    <div class="bg-orange-100 text-orange-600 px-3 py-1 rounded-full text-sm font-semibold">
                        {{ $trajet->bus->compagnie }}
                    </div>
                </div>
                
                <div class="flex justify-between items-center mb-4">
                    <div>
                        <p class="text-2xl font-bold text-orange-600">
                            {{ number_format($trajet->prix, 0, ',', ' ') }} FCFA
                        </p>
                        <p class="text-sm text-gray-500">par personne</p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm text-gray-500">Départ</p>
                    </div>
                </div>
                
                <a href="{{ route('sieges.show', $trajet->id) }}" 
                   class="block w-full text-center bg-gradient-to-r from-orange-500 to-orange-600 text-white py-2 rounded-lg font-semibold hover:from-orange-600 hover:to-orange-700 transition">
                    Réserver
                </a>
            </div>
            @endforeach
        </div>
    </div>
</div>

<!-- Témoignages -->
<div class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl font-bold text-gray-900 mb-12">
            Ils nous font <span class="text-orange-600">confiance</span>
        </h2>
        <div class="grid md:grid-cols-3 gap-8">
            <div class="bg-gray-50 rounded-xl p-6">
                <div class="text-orange-400 text-2xl mb-2">★★★★★</div>
                <p class="text-gray-600 mb-4">"Service impeccable, réservation très facile !"</p>
                <p class="font-semibold">- Fatima Z.</p>
            </div>
            <div class="bg-gray-50 rounded-xl p-6">
                <div class="text-orange-400 text-2xl mb-2">★★★★★</div>
                <p class="text-gray-600 mb-4">"Paiement simple et ticket reçu immédiatement"</p>
                <p class="font-semibold">- Karim B.</p>
            </div>
            <div class="bg-gray-50 rounded-xl p-6">
                <div class="text-orange-400 text-2xl mb-2">★★★★★</div>
                <p class="text-gray-600 mb-4">"Je recommande, très pratique pour voyager au Maroc"</p>
                <p class="font-semibold">- Sofia M.</p>
            </div>
        </div>
    </div>
</div>
@endsection