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
                    <p class="mb-4">Gestione sus disponibilidades: Registre una disponibilidad, modifiquela y eliminela si es necesario.</p>
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <button class="btn btn-link text-primary p-0"
                                style="text-decoration: none; font-size: 14px;">
                                ← Todos (<?= count($horarios) ?>)
                            </button>
                        </div>
                        <a href="<?= BASE_URL ?>/especialista/registrar-disponibilidad" class="btn btn-primary btn-sm" style="border-radius: 20px;"><i class="bi bi-plus-lg"></i> AÑADIR</a>
                    </div>

                    <!-- Horarios Table -->
                    <div class="bg-white rounded shadow-sm p-4 cont-tabla-consultorios">
                        <table class="table-pacientes">
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
                                                <a href="<?= BASE_URL ?>/admin/consultar-disponibilidad"><i class="fa-solid fa-magnifying-glass"></i></a>
                                                <a href="<?= BASE_URL ?>/especialista/actualizar-disponibilidad?id=<?= $horario['id'] ?>"><i class="fa-solid fa-pen-to-square"></i></a>
                                                <a href="<?= BASE_URL ?>/admin/eliminar-disponibilidad?id=<?= $horario['id'] ?>&accion=eliminar"><i class="fa-solid fa-trash-can"></i></a>
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
    include_once __DIR__ . '/../../layouts/footer_especialista.php';
    ?>