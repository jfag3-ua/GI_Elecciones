@extends('layouts.app')

@section('title', 'Administrar')

@section('content')
    <style>
        /* Estilos generales de las tablas */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px; /* Aumentamos el margen entre las tablas */
            font-family: 'Arial', sans-serif;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
            color: #333;
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

    @if (session('successActualizar'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Candidatura actualizada',
                text: '{{ session('successActualizar') }}',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Aceptar'
            });
        </script>
    @endif

    @if (session('successAnyadir'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Candidatura añadida',
                text: '{{ session('successAnyadir') }}',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Aceptar'
            });
        </script>
    @endif

    @if (session('successEliminar'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Candidatura eliminada',
                text: '{{ session('successEliminar') }}',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Aceptar'
            });
        </script>
    @endif

    @if (session('successActualizarCandidato'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Candidato actualizado',
                text: '{{ session('successActualizarCandidato') }}',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Aceptar'
            });
        </script>
    @endif

    @if (session('successAnyadirCandidato'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Candidato añadido',
                text: '{{ session('successAnyadirCandidato') }}',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Aceptar'
            });
        </script>
    @endif

    @if (session('successEliminarCandidato'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Candidato eliminado',
                text: '{{ session('successEliminarCandidato') }}',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Aceptar'
            });
        </script>
    @endif

    <script>
        function confirmarBorradoCandidatura(id) {
            Swal.fire({
                title: '¿Estás seguro?',
                text: "La candidatura se borrará",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sí, borrar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('form-borrar-' + id).submit();
                }
            });
        }

        function confirmarBorradoCandidato(id) {
            Swal.fire({
                title: '¿Estás seguro?',
                text: "El candidato se borrará",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sí, borrar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('form-borrar-' + id).submit();
                }
            });
        }
    </script>

    <h2>Administrar</h2>
    <p class="notice">Aquí un administrador puede realizar tareas de control y administración (<b>un administrador no puede votar</b>).</p>

<div class="mb-4">

</div>
<div class="mb-4">
    <h3>Seleccionar Elección</h3>
    <form method="GET" action="{{ route('administracion') }}#resultados">
        <label for="eleccion_id"></label>
        <select name="eleccion_id" id="eleccion_id" onchange="this.form.submit()">
            <option value="">Todas las Elecciones</option>
            @foreach ($elecciones as $eleccion)
            <option value="{{ $eleccion->id }}" {{ request('eleccion_id') == $eleccion->id ? 'selected' : '' }}>
            {{ $eleccion->nombre }} ({{ $eleccion->fecha_inicio }}) {{-- Usar fecha_inicio como en la tabla --}}
            </option>
            @endforeach
        </select>
    </form>
    <a href="{{ route('elecciones.create') }}">
        <button>Añadir nuevas elecciones</button>
    </a>
</div>
<a href="{{ route('elecciones.index') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
    Mostrar las elecciones
