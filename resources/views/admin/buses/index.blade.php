@extends('admin.layouts.admin')

@section('title', 'Gestion des bus')

@section('content')
<div class="card-futur rounded-3xl border border-white/20 bg-gradient-to-br from-white/10 to-white/5 backdrop-blur-lg overflow-hidden">
    <div class="px-6 py-5 border-b border-white/10 flex justify-between items-center">
        <h3 class="font-semibold text-xl text-white flex items-center gap-2"><i class="fas fa-bus text-orange-500"></i> Parc automobile</h3>
        <a href="{{ route('admin.buses.create') }}" class="btn-primary px-5 py-2.5 rounded-xl text-white font-medium flex items-center gap-2"><i class="fas fa-plus"></i> Nouveau bus</a>
    </div>
    
    <div class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($buses as $bus)
            <div class="bg-white/5 rounded-2xl p-5 border border-white/10 hover:border-orange-500/50 transition-all group">
                <div class="flex items-start justify-between mb-4">
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-orange-500 to-orange-700 flex items-center justify-center text-2xl">🚌</div>
                    <span class="text-xs px-3 py-1 rounded-full bg-emerald-500/20 text-emerald-400">{{ $bus->nombre_places }} places</span>
                </div>
                <h4 class="text-white font-bold text-lg">{{ $bus->nom }}</h4>
                <p class="text-gray-400 text-sm mb-4">{{ $bus->compagnie }}</p>
                <div class="flex gap-3 pt-3 border-t border-white/10">
                    <a href="{{ route('admin.buses.edit', $bus) }}" class="flex-1 text-center py-2 rounded-xl bg-orange-500/20 text-orange-400 hover:bg-orange-500/30 transition">Modifier</a>
                    <form action="{{ route('admin.buses.destroy', $bus) }}" method="POST" class="flex-1">
                        @csrf @method('DELETE')
                        <button type="submit" class="w-full py-2 rounded-xl bg-red-500/20 text-red-400 hover:bg-red-500/30 transition" onclick="return confirm('Supprimer ?')">Supprimer</button>
                    </form>
                </div>
            </div>
            @empty
            <div class="col-span-3 text-center py-12 text-gray-400">Aucun bus enregistré</div>
            @endforelse
        </div>
        <div class="mt-6">{{ $buses->links() }}</div>
    </div>
</div>
@endsection