@extends('layouts.app')

@section('title', 'Resultados')

@section('content')
    <style>
        /* Estilos generales de las tablas */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px; /* Aumentamos el margen entre las tablas */
            font-family: 'Arial', sans-serif;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
            color: #333;
        }
        .label-column {
            text-align: left;
        }
        .divider-row {
            border-bottom: 3px solid #000;
        }
        .text-porcentaje, .text-escano {
            color: #8c0c34;
            font-weight: bold;
        }

        /* Contenedor de los gráficos */
        .chart-container {
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 40px 0;
        }

        .pagination-wrapper {
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none !important; 
            gap: 10px;
            margin-bottom: 25px;
            overflow: hidden; /* evita que sobresalga nada */
            height: auto;
        }

        .year-scroll {
            overflow-x: auto;
            white-space: nowrap;
            max-width: 80vw;
            scrollbar-width: none;
            -webkit-overflow-scrolling: touch;
            height: auto;
        }

        .year-scroll::-webkit-scrollbar {
            display: none;
        }

        .pagination {
            display: inline-flex;
            gap: 10px;
            padding: 0;
            margin: 0;
            list-style: none;
            align-items: center;
        }

        .pagination li {
            flex: 0 0 auto;
        }

        .pagination a {
            text-decoration: none;
            color: #8c0c34;
            padding: 8px 12px;
            border-radius: 6px;
            background-color: white;
            border: 1px solid #8c0c34;
            font-size: 14px;
            font-weight: 500;
            line-height: 1.5;
            display: inline-block;
            height: 38px;
            box-sizing: border-box;
        }

        .pagination a:hover {
            background-color: #8c0c34;
            color: white;
        }

        .pagination .active a {
            background-color: #8c0c34;
            color: white;
            border: 2px solid #5a0b24;
            font-weight: bold;
            box-shadow: 0 2px 6px rgba(0,0,0,0.2);
        }

        .pagination-arrow {
            font-size: 18px;
            font-weight: bold;
            color: #8c0c34;
            padding: 8px 12px;
            border: 1px solid #8c0c34;
            border-radius: 6px;
            background-color: white;
            transition: background-color 0.3s ease;
            cursor: pointer;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 38px;
        }

        .pagination-arrow:hover {
            background-color: #8c0c34;
            color: white;
        }

        .pagination-arrow.disabled {
            opacity: 0.4;
            pointer-events: none;
        }


        /* Hacer la paginación más compacta en pantallas pequeñas */
        @media (max-width: 600px) {
            .pagination a {
                padding: 8px 12px;
                font-size: 12px;
            }
        }

        /* Aumentamos el espacio entre las filas de la tabla */
        .table-row {
            margin-bottom: 20px; /* Añadimos espacio entre las filas */
        }

    </style>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <h2>Resultados</h2>

    <div class="pagination-wrapper">
        {{-- Flecha anterior --}}
        @if ($selectedYear && $years && array_search($selectedYear, $years) > 0)
            <a href="{{ route('resultados', ['year' => $years[array_search($selectedYear, $years) - 1]]) }}" class="pagination-arrow">&#8592;</a>
        @endif

        {{-- Contenedor scrollable --}}
        <div class="year-scroll">
            <ul class="pagination">
                @foreach($years as $year)
                    <li class="{{ ($selectedYear == $year || (!$selectedYear && strtolower($year) === 'actual')) ? 'active' : '' }}">
                        <a href="{{ route('resultados', ['year' => $year]) }}">{{ $year }}</a>
                    </li>
                @endforeach
            </ul>
        </div>

        {{-- Flecha siguiente --}}
        @if ($selectedYear && $years && array_search($selectedYear, $years) < count($years) - 1)
            <a href="{{ route('resultados', ['year' => $years[array_search($selectedYear, $years) + 1]]) }}" class="pagination-arrow">&#8594;</a>
        @endif
    </div>

    @if ($selectedYear == 'Actual')
        <h3>Datos Electorales - Elecciones Actuales</h3>
    @else
        <h3>Datos Electorales - Elecciones en {{ $selectedYear }}</h3>
    @endif

    @if (isset($winners[$selectedYear]))
        <div class="chart-container">
            <canvas id="chart-{{ $selectedYear }}"></canvas>
        </div>

        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const ctx = document.getElementById('chart-{{ $selectedYear }}').getContext('2d');
                const readData = {!! json_encode($winners[$selectedYear] ?? []) !!};

                const data = {
                    labels: readData.labels,
                    datasets: readData.datasets
                };

                const options = {
                    responsive: true,
                    cutout: "60%", 
                    rotation: -90, 
                    circumference: 180,
                    plugins: {
                        legend: {
                            position: "top",
                            labels: {
                                usePointStyle: true
                            }
                        },

                        title:{
                            display: true,   
                            text: "99",
                            color: "#000",
                            font: {
                                size: 30,
                                weight: "bold"
                            },
                            position: "bottom"
                        }
                    }
                };

                new Chart(ctx, {
                    type: 'doughnut',
                    data: data,
                    options: options
                });

            });
        </script>
    @endif

    @if ($selectedYear == 'Actual')
        <h3>Información general de las elecciones Actuales</h3>
    @else
        <h3>Información general de las elecciones de {{ $selectedYear }}</h3>
    @endif

    @php
        $data = json_encode($winners[$selectedYear] ?? []);
    @endphp

    @if (isset($info_general[$selectedYear]))
        @foreach ($info_general[$selectedYear] as $votos)
            @php
                $votantes[$selectedYear] = $votos['Votantes'] ?? 0;
            @endphp

            <table>
                <thead>
                    <tr>
                        <th colspan="3">Información general sobre las elecciones</th>
                        <th>Número</th>
                        <th>Porcentaje</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="odd">
                        <td rowspan="2">Censo</td>
                        <td class="text-numero" rowspan="2">
                            {{ number_format($votos['Censo'] ?? 0, 0, ',', '.') }}
                        </td>

                        <td>Votantes</td>
                        <td class="text-numero">
                            {{ number_format($votos['Votantes'] ?? 0, 0, ',', '.') }}
                        </td>
                        <td class="text-porcentaje">
                            {{ number_format(($votos['Votantes'] ?? 0) * 100 / ($votos['Censo'] ?? 0), 2, ',', '.') }}%
                        </td>
                    </tr>

                    <tr class="even">
                        <td>Abstenciones</td>
                        <td class="text-numero">
                            {{ number_format($votos['Abstenciones'] ?? 0, 0, ',', '.') }}
                        </td>
                        <td class="text-porcentaje">
                            {{ number_format(($votos['Abstenciones'] ?? 0) * 100 / ($votos['Censo'] ?? 0), 2, ',', '.') }}%
                        </td>
                    </tr>

                    <tr class="odd">
                        <td rowspan="2">Votos Válidos</td>
                        <td class="text-numero" rowspan="2">
                            {{ number_format($votos['Validos'] ?? 0, 0, ',', '.') }}
                        </td>

                        <td>A candidaturas</td>
                        <td class="text-numero">
                            {{ number_format($votos['A candidaturas'] ?? 0, 0, ',', '.') }}
                        </td>
                        <td class="text-porcentaje">
                            {{ number_format(($votos['A candidaturas'] ?? 0) * 100 / ($votos['Validos'] ?? 0), 2, ',', '.') }}%
                        </td>
                    </tr>

                    <tr class="even">
                        <td>En blanco</td>
                        <td class="text-numero">
                            {{ number_format($votos['En blanco'] ?? 0, 0, ',', '.') }}
                        </td>
                        <td class="text-porcentaje">
                            @if ($selectedYear == 'Actual')
                                0,00%
                            @else
                                {{ number_format(($votos['En blanco'] ?? 0) * 100 / ($votos['Validos'] ?? 0), 2, ',', '.') }}%
                            @endif
                        </td>
                    </tr>

                    <tr class="odd">
                        <td rowspan="1"> Votos Nulos</td>
                        <td rowspan="1">
                            @if ($selectedYear == 'Actual')
                                -
                            @else
                                {{ number_format($votantes[$selectedYear] - $votos['Validos'] ?? 0, 0, ',', '.') }}
                            @endif
                        </td>
                        
                        <td class="text-numero" style="text-align: center;" colspan="3"> - </td>
                    </tr>
                </tbody>
            </table>
        @endforeach
    @endif

    @if ($selectedYear == 'Actual')
        <h3>Resultados de las elecciones Actuales</h3>
    @else
        <h3>Resultados de las elecciones de {{ $selectedYear }}</h3>
    @endif

    @if (isset($info_votos[$selectedYear]))
        @foreach ($info_votos[$selectedYear] as $candidatura)
            @php
                $candidatos = $candidatura['Candidato'] ?? [];
                $votaciones = $candidatura['Votos'] ?? [];
                $escanos = $candidatura['Escanos'] ?? [];
                $count = max(count($candidatos), count($votaciones), count($escanos));
            @endphp

            <table>
                <thead>
                    <tr>
                        <th>Candidato</th>
                        <th>Votos</th>
                        <th>Porcentaje</th>
                        <th>Escaños</th>
                    </tr>
                </thead>
                <tbody>                  
                    @for ($i = 0; $i < $count; $i++)
                        <tr>
                            <td>
                                {{ $candidatos[$i] ?? '/NA' }}
                            </td>

                            <td class="text-numero">
                                {{ number_format($votaciones[$i] ?? 0, 0, ',', '.') }}
                            </td>

                            <td>
                                {{ number_format(($votaciones[$i] * 100) / $votantes[$selectedYear], 2, ',', '.') }}%
                            </td>

                            <td class="text-escano">
                                {{ $escanos[$i] ?? 0 }}
                            </td>
                        </tr>
                    @endfor
                </tbody>
            </table>
        @endforeach
    @endif
@endsection
