<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Elección</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
<div class="container mx-auto p-4">
    <h1 class="text-3xl font-semibold text-center text-gray-800 my-8">Editar Elección</h1>

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
        <div class="mb-4">
            <label for="votos_nulos" class="block text-gray-700 text-sm font-bold mb-2">Votos Nulos:</label>
            <input type="number" name="votos_nulos" id="votos_nulos" value="{{ old('votos_nulos', $eleccion->votos_nulos) }}" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            @error('votos_nulos')
            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="abs tenciones" class="block text-gray-700 text-sm font-bold mb-2">Abstenciones:</label>
            <input type="number" name="abstenciones" id="abstenciones" value="{{ old('abstenciones', $eleccion->abstenciones) }}" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            @error('abstenciones')
            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
            Guardar Cambios
        </button>
        <a href="{{ route('elecciones.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline ml-2">
            Cancelar
        </a>
    </form>
</div>
</body>
</html>
