<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        return view('encuestas');
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
    
        return view('resultados', compact('info_general', 'info_votos', 'years'));
    }

    public function administracion() {
        return view('administracion');
    }

    public function usuario() {
        return view('usuario');
    }
}