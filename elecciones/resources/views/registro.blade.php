@extends('layouts.app')

@section('title', 'Registrarse')

@section('content')
    <h2>Registrarse</h2>
    <p class="notice">
        Es imprescindible que estés <b>censado</b>, si no, el sistema no te permitirá registrarte.
    </p>
    <form action="{{ route('registro2') }}" method="POST">
        @csrf
        <div>
            <label for="NIF">NIF</label>
            <input type="text" name="NIF" id="NIF" required>
            @error('NIF')
                <div style="color: red;">{{ $message }}</div>
            @enderror
        </div>
        <div>
            <label for="clave">Clave de registro</label>
            <input type="text" name="clave" id="clave" required>
            @error('clave')
                <div style="color: red;">{{ $message }}</div>
            @enderror
        </div>
        <div>
            <label for="nombreUsuario">Nombre de usuario</label>
            <input type="text" name="nombreUsuario" id="nombreUsuario"  required>
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
