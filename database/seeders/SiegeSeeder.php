<?php

namespace Database\Seeders;

use App\Models\Bus;
use App\Models\Siege;
use Illuminate\Database\Seeder;

class SiegeSeeder extends Seeder
{
    public function run(): void
    {
        $buses = Bus::all();

        foreach ($buses as $bus) {
            $nombrePlaces = $bus->nombre_places;
            $cols = 5; // 5 colonnes
            $rows = ceil($nombrePlaces / $cols);
            $numero = 1;

            for ($rang = 1; $rang <= $rows; $rang++) {
                for ($colonne = 1; $colonne <= $cols; $colonne++) {
                    if ($numero <= $nombrePlaces) {
                        Siege::create([
                            'bus_id' => $bus->id,
                            'numero_siege' => $numero,
                            'rang' => $rang,
                            'colonne' => $colonne,
                        ]);
                        $numero++;
                    }
                }
            }
        }
    }
}