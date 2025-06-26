<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Candidatura;

class CandidaturaSeeder extends Seeder
{
    public function run(): void
    {
        $candidaturas = [
            // Alicante - Elección 1
            ['nombre' => 'PSPV-PSOE', 'color' => '#FF0000', 'idCircunscripcion' => 1, 'escanyosElegidos' => 0, 'eleccion_id' => 1],
            ['nombre' => 'PP', 'color' => '#1D84CE', 'idCircunscripcion' => 1, 'escanyosElegidos' => 0, 'eleccion_id' => 1],
            ['nombre' => 'Compromís', 'color' => '#F9A825', 'idCircunscripcion' => 1, 'escanyosElegidos' => 0, 'eleccion_id' => 1],
            ['nombre' => 'VOX', 'color' => '#63BE21', 'idCircunscripcion' => 1, 'escanyosElegidos' => 0, 'eleccion_id' => 1],
            // Valencia - Elección 1
            ['nombre' => 'PSPV-PSOE', 'color' => '#FF0000', 'idCircunscripcion' => 2, 'escanyosElegidos' => 0, 'eleccion_id' => 1],
            ['nombre' => 'PP', 'color' => '#1D84CE', 'idCircunscripcion' => 2, 'escanyosElegidos' => 0, 'eleccion_id' => 1],
            ['nombre' => 'Compromís', 'color' => '#F9A825', 'idCircunscripcion' => 2, 'escanyosElegidos' => 0, 'eleccion_id' => 1],
            ['nombre' => 'VOX', 'color' => '#63BE21', 'idCircunscripcion' => 2, 'escanyosElegidos' => 0, 'eleccion_id' => 1],
            // Castellón - Elección 1
            ['nombre' => 'PSPV-PSOE', 'color' => '#FF0000', 'idCircunscripcion' => 3, 'escanyosElegidos' => 0, 'eleccion_id' => 1],
            ['nombre' => 'PP', 'color' => '#1D84CE', 'idCircunscripcion' => 3, 'escanyosElegidos' => 0, 'eleccion_id' => 1],
            ['nombre' => 'Compromís', 'color' => '#F9A825', 'idCircunscripcion' => 3, 'escanyosElegidos' => 0, 'eleccion_id' => 1],
            ['nombre' => 'VOX', 'color' => '#63BE21', 'idCircunscripcion' => 3, 'escanyosElegidos' => 0, 'eleccion_id' => 1],
        ];
        foreach ($candidaturas as $cand) {
            Candidatura::create($cand);
        }
    }
} 