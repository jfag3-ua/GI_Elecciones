@extends('layouts.app')

@section('title', 'Votar')

@section('content')
    <h2>Votar</h2>

    <!-- Mostrar mensaje si el usuario ya ha votado -->
    @if (isset($votado) && $votado)
        <p class="notice">Ya has votado. Gracias por participar.</p>
    @else
        <p class="notice">Selecciona el candidato que deseas votar. Solo puedes seleccionar una opción. Una vez confirmado, tu voto será registrado de forma <b>definitiva</b>.</p>
        <article>
            <form method="POST" action="{{ route('guardar.voto') }}">
                @csrf
                <h4>Selecciona tu opción de voto:</h4>
                <p>
                    @foreach ($candidaturas as $candidatura)
                        <label>
                            <input name="candidato" type="radio" value="{{ $candidatura->nombre }}">
                            {{ $candidatura->nombre }}
                        </label><br>
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
    @endif
@endsection
