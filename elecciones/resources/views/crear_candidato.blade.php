@extends('layouts.app')

@section('title', 'Crear candidato')

@section('content')
<h2>Crear nuevo candidato</h2>

{{-- ✅ 1. Bloque global de errores --}}
@if ($errors->any())
    <div style="color:#b91c1c; border:1px solid #b91c1c; padding:12px; margin-bottom:20px;">
        <strong>Se encontraron errores:</strong>
        <ul style="margin:6px 0 0 20px;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

{{-- ✅ 2. Mensaje del catch (cuando salta la excepción) --}}
@if (session('errorAnyadirCandidato'))
    <div style="color:#b91c1c; border:1px solid #b91c1c; padding:12px; margin-bottom:20px;">
        {{ session('errorAnyadirCandidato') }}
    </div>
@endif

{{-- ✅ 3. Mensaje de éxito (redirige desde el controlador si todo va bien) --}}
@if (session('successAnyadirCandidato'))
    <div style="color:#16a34a; border:1px solid #16a34a; padding:12px; margin-bottom:20px;">
        {{ session('successAnyadirCandidato') }}
    </div>
@endif

<form method="POST" action="{{ route('candidato.guardar') }}">
    @csrf
    <input type="hidden" name="eleccion_id" value="{{ $eleccion_id }}">
    {{-- Nombre --}}
    <div>
        <label>Nombre:</label>
        <input type="text" name="nombre" value="{{ old('nombre') }}" required>
        @error('nombre')
            <div style="color:#b91c1c;">{{ $message }}</div>
        @enderror
    </div>

    {{-- Apellidos --}}
    <div>
        <label>Apellidos:</label>
        <input type="text" name="apellidos" value="{{ old('apellidos') }}" required>
        @error('apellidos')
            <div style="color:#b91c1c;">{{ $message }}</div>
        @enderror
    </div>

    {{-- NIF --}}
    <div>
        <label>NIF:</label>
        <input type="text" name="nif" value="{{ old('nif') }}" required>
        @error('nif')
            <div style="color:#b91c1c;">{{ $message }}</div>
        @enderror
    </div>

    {{-- Orden elecciones --}}
    <div>
        <label>Orden elecciones:</label>
        <input type="number" name="orden" value="{{ old('orden') }}" min="1" required>
        @error('orden')
            <div style="color:#b91c1c;">{{ $message }}</div>
        @enderror
    </div>

    {{-- Candidatura --}}
    <div>
        <label>Candidatura:</label>
        <select name="idCandidatura" required>
            @foreach ($candidaturas as $candidatura)
                <option value="{{ $candidatura->idCandidatura }}"
                        {{ old('idCandidatura') == $candidatura->idCandidatura ? 'selected' : '' }}>
                    {{ $candidatura->nombre_concat }}
                </option>
            @endforeach
        </select>
        @error('idCandidatura')
            <div style="color:#b91c1c;">{{ $message }}</div>
        @enderror
    </div>

    {{-- Botones --}}
    <div style="margin-top:16px;">
        <button type="submit">Crear</button>
        <a href="{{ url()->previous() }}">
            <button type="button">Cancelar</button>
        </a>
    </div>
</form>
@endsection
