@extends('layouts.app')

@section('title', 'Usuario')

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
    </style>  

    @auth('web')
        <h2>Usuario</h2>

        <table>
            <thead>
                <tr>
                    <th>Datos</th>
                    <th>Valores</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Nombre de usuario</td>
                    <td>{{ $usuario->NOMBREUSUARIO }}</td>
                </tr>
                <tr>
                    <td>NIF</td>
                    <td>{{ $censo->NIF }}</td>
                </tr>
                <tr>
                    <td>Nombre</td>
                    <td>{{ $censo->NOMBRE }}</td>
                </tr>
                <tr>
                    <td>Apellidos</td>
                    <td>{{ $censo->APELLIDOS }}</td>
                </tr>
                <tr>
                    <td>Fecha de nacimiento</td>
                    <td>{{ $censo->FECHANAC }}</td>
                </tr>
                <tr>
                    <td>Sexo</td>
                    <td>{{ $censo->SEXO }}</td>
                </tr>
                <tr>
                    <td>Dirección</td>
                    <td>
                        {{ $direccion->NOMVIA }}, Nº {{ $direccion->NUMERO }},
                        @if($direccion->BIS) {{ $direccion->BIS}}, @endif
                        @if($direccion->PISO) Piso {{ $direccion->PISO }}, @endif
                        @if($direccion->BLOQUE) Bloque {{ $direccion->BLOQUE }}, @endif
                        @if($direccion->PUERTA) Puerta {{ $direccion->PUERTA}}, @endif
                        {{ $direccion->CIUDAD }}, {{ $direccion->PROVINCIA }}, {{ $direccion->CPOSTAL }}
                    </td>
                </tr>
            </tbody>
        </table>
    @endauth

    @auth('admin')
        <h2>Administrador</h2>

        <table>
            <thead>
                <tr>
                    <th>Datos</th>
                    <th>Valores</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>NIF</td>
                    <td>{{ $admin->NIF }}</td>
                </tr>
                <tr>
                    <td>Nombre de usuario</td>
                    <td>{{ $admin->NOMBREUSUARIO }}</td>
                </tr>
            </tbody>
        </table>
    @endauth

    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit">Cerrar sesión</button>
    </form>
@endsection
