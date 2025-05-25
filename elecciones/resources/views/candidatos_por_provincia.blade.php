@extends('layouts.app')

@section('content')
<a href="{{ route('provincias') }}" style="display: inline-block; margin-bottom: 20px;">← Volver a provincias</a>

<h2 style="margin-bottom: 30px; color: black;">Candidatos por partido en la provincia de {{ $nombreProvincia ?? 'Desconocida' }}</h2>

@php
    $logos = [
        'ALIANZA C V'    => 'alianza_c_v.png',
        'CENTRATS'       => 'centrats.png',
        'Cs'             => 'cs.png',
        'UNITS'          => 'units.png',
        'COMPROMÍS'      => 'compromis.png',
        'DECIDIX'        => 'decidix.png',
        'ERPV'           => 'erpv.png',
        'CENTRO MODERADO'=> 'centro_moderado.png',
        'PAR-Es.C.'      => 'par_esc.png',
        'PACMA'          => 'pacma.png',
        'PCPE'           => 'pcpe.png',
        'PP'             => 'pp.png',
        'PSOE'           => 'psoe.png',
        'PUM+J'          => 'pumj.png',
        'RECORTES CERO'  => 'recortes_cero.png',
        'RVPVE'          => 'rvpve.png',
        'UP-EUPV'        => 'up_eupv.png',
        'VOX'            => 'vox.png',
    ];
@endphp

@foreach ($candidatosPorPartido as $partido => $candidatos)
    @php
        // Extraer sigla entre paréntesis si existe
        if (preg_match('/\(([^)]+)\)$/', $partido, $matches)) {
            $sigla = $matches[1];
        } else {
            $sigla = $partido;
        }

        $logo = $logos[$sigla] ?? 'default.png';
        $id = Str::slug($partido, '_');

        // Eliminar siglas del nombre
        $nombrePartidoSinSigla = preg_replace('/\s*\(.*?\)$/', '', $partido);
    @endphp

    <div class="partido" style="margin-bottom: 20px; border: 1px solid #ddd; border-radius: 8px; overflow: hidden;">
        <button 
            type="button"
            class="toggle-btn" 
            onclick="toggleCandidatos('{{ $id }}')"
            style="display: flex; align-items: center; width: 100%; padding: 10px; background-color: #f0f0f0; border: none; color: black;"
        >
        <img 
            src="{{ asset('img/partidos/' . $logo) }}" 
            alt="{{ $partido }} logo" 
            style="width: 55px; height: 55px; object-fit: contain; margin-right: 15px;"
            onerror="if (!this.dataset.defaulted) { this.src='{{ asset('img/partidos/default.png') }}'; this.dataset.defaulted = true; }"
        />
            {{ $nombrePartidoSinSigla }} ({{ $candidatos->count() }} candidatos)
        </button>
        <ul id="candidatos_{{ $id }}" style="display: none; padding: 10px 20px; background: #fafafa; color: black;">
            @foreach ($candidatos as $candidato)
                <li>{{ $candidato->nombreCandidato }} {{ $candidato->apellidos }}</li>
            @endforeach
        </ul>
    </div>
@endforeach

<a href="{{ route('provincias') }}" style="display: inline-block; margin-top: 30px;">← Volver a provincias</a>

{{-- JS para desplegar los candidatos --}}
<script>
    function toggleCandidatos(id) {
        const el = document.getElementById('candidatos_' + id);
        el.style.display = (el.style.display === 'none' || !el.style.display) ? 'block' : 'none';
    }
</script>
@endsection
