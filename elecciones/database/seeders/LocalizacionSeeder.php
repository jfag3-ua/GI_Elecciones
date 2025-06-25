<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Localizacion;

class LocalizacionSeeder extends Seeder
{
    public function run(): void
    {
        $localizaciones = [
            // Alicante
            ['nomProvincia' => 'Alicante', 'ciudad' => 'Alicante', 'provincia' => 'Alicante', 'codpos' => '03001'],
            ['nomProvincia' => 'Alicante', 'ciudad' => 'Elche', 'provincia' => 'Alicante', 'codpos' => '03201'],
            ['nomProvincia' => 'Alicante', 'ciudad' => 'Benidorm', 'provincia' => 'Alicante', 'codpos' => '03501'],
            // Valencia
            ['nomProvincia' => 'Valencia', 'ciudad' => 'Valencia', 'provincia' => 'Valencia', 'codpos' => '46001'],
            ['nomProvincia' => 'Valencia', 'ciudad' => 'Gandía', 'provincia' => 'Valencia', 'codpos' => '46700'],
            ['nomProvincia' => 'Valencia', 'ciudad' => 'Torrent', 'provincia' => 'Valencia', 'codpos' => '46900'],
            // Castellón
            ['nomProvincia' => 'Castellón', 'ciudad' => 'Castellón de la Plana', 'provincia' => 'Castellón', 'codpos' => '12001'],
            ['nomProvincia' => 'Castellón', 'ciudad' => 'Villarreal', 'provincia' => 'Castellón', 'codpos' => '12540'],
            ['nomProvincia' => 'Castellón', 'ciudad' => 'Onda', 'provincia' => 'Castellón', 'codpos' => '12200'],
        ];
        foreach ($localizaciones as $loc) {
            Localizacion::create($loc);
        }
    }
} 