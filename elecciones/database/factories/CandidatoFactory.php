<?php

namespace Database\Factories;

use App\Models\Candidato;
use App\Models\Candidatura;
use Illuminate\Database\Eloquent\Factories\Factory;

class CandidatoFactory extends Factory
{
    protected $model = Candidato::class;

    public function definition(): array
    {
        return [
            'nombre' => $this->faker->firstName(),
            'apellidos' => $this->faker->lastName(),
            'elegido' => $this->faker->boolean(30),
            'idCandidatura' => Candidatura::inRandomOrder()->first()?->idCandidatura ?? 1,
            'nif' => $this->faker->unique()->bothify('########?'),
            'orden' => $this->faker->numberBetween(1, 10),
            'eleccion_id' => Candidatura::inRandomOrder()->first()?->eleccion_id ?? 1,
        ];
    }
} 