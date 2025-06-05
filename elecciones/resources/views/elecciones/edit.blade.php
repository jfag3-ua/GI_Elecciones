@extends('layouts.app')

@section('title', 'Editar Elección')

@section('head')
{{-- SweetAlert2 CDN --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
{{-- Custom styles for tables (if any tables are added to this view later, or for site-wide consistency) --}}
<style>
    /* Estilos generales de las tablas (copiados de la primera vista) */
    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 30px;
        font-family: 'Arial', sans-serif;
    }
    th, td {
        border: 1px solid #ddd;
        padding: 10px;
        text-align: left;
    }
    th {
        background-color: #8c0c34; /* Rojo cálido oscuro */
        color: #fff6f4; /* Blanco roto */
    }
    .label-column {
        text-align: left;
    }
    .divider-row {
        border-bottom: 3px solid #000;
    }
    .text-porcentaje, .text-escano {
        color: #8c0c34;
        font-weight: bold;
    }
    /* Puedes añadir aquí otros estilos específicos para este formulario si lo necesitas */
</style>
@endsection

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-3xl font-semibold text-center text-orange-800 my-8">Editar Elección</h1>

    {{-- Laravel session messages --}}
    @if (session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
        <strong class="font-bold">Éxito!</strong>
        <span class="block sm:inline">{{ session('success') }}</span>
    </div>
    @endif

    <form action="{{ route('elecciones.update', $eleccion->id) }}" method="POST" class="bg-white shadow-md rounded-lg p-6">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="nombre" class="block text-gray-700 text-sm font-bold mb-2">Nombre:</label>
            <input type="text" name="nombre" id="nombre" value="{{ old('nombre', $eleccion->nombre) }}" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            @error('nombre')
            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="fecha_inicio" class="block text-gray-700 text-sm font-bold mb-2">Fecha de Inicio:</label>
            <input type="datetime-local" name="fecha_inicio" id="fecha_inicio" value="{{ old('fecha_inicio', $eleccion->fecha_inicio) }}" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            @error('fecha_inicio')
            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="fecha_fin" class="block text-gray-700 text-sm font-bold mb-2">Fecha de Fin:</label>
            <input type="datetime-local" name="fecha_fin" id="fecha_fin" value="{{ old('fecha_fin', $eleccion->fecha_fin) }}" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            @error('fecha_fin')
            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="fecha_campana_inicio" class="block text-gray-700 text-sm font-bold mb-2">Fecha de Inicio de Campaña:</label>
            <input type="datetime-local" name="fecha_campana_inicio" id="fecha_campana_inicio" value="{{ old('fecha_campana_inicio', $eleccion->fecha_campana_inicio) }}"  class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            @error('fecha_campana_inicio')
            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="fecha_campana_fin" class="block text-gray-700 text-sm font-bold mb-2">Fecha de Fin de Campaña:</label>
            <input type="datetime-local" name="fecha_campana_fin" id="fecha_campana_fin" value="{{ old('fecha_campana_fin', $eleccion->fecha_campana_fin) }}"  class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            @error('fecha_campana_fin')
            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="fecha_elecciones" class="block text-gray-700 text-sm font-bold mb-2">Fecha de Elecciones:</label>
            <input type="datetime-local" name="fecha_elecciones" id="fecha_elecciones" value="{{ old('fecha_elecciones', $eleccion->fecha_elecciones) }}"  class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            @error('fecha_elecciones')
            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="activa" class="block text-gray-700 text-sm font-bold mb-2">Activa:</label>
            <input type="checkbox" name="activa" id="activa" value="1" {{ old('activa', $eleccion->activa) ? 'checked' : '' }} class="mr-2"> Sí
        </div>


        <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
            Guardar Cambios
        </button>

        <a href="{{ route('elecciones.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline ml-2">
            <button>    Cancelar</button>
        </a>

    </form>
</div>
@endsection

@section('scripts')
{{-- Script para mensajes de éxito tras la actualización --}}
@if (session('successActualizar'))
Swal.fire({
icon: 'success',
title: '¡Actualizado!',
text: '{{ session('successActualizar') }}',
confirmButtonColor: '#8c0c34', // Color del botón de confirmación
confirmButtonText: 'Aceptar'
});
@endif
{{-- Si tienes otros SweetAlerts para añadir, borrar, etc., puedes incluirlos aquí --}}
@endsection
