<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\Candidato; // Asegúrate de que el modelo Candidato existe
use App\Models\Candidatura; // Asegúrate de que el modelo Candidatura existe
use App\Models\Circunscripcion; // Asegúrate de que el modelo Circunscripcion existe

class CandidatoController
{
    /* ---------- FORMULARIO DE EDICIÓN ---------- */
    public function editar($id)
    {
        $candidato = DB::table('candidato')->where('idCandidato', $id)->first();

        if (!$candidato) {
            abort(404, 'Candidato no encontrado');
        }

        // Si tu vista de edición también necesita el select de candidaturas:
        $candidaturas = DB::table('candidatura as c')
            ->leftJoin('circunscripcion as ci', 'ci.idCircunscripcion', '=', 'c.idCircunscripcion')
            ->select([
                'c.idCandidatura',
                DB::raw("CONCAT(c.nombre, ' ', ci.nombre) AS nombre_concat")
            ])
            ->orderBy('nombre_concat')
            ->get();

        return view('editar_candidato', compact('candidato', 'candidaturas'));
    }

    /* ---------- ACTUALIZAR CANDIDATO EXISTENTE ---------- */
    public function actualizar(Request $request, $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'nombre'        => 'required|string|max:25',
                'apellidos'     => 'required|string|max:25',
                'nif'           => [
                    'required',
                    'string',
                    'max:50',
                    Rule::unique('candidato', 'nif')->ignore($id, 'idCandidato')
                ],
                'orden'         => [
                    'required',
                    'integer',
                    'min:1',
                    Rule::unique('candidato', 'orden')
                        ->ignore($id, 'idCandidato')
                        ->where(fn ($q) => $q->where('idCandidatura', $request->idCandidatura)),
                ],
                'idCandidatura' => 'required|exists:candidatura,idCandidatura',
            ],
            [
                'nif.unique'   => 'El NIF ya está registrado.',
                'orden.unique' => 'Ese número de orden ya está ocupado en esta candidatura.',
            ]
        );

        $validator->after(function ($validator) use ($request, $id) {
            $candidatura = DB::table('candidatura')
                ->where('idCandidatura', $request->idCandidatura)
                ->first();

            if (!$candidatura) {
                $validator->errors()->add('idCandidatura', 'Candidatura no encontrada.');
                return;
            }

            $escanosProvincia = DB::table('circunscripcion')
                ->where('idCircunscripcion', $candidatura->idCircunscripcion)
                ->value('numEscanyos');

            $totalCandidatos = DB::table('candidato')
                ->where('idCandidatura', $request->idCandidatura)
                ->where('idCandidato', '!=', $id)
                ->count();

            if ($totalCandidatos >= $escanosProvincia) {
                $validator->errors()->add(
                    'idCandidatura',
                    "Límite alcanzado: ya hay $totalCandidatos candidatos y la provincia solo tiene $escanosProvincia escaños."
                );
            }

            if ($request->orden > $escanosProvincia) {
                $validator->errors()->add(
                    'orden',
                    "El orden no puede ser mayor que el número de escaños de la provincia ($escanosProvincia)."
                );
            }
        });

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        DB::table('candidato')
            ->where('idCandidato', $id)
            ->update([
                'nombre'        => $request->nombre,
                'apellidos'     => $request->apellidos,
                'nif'           => $request->nif,
                'orden'         => $request->orden,
                'idCandidatura' => $request->idCandidatura,
            ]);

        return redirect()
            ->route('administracion')
            ->with('successActualizarCandidato', 'El candidato ha sido actualizado correctamente');
    }

    /* ---------- FORMULARIO DE ALTA ---------- */
    public function crear()
    {
        $candidaturas = DB::table('candidatura as c')
            ->leftJoin('circunscripcion as ci', 'ci.idCircunscripcion', '=', 'c.idCircunscripcion')
            ->select([
                'c.idCandidatura',
                DB::raw("CONCAT(c.nombre, ' ', ci.nombre) AS nombre_concat")
            ])
            ->orderBy('nombre_concat')
            ->get();

        return view('crear_candidato', compact('candidaturas'));
    }

    
    /* ---------- GUARDAR NUEVO CANDIDATO ---------- */
    public function guardar(Request $request)
    {
        /* 1) Validación básica, NIF único y ORDEN único por candidatura */
        $validator = Validator::make(
            $request->all(),
            [
                'nombre'        => 'required|string|max:25',
                'apellidos'     => 'required|string|max:25',
                'nif'           => ['required', 'string', 'max:50', Rule::unique('candidato', 'nif')],
                'orden'         => [
                    'required',
                    'integer',
                    'min:1',
                    Rule::unique('candidato', 'orden')
                        ->where(fn ($q) => $q->where('idCandidatura', $request->idCandidatura)),
                ],
                'idCandidatura' => 'required|exists:candidatura,idCandidatura',
            ],
            [
                'nif.unique'   => 'El NIF ya está registrado.',
                'orden.unique' => 'Ese número de orden ya está ocupado en esta candidatura.',
            ]
        );

        /* 2) Regla adicional: no superar los escaños de la provincia */
        $validator->after(function ($validator) use ($request) {

            // 2-a) Datos de la candidatura
            $candidatura = DB::table('candidatura')
                ->where('idCandidatura', $request->idCandidatura)
                ->first();

            if (!$candidatura) {
                $validator->errors()->add('idCandidatura', 'Candidatura no encontrada.');
                return;
            }

            // 2-b) Nº de escaños en la circunscripción
            $escanosProvincia = DB::table('circunscripcion')
                ->where('idCircunscripcion', $candidatura->idCircunscripcion)
                ->value('numEscanyos');   // ajusta si tu campo se llama distinto

            // 2-c) Nº de candidatos ya inscritos para esta candidatura
            $totalCandidatos = DB::table('candidato')
                ->where('idCandidatura', $request->idCandidatura)
                ->count();

            if ($totalCandidatos >= $escanosProvincia) {
                $validator->errors()->add(
                    'idCandidatura',
                    "Límite alcanzado: ya hay $totalCandidatos candidatos y la provincia solo tiene $escanosProvincia escaños."
                );
            }

            if ($request->orden > $escanosProvincia) {
                $validator->errors()->add(
                    'orden',
                    "El orden no puede ser mayor que el número de escaños de la provincia ($escanosProvincia)."
                );
            }
            
        });

        /* 3) Si algo falla, volvemos con errores */
        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        /* 4) Insert cuando todo está OK */
        try {
            DB::table('candidato')->insert([
                'nombre'        => $request->nombre,
                'apellidos'     => $request->apellidos,
                'nif'           => $request->nif,
                'orden'         => $request->orden,
                'idCandidatura' => $request->idCandidatura,
                // 'elegido'     => 0   // si existe la columna y tiene DEFAULT 0
            ]);

            return redirect()
                ->route('administracion')
                ->with('successAnyadirCandidato', 'El candidato ha sido añadido correctamente');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('errorAnyadirCandidato', 'Hubo un error al añadir el candidato: ' . $e->getMessage());
        }
    }


    /* ---------- BORRAR ---------- */
    public function borrar($id)
    {
        DB::table('candidato')->where('idCandidato', $id)->delete();

        return redirect()
            ->route('administracion')
            ->with('successEliminarCandidato', 'El candidato ha sido eliminado correctamente');
    }
    
    public function mostrarProvincias()
    {
        $provincias = DB::table('localizacion')->select('provincia', 'nomProvincia')->distinct()->get();
        return view('provincias', compact('provincias'));
    }
    public function candidatosPorProvincia($provincia)
    {
        $candidatosPorPartido = DB::table('candidato')
            ->join('candidatura', 'candidato.idCandidatura', '=', 'candidatura.idCandidatura')
            ->join('localizacion', 'candidatura.idCircunscripcion', '=', 'localizacion.id')
            ->where('localizacion.provincia', $provincia)
            ->select(
                'candidato.nombre as nombreCandidato',
                'candidato.apellidos',
                'candidatura.nombre as nombrePartido',
                'candidatura.color'
            )
            ->orderBy('nombrePartido')
            ->get()
            ->groupBy('nombrePartido');

        return view('candidatos_por_provincia', compact('candidatosPorPartido', 'provincia'));
    }
}
