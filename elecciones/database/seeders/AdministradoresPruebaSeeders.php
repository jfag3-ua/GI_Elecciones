<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;

class AdministradoresPruebaSeeders extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Admin::create([
            'NIF' => '11111111A',
            'NOMBREUSUARIO' => 'administrador1',
            'CONTRASENYA' => Hash::make('1234'),
        ]);

        Admin::create([
            'NIF' => '222222222A',
            'NOMBREUSUARIO' => 'administrador2',
            'CONTRASENYA' => Hash::make('1234'),
        ]);
    }
}
