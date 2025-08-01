<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Eleccion;
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
        $usuario = Auth::guard('web')->user();

        $censo = DB::table('censo')
                    ->where('NIF', $usuario->NIF)
                    ->first();

        $direccion = DB::table('direcciones')
                    ->where('IDDIRECCION', $censo->IDDIRECCION)
                    ->first();

        // Obtener la circunscripción en función de la provincia
        $provincia = $direccion->PROVINCIA;
        $idCircunscripcion = null;

        if ($provincia === 'Alicante') {
            $idCircunscripcion = 1;
        } elseif ($provincia === 'Valencia') {
            $idCircunscripcion = 2;
        } elseif ($provincia === 'Castellón') {
            $idCircunscripcion = 3;
        }

        // Obtener las candidaturas correspondientes
        $candidaturas = DB::table('candidatura')
                            ->where('idCircunscripcion', $idCircunscripcion)
                            ->get();

        return view('voto', compact('usuario', 'censo', 'direccion', 'candidaturas'));
    }

    public function predicciones() {
        if (!file_exists(storage_path('/app/datasets/predictions_dataset.csv'))) {
            return redirect()->route('inicio')->with('error', 'No se ha cargado el dataset');
        }

        $csv = Reader::createFromPath(storage_path('/app/datasets/predictions_dataset.csv'), 'r');
        $csv->setHeaderOffset(0); // Usa la primera fila como encabezados

        $years = $csv->getHeader(); // Obtener los años como columnas
        //$years = array_reverse($csv->getHeader()); // Invertir el orden de los años
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
        //$abstencion = array_reverse($abstencion, true);
        //$blanco = array_reverse($blanco, true);
        //$nulo = array_reverse($nulo, true);

        return view('predicciones', compact('abstencion', 'blanco', 'nulo', 'years'));
    }

    public function resultados()
    {
        return view('resultados');
    }

    public function administracion(Request $request)
    {
        $elecciones = Eleccion::all(); // Obtener todas las elecciones

        $query = DB::table('candidatura');
        if ($request->has('eleccion_id') && $request->eleccion_id != '') {
            $query->where('eleccion_id', $request->eleccion_id);
        }

        if ($request->filled('circunscripcion')) {
            $query->where('idCircunscripcion', $request->input('circunscripcion'));
        }
        if ($request->filled('nombre')) {
            $query->where('nombre', 'like', '%' . $request->nombre . '%');
        }

        $candidaturas = $query->paginate(10, ['*'], 'candidaturas_page');

        $query = DB::table('candidato as can')
            ->join('candidatura as c', 'can.idCandidatura', '=', 'c.idCandidatura')
            ->join('circunscripcion as ci', 'c.idCircunscripcion', '=', 'ci.idCircunscripcion')
            ->select([
                'can.idCandidato',
                'can.nombre',
                'can.apellidos',
                'can.nif',
                'can.orden',
                'can.elegido',
                'can.idCandidatura',
                'c.nombre as nombreCandidatura',
                'ci.nombre as provincia',
                'ci.idCircunscripcion' // Asegúrate de seleccionar el id de la circunscripción para el filtro
            ]);
        if ($request->has('eleccion_id') && $request->eleccion_id != '') {
            $query->where('can.eleccion_id', $request->eleccion_id);
        }

        if ($request->filled('circunscripcion_candidatos')) {
            $query->where('ci.idCircunscripcion', $request->input('circunscripcion_candidatos'));
        }

        $candidatos = $query->paginate(10, ['*'], 'candidatos_page');

        return view('administracion', compact('candidaturas','candidatos', 'elecciones')); // Pasar $elecciones a la vista
    }

    public function usuario()
    {
        // Comprobar si hay un usuario autenticado con el guard 'web'
        if (Auth::guard('web')->check()) {
            $usuario = Auth::guard('web')->user();

            $censo = DB::table('censo')
                        ->where('NIF', $usuario->NIF)
                        ->first();

            $direccion = DB::table('direcciones')
                        ->where('IDDIRECCION', $censo->IDDIRECCION)
                        ->first();

            return view('usuario', compact('usuario', 'censo', 'direccion'));
        }

        // Comprobar si hay un usuario autenticado con el guard 'admin'
        if (Auth::guard('admin')->check()) {
            $admin = Auth::guard('admin')->user();

            // Si quieres pasar algo para admin, puedes hacerlo aquí
            return view('usuario', ['admin' => $admin]);
        }

        // Si no hay nadie autenticado, redirigir al login o mostrar error
        return redirect()->route('inicio')->with('error', 'No has iniciado sesión.');
    }
}
