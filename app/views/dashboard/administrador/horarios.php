<?php
require_once BASE_PATH . '/app/helpers/session_admin.php';
require_once BASE_PATH . '/app/controllers/horarioController.php';

$horarios = mostrarHorarios();
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

                <!-- Horarios Section -->
                <div id="HorariosSection" style="display: block;">
                    <!-- Top Bar -->
                    <?php
                    include_once __DIR__ . '/../../layouts/topbar_administrador.php';
                    ?>

                    <!-- Horarios Header -->
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <button class="btn btn-link text-primary p-0"
                                style="text-decoration: none; font-size: 14px;">
                                ← Todos (<?= count($horarios) ?>)
                            </button>
                        </div>
                        <a href="<?= BASE_URL ?>/admin/registrar-horario" class="btn btn-primary btn-sm" style="border-radius: 20px;"><i class="bi bi-plus-lg"></i> AÑADIR</a>
                    </div>

                    <!-- Horarios Table -->
                    <div class="bg-white rounded shadow-sm p-4 cont-tabla-consultorios">
                        <table class="table-pacientes">
                            <thead>
                                <tr>
                                    <th>
                                        Especialista
                                        <i class="bi bi-chevron-down" style="font-size: 12px;"></i>
                                    </th>
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
                                            <td><?= $horario['nombres'] ?> <?= $horario['apellidos'] ?></td>
                                            <td><?= $horario['dia_semana'] ?></td>
                                            <td><?= $horario['hora_inicio'] ?></td>
                                            <td><?= $horario['hora_fin'] ?></td>
                                            <td><?= $horario['capacidad_maxima'] ?></td>
                                            <td><?= $horario['estado_disponibilidad'] ?></td>
                                            <td>
                                                <a href="<?= BASE_URL ?>/admin/consultar-horario"><i class="fa-solid fa-magnifying-glass"></i></a>
                                                <a href="<?= BASE_URL ?>/admin/actualizar-horario?id=<?= $horario['id'] ?>"><i class="fa-solid fa-pen-to-square"></i></a>
                                                <a href="<?= BASE_URL ?>/admin/eliminar-horario?id=<?= $horario['id'] ?>&accion=eliminar"><i class="fa-solid fa-trash-can"></i></a>
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
            </div>
        </div>
    </div>

    <?php
    include_once __DIR__ . '/../../layouts/footer_administrador.php';
    ?>