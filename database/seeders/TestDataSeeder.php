<?php

namespace Database\Seeders;

use App\Models\Reservation;
use App\Models\Siege;
use App\Models\Trajet;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TestDataSeeder extends Seeder
{
    public function run(): void
    {
        // Créer un utilisateur test
        $user = User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => bcrypt('password'),
                'role' => 'user',
            ]
        );

        // Créer quelques réservations de test
        $trajets = Trajet::take(3)->get();

        foreach ($trajets as $trajet) {
            $reservation = Reservation::create([
                'user_id' => $user->id,
                'trajet_id' => $trajet->id,
                'reference' => 'TEST-' . strtoupper(Str::random(6)),
                'statut' => 'confirmee',
                'montant_total' => $trajet->prix * 2,
                'date_reservation' => now(),
            ]);

            // Ajouter 2 sièges aléatoires
            $sieges = $trajet->bus->sieges->random(2);
            foreach ($sieges as $siege) {
                $reservation->sieges()->attach($siege->id, [
                    'prix_unitaire' => $trajet->prix,
                ]);
            }
        }
    }
}