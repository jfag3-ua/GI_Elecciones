<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Eleccion;
use App\Models\Candidatura;
use App\Models\Candidato;
use App\Models\Circunscripcion;

class CandidaturasCandidatosFakeSeeder extends Seeder
{
    public function run(): void
    {
        $elecciones = Eleccion::where('fecha_elecciones', '<', now())->get();
        $circunscripciones = Circunscripcion::all();
        foreach ($elecciones as $eleccion) {
            foreach ($circunscripciones as $circunscripcion) {
                // Crear 19 partidos/candidaturas por provincia/circunscripción y elección
                $candidaturas = Candidatura::factory()->count(19)->create([
                    'eleccion_id' => $eleccion->id,
                    'idCircunscripcion' => $circunscripcion->idCircunscripcion
                ]);
                // Para cada partido, crear 30 candidatos
                foreach ($candidaturas as $candidatura) {
                    Candidato::factory()->count(30)->create([
                        'idCandidatura' => $candidatura->idCandidatura,
                        'eleccion_id' => $eleccion->id
                    ]);
                }
            }
        }
    }
} 