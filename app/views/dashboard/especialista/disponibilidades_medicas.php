<?php
require_once BASE_PATH . '/app/helpers/session_especialista.php';
require_once BASE_PATH . '/app/controllers/horarioController.php';

$horarios = mostrarHorarios();
?>




<?php
include_once __DIR__ . '/../../layouts/header_especialista.php';
?>

<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <?php
            include_once __DIR__ . '/../../layouts/sidebar_especialista.php';
            ?>

            <!-- Main Content -->
            <div class="col-lg-10 col-md-9 main-content">

                <!-- Horarios Section -->
                <div id="HorariosSection" style="display: block;">
                    <!-- Top Bar -->
                    <?php
                    include_once __DIR__ . '/../../layouts/topbar_especialista.php';
                    ?>

                    <!-- Horarios Header -->
                    <h4 class="mb-4">Gestión de disponibilidades médicas</h4>
                    <p class="mb-4 d-none d-md-block">Gestione sus disponibilidades: Registre una disponibilidad, modifiquela y eliminela si es necesario.</p>
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <button class="btn btn-link text-primary p-0"
                                style="text-decoration: none; font-size: 14px;">
                                ← Todos (<?= count($horarios) ?>)
                            </button>
                        </div>
                        <a href="<?= BASE_URL ?>/especialista/registrar-disponibilidad" class="btn btn-primary btn-sm" style="border-radius: 20px;"><i class="bi bi-plus-lg"></i> AÑADIR</a>
                    </div>
                    <div class="card shadow-sm d-none d-lg-block">
                        <div class="card-header card-header-primary">
                            <h5 class="mb-0 text-white">
                                <i class="bi bi-calendar-check me-2"></i>
                                Disponibilidades médicas
                            </h5>
                        </div>
                        <div class="card-body" style="padding: 0;">
                            <?php if (empty($horarios)): ?>
                                <div class="alert alert-info text-center" role="alert">
                                    <i class="bi bi-info-circle me-2"></i>
                                    No tienes slots registrados en este momento
                                </div>
                            <?php else: ?>
                                <!-- Horarios Table -->
                                <div class="bg-white rounded shadow-sm p-4 cont-tabla-consultorios">
                                    <div class="table-responsive">
                                        <table class="table table-hover align-middle table-pacientes table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>
                                                        Día de atención
                                                        <i class="bi bi-chevron-down" style="font-size: 12px;"></i>
                                                    </th>
                                                    <th>Hora de inicio</th>
                                                    <th>Hora de fin</th>
                                                    <th>
                                                        Capacidad máxima de citas diarias
                                                        <i class="bi bi-chevron-down" style="font-size: 12px;"></i>
                                                    </th>
                                                    <th>Estado</th>
                                                    <th style="width: 80px;">Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if (!empty($horarios)) : ?>
                                                    <?php foreach ($horarios as $horario): ?>
                                                        <tr>
                                                            <?php
                                                            $diasArray = json_decode($horario['dia_semana'], true);
                                                            $diasTexto = is_array($diasArray) ? implode(',', $diasArray) : '';
                                                            ?>
                                                            <td><?= $diasTexto ?></td>
                                                            <td><?= $horario['hora_inicio'] ?></td>
                                                            <td><?= $horario['hora_fin'] ?></td>
                                                            <td><?= $horario['capacidad_maxima'] ?></td>
                                                            <td><?= $horario['estado_disponibilidad'] ?></td>
                                                            <td>
                                                                <a href="<?= BASE_URL ?>/especialista/consultar-disponibilidad?id=<?= $horario['id'] ?>" class="btn btn-info btn-sm text-white"><i class="fa-solid fa-magnifying-glass"></i></a>
                                                                <a href="<?= BASE_URL ?>/especialista/actualizar-disponibilidad?id=<?= $horario['id'] ?>" class="btn btn-success btn-sm text-white"><i class="fa-solid fa-pen-to-square"></i></a>
                                                                <a href="<?= BASE_URL ?>/especialista/eliminar-disponibilidad?id=<?= $horario['id'] ?>&accion=eliminar" class="btn btn-danger btn-sm text-white"><i class="fa-solid fa-trash-can"></i></a>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                <?php else: ?>
                                                    <td>No hay disponibilidades registradas</td>
                                                <?php endif; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>


                    <!-- VISTA MOVIL -->
                    <div class="row d-lg-none mt-3">
                        <?php if (!empty($horarios)): ?>
                            <?php foreach ($horarios as $horario): ?>
                                <div class="col-md-12 mt-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                <h5 class="card-title text-truncate">Disponibilidad médica</h5>
                                                <?php if ($horario['estado_disponibilidad'] === 'Activo'): ?>
                                                    <span class="status-badge bg-success text-white"><?= $horario['estado_disponibilidad'] ?></span>
                                                <?php else: ?>
                                                    <span class="status-badge bg-danger text-white"><?= $horario['estado_disponibilidad'] ?></span>
                                                <?php endif; ?>
                                            </div>
                                            <div class="mb-3">
                                                <?php $diasArray = json_decode($horario['dia_semana'], true);
                                                    $diasTexto = is_array($diasArray) ? implode(',', $diasArray) : ''; ?>
                                                <h6 class="card-subtitle mb-3 text-body-secondary">Días de atención: <?= $diasTexto ?></h6>
                                                <h6 class="card-subtitle mb-3 text-body-secondary">Hora de inicio: <?= $horario['hora_inicio'] ?></h6>
                                                <h6 class="card-subtitle mb-3 text-body-secondary">Hora de fin: <?= $horario['hora_fin'] ?></h6>
                                                <h6 class="card-subtitle mb-3 text-body-secondary">Capacidad máxima de citas: <?= $horario['capacidad_maxima'] ?></h6>
                                            </div>
                                            <div class="cont-botones d-flex justify-content-end gap-2">
                                                <a href="<?= BASE_URL ?>/especialista/consultar-disponibilidad?id=<?= $horario['id'] ?>" class="btn btn-info btn-sm text-white"><i class="fa-solid fa-magnifying-glass"></i></a>
                                                <a href="<?= BASE_URL ?>/especialista/actualizar-disponibilidad?id=<?= $horario['id'] ?>" class="btn btn-success btn-sm text-white"><i class="fa-solid fa-pen-to-square"></i></a>
                                                <a href="<?= BASE_URL ?>/especialista/eliminar-disponibilidad?id=<?= $horario['id'] ?>&accion=eliminar" class="btn btn-danger btn-sm text-white"><i class="fa-solid fa-trash-can"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p>No hay disponibilidades registradas.</p>

                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
    include_once __DIR__ . '/../../layouts/footer_especialista.php';
    ?>