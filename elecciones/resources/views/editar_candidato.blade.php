@extends('layouts.app')

@section('title', 'Editar candidato')

@section('content')
<h2>Editar candidato</h2>

@if (session('success'))
<div style="color: green;">{{ session('success') }}</div>
@endif

<form method="POST" action="{{ route('candidato.actualizar', $candidato->idCandidato) }}">
    @csrf
    <div>
        <label>ID:</label>
        <input type="text" value="{{ $candidato->idCandidato }}" disabled>
    </div>
    <div>
        <label>Nombre:</label>
        <input type="text" name="nombre" value="{{ $candidato->nombre }}" required>
    </div>
    <div>
        <label>Apellidos:</label>
        <input type="text" name="apellidos" value="{{ $candidato->apellidos }}" required>
    </div>
    <div>
        <label>Elegido:</label>
        <select name="elegido" required>
            <option value="0" {{ $candidato->elegido == 0 ? 'selected' : '' }}>No</option>
            <option value="1" {{ $candidato->elegido == 1 ? 'selected' : '' }}>Sí</option>
        </select>
    </div>
    <div>
        <label>Candidatura:</label>
        <select name="idCandidatura" required>
            @php
            $candidaturas = DB::table('candidatura')->pluck('nombre', 'idCandidatura');
            @endphp
            @foreach ($candidaturas as $id => $nombre)
            <option value="{{ $id }}" {{ $candidato->idCandidatura == $id ? 'selected' : '' }}>
                {{ $nombre }}
            </option>
            @endforeach
        </select>
    </div>
    <div>
        <button type="submit">Guardar cambios</button>
        <a href="{{ url()->previous() }}">
            <button type="button">Cancelar</button>
        </a>
    </div>

</form>
@endsection
