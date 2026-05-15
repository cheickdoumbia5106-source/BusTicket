@extends('admin.layouts.admin')

@section('title', 'Modifier un utilisateur')

@section('content')
<div class="bg-white rounded-lg shadow max-w-2xl mx-auto">
    <div class="border-b px-6 py-4">
        <h3 class="font-semibold text-gray-800">✏️ Modifier l'utilisateur</h3>
    </div>
    
    <form action="{{ route('admin.users.update', $user) }}" method="POST" class="p-6">
        @csrf
        @method('PUT')
        
        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-2">Nom complet</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}" 
                   class="w-full border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500" required>
            @error('name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>
        
        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-2">Email</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}" 
                   class="w-full border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500" required>
            @error('email') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>
        
        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-2">Rôle</label>
            <select name="role" class="w-full border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500" required>
                <option value="user" {{ old('role', $user->role) == 'user' ? 'selected' : '' }}>Utilisateur</option>
                <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Administrateur</option>
            </select>
            @error('role') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>
        
        <div class="flex justify-end gap-3">
            <a href="{{ route('admin.users.index') }}" class="bg-gray-300 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-400 transition">
                Annuler
            </a>
            <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition">
                Mettre à jour
            </button>
        </div>
    </form>
</div>
@endsection