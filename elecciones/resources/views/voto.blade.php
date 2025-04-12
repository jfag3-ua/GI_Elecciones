@extends('layouts.app')

@section('title', 'Votar')

@section('content')
    <h2>Votar</h2>
    <p class="notice">Selecciona el candidato que deseas votar. Solo puedes seleccionar una opción. Una vez confirmado, tu voto será registrado de forma <b>definitiva</b>.</p>
    <article>
        <form>
            @csrf
            <h4>Selecciona tu opción de voto:</h4>
            <p>
                @foreach ($candidaturas as $candidatura)
                    <label>
                        <input name="partido" type="radio" value="{{ $candidatura->nombre }}">
                        {{ $candidatura->nombre }}
                    </label>
                @endforeach
            </p>
            <button id="confirmar" disabled>Confirmar voto</button>
        </form>
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
