<?php

namespace Database\Factories;

use App\Models\Candidatura;
use App\Models\Eleccion;
use Illuminate\Database\Eloquent\Factories\Factory;

class CandidaturaFactory extends Factory
{
    protected $model = Candidatura::class;

    public function definition(): array
    {
        return [
            'nombre' => $this->faker->unique()->company(),
            'color' => $this->faker->safeColorName(),
            'idCircunscripcion' => 1, // Puedes randomizar si tienes circunscripciones
            'escanyosElegidos' => $this->faker->numberBetween(1, 10),
            'eleccion_id' => Eleccion::inRandomOrder()->first()?->id ?? 1,
        ];
    }
} 