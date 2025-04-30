<?php

namespace App\Http\Controllers;

use App\Models\Candidatura;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Localizacion;
use App\Models\Voto;
use Illuminate\Support\Facades\Log;

class CandidaturaController extends Controller
{
    // Método para mostrar las candidaturas
    public function votar()
    {
        // Obtener el usuario autenticado
        $usuario = Auth::user();

        // Verificar si el usuario ya ha votado
        if ($usuario->votado == 1) {
            // Si ya ha votado, redirigir a la vista de resultados o mostrar un mensaje
            return view('voto')->with('votado', true);  // Puedes pasar una variable 'votado' para mostrar el mensaje en la vista
        }

        // Obtener todas las candidaturas desde la base de datos, ordenadas por nombre
        $candidaturas = DB::table('usuario')
            ->join('censo', 'usuario.NIF', '=', 'censo.NIF')  // Cruza con censo por NIF
            ->join('direcciones', 'censo.IDDIRECCION', '=', 'direcciones.IDDIRECCION')  // Cruza con direcciones por IDDIRECCION
            ->join('circunscripcion', 'direcciones.PROVINCIA', '=', 'circunscripcion.Nombre')  // Cruza con circunscripcion por PROVINCIA
            ->join('candidatura', 'circunscripcion.idCircunscripcion', '=', 'candidatura.idCircunscripcion')  // Cruza con candidaturas por idCircunscripcion
            ->where('usuario.NIF', auth()->user()->NIF)  // Filtra por el NIF del usuario autenticado
            ->select('candidatura.*')  // Selecciona las candidaturas correspondientes
            ->get();

        // Pasar la variable $candidaturas a la vista 'voto'
        return view('voto', compact('candidaturas'));
    }

    // Guardar el voto
    public function guardarVoto(Request $request)
    {
        Log::info('Datos recibidos:', $request->all());
        // Validar que el candidato seleccionado existe
        $validated = $request->validate([
            'candidato' => 'required|exists:candidatura,nombre', // Validar que el candidato existe en la tabla 'candidatura'
        ]);

        // Obtener los datos del usuario autenticado (provincia, ciudad y código postal)
        $usuario = Auth::user();

        // Realizar la consulta para obtener los datos de dirección del usuario
        $direccion = DB::table('usuario')
        ->join('censo', 'usuario.NIF', '=', 'censo.NIF')  // Cruza con censo por NIF
        ->join('direcciones', 'censo.IDDIRECCION', '=', 'direcciones.IDDIRECCION')  // Cruza con direcciones por IDDIRECCION
        ->where('usuario.NIF', $usuario->NIF)  // Filtra por el NIF del usuario autenticado
        ->select('direcciones.PROVINCIA', 'direcciones.CPOSTAL', 'direcciones.CIUDAD')  // Selecciona los datos necesarios
        ->first();  // Tomamos solo el primer resultado

        // Verificar si se ha encontrado una dirección
        if (!$direccion) {
            dd('No se encontró una dirección válida para el usuario.');
            return redirect()->route('voto')->with('error', 'No se encontró una dirección válida para tu voto.');
        }

        // Realizar la consulta para obtener la localización que coincide con los datos de la dirección
        $localizacion = DB::table('localizacion')
            ->where('nomProvincia', $direccion->PROVINCIA)  // Coincide con 'nomProvincia' en la tabla 'localizacion'
            ->where('ciudad', $direccion->CIUDAD)  // Coincide con 'ciudad' en la tabla 'localizacion'
            ->where('codpos', $direccion->CPOSTAL)  // Coincide con 'codpos' en la tabla 'localizacion'
            ->first();  // Tomamos el primer resultado

        // Verificar si se ha encontrado una localización
        if (!$localizacion) {
            dd('No se encontró una localización válida en la tabla localizacion.');
            return redirect()->route('voto')->with('error', 'No se encontró una localización válida para tu voto.');
        }

        // Obtener el id de la localización
        $localizacion_id = $localizacion->id;
        
        // Crear el voto
        $voto = new Voto();
        $voto->voto = $request->input('candidato');  // Guardamos el nombre del candidato en el campo 'voto'
        $voto->localizacion_id = $localizacion_id;   // Guardamos el localizacion_id
        // Guardar el voto en la base de datos
        $voto->save();

        $usuario->votado = 1;
        $usuario->save();

        // Redirigir con mensaje de éxito
        return redirect()->route('voto')->with('successVotoRegistrado', 'Tu voto ha sido registrado correctamente');
    }

    // Mostrar el formulario de edición
    public function editar($id)
    {
        $candidatura = DB::table('candidatura')->where('idCandidatura', $id)->first();

        if (!$candidatura) {
            abort(404, 'Candidatura no encontrada');
        }

        return view('editar_candidatura', compact('candidatura'));
    }

    // Guardar los cambios
    public function actualizar(Request $request, $id)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'idCircunscripcion' => 'required|in:1,2,3',
        ]);

        DB::table('candidatura')
            ->where('idCandidatura', $id)
            ->update([
                'nombre' => $validated['nombre'],
                'idCircunscripcion' => $validated['idCircunscripcion'],
            ]);

        return redirect()->route('administracion')->with('successActualizar', 'La candidatura ha sido actualizada correctamente');
    }

    public function crear()
    {
        return view('anyadir_candidatura');
    }

    public function guardar(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'idCircunscripcion' => 'required|integer'
        ]);

        Candidatura::create([
            'nombre' => $request->nombre,
            'idCircunscripcion' => $request->idCircunscripcion,
            'escanyosElegidos' => 0
        ]);

        return redirect()->route('administracion')->with('successAnyadir', 'La candidatura ha sido añadida correctamente');
    }

    public function eliminar($id)
    {
        Candidatura::destroy($id); // o Candidatura::find($id)->delete();
        return redirect()->route('administracion')->with('successEliminar', 'La candidatura ha sido eliminada correctamente');
    }
}
