<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Elecciones</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
<div class="container mx-auto p-4">
    <h1 class="text-3xl font-semibold text-center text-gray-800 my-8">Lista de Elecciones</h1>

    @if (session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
        <strong class="font-bold">Éxito!</strong>
        <span class="block sm:inline">{{ session('success') }}</span>
    </div>
    @endif

    <div class="mb-4">
        <a href="{{ route('elecciones.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Crear Nueva Elección
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full leading-normal shadow-md rounded-lg overflow-hidden">
            <thead class="bg-gray-200 text-gray-700">
            <tr>
                <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold uppercase tracking-wider">Nombre</th>
                <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold uppercase tracking-wider">Fecha Inicio</th>
                <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold uppercase tracking-wider">Fecha Fin</th>
                <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold uppercase tracking-wider">Activa</th>
                <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold uppercase tracking-wider">Acciones</th>
            </tr>
            </thead>
            <tbody class="bg-white">
            @foreach ($elecciones as $eleccion)
            <tr>
                <td class="px-5 py-5 border-b border-gray-200 text-sm"><span class="font-italic text-gray-800">{{ $eleccion->nombre }}</span></td>
                <td class="px-5 py-5 border-b border-gray-200 text-sm"><span class="text-gray-900">{{ $eleccion->fecha_inicio }}</span></td>
                <td class="px-5 py-5 border-b border-gray-200 text-sm"><span class="text-gray-900">{{ $eleccion->fecha_fin }}</span></td>
                <td class="px-5 py-5 border-b border-gray-200 text-sm">
                                <span class="relative inline-block px-3 py-1 font-semibold text-green-900 leading-tight">
                                    <span aria-hidden="true" class="absolute inset-0 bg-green-200 rounded-full"></span>
                                    <span class="relative">{{ $eleccion->activa ? 'Sí' : 'No' }}</span>
                                </span>
                </td>
                <td class="px-5 py-5 border-b border-gray-200 text-sm">
                    <div class="flex space-x-2">
                        <a href="{{ route('elecciones.show', $eleccion) }}" class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-1 px-2 rounded text-xs">Ver</a>
                        <a href="{{ route('elecciones.edit', $eleccion) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-1 px-2 rounded text-xs">Editar</a>
                        <form action="{{ route('elecciones.destroy', $eleccion) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas eliminar esta elección?')" class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded text-xs">Eliminar</button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-4">
        {{ $elecciones->links() }}
    </div>
</div>
</body>
</html>
