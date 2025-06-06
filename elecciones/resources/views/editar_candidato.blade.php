@extends('layouts.app')

@section('title', 'Editar candidato')

@section('content')
<h2>Editar candidato</h2>

{{-- ✅ Errores de validación --}}
@if ($errors->any())
    <div style="color: #b91c1c; border: 1px solid #b91c1c; padding: 12px; margin-bottom: 20px;">
        <strong>Se encontraron errores:</strong>
        <ul style="margin: 6px 0 0 20px;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

{{-- ✅ Mensaje de éxito --}}
@if (session('successActualizarCandidato'))
    <div style="color: green;">{{ session('successActualizarCandidato') }}</div>
@endif

<form method="POST" action="{{ route('candidato.actualizar', $candidato->idCandidato) }}">
    @csrf

    {{-- ID (solo lectura) --}}
    <div>
        <label>ID:</label>
        <input type="text" value="{{ $candidato->idCandidato }}" disabled>
    </div>


    {{-- Nombre --}}
    <div>
        <label>Nombre:</label>
        <input type="text" name="nombre" value="{{ old('nombre', $candidato->nombre) }}" required>
        @error('nombre')
            <div style="color: #b91c1c;">{{ $message }}</div>
        @enderror
    </div>

    {{-- Apellidos --}}
    <div>
        <label>Apellidos:</label>
        <input type="text" name="apellidos" value="{{ old('apellidos', $candidato->apellidos) }}" required>
        @error('apellidos')
            <div style="color: #b91c1c;">{{ $message }}</div>
        @enderror
    </div>

    {{-- NIF --}}
    <div>
        <label>NIF:</label>
        <input type="text" name="nif" value="{{ old('nif', $candidato->nif) }}" required>
        @error('nif')
            <div style="color: #b91c1c;">{{ $message }}</div>
        @enderror
    </div>

    {{-- Orden elecciones --}}
    <div>
        <label>Orden elecciones:</label>
        <input type="number" name="orden" min="1"
               value="{{ old('orden', $candidato->orden) }}" required>
        @error('orden')
            <div style="color: #b91c1c;">{{ $message }}</div>
        @enderror
    </div>


        <label>Candidatura:</label>
        <select name="idCandidatura" required>
            @foreach ($candidaturas as $cand)
                <option value="{{ $cand->idCandidatura }}"
                        {{ old('idCandidatura', $candidato->idCandidatura) == $cand->idCandidatura ? 'selected' : '' }}>
                    {{ $cand->nombre_concat }}
                </option>
            @endforeach
        </select>
        @error('idCandidatura')
            <div style="color: #b91c1c;">{{ $message }}</div>
        @enderror

    {{-- Botones --}}
    <div style="margin-top: 16px;">
        <button type="submit">Guardar cambios</button>
        <a href="{{ url()->previous() }}">
            <button type="button">Cancelar</button>
        </a>
    </div>
</form>
@endsection
