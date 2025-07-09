<?php

namespace App\Http\Controllers;

use App\Models\Candidatura;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Localizacion;
use App\Models\Voto;
use Illuminate\Support\Facades\Log;
use App\Models\Eleccion;

class CandidaturaController extends Controller
{
    // Método para mostrar las candidaturas
    public function votar(Request $request)
    {
        $usuario = Auth::user();

        if ($usuario->votado == 1) {
            return view('voto')->with('votado', true);
        }

        // Obtener todas las elecciones en las que NO ha votado
        $usuarioNIF = $usuario->NIF;
        $eleccionesVotadas = DB::table('voto')
            ->join('candidatura', 'voto.voto', '=', 'candidatura.nombre')
            ->join('usuario', function($join) use ($usuarioNIF) {
                $join->on('usuario.NIF', '=', DB::raw("'$usuarioNIF'"));
            })
            ->select('candidatura.eleccion_id')
            ->distinct()
            ->pluck('candidatura.eleccion_id')
            ->toArray();

        $elecciones = Eleccion::whereNotIn('id', $eleccionesVotadas)->get();
        $eleccion_id = $request->input('eleccion_id');
        $candidaturas = collect();

        if ($eleccion_id) {
            // OPTIMIZACIÓN: Obtener primero la provincia del usuario
            $direccion = DB::table('usuario')
                ->join('censo', 'usuario.NIF', '=', 'censo.NIF')
                ->join('direcciones', 'censo.IDDIRECCION', '=', 'direcciones.IDDIRECCION')
                ->where('usuario.NIF', $usuario->NIF)
                ->select('direcciones.PROVINCIA')
                ->first();

            $circunscripcion = null;
            if ($direccion) {
                $circunscripcion = DB::table('circunscripcion')
                    ->where('NOMBRE', $direccion->PROVINCIA)
                    ->first();
            }

            if ($circunscripcion) {
                $candidaturas = DB::table('candidatura')
                    ->where('idCircunscripcion', $circunscripcion->idCircunscripcion)
                    ->where('eleccion_id', $eleccion_id)
                    ->get();
            }
        }

        return view('voto', compact('candidaturas', 'elecciones', 'eleccion_id'));
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

        // Si no existe la localización, la creamos automáticamente
        if (!$localizacion) {
            $localizacion_id = DB::table('localizacion')->insertGetId([
                'nomProvincia' => $direccion->PROVINCIA,
                'provincia'    => $direccion->PROVINCIA,
                'ciudad'       => $direccion->CIUDAD,
                'codpos'       => $direccion->CPOSTAL,
            ]);
        } else {
            $localizacion_id = $localizacion->id;
        }

        // Crear el voto
        $voto = new Voto();
        $voto->voto = $request->input('candidato');  // Guardamos el nombre del candidato en el campo 'voto'
        $voto->localizacion_id = $localizacion_id;   // Guardamos el localizacion_id
        // Guardar el voto en la base de datos
        $voto->save();

        // Obtener la candidatura votada
        $candidatura = \App\Models\Candidatura::where('nombre', $request->input('candidato'))->first();

        // Obtener la elección asociada
        $eleccion = null;
        if ($candidatura && $candidatura->eleccion_id) {
            $eleccion = \App\Models\Eleccion::find($candidatura->eleccion_id);
        }

        // Enviar correo al usuario
        if ($usuario->correo) {
            \Mail::to($usuario->correo)->send(new \App\Mail\VotoConfirmado($candidatura, $eleccion, now()));
        }

        $usuario->votado = 1;
        $usuario->save();

        // Redirigir con mensaje de éxito
        return redirect()->route('voto')->with('successVotoRegistrado', 'Tu voto ha sido registrado correctamente');
    }

