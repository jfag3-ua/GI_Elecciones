<?php

namespace App\Http\Controllers;

use League\Csv\Reader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;


class ResultadosController extends Controller
{
    const HONDT_CONSTRAIN = 0.05;

    private function electedParty($info_votos, $votantes_total) {
        $elected = [];

        foreach ($info_votos as $candidato => $data) {
            $votos = $data['Votos'];
            $porcentaje = floor((($votos * 100) / $votantes_total) * 100) / 100;

            if ($porcentaje > (self::HONDT_CONSTRAIN * 100)) {
                $elected[$candidato] = $votos;
            }
        }

        return $elected;
    }

    private function asignarEscanos($votos, $escanos) {
        $cocientes = [];

        foreach ($votos as $partido => $num_votos) {
            for ($i = 1; $i <= $escanos; $i++) {
                $cocientes[] = [
                    'valor' => $num_votos / $i,
                    'partido' => $partido
                ];
            }
        }

        // Ordenar de mayor a menor
        usort($cocientes, fn($a, $b) => $b['valor'] <=> $a['valor']);

        // Asignar Escaños a los Partidos
        $resultado = [];
        foreach (array_keys($votos) as $partido) {
            $resultado[$partido] = 0;
        }

        for ($i = 0; $i < $escanos; $i++) {
            $ganador = $cocientes[$i]['partido'];
            $resultado[$ganador]++;
        }


        return $resultado;
    }

