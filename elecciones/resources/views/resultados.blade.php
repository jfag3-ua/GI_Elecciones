@extends('layouts.app')

@section('title', 'Resultados')

@section('content')
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
            color: #8c0c34;
            font-weight: bold;
        }
        .chart-container {
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 20px 0;
        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    @php
        $votantes = [];
    @endphp

    <h2>Resultados</h2>

    {{-- Lista de años disponibles --}}
    <div>
        @foreach ($years as $year)
            <a href="{{ route('resultados', ['year' => $year]) }}" 
            class="{{ $year == $selectedYear ? 'font-bold' : '' }}" 
            style="margin-right: 10px;">
                {{ $year }}
            </a>
        @endforeach
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