    // Mostrar el formulario de edición
    public function editar($id, Request $request)
    {
        // 1. Obtener la candidatura que se está editando
        $candidatura = DB::table('candidatura')->where('idCandidatura', $id)->first();

        if (!$candidatura) {
            abort(404, 'Candidatura no encontrada');
        }

        // Obtener el eleccion_id de la candidatura actual
        $idCandidaturaActual = $candidatura->idCandidatura;
        $eleccionIdActual = $candidatura->eleccion_id; // Asegúrate de que este campo exista en tu tabla 'candidatura'

        // 2. Definir las circunscripciones de forma fija en el controlador
        // Esto es el equivalente a lo que tenías en tu @php de la vista
        $circunscripciones = [
            1 => 'Alicante',
            2 => 'Valencia',
            3 => 'Castellón'
        ];

        // 3. Construir la consulta para los candidatos
        $queryCandidatos = DB::table('candidato as can')
            ->join('candidatura as c', 'can.idCandidatura', '=', 'c.idCandidatura')
            // No necesitas un join a 'circunscripcion' aquí si 'ci.nombre' no es necesario para la tabla,
            // pero si necesitas el nombre de la provincia para mostrarlo en la tabla,
            // y 'can.provincia' no existe, la unión es necesaria.
            // Si can.provincia ya guarda el nombre, no hace falta el join a circunscripción.
            // Si can.idCircunscripcion guarda el ID, y quieres el nombre, sí necesitas el join o mapear.
            // Para mantener la compatibilidad con tu vista:
            ->join('circunscripcion as ci', 'c.idCircunscripcion', '=', 'ci.idCircunscripcion') // Asumo que `c.idCircunscripcion` es el int que te relaciona.
            ->select([
                'can.idCandidato',
                'can.nombre',
                'can.apellidos',
                'can.nif',
                'can.orden',
                'can.elegido',
                'can.idCandidatura',
                'c.nombre as nombreCandidatura',
                'ci.nombre as provincia', // Obtiene el nombre de la provincia de la tabla 'circunscripcion'
                'ci.idCircunscripcion',   // Necesario para el filtro de circunscripción por ID
                'can.eleccion_id'
            ]);

        // 4. Aplicar los filtros obligatorios (idCandidatura y eleccion_id de la candidatura actual)
        $queryCandidatos->where('can.idCandidatura', $idCandidaturaActual);
        $queryCandidatos->where('can.eleccion_id', $eleccionIdActual);


        // 5. Aplicar filtros opcionales de la tabla (nombre, circunscripción)
        if ($request->filled('nombre_candidato')) {
            $queryCandidatos->where('can.nombre', 'like', '%' . $request->input('nombre_candidato') . '%');
        }

        if ($request->filled('circunscripcion_candidatos')) {
            // Aquí, 'circunscripcion_candidatos' del request es el ID (1, 2, 3)
            // Y el campo en tu tabla `candidato` o `candidatura` que guarda ese ID es `idCircunscripcion`.
            // Asumo que es `ci.idCircunscripcion` si el join a `circunscripcion` es válido,
            // o `c.idCircunscripcion` si el candidato tiene una relación directa con la circunscripción a través de la candidatura.
            $queryCandidatos->where('ci.idCircunscripcion', $request->input('circunscripcion_candidatos'));
        }

        // 6. Obtener los candidatos paginados
        $candidatos = $queryCandidatos->paginate(10, ['*'], 'candidatos_page');


        return view('editar_candidatura', compact('candidatura', 'candidatos', 'circunscripciones'));
    }

    // Guardar los cambios
    public function actualizar(Request $request, $id)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'color' => 'required|string|max:255',
            'idCircunscripcion' => 'required|in:1,2,3',
            'color'  => ['required', 'regex:/^#[A-Fa-f0-9]{6}$/'],
        ]);

        DB::table('candidatura')
            ->where('idCandidatura', $id)
            ->update([
                'nombre' => $validated['nombre'],
                'color' => $validated['color'],
                'idCircunscripcion' => $validated['idCircunscripcion'],
                'color' => $validated['color']
            ]);

        return redirect()->route('administracion')->with('successActualizar', 'La candidatura ha sido actualizada correctamente');
    }

    public function crear($id)
    {
        return view('anyadir_candidatura',['eleccion_id' => $id]);
    }

    public function guardar(Request $request)
    {

   
        $request->validate([
            'nombre' => 'required|string|max:255',
            'color' => 'required|string|max:255',
            'idCircunscripcion' => 'required|integer',
            'eleccion_id' => 'nullable|integer|exists:elecciones,id',
        ]);

        Candidatura::create([
            'nombre' => $request->nombre,
            'color' => $request->color,
            'idCircunscripcion' => $request->idCircunscripcion,
            'escanyosElegidos' => 0,
            'eleccion_id' => $request->input('eleccion_id')
        ]);

        return redirect()->route('administracion', ['eleccion_id' => $request->input('eleccion_id')])->with('successAnyadir', 'La candidatura ha sido añadida correctamente');
    }

    public function eliminar($id)
    {
        Candidatura::destroy($id); // o Candidatura::find($id)->delete();
        return redirect()->route('administracion')->with('successEliminar', 'La candidatura ha sido eliminada correctamente');
    }


}
