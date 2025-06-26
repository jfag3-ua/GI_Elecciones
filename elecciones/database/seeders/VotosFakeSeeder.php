<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Voto;
use App\Models\Eleccion;
use App\Models\Candidatura;
use App\Models\Candidato;
use App\Models\Localizacion;
use App\Models\Circunscripcion;

class VotosFakeSeeder extends Seeder
{
    public function run(): void
    {
        $elecciones = Eleccion::where('fecha_elecciones', '<', now())->get();
        $circunscripciones = Circunscripcion::all();
        $localizaciones = Localizacion::pluck('id')->toArray();
        foreach ($elecciones as $eleccion) {
            foreach ($circunscripciones as $circunscripcion) {
                // Obtener candidaturas de la elección y circunscripción
                $candidaturas = Candidatura::where('eleccion_id', $eleccion->id)
                    ->where('idCircunscripcion', $circunscripcion->idCircunscripcion)
                    ->get();
                if ($candidaturas->isEmpty()) continue;
                // Asignar un peso aleatorio a cada candidatura (simula partidos grandes y pequeños)
                $pesos = [];
                $totalPeso = 0;
                foreach ($candidaturas as $candidatura) {
                    $peso = rand(1, 100);
                    $pesos[$candidatura->idCandidatura] = $peso;
                    $totalPeso += $peso;
                }
                // Generar 2000 votos por circunscripción y elección
                for ($i = 0; $i < 2000; $i++) {
                    // Elegir candidatura ponderada
                    $rand = rand(1, $totalPeso);
                    $acum = 0;
                    $candidaturaElegida = null;
                    foreach ($pesos as $idCandidatura => $peso) {
                        $acum += $peso;
                        if ($rand <= $acum) {
                            $candidaturaElegida = $idCandidatura;
                            break;
                        }
                    }
                    // Elegir candidato aleatorio dentro de la candidatura
                    $candidatos = Candidato::where('idCandidatura', $candidaturaElegida)->pluck('idCandidato')->toArray();
                    if (empty($candidatos)) continue;
                    $candidatoElegido = fake()->randomElement($candidatos);
                    // Localización aleatoria
                    $localizacion = fake()->randomElement($localizaciones);
                    Voto::create([
                        'voto' => $candidatoElegido,
                        'localizacion_id' => $localizacion,
                    ]);
                }
            }
        }
    }
} 