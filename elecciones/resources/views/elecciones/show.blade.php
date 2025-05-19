<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles de la Elección</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
<div class="container mx-auto p-4">
    <h1 class="text-3xl font-semibold text-center text-gray-800 my-8">Detalles de la Elección</h1>

    <div class="bg-white shadow-md rounded-lg p-6 mb-6">
        <div class="grid grid-cols-2 gap-4">
            <div>
                <p class="text-gray-700 font-bold">Nombre:</p>
                <p class="text-gray-900">{{ $eleccion->nombre }}</p>
            </div>
            <div>
                <p class="text-gray-700 font-bold">Fecha de Inicio:</p>
                <p class="text-gray-900">{{ $eleccion->fecha_inicio }}</p>
            </div>
            <div>
                <p class="text-gray-700 font-bold">Fecha de Fin:</p>
                <p class="text-gray-900">{{ $eleccion->fecha_fin }}</p>
            </div>
            <div>
                <p class="text-gray-700 font-bold">Fecha de Inicio de Campaña:</p>
                <p class="text-gray-900">{{ $eleccion->fecha_campana_inicio ?? 'No definida' }}</p>
            </div>
            <div>
                <p class="text-gray-700 font-bold">Fecha de Fin de Campaña:</p>
                <p class="text-gray-900">{{ $eleccion->fecha_campana_fin ?? 'No definida' }}</p>
            </div>
            <div>
                <p class="text-gray-700 font-bold">Fecha de Elecciones:</p>
                <p class="text-gray-900">{{ $eleccion->fecha_elecciones ?? 'No definida' }}</p>
            </div>
            <div>
                <p class="text-gray-700 font-bold">Activa:</p>
                <p class="text-gray-900">{{ $eleccion->activa ? 'Sí' : 'No' }}</p>
            </div>
            <div>
                <p class="text-gray-700 font-bold">Votos Nulos:</p>
                <p class="text-gray-900">{{ $eleccion->votos_nulos }}</p>
            </div>
            <div>
                <p class="text-gray-700 font-bold">Abstenciones:</p>
                <p class="text-gray-900">{{ $eleccion->abstenciones }}</p>
            </div>
        </div>
    </div>

    <a href="{{ route('elecciones.index') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
        Volver a la Lista
    </a>
</div>
</body>
</html>
