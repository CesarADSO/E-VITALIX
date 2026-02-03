<?php
require_once BASE_PATH . '/app/helpers/session_especialista.php';
require_once BASE_PATH . '/app/controllers/slotController.php';

$slots = mostrarSlots();
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
                    <h4 class="mb-4">Gestión de slots de agenda</h4>
                    <p class="mb-4">Gestione sus bloques en los cuales puede atender pacientes: Acá podrá visualizarlos, y modificar su estado si es necesario.</p>
                    <!-- Horarios Table -->
                    <div class="card shadow-sm">
                        <div class="card-header card-header-primary">
                            <h5 class="mb-0 text-white">
                                <i class="bi bi-calendar-check me-2"></i>
                                Slots de Agenda
                            </h5>
                        </div>
                        <div class="card-body" style="padding: 0;">
                            <?php if (empty($slots)): ?>
                                <div class="alert alert-info text-center" role="alert">
                                    <i class="bi bi-info-circle me-2"></i>
                                    No tienes slots registrados en este momento
                                </div>
                            <?php else: ?>
                                <div class="bg-white rounded shadow-sm p-4 cont-tabla-consultorios table-responsive">
                                    <table class="table table-hover align-middle table-pacientes table-bordered" id="tablaSlots">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Disponibilidad</th>
                                                <th>
                                                    Especialista
                                                    <i class="bi bi-chevron-down" style="font-size: 12px;"></i>
                                                </th>
                                                <th>Consultorio</th>
                                                <th>Fecha</th>
                                                <th>Hora inicio</th>
                                                <th>Hora fin</th>
                                                <th>Estado</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($slots)): ?>
                                                <?php foreach ($slots as $slot): ?>
                                                    <tr>
                                                        <td><?= $slot['id_disponibilidad'] ?></td>
                                                        <td><?= $slot['nombres'] ?> <?= $slot['apellidos'] ?></td>
                                                        <td><?= $slot['nombre_consultorio'] ?></td>
                                                        <td><?= date('d/m/Y', strtotime($slot['fecha'])) ?></td>
                                                        <td><?= substr($slot['hora_inicio'], 0, 5) ?></td>
                                                        <td><?= substr($slot['hora_fin'], 0, 5) ?></td>
                                                        <td>

                                                            <?php if ($slot['estado_slot'] === 'Disponible') : ?>
                                                                <a style="text-decoration: none;" class="badge bg-success status-badge status" href="<?= BASE_URL ?>/especialista/actualizar-slot?id=<?= $slot['id'] ?>&accion=modificarEstado"><?= $slot['estado_slot'] ?></a>
                                                            <?php elseif ($slot['estado_slot'] === 'Reservado'): ?>
                                                                <a style="text-decoration: none;" class="badge bg-secondary status-badge status" href="<?= BASE_URL ?>/especialista/actualizar-slot?id=<?= $slot['id'] ?>&accion=modificarEstado"><?= $slot['estado_slot'] ?></a>
                                                            <?php else: ?>
                                                                <a style="text-decoration: none;" class="badge bg-danger status-badge status" href="<?= BASE_URL ?>/especialista/actualizar-slot?id=<?= $slot['id'] ?>&accion=modificarEstado"><?= $slot['estado_slot'] ?></a>
                                                            <?php endif; ?>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <td>No hay slots registrados</td>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
    include_once __DIR__ . '/../../layouts/footer_especialista.php';
    ?>