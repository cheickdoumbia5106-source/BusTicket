@extends('admin.layouts.admin')

@section('title', isset($bus) ? 'Modifier le bus' : 'Nouveau bus')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="card-futur rounded-3xl p-8">
        <h3 class="text-2xl font-bold text-white mb-8 flex items-center gap-3">
            <i class="fas fa-bus text-orange-500"></i> 
            {{ isset($bus) ? 'Modifier le bus' : 'Ajouter un bus' }}
        </h3>
        
        <form action="{{ isset($bus) ? route('admin.buses.update', $bus) : route('admin.buses.store') }}" method="POST">
            @csrf
            @if(isset($bus)) @method('PUT') @endif
            
            <div class="space-y-6">
                <div>
                    <label class="block text-slate-300 font-medium mb-2">Nom du bus</label>
                    <input type="text" name="nom" value="{{ old('nom', $bus->nom ?? '') }}" 
                           class="w-full px-5 py-3.5 rounded-2xl bg-white/10 border border-white/20 text-white placeholder-slate-400 focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition" 
                           placeholder="Ex: Mercedes Sprinter" required>
                </div>

                <div>
                    <label class="block text-slate-300 font-medium mb-2">Compagnie</label>
                    <input type="text" name="compagnie" value="{{ old('compagnie', $bus->compagnie ?? '') }}" 
                           class="w-full px-5 py-3.5 rounded-2xl bg-white/10 border border-white/20 text-white placeholder-slate-400 focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition" 
                           placeholder="Ex: Bani Transport" required>
                </div>

                <div>
                    <label class="block text-slate-300 font-medium mb-2">Nombre de places</label>
                    <input type="number" name="nombre_places" value="{{ old('nombre_places', $bus->nombre_places ?? 50) }}" 
                           class="w-full px-5 py-3.5 rounded-2xl bg-white/10 border border-white/20 text-white focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition" 
                           min="10" max="100" required>
                    <p class="text-slate-400 text-sm mt-2">Les sièges seront générés automatiquement</p>
                </div>
            </div>

            <div class="flex justify-end gap-4 mt-10">
                <a href="{{ route('admin.buses.index') }}" 
                   class="px-6 py-3 rounded-2xl bg-white/10 text-slate-300 hover:bg-white/20 transition">
                    Annuler
                </a>
                <button type="submit" class="btn-primary px-8 py-3 rounded-2xl text-white font-medium">
                    {{ isset($bus) ? 'Mettre à jour' : 'Enregistrer le bus' }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection