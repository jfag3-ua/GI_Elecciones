<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VotosSeeder extends Seeder
{
    public function run(): void
    {
        // Obtener usuarios y localizaciones
        $usuarios = DB::table('usuario')->get();
        $localizaciones = DB::table('localizacion')->get();
        $candidaturas = DB::table('candidatura')->get();
        $votos = [];
        $i = 0;
        foreach ($usuarios as $usuario) {
            // Asignar localización y candidatura según provincia
            $loc = $localizaciones[$i % count($localizaciones)];
            $cands = $candidaturas->where('idCircunscripcion', $loc->id % 3 + 1)->values();
            $cand = $cands[$i % $cands->count()];
            $votos[] = [
                'voto' => $cand->nombre,
                'localizacion_id' => $loc->id,
            ];
            $i++;
        }
        foreach ($votos as $voto) {
            DB::table('voto')->insert($voto);
        }
    }
} 