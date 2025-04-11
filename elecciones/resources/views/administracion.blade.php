@extends('layouts.app')

@section('title', 'Administrar')

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

    <h2>Administrar</h2>
    <p class="notice">Aquí un administrador puede realizar tareas de control y administración (<b>un administrador no puede votar</b>).</p>

    <h3>Circunscripciones</h3>
    <table>
        <thead>
            <tr>
                <th>Id</th>
                <th>Nombre</th>
                <th>Escaños</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td>Alicante</td>
                <td class="text-escano">35</td>
            </tr>
            <tr>
                <td>2</td>
                <td>Valencia</td>
                <td class="text-escano">40</td>
            </tr>
            <tr>
                <td>3</td>
                <td>Castellón</td>
                <td class="text-escano">24</td>
            </tr>
            <tr>
                <td colspan="2">Total</td>
                <td class="text-escano">99</td>
            </tr>
        </tbody>
    </table>
    
    <h3>Candidaturas</h3>
    <table>
        <thead>
            <tr>
                <th>Id</th>
                <th>Nombre</th>
                <th>Escaños obtenidos</th>
                <th>Id Circunscripción</th>
                <th>Modificar</th>
                <th>Borrar</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td><a href>Modificar</a></td>
                <td><a href>Borrar</a></td>
            </tr>
        </tbody>
    </table>
    <button>Añadir candidatura</button>

    <h3>Candidatos</h3>
    <table>
        <thead>
            <tr>
                <th>Id</th>
                <th>Nombre</th>
                <th>Apellidos</th>
                <th>Elegido</th>
                <th>Id Candidatura</th>
                <th>Modificar</th>
                <th>Borrar</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td><a href>Modificar</a></td>
                <td><a href>Borrar</a></td>
            </tr>
        </tbody>
    </table>
    <button>Añadir candidato</button>
@endsection
