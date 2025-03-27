@extends('layouts.app')

@section('title', 'Administrar')

@section('content')
    <h2>Administrar</h2>
    <p class="notice">Aquí un administrador podrá realizar tareas de control y administración.</p>
    
    <div class="button-container" style="display: flex; justify-content: center; gap: 10px;">
        <button onclick="window.location.href='{{ route('candidato') }}'" class="btn btn-primary">Candidato</button>
        <button onclick="window.location.href='{{ route('candidatura') }}'" class="btn btn-primary">Candidatura</button>
    </div>
@endsection