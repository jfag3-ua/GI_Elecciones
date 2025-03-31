<?php

namespace App\Http\Controllers;

use League\Csv\Reader;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;


class ResultadosController extends Controller
{
    public function index(Request $request)
    {
        if (!file_exists(storage_path('/app/datasets/elections_dataset.csv'))) {
            return redirect()->route('inicio')->with('error', 'No se ha cargado el dataset');
        }
        $csv = Reader::createFromPath(storage_path('/app/datasets/elections_dataset.csv'), 'r');
        $csv->setHeaderOffset(0); 
        $years = array_reverse($csv->getHeader());

        $info_general = [];
        $info_votos = [];
        $info_color = [];
        $winners = [];

        foreach ($csv as $index => $row) {
            foreach ($years as $year) {
                $replacements = ["'" => '"', "d'" => "d "];
                $replacements_v1 = ["'" => '"'];

                $dictionary = json_decode(strtr($row[$year], $replacements), true);
                $dictionary_v1 = json_decode(strtr($row[$year], $replacements_v1), true);

                if ($index == 1) {
                    $info_general[$year][] = $dictionary;
                } elseif ($index == 2) {
                    $info_votos[$year][] = $dictionary;
                } elseif ($index == 3) {
                    $info_color[$year] = $dictionary_v1;
                }
            }
        }

        $info_general = array_reverse($info_general, true);
        $info_votos = array_reverse($info_votos, true);
        $info_color = array_reverse($info_color, true);

        foreach ($years as $year) {
            if (!isset($info_votos[$year])) {
                continue;
            }

            $escanos_partidos = [];
            foreach ($info_votos[$year] as $candidatura) {
                $candidatos_list = $candidatura['Candidato'] ?? [];
                $escanos_list = $candidatura['Escanos'] ?? [];

                for ($i = 0; $i < count($candidatos_list); $i++) {
                    $candidato = $candidatos_list[$i] ?? '/NA';
                    $escanos = $escanos_list[$i] ?? 0;

                    if ($escanos > 0) {
                        $escanos_partidos[$candidato] = $escanos;
                    }
                }
            }


            $background = $info_color[$year]['Background'] ?? [];
            $hover = $info_color[$year]['Hover'] ?? [];

            $data = [
                // Partidos
                'labels' => array_keys($escanos_partidos),
    
                // Escaños
                'datasets' => [[
                    'label' => 'Total de Escaños',
                    'data' => array_values($escanos_partidos),
                    'backgroundColor' => array_values($background),
                    'hoverBackgroundColor' => array_values($hover)
                ]]
            ];

            // Guardar los datos en la variable $winners para pasarlos a la vista
            $winners[$year] = $data;
        }
        // Convertir los años en una colección paginable
        $page = $request->query('page', 1);
        $perPage = 1; // Cantidad de años por página
        $yearsCollection = collect($years);
        $paginatedYears = new LengthAwarePaginator(
            $yearsCollection->forPage($page, $perPage),
            $yearsCollection->count(),
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('resultados', compact('info_general', 'info_votos', 'paginatedYears', 'winners'));
    }
}