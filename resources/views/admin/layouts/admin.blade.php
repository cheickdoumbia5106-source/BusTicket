<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - BusTicket</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
</head>
<body class="font-sans antialiased bg-gray-100">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <div class="w-64 bg-indigo-800 text-white">
            <div class="p-6">
                <h1 class="text-2xl font-bold">🚌 BusTicket</h1>
                <p class="text-indigo-300 text-sm">Administration</p>
            </div>
            
            <nav class="mt-6">
                <a href="{{ route('admin.dashboard') }}" class="block px-6 py-3 hover:bg-indigo-700 transition">
                    📊 Dashboard
                </a>
                <a href="{{ route('admin.villes.index') }}" class="block px-6 py-3 hover:bg-indigo-700 transition">
                    🏙️ Villes
                </a>
                <a href="{{ route('admin.buses.index') }}" class="block px-6 py-3 hover:bg-indigo-700 transition">
                    🚌 Bus
                </a>
                <a href="{{ route('admin.trajets.index') }}" class="block px-6 py-3 hover:bg-indigo-700 transition">
                    🗺️ Trajets
                </a>
                <a href="{{ route('admin.reservations.index') }}" class="block px-6 py-3 hover:bg-indigo-700 transition">
                    🎫 Réservations
                </a>
                <a href="{{ route('admin.users.index') }}" class="block px-6 py-3 hover:bg-indigo-700 transition">
                    👥 Utilisateurs
                </a>
                <hr class="my-4 border-indigo-600">
                <a href="{{ route('home') }}" class="block px-6 py-3 hover:bg-indigo-700 transition">
                    🌐 Voir le site
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left px-6 py-3 hover:bg-indigo-700 transition">
                        🚪 Déconnexion
                    </button>
                </form>
            </nav>
        </div>

        <!-- Contenu principal -->
        <div class="flex-1">
            <div class="bg-white shadow-sm px-6 py-4">
                <h2 class="text-xl font-semibold text-gray-800">@yield('title')</h2>
            </div>
            
            <div class="p-6">
                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                        {{ session('error') }}
                    </div>
                @endif

                @yield('content')
            </div>
        </div>
    </div>
</body>
</html>