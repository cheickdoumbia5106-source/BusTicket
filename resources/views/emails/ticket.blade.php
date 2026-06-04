<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Votre ticket BusTicket</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        .header {
            background: linear-gradient(135deg, #f97316, #ea580c);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .content {
            padding: 30px;
        }
        .info {
            background: #f9fafb;
            padding: 15px;
            border-radius: 12px;
            margin: 15px 0;
        }
        .btn {
            display: inline-block;
            background: #f97316;
            color: white;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 8px;
            margin-top: 20px;
        }
        .footer {
            background: #f5f5f5;
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #6b7280;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🎫 BusTicket</h1>
            <p>Confirmation de réservation</p>
        </div>
        
        <div class="content">
            <h2>Bonjour {{ $reservation->user->name }},</h2>
            <p>Votre réservation a été confirmée avec succès !</p>
            
            <div class="info">
                <strong>Référence :</strong> {{ $reservation->reference }}<br>
                <strong>Trajet :</strong> {{ $reservation->trajet->villeDepart->nom }} → {{ $reservation->trajet->villeArrivee->nom }}<br>
                <strong>Date :</strong> {{ Carbon\Carbon::parse($reservation->trajet->date_depart)->format('d/m/Y') }}<br>
                <strong>Départ :</strong> {{ Carbon\Carbon::parse($reservation->trajet->heure_depart)->format('H:i') }}<br>
                <strong>Sièges :</strong> 
                @foreach($reservation->sieges as $siege)
                    {{ $siege->numero_siege }}{{ !$loop->last ? ', ' : '' }}
                @endforeach<br>
                <strong>Montant :</strong> {{ number_format($reservation->montant_total, 0, ',', ' ') }} FCFA
            </div>
            
            <p>Vous trouverez ci-joint votre billet électronique au format PDF.</p>
            
            <center>
                <a href="{{ route('reservation.download-ticket', $reservation) }}" class="btn">
                    📥 Télécharger le ticket
                </a>
            </center>
        </div>
        
        <div class="footer">
            <p>Merci d'avoir choisi BusTicket !</p>
            <p>&copy; {{ date('Y') }} BusTicket. Tous droits réservés.</p>
        </div>
    </div>
</body>
</html>