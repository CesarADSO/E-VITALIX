<?php
require_once BASE_PATH . '/app/helpers/session_administrador.php';
require_once BASE_PATH . '/app/controllers/especialidadController.php';

$especialidades = listarEspecialidades();
?>


<?php
include_once __DIR__ . '/../../layouts/header_administrador.php';
?>

<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <?php
            include_once __DIR__ . '/../../layouts/sidebar_administrador.php';
            ?>

            <!-- Main Content -->
            <div class="col-lg-10 col-md-9 main-content">

                <!-- especialidades Section -->
                <div id="especialidadesSection" style="display: block;">
                    <!-- Top Bar -->
                    <?php
                    include_once __DIR__ . '/../../layouts/topbar_administrador.php';
                    ?>

                    <!-- Pacientes Header -->
                    <h4 class="mb-4">Gestión de especialidades del consultorio</h4>
                    <p class="mb-4 d-none d-md-block">Gestione las especialidades de su consultorio.</p>
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <button class="btn btn-link text-primary p-0"
                                style="text-decoration: none; font-size: 14px;">
                                ← Todos (0)
                            </button>
                        </div>
                        <a class="btn btn-primary btn-sm btn-añadir-volver" href="<?= BASE_URL ?>/admin/asociar-especialidad"><i class="bi bi-plus-lg"></i> ASOCIAR</a>
                    </div>

                    <div class="card shadow-sm d-none d-lg-block">
                        <div class="card-header card-header-primary">
                            <h5 class="mb-0 text-white">
                                <i class="bi bi-calendar-check me-2"></i>
                                Lista de especialidades
                            </h5>
                        </div>
                        <div class="card-body">
                            <!-- <div class="alert alert-info text-center" role="alert">
                                    <i class="bi bi-info-circle me-2"></i>
                                    No tienes especialidades registradas.
                                </div> -->
                            <!-- asistentes Table -->
                            <div class="bg-white rounded shadow-sm p-4">
                                <!-- <a class="btn btn-primary boton-reporte" href="<?= BASE_URL ?>/admin/generar-reporte?tipo=asistentes" target="_blank">Generar reporte pdf</a> -->
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle table-pacientes table-bordered">
                                        <thead>
                                            <tr>
                                                <th>
                                                    Nombre
                                                    <i class="bi bi-chevron-down" style="font-size: 12px;"></i>
                                                </th>
                                                <th>Descripción</th>
                                                <th>Estado</th>
                                                <th style="width: 80px;">Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($especialidades)): ?>
                                                <?php foreach ($especialidades as $especialidad): ?>
                                                    <tr>
                                                        <td><?= $especialidad['nombre'] ?></td>
                                                        <td><?= $especialidad['descripcion'] ?></td>
                                                        <td>
                                                            <?php if ($especialidad['estado'] === 'ACTIVA'): ?>
                                                                <span class="badge bg-success status-bagde status text-white"><?= $especialidad['estado'] ?></span>
                                                                <!-- <a class="badge bg-success status-badge status btn-estado" href="<?= BASE_URL ?>/admin/cambiar-estado-especialidad?id=<?= $especialidad['id'] ?>&accion=modificarEstado"><?= $especialidad['estado'] ?></a> -->
                                                            <?php else: ?>
                                                                <span class="badge bg-danger status-bagde status text-white"><?= $especialidad['estado'] ?></span>
                                                                <!-- <a class="badge bg-danger status-badge status btn-estado" href="<?= BASE_URL ?>/admin/cambiar-estado-especialidad?id=<?= $especialidad['id'] ?>&accion=modificarEstado"><?= $especialidad['estado'] ?></a> -->
                                                            <?php endif; ?>
                                                        </td>
                                                        <td>
                                                            <a href="<?= BASE_URL ?>/admin/desasociar-especialidad?id=<?= $especialidad['id'] ?>&accion=desasociar" class="btn btn-sm btn-danger btn-editar-especialidad" title="Desasociar especialidad"><i class="fa-solid fa-x"></i></a>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <h2>Aún no has asociado ninguna especialidad a tu consultorio.</h2>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- VISTA MOVIL -->
                    <div class="row d-lg-none mt-3">
                        <?php if (!empty($especialidades)): ?>
                            <?php foreach ($especialidades as $especialidad): ?>
                                <div class="col-md-12 mt-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                <h5 class="card-title text-truncate"><?= $especialidad['nombre'] ?></h5>
                                                <?php if ($especialidad['estado'] === 'ACTIVA'): ?>
                                                    <span class="status-badge bg-success text-white"><?= $especialidad['estado'] ?></span>
                                                <?php else: ?>
                                                    <span class="status-badge bg-danger text-white"><?= $servicio['estado'] ?></span>
                                                <?php endif; ?>
                                            </div>
                                            <div class="mb-3">
                                                <h6 class="card-subtitle mb-2 text-body-secondary">Descripción: <?= $especialidad['descripcion'] ?></h6>
                                            </div>
                                            <div class="cont-botones d-flex justify-content-end gap-2">
                                                <a href="<?= BASE_URL ?>/admin/desasociar-especialidad?id=<?= $especialidad['id'] ?>&accion=desasociar" class="btn btn-sm btn-danger btn-editar-especialidad" title="Desasociar especialidad"><i class="fa-solid fa-x"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p>No hay especialidades registradas.</p>

                        <?php endif; ?>
                    </div>

                </div>



            </div>
        </div>
    </div>
    <?php
    include_once __DIR__ . '/../../layouts/footer_administrador.php';
    ?>