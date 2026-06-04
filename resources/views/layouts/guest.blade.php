<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 min-h-screen">
        <div class="min-h-screen flex flex-col justify-center items-center p-4">
            <!-- Logo -->
            <div class="mb-8 text-center">
                <div class="w-20 h-20 mx-auto rounded-3xl bg-gradient-to-br from-orange-500 to-orange-700 flex items-center justify-center shadow-lg mb-3">
                    <i class="fas fa-bus text-3xl text-white"></i>
                </div>
                <h1 class="text-2xl font-bold text-white">{{ config('app.name', 'Laravel') }}</h1>
                <p class="text-gray-400 text-sm">Votre solution de transport</p>
            </div>

            <!-- Card -->
            <div class="w-full sm:max-w-md">
                <div class="card-futur rounded-3xl border border-white/20 bg-gradient-to-br from-white/10 to-white/5 backdrop-blur-lg overflow-hidden">
                    <div class="p-6 sm:p-8">
                        {{ $slot }}
                    </div>
                </div>
            </div>
            
            <!-- Footer -->
            <div class="mt-8 text-center text-gray-500 text-xs">
                &copy; {{ date('Y') }} {{ config('app.name', 'Laravel') }}. Tous droits réservés.
            </div>
        </div>
    </body>
</html>