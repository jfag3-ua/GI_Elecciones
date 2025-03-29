@extends('layouts.app')

@section('title', 'Resultados')

@section('content')
    <!DOCTYPE html>
    <html lang="es">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">

            <title>Resultados</title>

            <style>
                table {
                    width: 100%;
                    border-collapse: collapse;
                    margin-bottom: 20px;
                }
                th, td {
                    border: 1px solid black;
                    padding: 8px;
                    text-align: left;
                }
                th {
                    background-color: #f2f2f2;
                }
                .label-column {
                    text-align: left;
                }
                .divider-row {
                    border-bottom: 3px solid black;
                }

                .text-porcentaje, .text-escano {
                    color: #a41336ff;
                    font-weight: bold;
                }
            </style>

            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        </head>
    
        @php
            $votantes = [];
        @endphp

        <body>
            <h1>Resultados</h1>
            @foreach ($years as $year)

                <h2>Información general sobre las elecciones de {{ $year }}</h2>

                @php
                    $data = json_encode($winners[$year] ?? []);
                    //dd($data);
                @endphp

                @if (isset($info_general[$year]))
                    @foreach ($info_general[$year] as $votos)
                        @php
                            $votantes[$year] = $votos['Votantes'] ?? 0;
                        @endphp

                        
                        <canvas id="mychart"></canvas>

                        <script>
                            document.addEventListener("DOMContentLoaded", function() {
                                const ctx = document.getElementById('mychart').getContext('2d');

                                // Pasar datos de PHP a JavaScript
                                const data = {
                                    labels: ["Partido Popular (PP)", "Partido Socialista Obrero Español (PSOE)", 
                                    "Compromís: Més-Iniciativa-VerdsEquo (COMPROMÍS)", "VOX"],
                                    
                                    datasets: [{
                                        data: [50, 30, 12, 7], // Número de escaños
                                        backgroundColor: ["blue", "red", "orange", "green"]
                                    }
                                ]};

                                const options = {
                                    responsive: true,
                                    cutout: "60%", // Hace que parezca un gráfico semicircular
                                    rotation: -90, // Ajuste de inicio
                                    circumference: 180, // Hace que sea semicircular
                                    plugins: {
                                        legend: {
                                            position: "top",
                                            labels: {
                                                usePointStyle: true
                                            }
                                        },

                                        // Configuración para mostrar los valores
                                        datalabels: {
                                            color: '#fff',
                                            font: {
                                                weight: 'bold',
                                                size: 14
                                            },
                                            
                                            formatter: (value) => {
                                                return value;
                                            },
                                            anchor: 'end',
                                            align: 'start',
                                            offset: -30
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
                                    <td rowspan="2"> Votos Nulos</td>
                                    <td rowspan="2">
                                        {{ number_format($votantes[$year] - $votos['Validos'] ?? 0, 0, ',', '.') }}
                                    </td>
                                    
                                    <td class="text-numero" style="text-align: center;" colspan="3"> - </td>
                                </tr>
                            </tbody>
                        </table>

                    @endforeach
                @endif
            
                <h2>Resultados de las elecciones de {{ $year }}</h2>

                @if (isset($info_votos[$year]))
                    @foreach ($info_votos[$year] as $candidatura)
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
                                            {{ number_format(($votaciones[$i] * 100) / $votantes[$year], 2, ',', '.') }}%
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

            @endforeach

        </body>
    </html>
@endsection
