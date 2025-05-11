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

        /* Estilos de la paginación de los años */
        .pagination-container {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        /* Separación entre las dos filas de paginación */
        .pagination-container-year {
            margin-bottom: 20px; /* Añadimos espacio entre la fila de los años y la fila de las páginas */
        }

        .pagination {
            list-style: none;
            display: flex;
            padding: 0;
            margin: 0;
            flex-wrap: wrap; /* Asegura que la paginación se ajuste en pantallas pequeñas */
        }

        .pagination li {
            margin: 0 5px;
        }

        .pagination a {
        text-decoration: none;
        color: #8c0c34; /* texto granate */
        padding: 5px 7px;
        border-radius: 5px;
        background-color: white; /* fondo blanco */
        border: 1px solid #8c0c34;
        transition: background-color 0.3s ease, color 0.3s ease;
        font-size: 14px;
    }

        .pagination a:hover {
            background-color: #8c0c34;
            color: white;
        }

        .pagination .active a {
            background-color: #8c0c34; /* Verde para la página activa */
            color: white;
            border: 1px solid #8c0c34;
        }

        /* Desaparecer flechas cuando no son posibles */
        .pagination .disabled .pagination-arrow {
            display: none;
        }

        /* Estilo de las flechas */
        .pagination-arrow {
            font-size: 18px;
            font-weight: bold;
            color: #007bff;
            text-decoration: none;
            padding: 10px;
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

    {{-- Lista de años disponibles --}}
    <div class="pagination-container-year">
        <ul class="pagination">
            @if ($selectedYear && $years)
                @php
                    $currentYearIndex = array_search($selectedYear, $years);
                @endphp

                {{-- Flecha de Anterior --}}
                @if ($currentYearIndex > 0)
                    <li><a href="{{ route('resultados', ['year' => $years[$currentYearIndex - 1]]) }}" class="pagination-arrow">&#8592;</a></li>
                @else
                    <li class="disabled"><span class="pagination-arrow">&#8592;</span></li>
                @endif

                {{-- Páginas de Años --}}
                @foreach($years as $index => $year_option)
                    <li class="{{ $selectedYear == $year_option ? 'active' : '' }}">
                        <a href="{{ route('resultados', ['year' => $year_option]) }}">{{ $year_option }}</a>
                    </li>
                @endforeach

                {{-- Flecha de Siguiente --}}
                @if ($currentYearIndex < count($years) - 1)
                    <li><a href="{{ route('resultados', ['year' => $years[$currentYearIndex + 1]]) }}" class="pagination-arrow">&#8594;</a></li>
                @else
                    <li class="disabled"><span class="pagination-arrow">&#8594;</span></li>
                @endif
            @endif
        </ul>
    </div>

    <h3>Información general sobre las elecciones de {{ $selectedYear }}</h3>

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
                            {{ number_format(($votos['En blanco'] ?? 0) * 100 / ($votos['Validos'] ?? 0), 2, ',', '.') }}%
                        </td>
                    </tr>

                    <tr class="odd">
                        <td rowspan="1"> Votos Nulos</td>
                        <td rowspan="1">
                            {{ number_format($votantes[$selectedYear] - $votos['Validos'] ?? 0, 0, ',', '.') }}
                        </td>
                        
                        <td class="text-numero" style="text-align: center;" colspan="3"> - </td>
                    </tr>
                </tbody>
            </table>
        @endforeach
    @endif

    <h3>Resultados de las elecciones de {{ $selectedYear }}</h3>

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
