@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-800">Choisissez vos sièges</h1>
        <div class="mt-2 text-gray-600">
            <p>{{ $trajet->villeDepart->nom }} → {{ $trajet->villeArrivee->nom }}</p>
            <p>Date : {{ $trajet->date_depart->format('d/m/Y') }} à {{ $trajet->heure_depart->format('H:i') }}</p>
            <p>Compagnie : {{ $trajet->bus->compagnie }} - {{ $trajet->bus->nom }}</p>
        </div>
    </div>

    <div class="flex flex-wrap -mx-4">
        <!-- Plan du bus -->
        <div class="w-full lg:w-2/3 px-4">
            <div class="bg-white rounded-xl shadow-lg p-6">
                <div class="text-center mb-6">
                    <div class="inline-block bg-gray-200 rounded-lg px-6 py-2">
                        <p class="font-semibold">Avant du bus 🚌</p>
                    </div>
                </div>

                <!-- Grille des sièges -->
                <div class="overflow-x-auto">
                    <div class="inline-block min-w-full">
                        @php
                            $groupedSeats = $tousLesSieges->groupBy('rang');
                            $rows = $groupedSeats->keys()->sort();
                        @endphp

                        @foreach($rows as $rang)
                            <div class="flex justify-center mb-4">
                                <div class="flex space-x-3">
                                    @php
                                        $siegesRow = $groupedSeats[$rang]->sortBy('colonne');
                                    @endphp
                                    @foreach($siegesRow as $siege)
                                        @php
                                            $isAvailable = $siege->est_libre ?? true;
                                            $seatNumber = $siege->numero_siege;
                                        @endphp
                                        <button type="button"
                                                data-seat="{{ $siege->id }}"
                                                data-number="{{ $seatNumber }}"
                                                onclick="toggleSeat(this)"
                                                class="seat-btn w-12 h-12 rounded-lg transition-all duration-200 
                                                       {{ $isAvailable ? 'bg-green-500 hover:bg-green-600 cursor-pointer' : 'bg-red-500 cursor-not-allowed opacity-50' }}
                                                       text-white font-bold shadow-md"
                                                {{ !$isAvailable ? 'disabled' : '' }}>
                                            {{ $seatNumber }}
                                        </button>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Légende -->
                <div class="mt-8 flex justify-center space-x-6">
                    <div class="flex items-center">
                        <div class="w-6 h-6 bg-green-500 rounded mr-2"></div>
                        <span class="text-sm">Libre</span>
                    </div>
                    <div class="flex items-center">
                        <div class="w-6 h-6 bg-yellow-500 rounded mr-2"></div>
                        <span class="text-sm">Sélectionné</span>
                    </div>
                    <div class="flex items-center">
                        <div class="w-6 h-6 bg-red-500 rounded mr-2"></div>
                        <span class="text-sm">Occupé</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Panneau de résumé -->
        <div class="w-full lg:w-1/3 px-4 mt-6 lg:mt-0">
            <div class="bg-white rounded-xl shadow-lg p-6 sticky top-24">
                <h3 class="text-xl font-bold text-gray-800 mb-4">Votre sélection</h3>
                
                <div id="selected-seats-list" class="min-h-[100px] mb-4">
                    <p class="text-gray-500 text-sm">Aucun siège sélectionné</p>
                </div>
                
                <div class="border-t pt-4 mt-4">
                    <div class="flex justify-between mb-2">
                        <span class="font-semibold">Nombre de sièges :</span>
                        <span id="seat-count" class="font-bold text-indigo-600">0</span>
                    </div>
                    <div class="flex justify-between mb-4">
                        <span class="font-semibold">Prix unitaire :</span>
                        <span class="font-bold">{{ number_format($trajet->prix, 0, ',', ' ') }} FCFA</span>
                    </div>
                    <div class="flex justify-between text-xl mb-6">
                        <span class="font-bold">Total :</span>
                        <span id="total-price" class="font-bold text-indigo-600">0 FCFA</span>
                    </div>
                </div>

                <form id="reservation-form" action="{{ route('reservation.prepare') }}" method="POST">
                    @csrf
                    <input type="hidden" name="trajet_id" value="{{ $trajet->id }}">
                    <input type="hidden" name="sieges" id="selected-seats-input" value="">
                    
                    <button type="submit" id="submit-btn" disabled
                            class="w-full bg-indigo-600 text-white py-3 rounded-lg font-semibold 
                                   hover:bg-indigo-700 transition disabled:bg-gray-400 disabled:cursor-not-allowed">
                        Continuer la réservation
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    let selectedSeats = [];

    function toggleSeat(button) {
        // Ne rien faire si le siège est déjà occupé
        if (button.disabled) return;
        
        const seatId = button.getAttribute('data-seat');
        const seatNumber = button.getAttribute('data-number');
        
        if (selectedSeats.includes(seatId)) {
            // Désélectionner
            selectedSeats = selectedSeats.filter(id => id !== seatId);
            button.classList.remove('bg-yellow-500');
            button.classList.add('bg-green-500');
        } else {
            // Sélectionner
            selectedSeats.push(seatId);
            button.classList.remove('bg-green-500');
            button.classList.add('bg-yellow-500');
        }
        
        updateSummary();
    }

    function updateSummary() {
        const seatCount = selectedSeats.length;
        const unitPrice = {{ $trajet->prix }};
        const totalPrice = seatCount * unitPrice;
        
        // Mettre à jour l'affichage
        document.getElementById('seat-count').textContent = seatCount;
        document.getElementById('total-price').textContent = totalPrice.toLocaleString('fr-FR') + ' FCFA';
        
        // Mettre à jour la liste des sièges sélectionnés
        const seatsListDiv = document.getElementById('selected-seats-list');
        if (seatCount > 0) {
            const seatNumbers = [];
            document.querySelectorAll('.seat-btn').forEach(btn => {
                if (selectedSeats.includes(btn.getAttribute('data-seat'))) {
                    seatNumbers.push(btn.getAttribute('data-number'));
                }
            });
            seatsListDiv.innerHTML = `
                <div class="flex flex-wrap gap-2">
                    ${seatNumbers.map(num => `<span class="bg-indigo-100 text-indigo-700 px-3 py-1 rounded-full text-sm font-semibold">Siège ${num}</span>`).join('')}
                </div>
            `;
        } else {
            seatsListDiv.innerHTML = '<p class="text-gray-500 text-sm">Aucun siège sélectionné</p>';
        }
        
        // Activer/désactiver le bouton de soumission
        const submitBtn = document.getElementById('submit-btn');
        const seatsInput = document.getElementById('selected-seats-input');
        
        if (seatCount > 0) {
            submitBtn.disabled = false;
            seatsInput.value = JSON.stringify(selectedSeats);
        } else {
            submitBtn.disabled = true;
            seatsInput.value = '';
        }
    }
</script>

<style>
    .seat-btn {
        transition: all 0.2s ease;
    }
    .seat-btn:hover:not(:disabled) {
        transform: scale(1.05);
    }
</style>
@endsection