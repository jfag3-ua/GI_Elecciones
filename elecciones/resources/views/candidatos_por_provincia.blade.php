@extends('layouts.app')

@section('content')
@php
$nombresProvincias = [
1 => 'Alicante',
2 => 'Valencia',
3 => 'Castellón'
];
@endphp
<h2>Candidatos por partido en la provincia {{ $nombresProvincias[$provincia] ?? 'Desconocida' }}</h2>

@foreach ($candidatosPorPartido as $partido => $candidatos)
    <h3 style="color: {{ $candidatos->first()->color }}">{{ $partido }}</h3>
    <ul>
        @foreach ($candidatos as $candidato)
            <li>{{ $candidato->nombreCandidato }} {{ $candidato->apellidos }}</li>
        @endforeach
    </ul>
@endforeach

<a href="{{ route('provincias') }}">← Volver a provincias</a>
@endsection
