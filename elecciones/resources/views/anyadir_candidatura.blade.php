@extends('layouts.app')

@section('title', 'Añadir candidatura')

@section('content')
    <h2>Añadir candidatura</h2>

        <form method="POST" action="{{ route('candidatura.guardar') }}">
        @csrf
        <input type="hidden" name="eleccion_id" value="{{ $eleccion_id }}">
        <div>
            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" id="nombre" required>
        </div>

        <div>
            <label for="color">Color:</label>
            <input type="text" name="color" id="color" required>
        </div>

        <div>
            <label for="idCircunscripcion">Circunscripción:</label>
            <select name="idCircunscripcion" id="idCircunscripcion" required>
                @php
                    $circunscripciones = [
                        1 => 'Alicante',
                        2 => 'Valencia',
                        3 => 'Castellón'
                    ];
                @endphp

                @foreach ($circunscripciones as $id => $nombre)
                    <option value="{{ $id }}">{{ $nombre }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <button type="submit">Guardar</button>
            <a href="{{ url()->previous() }}">
                <button type="button">Cancelar</button>
            </a>
        </div>
    </form>
@endsection
