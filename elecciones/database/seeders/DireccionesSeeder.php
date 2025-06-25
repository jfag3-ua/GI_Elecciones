<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DireccionesSeeder extends Seeder
{
    public function run(): void
    {
        $direcciones = [
            ['PROVINCIA' => 'Alicante', 'CIUDAD' => 'Alicante', 'CPOSTAL' => '03001', 'NOMVIA' => 'Av. de la Estación', 'NUMERO' => '1', 'BIS' => null, 'PISO' => '2', 'BLOQUE' => null, 'PUERTA' => 'A'],
            ['PROVINCIA' => 'Valencia', 'CIUDAD' => 'Valencia', 'CPOSTAL' => '46001', 'NOMVIA' => 'Calle Colón', 'NUMERO' => '10', 'BIS' => null, 'PISO' => '3', 'BLOQUE' => 'B', 'PUERTA' => '2'],
            ['PROVINCIA' => 'Castellón', 'CIUDAD' => 'Castellón de la Plana', 'CPOSTAL' => '12001', 'NOMVIA' => 'Plaza Mayor', 'NUMERO' => '5', 'BIS' => 'BIS', 'PISO' => null, 'BLOQUE' => null, 'PUERTA' => null],
            ['PROVINCIA' => 'Alicante', 'CIUDAD' => 'Elche', 'CPOSTAL' => '03201', 'NOMVIA' => 'Calle Reina Victoria', 'NUMERO' => '8', 'BIS' => null, 'PISO' => '1', 'BLOQUE' => 'A', 'PUERTA' => 'B'],
            ['PROVINCIA' => 'Valencia', 'CIUDAD' => 'Gandía', 'CPOSTAL' => '46700', 'NOMVIA' => 'Av. República Argentina', 'NUMERO' => '15', 'BIS' => null, 'PISO' => null, 'BLOQUE' => null, 'PUERTA' => '3'],
            ['PROVINCIA' => 'Castellón', 'CIUDAD' => 'Villarreal', 'CPOSTAL' => '12540', 'NOMVIA' => 'Calle Mayor', 'NUMERO' => '20', 'BIS' => null, 'PISO' => '4', 'BLOQUE' => 'C', 'PUERTA' => null],
        ];
        foreach ($direcciones as $dir) {
            DB::table('direcciones')->insert($dir);
        }
    }
} 