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
    
        $years = $csv->getHeader(); // Obtener los años como columnas
        $info_general = [];
        $info_votos = [];
    
        foreach ($csv as $index => $row) {
            foreach ($years as $year) {
                // Decodificar los valores almacenados como diccionario en el CSV
                $dictionary = json_decode(str_replace("'", '"', $row[$year]), true) ?? [];
    
                if ($index == 1) { // Primera fila -> Info General
                    $info_general[$year][] = $dictionary;
                }
                 
                elseif ($index == 2) { // Resto de filas -> Info Votos
                    $info_votos[$year][] = $dictionary;
                }
            }
        }
    
        return view('resultados', compact('info_general', 'info_votos', 'years'));
    }

    public function administracion() {
        return view('administracion');
    }

    public function usuario() {
        return view('usuario');
    }
}