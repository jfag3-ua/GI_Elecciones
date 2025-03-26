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
        </style>
    </head>
    <body>
        <h1>Información General de Elecciones</h1>
        @foreach ($years as $year)
            @if (isset($info_votos[$year]))
                <h2>Año: {{ $year }}</h2>
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
                    @foreach ($info_votos[$year] as $votos)
                        <tr>
                            <td>{{ $info_votos[$year]['Censo'] ?? 0 }}</td>
                            <td>{{ $votantes = $votos['Votantes'] ?? 0 }}</td>
                            <td>{{ $votos['Abstenciones'] ?? 0 }}</td>
                            <td>{{ $voto_valido = $votos['Validos'] ?? 0 }}</td>
                            <td>{{ $votantes - $voto_valido }}</td>
                            <td>{{ $votos['A candidaturas'] ?? 0 }}</td>
                            <td>{{ $votos['En blanco'] ?? 0 }}</td>
                        </tr>
                    @endforeach
                </table>
            @endif
        @endforeach
        
        <h1>Resultados por Candidato</h1>
        @foreach ($years as $year)
            @if (isset($info_votos[$year]))
                <h2>Año: {{ $year }}</h2>
                <table>
                    <tr>
                        <th>Candidato</th>
                        <th>Votos</th>
                        <th>Porcentaje</th>
                        <th>Escaños</th>
                    </tr>
                    @foreach ($info_votos[$year] as $candidatura)
                        @foreach ($candidatura as $candidato)
                            <tr>
                                <td>{{ $candidato['Candidato'] ?? '/NA' }}</td>
                                <td>{{ $candidato['Votos'] ?? 1 }}</td>
                                <td>{{ number_format(($candidato['Votos'] ?? 1) * 100 / ($info_general[$year]['Votantes'] ?? 1), 2, ',', '.') }}%</td>
                                <td>{{ $candidato['Escanos'] ?? 'N/A' }}</td>
                            </tr>
                        @endforeach
                    @endforeach
                </table>
            @endif
        @endforeach
    </body>
    </html>
@endsection
