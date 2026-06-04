<nav class="bg-white/95 backdrop-blur-lg border-b border-gray-100 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-6">
        <div class="flex justify-between items-center h-16 lg:h-20">
            
            <!-- Logo -->
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 bg-gradient-to-br from-orange-500 to-orange-600 rounded-2xl flex items-center justify-center text-white font-bold text-2xl shadow-inner">
                    🚌
                </div>
                <div>
                    <span class="font-bold text-2xl tracking-tight text-gray-900">Bus</span>
                    <span class="font-bold text-2xl tracking-tight text-orange-600">Ticket</span>
                </div>
            </div>

            <!-- Menu Desktop -->
            <div class="hidden md:flex items-center gap-8 text-sm font-medium">
                <a href="{{ route('home') }}" 
                   class="text-gray-700 hover:text-orange-600 transition-colors {{ request()->routeIs('home') ? 'text-orange-600 font-semibold' : '' }}">
                    Accueil
                </a>
            </div>

            <!-- Actions -->
            <div class="flex items-center gap-4">
                @guest
                    <a href="{{ route('login') }}" 
                       class="hidden sm:block px-5 py-2.5 text-gray-700 hover:text-gray-900 font-medium transition">
                        Se connecter
                    </a>
                    <a href="{{ route('register') }}" 
                       class="px-6 py-2.5 bg-orange-600 hover:bg-orange-700 text-white font-semibold rounded-2xl transition shadow-lg">
                        S'inscrire
                    </a>
                @else
                    <!-- Utilisateur connecté -->
                    <div class="flex items-center gap-3">
                        <a href="{{ route('profile') }}" 
                           class="flex items-center gap-3 hover:bg-gray-50 px-4 py-2 rounded-2xl transition">
                            <div class="w-8 h-8 bg-orange-100 text-orange-600 rounded-2xl flex items-center justify-center font-semibold text-sm">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                            <div class="hidden md:block">
                                <p class="text-sm font-semibold text-gray-800">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-gray-500 -mt-0.5">Voyageur</p>
                            </div>
                        </a>

                        <!-- Dropdown Menu -->
                        <div class="relative group">
                            <button onclick="toggleDropdown()" 
                                    class="w-9 h-9 flex items-center justify-center hover:bg-gray-100 rounded-2xl transition">
                                <i class="fas fa-ellipsis-v text-gray-600"></i>
                            </button>
                            
                            <div id="user-dropdown" 
                                 class="hidden group-hover:block absolute right-0 mt-2 w-56 bg-white rounded-3xl shadow-2xl border border-gray-100 py-2 z-50">
                                <a href="{{ route('profile') }}" class="flex items-center gap-3 px-5 py-3 hover:bg-gray-50">
                                    <i class="fas fa-user text-gray-400"></i>
                                    <span>Mon Profil</span>
                                </a>
                                <a href="reservations" class="flex items-center gap-3 px-5 py-3 hover:bg-gray-50">
                                    <i class="fas fa-ticket-alt text-gray-400"></i>
                                    <span>Mes Réservations</span>
                                </a>
                                <div class="border-t my-2"></div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" 
                                            class="flex items-center gap-3 px-5 py-3 text-red-600 hover:bg-red-50 w-full text-left">
                                        <i class="fas fa-sign-out-alt"></i>
                                        <span>Déconnexion</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endguest

                <!-- Mobile Menu Button -->
                <button onclick="toggleMobileMenu()" 
                        class="md:hidden w-10 h-10 flex items-center justify-center text-2xl text-gray-700">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div id="mobile-menu" class="hidden md:hidden bg-white border-t">
        <div class="px-6 py-8 space-y-6 text-lg">
            <a href="{{ route('home') }}" class="block py-2">Accueil</a>
            <a href="#" class="block py-2">Destinations</a>
            <a href="#" class="block py-2">Compagnies</a>
            <a href="{{ route('profile') }}" class="block py-2">Mes Voyages</a>
            
            @guest
                <div class="pt-6 border-t space-y-4">
                    <a href="{{ route('login') }}" class="block text-center py-4 border rounded-2xl">Se connecter</a>
                    <a href="{{ route('register') }}" class="block text-center py-4 bg-orange-600 text-white rounded-2xl">Créer un compte</a>
                </div>
            @else
                <div class="pt-6 border-t">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-left text-red-600 py-4">Déconnexion</button>
                    </form>
                </div>
            @endguest
        </div>
    </div>
</nav>

<script>
    function toggleMobileMenu() {
        const menu = document.getElementById('mobile-menu');
        menu.classList.toggle('hidden');
    }

    function toggleDropdown() {
        const dropdown = document.getElementById('user-dropdown');
        dropdown.classList.toggle('hidden');
    }

    // Fermer le dropdown en cliquant en dehors
    document.addEventListener('click', function(e) {
        const dropdown = document.getElementById('user-dropdown');
        if (!e.target.closest('.relative')) {
            dropdown.classList.add('hidden');
        }
    });
</script>