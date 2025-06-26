@extends('layouts.app')

@section('content')
<div>
    <h2>Calendario de Elecciones</h2>
    <div>
        <label for="eleccionesSelect">Selecciona elecciones:</label>
        <select id="eleccionesSelect" multiple>
            @foreach($elecciones as $eleccion)
                <option value="{{ $eleccion->id }}">{{ $eleccion->nombre }}</option>
            @endforeach
        </select>
    </div>
    <div style="margin: 16px 0;">
        <label for="gotoMonth">Ir a mes/año:</label>
        <input type="month" id="gotoMonth">
        <button type="button" onclick="goToSelectedMonth()">Ir</button>
    </div>
    <div id="calendar"></div>
    <div id="no-selection" style="display:none; color: #8c0c34; font-weight: bold; margin-top: 30px;">
        Selecciona al menos una elección para ver el calendario.
    </div>
</div>

<!-- FullCalendar CSS y JS -->
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>

<script>
    const elecciones = @json($elecciones);
    const calendarEl = document.getElementById('calendar');
    const noSelectionEl = document.getElementById('no-selection');
    let calendar = null;

    function getEventsForSelected() {
        const selected = Array.from(document.getElementById('eleccionesSelect').selectedOptions).map(opt => parseInt(opt.value));
        let events = [];
        elecciones.forEach(e => {
            if (selected.includes(e.id)) {
                if (e.fecha_campana_inicio && e.fecha_campana_fin) {
                    events.push({
                        title: e.nombre + ' (Campaña)',
                        start: e.fecha_campana_inicio,
                        end: e.fecha_campana_fin,
                        color: '#f6c23e'
                    });
                }
                if (e.fecha_inicio && e.fecha_fin) {
                    events.push({
                        title: e.nombre + ' (Convocatoria)',
                        start: e.fecha_inicio,
                        end: e.fecha_fin,
                        color: '#36b9cc'
                    });
                }
                if (e.fecha_elecciones) {
                    events.push({
                        title: e.nombre + ' (Día de elecciones)',
                        start: e.fecha_elecciones,
                        end: e.fecha_elecciones,
                        color: '#1cc88a'
                    });
                }
            }
        });
        return events;
    }

    function renderCalendar() {
        const events = getEventsForSelected();
        if (calendar) {
            calendar.destroy();
        }
        if (events.length === 0) {
            calendarEl.style.display = 'none';
            noSelectionEl.style.display = 'block';
            return;
        }
        calendarEl.style.display = 'block';
        noSelectionEl.style.display = 'none';
        calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            locale: 'es',
            events: events,
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth'
            }
        });
        calendar.render();
    }

    function goToSelectedMonth() {
        const input = document.getElementById('gotoMonth');
        if (input.value && calendar) {
            const [year, month] = input.value.split('-');
            calendar.gotoDate(`${year}-${month}-01`);
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('eleccionesSelect').addEventListener('change', function() {
            // Autocompletar el input de mes con el mes/año de la primera elección seleccionada
            const selected = Array.from(this.selectedOptions).map(opt => parseInt(opt.value));
            if (selected.length > 0) {
                const eleccion = elecciones.find(e => e.id === selected[0]);
                if (eleccion && eleccion.fecha_inicio) {
                    // fecha_inicio puede ser 'YYYY-MM-DD' o 'YYYY-MM-DDTHH:MM:SS', tomamos los dos primeros segmentos
                    const fecha = new Date(eleccion.fecha_inicio);
                    if (!isNaN(fecha)) {
                        const year = fecha.getFullYear();
                        const month = (fecha.getMonth() + 1).toString().padStart(2, '0');
                        document.getElementById('gotoMonth').value = `${year}-${month}`;
                    }
                }
            }
            renderCalendar();
        });
        renderCalendar();
    });
</script>
@endsection
