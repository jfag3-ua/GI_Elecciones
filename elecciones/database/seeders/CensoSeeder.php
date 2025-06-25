<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CensoSeeder extends Seeder
{
    public function run(): void
    {
        $censos = [
            ['NIF' => '12345678A', 'IDDIRECCION' => 1, 'CLAVE' => 'clavealicante1', 'NOMBRE' => 'Alicante Uno', 'APELLIDOS' => 'García López', 'FECHANAC' => '1990-01-01', 'SEXO' => 'M'],
            ['NIF' => '23456789B', 'IDDIRECCION' => 2, 'CLAVE' => 'clavevalencia1', 'NOMBRE' => 'Valencia Uno', 'APELLIDOS' => 'Martínez Ruiz', 'FECHANAC' => '1985-05-12', 'SEXO' => 'F'],
            ['NIF' => '34567890C', 'IDDIRECCION' => 3, 'CLAVE' => 'clavecastellon1', 'NOMBRE' => 'Castellón Uno', 'APELLIDOS' => 'Serrano Gil', 'FECHANAC' => '1978-09-23', 'SEXO' => 'M'],
            ['NIF' => '45678901D', 'IDDIRECCION' => 4, 'CLAVE' => 'clavealicante2', 'NOMBRE' => 'Alicante Dos', 'APELLIDOS' => 'Ramírez Torres', 'FECHANAC' => '1992-03-15', 'SEXO' => 'F'],
            ['NIF' => '56789012E', 'IDDIRECCION' => 5, 'CLAVE' => 'clavevalencia2', 'NOMBRE' => 'Valencia Dos', 'APELLIDOS' => 'Navarro Domínguez', 'FECHANAC' => '1988-07-30', 'SEXO' => 'M'],
            ['NIF' => '67890123F', 'IDDIRECCION' => 6, 'CLAVE' => 'clavecastellon2', 'NOMBRE' => 'Castellón Dos', 'APELLIDOS' => 'Fernández Sánchez', 'FECHANAC' => '1995-11-11', 'SEXO' => 'F'],
        ];
        foreach ($censos as $censo) {
            DB::table('censo')->insert($censo);
        }
    }
} 