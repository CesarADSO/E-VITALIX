<?php
require_once BASE_PATH . '/app/helpers/session_paciente.php';
include_once __DIR__ . '/../../layouts/header_paciente.php';
require_once BASE_PATH . '/app/controllers/misCitasController.php';
$citas = obtenerCitasPaciente();

?>

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12 mb-4">
            <h3 class="fw-bold">Mis Citas Médicas</h3>
            <p class="text-muted">Gestiona tus consultas próximas y el historial médico.</p>
        </div>

        <?php if (empty($citas)): ?>
            <div class="col-12 text-center py-5">
                <i class="bi bi-calendar-x display-1 text-muted"></i>
                <p class="mt-3">Aún no tienes citas agendadas.</p>
                <a href="<?= BASE_URL ?>/paciente/agendarCita" class="btn btn-primary">Agendar mi primera cita</a>
            </div>
        <?php else: ?>
        <?php endif; ?>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            <?php foreach ($citas as $cita):
                $colorEstado = [
                    'PENDIENTE' => 'warning',
                    'CONFIRMADA' => 'success',
                    'CANCELADA' => 'danger',
                    'RECHAZADA' => 'secondary'
                ][$cita['estado_cita']] ?? 'primary';
            ?>
            <?php endforeach; ?>
            <div class="col">

                <?php if (!empty($citas)): ?>
                    <?php foreach ($citas as $cita): ?>



                        <div class="card h-100 border-0 shadow-sm hover-shadow">
                            <div class="card-header bg-transparent border-0 d-flex justify-content-between align-items-center pt-3">
                                <span class="badge bg-<?= $colorEstado ?>"><?= $cita['estado_cita'] ?></span>
                                <small class="text-muted"><i class="bi bi-calendar3"></i> <?= $cita['fecha'] ?></small>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title fw-bold">Dr. <?= $cita['especialista_nombre'] . ' ' . $cita['especialista_apellido'] ?></h5>
                                <p class="card-text text-primary mb-1"><i class="bi bi-stethoscope"></i> <?= $cita['servicio_nombre'] ?></p>
                                <p class="card-text"><i class="bi bi-clock"></i> <?= date('h:i A', strtotime($cita['hora_inicio'])) ?></p>
                            </div>
                            <div class="card-footer bg-transparent border-0 pb-3">
                                <button class="btn btn-outline-primary w-100 btn-detalle-paciente" data-id="<?= $cita['id_cita'] ?>">
                                    <i class="bi bi-eye me-2"></i>Ver Detalles
                                </button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

        </div>

    </div>
</div>

<div class="modal fade" id="modalCitaPaciente" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Detalle de tu Cita</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div id="detalleCitaBody" class="modal-body text-center py-4">
                <div class="spinner-border text-primary"></div>
            </div>
        </div>
    </div>
</div>

<?php include_once __DIR__ . '/../../layouts/footer_paciente.php'; ?>

<!-- <script>
    $(document).on('click', '.btn-detalle-paciente', function() {
        const idCita = $(this).data('id');
        const modal = new bootstrap.Modal(document.getElementById('modalCitaPaciente'));
        modal.show();

        $.get(`<?= BASE_URL ?>/paciente/ListaDeCitas?action=detalle_json&id=${idCita}`, function(data) {
            let html = `
            <div class="text-start">
                <p><strong>Especialista:</strong> Dr. ${data.especialista_nombre} ${data.especialista_apellido}</p>
                <p><strong>Servicio:</strong> ${data.servicio_nombre}</p>
                <p><strong>Fecha:</strong> ${data.fecha}</p>
                <p><strong>Hora:</strong> ${data.hora_inicio} - ${data.hora_fin}</p>
                <p><strong>Motivo:</strong> ${data.motivo_consulta || 'No especificado'}</p>
                <p><strong>Precio:</strong> $${data.servicio_precio}</p>
                <hr>
                <div class="alert alert-info">Recuerda llegar 15 minutos antes de tu cita.</div>
            </div>`;
            $('#detalleCitaBody').html(html);
        });
    });
</script> -->