<?php

namespace App\Http\Controllers;

use App\Models\Candidatura;
use Illuminate\Http\Request;

class CandidaturaController extends Controller
{
    // Método para mostrar las candidaturas
    public function votar()
    {
        // Obtener todas las candidaturas desde la base de datos, ordenadas por nombre
        $candidaturas = Candidatura::orderBy('nombre')->get();

        // Pasar la variable $candidaturas a la vista 'voto'
        return view('voto', compact('candidaturas'));
    }

    // Guardar el voto
    public function guardarVoto(Request $request)
    {
        // Validar que el candidato seleccionado existe
        $validated = $request->validate([
            'candidato' => 'required|exists:candidatura,id', // Asegurarse de que el candidato existe
        ]);

        // Obtener el id de la provincia del usuario autenticado
        $provincia_id = Auth::user()->provincia_id; // Si el usuario tiene un campo provincia_id

        // Guardar el voto en la base de datos
        $voto = new Voto();
        $voto->candidato_id = $request->input('candidato'); // ID del candidato
        $voto->provincia_id = $provincia_id; // ID de la provincia
        $voto->save();

        // Redirigir al usuario a la página de votación con un mensaje de éxito
        return redirect()->route('voto')->with('success', 'Tu voto ha sido registrado correctamente.');
    }
}
