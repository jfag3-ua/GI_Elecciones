@extends('layouts.app')

@section('title', 'Encuestas')

@section('content')
<!DOCTYPE html>
    <html lang="es">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">

            <title>Encuestas</title>

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
            $predicciones = [];
        @endphp

        <body>
            <h1>Predicciones para 2027</h1>

            <table>

                <thead>
                    <tr>
                        <th>Año de Elecciones</th>
                        <th>Abstenciones</th>
                        <th>Votos en blanco</th>
                        <th>Votos Nulos</th>
                    </tr>
                </thead>

                <tbody> 
                    @foreach ($years as $year)
                        <tr>  
                            <td>
                                {{ $val = $year ?? 0 }}
                            </td>

                            @if (isset($abstencion[$year]))
                                @foreach ($abstencion[$year] as $abs)
                                    @php
                                        if ($val == 2027) {
                                            $predicciones['Abstenciones'] = $abs ?? 0;
                                        }
                                    @endphp
                                    
                                    <td>
                                        {{ $abs ?? 0 }}
                                    </td>
                                @endforeach
                            @endif
                            @if (isset($blanco[$year]))
                                @foreach ($blanco[$year] as $bn)
                                    @php
                                        if ($val == 2027) {
                                            $predicciones['En blanco'] = $bn ?? 0;
                                        }
                                    @endphp
                                    
                                    <td>
                                        {{ $bn ?? 0}}
                                    </td>
                                @endforeach
                            @endif
                            @if (isset($nulo[$year]))
                                @foreach ($nulo[$year] as $nl)
                                    @php
                                        if ($val == 2027) {
                                            $predicciones['Nulos'] = $nl ?? 0;
                                        }
                                    @endphp
                                    
                                    <td>
                                        {{ $nl ?? 0 }}
                                    </td>
                                @endforeach
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </body>
    </html>
@endsection
