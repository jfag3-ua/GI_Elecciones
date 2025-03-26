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

    public function administracion() {
        return view('administracion');
    }

    public function usuario() {
        return view('usuario');
    }
}