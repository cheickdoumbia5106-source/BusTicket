@extends('admin.layouts.admin')

@section('title', 'Gestion des utilisateurs')

@section('content')
<div class="card-futur rounded-3xl border border-white/20 bg-gradient-to-br from-white/10 to-white/5 backdrop-blur-lg overflow-hidden">
    <div class="px-6 py-5 border-b border-white/10">
        <h3 class="font-semibold text-xl text-white flex items-center gap-2"><i class="fas fa-users text-orange-500"></i> Utilisateurs</h3>
    </div>
    
    <div class="p-6 overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="border-b border-white/10">
                    <th class="text-left py-3 px-4 text-gray-400">ID</th>
                    <th class="text-left py-3 px-4 text-gray-400">Nom</th>
                    <th class="text-left py-3 px-4 text-gray-400">Email</th>
                    <th class="text-left py-3 px-4 text-gray-400">Rôle</th>
                    <th class="text-left py-3 px-4 text-gray-400">Réservations</th>
                    <th class="text-left py-3 px-4 text-gray-400">Inscrit le</th>
                    <th class="text-left py-3 px-4 text-gray-400">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr class="border-b border-white/5 hover:bg-white/5 transition">
                    <td class="py-3 px-4 text-white">{{ $user->id }}</td>
                    <td class="py-3 px-4 text-white font-medium">{{ $user->name }}</td>
                    <td class="py-3 px-4 text-gray-300">{{ $user->email }}</td>
                    <td class="py-3 px-4">
                        <span class="px-2 py-1 rounded-full text-xs {{ $user->role == 'admin' ? 'bg-purple-500/20 text-purple-400' : 'bg-gray-500/20 text-gray-400' }}">{{ ucfirst($user->role) }}</span>
                    </td>
                    <td class="py-3 px-4 text-gray-300">{{ $user->reservations_count ?? 0 }}</td>
                    <td class="py-3 px-4 text-gray-300">{{ $user->created_at->format('d/m/Y') }}</td>
                    <td class="py-3 px-4">
                        <a href="{{ route('admin.users.edit', $user) }}" class="text-orange-400 hover:text-orange-300 mr-3"><i class="fas fa-edit"></i></a>
                        @if($user->id != auth()->id())
                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-400 hover:text-red-300" onclick="return confirm('Supprimer ?')"><i class="fas fa-trash-alt"></i></button>
                        </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="py-12 text-center text-gray-400">Aucun utilisateur</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="mt-6">{{ $users->links() }}</div>
    </div>
</div>
@endsection