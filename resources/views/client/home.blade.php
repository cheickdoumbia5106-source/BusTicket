@extends('layouts.app')

@section('title', 'BusTicket - Réservez vos billets de bus')

@section('content')
<!-- Hero Section -->
<section class="hero-bg min-h-screen flex items-center relative overflow-hidden">
    <div class="absolute inset-0 bg-[radial-gradient(circle_at_center,rgba(255,255,255,0.2)_0%,transparent_70%)]"></div>
    
    <div class="max-w-7xl mx-auto px-6 pt-20 pb-16 relative z-10">
        <div class="text-center max-w-4xl mx-auto">
            <div class="inline-flex items-center gap-2 bg-white/20 backdrop-blur-md text-white text-sm font-medium px-5 py-2 rounded-full mb-6">
                <span class="relative flex h-3 w-3">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-3 w-3 bg-emerald-500"></span>
                </span>
                100+ compagnies au Mali
            </div>
            
            <h1 class="text-6xl md:text-7xl font-bold text-white leading-tight mb-6 neon-glow">
                Réservez votre billet<br>en <span class="text-orange-200">moins de 2 minutes</span>
            </h1>
            
            <p class="text-xl text-orange-100 max-w-2xl mx-auto mb-10">
                Accédez aux meilleurs prix, choisissez vos sièges et payez en ligne ou en espèces.
            </p>
        </div>

        <!-- Formulaire de recherche -->
        <div class="max-w-5xl mx-auto glass rounded-3xl shadow-2xl p-8 md:p-10 border border-white/30">
            <form action="{{ route('search') }}" method="GET" class="grid md:grid-cols-4 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center gap-2">
                        <i class="fas fa-map-marker-alt"></i> VILLE DE DÉPART
                    </label>
                    <select name="ville_depart" required 
                            class="w-full px-6 py-4 rounded-2xl border-0 bg-white focus:ring-4 focus:ring-orange-500/30 text-lg">
                        <option value="">Sélectionnez...</option>
                        @foreach($villes as $ville)
                            <option value="{{ $ville->id }}">{{ $ville->nom }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center gap-2">
                        <i class="fas fa-map-marker-alt"></i> VILLE D'ARRIVÉE
                    </label>
                    <select name="ville_arrivee" required 
                            class="w-full px-6 py-4 rounded-2xl border-0 bg-white focus:ring-4 focus:ring-orange-500/30 text-lg">
                        <option value="">Sélectionnez...</option>
                        @foreach($villes as $ville)
                            <option value="{{ $ville->id }}">{{ $ville->nom }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center gap-2">
                        <i class="fas fa-calendar"></i> DATE DE DÉPART
                    </label>
                    <input type="date" name="date_depart" required min="{{ date('Y-m-d') }}" 
                           class="w-full px-6 py-4 rounded-2xl border-0 bg-white focus:ring-4 focus:ring-orange-500/30 text-lg">
                </div>

                <div class="flex items-end">
                    <button type="submit"
                            class="w-full bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white font-bold py-4 rounded-2xl text-lg shadow-xl flex items-center justify-center gap-3 transition-all hover:scale-105">
                        <i class="fas fa-search"></i>
                        RECHERCHER
                    </button>
                </div>
            </form>
        </div>
    </div>

</section>

<!-- Avantages -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-6">
        <div class="grid md:grid-cols-3 gap-10">
            <div class="text-center card-hover bg-white p-8 rounded-3xl border">
                <div class="w-20 h-20 mx-auto bg-orange-100 rounded-2xl flex items-center justify-center text-4xl mb-6">⚡</div>
                <h3 class="text-2xl font-bold mb-3">Ultra Rapide</h3>
                <p class="text-gray-600">Réservation en moins de 2 minutes avec confirmation immédiate.</p>
            </div>
            <div class="text-center card-hover bg-white p-8 rounded-3xl border">
                <div class="w-20 h-20 mx-auto bg-orange-100 rounded-2xl flex items-center justify-center text-4xl mb-6">💰</div>
                <h3 class="text-2xl font-bold mb-3">Meilleurs Prix</h3>
                <p class="text-gray-600">Comparez 100+ opérateurs et trouvez les tarifs les plus bas.</p>
            </div>
            <div class="text-center card-hover bg-white p-8 rounded-3xl border">
                <div class="w-20 h-20 mx-auto bg-orange-100 rounded-2xl flex items-center justify-center text-4xl mb-6">🔒</div>
                <h3 class="text-2xl font-bold mb-3">Sécurisé</h3>
                <p class="text-gray-600">Paiement en ligne ou en espèces • Sièges garantis.</p>
            </div>
        </div>
    </div>
</section>

<!-- Trajets Populaires -->
<section class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-6">
        <div class="flex justify-between items-end mb-10">
            <h2 class="text-4xl font-bold">Trajets Populaires</h2>
            <a href="#" class="text-orange-600 hover:text-orange-700 font-semibold flex items-center gap-2">
                Voir tous les trajets <i class="fas fa-arrow-right"></i>
            </a>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($trajetsRecents as $trajet)
            <div class="bg-white rounded-3xl overflow-hidden card-hover border border-gray-100">
                <div class="p-8">
                    <div class="flex justify-between items-start mb-6">
                        <div>
                            <p class="text-3xl font-bold">{{ $trajet->villeDepart->nom }}</p>
                            <p class="text-gray-500">{{ $trajet->heure_depart->format('H:i') }}</p>
                        </div>
                        <div class="text-4xl text-orange-500 pt-3">→</div>
                        <div class="text-right">
                            <p class="text-3xl font-bold">{{ $trajet->villeArrivee->nom }}</p>
                            <p class="text-gray-500">{{ $trajet->heure_arrivee->format('H:i') }}</p>
                        </div>
                    </div>

                    <div class="flex justify-between items-center pt-6 border-t">
                        <div>
                            <span class="inline-block bg-orange-100 text-orange-700 px-4 py-1 rounded-full text-sm font-semibold">
                                {{ $trajet->bus->compagnie }}
                            </span>
                        </div>
                        <div class="text-right">
                            <p class="text-4xl font-bold text-orange-600">{{ number_format($trajet->prix, 0, ',', ' ') }} <span class="text-lg">FCFA</span></p>
                        </div>
                    </div>
                </div>
                <a href="{{ route('sieges.show', $trajet->id) }}" 
                   class="block bg-gradient-to-r from-orange-500 to-orange-600 text-white text-center py-5 font-bold text-lg hover:from-orange-600 hover:to-orange-700 transition">
                    Choisir ce trajet →
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endsection