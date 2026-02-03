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

                    <!-- Horarios Table -->
                    <div class="bg-white rounded shadow-sm p-4 cont-tabla-consultorios">
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
                                                <a style="text-decoration: none;" class="badge bg-success" href="<?= BASE_URL ?>/especialista/actualizar-slot?id=<?= $slot['id'] ?>&accion=modificarEstado"><?= $slot['estado_slot'] ?></a>
                                                <?php elseif ($slot['estado_slot'] === 'Reservado'):?>
                                                    <a style="text-decoration: none;" class="badge bg-secondary" href="<?= BASE_URL ?>/especialista/actualizar-slot?id=<?= $slot['id'] ?>&accion=modificarEstado"><?= $slot['estado_slot'] ?></a>
                                                <?php else:?>
                                                    <a style="text-decoration: none;" class="badge bg-danger" href="<?= BASE_URL ?>/especialista/actualizar-slot?id=<?= $slot['id'] ?>&accion=modificarEstado"><?= $slot['estado_slot'] ?></a>
                                                <?php endif;?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <td>No hay slots registrados</td>
                                <?php endif; ?>
                            </tbody>
                        </table>
                        </div>
                    </div>



                </div>
            </div>
        </div>
    </div>

    <?php
    include_once __DIR__ . '/../../layouts/footer_paciente.php';
    ?>