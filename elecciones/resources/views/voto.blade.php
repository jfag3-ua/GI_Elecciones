@extends('layouts.app')

@section('title', 'Votar')

@section('content')
    <h2>Votar</h2>
    <p class="notice">Selecciona el candidato que deseas votar. Solo puedes seleccionar una opción. Una vez confirmado, tu voto será registrado de forma <b>definitiva</b>.</p>
    <article>
        <h4>Selecciona tu opción de voto:</h4>
        <p>
        <label><input name="candidato" type="radio" value="PP"> Partido Popular (PP)</label>
        <label><input name="candidato" type="radio" value="PSOE"> Partido Socialista Obrero Español (PSOE)</label>
        <label><input name="candidato" type="radio" value="COMPROMIS"> Compromís: Més-Iniciativa-Verdsequo (COMPROMÍS)</label>
        <label><input name="candidato" type="radio" value="VOX"> VOX</label>
        <label><input name="candidato" type="radio" value="UP-EUPV"> Unides Podem-Esquerra Unida (UP-EUPV)</label>
        <label><input name="candidato" type="radio" value="CS"> Ciudadanos-Partido de la Ciudadanía (Cs)</label>
        <label><input name="candidato" type="radio" value="PACMA"> Partido Animalista con el Medio Ambiente (PACMA)</label>
        <label><input name="candidato" type="radio" value="CENTRO MODERADO"> Los Verdes-Ecopacifistas (CENTRO MODERADO)</label>
        <label><input name="candidato" type="radio" value="ERPV"> Esquerra Republicana del País Valencià (ERPV)</label>
        <label><input name="candidato" type="radio" value="UNITS"> Coalició Units (UNITS)</label>
        <label><input name="candidato" type="radio" value="PCPE"> Partido Comunista de los Pueblos de España (PCPE)</label>
        <label><input name="candidato" type="radio" value="RECORTES CERO"> Recortes Cero (RECORTES CERO)</label>
        <label><input name="candidato" type="radio" value="DECIDIX"> Decidix (DECIDIX)</label>
        <label><input name="candidato" type="radio" value="RVPVE"> República Valenciana / Partit Valencianiste Europeu (RVPVE)</label>
        <label><input name="candidato" type="radio" value="ALIANZA C V"> Alianza por el Comercio y la Vivienda (ALIANZA C V)</label>
        <label><input name="candidato" type="radio" value="PUM+J"> Por un Mundo Más Justo (PUM+J)</label>
        <label><input name="candidato" type="radio" value="CENTRATS"> Centrats en la Nostra Terra (CENTRATS)</label>
        <label><input name="candidato" type="radio" value="PAR-ES.C."> Partido Alicantino Regionalista - Esperanza Ciudadana (PAR-Es.C.)</label>
        </p>
        <button id="confirmar" disabled>Confirmar voto</button>
    </article>
    <script>
        // Obtener todos los inputs tipo radio
        const radios = document.querySelectorAll('input[name="candidato"]');
        const botonConfirmar = document.getElementById('confirmar');

        // Función para habilitar el botón cuando se seleccione una opción
        radios.forEach(radio => {
            radio.addEventListener('change', () => {
                botonConfirmar.disabled = false;
            });
        });
    </script>
@endsection
