<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BusTicket - Vérification d'email</title>
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

        .verify-container {
            background: rgba(15, 23, 42, 0.85);
            backdrop-filter: blur(24px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .btn-resend {
            background: linear-gradient(135deg, #f97316, #ea580c);
            transition: all 0.3s ease;
        }
        .btn-resend:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(249, 115, 22, 0.4);
        }

        .btn-logout {
            border: 1px solid rgba(255, 255, 255, 0.2);
            background: rgba(255, 255, 255, 0.05);
            transition: all 0.3s ease;
        }
        .btn-logout:hover {
            background: rgba(255, 255, 255, 0.1);
            transform: translateY(-2px);
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
        <div class="absolute top-32 right-32 text-4xl opacity-10 floating">📧</div>
        <div class="absolute bottom-32 left-32 text-3xl opacity-10 floating-reverse">✓</div>
        <div class="absolute top-1/2 right-16 text-2xl opacity-10 floating">🔔</div>
    </div>

    <div class="min-h-screen flex items-center justify-center p-4 pt-24">
        <div class="w-full max-w-md">
            <!-- Logo et titre centrés -->
            <div class="text-center mb-8">
                <a href="/" class="inline-block">
                    <div class="w-24 h-24 mx-auto mb-4 bg-gradient-to-br from-orange-500 to-orange-700 rounded-3xl flex items-center justify-center shadow-2xl floating transition-transform hover:scale-110">
                        <i class="fas fa-envelope-open-text text-4xl text-white"></i>
                    </div>
                </a>
                <h2 class="text-3xl font-bold text-white mb-2">Vérifiez votre email</h2>
                <p class="text-slate-400">Activez votre compte pour continuer</p>
            </div>

            <!-- Formulaire centré -->
            <div class="verify-container rounded-3xl p-8 shadow-2xl">
                <!-- Message principal -->
                <div class="mb-6 p-4 rounded-xl bg-blue-500/10 border border-blue-500/30 text-center">
                    <i class="fas fa-info-circle text-blue-400 text-2xl mb-2 block"></i>
                    <p class="text-slate-300 text-sm leading-relaxed">
                        Merci pour votre inscription ! Avant de commencer, veuillez vérifier votre adresse email 
                        en cliquant sur le lien que nous venons de vous envoyer.
                    </p>
                </div>

                <!-- Message de succès -->
                @if (session('status') == 'verification-link-sent')
                    <div class="mb-4 p-3 rounded-xl bg-emerald-500/20 border border-emerald-500/30 text-emerald-400 text-center text-sm">
                        <i class="fas fa-check-circle mr-2"></i>
                        Un nouveau lien de vérification a été envoyé à votre adresse email.
                    </div>
                @endif

                <!-- Actions -->
                <div class="space-y-3">
                    <form method="POST" action="{{ route('verification.send') }}">
                        @csrf
                        <button type="submit" class="btn-resend w-full py-3 rounded-xl text-white font-semibold text-lg transition flex items-center justify-center gap-2">
                            <i class="fas fa-paper-plane"></i>
                            Renvoyer l'email de vérification
                        </button>
                    </form>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn-logout w-full py-3 rounded-xl text-slate-300 font-semibold text-lg transition flex items-center justify-center gap-2">
                            <i class="fas fa-sign-out-alt"></i>
                            Se déconnecter
                        </button>
                    </form>
                </div>

                <!-- Instructions supplémentaires -->
                <div class="mt-6 pt-4 border-t border-white/10">
                    <div class="flex items-center gap-3 text-xs text-slate-500 justify-center">
                        <i class="fas fa-envelope"></i>
                        <span>Vérifiez vos spams si vous ne trouvez pas l'email</span>
                    </div>
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
</body>
</html>