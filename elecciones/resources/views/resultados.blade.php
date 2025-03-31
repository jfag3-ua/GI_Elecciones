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

    @foreach ($paginatedYears as $year)
        <h3>Información general sobre las elecciones de {{ $year }}</h3>

        @php
            $data = json_encode($winners[$year] ?? []);
        @endphp

        @if (isset($info_general[$year]))
            @foreach ($info_general[$year] as $votos)
                @php
                    $votantes[$year] = $votos['Votantes'] ?? 0;
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
                        <tr>
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
                    </tbody>
                </table>
            @endforeach
        @endif

        <h3>Resultados de las elecciones de {{ $year }}</h3>

        @if (isset($winners[$year]))
            <div class="chart-container">
                <canvas id="chart-{{ $year }}"></canvas>
            </div>

            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    const ctx = document.getElementById('chart-{{ $year }}').getContext('2d');
                    const readData = {!! json_encode($winners[$year]) !!};

                    new Chart(ctx, {
                        type: 'doughnut',
                        data: {
                            labels: readData.labels,
                            datasets: readData.datasets
                        },
                        options: {
                            responsive: true,
                            cutout: "60%", 
                            rotation: -90, 
                            circumference: 180
                        }
                    });
                });
            </script>
        @endif
    @endforeach

    {{-- Controles de paginación --}}
    <div>
        {{ $paginatedYears->links() }}
    </div>
@endsection