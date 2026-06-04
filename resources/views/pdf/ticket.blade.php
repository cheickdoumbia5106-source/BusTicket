<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Ticket {{ $reservation->reference }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'DejaVu Sans', 'Helvetica', 'Arial', sans-serif;
            background: #f5f5f5;
            padding: 40px 20px;
        }
        
        .ticket {
            max-width: 550px;
            margin: 0 auto;
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }
        
        /* Header with gradient */
        .header {
            background: linear-gradient(135deg, #f97316 0%, #ea580c 100%);
            color: white;
            padding: 30px 20px;
            text-align: center;
            position: relative;
        }
        
        .header h1 {
            font-size: 28px;
            margin-bottom: 5px;
            letter-spacing: 2px;
        }
        
        .header p {
            font-size: 12px;
            opacity: 0.9;
        }
        
        .reference {
            display: inline-block;
            background: rgba(255, 255, 255, 0.2);
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 12px;
            margin-top: 10px;
            font-weight: bold;
        }
        
        /* Content */
        .content {
            padding: 25px;
        }
        
        /* Section styles */
        .section {
            margin-bottom: 25px;
            border-bottom: 1px solid #e5e7eb;
            padding-bottom: 20px;
        }
        
        .section:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }
        
        .section-title {
            font-size: 14px;
            font-weight: bold;
            color: #f97316;
            margin-bottom: 12px;
            text-transform: uppercase;
            letter-spacing: 1px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .section-title i {
            font-size: 16px;
        }
        
        .info-box {
            background: #f9fafb;
            padding: 15px;
            border-radius: 12px;
        }
        
        /* Journey details */
        .journey {
            display: flex;
            justify-content: space-between;
            align-items: center;
            text-align: center;
        }
        
        .journey-point {
            flex: 1;
        }
        
        .journey-time {
            font-size: 20px;
            font-weight: bold;
            color: #1f2937;
        }
        
        .journey-city {
            font-size: 14px;
            color: #6b7280;
            margin-top: 5px;
        }
        
        .journey-arrow {
            font-size: 24px;
            color: #f97316;
            padding: 0 15px;
        }
        
        .journey-info {
            text-align: center;
            margin-top: 15px;
            padding-top: 15px;
            border-top: 1px dashed #e5e7eb;
            font-size: 12px;
            color: #6b7280;
        }
        
        /* Seats */
        .seats-container {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }
        
        .seat-badge {
            display: inline-block;
            background: linear-gradient(135deg, #fef3c7, #fde68a);
            color: #92400e;
            padding: 8px 16px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: bold;
            box-shadow: 0 1px 2px rgba(0,0,0,0.05);
        }
        
        /* Payment info */
        .payment-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            font-size: 14px;
        }
        
        .payment-total {
            margin-top: 10px;
            padding-top: 10px;
            border-top: 2px solid #f97316;
            font-size: 18px;
            font-weight: bold;
            color: #f97316;
        }
        
        /* QR Code placeholder */
        .qr-code {
            text-align: center;
            padding: 15px;
            background: #f9fafb;
            border-radius: 12px;
            margin-top: 15px;
        }
        
        .qr-code svg {
            width: 80px;
            height: 80px;
        }
        
        /* Footer */
        .footer {
            background: #1f2937;
            color: #9ca3af;
            padding: 20px;
            text-align: center;
            font-size: 10px;
        }
        
        .footer p {
            margin: 5px 0;
        }
        
        /* Badges */
        .badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: bold;
        }
        
        .badge-paid {
            background: #10b981;
            color: white;
        }
        
        .badge-pending {
            background: #f59e0b;
            color: white;
        }
        
        /* Divider */
        .divider {
            text-align: center;
            margin: 15px 0;
            position: relative;
        }
        
        .divider span {
            background: white;
            padding: 0 10px;
            color: #9ca3af;
            font-size: 11px;
        }
        
        .divider::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 1px;
            background: #e5e7eb;
            z-index: -1;
        }
    </style>
