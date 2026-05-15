@extends('admin.layouts.admin')

@section('title', 'Gestion des bus')

@section('content')
<div class="bg-white rounded-lg shadow">
    <div class="border-b px-6 py-4 flex justify-between items-center">
        <h3 class="font-semibold text-gray-800">🚌 Liste des bus</h3>
        <a href="{{ route('admin.buses.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition">
            + Ajouter un bus
        </a>
    </div>
    
    <div class="p-6">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="text-left py-3 px-4">ID</th>
                        <th class="text-left py-3 px-4">Nom du bus</th>
                        <th class="text-left py-3 px-4">Compagnie</th>
                        <th class="text-left py-3 px-4">Nombre de places</th>
                        <th class="text-left py-3 px-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($buses as $bus)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="py-3 px-4">{{ $bus->id }}</td>
                        <td class="py-3 px-4 font-medium">{{ $bus->nom }}</td>
                        <td class="py-3 px-4">{{ $bus->compagnie }}</td>
                        <td class="py-3 px-4">
                            <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-sm">
                                {{ $bus->nombre_places }} places
                            </span>
                        </td>
                        <td class="py-3 px-4">
                            <a href="{{ route('admin.buses.edit', $bus) }}" class="text-indigo-600 hover:text-indigo-800 mr-3">Modifier</a>
                            <form action="{{ route('admin.buses.destroy', $bus) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800" onclick="return confirm('Supprimer ce bus ?')">
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
            {{ $buses->links() }}
        </div>
    </div>
</div>
@endsection