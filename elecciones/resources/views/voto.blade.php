@extends('layouts.app')

@section('title', 'Votar')

@section('content')
    @if (session('successVotoRegistrado'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Voto registrado',
                text: '{{ session('successVotoRegistrado') }}',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Aceptar'
            });
        </script>
    @endif

    <h2>Votar</h2>

    <!-- Mostrar mensaje si el usuario ya ha votado -->
    @if (isset($votado) && $votado)
        <p class="notice">Tu voto ya ha sido <b>registrado</b>. Gracias por participar.</p>
    @else
        <p class="notice">Selecciona el candidato que deseas votar. Solo puedes seleccionar una opción. Una vez confirmado, tu voto será registrado de forma <b>definitiva</b>.</p>
        <article>
            <form id="form-voto" method="POST" action="{{ route('guardar.voto') }}">
                @csrf
                <h4>Selecciona tu opción de voto:</h4>
                <p>
                    @foreach ($candidaturas as $candidatura)
                        <label>
                            <input name="candidato" type="radio" value="{{ $candidatura->nombre }}">
                            {{ $candidatura->nombre }}
                        </label>
                    @endforeach
                </p>
                <button id="confirmar" type="button" disabled>Confirmar voto</button>
            </form>
        </article>

        <script>
            // Obtener todos los inputs tipo radio
            const radios = document.querySelectorAll('input[name="candidato"]');
            const botonConfirmar = document.getElementById('confirmar');
            const formulario = document.getElementById('form-voto');

            // Función para habilitar el botón cuando se seleccione una opción
            radios.forEach(radio => {
                radio.addEventListener('change', () => {
                    botonConfirmar.disabled = false;
                });
            });

            botonConfirmar.addEventListener('click', () => {
                const candidatoSeleccionado = document.querySelector('input[name="candidato"]:checked').value;

                Swal.fire({
                    title: '¿Confirmas tu voto?',
                    text: "Has seleccionado: " + candidatoSeleccionado,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#aaa',
                    confirmButtonText: 'Sí, votar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        formulario.submit();
                    }
                });
            });
        </script>
    @endif
@endsection
