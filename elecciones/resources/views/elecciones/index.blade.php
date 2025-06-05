@extends('layouts.app')

@section('title', 'Administrar')

{{-- SweetAlert2 CDN and custom styles go in the 'head' section of your layout --}}
@section('head')
{{-- Ensure TailwindCSS is linked in your layouts.app if not already --}}
{{-- <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2/dist/tailwind.min.css" rel="stylesheet"> --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<style>
    /* Estilos generales de las tablas */
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
</style>
@endsection

@section('content')
{{-- The body tag is removed here as it should be in layouts.app --}}
{{-- The container div moves here --}}
<div class="container mx-auto p-4">
    <h1 class="text-3xl font-semibold text-center text-orange-800 my-8">Lista de Elecciones</h1>

    {{-- Laravel session messages --}}
    @if (session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
        <strong class="font-bold">Éxito!</strong>
        <span class="block sm:inline">{{ session('success') }}</span>
    </div>
    @endif
        <a href="{{ route('elecciones.create') }}">
            <button>Añadir nuevas elecciones</button>
        </a>

    <div class="overflow-x-auto">
        <table >
            <thead class="bg-orange-200 text-orange-800">
            <tr>
                <th>Nombre</th>
                <th>Fecha Inicio</th>
                <th>Fecha Fin</th>
                <th>Activa</th>
                <th>Editar</th>
                <th>Borrar</th>
                <th>Ver</th>
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
                <td><a href="{{ route('elecciones.edit', $eleccion) }}"><button>✏️</button></a></td>

                <td>
                    <form id="delete-form-{{ $eleccion->id }}" method="POST" action="{{ route('elecciones.destroy', $eleccion) }}">
                        @csrf
                        @method('DELETE')
                        <button type="button" onclick="confirmarBorradoCandidatura({{ $eleccion->id }})">🗑️</button>
                    </form>
                </td>
                <td>
                    <a href="{{ route('elecciones.show', $eleccion) }}"><button>️‍👁️️</button></a>
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
@endsection

{{-- SweetAlert2 scripts go in the 'scripts' section of your layout --}}
@section('scripts')
<script>
    // Script para mensajes de éxito
    @if (session('successActualizar'))
        Swal.fire({
            icon: 'success',
            title: 'Elección actualizada',
            text: '{{ session('successActualizar') }}',
            confirmButtonColor: '#8c0c34',
            confirmButtonText: 'Aceptar'
        });
    @endif

    @if (session('successAnyadir'))
        Swal.fire({
            icon: 'success',
            title: 'Elección añadida',
            text: '{{ session('successAnyadir') }}',
            confirmButtonColor: '#8c0c34',
            confirmButtonText: 'Aceptar'
        });
    @endif

    @if (session('successEliminar'))
        Swal.fire({
            icon: 'success',
            title: 'Elección eliminada',
            text: '{{ session('successEliminar') }}',
            confirmButtonColor: '#8c0c34',
            confirmButtonText: 'Aceptar'
        });
    @endif

    // Script para la confirmación de borrado
    function confirmarBorradoEleccion(id) {
        Swal.fire({
            title: '¿Estás seguro?',
            text: "La elección se borrará permanentemente",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#8c0c34',
            cancelButtonColor: '#ff8c00',
            confirmButtonText: 'Sí, borrar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        });
    }
</script>
@endsection
