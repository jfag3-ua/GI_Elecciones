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

    public function predicciones() {
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

        return view('predicciones', compact('abstencion', 'blanco', 'nulo', 'years'));
    }

    public function resultados()
    {
        if (!file_exists(storage_path('/app/datasets/elections_dataset.csv'))) {
            return redirect()->route('inicio')->with('error', 'No se ha cargado el dataset');
        }

        $csv = Reader::createFromPath(storage_path('/app/datasets/elections_dataset.csv'), 'r');
        $csv->setHeaderOffset(0); // Usa la primera fila como encabezados

        $years = array_reverse($csv->getHeader()); // Invertir el orden de los años
        $info_general = [];
        $info_votos = [];
        $info_color = [];
        $winners = [];

        foreach ($csv as $index => $row) {
            foreach ($years as $year) {
                // Reemplazar caracteres especiales en el JSON
                $replacements = [
                    "'"  => '"',   
                    "d'"  => "d ",
                ];
                $replacements_v1 = [
                    "'"  => '"',   
                ];

                // Decodificar los valores almacenados como diccionario en el CSV
                $dictionary = json_decode(strtr($row[$year], $replacements), true);
                $dictionary_v1 = json_decode(strtr($row[$year], $replacements_v1), true);

                if ($index == 1) { // Primera fila -> Info General
                    $info_general[$year][] = $dictionary;
                }

                elseif ($index == 2) { // Resto de filas -> Info Votos
                    $info_votos[$year][] = $dictionary;
                }

                elseif ($index == 3) { // Resto de filas -> Info Votos
                    $info_color[$year] = $dictionary_v1;
                }
            }
        }

        // Invertir el orden de los datos para que coincidan con los años invertidos
        $info_general = array_reverse($info_general, true);
        $info_votos = array_reverse($info_votos, true);
        $info_color = array_reverse($info_color, true);

        foreach ($years as $year) {
            if (!isset($info_votos[$year])) {
                continue;
            }

            $escanos_partidos = [];
            foreach ($info_votos[$year] as $candidatura) {
                $candidatos_list = $candidatura['Candidato'] ?? [];
                $escanos_list = $candidatura['Escanos'] ?? [];

                for ($i = 0; $i < count($candidatos_list); $i++) {
                    $candidato = $candidatos_list[$i] ?? '/NA';
                    $escanos = $escanos_list[$i] ?? 0;

                    if ($escanos > 0) {
                        $escanos_partidos[$candidato] = $escanos;
                    }
                }
            }


            $background = $info_color[$year]['Background'] ?? [];
            $hover = $info_color[$year]['Hover'] ?? [];

            $data = [
                // Partidos
                'labels' => array_keys($escanos_partidos),
    
                // Escaños
                'datasets' => [[
                    'label' => 'Total de Escaños',
                    'data' => array_values($escanos_partidos),
                    'backgroundColor' => array_values($background),
                    'hoverBackgroundColor' => array_values($hover)
                ]]
            ];

            // Guardar los datos en la variable $winners para pasarlos a la vista
            $winners[$year] = $data;
        }

        return view('resultados', compact('info_general', 'info_votos', 'years', 'winners'));
    }



    public function administracion() {
        return view('administracion');
    }

    public function usuario()
    {
        // Obtener el usuario autenticado
        $usuario = Auth::user();

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