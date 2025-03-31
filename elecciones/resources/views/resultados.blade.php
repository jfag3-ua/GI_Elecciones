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
        .chart-container {
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 20px 0;
        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <h2>Resultados</h2>

    {{-- Verificar si la variable está definida --}}
    @if (!isset($yearsPaginated) || $yearsPaginated->isEmpty())
        <p>No hay datos disponibles.</p>
    @else
        @foreach ($yearsPaginated as $year)
            <h3>Información general sobre las elecciones de {{ $year }}</h3>

            @if (isset($info_general[$year]))
                @foreach ($info_general[$year] as $votos)
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
                                <td rowspan="2">{{ number_format($votos['Censo'] ?? 0, 0, ',', '.') }}</td>
                                <td>Votantes</td>
                                <td>{{ number_format($votos['Votantes'] ?? 0, 0, ',', '.') }}</td>
                                <td>
                                    @php
                                        $censo = $votos['Censo'] ?? 0;
                                        $votantes = $votos['Votantes'] ?? 0;
                                        $porcentaje = $censo > 0 ? ($votantes * 100 / $censo) : 0;
                                    @endphp
                                    {{ number_format($porcentaje, 2, ',', '.') }}%
                                </td>
                            </tr>
                        </tbody>
                    </table>
                @endforeach
            @endif

            @if (isset($winners[$year]))
                <h3>Resultados de las elecciones de {{ $year }}</h3>
                <div class="chart-container">
                    <canvas id="chart-{{ $year }}"></canvas>
                </div>
            @endif
        @endforeach

        {{-- Enlaces de paginación --}}
        <div class="pagination">
            {{ $yearsPaginated->links('pagination::bootstrap-4') }}
        </div>

        {{-- Script para los gráficos --}}
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                @foreach ($yearsPaginated as $year)
                    const ctx{{ $year }} = document.getElementById('chart-{{ $year }}').getContext('2d');
                    const data{{ $year }} = {!! json_encode($winners[$year] ?? []) !!};

                    if (data{{ $year }} && Object.keys(data{{ $year }}).length > 0) {
                        new Chart(ctx{{ $year }}, {
                            type: 'doughnut',
                            data: {
                                labels: Object.keys(data{{ $year }}),
                                datasets: [{
                                    data: Object.values(data{{ $year }}),
                                    backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF'],
                                }]
                            },
                            options: { responsive: true }
                        });
                    }
                @endforeach
            });
        </script>
    @endif
@endsection
