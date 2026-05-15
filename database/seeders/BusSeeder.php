<?php

namespace Database\Seeders;

use App\Models\Bus;
use Illuminate\Database\Seeder;

class BusSeeder extends Seeder
{
    public function run(): void
    {
        $buses = [
            ['nom' => 'Mercedes Sprinter', 'compagnie' => 'Bani Transport', 'nombre_places' => 50],
            ['nom' => 'IVECO Bus', 'compagnie' => 'Bani Transport', 'nombre_places' => 48],
            ['nom' => 'Toyota Coaster', 'compagnie' => 'Mali Voyages', 'nombre_places' => 30],
            ['nom' => 'Scania Touring', 'compagnie' => 'Africa Express', 'nombre_places' => 52],
        ];

        foreach ($buses as $bus) {
            Bus::create($bus);
        }
    }
}