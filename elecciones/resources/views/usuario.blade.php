@extends('layouts.app')

@section('title', 'Usuario')

@section('content')
    <h2>Usuario</h2>

    <table>
        <tbody>
            <tr>
                <td><b>Nombre de usuario</b></td>
                <td>{{ $usuario->NOMBREUSUARIO }}</td>
            </tr>
            <tr>
                <td><b>NIF</b></td>
                <td>{{ $censo->NIF }}</td>
            </tr>
            <tr>
                <td><b>Nombre</b></td>
                <td>{{ $censo->NOMBRE }}</td>
            </tr>
            <tr>
                <td><b>Apellidos</b></td>
                <td>{{ $censo->APELLIDOS }}</td>
            </tr>
            <tr>
                <td><b>Fecha de nacimiento</b></td>
                <td>{{ $censo->FECHANAC }}</td>
            </tr>
            <tr>
                <td><b>Sexo</b></td>
                <td>{{ $censo->SEXO }}</td>
            </tr>
            <tr>
                <td><b>Dirección</b></td>
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

    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit">Cerrar sesión</button>
    </form>
@endsection
