<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Candidatura;

class CandidaturaSeeder extends Seeder
{
    public function run(): void
    {
        $candidaturas = [
            // Alicante
            ['nombre' => 'PSPV-PSOE', 'color' => '#FF0000', 'idCircunscripcion' => 1, 'escanyosElegidos' => 0],
            ['nombre' => 'PP', 'color' => '#1D84CE', 'idCircunscripcion' => 1, 'escanyosElegidos' => 0],
            ['nombre' => 'Compromís', 'color' => '#F9A825', 'idCircunscripcion' => 1, 'escanyosElegidos' => 0],
            ['nombre' => 'VOX', 'color' => '#63BE21', 'idCircunscripcion' => 1, 'escanyosElegidos' => 0],
            // Valencia
            ['nombre' => 'PSPV-PSOE', 'color' => '#FF0000', 'idCircunscripcion' => 2, 'escanyosElegidos' => 0],
            ['nombre' => 'PP', 'color' => '#1D84CE', 'idCircunscripcion' => 2, 'escanyosElegidos' => 0],
            ['nombre' => 'Compromís', 'color' => '#F9A825', 'idCircunscripcion' => 2, 'escanyosElegidos' => 0],
            ['nombre' => 'VOX', 'color' => '#63BE21', 'idCircunscripcion' => 2, 'escanyosElegidos' => 0],
            // Castellón
            ['nombre' => 'PSPV-PSOE', 'color' => '#FF0000', 'idCircunscripcion' => 3, 'escanyosElegidos' => 0],
            ['nombre' => 'PP', 'color' => '#1D84CE', 'idCircunscripcion' => 3, 'escanyosElegidos' => 0],
            ['nombre' => 'Compromís', 'color' => '#F9A825', 'idCircunscripcion' => 3, 'escanyosElegidos' => 0],
            ['nombre' => 'VOX', 'color' => '#63BE21', 'idCircunscripcion' => 3, 'escanyosElegidos' => 0],
        ];
        foreach ($candidaturas as $cand) {
            Candidatura::create($cand);
        }
    }
} 