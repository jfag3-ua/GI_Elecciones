<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AdministradoresSeeder extends Seeder
{
    public function run(): void
    {
        $admins = [
            [
                'NIF' => '11111111A',
                'NOMBREUSUARIO' => 'admin1',
                'CONTRASENYA' => Hash::make('admin1234'),
            ],
            [
                'NIF' => '22222222B',
                'NOMBREUSUARIO' => 'admin2',
                'CONTRASENYA' => Hash::make('admin5678'),
            ],
        ];
        foreach ($admins as $admin) {
            DB::table('administrador')->insert($admin);
        }
    }
} 