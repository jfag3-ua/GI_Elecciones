<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CandidatosSeeder extends Seeder
{
    public function run(): void
    {
        // Ejemplo: 3 candidatos por candidatura, ordenados y con NIF únicos
        $candidatos = [];
        $nombres = [
            'PSPV-PSOE' => ['Ana', 'Luis', 'María'],
            'PP' => ['Carlos', 'Elena', 'Javier'],
            'Compromís' => ['Joan', 'Marta', 'Pau'],
            'VOX' => ['Sergio', 'Lucía', 'Raúl'],
        ];
        $apellidos = ['García', 'Martínez', 'López', 'Sánchez', 'Fernández', 'Ruiz', 'Torres', 'Ramírez', 'Navarro', 'Domínguez', 'Gil', 'Serrano'];
        $nif_base = 10000000;
        $orden = 1;
        // Para cada candidatura en cada provincia
        foreach ([1,2,3] as $idCircunscripcion) {
            $candidaturas = DB::table('candidatura')->where('idCircunscripcion', $idCircunscripcion)->get();
            foreach ($candidaturas as $candidatura) {
                $partido = $candidatura->nombre;
                foreach ($nombres[$partido] as $i => $nombre) {
                    $candidatos[] = [
                        'nombre' => $nombre,
                        'apellidos' => $apellidos[($idCircunscripcion-1)*3+$i],
                        'nif' => ($nif_base + ($idCircunscripcion*1000) + ($i*10) + $candidatura->idCandidatura) . chr(65+$i),
                        'orden' => $i+1,
                        'idCandidatura' => $candidatura->idCandidatura,
                    ];
                }
            }
        }
        foreach ($candidatos as $candidato) {
            DB::table('candidato')->insert($candidato);
        }
    }
} 