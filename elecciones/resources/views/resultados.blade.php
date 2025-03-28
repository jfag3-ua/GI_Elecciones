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
            @if (isset($info_general[$year]))
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
                    <tr>
                        @foreach ($info_general[$year] as $votos)
                            <td>{{ $votos['Censo'] ?? 0 }}</td>
                            <td>{{ $votantes = $votos['Votantes'] ?? 0 }}</td>
                            <td>{{ $votos['Abstenciones'] ?? 0 }}</td>
                            <td>{{ $voto_valido = $votos['Validos'] ?? 0 }}</td>
                            <td>{{ $votantes - $voto_valido }}</td>
                            <td>{{ $votos['A candidaturas'] ?? 0 }}</td>
                            <td>{{ $votos['En blanco'] ?? 0 }}</td>
                        @endforeach
                    </tr>
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
                        <th>Escaños</th>
                    </tr>

                    @foreach ($info_votos[$year] as $candidatura)
                        @php
                            $candidatos = $candidatura['Candidato'] ?? [];
                            $votos = $candidatura['Votos'] ?? [];
                            $escanos = $candidatura['Escanos'] ?? [];
                            $count = max(count($candidatos), count($votos), count($escanos));
                        @endphp

                        @for ($i = 0; $i < $count; $i++)
                            <tr>
                                <td>{{ $candidatos[$i] ?? '/NA' }}</td>
                                <td>{{ $votos[$i] ?? 0 }}</td>
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
