<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BusTicket - Inscription</title>
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

        body {
            background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 50%, #0f172a 100%);
            min-height: 100vh;
        }

        .register-container {
            background: rgba(15, 23, 42, 0.85);
            backdrop-filter: blur(24px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .input-field {
            transition: all 0.3s ease;
        }
        .input-field:focus {
            transform: translateY(-2px);
        }

        .btn-register {
            background: linear-gradient(135deg, #f97316, #ea580c);
            transition: all 0.3s ease;
        }
        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(249, 115, 22, 0.4);
        }

        .floating {
            animation: float 8s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(5deg); }
        }

        .floating-reverse {
            animation: floatReverse 10s ease-in-out infinite;
        }

        @keyframes floatReverse {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(20px) rotate(-5deg); }
        }
    </style>
</head>
<body class="font-sans antialiased">

    <!-- Navigation minimal -->
    <nav class="fixed w-full z-50 backdrop-blur-2xl bg-slate-950/80 border-b border-white/10">
        <div class="container mx-auto px-6 py-4">
            <div class="flex justify-center md:justify-between items-center">
                <a href="/" class="hidden md:flex items-center gap-3 group">
                    <div class="w-10 h-10 bg-gradient-to-br from-orange-500 to-orange-700 rounded-xl flex items-center justify-center text-xl shadow-lg transition-transform group-hover:scale-110">
                        🚌
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-white">BusTicket</h1>
                        <p class="text-orange-400 text-xs">Voyagez en toute confiance</p>
                    </div>
                </a>

                <div class="flex gap-3">
                    <a href="/" class="text-slate-300 hover:text-orange-400 transition px-4 py-2">
                        <i class="fas fa-home mr-2"></i>Accueil
                    </a>
                    <a href="{{ route('login') }}" class="btn-outline px-5 py-2 rounded-xl text-white font-medium text-sm">
                        <i class="fas fa-sign-in-alt mr-2"></i>Connexion
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Animated background -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-20 left-10 w-72 h-72 bg-orange-500/10 rounded-full blur-3xl floating"></div>
        <div class="absolute bottom-20 right-10 w-96 h-96 bg-purple-500/10 rounded-full blur-3xl floating-reverse"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[500px] h-[500px] bg-orange-500/5 rounded-full blur-3xl"></div>
        
        <!-- Petits éléments flottants -->
        <div class="absolute top-32 right-32 text-4xl opacity-10 floating">🚌</div>
        <div class="absolute bottom-32 left-32 text-3xl opacity-10 floating-reverse">🎫</div>
        <div class="absolute top-1/2 right-16 text-2xl opacity-10 floating">🗺️</div>
    </div>

    <div class="min-h-screen flex items-center justify-center p-4 pt-24">
        <div class="w-full max-w-md">
            <!-- Logo et titre centrés -->
            <div class="text-center mb-8">
                <a href="/" class="inline-block">
                    <div class="w-24 h-24 mx-auto mb-4 bg-gradient-to-br from-orange-500 to-orange-700 rounded-3xl flex items-center justify-center shadow-2xl floating transition-transform hover:scale-110">
                        <i class="fas fa-bus text-4xl text-white"></i>
                    </div>
                </a>
                <h2 class="text-3xl font-bold text-white mb-2">Inscription</h2>
                <p class="text-slate-400">Créez votre compte</p>
            </div>

            <!-- Formulaire d'inscription centré -->
            <div class="register-container rounded-3xl p-8 shadow-2xl">
                @if ($errors->any())
                    <div class="mb-4 p-3 rounded-xl bg-red-500/20 border border-red-500/30 text-red-400 text-center text-sm">
                        @foreach ($errors->all() as $error)
                            <div><i class="fas fa-exclamation-circle mr-2"></i>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <!-- Name -->
                    <div class="mb-5">
                        <label for="name" class="block text-slate-300 font-medium mb-2 text-sm">
                            <i class="fas fa-user mr-2 text-orange-500"></i>Nom complet
                        </label>
                        <input id="name" 
                               type="text" 
                               name="name" 
                               value="{{ old('name') }}" 
                               required autofocus 
                               class="input-field w-full px-5 py-3 rounded-xl bg-slate-800/50 border border-white/20 text-white placeholder-slate-500 focus:outline-none focus:border-orange-500 focus:ring-2 focus:ring-orange-500/50 transition"
                               placeholder="Jean Dupont">
                    </div>

                    <!-- Email Address -->
                    <div class="mb-5">
                        <label for="email" class="block text-slate-300 font-medium mb-2 text-sm">
                            <i class="fas fa-envelope mr-2 text-orange-500"></i>Adresse email
                        </label>
                        <input id="email" 
                               type="email" 
                               name="email" 
                               value="{{ old('email') }}" 
                               required 
                               class="input-field w-full px-5 py-3 rounded-xl bg-slate-800/50 border border-white/20 text-white placeholder-slate-500 focus:outline-none focus:border-orange-500 focus:ring-2 focus:ring-orange-500/50 transition"
                               placeholder="votre@email.com">
                    </div>

                    <!-- Password -->
                    <div class="mb-5">
                        <label for="password" class="block text-slate-300 font-medium mb-2 text-sm">
                            <i class="fas fa-lock mr-2 text-orange-500"></i>Mot de passe
                        </label>
                        <input id="password" 
                               type="password" 
                               name="password" 
                               required 
                               class="input-field w-full px-5 py-3 rounded-xl bg-slate-800/50 border border-white/20 text-white placeholder-slate-500 focus:outline-none focus:border-orange-500 focus:ring-2 focus:ring-orange-500/50 transition"
                               placeholder="••••••••">
                        <p class="text-xs text-slate-500 mt-1">Minimum 8 caractères</p>
                    </div>

                    <!-- Confirm Password -->
                    <div class="mb-6">
                        <label for="password_confirmation" class="block text-slate-300 font-medium mb-2 text-sm">
                            <i class="fas fa-check-circle mr-2 text-orange-500"></i>Confirmer le mot de passe
                        </label>
                        <input id="password_confirmation" 
                               type="password" 
                               name="password_confirmation" 
                               required 
                               class="input-field w-full px-5 py-3 rounded-xl bg-slate-800/50 border border-white/20 text-white placeholder-slate-500 focus:outline-none focus:border-orange-500 focus:ring-2 focus:ring-orange-500/50 transition"
                               placeholder="••••••••">
                    </div>

                    <button type="submit" class="btn-register w-full py-3 rounded-xl text-white font-semibold text-lg transition flex items-center justify-center gap-2">
                        <i class="fas fa-user-plus"></i>
                        S'inscrire
                    </button>
                </form>

                <!-- Separator -->
                <div class="relative my-6">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-white/20"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-3 bg-slate-800 text-slate-400 rounded-full">Ou</span>
                    </div>
                </div>

                <!-- Google Login -->
                <a href="{{ route('google.login') }}" 
                   class="btn-google w-full flex justify-center items-center gap-3 bg-white/10 hover:bg-white/20 text-white font-semibold py-3 px-4 rounded-xl transition border border-white/20">
                    <svg class="w-5 h-5" viewBox="0 0 24 24">
                        <path fill="currentColor" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                        <path fill="currentColor" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                        <path fill="currentColor" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                        <path fill="currentColor" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                    </svg>
                    S'inscrire avec Google
                </a>

                <p class="text-center text-slate-400 text-sm mt-6">
                    Déjà inscrit ? 
                    <a href="{{ route('login') }}" class="text-orange-400 hover:text-orange-300 font-semibold transition">
                        Se connecter
                    </a>
                </p>
            </div>

            <!-- Footer centré -->
            <div class="text-center mt-8">
                <p class="text-slate-500 text-xs">
                    &copy; {{ date('Y') }} BusTicket. Tous droits réservés.
                </p>
            </div>
        </div>
    </div>

    <style>
        .btn-outline {
            border: 1px solid rgba(249, 115, 22, 0.5);
            background: rgba(249, 115, 22, 0.1);
            transition: all 0.3s ease;
        }
        .btn-outline:hover {
            background: rgba(249, 115, 22, 0.2);
            border-color: #f97316;
        }

        .btn-google {
            transition: all 0.3s ease;
        }
        .btn-google:hover {
            transform: translateY(-2px);
            background: rgba(255, 255, 255, 0.15);
        }
    </style>

    <script>
        // Animation subtile sur les inputs
        document.querySelectorAll('.input-field').forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.classList.add('transform');
            });
            input.addEventListener('blur', function() {
                this.parentElement.classList.remove('transform');
            });
        });
    </script>
</body>
</html>