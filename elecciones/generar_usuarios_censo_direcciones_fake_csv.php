<?php

// Cantidad de usuarios/censados/direcciones
$total = 1000000;

// Abrir archivo único
$archivo = fopen('usuarios_censo_direcciones_fake.csv', 'w');

// Cabecera
fputcsv($archivo, [
    'NIF', 'CONTRASENYA', 'IDDIRECCION', 'CLAVE', 'NOMBRE', 'APELLIDOS', 'FECHANAC', 'SEXO',
    'PROVINCIA', 'CIUDAD', 'CPOSTAL', 'NOMVIA', 'NUMERO', 'BIS', 'PISO', 'BLOQUE', 'PUERTA', 'CORREO'
]);

// Hash bcrypt precomputado para 'password'
$password = password_hash('password', PASSWORD_BCRYPT);
$provincias = ['Alicante', 'Castellón', 'Valencia'];
$nombres = ['Juan', 'Ana', 'Pedro', 'Lucía', 'Carlos', 'María', 'Javier', 'Laura'];
$apellidos = ['García', 'Martínez', 'López', 'Sánchez', 'Pérez', 'Gómez', 'Ruiz', 'Fernández'];
$vias = ['Calle Mayor', 'Avenida del Sol', 'Plaza España', 'Camino Real'];
$sexos = ['H', 'M'];

for ($i = 1; $i <= $total; $i++) {
    $nif = str_pad($i, 8, '0', STR_PAD_LEFT) . 'A';
    $iddir = $i;
    $provincia = $provincias[$i % 3];
    $ciudad = $provincia . ' Ciudad ' . ($i % 100);
    $cpostal = str_pad(($i % 50000) + 1000, 5, '0', STR_PAD_LEFT);
    $nomvia = $vias[$i % 4];
    $numero = ($i % 200) + 1;
    $bis = '';
    $piso = ($i % 10) + 1;
    $bloque = '';
    $puerta = chr(65 + ($i % 5)); // A-E
    $clave = 'CLAVE' . $i;
    $nombre = $nombres[$i % 8];
    $apellido = $apellidos[$i % 8];
    $fechanac = rand(1960, 2005) . '-' . str_pad(rand(1, 12), 2, '0', STR_PAD_LEFT) . '-' . str_pad(rand(1, 28), 2, '0', STR_PAD_LEFT);
    $sexo = $sexos[$i % 2];
    $correo = strtolower($nombre . $i . '@mail.com');
    fputcsv($archivo, [
        $nif, $password, $iddir, $clave, $nombre, $apellido, $fechanac, $sexo,
        $provincia, $ciudad, $cpostal, $nomvia, $numero, $bis, $piso, $bloque, $puerta, $correo
    ]);
}

fclose($archivo);

echo "Archivo usuarios_censo_direcciones_fake.csv generado con $total registros.\n"; 