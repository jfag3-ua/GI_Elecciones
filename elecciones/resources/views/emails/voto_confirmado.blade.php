@component('mail::message')
<style>
    .voto-confirmado-container {
        background: #fff;
        border: 1px solid #8c0c34;
        border-radius: 10px;
        padding: 2rem;
        font-family: 'Segoe UI', Arial, sans-serif;
        color: #222;
        max-width: 600px;
        margin: 0 auto;
    }
    .voto-confirmado-titulo {
        color: #8c0c34;
        font-size: 2rem;
        margin-bottom: 1rem;
        text-align: center;
    }
    .voto-confirmado-partido {
        font-size: 1.3rem;
        font-weight: bold;
        color: {{ $candidatura->color ?? '#8c0c34' }};
        margin-bottom: 1rem;
        text-align: center;
    }
    .voto-confirmado-eleccion {
        font-size: 1.1rem;
        color: #8c0c34;
        margin-bottom: 1rem;
        text-align: center;
    }
    .voto-confirmado-fecha {
        font-size: 1rem;
        color: #555;
        margin-bottom: 2rem;
        text-align: center;
    }
    .voto-confirmado-footer {
        text-align: center;
        color: #8c0c34;
        font-size: 0.95rem;
        margin-top: 2rem;
    }
</style>
<div class="voto-confirmado-container">
    <div class="voto-confirmado-titulo">¡Voto registrado correctamente!</div>
    <div class="voto-confirmado-partido">
        Has votado al partido:
        <span style="color: {{ $candidatura->color ?? '#8c0c34' }};">
            {{ $candidatura->nombre ?? 'Desconocido' }}
        </span>
    </div>
    <div class="voto-confirmado-eleccion">
        En las elecciones:
        <span>{{ $eleccion->nombre ?? 'Desconocidas' }}</span>
    </div>
    <div class="voto-confirmado-fecha">
        Fecha y hora del voto:<br>
        <span>{{ $fecha->format('d/m/Y H:i') }}</span>
    </div>
    <div class="voto-confirmado-footer">
        Gracias por participar en la democracia.<br>
        Elecciones Valencianes
    </div>
</div>
@endcomponent
