@extends('admin.layouts.admin')

@section('title', isset($ville) ? 'Modifier la ville' : 'Nouvelle ville')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="card-futur rounded-3xl border border-white/20 bg-gradient-to-br from-white/10 to-white/5 backdrop-blur-lg p-8">
        <h3 class="text-2xl font-bold text-white mb-6 flex items-center gap-3"><i class="fas fa-city text-orange-500"></i> {{ isset($ville) ? '✏️ Modifier' : '➕ Ajouter' }} une ville</h3>
        
        <form action="{{ isset($ville) ? route('admin.villes.update', $ville) : route('admin.villes.store') }}" method="POST">
            @csrf
            @if(isset($ville)) @method('PUT') @endif
            
            <div class="mb-6">
                <label class="block text-gray-300 font-medium mb-2">Nom de la ville</label>
                <input type="text" name="nom" value="{{ old('nom', $ville->nom ?? '') }}" class="w-full px-5 py-3 rounded-xl bg-white/10 border border-white/20 text-white placeholder-gray-400 focus:outline-none focus:border-orange-500 transition" placeholder="Ex: Bamako" required>
                @error('nom') <p class="text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
            </div>
            
            <div class="flex justify-end gap-4">
                <a href="{{ route('admin.villes.index') }}" class="px-6 py-3 rounded-xl bg-white/10 text-gray-300 hover:bg-white/20 transition">Annuler</a>
                <button type="submit" class="btn-primary px-6 py-3 rounded-xl text-white font-medium">{{ isset($ville) ? 'Mettre à jour' : 'Enregistrer' }}</button>
            </div>
        </form>
    </div>
</div>
@endsection