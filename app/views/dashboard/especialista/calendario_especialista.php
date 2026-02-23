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
                <p><strong>Motivo:</strong> <span id="detMotivo"></span></p>
                <div id="areaAcciones" class="d-none mt-3">
                    <hr>
                    <button class="btn btn-success w-100 mb-2" id="btnAceptarCita">Aceptar Cita</button>
                    <button class="btn btn-danger w-100" id="btnRechazarCita">Rechazar Cita</button>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once BASE_PATH . '/app/views/layouts/footer_especialista.php'; ?>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const calendarEl = document.getElementById('calendar');
        const modalEl = new bootstrap.Modal(document.getElementById('modalEvento'));

        const calendar = new FullCalendar.Calendar(calendarEl, {
            ...window.fullCalendarConfig,
            events: '<?= BASE_URL ?>/especialista/calendario-api?action=obtener_eventos_especialista',

            eventClick: function(info) {
                const data = info.event.extendedProps;
                document.getElementById('detPaciente').innerText = data.paciente;
                document.getElementById('detServicio').innerText = data.servicio;
                document.getElementById('detMotivo').innerText = data.motivo || 'N/A';

                const areaAcciones = document.getElementById('areaAcciones');
                if (data.tipo === 'cita' && data.estado === 'Pendiente') {
                    areaAcciones.classList.remove('d-none');
                    document.getElementById('btnAceptarCita').onclick = () => procesarCita(info.event.id, 'aceptar');
                    document.getElementById('btnRechazarCita').onclick = () => procesarCita(info.event.id, 'cancelar');
                } else {
                    areaAcciones.classList.add('d-none');
                }
                modalEl.show();
            }
        });

        calendar.render();

        function procesarCita(id, accion) {
            Swal.fire({
                title: '¿Confirmar acción?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Sí, proceder'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Llamada a tu controlador existente MisCitasController
                    $.get(`<?= BASE_URL ?>/especialista/mis-citas?accion=${accion}&id=${id}`, function(res) {
                        // Dado que tu controlador actual usa SweetAlert y redirige, 
                        // lo ideal sería que devolviera JSON, pero para no romper tu lógica:
                        modalEl.hide();
                        calendar.refetchEvents();
                    });
                }
            });
        }
    });
</script>