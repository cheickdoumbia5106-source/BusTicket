<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'BusTicket • Réservez en un clic')</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            content: ["./**/*.blade.php"],
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'system-ui', 'sans-serif']
                    },
                    colors: {
                        primary: {
                            50: '#fff7ed',
                            500: '#f97316',
                            600: '#ea580c',
                            700: '#c2410c',
                            900: '#9a3412'
                        }
                    }
                }
            }
        }
    </script>

    <style>
        .glass {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
        }
        
        .hero-bg {
            background: linear-gradient(135deg, #f97316 0%, #c2410c 100%);
        }
        
        .neon-glow {
            text-shadow: 0 0 25px rgba(249, 115, 22, 0.6);
        }
        
        .card-hover {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .card-hover:hover {
            transform: translateY(-12px);
            box-shadow: 0 30px 60px -15px rgb(249 115 22 / 0.3);
        }
        
        .seat-btn {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .seat-btn:hover:not(:disabled) {
            transform: scale(1.15);
        }
        .seat-btn.selected {
            animation: pulse 1.5s infinite;
        }
        
        @keyframes pulse {
            0%, 100% { box-shadow: 0 0 0 0 rgba(249, 115, 22, 0.5); }
            70% { box-shadow: 0 0 0 12px rgba(249, 115, 22, 0); }
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-900">
    @include('partials.navbar')  {{-- Tu peux créer ce fichier plus tard --}}
    
    @yield('content')
    
    @include('partials.footer')
</body>
</html>