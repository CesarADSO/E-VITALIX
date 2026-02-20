<!-- AQUI VA EL INCLUDE DEL HEADER -->
<?php
include_once __DIR__ . '/../../../views/layouts/header_especialista.php';
require_once BASE_PATH . '/app/helpers/session_especialista.php';
require_once BASE_PATH . '/app/controllers/misCitasController.php';
?>

<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <?php
            include_once __DIR__ . '/../../../views/layouts/sidebar_especialista.php';
            ?>

            <!-- Main Content -->
            <div class="col-lg-10 col-md-9 main-content">
                <!-- Top Bar -->
                <?php
                include_once __DIR__ . '/../../../views/layouts/topbar_especialista.php';
                ?>

                <!-- Título de la sección -->
                <div class="mb-4">
                    <h3 class="fw-bold">Mis Citas</h3>
                    <p class="text-muted">Gestiona las citas que los pacientes han agendado contigo</p>
                </div>

                <!-- Estadísticas de Citas -->
                <div class="stats-cards mb-4">
                    <div class="stat-card">
                        <div class="stat-label">Citas Pendientes</div>
                        <div class="stat-value"><?= $estadisticas['PENDIENTE'] ?? 0 ?></div>
                        <div class="stat-subtitle">Por revisar</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-label">Citas Aceptadas</div>
                        <div class="stat-value"><?= $estadisticas['CONFIRMADA'] ?? 0 ?></div>
                        <div class="stat-subtitle">Confirmadas</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-label">Citas Canceladas</div>
                        <div class="stat-value"><?= $estadisticas['CANCELADA'] ?? 0 ?></div>
                        <div class="stat-subtitle">No realizadas</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-label">Citas Rechazadas</div>
                        <div class="stat-value"><?= $estadisticas['RECHAZADA'] ?? 0 ?></div>
                        <div class="stat-subtitle">Declinadas</div>
                    </div>
                </div>

                <!-- Tabla de Citas -->
                <div class="card shadow-sm">
                    <div class="card-header card-header-primary">
                        <h5 class="mb-0 text-white">
                            <i class="bi bi-calendar-check me-2"></i>
                            Lista de Citas
                        </h5>
                    </div>
                    <div class="card-body">
                        <?php if (empty($citas)): ?>
                            <div class="alert alert-info text-center" role="alert">
                                <i class="bi bi-info-circle me-2"></i>
                                No tienes citas registradas en este momento
                            </div>
                        <?php else: ?>
                            <div class="table-responsive">
                                <table class="table table-hover align-middle table-pacientes table-bordered" id="tablaCitas">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Foto</th>
                                            <th>Nombres y apellidos</th>
                                            <th>Fecha</th>
                                            <th>Hora Inicio</th>
                                            <th>Servicio</th>
                                            <th>Estado</th>
                                            <th class="text-center">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($citas as $cita): ?>
                                            <tr data-cita-id="<?= $cita['id_cita'] ?>">
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="user-avatar">
                                                            <img class="adminImg" src="<?= BASE_URL ?>/public/uploads/pacientes/<?= $cita['foto_paciente'] ?>" alt="<?= $cita['nombre_paciente'] ?>">
                                                        </div>
                                                        <div>
                                                            
                                                        </div>
                                                    </div>
                                                </td>
                                                <td><strong><?= htmlspecialchars($cita['nombre_paciente']) ?></strong></td>
                                                <td>
                                                    <i class="bi bi-calendar3 me-1"></i>
                                                    <?= date('d/m/Y', strtotime($cita['fecha'])) ?>
                                                </td>
                                                <td>
                                                    <i class="bi bi-clock me-1"></i>
                                                    <?= date('h:i A', strtotime($cita['hora_inicio'])) ?>
                                                </td>
                                                <td><?= htmlspecialchars($cita['servicio_nombre'] ?? 'Sin servicio') ?></td>
                                                <td>
                                                    <?php if ($cita['estado_cita'] === 'CONFIRMADA'): ?>
                                                        <span class="status-badge status status-aceptada">
                                                        <?= $cita['estado_cita'] ?>
                                                        </span>
                                                    <?php elseif ($cita['estado_cita'] === 'PENDIENTE'): ?>
                                                    <span class="status-badge status status-pendiente">
                                                        <?= $cita['estado_cita'] ?>
                                                    </span>
                                                    <?php elseif($cita['estado_cita'] === 'COMPLETADA'):?>
                                                        <span class="status-badge status status-completada">
                                                        <?= $cita['estado_cita'] ?>
                                                    </span>
                                                    <?php else:?>
                                                    <span class="status-badge status status-cancelada">
                                                        <?= $cita['estado_cita'] ?>
                                                    </span>
                                                    <?php endif; ?>
                                                </td>
                                                <td class="text-center">
                                                    <div class="btn-group" role="group">
                                                        <?php if ($cita['estado_cita'] === 'PENDIENTE'): ?>
                                                            <a href="<?= BASE_URL ?>/especialista/aceptar-cita?id=<?= $cita['id_cita'] ?>&accion=aceptar" class="btn btn-sm btn-success btn-aceptar"
                                                                data-cita-id="<?= $cita['id_cita'] ?>"
                                                                title="Aceptar cita">
                                                                <i class="bi bi-check-circle"></i></a>
                                                            <a href="<?= BASE_URL ?>/especialista/cancelar-cita?id=<?= $cita['id_cita'] ?>&accion=cancelar" class="btn btn-sm btn-danger btn-cancelar"
                                                                data-cita-id="<?= $cita['id_cita'] ?>"
                                                                title="Cancelar cita">
                                                                <i class="bi bi-x-circle"></i></a>
                                                        <?php elseif ($cita['estado_cita'] === 'CONFIRMADA'): ?>
                                                            <a href="<?= BASE_URL ?>/especialista/iniciar-consulta?id_cita=<?= $cita['id_cita'] ?>&id_paciente=<?= $cita['id_paciente'] ?>" class="btn btn-sm btn-info" title="Iniciar consulta"><i class="fa-solid fa-book" style="color: #fff;"></i></a>
                                                        <?php else: ?>
                                                            <span class="text-muted small">Sin acciones disponibles</span>
                                                        <?php endif; ?>

                                                        <button
                                                            class="btn btn-sm btn-info btn-detalle ms-1"
                                                            data-cita-id="<?= $cita['id'] ?>"
                                                            title="Ver detalles">
                                                            <i class="bi bi-eye"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Confirmación -->
    <div class="modal fade" id="modalConfirmacion" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitulo">Confirmar Acción</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="modalMensaje">
                    ¿Estás seguro de realizar esta acción?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" id="btnConfirmarAccion">Confirmar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Detalle de Cita -->
    <div class="modal fade" id="modalDetalle" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header card-header-primary">
                    <h5 class="modal-title text-white">
                        <i class="bi bi-info-circle me-2"></i>
                        Detalles de la Cita
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="modalDetalleContenido">
                    <div class="text-center py-4">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Cargando...</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- AQUI VA EL FOOTER INCLUDE -->
    <?php
    include_once __DIR__ . '/../../../views/layouts/footer_especialista.php';
    ?>
</body>