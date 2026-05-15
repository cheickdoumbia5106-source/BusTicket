@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <!-- En-tête du ticket -->
        <div class="bg-gradient-to-r from-indigo-600 to-blue-600 px-6 py-6 text-center text-white">
            <div class="inline-block bg-white/20 rounded-full px-4 py-2 mb-4">
                <p class="font-semibold">Billet électronique</p>
            </div>
            <h1 class="text-3xl font-bold mb-2">🎫 BusTicket</h1>
            <p class="text-indigo-100">Réf : {{ $reservation->reference }}</p>
        </div>

        <!-- Contenu du ticket -->
        <div class="p-6">
            <!-- Info passager -->
            <div class="mb-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-3">Passager</h2>
                <div class="bg-gray-50 rounded-lg p-4">
                    <p class="font-semibold">{{ $reservation->user->name }}</p>
                    <p class="text-gray-600">{{ $reservation->user->email }}</p>
                </div>
            </div>

            <!-- Info trajet -->
            <div class="mb-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-3">Trajet</h2>
                <div class="bg-gray-50 rounded-lg p-4">
                    <div class="flex justify-between items-center">
                        <div class="text-center flex-1">
                            <p class="text-2xl font-bold text-gray-800">{{ \Carbon\Carbon::parse($reservation->trajet->heure_depart)->format('H:i') }}</p>
                            <p class="text-gray-600">{{ $reservation->trajet->villeDepart->nom }}</p>
                        </div>
                        <div class="text-gray-400 text-2xl flex-1 text-center">→</div>
                        <div class="text-center flex-1">
                            <p class="text-2xl font-bold text-gray-800">{{ \Carbon\Carbon::parse($reservation->trajet->heure_arrivee)->format('H:i') }}</p>
                            <p class="text-gray-600">{{ $reservation->trajet->villeArrivee->nom }}</p>
                        </div>
                    </div>
                    <div class="mt-3 text-center">
                        <p class="text-gray-600">{{ \Carbon\Carbon::parse($reservation->trajet->date_depart)->format('d/m/Y') }}</p>
                        <p class="text-gray-600">{{ $reservation->trajet->bus->compagnie }} - {{ $reservation->trajet->bus->nom }}</p>
                    </div>
                </div>
            </div>

            <!-- Sièges -->
            <div class="mb-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-3">Sièges réservés</h2>
                <div class="bg-gray-50 rounded-lg p-4">
                    <div class="flex flex-wrap gap-2">
                        @foreach($reservation->sieges as $siege)
                            <span class="bg-indigo-100 text-indigo-700 px-4 py-2 rounded-lg font-semibold">
                                Siège {{ $siege->numero_siege }}
                            </span>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Paiement -->
            <div class="mb-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-3">Paiement</h2>
                <div class="bg-gray-50 rounded-lg p-4">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-gray-600">Mode de paiement :</p>
                            <p class="font-semibold">
                                @if($reservation->paiement->mode_paiement === 'simule')
                                    💳 Payé en ligne
                                @else
                                    💵 À payer à l'embarquement
                                @endif
                            </p>
                        </div>
                        <div class="text-right">
                            <p class="text-gray-600">Montant total :</p>
                            <p class="text-2xl font-bold text-indigo-600">{{ number_format($reservation->montant_total, 0, ',', ' ') }} FCFA</p>
                        </div>
                    </div>
                    @if($reservation->paiement->statut === 'en_attente')
                        <div class="mt-3 bg-yellow-100 border border-yellow-300 rounded p-2 text-center">
                            <p class="text-yellow-800 text-sm">⚠️ En attente de paiement à l'embarquement</p>
                        </div>
                    @else
                        <div class="mt-3 bg-green-100 border border-green-300 rounded p-2 text-center">
                            <p class="text-green-800 text-sm">✓ Paiement confirmé</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- QR Code (simulé) -->
            <div class="mb-6 text-center">
                <div class="inline-block bg-gray-100 rounded-lg p-4">
                    <div class="w-32 h-32 bg-black mx-auto flex items-center justify-center">
                        <p class="text-white text-xs text-center">QR CODE<br>{{ $reservation->reference }}</p>
                    </div>
                    <p class="text-xs text-gray-500 mt-2">Présentez ce code à l'embarquement</p>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex gap-4">
                <a href="{{ route('profile') }}" class="flex-1 bg-gray-200 text-gray-800 py-3 rounded-lg font-semibold text-center hover:bg-gray-300 transition">
                    Mes réservations
                </a>
                <a href="{{ route('ticket.download', $reservation) }}" class="flex-1 bg-indigo-600 text-white py-3 rounded-lg font-semibold text-center hover:bg-indigo-700 transition">
                    Télécharger PDF
                </a>
            </div>
        </div>
    </div>
</div>
@endsection