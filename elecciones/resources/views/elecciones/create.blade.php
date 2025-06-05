@extends('layouts.app')

@section('title', 'Crear Nueva Elección')

@section('content')
<h2>Crear Nueva Elección</h2>

<form method="POST" action="{{ route('elecciones.store') }}">
    @csrf

    <div>
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" id="nombre" value="{{ old('nombre') }}" required>
        @error('nombre')
        <p>{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="fecha_inicio">Fecha de Inicio:</label>
        <input type="datetime-local" name="fecha_inicio" id="fecha_inicio" value="{{ old('fecha_inicio') }}" required>
        @error('fecha_inicio')
        <p>{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="fecha_fin">Fecha de Fin:</label>
        <input type="datetime-local" name="fecha_fin" id="fecha_fin" value="{{ old('fecha_fin') }}" required>
        @error('fecha_fin')
        <p>{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="fecha_campana_inicio">Fecha de Inicio de Campaña:</label>
        <input type="datetime-local" name="fecha_campana_inicio" id="fecha_campana_inicio" value="{{ old('fecha_campana_inicio') }}">
        @error('fecha_campana_inicio')
        <p>{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="fecha_campana_fin">Fecha de Fin de Campaña:</label>
        <input type="datetime-local" name="fecha_campana_fin" id="fecha_campana_fin" value="{{ old('fecha_campana_fin') }}">
        @error('fecha_campana_fin')
        <p>{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="fecha_elecciones">Fecha de Elecciones:</label>
        <input type="datetime-local" name="fecha_elecciones" id="fecha_elecciones" value="{{ old('fecha_elecciones') }}">
        @error('fecha_elecciones')
        <p>{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="activa">Activa:</label>
        <input type="checkbox" name="activa" id="activa" value="1" {{ old('activa') ? 'checked' : '' }}> Sí
    </div>

    <div>
        <button type="submit">Crear Elección</button>
        <a href="{{ route('elecciones.index') }}">
            <button type="button">Cancelar</button>
        </a>
    </div>
</form>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const fechaInicioInput = document.getElementById('fecha_inicio');
        const fechaFinInput = document.getElementById('fecha_fin');
        const fechaCampanaInicioInput = document.getElementById('fecha_campana_inicio');
        const fechaCampanaFinInput = document.getElementById('fecha_campana_fin');
        const fechaEleccionesInput = document.getElementById('fecha_elecciones');

        const today = new Date();
        const todayISO = today.toISOString().slice(0, 16);

        fechaInicioInput.min = todayISO;

        function updateDateRestrictions() {
            if (fechaInicioInput.value) {
                fechaFinInput.min = fechaInicioInput.value;
            } else {
                fechaFinInput.min = todayISO;
            }

            if (fechaInicioInput.value) {
                fechaCampanaInicioInput.max = fechaInicioInput.value;
            } else {
                fechaCampanaInicioInput.max = null;
            }

            if (fechaInicioInput.value) {
                fechaCampanaFinInput.max = fechaInicioInput.value;
            } else {
                fechaCampanaFinInput.max = null;
            }

            if (fechaCampanaInicioInput.value) {
                fechaCampanaFinInput.min = fechaCampanaInicioInput.value;
            } else {
                fechaCampanaFinInput.min = null;
            }

            if (fechaFinInput.value) {
                fechaEleccionesInput.min = fechaFinInput.value;
            } else {
                fechaEleccionesInput.min = null;
            }
        }

        fechaInicioInput.addEventListener('change', updateDateRestrictions);
        fechaFinInput.addEventListener('change', updateDateRestrictions);
        fechaCampanaInicioInput.addEventListener('change', updateDateRestrictions);

        updateDateRestrictions();
    });
</script>
@endsection
