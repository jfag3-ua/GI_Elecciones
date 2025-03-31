<?php

namespace App\Http\Controllers;

use League\Csv\Reader;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;


class ResultadosController extends Controller
{
    public function index(Request $request, $year = null)  
    {
        if (!file_exists(storage_path('/app/datasets/elections_dataset.csv'))) {
            return redirect()->route('inicio')->with('error', 'No se ha cargado el dataset');
        }

        $csv = Reader::createFromPath(storage_path('/app/datasets/elections_dataset.csv'), 'r');
        $csv->setHeaderOffset(0);
        $years = array_reverse($csv->getHeader()); // Lista de años

        $info_general = [];
        $info_votos = [];
        $info_color = [];
        $winners = [];

        foreach ($csv as $index => $row) {
            foreach ($years as $year_key) {
                $replacements = ["'" => '"', "d'" => "d "];
                $replacements_v1 = ["'" => '"'];

                $dictionary = json_decode(strtr($row[$year_key], $replacements), true);
                $dictionary_v1 = json_decode(strtr($row[$year_key], $replacements_v1), true);

                if ($index == 1) {
                    $info_general[$year_key][] = $dictionary;
                } elseif ($index == 2) {
                    $info_votos[$year_key][] = $dictionary;
                } elseif ($index == 3) {
                    $info_color[$year_key] = $dictionary_v1;
                }
            }
        }

        $info_general = array_reverse($info_general, true);
        $info_votos = array_reverse($info_votos, true);
        $info_color = array_reverse($info_color, true);

        foreach ($years as $year_key) {
            if (!isset($info_votos[$year_key])) {
                continue;
            }

            $escanos_partidos = [];
            foreach ($info_votos[$year_key] as $candidatura) {
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

            $background = $info_color[$year_key]['Background'] ?? [];
            $hover = $info_color[$year_key]['Hover'] ?? [];

            $data = [
                'labels' => array_keys($escanos_partidos),
                'datasets' => [[
                    'label' => 'Total de Escaños',
                    'data' => array_values($escanos_partidos),
                    'backgroundColor' => array_values($background),
                    'hoverBackgroundColor' => array_values($hover)
                ]]
            ];

            $winners[$year_key] = $data;
        }

        // Verificar que el año recibido esté en la lista de años válidos
        $selectedYear = in_array($year, $years) ? $year : ($years[0] ?? null);

        return view('resultados', compact('info_general', 'info_votos', 'winners', 'years', 'selectedYear'));
    }


}