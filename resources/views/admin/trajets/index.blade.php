@extends('admin.layouts.admin')

@section('title', 'Gestion des trajets')

@section('content')
<div class="bg-white rounded-lg shadow">
    <div class="border-b px-6 py-4 flex justify-between items-center">
        <h3 class="font-semibold text-gray-800">🗺️ Liste des trajets</h3>
        <a href="{{ route('admin.trajets.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition">
            + Ajouter un trajet
        </a>
    </div>
    
    <div class="p-6">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="text-left py-3 px-4">ID</th>
                        <th class="text-left py-3 px-4">Trajet</th>
                        <th class="text-left py-3 px-4">Date</th>
                        <th class="text-left py-3 px-4">Heure départ</th>
                        <th class="text-left py-3 px-4">Bus</th>
                        <th class="text-left py-3 px-4">Prix</th>
                        <th class="text-left py-3 px-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($trajets as $trajet)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="py-3 px-4">{{ $trajet->id }}</td>
                        <td class="py-3 px-4 font-medium">
                            {{ $trajet->villeDepart->nom }} → {{ $trajet->villeArrivee->nom }}
                        </td>
                        <td class="py-3 px-4">{{ $trajet->date_depart->format('d/m/Y') }}</td>
                        <td class="py-3 px-4">{{ $trajet->heure_depart->format('H:i') }}</td>
                        <td class="py-3 px-4">{{ $trajet->bus->nom }}</td>
                        <td class="py-3 px-4 font-bold text-indigo-600">{{ number_format($trajet->prix, 0, ',', ' ') }} FCFA</td>
                        <td class="py-3 px-4">
                            <a href="{{ route('admin.trajets.edit', $trajet) }}" class="text-indigo-600 hover:text-indigo-800 mr-3">Modifier</a>
                            <form action="{{ route('admin.trajets.destroy', $trajet) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800" onclick="return confirm('Supprimer ce trajet ?')">
                                    Supprimer
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <div class="mt-4">
            {{ $trajets->links() }}
        </div>
    </div>
</div>
@endsection