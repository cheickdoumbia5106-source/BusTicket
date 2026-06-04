@extends('admin.layouts.admin')

@section('title', 'Nouveau trajet')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="card-futur rounded-3xl p-8">
        <h3 class="text-2xl font-bold text-white mb-8 flex items-center gap-3">
            <i class="fas fa-route text-orange-500"></i> 
            Ajouter un nouveau trajet
        </h3>
        
        <form action="{{ route('admin.trajets.store') }}" method="POST">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                <!-- Ville Départ -->
                <div>
                    <label class="block text-slate-300 font-medium mb-2">Ville de départ</label>
                    <select name="ville_depart_id" required 
                            class="w-full px-5 py-3.5 rounded-2xl bg-slate-800 border border-white/20 text-white focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition">
                        <option value="" class="bg-slate-800 text-slate-400">Sélectionner une ville</option>
                        @foreach($villes as $ville)
                            <option value="{{ $ville->id }}" class="bg-slate-800 text-white" 
                                    {{ old('ville_depart_id') == $ville->id ? 'selected' : '' }}>
                                {{ $ville->nom }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Ville Arrivée -->
                <div>
                    <label class="block text-slate-300 font-medium mb-2">Ville d'arrivée</label>
                    <select name="ville_arrivee_id" required 
                            class="w-full px-5 py-3.5 rounded-2xl bg-slate-800 border border-white/20 text-white focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition">
                        <option value="" class="bg-slate-800 text-slate-400">Sélectionner une ville</option>
                        @foreach($villes as $ville)
                            <option value="{{ $ville->id }}" class="bg-slate-800 text-white" 
                                    {{ old('ville_arrivee_id') == $ville->id ? 'selected' : '' }}>
                                {{ $ville->nom }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Bus -->
                <div>
                    <label class="block text-slate-300 font-medium mb-2">Bus</label>
                    <select name="bus_id" required 
                            class="w-full px-5 py-3.5 rounded-2xl bg-slate-800 border border-white/20 text-white focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition">
                        <option value="" class="bg-slate-800 text-slate-400">Sélectionner un bus</option>
                        @foreach($buses as $bus)
                            <option value="{{ $bus->id }}" class="bg-slate-800 text-white" 
                                    {{ old('bus_id') == $bus->id ? 'selected' : '' }}>
                                {{ $bus->nom }} - {{ $bus->compagnie }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Date de départ -->
                <div>
                    <label class="block text-slate-300 font-medium mb-2">Date de départ</label>
                    <input type="date" name="date_depart" 
                           value="{{ old('date_depart') }}" 
                           class="w-full px-5 py-3.5 rounded-2xl bg-slate-800 border border-white/20 text-white focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition" 
                           required>
                </div>

                <!-- Heure de départ -->
                <div>
                    <label class="block text-slate-300 font-medium mb-2">Heure de départ</label>
                    <input type="time" name="heure_depart" 
                           value="{{ old('heure_depart') }}" 
                           class="w-full px-5 py-3.5 rounded-2xl bg-slate-800 border border-white/20 text-white focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition" 
                           required>
                </div>

                <!-- Heure d'arrivée -->
                <div>
                    <label class="block text-slate-300 font-medium mb-2">Heure d'arrivée</label>
                    <input type="time" name="heure_arrivee" 
                           value="{{ old('heure_arrivee') }}" 
                           class="w-full px-5 py-3.5 rounded-2xl bg-slate-800 border border-white/20 text-white focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition" 
                           required>
                </div>

                <!-- Prix -->
                <div class="md:col-span-2">
                    <label class="block text-slate-300 font-medium mb-2">Prix (FCFA)</label>
                    <input type="number" name="prix" 
                           value="{{ old('prix') }}" 
                           class="w-full px-5 py-3.5 rounded-2xl bg-slate-800 border border-white/20 text-white focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition" 
                           min="0" step="500" required>
                </div>

            </div>

            <div class="flex justify-end gap-4 mt-10">
                <a href="{{ route('admin.trajets.index') }}" 
                   class="px-6 py-3 rounded-2xl bg-white/10 text-slate-300 hover:bg-white/20 transition font-medium">
                    Annuler
                </a>
                <button type="submit" class="btn-primary px-8 py-3 rounded-2xl text-white font-medium">
                    Enregistrer le trajet
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
    
    /* Style pour les inputs date et time */
    input[type="date"]::-webkit-calendar-picker-indicator,
    input[type="time"]::-webkit-calendar-picker-indicator {
        filter: invert(1);
        cursor: pointer;
    }
    
    input[type="date"]::-webkit-datetime-edit-text,
    input[type="date"]::-webkit-datetime-edit-month-field,
    input[type="date"]::-webkit-datetime-edit-day-field,
    input[type="date"]::-webkit-datetime-edit-year-field {
        color: white;
    }
</style>
@endsection