@extends('admin.layouts.admin')

@section('title', 'Gestion des villes')

@section('content')
<div class="card-futur rounded-3xl border border-white/20 bg-gradient-to-br from-white/10 to-white/5 backdrop-blur-lg overflow-hidden">
    <div class="px-6 py-5 border-b border-white/10 flex justify-between items-center">
        <h3 class="font-semibold text-xl text-white flex items-center gap-2"><i class="fas fa-city text-orange-500"></i> Villes</h3>
        <a href="{{ route('admin.villes.create') }}" class="btn-primary px-5 py-2.5 rounded-xl text-white font-medium flex items-center gap-2"><i class="fas fa-plus"></i> Nouvelle ville</a>
    </div>
    
    <div class="p-6">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-white/10">
                        <th class="text-left py-4 px-4 text-gray-400 font-medium">ID</th>
                        <th class="text-left py-4 px-4 text-gray-400 font-medium">Nom</th>
                        <th class="text-left py-4 px-4 text-gray-400 font-medium">Trajets départ</th>
                        <th class="text-left py-4 px-4 text-gray-400 font-medium">Trajets arrivée</th>
                        <th class="text-left py-4 px-4 text-gray-400 font-medium">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($villes as $ville)
                    <tr class="border-b border-white/5 hover:bg-white/5 transition">
                        <td class="py-4 px-4 text-white">{{ $ville->id }}</td>
                        <td class="py-4 px-4 text-white font-medium">{{ $ville->nom }}</td>
                        <td class="py-4 px-4 text-gray-300">{{ $ville->trajetsDepart->count() }}</td>
                        <td class="py-4 px-4 text-gray-300">{{ $ville->trajetsArrivee->count() }}</td>
                        <td class="py-4 px-4">
                            <a href="{{ route('admin.villes.edit', $ville) }}" class="text-orange-400 hover:text-orange-300 mr-4"><i class="fas fa-edit"></i></a>
                            <form action="{{ route('admin.villes.destroy', $ville) }}" method="POST" class="inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-400 hover:text-red-300" onclick="return confirm('Supprimer ?')"><i class="fas fa-trash-alt"></i></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="py-12 text-center text-gray-400">Aucune ville</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-6">{{ $villes->links() }}</div>
    </div>
</div>
@endsection