<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class EleccionesSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('elecciones')->insert([
            [
                'nombre' => 'Elecciones Generales 2023',
                'fecha_inicio' => '2023-06-01',
                'fecha_fin' => '2023-07-23',
                'fecha_campana_inicio' => '2023-07-07',
                'fecha_campana_fin' => '2023-07-21',
                'fecha_elecciones' => '2023-07-23',
                'activa' => false,
                'votos_nulos' => 0,
                'abstenciones' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Elecciones Autonómicas 2025',
                'fecha_inicio' => '2025-03-01',
                'fecha_fin' => '2025-05-15',
                'fecha_campana_inicio' => '2025-05-01',
                'fecha_campana_fin' => '2025-05-13',
                'fecha_elecciones' => '2025-05-15',
                'activa' => true,
                'votos_nulos' => 0,
                'abstenciones' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
} 