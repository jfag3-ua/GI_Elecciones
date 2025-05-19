<html lang='en'>
<head>
    <meta charset='utf-8' />
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.17/index.global.min.js'></script>
    <script>

        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth'
            });
            calendar.render();
        });

    </script>
</head>
<body>
<div id='calendar'></div>
</body>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');

        function cargarFechasYMostrarCalendario(eleccionId) {
            fetch(`/api/elecciones/${eleccionId}/fechas`)
                .then(response => response.json())
                .then(fechas => {
                    inicializarCalendarioConFechas(fechas);
                });
        }

        function inicializarCalendarioConFechas(fechas) {
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                events: [
                    {
                        title: 'Campaña Electoral',
                        start: fechas.fecha_campana_inicio,
                        end: fechas.fecha_campana_fin,
                        allDay: true,
                        className: 'evento-campana'
                    },
                    {
                        title: 'Elecciones',
                        start: fechas.fecha_elecciones,
                        allDay: true,
                        className: 'evento-elecciones'
                    }
                ],
                locale: 'es' // O tu configuración regional
            });
            calendar.render();
        }

        const selectorEleccion = document.getElementById('selector-eleccion');
        if (selectorEleccion) {
            selectorEleccion.addEventListener('change', function() {
                const eleccionId = this.value;
                if (eleccionId) {
                    cargarFechasYMostrarCalendario(eleccionId);
                } else {
                    // Limpiar el calendario o mostrar un estado por defecto
                    calendarEl.innerHTML = ''; // Si 'calendar' ya está definido globalmente
                }
            });

            // Cargar el calendario con la primera elección al cargar la página (opcional)
            fetch('/api/elecciones')
                .then(response => response.json())
                .then(data => {
                    if (data.length > 0) {
                        cargarFechasYMostrarCalendario(data[0].id); // Carga la primera elección por defecto
                        // Llena el desplegable aquí si aún no lo has hecho
                        const option = document.createElement('option');
                        option.value = data[0].id;
                        option.textContent = data[0].nombre;
                        selectorEleccion.appendChild(option);
                        // ... Continúa llenando el resto de las opciones del desplegable
                    }
                });
        } else {
            // Si no hay selector, podrías cargar un calendario por defecto con alguna información
            fetch('/api/elecciones')
                .then(response => response.json())
                .then(data => {
                    if (data.length > 0) {
                        cargarFechasYMostrarCalendario(data[0].id);
                    }
                });
        }
    });
</script>
</html>
