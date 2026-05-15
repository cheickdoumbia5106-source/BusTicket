@extends('admin.layouts.admin')

@section('title', 'Gestion des villes')

@section('content')
<div class="bg-white rounded-lg shadow">
    <div class="border-b px-6 py-4 flex justify-between items-center">
        <h3 class="font-semibold text-gray-800">Liste des villes</h3>
        <a href="{{ route('admin.villes.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition">
            + Ajouter une ville
        </a>
    </div>
    
    <div class="p-6">
        <table class="w-full">
            <thead>
                <tr class="border-b">
                    <th class="text-left py-2">ID</th>
                    <th class="text-left py-2">Nom</th>
                    <th class="text-left py-2">Slug</th>
                    <th class="text-left py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($villes as $ville)
                <tr class="border-b">
                    <td class="py-2">{{ $ville->id }}</td>
                    <td class="py-2">{{ $ville->nom }}</td>
                    <td class="py-2">{{ $ville->slug }}</td>
                    <td class="py-2">
                        <a href="{{ route('admin.villes.edit', $ville) }}" class="text-indigo-600 hover:text-indigo-800 mr-3">Modifier</a>
                        <form action="{{ route('admin.villes.destroy', $ville) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800" onclick="return confirm('Supprimer cette ville ?')">Supprimer</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        
        <div class="mt-4">
            {{ $villes->links() }}
        </div>
    </div>
</div>
@endsection