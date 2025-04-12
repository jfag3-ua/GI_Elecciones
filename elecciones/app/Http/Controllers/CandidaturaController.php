<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CandidaturaController extends Controller
{
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

        return redirect()->route('administracion')->with('success', 'La candidatura ha sido actualizada correctamente');
    }
}
