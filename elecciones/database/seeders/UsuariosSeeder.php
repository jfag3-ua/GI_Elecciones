<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UsuariosSeeder extends Seeder
{
    public function run(): void
    {
        $usuarios = [
            ['NIF' => '12345678A', 'NOMBREUSUARIO' => 'alicante1', 'CONTRASENYA' => Hash::make('1234'), 'votado' => 0],
            ['NIF' => '23456789B', 'NOMBREUSUARIO' => 'valencia1', 'CONTRASENYA' => Hash::make('1234'), 'votado' => 0],
            ['NIF' => '34567890C', 'NOMBREUSUARIO' => 'castellon1', 'CONTRASENYA' => Hash::make('1234'), 'votado' => 0],
            ['NIF' => '45678901D', 'NOMBREUSUARIO' => 'alicante2', 'CONTRASENYA' => Hash::make('1234'), 'votado' => 0],
            ['NIF' => '56789012E', 'NOMBREUSUARIO' => 'valencia2', 'CONTRASENYA' => Hash::make('1234'), 'votado' => 0],
            ['NIF' => '67890123F', 'NOMBREUSUARIO' => 'castellon2', 'CONTRASENYA' => Hash::make('1234'), 'votado' => 0],
        ];
        foreach ($usuarios as $usuario) {
            DB::table('usuario')->insert($usuario);
        }
    }
} 