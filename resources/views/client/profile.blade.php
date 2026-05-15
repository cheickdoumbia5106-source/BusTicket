@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex flex-wrap -mx-4">
        <!-- Sidebar -->
        <div class="w-full md:w-1/4 px-4 mb-6 md:mb-0">
            <div class="bg-white rounded-xl shadow-lg p-6">
                <div class="text-center mb-6">
                    <div class="w-24 h-24 bg-indigo-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-4xl text-indigo-600">{{ substr($user->name, 0, 1) }}</span>
                    </div>
                    <h3 class="font-semibold text-lg">{{ $user->name }}</h3>
                    <p class="text-gray-600 text-sm">{{ $user->email }}</p>
                    @if($user->role === 'admin')
                        <span class="inline-block mt-2 bg-red-100 text-red-700 text-xs px-2 py-1 rounded">Administrateur</span>
                    @endif
                </div>
                
                <div class="border-t pt-4">
                    <nav class="space-y-2">
                        <button onclick="showTab('profile')" id="tab-profile-btn" 
                                class="w-full text-left px-4 py-2 rounded-lg bg-indigo-50 text-indigo-600 font-semibold">
                            👤 Mon profil
                        </button>
                        <button onclick="showTab('reservations')" id="tab-reservations-btn" 
                                class="w-full text-left px-4 py-2 rounded-lg hover:bg-gray-50 text-gray-700">
                            🎫 Mes réservations
                        </button>
                    </nav>
                </div>
            </div>
        </div>

        <!-- Contenu principal -->
        <div class="w-full md:w-3/4 px-4">
            <!-- Tab Profil -->
            <div id="tab-profile" class="tab-content">
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-6">Informations personnelles</h2>
                    
                    <form action="{{ route('profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-4">
                            <label class="block text-gray-700 font-medium mb-2">Nom complet</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" 
                                   class="w-full border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                            @error('name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>
                        
                        <div class="mb-4">
                            <label class="block text-gray-700 font-medium mb-2">Email</label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}" 
                                   class="w-full border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                            @error('email') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>
                        
                        <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700 transition">
                            Mettre à jour
                        </button>
                    </form>

                    <div class="border-t mt-8 pt-8">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Changer le mot de passe</h3>
                        
                        <form action="{{ route('profile.password') }}" method="POST">
                            @csrf
                            @method('PUT')
                            
                            <div class="mb-4">
                                <label class="block text-gray-700 font-medium mb-2">Mot de passe actuel</label>
                                <input type="password" name="current_password" 
                                       class="w-full border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                                @error('current_password') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                            </div>
                            
                            <div class="mb-4">
                                <label class="block text-gray-700 font-medium mb-2">Nouveau mot de passe</label>
                                <input type="password" name="password" 
                                       class="w-full border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                                @error('password') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                            </div>
                            
                            <div class="mb-4">
                                <label class="block text-gray-700 font-medium mb-2">Confirmer le mot de passe</label>
                                <input type="password" name="password_confirmation" 
                                       class="w-full border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                            </div>
                            
                            <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700 transition">
                                Changer le mot de passe
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Tab Réservations -->
            <div id="tab-reservations" class="tab-content hidden">
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-6">Mes réservations</h2>
                    
                    @if($reservations->count() > 0)
                        <div class="space-y-4">
                            @foreach($reservations as $reservation)
                                <div class="border rounded-lg p-4 hover:shadow-md transition">
                                    <div class="flex flex-wrap justify-between items-start">
                                        <div>
                                            <p class="text-sm text-gray-500">Réf : {{ $reservation->reference }}</p>
                                            <p class="font-semibold mt-1">
                                                {{ $reservation->trajet->villeDepart->nom }} → {{ $reservation->trajet->villeArrivee->nom }}
                                            </p>
                                            <p class="text-sm text-gray-600">
                                                {{ \Carbon\Carbon::parse($reservation->trajet->date_depart)->format('d/m/Y') }} à {{ $reservation->trajet->heure_depart->format('H:i') }}
                                            </p>
                                            <p class="text-sm text-gray-600">
                                                Sièges : {{ $reservation->sieges->pluck('numero_siege')->implode(', ') }}
                                            </p>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-lg font-bold text-indigo-600">{{ number_format($reservation->montant_total, 0, ',', ' ') }} FCFA</p>
                                            <p class="text-sm">
                                                @if($reservation->statut === 'confirmee')
                                                    <span class="text-green-600">✓ Confirmée</span>
                                                @elseif($reservation->statut === 'annulee')
                                                    <span class="text-red-600">✗ Annulée</span>
                                                @else
                                                    <span class="text-yellow-600">⏳ En attente</span>
                                                @endif
                                            </p>
                                            <div class="mt-2 flex gap-2">
                                                <a href="{{ route('ticket.show', $reservation) }}" 
                                                   class="text-indigo-600 hover:text-indigo-700 text-sm">
                                                    Voir ticket
                                                </a>
                                                @if($reservation->statut === 'confirmee' && $reservation->trajet->date_depart > now()->addHours(24))
                                                    <form action="{{ route('reservation.cancel', $reservation) }}" method="POST" 
                                                          onsubmit="return confirm('Annuler cette réservation ?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-600 hover:text-red-700 text-sm">
                                                            Annuler
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <p class="text-gray-500">Aucune réservation pour le moment.</p>
                            <a href="{{ route('home') }}" class="mt-4 inline-block text-indigo-600 hover:text-indigo-700">
                                Réserver un trajet →
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function showTab(tabName) {
        // Cacher tous les tabs
        document.querySelectorAll('.tab-content').forEach(tab => {
            tab.classList.add('hidden');
        });
        
        // Enlever les styles actifs des boutons
        document.getElementById('tab-profile-btn').classList.remove('bg-indigo-50', 'text-indigo-600', 'font-semibold');
        document.getElementById('tab-profile-btn').classList.add('text-gray-700');
        document.getElementById('tab-reservations-btn').classList.remove('bg-indigo-50', 'text-indigo-600', 'font-semibold');
        document.getElementById('tab-reservations-btn').classList.add('text-gray-700');
        
        // Afficher le tab sélectionné
        document.getElementById(`tab-${tabName}`).classList.remove('hidden');
        
        // Activer le bouton correspondant
        document.getElementById(`tab-${tabName}-btn`).classList.add('bg-indigo-50', 'text-indigo-600', 'font-semibold');
        document.getElementById(`tab-${tabName}-btn`).classList.remove('text-gray-700');
    }
</script>
@endsection