    private function getDatos()
    {
        $candidatos = [];
        $votos = [];
        $escanos = [];

        // Datos para la Infromación General de las elecciones
        $censo = DB::table('censo')->count();        
        $votantes = DB::table('usuario')->where('votado', 1)->count();
        $abstenciones = $censo - $votantes;

        // Datos de TODOS los partidos con TODOS sus votos
        $info_elecciones = DB::table('voto_completo')
            ->select('voto as partido', DB::raw('SUM(total_votos) as votos'))
            ->groupBy('voto')
            ->orderByDesc('votos')
            ->get();

        $elecciones = $info_elecciones->mapWithKeys(function ($item) {
            return [
                $item->partido => [
                    'Votos' => $item->votos,
                    'Escanos' => 0
                ]
            ];
        })->toArray();

        // EXTRAER datos de los ESCANOS
        $select_escanos = DB::table('circunscripcion')
            ->select(
                'nombre as provincia',
                'numEscanyos as escanos'
            )
            ->get();
        
        $num_escanos = $select_escanos->mapWithKeys(function ($item) {
            return [
                $item->provincia => $item->escanos,    
            ];
        })->toArray();

        // EXTRAER datos de los VOTANTES
        $info_votantes = DB::table('voto_completo')
            ->select('nomProvincia as provincia', DB::raw('SUM(total_votos) as votantes'))
            ->groupBy('nomProvincia')
            ->orderByDesc('votantes')
            ->get();

        $votantes_provincia = $info_votantes->mapWithKeys(function ($item) {
            return [
                $item->provincia => $item->votantes,    
            ];
        })->toArray();

        // EXTRAER datos de los PARTIDOS VOTADOS
        $info_provincias = DB::table('voto_completo')
            ->select(
                'voto as partido',
                'nomProvincia as provincia',
                'total_votos as votos'
            )
            ->orderByDesc('total_votos')
            ->get();
        
        $provincia_votos = [];
        foreach ($info_provincias as $item) {
            $provincia = $item->provincia;
            $partido = $item->partido;
            $votos = $item->votos;

            if (!isset($provincia_votos[$provincia])) {
                $provincia_votos[$provincia] = [];
            }

            $provincia_votos[$provincia][$partido] = [
                'Votos' => $votos
            ];
        }
        
        // EXTRAER datos de los partidos votados en ALICANTE
        // Este proceso solo devuelve los partidos electos que han conseguido escaños, junto al valor de los mismos
        $elected = $this->electedParty($provincia_votos['Alicante'], $votantes_provincia['Alicante']);
        $alicante = $this->asignarEscanos($elected, $num_escanos['Alicante']);

        // EXTRAER datos de los partidos votados en VALENCIA
        // Este proceso solo devuelve los partidos electos que han conseguido escaños, junto al valor de los mismos
        $elected = $this->electedParty($provincia_votos['Valencia'], $votantes_provincia['Valencia']);
        $valencia = $this->asignarEscanos($elected, $num_escanos['Valencia']);

        // EXTRAER datos de los partidos votados en CASTELLON
        // Este proceso solo devuelve los partidos electos que han conseguido escaños, junto al valor de los mismos
        $elected = $this->electedParty($provincia_votos['Castellón'], $votantes_provincia['Castellón']);
        $castellon = $this->asignarEscanos($elected, $num_escanos['Castellón']);

        // SUMA de escaños con el total de partidos y sus respectivos votos
        foreach ($elecciones as $partido => $dato) {
            $escanos = 0;
            $escanos += $alicante[$partido] ?? 0;
            $escanos += $valencia[$partido] ?? 0;
            $escanos += $castellon[$partido] ?? 0;

            $elecciones[$partido] = [
                'Votos' => $dato['Votos'],
                'Escanos' => $escanos
            ];
        }

        // COMPROVACION de si hay partidos sin votos para unirlos al resultado
        $nombres = DB::table('candidatura')->groupBy('nombre', 'color')->pluck('color', 'nombre')->toArray();
        foreach ($nombres as $partido => $color) {
            if (!array_key_exists($partido, $elecciones)) {
                $elecciones[$partido] = [
                    'Votos' => 0,
                    'Escanos' => 0
                ];
            }
        }
        
        // Datos para los RESULTADOS DE LAS ELECCIONES
        $candidatos = array_keys($elecciones);
        $votos = array_column($elecciones, 'Votos');
        $escanos = array_column($elecciones, 'Escanos');

        // Extraer los colores de los partidos que se van a mostrar por pantalla
        $escanos_partidos = [];
        $background = [];
        $hover = [];
        foreach ($elecciones as $partido => $lista_valor)  {
            $esc = $lista_valor['Escanos'];

            if ($esc > 0) {
                $escanos_partidos[$partido] = $esc;

                // Si no se encuentra el color, usa uno por defecto
                $color = $nombres[$partido] ?? '#D3D3D3';
                $background[] = $color;
                $hover[] = '#D3D3D3';
            }
        }

        // Array de datos a consumir
        return [
            'new_general' => [
                'Actual' => [[
                    'Censo' => $censo,
                    'Votantes' => $votantes,
                    'Abstenciones' => $abstenciones,

                    'Validos' => $votantes,
                    'A candidaturas' => $votantes,
                    'En blanco' => 0
                ]]
            ],

            'new_votos' => [
                'Actual' => [[
                    'Candidato' => $candidatos,
                    'Votos' => $votos,
                    'Escanos' => $escanos,
                ]]
            ],

            'new_winners' => [
                'Actual' => [
                    'labels' => array_keys($escanos_partidos),
                    'datasets' => [[
                        'label' => 'Total de Escaños',
                        'data' => array_values($escanos_partidos),
                        'backgroundColor' => array_values($background),
                        'hoverBackgroundColor' => array_values($hover)
                    ]]
                ]
            ]
        ];
    }

    public function index(Request $request, $year = null)  
    {
        if (!file_exists(storage_path('/app/datasets/elections_dataset.csv'))) {
            return redirect()->route('inicio')->with('error', 'No se ha cargado el dataset');
        }

        $csv = Reader::createFromPath(storage_path('/app/datasets/elections_dataset.csv'), 'r');
        $csv->setHeaderOffset(0);
        $years = array_reverse($csv->getHeader()); // Lista de años

        // Obtener los datos adicionales desde otro "módulo"
        $datos_extra = $this->getDatos();

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
        $info_general = $datos_extra['new_general'] + $info_general;

        $info_votos = array_reverse($info_votos, true);
        $info_votos = $datos_extra['new_votos'] + $info_votos;

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

        array_unshift($years, 'Actual');
        $winners = $datos_extra['new_winners'] + $winners;

        // Verificar que el año recibido esté en la lista de años válidos
        $selectedYear = in_array($year, $years) ? $year : ($years[0] ?? null);

        return view('resultados', compact('info_general', 'info_votos', 'winners', 'years', 'selectedYear'));
    }


}