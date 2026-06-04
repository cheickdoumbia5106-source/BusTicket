@extends('admin.layouts.admin')

@section('title', 'Détail réservation #'.$reservation->reference)

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="card-futur rounded-3xl border border-white/20 bg-gradient-to-br from-white/10 to-white/5 backdrop-blur-lg overflow-hidden">
        <div class="px-6 py-5 border-b border-white/10">
            <h3 class="font-semibold text-xl text-white flex items-center gap-2"><i class="fas fa-ticket-alt text-orange-500"></i> Réservation #{{ $reservation->reference }}</h3>
        </div>
        
        <div class="p-6 space-y-6">
            <!-- Client -->
            <div class="bg-white/5 rounded-2xl p-5">
                <h4 class="text-white font-semibold mb-3 flex items-center gap-2"><i class="fas fa-user"></i> Client</h4>
                <div class="grid grid-cols-2 gap-4 text-gray-300">
                    <p><span class="text-gray-500">Nom :</span> {{ $reservation->user->name }}</p>
                    <p><span class="text-gray-500">Email :</span> {{ $reservation->user->email }}</p>
                    <p><span class="text-gray-500">Membre depuis :</span> {{ $reservation->user->created_at->format('d/m/Y') }}</p>
                </div>
            </div>
            
            <!-- Trajet -->
            <div class="bg-white/5 rounded-2xl p-5">
                <h4 class="text-white font-semibold mb-3 flex items-center gap-2"><i class="fas fa-route"></i> Trajet</h4>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-gray-300">
                    <p><span class="text-gray-500">Départ :</span> {{ $reservation->trajet->villeDepart->nom }}</p>
                    <p><span class="text-gray-500">Arrivée :</span> {{ $reservation->trajet->villeArrivee->nom }}</p>
                    <p><span class="text-gray-500">Date :</span> {{ $reservation->trajet->date_depart->format('d/m/Y') }}</p>
                    <p><span class="text-gray-500">Heure :</span> {{ $reservation->trajet->heure_depart->format('H:i') }}</p>
                </div>
            </div>
            
            <!-- Sièges -->
            <div class="bg-white/5 rounded-2xl p-5">
                <h4 class="text-white font-semibold mb-3 flex items-center gap-2"><i class="fas fa-chair"></i> Sièges</h4>
                <div class="flex flex-wrap gap-2">
                    @foreach($reservation->sieges as $siege)
                    <span class="px-3 py-1 rounded-full bg-orange-500/20 text-orange-400 text-sm font-medium">Siège {{ $siege->numero_siege }}</span>
                    @endforeach
                </div>
            </div>
            
            <!-- Paiement -->
            <div class="bg-white/5 rounded-2xl p-5">
                <h4 class="text-white font-semibold mb-3 flex items-center gap-2"><i class="fas fa-credit-card"></i> Paiement</h4>
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-gray-300">Montant total</p>
                        <p class="text-3xl font-bold text-orange-400">{{ number_format($reservation->montant_total, 0, ',', ' ') }} FCFA</p>
                    </div>
                    <div>
                        <p class="text-gray-300">Statut paiement</p>
                        <span class="px-3 py-1 rounded-full text-sm {{ $reservation->paiement->statut == 'paye' ? 'bg-emerald-500/20 text-emerald-400' : 'bg-amber-500/20 text-amber-400' }}">{{ $reservation->paiement->statut == 'paye' ? 'Payé' : 'En attente' }}</span>
                    </div>
                </div>
            </div>
            
            <!-- Mise à jour du statut -->
            <div class="bg-white/5 rounded-2xl p-6">
                <h4 class="text-white font-semibold mb-4">Changer le statut</h4>
                <form action="{{ route('admin.reservations.status', $reservation) }}" method="POST" class="flex gap-4 items-end">
                    @csrf @method('PUT')
                    <div class="flex-1">
                        <select name="statut" 
                                class="w-full px-5 py-3.5 rounded-2xl bg-slate-800 border border-white/20 text-white focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition">
                            <option value="en_attente" class="bg-slate-800 text-white" {{ $reservation->statut == 'en_attente' ? 'selected' : '' }}>En attente</option>
                            <option value="confirmee" class="bg-slate-800 text-white" {{ $reservation->statut == 'confirmee' ? 'selected' : '' }}>Confirmée</option>
                            <option value="annulee" class="bg-slate-800 text-white" {{ $reservation->statut == 'annulee' ? 'selected' : '' }}>Annulée</option>
                        </select>
                    </div>
                    <button type="submit" class="btn-primary px-8 py-3.5 rounded-2xl text-white font-medium">
                        Mettre à jour
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    /* Style pour les options des selects au survol */
    select option:hover,
    select option:focus,
    select option:checked {
        background: #f97316 !important;
        color: white !important;
    }
    
    /* Pour Chrome/Safari/Edge */
    select:focus option:checked,
    select:focus option:hover {
        background: #f97316 !important;
        color: white !important;
    }
</style>
@endsection