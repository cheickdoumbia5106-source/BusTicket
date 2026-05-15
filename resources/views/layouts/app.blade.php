<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>BusTicket - Réservation de billets de bus</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="font-sans antialiased bg-gray-50">
    <div class="min-h-screen flex flex-col">
        
        <!-- Navbar -->
        <nav class="bg-white shadow-md sticky top-0 z-50 border-b border-orange-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16">
                    <!-- Logo -->
                    <div class="flex items-center space-x-2">
                        <div class="text-3xl">🚌</div>
                        <a href="{{ route('home') }}" class="text-2xl font-bold bg-gradient-to-r from-orange-600 to-orange-500 bg-clip-text text-transparent">
                            Bus<span class="text-orange-600">Ticket</span>
                        </a>
                    </div>
                    
                    <!-- Navigation Desktop -->
                    <div class="hidden md:flex items-center space-x-6">
                        <a href="{{ route('home') }}" class="text-gray-700 hover:text-orange-600 transition font-medium">
                            Accueil
                        </a>
                        @auth
                            <a href="{{ route('profile') }}" class="text-gray-700 hover:text-orange-600 transition font-medium">
                                Mes réservations
                            </a>
                            @if(auth()->user()->isAdmin())
                                <a href="{{ route('admin.dashboard') }}" class="text-gray-700 hover:text-orange-600 transition font-medium">
                                    Administration
                                </a>
                            @endif
                        @endauth
                    </div>
                    
                    <!-- Actions -->
                    <div class="flex items-center space-x-4">
                        @auth
                            <!-- Menu utilisateur connecté -->
                            <div class="relative" x-data="{ open: false }">
                                <button @click="open = !open" class="flex items-center space-x-2 focus:outline-none">
                                    <div class="w-8 h-8 bg-gradient-to-r from-orange-500 to-orange-600 rounded-full flex items-center justify-center text-white font-bold">
                                        {{ substr(auth()->user()->name, 0, 1) }}
                                    </div>
                                    <span class="text-gray-700 hidden md:inline">{{ auth()->user()->name }}</span>
                                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </button>
                                
                                <div x-show="open" @click.away="open = false" x-cloak 
                                     class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-2 border z-50">
                                    <a href="{{ route('profile') }}" class="block px-4 py-2 text-gray-700 hover:bg-orange-50 hover:text-orange-600">
                                        👤 Mon profil
                                    </a>
                                    <a href="{{ route('profile') }}#reservations" class="block px-4 py-2 text-gray-700 hover:bg-orange-50 hover:text-orange-600">
                                        🎫 Mes réservations
                                    </a>
                                    @if(auth()->user()->isAdmin())
                                        <div class="border-t my-1"></div>
                                        <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-gray-700 hover:bg-orange-50 hover:text-orange-600">
                                            🔧 Administration
                                        </a>
                                    @endif
                                    <div class="border-t my-1"></div>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="w-full text-left px-4 py-2 text-red-600 hover:bg-red-50">
                                            🚪 Déconnexion
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @else
                            <a href="{{ route('login') }}" class="text-gray-700 hover:text-orange-600 transition font-medium">
                                Connexion
                            </a>
                            <a href="{{ route('register') }}" class="bg-gradient-to-r from-orange-500 to-orange-600 text-white px-5 py-2 rounded-full font-semibold hover:from-orange-600 hover:to-orange-700 transition shadow-md">
                                Inscription
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>

        <!-- Messages flash -->
        @if(session('success'))
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 px-4 py-3 rounded shadow-md">
                    {{ session('success') }}
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 px-4 py-3 rounded shadow-md">
                    {{ session('error') }}
                </div>
            </div>
        @endif

        <!-- Contenu principal -->
        <main class="flex-1">
            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="bg-gray-900 text-white mt-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
                <div class="grid md:grid-cols-4 gap-8">
                    <div>
                        <div class="flex items-center space-x-2 mb-4">
                            <div class="text-2xl">🚌</div>
                            <span class="text-xl font-bold">BusTicket</span>
                        </div>
                        <p class="text-gray-400 text-sm">
                            Réservez vos billets de bus en toute simplicité. Voyagez confortablement aux meilleurs prix.
                        </p>
                    </div>
                    <div>
                        <h4 class="font-semibold mb-4">Liens utiles</h4>
                        <ul class="space-y-2 text-gray-400 text-sm">
                            <li><a href="#" class="hover:text-orange-400 transition">À propos</a></li>
                            <li><a href="#" class="hover:text-orange-400 transition">Contact</a></li>
                            <li><a href="#" class="hover:text-orange-400 transition">FAQ</a></li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="font-semibold mb-4">Mentions légales</h4>
                        <ul class="space-y-2 text-gray-400 text-sm">
                            <li><a href="#" class="hover:text-orange-400 transition">Conditions générales</a></li>
                            <li><a href="#" class="hover:text-orange-400 transition">Politique de confidentialité</a></li>
                            <li><a href="#" class="hover:text-orange-400 transition">Cookies</a></li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="font-semibold mb-4">Suivez-nous</h4>
                        <div class="flex space-x-4">
                            <a href="#" class="text-gray-400 hover:text-orange-400 transition">📘</a>
                            <a href="#" class="text-gray-400 hover:text-orange-400 transition">📷</a>
                            <a href="#" class="text-gray-400 hover:text-orange-400 transition">🐦</a>
                        </div>
                    </div>
                </div>
                <div class="border-t border-gray-800 mt-8 pt-8 text-center text-gray-500 text-sm">
                    &copy; 2024 BusTicket - Tous droits réservés
                </div>
            </div>
        </footer>
    </div>
    
    <script>
        // Alpine.js sera chargé via Vite
        document.addEventListener('alpine:init', () => {
            console.log('Alpine.js initialisé');
        });
    </script>
</body>
</html>