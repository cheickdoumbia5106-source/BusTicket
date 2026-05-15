@extends('admin.layouts.admin')

@section('title', 'Détail de la réservation')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow">
        <div class="border-b px-6 py-4">
            <h3 class="font-semibold text-gray-800">🎫 Réservation #{{ $reservation->reference }}</h3>
        </div>
        
        <div class="p-6">
            <!-- Informations client -->
            <div class="mb-6">
                <h4 class="font-semibold text-gray-700 mb-3">👤 Client</h4>
                <div class="bg-gray-50 rounded-lg p-4">
                    <p><strong>Nom :</strong> {{ $reservation->user->name }}</p>
                    <p><strong>Email :</strong> {{ $reservation->user->email }}</p>
                    <p><strong>Membre depuis :</strong> {{ $reservation->user->created_at->format('d/m/Y') }}</p>
                </div>
            </div>
            
            <!-- Informations trajet -->
            <div class="mb-6">
                <h4 class="font-semibold text-gray-700 mb-3">🚌 Trajet</h4>
                <div class="bg-gray-50 rounded-lg p-4">
                    <p><strong>Itinéraire :</strong> {{ $reservation->trajet->villeDepart->nom }} → {{ $reservation->trajet->villeArrivee->nom }}</p>
                    <p><strong>Date :</strong> {{ $reservation->trajet->date_depart->format('d/m/Y') }}</p>
                    <p><strong>Heure départ :</strong> {{ $reservation->trajet->heure_depart->format('H:i') }}</p>
                    <p><strong>Heure arrivée :</strong> {{ $reservation->trajet->heure_arrivee->format('H:i') }}</p>
                    <p><strong>Bus :</strong> {{ $reservation->trajet->bus->nom }} ({{ $reservation->trajet->bus->compagnie }})</p>
                </div>
            </div>
            
            <!-- Sièges -->
            <div class="mb-6">
                <h4 class="font-semibold text-gray-700 mb-3">💺 Sièges réservés</h4>
                <div class="bg-gray-50 rounded-lg p-4">
                    <div class="flex flex-wrap gap-2">
                        @foreach($reservation->sieges as $siege)
                            <span class="bg-indigo-100 text-indigo-700 px-3 py-1 rounded-full text-sm font-semibold">
                                Siège {{ $siege->numero_siege }}
                            </span>
                        @endforeach
                    </div>
                </div>
            </div>
            
            <!-- Paiement -->
            <div class="mb-6">
                <h4 class="font-semibold text-gray-700 mb-3">💰 Paiement</h4>
                <div class="bg-gray-50 rounded-lg p-4">
                    <p><strong>Montant total :</strong> <span class="text-2xl font-bold text-indigo-600">{{ number_format($reservation->montant_total, 0, ',', ' ') }} FCFA</span></p>
                    <p><strong>Mode de paiement :</strong> {{ $reservation->paiement->mode_paiement == 'simule' ? 'Paiement en ligne' : 'Paiement à l\'embarquement' }}</p>
                    <p><strong>Statut paiement :</strong> 
                        @if($reservation->paiement->statut == 'paye')
                            <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-sm">Payé</span>
                        @else
                            <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded text-sm">En attente</span>
                        @endif
                    </p>
                </div>
            </div>
            
            <!-- Changement de statut -->
            <div class="mb-6">
                <h4 class="font-semibold text-gray-700 mb-3">📝 Modifier le statut</h4>
                <form action="{{ route('admin.reservations.status', $reservation) }}" method="POST" class="flex gap-3">
                    @csrf
                    @method('PUT')
                    <select name="statut" class="border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="en_attente" {{ $reservation->statut == 'en_attente' ? 'selected' : '' }}>En attente</option>
                        <option value="confirmee" {{ $reservation->statut == 'confirmee' ? 'selected' : '' }}>Confirmée</option>
                        <option value="annulee" {{ $reservation->statut == 'annulee' ? 'selected' : '' }}>Annulée</option>
                    </select>
                    <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition">
                        Mettre à jour
                    </button>
                </form>
            </div>
            
            <div class="flex justify-end gap-3">
                <a href="{{ route('admin.reservations.index') }}" class="bg-gray-300 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-400 transition">
                    Retour
                </a>
                <form action="{{ route('admin.reservations.destroy', $reservation) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition" 
                            onclick="return confirm('Supprimer cette réservation ?')">
                        Supprimer
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection