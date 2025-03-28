@extends('layouts.app')

@section('title', 'Resultados')

@section('content')
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Datos de Elecciones</title>
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
        </style>
    </head>
    <body>
        @php
            $votantes = [];
        @endphp

        @foreach ($years as $year)
            @if (isset($info_general[$year]))
                <h1>Información General de Elecciones {{ $year }}</h1>
                <table class="responsive-enabled table table-hover table-striped" data-striping="1" data-once="tableresponsive">
                    @foreach ($info_general[$year] as $votos)
                        <thead>
                            <tr>
                                <th colspan="3">Información general sobre las elecciones</th>
                                <th class="text-right">Número</th>
                                <th class="text-right">Porcentaje</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr>
                                <td rowspan="2">Censo</td>
                                <td rowspan="2">{{ number_format($votos['Censo'] ?? 0, 0, ',', '.') }}</td>
                                <td>Votantes</td>
                                <td class="text-right">{{ number_format($votos['Votantes'] ?? 0, 0, ',', '.') }}</td>
                                <td class="text-right">{{ number_format(($votos['Votantes'] ?? 0) * 100 / ($votos['Censo'] ?? 0), 2, ',', '.') }}%</td>
                            </tr>

                            @php
                                $votantes[$year] = $votos['Votantes'] ?? 0;
                            @endphp

                            <tr>
                                <td>Abstenciones</td>
                                <td class="text-right">{{ number_format($votos['Abstenciones'] ?? 0, 0, ',', '.') }}</td>
                                <td class="text-right">{{ number_format(($votos['Abstenciones'] ?? 0) * 100 / ($votos['Censo'] ?? 0), 2, ',', '.') }}%</td>
                            </tr>

                            <tr>
                                <td rowspan="2">Válidos</td>
                                <td rowspan="2">{{ number_format($votos['Validos'] ?? 0, 0, ',', '.') }}</td>
                                <td>A candidaturas</td>
                                <td class="text-right">{{ number_format($votos['A candidaturas'] ?? 0, 0, ',', '.') }}</td>
                                <td class="text-right">{{ number_format(($votos['A candidaturas'] ?? 0) * 100 / ($votos['Validos'] ?? 0), 2, ',', '.') }}%</td>
                            </tr>

                            <tr class="even">
                                <td>En blanco</td>
                                <td class="text-right">{{ number_format($votos['En blanco'] ?? 0, 0, ',', '.') }}</td>
                                <td class="text-right">{{ number_format(($votos['En blanco'] ?? 0) * 100 / ($votos['Validos'] ?? 0), 2, ',', '.') }}%</td>
                            </tr>

                            <tr class="even">
                                <td rowspan="2" colspan="2">Nulos</td>
                            </tr>
                            <tr class="odd">
                                <td rowspan="2" colspan="2">{{ number_format($votantes[$year] - $votos['Validos'] ?? 0, 0, ',', '.') }}</td>
                                <td class="text-right"> - </td>
                            </tr>
                        </tbody>
                    @endforeach
                </table>

                <table>
                    <tr>
                        <th>Censo</th>
                        <th>Votantes</th>
                        <th>Abstenciones</th>
                        <th>Válidos</th>
                        <th>Nulos</th>
                        <th>A Candidaturas</th>
                        <th>En Blanco</th>
                    </tr>
                    <tr>
                        @foreach ($info_general[$year] as $votos)
                            <td>{{ number_format($votos['Censo'] ?? 0, 0, ',', '.') }}</td>
                            <td>{{ number_format($votos['Votantes'] ?? 0, 0, ',', '.') }}</td>

                            @php
                                $votantes[$year] = $votos['Votantes'] ?? 0;
                            @endphp

                            <td>{{ number_format($votos['Abstenciones'] ?? 0, 0, ',', '.') }}</td>
                            <td>{{ number_format($votos['Validos'] ?? 0, 0, ',', '.') }}</td>
                            <td>{{ number_format($votantes[$year] - $votos['Validos'] ?? 0, 0, ',', '.') }}</td>
                            <td>{{ number_format($votos['A candidaturas'] ?? 0, 0, ',', '.') }}</td>
                            <td>{{ number_format($votos['En blanco'] ?? 0, 0, ',', '.') }}</td>
                        @endforeach
                    </tr>
                </table>
            @endif
        
            <h1>Resultados de las Elecciones {{ $year }}</h1>
            @if (isset($info_votos[$year]))
                <table>
                    <tr>
                        <th>Candidato</th>
                        <th>Votos</th>
                        <th>Porcentaje</th>
                        <th>Escaños</th>
                    </tr>

                    @foreach ($info_votos[$year] as $candidatura)
                        @php
                            $candidatos = $candidatura['Candidato'] ?? [];
                            $votaciones = $candidatura['Votos'] ?? [];
                            $escanos = $candidatura['Escanos'] ?? [];
                            $count = max(count($candidatos), count($votaciones), count($escanos));
                        @endphp

                        @for ($i = 0; $i < $count; $i++)
                            <tr>
                                <td>{{ $candidatos[$i] ?? '/NA' }}</td>
                                <td>{{ number_format($votaciones[$i] ?? 0, 0, ',', '.') }}</td>
                                <td>{{ number_format(($votaciones[$i] * 100) / $votantes[$year], 2, ',', '.') }}%</td>
                                <td>{{ $escanos[$i] ?? 0 }}</td>
                            </tr>
                        @endfor
                    @endforeach
                </table>
            @endif
        @endforeach
    </body>
    </html>
@endsection
