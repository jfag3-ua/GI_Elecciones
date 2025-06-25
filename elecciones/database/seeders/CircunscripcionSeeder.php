<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CircunscripcionSeeder extends Seeder
{
    public function run(): void
    {
        $circunscripciones = [
            ['idCircunscripcion' => 1, 'nombre' => 'Alicante', 'numEscanyos' => 35],
            ['idCircunscripcion' => 2, 'nombre' => 'Valencia', 'numEscanyos' => 40],
            ['idCircunscripcion' => 3, 'nombre' => 'Castellón', 'numEscanyos' => 24],
        ];
        foreach ($circunscripciones as $circ) {
            DB::table('circunscripcion')->insert($circ);
        }
    }
} 