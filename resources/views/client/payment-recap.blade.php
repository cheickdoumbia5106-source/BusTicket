@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <!-- Header -->
        <div class="bg-gradient-to-r from-indigo-600 to-blue-600 px-6 py-4">
            <h1 class="text-2xl font-bold text-white">Récapitulatif de votre réservation</h1>
        </div>

        <!-- Contenu -->
        <div class="p-6">
            <!-- Info trajet -->
            <div class="mb-8">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Détails du trajet</h2>
                <div class="bg-gray-50 rounded-lg p-4">
                    <div class="flex justify-between items-center">
                        <div class="text-center flex-1">
                            <p class="text-2xl font-bold text-gray-800">{{ $trajet->heure_depart->format('H:i') }}</p>
                            <p class="text-gray-600">{{ $trajet->villeDepart->nom }}</p>
                        </div>
                        <div class="text-gray-400 text-2xl flex-1 text-center">→</div>
                        <div class="text-center flex-1">
                            <p class="text-2xl font-bold text-gray-800">{{ $trajet->heure_arrivee->format('H:i') }}</p>
                            <p class="text-gray-600">{{ $trajet->villeArrivee->nom }}</p>
                        </div>
                    </div>
                    <div class="mt-4 text-center">
                        <p class="text-gray-600">{{ $trajet->date_depart->format('d/m/Y') }}</p>
                        <p class="text-gray-600">{{ $trajet->bus->compagnie }} - {{ $trajet->bus->nom }}</p>
                    </div>
                </div>
            </div>

            <!-- Sièges sélectionnés -->
            <div class="mb-8">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Sièges sélectionnés</h2>
                <div class="bg-gray-50 rounded-lg p-4">
                    <div class="flex flex-wrap gap-2">
                        @foreach($sieges as $siege)
                            <span class="bg-indigo-100 text-indigo-700 px-4 py-2 rounded-lg font-semibold">
                                Siège {{ $siege->numero_siege }}
                            </span>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Détails des prix -->
            <div class="mb-8">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Détails des prix</h2>
                <div class="bg-gray-50 rounded-lg p-4">
                    <div class="space-y-2">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Prix unitaire :</span>
                            <span class="font-semibold">{{ number_format($trajet->prix, 0, ',', ' ') }} FCFA</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Nombre de sièges :</span>
                            <span class="font-semibold">{{ count($sieges) }}</span>
                        </div>
                        <div class="border-t pt-2 mt-2">
                            <div class="flex justify-between">
                                <span class="text-lg font-bold text-gray-800">Total à payer :</span>
                                <span class="text-2xl font-bold text-indigo-600">{{ number_format($montantTotal, 0, ',', ' ') }} FCFA</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Choix du mode de paiement -->
            <div class="mb-8">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Mode de paiement</h2>
                <form action="{{ route('reservation.confirm') }}" method="POST" id="payment-form">
                    @csrf
                    <div class="space-y-3">
                        <label class="flex items-center p-4 border rounded-lg cursor-pointer hover:bg-gray-50 transition">
                            <input type="radio" name="mode_paiement" value="simule" class="w-5 h-5 text-indigo-600" required>
                            <div class="ml-3">
                                <p class="font-semibold text-gray-800">💳 Paiement en ligne (simulation)</p>
                                <p class="text-sm text-gray-500">Paiement immédiat par carte bancaire (environnement de test)</p>
                            </div>
                        </label>
                        
                        <label class="flex items-center p-4 border rounded-lg cursor-pointer hover:bg-gray-50 transition">
                            <input type="radio" name="mode_paiement" value="especes" class="w-5 h-5 text-indigo-600" required>
                            <div class="ml-3">
                                <p class="font-semibold text-gray-800">💵 Paiement à l'embarquement</p>
                                <p class="text-sm text-gray-500">Payez directement au chauffeur ou au guichet avant le départ</p>
                            </div>
                        </label>
                    </div>

                    <div class="mt-6 flex gap-4">
                        <a href="{{ url()->previous() }}" class="flex-1 bg-gray-200 text-gray-800 py-3 rounded-lg font-semibold text-center hover:bg-gray-300 transition">
                            Retour
                        </a>
                        <button type="submit" class="flex-1 bg-indigo-600 text-white py-3 rounded-lg font-semibold hover:bg-indigo-700 transition">
                            Confirmer et payer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection