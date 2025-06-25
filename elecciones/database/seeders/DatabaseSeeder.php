<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            CircunscripcionSeeder::class,
            LocalizacionSeeder::class,
            DireccionesSeeder::class,
            CensoSeeder::class,
            CandidaturaSeeder::class,
            UsuariosSeeder::class,
            CandidatosSeeder::class,
            VotosSeeder::class,
            AdministradoresSeeder::class,
            EleccionesSeeder::class,
        ]);
    }
}
