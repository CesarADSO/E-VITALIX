<?php include_once BASE_PATH . '/app/views/layouts/header_especialista.php'; ?>

<div class="container-fluid py-4">
    <div class="row">
        <?php include_once BASE_PATH . '/app/views/layouts/sidebar_especialista.php'; ?>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Mi Agenda E-VITALIX</h1>
            </div>

            <div class="card shadow border-0">
                <div class="card-body">
                    <div id="calendar"></div>
                </div>
            </div>
        </main>
    </div>
</div>

<div class="modal fade" id="modalEvento" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detalle del Evento</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p><strong>Paciente:</strong> <span id="detPaciente"></span></p>
                <p><strong>Servicio:</strong> <span id="detServicio"></span></p>
            </div>
        </div>
    </div>
</div>

<?php include_once BASE_PATH . '/app/views/layouts/footer_especialista.php'; ?>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const calendarEl = document.getElementById('calendar');
        const modalEl = new bootstrap.Modal(document.getElementById('modalEvento'));

        // 1. Medir la pantalla: Si es menor a 768px (tamaño tablet/móvil de Bootstrap), es verdadero.
        const esMovil = window.innerWidth < 768;


        const calendar = new FullCalendar.Calendar(calendarEl, {
            ...window.fullCalendarConfig,

            // 2. Vistas dinámicas según el dispositivo
            initialView: esMovil ? 'listWeek' : 'dayGridMonth',

            // 3. Barra de herramientas dinámica (menos botones en móvil para evitar que se apeñuzque)
            headerToolbar: esMovil ? {
                left: 'prev,next',
                center: 'title',
                right: ''
            } : {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },

            events: '<?= BASE_URL ?>/especialista/calendario-api?action=obtener_eventos_especialista',

            eventClick: function(info) {
                const data = info.event.extendedProps;
                document.getElementById('detPaciente').innerText = data.paciente;
                document.getElementById('detServicio').innerText = data.servicio;
                modalEl.show();
            },

            // 4. Magia extra: Detectar si el especialista voltea el celular o encoge la ventana en PC
            windowResize: function(arg) {
                const pantallaChica = window.innerWidth < 768;

                // Si la pantalla se hace pequeña y no estamos en lista, fuerza el cambio a lista
                if (pantallaChica && arg.view.type !== 'listWeek') {
                    calendar.changeView('listWeek');
                }
                // Si la pantalla se hace grande y estamos en lista, vuelve a la cuadrícula normal del mes
                else if (!pantallaChica && arg.view.type === 'listWeek') {
                    calendar.changeView('dayGridMonth');
                }
            }
        });

        calendar.render();
    });
</script>