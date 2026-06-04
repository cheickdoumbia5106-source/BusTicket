@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="bg-green-500 text-white p-6 text-center">
                <i class="fas fa-check-circle text-5xl mb-3"></i>
                <h1 class="text-2xl font-bold">Réservation confirmée !</h1>
                <p>Référence : {{ $reservation->reference }}</p>
            </div>
            
            <div class="p-6">
                <div class="mb-6">
                    <h3 class="font-bold text-lg mb-3">Détails du trajet</h3>
                    <p><strong>Départ :</strong> {{ $reservation->trajet->villeDepart->nom }}</p>
                    <p><strong>Arrivée :</strong> {{ $reservation->trajet->villeArrivee->nom }}</p>
                    <p><strong>Date :</strong> {{ $reservation->trajet->date_depart->format('d/m/Y') }}</p>
                    <p><strong>Heure :</strong> {{ $reservation->trajet->heure_depart->format('H:i') }}</p>
                </div>
                
                <div class="mb-6">
                    <h3 class="font-bold text-lg mb-3">Sièges réservés</h3>
                    @foreach($reservation->sieges as $siege)
                        <span class="bg-orange-100 text-orange-700 px-3 py-1 rounded-full mr-2">Siège {{ $siege->numero_siege }}</span>
                    @endforeach
                </div>
                
                <div class="text-center">
                    <a href="{{ route('reservation.download-ticket', $reservation) }}" 
                       class="bg-orange-500 hover:bg-orange-600 text-white font-bold py-3 px-6 rounded-lg inline-flex items-center gap-2">
                        <i class="fas fa-download"></i>
                        Télécharger le ticket (PDF)
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection