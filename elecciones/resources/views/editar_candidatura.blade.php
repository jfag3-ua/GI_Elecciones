@extends('layouts.app')

@section('title', 'Editar Candidatura')

@section('content')
    <h2>Editar Candidatura</h2>
    
    <form method="POST" action="{{ route('candidatura.actualizar', $candidatura->idCandidatura) }}">
        @csrf
        <div>
            <label>Id:</label>
            <input type="text" value="{{ $candidatura->idCandidatura }}" disabled>
        </div>
        <div>
            <label>Nombre:</label>
            <input type="text" name="nombre" value="{{ $candidatura->nombre }}" required>
        </div>
        <div>
            <label>Escaños obtenidos:</label>
            <input type="text" value="{{ $candidatura->escanyosElegidos }}" disabled>
        </div>
        <div>
            <label>Circunscripción:</label>
            <select name="idCircunscripcion" required>
                @php
                    $circunscripciones = [
                        1 => 'Alicante',
                        2 => 'Valencia',
                        3 => 'Castellón'
                    ];
                @endphp

                @foreach ($circunscripciones as $id => $nombre)
                    <option value="{{ $id }}" {{ $candidatura->idCircunscripcion == $id ? 'selected' : '' }}>
                        {{ $nombre }}
                    </option>
                @endforeach
            </select>
        </div>
        <div>
            <button type="submit">Guardar cambios</button>
        </div>
    </form>
@endsection
