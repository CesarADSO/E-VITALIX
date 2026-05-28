<?php
require_once BASE_PATH . '/app/helpers/session_paciente.php';
require_once BASE_PATH . '/app/controllers/slotController.php';

$slots = mostrarSlots2();
?>

<?php
include_once __DIR__ . '/../../layouts/header_paciente.php';
?>

<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <?php
            include_once __DIR__ . '/../../layouts/sidebar_paciente.php';
            ?>

            <!-- Main Content -->
            <div class="col-lg-10 col-md-9 main-content">

                <!-- Horarios Section -->
                <div id="HorariosSection" style="display: block;">
                    <!-- Top Bar -->
                    <?php
                    include_once __DIR__ . '/../../layouts/topbar_paciente.php';
                    ?>

                    <!-- Horarios Header -->
                    <h4 class="mb-4">Gestión de slots de agenda</h4>
                    <p class="mb-4">Gestione sus bloques en los cuales puede atender pacientes: Acá podrá visualizarlos, y modificar su estado si es necesario.</p>
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <button class="btn btn-link text-primary p-0"
                                style="text-decoration: none; font-size: 14px;">
                                ← Todos (2)
                            </button>
                        </div>
                        <!-- <a href="<?= BASE_URL ?>/especialista/registrar-disponibilidad" class="btn btn-primary btn-sm" style="border-radius: 20px;"><i class="bi bi-plus-lg"></i> AÑADIR</a> -->
                    </div>

                    <!-- Slots Table -->
                    <div class="card shadow-sm d-none d-lg-block">
                        <div class="card-header card-header-primary">
                            <h5 class="mb-0 text-white">
                                <i class="bi bi-calendar-check me-2"></i>
                                Lista de slots disponibles
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="bg-white rounded shadow-sm p-4">
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle table-pacientes table-bordered">
                                    <thead>
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
                                                    <td><?= $slot['fecha'] ?></td>
                                                    <td><?= $slot['hora_inicio'] ?></td>
                                                    <td><?= $slot['hora_fin'] ?></td>
                                                    <td>
                                                        <?php if($slot['estado_slot'] === 'Disponible') :?>
                                                        <span class="badge bg-success"><?= $slot['estado_slot'] ?></span>
                                                        <?php elseif ($slot['estado_slot'] === 'Reservado'):?>
                                                            <span class="badge bg-secondary"><?= $slot['estado_slot'] ?></span>
                                                        <?php else:?>
                                                            <span class="badge bg-danger"><?= $slot['estado_slot'] ?></span>
                                                        <?php endif;?>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td>No hay slots registrados</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                                </div>
                            </div>
                        </div>
                    </div>



                </div>
            </div>
        </div>
    </div>

    <?php
    include_once __DIR__ . '/../../layouts/footer_paciente.php';
    ?>