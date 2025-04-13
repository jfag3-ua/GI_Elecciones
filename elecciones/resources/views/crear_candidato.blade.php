@extends('layouts.app')

@section('title', 'Crear candidato')

@section('content')
<h2>Crear nuevo candidato</h2>

<form method="POST" action="{{ route('candidato.guardar') }}">
    @csrf
    <div>
        <label>Nombre:</label>
        <input type="text" name="nombre" value="{{ old('nombre') }}" required>
    </div>
    <div>
        <label>Apellidos:</label>
        <input type="text" name="apellidos" value="{{ old('apellidos') }}" required>
    </div>
    <div>
        <label>Elegido:</label>
        <select name="elegido" required>
            <option value="0" {{ old('elegido') == "0" ? 'selected' : '' }}>No</option>
            <option value="1" {{ old('elegido') == "1" ? 'selected' : '' }}>Sí</option>
        </select>
    </div>
    <div>
        <label>Candidatura:</label>
        <select name="idCandidatura" required>
            @foreach ($candidaturas as $candidatura)
            <option value="{{ $candidatura->idCandidatura }}" {{ old('idCandidatura') == $candidatura->idCandidatura ? 'selected' : '' }}>
            {{ $candidatura->nombre }}
            </option>
            @endforeach
        </select>
    </div>
    <div>
        <button type="submit">Crear</button>
        <a href="{{ url()->previous() }}">
            <button type="button">Cancelar</button>
        </a>
    </div>
</form>
@endsection
