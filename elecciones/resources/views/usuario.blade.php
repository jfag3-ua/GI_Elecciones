@extends('layouts.app')

@section('title', 'Usuario')

@section('content')
    <h2>Usuario</h2>
    <p class="notice">Aquí un usuario podrá ver su información y cerrar sesión.</p>
    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit">Cerrar sesión</button>
    </form>
@endsection
