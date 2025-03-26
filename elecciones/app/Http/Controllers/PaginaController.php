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

    /*
    public function resultados() {
        if (!file_exists(storage_path('/app/datasets/elections_dataset.csv'))) {
            return redirect()->route('inicio')->with('error', 'No se ha cargado el dataset');
        }

        $csv = Reader::createFromPath(storage_path('/app/datasets/elections_dataset.csv'), 'r');
        $csv->setHeaderOffset(0); // Usa la primera fila como encabezados

        $info_general = [];
        $info_votos = [];

        foreach ($csv as $row => $index) {
            foreach ($row as $key => $value) {
                $row[$key] = json_decode($value, true) ?? $value; // Convertir diccionarios
            }

            if ($row['Votantes'] == null) { // Primera fila -> Info General
                $info_general = $row;
            } else { // Resto de filas -> Info Votos
                $info_votos[] = $row;
            }
        }
        
        foreach ($csv as $key => $row) {
            foreach ($row as $year) {
                $dictionary = json_decode($row[$year], true) ?? [];

                if ($index == 0) { // Primera fila -> Info General
                    $info_general[$year] = $dictionary;
                } else { // Resto de filas -> Info Votos
                    $info_votos[$year][] = $dictionary;
                }
            }
        }

        // Agregar votos nulos a info_general
        foreach ($info_general as $year => $data) {
            $votantes = $data['Votantes'] ?? 0;
            $voto_valido = $data['Validos'] ?? 0;
            $info_general[$year]['Nulos'] = $votantes - $voto_valido;
        }

        return view('datos', compact('info_general', 'info_votos', 'years'));
    }
    */

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
    
                if ($index == 0) { // Primera fila -> Info General
                    $info_general[$year] = $dictionary;
                } else { // Resto de filas -> Info Votos
                    $info_votos[$year][] = $dictionary;
                }
            }
        }
    
        // Agregar votos nulos a info_general
        foreach ($info_general as $year => $data) {
            $votantes = $data['Votantes'] ?? 0;
            $voto_valido = $data['Validos'] ?? 0;
            $info_general[$year]['Nulos'] = $votantes - $voto_valido;
        }
    
        return view('resultados', compact('info_general', 'info_votos', 'years'));
    }

    /*
    public function resultados() {
        if (!file_exists(storage_path('/app/datasets/elections_dataset.csv'))) {
            return redirect()->route('inicio')->with('error', 'No se ha cargado el dataset');
        }

        $csv = Reader::createFromPath(storage_path('/app/datasets/elections_dataset.csv'), 'r');
        $csv->setHeaderOffset(0); // Usa la primera fila como encabezados
    
        $data = [];
        foreach ($csv as $row) {
            foreach ($row as $key => $value) {
                $row[$key] = json_decode($value, true) ?? $value; // Convertir diccionarios
            }
            $data[] = $row;
        }
    
        return view('resultados', compact('data'));
    }
        */

    public function administracion() {
        return view('administracion');
    }

    public function usuario() {
        return view('usuario');
    }
}