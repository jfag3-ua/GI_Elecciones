@extends('layouts.app')

@section('title', 'Registrarse')

@section('content')
    <h2>Registrarse</h2>
    <!-- resources/views/registro.blade.php -->
<h2>Registro de Usuario</h2>
<form action="{{ route('registro2') }}" method="POST">
    @csrf
    <div>
        <label for="NIF">NIF</label>
        <input type="text" name="NIF" id="NIF" required>
        <label for="NIF">NIF:</label>
@error('NIF')
    <div style="color: red;">{{ $message }}</div>
@enderror

    </div>
    <div>
        <label for="nombreUsuario">Nombre de Usuario</label>
        <input type="text" name="nombreUsuario" id="nombreUsuario"  required>
        <label for="NIF">NIF:</label>
@error('nombreUsuario')
    <div style="color: red;">{{ $message }}</div>
@enderror

    </div>
    <div>
        <label for="password">Contraseña</label>
        <input type="password" name="password" id="password" required>
    </div>
    <div>
        <button type="submit">Registrarse</button>
    </div>
</form>

@endsection
