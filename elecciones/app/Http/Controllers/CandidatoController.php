<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CandidatoController
{
    public function editar($id)
    {
        $candidato = DB::table('candidato')->where('idCandidato', $id)->first();

        if (!$candidato) {
            abort(404, 'Candidato no encontrado');
        }

        return view('editar_candidato', compact('candidato'));
    }

    public function actualizar(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|max:25',
            'apellidos' => 'required|max:25',
            'elegido' => 'required|boolean',
            'idCandidatura' => 'required|integer',
        ]);

        DB::table('candidato')->where('idCandidato', $id)->update([
            'nombre' => $request->nombre,
            'apellidos' => $request->apellidos,
            'elegido' => $request->elegido,
            'idCandidatura' => $request->idCandidatura,
        ]);

        return redirect()->route('administracion')->with('successActualizarCandidato', 'El candidato ha sido actualizado correctamente');
    }
    public function crear()
    {
        $candidaturas = DB::table('candidatura')->get(); // para el <select>
        return view('crear_candidato', compact('candidaturas'));
    }
    public function guardar(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:25',
            'apellidos' => 'required|string|max:25',
            'elegido' => 'required|boolean',
            'idCandidatura' => 'required|exists:candidatura,idCandidatura',
        ]);

        DB::table('candidato')->insert([
            'nombre' => $request->nombre,
            'apellidos' => $request->apellidos,
            'elegido' => $request->elegido,
            'idCandidatura' => $request->idCandidatura,
        ]);

        return redirect()->route('administracion')->with('successAnyadirCandidato', 'El candidato ha sido añadido correctamente');
    }
    public function borrar($id)
    {
        DB::table('candidato')->where('idCandidato', $id)->delete();

        return redirect()->route('administracion')->with('successEliminarCandidato', 'El candidato ha sido eliminado correctamente');
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
