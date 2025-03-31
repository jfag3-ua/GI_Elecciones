<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class ResultadosController extends Controller
{
    public function index(Request $request)
    {
        // Simulación de datos (debes reemplazar con datos reales)
        $info_general = [
            2020 => [['Censo' => 500000, 'Votantes' => 350000]],
            2024 => [['Censo' => 520000, 'Votantes' => 370000]],
        ];
        
        $winners = [
            2020 => ['Partido A' => 45, 'Partido B' => 35, 'Partido C' => 20],
            2024 => ['Partido A' => 50, 'Partido B' => 30, 'Partido C' => 20],
        ];

        $info_votos = []; // Datos adicionales si los tienes.

        // Obtener los años con elecciones disponibles
        $years = array_keys($info_general);

        // Configurar la paginación
        $perPage = 1; // Número de años por página
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $currentYears = array_slice($years, ($currentPage - 1) * $perPage, $perPage);

        // Crear la paginación
        $yearsPaginated = new LengthAwarePaginator(
            $currentYears,
            count($years),
            $perPage,
            $currentPage,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        // Asegurar que la variable se está pasando a la vista
        return view('resultados', [
            'yearsPaginated' => $yearsPaginated,
            'info_general' => $info_general,
            'winners' => $winners,
            'info_votos' => $info_votos
        ]);
    }
}
