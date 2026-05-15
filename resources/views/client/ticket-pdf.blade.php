<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Ticket {{ $reservation->reference }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            margin: 0;
            padding: 20px;
        }
        .ticket {
            max-width: 600px;
            margin: 0 auto;
            border: 2px solid #4F46E5;
            border-radius: 10px;
            overflow: hidden;
        }
        .header {
            background: linear-gradient(135deg, #4F46E5, #2563EB);
            color: white;
            padding: 20px;
            text-align: center;
        }
        .content {
            padding: 20px;
        }
        .section {
            margin-bottom: 20px;
        }
        .section-title {
            font-size: 16px;
            font-weight: bold;
            color: #4F46E5;
            margin-bottom: 10px;
        }
        .info-box {
            background: #F3F4F6;
            padding: 10px;
            border-radius: 5px;
        }
        .seat-badge {
            display: inline-block;
            background: #E0E7FF;
            color: #4F46E5;
            padding: 5px 10px;
            border-radius: 5px;
            margin: 2px;
            font-size: 12px;
            font-weight: bold;
        }
        .total {
            font-size: 20px;
            font-weight: bold;
            color: #4F46E5;
        }
        .footer {
            text-align: center;
            padding: 15px;
            background: #F9FAFB;
            font-size: 10px;
            color: #6B7280;
        }
    </style>
</head>
<body>
    <div class="ticket">
        <div class="header">
            <h1>🎫 BusTicket</h1>
            <p>Billet électronique</p>
            <p><strong>Réf : {{ $reservation->reference }}</strong></p>
        </div>

        <div class="content">
            <div class="section">
                <div class="section-title">Passager</div>
                <div class="info-box">
                    <strong>{{ $reservation->user->name }}</strong><br>
                    {{ $reservation->user->email }}
                </div>
            </div>

            <div class="section">
                <div class="section-title">Trajet</div>
                <div class="info-box">
                    <div style="display: flex; justify-content: space-between; text-align: center;">
                        <div>
                            <strong>{{ \Carbon\Carbon::parse($reservation->trajet->heure_depart)->format('H:i') }}</strong><br>
                            {{ $reservation->trajet->villeDepart->nom }}
                        </div>
                        <div style="font-size: 20px;">→</div>
                        <div>
                            <strong>{{ \Carbon\Carbon::parse($reservation->trajet->heure_arrivee)->format('H:i') }}</strong><br>
                            {{ $reservation->trajet->villeArrivee->nom }}
                        </div>
                    </div>
                    <div style="text-align: center; margin-top: 10px;">
                        {{ \Carbon\Carbon::parse($reservation->trajet->date_depart)->format('d/m/Y') }}<br>
                        {{ $reservation->trajet->bus->compagnie }} - {{ $reservation->trajet->bus->nom }}
                    </div>
                </div>
            </div>

            <div class="section">
                <div class="section-title">Sièges réservés</div>
                <div class="info-box">
                    @foreach($reservation->sieges as $siege)
                        <span class="seat-badge">Siège {{ $siege->numero_siege }}</span>
                    @endforeach
                </div>
            </div>

            <div class="section">
                <div class="section-title">Paiement</div>
                <div class="info-box">
                    <div style="display: flex; justify-content: space-between;">
                        <span>Mode :</span>
                        <strong>{{ $reservation->paiement->mode_paiement === 'simule' ? 'Payé en ligne' : 'À payer à l\'embarquement' }}</strong>
                    </div>
                    <div style="display: flex; justify-content: space-between; margin-top: 10px;">
                        <span>Total :</span>
                        <span class="total">{{ number_format($reservation->montant_total, 0, ',', ' ') }} FCFA</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="footer">
            Présentez ce billet (numérique ou papier) avant embarquement.<br>
            Merci d'avoir choisi BusTicket !
        </div>
    </div>
</body>
</html>