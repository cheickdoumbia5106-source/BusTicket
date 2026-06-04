@extends('admin.layouts.admin')

@section('title', 'Modifier l\'utilisateur')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="card-futur rounded-3xl p-8">
        <h3 class="text-2xl font-bold text-white mb-8 flex items-center gap-3">
            <i class="fas fa-user-edit text-orange-500"></i> 
            Modifier l'utilisateur
        </h3>
        
        <form action="{{ route('admin.users.update', $user) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="space-y-6">
                <!-- Nom complet -->
                <div>
                    <label class="block text-slate-300 font-medium mb-2">Nom complet</label>
                    <input type="text" name="name" 
                           value="{{ old('name', $user->name) }}" 
                           class="w-full px-5 py-3.5 rounded-2xl bg-slate-800 border border-white/20 text-white placeholder-slate-400 
                                  focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition" 
                           required>
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-slate-300 font-medium mb-2">Adresse email</label>
                    <input type="email" name="email" 
                           value="{{ old('email', $user->email) }}" 
                           class="w-full px-5 py-3.5 rounded-2xl bg-slate-800 border border-white/20 text-white placeholder-slate-400 
                                  focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition" 
                           required>
                </div>

                <!-- Rôle -->
                <div>
                    <label class="block text-slate-300 font-medium mb-2">Rôle</label>
                    <select name="role" required
                            class="w-full px-5 py-3.5 rounded-2xl bg-slate-800 border border-white/20 text-white 
                                   focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition">
                        <option value="user" class="bg-slate-800 text-white" {{ old('role', $user->role) == 'user' ? 'selected' : '' }}>Utilisateur</option>
                        <option value="admin" class="bg-slate-800 text-white" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Administrateur</option>
                    </select>
                </div>
            </div>

            <div class="flex justify-end gap-4 mt-10">
                <a href="{{ route('admin.users.index') }}" 
                   class="px-6 py-3 rounded-2xl bg-white/10 text-slate-300 hover:bg-white/20 transition font-medium">
                    Annuler
                </a>
                <button type="submit" 
                        class="btn-primary px-8 py-3 rounded-2xl text-white font-medium">
                    Mettre à jour l'utilisateur
                </button>
            </div>
        </form>
    </div>
</div>

<style>
    /* Style pour les options des selects au survol */
    select option:hover,
    select option:focus,
    select option:checked {
        background: #f97316 !important;
        color: white !important;
    }
    
    /* Pour Chrome/Safari/Edge */
    select:focus option:checked,
    select:focus option:hover {
        background: #f97316 !important;
        color: white !important;
    }
</style>
@endsection