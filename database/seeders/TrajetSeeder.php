<?php

namespace Database\Seeders;

use App\Models\Trajet;
use App\Models\Ville;
use App\Models\Bus;
use Illuminate\Database\Seeder;

class TrajetSeeder extends Seeder
{
    public function run(): void
    {
        $bamako = Ville::where('slug', 'bamako')->first();
        $kayes = Ville::where('slug', 'kayes')->first();
        $sikasso = Ville::where('slug', 'sikasso')->first();
        $bus1 = Bus::first();

        Trajet::create([
            'ville_depart_id' => $bamako->id,
            'ville_arrivee_id' => $kayes->id,
            'bus_id' => $bus1->id,
            'date_depart' => now()->addDays(1),
            'heure_depart' => '08:00:00',
            'heure_arrivee' => '14:00:00',
            'prix' => 7500,
        ]);

        Trajet::create([
            'ville_depart_id' => $bamako->id,
            'ville_arrivee_id' => $sikasso->id,
            'bus_id' => $bus1->id,
            'date_depart' => now()->addDays(1),
            'heure_depart' => '10:00:00',
            'heure_arrivee' => '15:30:00',
            'prix' => 5000,
        ]);
    }
}