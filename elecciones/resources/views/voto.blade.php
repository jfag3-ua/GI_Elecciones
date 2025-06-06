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
    /*
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
                    @foreach ($candidatosPorPartido as $partido => $candidatos)
                        
                        <div class="partido" style="margin-bottom: 20px; border-radius: 8px; box-shadow: 0 1px 4px rgba(0,0,0,0.07); overflow: hidden;">

                        <button 
                            type="button"
                            class="toggle-btn" 
                            onclick="toggleCandidatos('{{ $id }}', this)"
                            style="display: flex; align-items: center; width: 100%; padding: 14px 20px; background-color: #fdecea; border: none; color: black; font-weight: 600; cursor: pointer; transition: color 0.3s ease, background-color 0.25s ease;"
                            onmouseenter="this.style.color='#8c0c34'; this.style.backgroundColor='#f9d6d0';"
                            onmouseleave="this.style.color='black'; this.style.backgroundColor='#fdecea';"
                        >
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
    @endif
    
@endsection
