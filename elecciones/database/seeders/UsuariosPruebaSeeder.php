<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
class UsuariosPruebaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'NIF' => '84611391t',
            'NOMBREUSUARIO' => 'usuario1',
            'CONTRASENYA' => Hash::make('1234'),
        ]);

        User::create([
            'NIF' => '67869531l',
            'NOMBREUSUARIO' => 'usuario2',
            'CONTRASENYA' => Hash::make('1234'),
        ]);
    }
}
