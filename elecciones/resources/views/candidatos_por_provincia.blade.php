@extends('layouts.app')

@section('content')
<a href="{{ route('provincias') }}" style="display: inline-block; margin-bottom: 20px; color: #8c0c34; font-weight: bold; text-decoration: none;">← Volver a provincias</a>

<h3 style="margin-bottom: 2rem;">
Explore los candidatos por partido en la provincia de {{ $nombreProvincia ?? 'Desconocida' }}
</h3>

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
        $sigla = preg_match('/\(([^)]+)\)$/', $partido, $matches) ? $matches[1] : $partido;
        $logo = $logos[$sigla] ?? 'default.png';
        $id = Str::slug($partido, '_');
        $nombrePartidoSinSigla = preg_replace('/\s*\(.*?\)$/', '', $partido);
    @endphp

    <div class="partido" style="margin-bottom: 20px; border-radius: 8px; box-shadow: 0 1px 4px rgba(0,0,0,0.07); overflow: hidden;">

    <button 
        type="button"
        class="toggle-btn" 
        onclick="toggleCandidatos('{{ $id }}', this)"
        style="display: flex; align-items: center; width: 100%; padding: 14px 20px; background-color: #fdecea; border: none; color: black; font-weight: 600; cursor: pointer; transition: color 0.3s ease, background-color 0.25s ease;"
        onmouseenter="this.style.color='#8c0c34'; this.style.backgroundColor='#f9d6d0';"
        onmouseleave="this.style.color='black'; this.style.backgroundColor='#fdecea';"
    >
        <img 
            src="{{ asset('img/partidos/' . $logo) }}" 
            alt="{{ $partido }} logo" 
            style="width: 40px; height: 40px; object-fit: contain; margin-right: 16px;"
            onerror="if (!this.dataset.defaulted) { this.src='{{ asset('img/partidos/default.png') }}'; this.dataset.defaulted = true; }"
        />
        {{ $nombrePartidoSinSigla }} ({{ $candidatos->count() }} candidatos)
        <span class="arrow" style="margin-left:auto; font-size: 22px; transform: rotate(0deg); transition: transform 0.3s ease;">▸</span>
    </button>
    <ul id="candidatos_{{ $id }}" class="candidatos-list" 
        style="display: none; 
            padding: 12px 24px; 
            background: #fefefe; 
            color: black; 
            list-style: none; 
            margin: 0;
            columns: 2;          /* <== Aquí está el truco */
            column-gap: 20px;">   <!-- Espacio entre columnas -->
        @foreach ($candidatos as $index => $candidato)
            <li style="padding: 6px 0; border-bottom: 1px solid #eee;">
                <strong>{{ $index + 1 }}º:</strong> {{ $candidato->nombreCandidato }} {{ $candidato->apellidos }}
            </li>
        @endforeach
    </ul>
    </div>
@endforeach

<a href="{{ route('provincias') }}" style="display: inline-block; margin-top: 30px; color: #8c0c34; font-weight: bold; text-decoration: none;">← Volver a provincias</a>

<script>
    function toggleCandidatos(id, button) {
        const list = document.getElementById('candidatos_' + id);
        const arrow = button.querySelector('.arrow');

        if (list.style.display === 'none' || !list.style.display) {
            list.style.display = 'block';
            arrow.style.transform = 'rotate(90deg)';
        } else {
            list.style.display = 'none';
            arrow.style.transform = 'rotate(0deg)';
        }
    }
</script>
@endsection
