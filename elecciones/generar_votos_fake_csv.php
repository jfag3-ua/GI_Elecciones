<?php

// Cantidad de votos a generar
$total = 500000;

// Carga los IDs de candidatos y localizaciones desde archivos de texto (uno por línea)
// Exporta estos archivos desde la base de datos antes de ejecutar este script
$candidatos = file_exists('candidatos_ids.txt') ? file('candidatos_ids.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) : [];
$localizaciones = file_exists('localizaciones_ids.txt') ? file('localizaciones_ids.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) : [];

if (empty($candidatos) || empty($localizaciones)) {
    die("Debes crear los archivos candidatos_ids.txt y localizaciones_ids.txt con los IDs válidos antes de ejecutar este script.\n");
}

$file = fopen('votos_fake.csv', 'w');
fputcsv($file, ['voto', 'localizacion_id']); // Cabecera

for ($i = 0; $i < $total; $i++) {
    $voto = $candidatos[array_rand($candidatos)];
    $localizacion = $localizaciones[array_rand($localizaciones)];
    fputcsv($file, [$voto, $localizacion]);
}
fclose($file);

echo "Archivo votos_fake.csv generado con $total votos.\n"; 