</head>
<body>
    <div class="ticket">
        <!-- Header -->
        <div class="header">
            <h1>🚌 BusTicket</h1>
            <p>Billet électronique</p>
            <div class="reference">N° {{ $reservation->reference }}</div>
        </div>

        <div class="content">
            <!-- Passenger -->
            <div class="section">
                <div class="section-title">
                    👤 PASSAGER
                </div>
                <div class="info-box">
                    <div style="font-weight: bold; font-size: 16px; color: #1f2937;">{{ $reservation->user->name }}</div>
                    <div style="font-size: 12px; color: #6b7280; margin-top: 5px;">{{ $reservation->user->email }}</div>
                </div>
            </div>

            <!-- Journey -->
            <div class="section">
                <div class="section-title">
                    🗺️ TRAJET
                </div>
                <div class="info-box">
                    <div class="journey">
                        <div class="journey-point">
                            <div class="journey-time">{{ Carbon\Carbon::parse($reservation->trajet->heure_depart)->format('H:i') }}</div>
                            <div class="journey-city">{{ $reservation->trajet->villeDepart->nom }}</div>
                        </div>
                        <div class="journey-arrow">→</div>
                        <div class="journey-point">
                            <div class="journey-time">{{ Carbon\Carbon::parse($reservation->trajet->heure_arrivee)->format('H:i') }}</div>
                            <div class="journey-city">{{ $reservation->trajet->villeArrivee->nom }}</div>
                        </div>
                    </div>
                    <div class="journey-info">
                        📅 {{ Carbon\Carbon::parse($reservation->trajet->date_depart)->format('d/m/Y') }}<br>
                        🚍 {{ $reservation->trajet->bus->compagnie ?? 'BusTicket' }} - {{ $reservation->trajet->bus->nom ?? 'Standard' }}
                    </div>
                </div>
            </div>

            <!-- Seats -->
            <div class="section">
                <div class="section-title">
                    💺 SIÈGES RÉSERVÉS
                </div>
                <div class="info-box">
                    <div class="seats-container">
                        @foreach($reservation->sieges as $siege)
                            <span class="seat-badge">Siège {{ $siege->numero_siege }}</span>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Payment -->
            <div class="section">
                <div class="section-title">
                    💳 PAIEMENT
                </div>
                <div class="info-box">
                    <div class="payment-row">
                        <span>Mode de paiement :</span>
                        <strong>{{ $reservation->paiement->mode_paiement === 'simule' ? 'Paiement en ligne' : 'Paiement à l\'embarquement' }}</strong>
                    </div>
                    <div class="payment-row">
                        <span>Statut :</span>
                        <span class="badge {{ $reservation->paiement->statut === 'paye' ? 'badge-paid' : 'badge-pending' }}">
                            {{ $reservation->paiement->statut === 'paye' ? 'Payé' : 'En attente' }}
                        </span>
                    </div>
                    <div class="payment-row payment-total">
                        <span>Total :</span>
                        <span>{{ number_format($reservation->montant_total, 0, ',', ' ') }} FCFA</span>
                    </div>
                </div>
            </div>

            <!-- Divider with scissors effect -->
            <div class="divider">
                <span>--- --- --- Coupon détachable --- --- ---</span>
            </div>

            <!-- QR Code / Barcode area -->
            <div class="qr-code">
                <svg width="80" height="80" viewBox="0 0 100 100">
                    <rect width="100" height="100" fill="white"/>
                    @php
                        $ref = $reservation->reference;
                        $code = str_split($ref);
                        $x = 10;
                        $y = 10;
                    @endphp
                    @foreach($code as $char)
                        @for($i = 0; $i < ord($char) % 8; $i++)
                            <rect x="{{ $x + ($i * 4) }}" y="{{ $y }}" width="2" height="4" fill="black"/>
                        @endfor
                        @php
                            $x += 8;
                            if($x > 80) {
                                $x = 10;
                                $y += 6;
                            }
                        @endphp
                    @endforeach
                </svg>
                <div style="margin-top: 8px; font-size: 10px; color: #6b7280;">Présentez ce code à l'embarquement</div>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p> Présentez ce billet numérique ou imprimez-le avant l'embarquement</p>
            <p> Veuillez vous présenter 15 minutes avant le départ</p>
            <p> Merci d'avoir choisi BusTicket - Bon voyage !</p>
        </div>
    </div>
</body>
</html>