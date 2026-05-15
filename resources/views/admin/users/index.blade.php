@extends('admin.layouts.admin')

@section('title', 'Gestion des utilisateurs')

@section('content')
<div class="bg-white rounded-lg shadow">
    <div class="border-b px-6 py-4">
        <h3 class="font-semibold text-gray-800">👥 Liste des utilisateurs</h3>
    </div>
    
    <div class="p-6">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="text-left py-3 px-4">ID</th>
                        <th class="text-left py-3 px-4">Nom</th>
                        <th class="text-left py-3 px-4">Email</th>
                        <th class="text-left py-3 px-4">Rôle</th>
                        <th class="text-left py-3 px-4">Réservations</th>
                        <th class="text-left py-3 px-4">Inscrit le</th>
                        <th class="text-left py-3 px-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="py-3 px-4">{{ $user->id }}</td>
                        <td class="py-3 px-4 font-medium">{{ $user->name }}</td>
                        <td class="py-3 px-4">{{ $user->email }}</td>
                        <td class="py-3 px-4">
                            @if($user->role == 'admin')
                                <span class="bg-purple-100 text-purple-800 px-2 py-1 rounded text-sm">Admin</span>
                            @else
                                <span class="bg-gray-100 text-gray-800 px-2 py-1 rounded text-sm">Utilisateur</span>
                            @endif
                        </td>
                        <td class="py-3 px-4">
                            <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-sm">
                                {{ $user->reservations_count }} réservation(s)
                            </span>
                        </td>
                        <td class="py-3 px-4">{{ $user->created_at->format('d/m/Y') }}</td>
                        <td class="py-3 px-4">
                            <a href="{{ route('admin.users.edit', $user) }}" class="text-indigo-600 hover:text-indigo-800 mr-3">
                                Modifier
                            </a>
                            @if($user->id != auth()->id())
                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800" onclick="return confirm('Supprimer cet utilisateur ?')">
                                        Supprimer
                                    </button>
                                </form>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <div class="mt-4">
            {{ $users->links() }}
        </div>
    </div>
</div>
@endsection