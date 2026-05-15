@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="bg-gradient-to-r from-green-600 to-teal-600 px-6 py-4">
            <h1 class="text-2xl font-bold text-white">
                @if($mode === 'simule')
                    💳 Paiement en ligne (simulation)
                @else
                    💵 Confirmation paiement à l'embarquement
                @endif
            </h1>
        </div>

        <div class="p-6">
            <!-- Récapitulatif rapide -->
            <div class="bg-gray-50 rounded-lg p-4 mb-6">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-sm text-gray-600">Référence</p>
                        <p class="font-semibold">{{ $reservation->reference }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm text-gray-600">Montant total</p>
                        <p class="text-2xl font-bold text-indigo-600">{{ number_format($reservation->montant_total, 0, ',', ' ') }} FCFA</p>
                    </div>
                </div>
            </div>

            @if($mode === 'simule')
                <!-- Formulaire de paiement simulé -->
                <form action="{{ route('paiement.simulate', $reservation) }}" method="POST">
                    @csrf
                    <input type="hidden" name="mode" value="simule">
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Numéro de carte</label>
                            <input type="text" value="4242 4242 4242 4242" 
                                   class="w-full border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 font-mono">
                            <p class="text-xs text-gray-500 mt-1">Mode test : utilisez 4242 4242 4242 4242</p>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-gray-700 font-medium mb-2">Date d'expiration</label>
                                <input type="text" placeholder="MM/AA" value="12/25"
                                       class="w-full border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                            </div>
                            <div>
                                <label class="block text-gray-700 font-medium mb-2">CVV</label>
                                <input type="text" placeholder="123" value="123"
                                       class="w-full border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Nom du titulaire</label>
                            <input type="text" value="{{ auth()->user()->name }}"
                                   class="w-full border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                    </div>

                    <div class="mt-8 flex gap-4">
                        <a href="{{ route('reservation.recap') }}" class="flex-1 bg-gray-200 text-gray-800 py-3 rounded-lg font-semibold text-center hover:bg-gray-300 transition">
                            Retour
                        </a>
                        <button type="submit" class="flex-1 bg-green-600 text-white py-3 rounded-lg font-semibold hover:bg-green-700 transition">
                            Payer {{ number_format($reservation->montant_total, 0, ',', ' ') }} FCFA
                        </button>
                    </div>
                </form>
            @else
                <!-- Confirmation paiement espèces -->
                <form action="{{ route('paiement.simulate', $reservation) }}" method="POST">
                    @csrf
                    <input type="hidden" name="mode" value="especes">
                    
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                        <p class="text-blue-800">
                            📌 Vous avez choisi de payer à l'embarquement. 
                            Veuillez vous présenter au guichet ou au chauffeur avec votre ticket numérique.
                        </p>
                    </div>

                    <div class="mt-8 flex gap-4">
                        <a href="{{ route('reservation.recap') }}" class="flex-1 bg-gray-200 text-gray-800 py-3 rounded-lg font-semibold text-center hover:bg-gray-300 transition">
                            Retour
                        </a>
                        <button type="submit" class="flex-1 bg-blue-600 text-white py-3 rounded-lg font-semibold hover:bg-blue-700 transition">
                            Confirmer ma réservation
                        </button>
                    </div>
                </form>
            @endif
        </div>
    </div>
</div>
@endsection