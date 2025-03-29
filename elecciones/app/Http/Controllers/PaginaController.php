<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use League\Csv\Reader;

class PaginaController extends Controller

{
    public function landing() {
        return view('landing');
    }
    
    public function inicio() {
        return view('inicio');
    }

    public function registro() {
        return view('registro');
    }

    public function voto() {
        return view('voto');
    }

    public function encuestas() {
        if (!file_exists(storage_path('/app/datasets/predictions_dataset.csv'))) {
            return redirect()->route('inicio')->with('error', 'No se ha cargado el dataset');
        }

        $csv = Reader::createFromPath(storage_path('/app/datasets/predictions_dataset.csv'), 'r');
        $csv->setHeaderOffset(0); // Usa la primera fila como encabezados
    
        // $years = $csv->getHeader(); // Obtener los años como columnas
        $years = array_reverse($csv->getHeader()); // Invertir el orden de los años
        $abstencion = [];
        $blanco = [];
        $nulo = [];
    
        foreach ($csv as $index => $row) {
            foreach ($years as $year) {
                // Reemplazar caracteres especiales en el JSON
                $replacements = [
                    "'"  => '"',   
                ];

                // Decodificar los valores almacenados como diccionario en el CSV
                $dictionary = json_decode(strtr($row[$year], $replacements), true);
    
                if ($index == 1) {
                    $abstencion[$year][] = $dictionary;
                }
                 
                elseif ($index == 2) {
                    $blanco[$year][] = $dictionary;
                }

                elseif ($index == 3) {
                    $nulo[$year][] = $dictionary;
                }
            }
        }

        // Invertir el orden de los datos para que coincidan con los años invertidos
        $abstencion = array_reverse($abstencion, true);
        $blanco = array_reverse($blanco, true);
        $nulo = array_reverse($nulo, true);

        return view('encuestas', compact('abstencion', 'blanco', 'nulo', 'years'));
    }

    public function resultados()
    {
        if (!file_exists(storage_path('/app/datasets/elections_dataset.csv'))) {
            return redirect()->route('inicio')->with('error', 'No se ha cargado el dataset');
        }

        $csv = Reader::createFromPath(storage_path('/app/datasets/elections_dataset.csv'), 'r');
        $csv->setHeaderOffset(0); // Usa la primera fila como encabezados
    
        // $years = $csv->getHeader(); // Obtener los años como columnas
        $years = array_reverse($csv->getHeader()); // Invertir el orden de los años
        $info_general = [];
        $info_votos = [];
        $winners = [];
    
        foreach ($csv as $index => $row) {
            foreach ($years as $year) {
                // Reemplazar caracteres especiales en el JSON
                $replacements = [
                    "'"  => '"',   
                    "d'"  => "d ",
                ];

                // Decodificar los valores almacenados como diccionario en el CSV
                $dictionary = json_decode(strtr($row[$year], $replacements), true);

                // Verificar si el JSON se decodificó correctamente
                if (!is_array($dictionary)) {
                    dd("Error en JSON en el año: $year", $row[$year], json_last_error_msg(), $dictionary);
                }
    
                if ($index == 1) { // Primera fila -> Info General
                    $info_general[$year][] = $dictionary;
                }
                 
                elseif ($index == 2) { // Resto de filas -> Info Votos
                    $info_votos[$year][] = $dictionary;
                    //dd("Valor de la ARRAY: $year", $row[$year], $dictionary);
                }
            }
        }

        // Invertir el orden de los datos para que coincidan con los años invertidos
        $info_general = array_reverse($info_general, true);
        $info_votos = array_reverse($info_votos, true);
        
        foreach ($years as $year) {
            foreach ($info_votos[$year] as $candidatura) {
                $candidatos_list = $candidatura['Candidato'] ?? [];
                $votaciones_list = $candidatura['Votos'] ?? [];
                $escanos_list = $candidatura['Escanos'] ?? [];
                $count = max(count($candidatos_list), count($votaciones_list), count($escanos_list));

                $elected = [];
                for ($i = 0; $i < $count; $i++) {
                    $candidato = $candidatos_list[$i] ?? '/NA';
                    $votacion = $votaciones_list[$i] ?? 0;
                    $escano = $escanos_list[$i] ?? 0;

                    if ($escano > 0){
                        $elected[$candidato] = $escano;
                    }
                }

                $data = [
                    // Partidos
                    'labels' => array_keys($elected),
        
                    // Escaños
                    'datasets' => [[
                        'label' => 'Total de Escaños',
                        'data' => $elected,
                        'backgroundColor' => 'rgba(54, 162, 235, 0.5)',
                        'borderColor' => 'rgba(54, 162, 235, 1)',
                        'borderWidth' => 1
                    ]]
                ];

                $winners[$year] = $data;
            }
        }
    
        return view('resultados', compact('info_general', 'info_votos', 'years', 'winners'));
    }

    public function administracion() {
        return view('administracion');
    }

    public function usuario()
    {
        // Obtener el usuario autenticado
        $usuario = auth()->user();

        // Obtener la información del censo basándonos en el NIF del usuario
        $censo = DB::table('censo')
                    ->where('NIF', $usuario->NIF)
                    ->first();

        // Obtener la dirección asociada al usuario (por IDDIRECCION)
        $direccion = DB::table('direcciones')
                    ->where('IDDIRECCION', $censo->IDDIRECCION)
                    ->first();

        // Pasar los datos a la vista
        return view('usuario', compact('usuario', 'censo', 'direccion'));
    }
}