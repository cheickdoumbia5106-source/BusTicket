<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin BusTicket - @yield('title')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
            content: ["./resources/**/*.blade.php"],
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'system-ui', 'sans-serif'] },
                    colors: {
                        primary: {
                            50: '#fff7ed',
                            500: '#f97316',
                            600: '#ea580c',
                            700: '#c2410c',
                            800: '#9a3412'
                        }
                    }
                }
            }
        }
    </script>

    <style>
        :root {
            --primary: 249 115 22;
        }

        .glass-sidebar {
            background: rgba(15, 23, 42, 0.85);     /* Légèrement plus opaque */
            backdrop-filter: blur(24px);
            border-right: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 4px 0 15px -5px rgba(0, 0, 0, 0.3);
        }

        .nav-item {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .nav-item:hover {
            transform: translateX(8px);
            background: rgba(249, 115, 22, 0.2);
            border-left: 3px solid #f97316;
        }
        .nav-item.active {
            background: linear-gradient(135deg, rgba(249, 115, 22, 0.3), rgba(194, 65, 12, 0.15));
            border-left: 3px solid #f97316;
            color: white;
        }

        .card-futur {
            background: rgba(255, 255, 255, 0.06);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .card-futur:hover {
            transform: translateY(-6px);
            box-shadow: 0 25px 50px -12px rgba(249, 115, 22, 0.25);
        }
    </style>
</head>
<body class="font-sans antialiased bg-[#0f172a] text-slate-200">

    <div class="min-h-screen flex">

        <!-- ==================== SIDEBAR ==================== -->
        <div class="w-72 glass-sidebar fixed h-full overflow-y-auto">
            <div class="p-6 border-b border-white/10">
                <div class="flex items-center gap-3">
                    <div class="w-11 h-11 bg-gradient-to-br from-orange-500 to-orange-700 rounded-2xl flex items-center justify-center text-2xl shadow-lg">
                        🚌
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-white tracking-tight">BusTicket</h1>
                        <p class="text-orange-400 text-xs -mt-1">Administration</p>
                    </div>
                </div>
            </div>

            <nav class="mt-8 px-4 space-y-1">
                <a href="{{ route('admin.dashboard') }}" 
                   class="nav-item flex items-center gap-3 px-4 py-3.5 rounded-2xl text-slate-300 hover:text-white {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-chart-line w-5"></i> 
                    Tableau de bord
                </a>
                <a href="{{ route('admin.villes.index') }}" 
                   class="nav-item flex items-center gap-3 px-4 py-3.5 rounded-2xl text-slate-300 hover:text-white {{ request()->routeIs('admin.villes.*') ? 'active' : '' }}">
                    <i class="fas fa-city w-5"></i> 
                    Villes
                </a>
                <a href="{{ route('admin.buses.index') }}" 
                   class="nav-item flex items-center gap-3 px-4 py-3.5 rounded-2xl text-slate-300 hover:text-white {{ request()->routeIs('admin.buses.*') ? 'active' : '' }}">
                    <i class="fas fa-bus w-5"></i> 
                    Bus
                </a>
                <a href="{{ route('admin.trajets.index') }}" 
                   class="nav-item flex items-center gap-3 px-4 py-3.5 rounded-2xl text-slate-300 hover:text-white {{ request()->routeIs('admin.trajets.*') ? 'active' : '' }}">
                    <i class="fas fa-route w-5"></i> 
                    Trajets
                </a>
                <a href="{{ route('admin.reservations.index') }}" 
                   class="nav-item flex items-center gap-3 px-4 py-3.5 rounded-2xl text-slate-300 hover:text-white {{ request()->routeIs('admin.reservations.*') ? 'active' : '' }}">
                    <i class="fas fa-ticket-alt w-5"></i> 
                    Réservations
                </a>
                <a href="{{ route('admin.users.index') }}" 
                   class="nav-item flex items-center gap-3 px-4 py-3.5 rounded-2xl text-slate-300 hover:text-white {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                    <i class="fas fa-users w-5"></i> 
                    Utilisateurs
                </a>

                <hr class="my-6 border-white/10">

                <a href="{{ route('home') }}" 
                   class="nav-item flex items-center gap-3 px-4 py-3.5 rounded-2xl text-slate-300 hover:text-white">
                    <i class="fas fa-globe w-5"></i> 
                    Voir le site
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" 
                            class="nav-item w-full flex items-center gap-3 px-4 py-3.5 rounded-2xl text-slate-300 hover:text-white">
                        <i class="fas fa-sign-out-alt w-5"></i> 
                        Déconnexion
                    </button>
                </form>
            </nav>
        </div>

        <!-- ==================== CONTENU PRINCIPAL ==================== -->
        <div class="flex-1 ml-72">
            <!-- Header -->
            <div class="backdrop-blur-2xl bg-slate-950/80 border-b border-white/10 sticky top-0 z-10">
                <div class="px-8 py-5">
                    <div class="flex justify-between items-center">
                        <div>
                            <h2 class="text-2xl font-bold bg-gradient-to-r from-orange-400 to-orange-600 bg-clip-text text-transparent">
                                @yield('title')
                            </h2>
                            <p class="text-slate-400 text-sm">Panel d'administration</p>
                        </div>

                        <div class="flex items-center gap-6">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-2xl bg-gradient-to-br from-orange-500 to-orange-700 flex items-center justify-center font-bold text-lg">
                                    {{ substr(Auth::user()->name ?? 'A', 0, 1) }}
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-white">{{ Auth::user()->name ?? 'Administrateur' }}</p>
                                    <p class="text-xs text-orange-400">Admin</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contenu -->
            <div class="p-8">
                @if(session('success'))
                    <div class="mb-6 p-4 rounded-2xl bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 flex items-center gap-3">
                        <i class="fas fa-check-circle"></i> {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-6 p-4 rounded-2xl bg-red-500/10 border border-red-500/30 text-red-400 flex items-center gap-3">
                        <i class="fas fa-exclamation-triangle"></i> {{ session('error') }}
                    </div>
                @endif

                @yield('content')
            </div>
        </div>
    </div>
</body>
</html>