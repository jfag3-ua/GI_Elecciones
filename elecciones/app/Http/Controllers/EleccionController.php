<?php

namespace App\Http\Controllers;

use App\Models\Eleccion;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rule;

class EleccionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function getEleccionesForDropdown()
    {
        $elecciones = Eleccion::orderBy('fecha_inicio', 'desc')->get(['id', 'nombre']);
        return response()->json($elecciones);
    }
    public function getFechasEleccion($id)
    {
        $eleccion = Eleccion::findOrFail($id);
        return response()->json([
            'fecha_inicio' => $eleccion->fecha_inicio ? $eleccion->fecha_inicio->toDateString() : null,
            'fecha_fin' => $eleccion->fecha_fin ? $eleccion->fecha_fin->toDateString() : null,
            'fecha_campana_inicio' => $eleccion->fecha_campana_inicio ? $eleccion->fecha_campana_inicio->toDateString() : null,
            'fecha_campana_fin' => $eleccion->fecha_campana_fin ? $eleccion->fecha_campana_fin->toDateString() : null,
            'fecha_elecciones' => $eleccion->fecha_elecciones ? $eleccion->fecha_elecciones->toDateString() : null,
        ]);
    }
    public function mostrarCalendario(): View
    {
        $elecciones = \App\Models\Eleccion::all();
        return view('elecciones.calendario', compact('elecciones'));
    }

    public function index(): View
    {
        $elecciones = Eleccion::orderBy('fecha_inicio', 'desc')->paginate(10); // Paginación para no cargar demasiados registros
        return view('elecciones.index', compact('elecciones'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('elecciones.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nombre' => 'required|string|max:255|unique:elecciones,nombre',
            'fecha_inicio' => 'required|date|before:fecha_fin',
            'fecha_fin' => 'required|date|after:fecha_inicio',
            'fecha_campana_inicio' => 'nullable|date|before:fecha_inicio',
            'fecha_campana_fin' => 'nullable|date|before:fecha_inicio', //Lo cambié, tiene sentido que sea antes
            'fecha_elecciones' => 'nullable|date|after:fecha_fin', // Esto también lo cambié
            'activa' => 'boolean',
            'votos_nulos' => 'integer|min:0',
            'abstenciones' => 'integer|min:0',
        ]);

        Eleccion::create($request->all());

        return redirect()->route('elecciones.index')->with('success', 'Elección creada correctamente.');
    }


    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $eleccion = Eleccion::findOrFail($id);
        return view('elecciones.show', compact('eleccion'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $eleccion = Eleccion::findOrFail($id);
        return view('elecciones.edit', compact('eleccion'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        $eleccion = Eleccion::findOrFail($id);

        $request->validate([
            'nombre' => ['required', 'string', 'max:255', Rule::unique('elecciones')->ignore($eleccion)],
            'fecha_inicio' => 'required|date|before:fecha_fin',
            'fecha_fin' => 'required|date|after:fecha_inicio',
            'fecha_campana_inicio' => 'nullable|date|before:fecha_inicio',
            'fecha_campana_fin' => 'nullable|date|before:fecha_inicio',  //Lo cambié
            'fecha_elecciones' => 'nullable|date|after:fecha_fin', //Lo cambié
            'activa' => 'boolean',
            'votos_nulos' => 'integer|min:0',
            'abstenciones' => 'integer|min:0',
        ]);

        $eleccion->update($request->all());

        return redirect()->route('elecciones.index')->with('success', 'Elección actualizada correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): RedirectResponse
    {
        $eleccion = Eleccion::findOrFail($id);
        $eleccion->delete();
        return redirect()->route('elecciones.index')->with('success', 'Elección eliminada correctamente.');
    }
}
?>
