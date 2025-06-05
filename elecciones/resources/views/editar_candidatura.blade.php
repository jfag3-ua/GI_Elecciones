@extends('layouts.app')

@section('title', 'Editar candidatura')
@section('content')

    <h2>Editar candidatura</h2>

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
            <label>Color:</label>
            <input type="text" name="color" value="{{ $candidatura->color }}" required>
        </div>
        <div>
            <label>Escaños obtenidos:</label>
            <input type="text" value="{{ $candidatura->escanyosElegidos }}" disabled>
        </div>
        <div>
            <label>Circunscripción:</label>
            <select name="idCircunscripcion" required >
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
        <div style="margin-bottom: 1rem;">
            <label for="color">Color (hex):</label>
            <input
                type="text"
                name="color"
                id="color"
                value="{{ old('color', $candidatura->color) }}"
                placeholder="#3498db"
                required
                pattern="^#([A-Fa-f0-9]{6})$"
                title="Introduce un color en formato hexadecimal, p. ej. #ff0000"
                style="padding: .5rem; width: 150px;"
            >
        </div>

        <div>
            <button type="submit">Guardar cambios</button>
            <a href="{{ route('administracion') }}">
                <button type="button">Cancelar</button>
            </a>
        </div>
    </form>

<table id="resultados_candidatos">
    <thead>
    <tr>
        <th>Id</th>
        <th>Nombre
            <form method="GET" action="{{ route('administracion') }}#resultados_candidatos">
                {{-- Mantener los parámetros de filtro de candidatura --}}
                @if(request()->has('idCandidatura'))
                <input type="hidden" name="idCandidatura" value="{{ request('idCandidatura') }}">
                @endif
                @if(request()->has('eleccion_id'))
                <input type="hidden" name="eleccion_id" value="{{ request('eleccion_id') }}">
                @endif

                <input type="text"
                       name="nombre_candidato"
                       placeholder="Buscar nombre"
                       value="{{ request('nombre_candidato') }}">
                <button type="submit">Buscar</button>
                <button type="button"
                        onclick="window.location.href='{{ route('administracion', array_merge(request()->only(['idCandidatura', 'eleccion_id']), ['nombre_candidato' => '', 'apellidos_candidato' => '', 'partido_id' => '', 'circunscripcion_id' => ''])) }}#resultados_candidatos'">
                    Reset
                </button>
            </form>
        </th>
        <th>Apellidos</th>
        <th>NIF</th>
        <th>Orden</th>
        <th>Elegido</th>
        <th><form method="GET"
                  action="{{ route('administracion') }}#resultados_candidatos">
                {{-- Mantener los parámetros de filtro de candidatura --}}
                @if(request()->has('idCandidatura'))
                <input type="hidden" name="idCandidatura" value="{{ request('idCandidatura') }}">
                @endif
                @if(request()->has('eleccion_id'))
                <input type="hidden" name="eleccion_id" value="{{ request('eleccion_id') }}">
                @endif
                <label for="circunscripcion">Circunscripción</label>
            </form></th>
        <th>Editar</th>
        <th>Borrar</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($candidatos as $candidato)
    <tr>
        <td>{{ $candidato->idCandidato }}</td>
        <td>{{ $candidato->nombre }}</td>
        <td>{{ $candidato->apellidos }}</td>
        <td>{{ $candidato->nif }}</td>
        <td>{{ $candidato->orden }}</td>
        <td>{{ $candidato->elegido ? 'Sí' : 'No' }}</td>
        <td>{{ $candidato->provincia }}</td>
        <td>
            {{-- Asegúrate de pasar idCandidatura y eleccion_id si es necesario para la edición --}}
            <a href="{{ route('candidato.editar', $candidato->idCandidato) }}">
                <button>✏️</button>
            </a>
        </td>
        <td>
            <form id="form-borrar-{{ $candidato->idCandidato }}" action="{{ route('candidato.borrar', $candidato->idCandidato) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="button" onclick="confirmarBorradoCandidato({{ $candidato->idCandidato }})">🗑️</button>
            </form>
        </td>
    </tr>
    @endforeach
    </tbody>
</table>
<p>Total de candidatos mostrados: {{ $candidatos->total() }}</p>
<div class="margin-top: 20px;">
    {{ $candidatos->appends(request()
    ->except('candidatos_page'))
    ->fragment('resultados_candidatos')
    ->links('pagination::simple-default') }}
</div>
<a href="{{ route('candidato.crear') }}">
    <button>Añadir candidato</button>
</a>

@endsection

