<?php
require_once BASE_PATH . '/app/helpers/session_paciente.php';
include_once __DIR__ . '/../../layouts/header_paciente.php';
require_once BASE_PATH . '/app/controllers/citaController.php';

// Lógica para paginación segura

// 1. Traer todos las citas de la base de datos
$todas_las_citas = mostrarCitas();


// 2. Configurar la paginación
$registros_por_pagina = 10; // Mostrar 10 citas por página
$total_registros = is_array($todas_las_citas) ? count($todas_las_citas) : 0;
$total_paginas = ceil($total_registros / $registros_por_pagina);

// 3. Capturar en que página estamos
$pagina_actual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;

// 4. Validar que la pagina actual sea un número válido y esté dentro del rango permitido
if ($pagina_actual < 1) {
    $pagina_actual = 1;
}

if ($pagina_actual > $total_paginas && $total_paginas > 0) {
    $pagina_actual = $total_paginas;
}

// 5. Calcular el índice de inicio para la consulta SQL
$indice_inicio = ($pagina_actual - 1) * $registros_por_pagina;
$citas = is_array($todas_las_citas) ? array_slice($todas_las_citas, $indice_inicio, $registros_por_pagina) : [];
?>
?>

<body>

    <div class="container-fluid">
        <div class="row">

            <?php include_once __DIR__ . '/../../layouts/sidebar_paciente.php'; ?>

            <div class=" col-lg-10 col-md-9 main-content">
                <div id="citasSection">
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
                        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                            <?php foreach ($citas as $cita):
                                $colorEstado = [
                                    'PENDIENTE' => 'warning',
                                    'CONFIRMADA' => 'success',
                                    'CANCELADA' => 'danger',
                                    'RECHAZADA' => 'secondary'
                                ][$cita['estado_cita']] ?? 'primary';
                            ?>
                                <div class="col">



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
                                        <div class="card-footer d-flex justify-content-between bg-transparent border-0 pb-3">
                                            <?php if ($cita['estado_cita'] === 'PENDIENTE'): ?>
                                                <a href="<?= BASE_URL ?>/paciente/reprogramar-cita?id_cita=<?= $cita['id_cita'] ?>&id_servicio=<?= $cita['id_servicio'] ?>&id_consultorio=<?= $cita['id_consultorio'] ?>&id_especialidad=<?= $cita['id_especialidad'] ?>&id_especialista=<?= $cita['id_especialista'] ?>" class="btn btn-sm btn-success mx-2" title="Reprogramar cita médica">
                                                    <i class="fa-solid fa-pen-to-square text-white"></i>
                                                </a>
                                                <a href="<?= BASE_URL ?>/paciente/cancelar-cita?id_cita=<?= $cita['id_cita'] ?>&accion=cancelar" class="btn btn-sm btn-danger mx-2" title="Cancelar cita médica">
                                                    <i class="fa-solid fa-x text-white"></i>
                                                </a>

                                                <a href="<?= BASE_URL ?>/paciente/detalle-cita?id_cita=<?= $cita['id_cita'] ?>" class="btn btn-sm btn-outline-primary w-100 btn-detalle-paciente mx-2"><i class="bi bi-eye me-2"></i>Ver Detalles</a>
                                            <?php else: ?>

                                                <a href="<?= BASE_URL ?>/paciente/detalle-cita?id_cita=<?= $cita['id_cita'] ?>" class="btn btn-sm btn-outline-primary w-100 btn-detalle-paciente mx-2"><i class="bi bi-eye me-2"></i>Ver Detalles</a>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>


                            <?php if (isset($total_paginas) && $total_paginas > 1) : ?>
                                <div class="col-12 mt-4 mb-5">
                                    <nav aria-label="Navegación de horarios móvil">
                                        <ul class="pagination pagination-sm justify-content-center">

                                            <!-- Si la página actual es menor o igual a 1 entonces ponemos la clase disabled para evitar que se pueda ir a una página "0" que no existe y al botón anterior cogemos la página actual y le restamos 1 para volver una página atrás -->
                                            <li class="page-item <?= ($pagina_actual <= 1) ? 'disabled' : '' ?>">
                                                <a class="page-link" href="?pagina=<?= $pagina_actual - 1 ?>">
                                                    <i class="bi bi-chevron-left"></i>
                                                </a>
                                            </li>

                                            <!-- Si la página actual es igual a 1 entonces ponemos la clase active que pinta el botón de azulito y a ese botón le ponemos el número 1 -->

                                            <li class="page-item <?= ($pagina_actual == 1) ? 'active' : '' ?>">
                                                <a class="page-link" href="?pagina=1">1</a>
                                            </li>
                                            <!-- Si la página actual es mayor a 3 entonces mostramos un botón con puntos suspensivos pero con la clase disabled eso quiere decir que se muestran de a 3 botones disponibles para presionar -->
                                            <?php if ($pagina_actual > 3): ?>
                                                <li class="page-item disabled"><span class="page-link">...</span></li>
                                            <?php endif; ?>

                                            <!-- Aquí hacemos el bucle para que los botones de paginación se muestren según el número de página que sean necesarias para mostrar todos los registros -->
                                            <?php for ($i = max(2, $pagina_actual - 1); $i <= min($total_paginas - 1, $pagina_actual + 1); $i++) : ?>
                                                <li class="page-item <?= ($pagina_actual == $i) ? 'active' : '' ?>">
                                                    <a class="page-link" href="?pagina=<?= $i ?>"><?= $i ?></a>
                                                </li>
                                            <?php endfor; ?>

                                            <!-- Si la página actual es menor que el total de páginas menos 2 entonces mostramos un botón con puntos suspensivos pero con la clase disabled -->
                                            <?php if ($pagina_actual < $total_paginas - 2): ?>
                                                <li class="page-item disabled"><span class="page-link">...</span></li>
                                            <?php endif; ?>

                                            <!-- Si la página actual es igual al total de páginas entonces ponemos la clase active que pinta el botón de azulito -->
                                            <li class="page-item <?= ($pagina_actual == $total_paginas) ? 'active' : '' ?>">
                                                <a class="page-link" href="?pagina=<?= $total_paginas ?>"><?= $total_paginas ?></a>
                                            </li>


                                            <!-- Si la página actual es mayor o igual al total de páginas entonces desabilitamos la flecha derecha para evitar que siga avanzando a una página que no existe -->
                                            <li class="page-item <?= ($pagina_actual >= $total_paginas) ? 'disabled' : '' ?>">
                                                <a class="page-link" href="?pagina=<?= $pagina_actual + 1 ?>">
                                                    <i class="bi bi-chevron-right"></i>
                                                </a>
                                            </li>

                                        </ul>
                                    </nav>
                                </div>

                            <?php endif; ?>
                        <?php endif; ?>

                        </div>
                </div>
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
</script>