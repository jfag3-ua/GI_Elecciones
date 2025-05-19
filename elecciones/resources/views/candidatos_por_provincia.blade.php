@extends('layouts.app')

@section('content')
@php
$nombresProvincias = [
    1 => 'Alicante',
    2 => 'Valencia',
    3 => 'Castellón'
];
@endphp
<a href="{{ route('provincias') }}">← Volver a provincias</a>

<h2>Candidatos por partido en la provincia de {{ $nombresProvincias[$provincia] ?? 'Desconocida' }}</h2>

@foreach ($candidatosPorPartido as $partido => $candidatos)
    <div class="partido">
        <button 
            class="toggle-btn" 
            style="background-color: {{ $candidatos->first()->color }}; color: white; padding: 10px; border: none; width: 100%; text-align: left;"
            onclick="toggleCandidatos('{{ Str::slug($partido, '_') }}')"
        >
            {{ $partido }}
        </button>
        <ul id="candidatos_{{ Str::slug($partido, '_') }}" style="display: none; margin-left: 20px;">
            @foreach ($candidatos as $candidato)
                <li>{{ $candidato->nombreCandidato }} {{ $candidato->apellidos }}</li>
            @endforeach
        </ul>
    </div>
@endforeach

<a href="{{ route('provincias') }}">← Volver a provincias</a>

{{-- JS para desplegar los candidatos --}}
<script>
    function toggleCandidatos(id) {
        const el = document.getElementById('candidatos_' + id);
        el.style.display = el.style.display === 'none' ? 'block' : 'none';
    }
</script>
@endsection