@extends('admin.layouts.admin')

@section('title', 'Gestion des réservations')

@section('content')
<div class="bg-white rounded-lg shadow">
    <div class="border-b px-6 py-4">
        <h3 class="font-semibold text-gray-800">🎫 Toutes les réservations</h3>
    </div>
    
    <div class="p-6">
        <!-- Filtres -->
        <form method="GET" class="mb-6 flex flex-wrap gap-4">
            <div>
                <select name="statut" class="border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">Tous les statuts</option>
                    <option value="en_attente" {{ request('statut') == 'en_attente' ? 'selected' : '' }}>En attente</option>
                    <option value="confirmee" {{ request('statut') == 'confirmee' ? 'selected' : '' }}>Confirmée</option>
                    <option value="annulee" {{ request('statut') == 'annulee' ? 'selected' : '' }}>Annulée</option>
                </select>
            </div>
            <div>
                <input type="date" name="date_debut" value="{{ request('date_debut') }}" placeholder="Date début" 
                       class="border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
            </div>
            <div>
                <input type="date" name="date_fin" value="{{ request('date_fin') }}" placeholder="Date fin" 
                       class="border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
            </div>
            <div>
                <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition">
                    Filtrer
                </button>
                <a href="{{ route('admin.reservations.index') }}" class="ml-2 bg-gray-300 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-400 transition">
                    Réinitialiser
                </a>
            </div>
        </form>
        
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="text-left py-3 px-4">Référence</th>
                        <th class="text-left py-3 px-4">Client</th>
                        <th class="text-left py-3 px-4">Trajet</th>
                        <th class="text-left py-3 px-4">Date réservation</th>
                        <th class="text-left py-3 px-4">Montant</th>
                        <th class="text-left py-3 px-4">Statut</th>
                        <th class="text-left py-3 px-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reservations as $reservation)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="py-3 px-4 font-mono text-sm">{{ $reservation->reference }}</td>
                        <td class="py-3 px-4">{{ $reservation->user->name }}</td>
                        <td class="py-3 px-4">
                            {{ $reservation->trajet->villeDepart->nom }} → {{ $reservation->trajet->villeArrivee->nom }}
                        </td>
                        <td class="py-3 px-4">{{ $reservation->created_at->format('d/m/Y H:i') }}</td>
                        <td class="py-3 px-4 font-bold text-indigo-600">{{ number_format($reservation->montant_total, 0, ',', ' ') }} FCFA</td>
                        <td class="py-3 px-4">
                            @if($reservation->statut == 'confirmee')
                                <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-sm">Confirmée</span>
                            @elseif($reservation->statut == 'annulee')
                                <span class="bg-red-100 text-red-800 px-2 py-1 rounded text-sm">Annulée</span>
                            @else
                                <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded text-sm">En attente</span>
                            @endif
                        </td>
                        <td class="py-3 px-4">
                            <a href="{{ route('admin.reservations.show', $reservation) }}" class="text-indigo-600 hover:text-indigo-800 mr-3">
                                Voir
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <div class="mt-4">
            {{ $reservations->links() }}
        </div>
    </div>
</div>
@endsection