</a>

    <h3>Circunscripciones</h3>
    <table>
        <thead>
            <tr>
                <th>Id</th>
                <th>Nombre</th>
                <th>Escaños</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td>Alicante</td>
                <td class="text-escano">35</td>
            </tr>
            <tr>
                <td>2</td>
                <td>Valencia</td>
                <td class="text-escano">40</td>
            </tr>
            <tr>
                <td>3</td>
                <td>Castellón</td>
                <td class="text-escano">24</td>
            </tr>
            <tr>
                <td colspan="2">Total</td>
                <td class="text-escano">99</td>
            </tr>
        </tbody>
    </table>

    @php
    $circunscripciones = [
        1 => 'Alicante',
        2 => 'Valencia',
        3 => 'Castellón'
    ];
    @endphp

    <h3>Candidaturas</h3>

    <table id="resultados">
        <thead>
            <tr>
                <th>Id</th>
                <th>Nombre
                    <form method="GET"
                          action="{{ route('administracion') }}#resultados">
                        <input type="hidden" name="eleccion_id" value="{{ request('eleccion_id') }}">
                        <input type="text"
                               name="nombre"
                               placeholder="Buscar nombre"
                               value="{{ request('nombre') }}">
                        <button type="submit">Buscar</button>
                        <button type="button"
                                onclick="window.location.href='{{ route('administracion', ['eleccion_id' => request('eleccion_id'), 'nombre_candidato' => '', 'apellidos_candidato' => '', 'partido_id' => '', 'circunscripcion_id' => '']) }}#resultados_candidatos'">
                            Reset
                        </button>
                    </form>
                </th>

                <th>Escaños obtenidos</th>
                <th>
                    <form method="GET"
                          action="{{ route('administracion') }}#resultados">
                        <label for="circunscripcion">Circunscripción</label>
                        <input type="hidden" name="eleccion_id" value="{{ request('eleccion_id') }}">
                        <select name="circunscripcion"
                                id="circunscripcion"
                                onchange="this.form.submit()">
                            <option value="">Todas</option>
                            @foreach ($circunscripciones as $id => $nombre)
                            <option value="{{ $id }}"
                                    {{ request('circunscripcion') == $id ? 'selected' : '' }}>
                            {{ $nombre }}
                            </option>
                            @endforeach
                        </select>
                    </form>
                </th>
                <th>Editar</th>
                <th>Borrar</th>
            </tr>
        </thead>


        <tbody>
            @foreach ($candidaturas as $candidatura)
                <tr>
                    <td>{{ $candidatura->idCandidatura }}</td>
                    <td>
                        {{ $candidatura->nombre }}
                        <span
                            style="
            display: inline-block;
            width: 16px;
            height: 16px;
            margin-left: 8px;
            border-radius: 50%;
            background-color: {{ $candidatura->color }};
            vertical-align: middle;
        "
                            title="{{ $candidatura->color }}"
                        ></span>
                    </td>
                    <td>{{ $candidatura->escanyosElegidos }}</td>
                    <td>{{ $circunscripciones[$candidatura->idCircunscripcion] ?? 'Desconocida' }}</td>
                    <td><a href="{{ route('candidatura.editar', $candidatura->idCandidatura) }}"><button>✏️</button></a></td>
                    <td>
                        <form id="form-borrar-{{ $candidatura->idCandidatura }}" method="POST" action="{{ route('candidatura.eliminar', $candidatura->idCandidatura) }}">
                            @csrf
                            @method('DELETE')
                            <button type="button" onclick="confirmarBorradoCandidatura({{ $candidatura->idCandidatura }})">🗑️</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
<p>Total de candidaturas: {{ $candidaturas->total() }}</p>
<div id="resultados" style="margin-top: 20px;">{{ $candidaturas
    ->appends(request()->except('candidaturas_page'))
    ->fragment('resultados')
    ->links('pagination::simple-default')
    }}
</div>
<a href="{{ route('candidatura.crear', ['eleccion_id' => request('eleccion_id')]) }}">
    <button>Añadir candidatura</button>
</a>


    <h3>Candidatos</h3>

    <table id="resultados_candidatos">
        <thead>
            <tr>
                <th>Id</th>
                <th>Nombre
                    <form method="GET" action="{{ route('administracion') }}#resultados_candidatos">
                        <input type="text"
                               name="nombre_candidato"
                               placeholder="Buscar nombre"
                               value="{{ request('nombre_candidato') }}">
                        <button type="submit">Buscar</button>
                        <button type="button"
                                onclick="window.location.href='{{ route('administracion', ['nombre_candidato' => '', 'apellidos_candidato' => '', 'partido_id' => '', 'circunscripcion_id' => '']) }}#resultados_candidatos'">
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
                        <input type="hidden" name="eleccion_id" value="{{ request('eleccion_id') }}">
                        <label for="circunscripcion">Circunscripción</label>
                        <select name="circunscripcion_candidatos"
                                id="circunscripcion_candidatos"
                                onchange="this.form.submit()">
                            <option value="">Todas</option>
                            @foreach ($circunscripciones as $id => $nombre)
                            <option value="{{ $id }}"
                                    {{ request('circunscripcion_candidatos') == $id ? 'selected' : '' }}>
                            {{ $nombre }}
                            </option>
                            @endforeach
                        </select>
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
<p>Total de candidatos: {{ $candidatos->total() }}</p>
<div class="margin-top: 20px;">
    {{ $candidatos->appends(request()
    ->except('candidatos_page'))
    ->fragment('resultados_candidatos')
    ->links('pagination::simple-default') }}
</div>
<a href="{{ route('candidato.crear', ['eleccion_id' => request('eleccion_id')]) }}">
    <button>Añadir candidato</button>
</a>

    @endsection
