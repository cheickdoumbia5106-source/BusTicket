@extends('admin.layouts.admin')

@section('title', 'Ajouter un trajet')

@section('content')
<div class="bg-white rounded-lg shadow max-w-3xl mx-auto">
    <div class="border-b px-6 py-4">
        <h3 class="font-semibold text-gray-800">➕ Nouveau trajet</h3>
    </div>
    
    <form action="{{ route('admin.trajets.store') }}" method="POST" class="p-6">
        @csrf
        
        <div class="grid grid-cols-2 gap-4">
            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-2">Ville de départ</label>
                <select name="ville_depart_id" class="w-full border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500" required>
                    <option value="">Sélectionnez</option>
                    @foreach($villes as $ville)
                        <option value="{{ $ville->id }}" {{ old('ville_depart_id') == $ville->id ? 'selected' : '' }}>
                            {{ $ville->nom }}
                        </option>
                    @endforeach
                </select>
                @error('ville_depart_id') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>
            
            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-2">Ville d'arrivée</label>
                <select name="ville_arrivee_id" class="w-full border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500" required>
                    <option value="">Sélectionnez</option>
                    @foreach($villes as $ville)
                        <option value="{{ $ville->id }}" {{ old('ville_arrivee_id') == $ville->id ? 'selected' : '' }}>
                            {{ $ville->nom }}
                        </option>
                    @endforeach
                </select>
                @error('ville_arrivee_id') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>
        </div>
        
        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-2">Bus</label>
            <select name="bus_id" class="w-full border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500" required>
                <option value="">Sélectionnez</option>
                @foreach($buses as $bus)
                    <option value="{{ $bus->id }}" {{ old('bus_id') == $bus->id ? 'selected' : '' }}>
                        {{ $bus->nom }} - {{ $bus->compagnie }} ({{ $bus->nombre_places }} places)
                    </option>
                @endforeach
            </select>
            @error('bus_id') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>
        
        <div class="grid grid-cols-2 gap-4">
            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-2">Date de départ</label>
                <input type="date" name="date_depart" value="{{ old('date_depart') }}" 
                       class="w-full border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500" required>
                @error('date_depart') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>
            
            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-2">Heure de départ</label>
                <input type="time" name="heure_depart" value="{{ old('heure_depart') }}" 
                       class="w-full border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500" required>
                @error('heure_depart') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>
        </div>
        
        <div class="grid grid-cols-2 gap-4">
            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-2">Heure d'arrivée</label>
                <input type="time" name="heure_arrivee" value="{{ old('heure_arrivee') }}" 
                       class="w-full border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500" required>
                @error('heure_arrivee') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>
            
            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-2">Prix (FCFA)</label>
                <input type="number" name="prix" value="{{ old('prix') }}" 
                       class="w-full border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500" 
                       min="0" step="100" required>
                @error('prix') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>
        </div>
        
        <div class="flex justify-end gap-3 mt-4">
            <a href="{{ route('admin.trajets.index') }}" class="bg-gray-300 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-400 transition">
                Annuler
            </a>
            <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition">
                Enregistrer
            </button>
        </div>
    </form>
</div>
@endsection