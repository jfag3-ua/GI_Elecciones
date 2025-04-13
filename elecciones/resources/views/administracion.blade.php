@extends('layouts.app')

@section('title', 'Administrar')

@section('content')
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .label-column {
            text-align: left;
        }
        .divider-row {
            border-bottom: 3px solid black;
        }
        .text-porcentaje, .text-escano {
            color: #8c0c34;
            font-weight: bold;
        }
        .chart-container {
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 20px 0;
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

    <script>
        function confirmarBorrado(id) {
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
    </script>

    <h2>Administrar</h2>
    <p class="notice">Aquí un administrador puede realizar tareas de control y administración (<b>un administrador no puede votar</b>).</p>

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
    
    <table>
        <thead>
            <tr>
                <th>Id</th>
                <th>Nombre</th>
                <th>Escaños obtenidos</th>
                <th>
                    <form method="GET" action="{{ route('administracion') }}">
                        <label for="circunscripcion">Circunscripción</label>
                        <select name="circunscripcion" id="circunscripcion" onchange="this.form.submit()">
                            <option value="">Todas</option>
                            @foreach ($circunscripciones as $id => $nombre)
                                <option value="{{ $id }}" {{ request('circunscripcion') == $id ? 'selected' : '' }}>
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
                    <td>{{ $candidatura->nombre }}</td>
                    <td>{{ $candidatura->escanyosElegidos }}</td>
                    <td>{{ $circunscripciones[$candidatura->idCircunscripcion] ?? 'Desconocida' }}</td>
                    <td><a href="{{ route('candidatura.editar', $candidatura->idCandidatura) }}">✏️</a></td>
                    <!-- Formulario oculto para eliminar -->
                    <td>
                        <form id="form-borrar-{{ $candidatura->idCandidatura }}" method="POST" action="{{ route('candidatura.eliminar', $candidatura->idCandidatura) }}" style="display: none;">
                            @csrf
                            @method('DELETE')
                        </form>
                        <a href="#" onclick="confirmarBorrado({{ $candidatura->idCandidatura }})">🗑️</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <a href="{{ route('candidatura.crear') }}">
        <button>Añadir candidatura</button>
    </a>

    <h3>Candidatos</h3>
    <table>
        <thead>
            <tr>
                <th>Id</th>
                <th>Nombre</th>
                <th>Apellidos</th>
                <th>Elegido</th>
                <th>Id Candidatura</th>
                <th>Editar</th>
                <th>Borrar</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td><a href>✏️</a></td>
                <td><a href>🗑️</a></td>
            </tr>
        </tbody>
    </table>
    <button>Añadir candidato</button>
@endsection
