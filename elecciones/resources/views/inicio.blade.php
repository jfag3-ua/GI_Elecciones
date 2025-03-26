@extends('layouts.app')

@section('title', 'Iniciar sesión')

@section('content')
    <h2>Iniciar sesión</h2>
    <form action="{{ route('login') }}" method="POST">
        @csrf
        <div>
            <label for="NombreUsuario">Nombre de Usuario</label>
            <input type="text" name="NombreUsuario" id="NombreUsuario" required>
        </div>
        <div>
            <label for="password">Contraseña</label>
            <input type="password" name="password" id="password" required>
        </div>
        <div>
            <button type="submit">Iniciar sesión</button>
        </div>
    </form>

    
    @if($errors->any())
        <div>
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
@endsection
