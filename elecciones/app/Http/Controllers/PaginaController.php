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
        return view('resultados');
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