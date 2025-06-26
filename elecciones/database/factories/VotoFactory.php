<?php

namespace Database\Factories;

use App\Models\Voto;
use App\Models\Candidatura;
use App\Models\Localizacion;
use Illuminate\Database\Eloquent\Factories\Factory;

class VotoFactory extends Factory
{
    protected $model = Voto::class;

    public function definition(): array
    {
        return [
            'voto' => Candidatura::inRandomOrder()->first()?->idCandidatura ?? 1,
            'localizacion_id' => Localizacion::inRandomOrder()->first()?->id ?? 1,
        ];
    }
} 