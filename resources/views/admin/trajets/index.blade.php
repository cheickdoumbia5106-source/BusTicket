@extends('admin.layouts.admin')

@section('title', 'Gestion des trajets')

@section('content')
<div class="card-futur rounded-3xl border border-white/20 bg-gradient-to-br from-white/10 to-white/5 backdrop-blur-lg overflow-hidden">
    <div class="px-6 py-5 border-b border-white/10 flex justify-between items-center">
        <h3 class="font-semibold text-xl text-white flex items-center gap-2"><i class="fas fa-route text-orange-500"></i> Trajets</h3>
        <a href="{{ route('admin.trajets.create') }}" class="btn-primary px-5 py-2.5 rounded-xl text-white font-medium flex items-center gap-2"><i class="fas fa-plus"></i> Nouveau trajet</a>
    </div>
    
    <div class="p-6 overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="border-b border-white/10">
                    <th class="text-left py-3 px-4 text-gray-400">ID</th>
                    <th class="text-left py-3 px-4 text-gray-400">Trajet</th>
                    <th class="text-left py-3 px-4 text-gray-400">Date/Heure</th>
                    <th class="text-left py-3 px-4 text-gray-400">Bus</th>
                    <th class="text-left py-3 px-4 text-gray-400">Prix</th>
                    <th class="text-left py-3 px-4 text-gray-400">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($trajets as $trajet)
                <tr class="border-b border-white/5 hover:bg-white/5 transition">
                    <td class="py-3 px-4 text-white">{{ $trajet->id }}</td>
                    <td class="py-3 px-4 text-white font-medium">{{ $trajet->villeDepart->nom }} → {{ $trajet->villeArrivee->nom }}</td>
                    <td class="py-3 px-4 text-gray-300">{{ $trajet->date_depart->format('d/m/Y') }} à {{ $trajet->heure_depart->format('H:i') }}</td>
                    <td class="py-3 px-4 text-gray-300">{{ $trajet->bus->nom }}</td>
                    <td class="py-3 px-4 text-orange-400 font-bold">{{ number_format($trajet->prix, 0, ',', ' ') }} FCFA</td>
                    <td class="py-3 px-4">
                        <a href="{{ route('admin.trajets.edit', $trajet) }}" class="text-orange-400 hover:text-orange-300 mr-3"><i class="fas fa-edit"></i></a>
                        <form action="{{ route('admin.trajets.destroy', $trajet) }}" method="POST" class="inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-400 hover:text-red-300" onclick="return confirm('Supprimer ?')"><i class="fas fa-trash-alt"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="py-12 text-center text-gray-400">Aucun trajet</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="mt-6">{{ $trajets->links() }}</div>
    </div>
</div>
@endsection