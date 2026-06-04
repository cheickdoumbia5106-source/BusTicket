@extends('admin.layouts.admin')

@section('title', 'Gestion des réservations')

@section('content')
<div class="card-futur rounded-3xl border border-white/20 bg-gradient-to-br from-white/10 to-white/5 backdrop-blur-lg overflow-hidden">
    <div class="px-6 py-5 border-b border-white/10">
        <h3 class="font-semibold text-xl text-white flex items-center gap-2"><i class="fas fa-ticket-alt text-orange-500"></i> Réservations</h3>
    </div>
    
    <div class="p-6">
        <!-- Filtres -->
        <form method="GET" class="mb-6 flex flex-wrap gap-4">
            <select name="statut" class="px-4 py-2 rounded-xl bg-white/10 border border-white/20 text-white focus:outline-none focus:border-orange-500">
                <option value="">Tous statuts</option>
                <option value="en_attente" {{ request('statut') == 'en_attente' ? 'selected' : '' }}>En attente</option>
                <option value="confirmee" {{ request('statut') == 'confirmee' ? 'selected' : '' }}>Confirmée</option>
                <option value="annulee" {{ request('statut') == 'annulee' ? 'selected' : '' }}>Annulée</option>
            </select>
            <input type="date" name="date_debut" value="{{ request('date_debut') }}" class="px-4 py-2 rounded-xl bg-white/10 border border-white/20 text-white">
            <input type="date" name="date_fin" value="{{ request('date_fin') }}" class="px-4 py-2 rounded-xl bg-white/10 border border-white/20 text-white">
            <button type="submit" class="btn-primary px-5 py-2 rounded-xl text-white"><i class="fas fa-filter"></i> Filtrer</button>
            <a href="{{ route('admin.reservations.index') }}" class="px-5 py-2 rounded-xl bg-white/10 text-gray-300 hover:bg-white/20">Réinitialiser</a>
        </form>
        
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-white/10">
                        <th class="text-left py-3 px-4 text-gray-400">Réf</th>
                        <th class="text-left py-3 px-4 text-gray-400">Client</th>
                        <th class="text-left py-3 px-4 text-gray-400">Trajet</th>
                        <th class="text-left py-3 px-4 text-gray-400">Date</th>
                        <th class="text-left py-3 px-4 text-gray-400">Montant</th>
                        <th class="text-left py-3 px-4 text-gray-400">Statut</th>
                        <th class="text-left py-3 px-4 text-gray-400">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reservations as $res)
                    <tr class="border-b border-white/5 hover:bg-white/5 transition">
                        <td class="py-3 px-4 text-white font-mono text-sm">{{ $res->reference }}</td>
                        <td class="py-3 px-4 text-white">{{ $res->user->name }}</td>
                        <td class="py-3 px-4 text-gray-300">{{ $res->trajet->villeDepart->nom }} → {{ $res->trajet->villeArrivee->nom }}</td>
                        <td class="py-3 px-4 text-gray-300">{{ $res->created_at->format('d/m/Y H:i') }}</td>
                        <td class="py-3 px-4 text-orange-400 font-bold">{{ number_format($res->montant_total, 0, ',', ' ') }} FCFA</td>
                        <td class="py-3 px-4">
                            <span class="px-2 py-1 rounded-full text-xs {{ $res->statut == 'confirmee' ? 'bg-emerald-500/20 text-emerald-400' : ($res->statut == 'annulee' ? 'bg-red-500/20 text-red-400' : 'bg-amber-500/20 text-amber-400') }}">{{ ucfirst($res->statut) }}</span>
                        </td>
                        <td class="py-3 px-4">
                            <a href="{{ route('admin.reservations.show', $res) }}" class="text-orange-400 hover:text-orange-300"><i class="fas fa-eye"></i></a>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="py-12 text-center text-gray-400">Aucune réservation</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-6">{{ $reservations->links() }}</div>
    </div>
</div>
@endsection