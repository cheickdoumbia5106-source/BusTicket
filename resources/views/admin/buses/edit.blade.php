@extends('admin.layouts.admin')

@section('title', 'Modifier un bus')

@section('content')
<div class="bg-white rounded-lg shadow max-w-2xl mx-auto">
    <div class="border-b px-6 py-4">
        <h3 class="font-semibold text-gray-800">✏️ Modifier le bus</h3>
    </div>
    
    <form action="{{ route('admin.buses.update', $bus) }}" method="POST" class="p-6">
        @csrf
        @method('PUT')
        
        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-2">Nom du bus</label>
            <input type="text" name="nom" value="{{ old('nom', $bus->nom) }}" 
                   class="w-full border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500" required>
            @error('nom') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>
        
        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-2">Compagnie</label>
            <input type="text" name="compagnie" value="{{ old('compagnie', $bus->compagnie) }}" 
                   class="w-full border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500" required>
            @error('compagnie') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>
        
        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-2">Nombre de places</label>
            <input type="number" name="nombre_places" value="{{ old('nombre_places', $bus->nombre_places) }}" 
                   class="w-full border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500" 
                   min="1" max="100" required>
            <p class="text-yellow-600 text-sm mt-1">⚠️ Si vous modifiez le nombre de places, les sièges seront régénérés</p>
            @error('nombre_places') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>
        
        <div class="flex justify-end gap-3">
            <a href="{{ route('admin.buses.index') }}" class="bg-gray-300 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-400 transition">
                Annuler
            </a>
            <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition">
                Mettre à jour
            </button>
        </div>
    </form>
</div>
@endsection