<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BusTicket - Réinitialisation du mot de passe</title>
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

        .reset-container {
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

        .btn-reset {
            background: linear-gradient(135deg, #f97316, #ea580c);
            transition: all 0.3s ease;
        }
        .btn-reset:hover {
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
        <div class="absolute top-32 right-32 text-4xl opacity-10 floating">🔄</div>
        <div class="absolute bottom-32 left-32 text-3xl opacity-10 floating-reverse">🔑</div>
        <div class="absolute top-1/2 right-16 text-2xl opacity-10 floating">✨</div>
    </div>

    <div class="min-h-screen flex items-center justify-center p-4 pt-24">
        <div class="w-full max-w-md">
            <!-- Logo et titre centrés -->
            <div class="text-center mb-8">
                <a href="/" class="inline-block">
                    <div class="w-24 h-24 mx-auto mb-4 bg-gradient-to-br from-orange-500 to-orange-700 rounded-3xl flex items-center justify-center shadow-2xl floating transition-transform hover:scale-110">
                        <i class="fas fa-key text-4xl text-white"></i>
                    </div>
                </a>
                <h2 class="text-3xl font-bold text-white mb-2">Nouveau mot de passe</h2>
                <p class="text-slate-400">Choisissez un mot de passe sécurisé</p>
            </div>

            <!-- Formulaire centré -->
            <div class="reset-container rounded-3xl p-8 shadow-2xl">
                <!-- Message d'information -->
                <div class="mb-6 p-3 rounded-xl bg-orange-500/10 border border-orange-500/30 text-orange-400 text-center text-sm">
                    <i class="fas fa-info-circle mr-2"></i>
                    Votre nouveau mot de passe doit contenir au moins 8 caractères
                </div>

                @if ($errors->any())
                    <div class="mb-4 p-3 rounded-xl bg-red-500/20 border border-red-500/30 text-red-400 text-center text-sm">
                        @foreach ($errors->all() as $error)
                            <div><i class="fas fa-exclamation-circle mr-2"></i>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif

                <form method="POST" action="{{ route('password.store') }}">
                    @csrf

                    <!-- Password Reset Token -->
                    <input type="hidden" name="token" value="{{ $request->route('token') }}">

                    <!-- Email Address -->
                    <div class="mb-5">
                        <label for="email" class="block text-slate-300 font-medium mb-2 text-sm">
                            <i class="fas fa-envelope mr-2 text-orange-500"></i>Adresse email
                        </label>
                        <input id="email" 
                               type="email" 
                               name="email" 
                               value="{{ old('email', $request->email) }}" 
                               required autofocus 
                               class="input-field w-full px-5 py-3 rounded-xl bg-slate-800/50 border border-white/20 text-white placeholder-slate-500 focus:outline-none focus:border-orange-500 focus:ring-2 focus:ring-orange-500/50 transition"
                               placeholder="votre@email.com">
                    </div>

                    <!-- Password -->
                    <div class="mb-5">
                        <label for="password" class="block text-slate-300 font-medium mb-2 text-sm">
                            <i class="fas fa-lock mr-2 text-orange-500"></i>Nouveau mot de passe
                        </label>
                        <input id="password" 
                               type="password" 
                               name="password" 
                               required 
                               class="input-field w-full px-5 py-3 rounded-xl bg-slate-800/50 border border-white/20 text-white placeholder-slate-500 focus:outline-none focus:border-orange-500 focus:ring-2 focus:ring-orange-500/50 transition"
                               placeholder="••••••••">
                        <div class="flex items-center gap-2 mt-2">
                            <div class="flex-1 h-1 bg-slate-700 rounded-full overflow-hidden">
                                <div class="h-full w-0 bg-gradient-to-r from-red-500 to-green-500 rounded-full" id="passwordStrength"></div>
                            </div>
                            <span class="text-xs text-slate-500" id="strengthText">Faible</span>
                        </div>
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
                        <p class="text-xs text-slate-500 mt-1" id="matchMessage"></p>
                    </div>

                    <button type="submit" class="btn-reset w-full py-3 rounded-xl text-white font-semibold text-lg transition flex items-center justify-center gap-2">
                        <i class="fas fa-save"></i>
                        Réinitialiser le mot de passe
                    </button>
                </form>

                <!-- Lien retour connexion -->
                <div class="text-center mt-6">
                    <a href="{{ route('login') }}" class="text-orange-400 hover:text-orange-300 transition inline-flex items-center gap-2 text-sm">
                        <i class="fas fa-arrow-left"></i>
                        Retour à la connexion
                    </a>
                </div>
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
    </style>

    <script>
        // Vérification de la force du mot de passe
        const passwordInput = document.getElementById('password');
        const confirmInput = document.getElementById('password_confirmation');
        const strengthBar = document.getElementById('passwordStrength');
        const strengthText = document.getElementById('strengthText');
        const matchMessage = document.getElementById('matchMessage');

        function checkPasswordStrength(password) {
            let strength = 0;
            if (password.length >= 8) strength++;
            if (password.match(/[a-z]+/)) strength++;
            if (password.match(/[A-Z]+/)) strength++;
            if (password.match(/[0-9]+/)) strength++;
            if (password.match(/[$@#&!]+/)) strength++;
            
            let width = (strength / 5) * 100;
            strengthBar.style.width = width + '%';
            
            if (strength <= 2) {
                strengthBar.style.backgroundColor = '#ef4444';
                strengthText.textContent = 'Faible';
                strengthText.style.color = '#ef4444';
            } else if (strength <= 4) {
                strengthBar.style.backgroundColor = '#f59e0b';
                strengthText.textContent = 'Moyen';
                strengthText.style.color = '#f59e0b';
            } else {
                strengthBar.style.backgroundColor = '#10b981';
                strengthText.textContent = 'Fort';
                strengthText.style.color = '#10b981';
            }
        }

        function checkPasswordMatch() {
            if (confirmInput.value.length > 0) {
                if (passwordInput.value === confirmInput.value) {
                    matchMessage.innerHTML = '<i class="fas fa-check-circle mr-1"></i>Les mots de passe correspondent';
                    matchMessage.style.color = '#10b981';
                } else {
                    matchMessage.innerHTML = '<i class="fas fa-exclamation-circle mr-1"></i>Les mots de passe ne correspondent pas';
                    matchMessage.style.color = '#ef4444';
                }
            } else {
                matchMessage.innerHTML = '';
            }
        }

        passwordInput.addEventListener('input', function() {
            checkPasswordStrength(this.value);
            checkPasswordMatch();
        });

        confirmInput.addEventListener('input', checkPasswordMatch);
    </script>
</body>
</html>