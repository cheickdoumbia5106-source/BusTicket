<?php

namespace Database\Seeders;

use App\Models\Ville;
use Illuminate\Database\Seeder;

class VilleSeeder extends Seeder
{
    public function run(): void
    {
        $villes = [
            ['nom' => 'Bamako', 'slug' => 'bamako'],
            ['nom' => 'Kayes', 'slug' => 'kayes'],
            ['nom' => 'Sikasso', 'slug' => 'sikasso'],
            ['nom' => 'Ségou', 'slug' => 'segou'],
            ['nom' => 'Mopti', 'slug' => 'mopti'],
            ['nom' => 'Gao', 'slug' => 'gao'],
            ['nom' => 'Tombouctou', 'slug' => 'tombouctou'],
        ];

        foreach ($villes as $ville) {
            Ville::create($ville);
        }
    }
}