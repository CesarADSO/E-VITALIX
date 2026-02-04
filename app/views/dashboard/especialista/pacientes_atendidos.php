<?php
include_once __DIR__ . '/../../../views/layouts/header_especialista.php';
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

                <!-- historiales Header -->
                <h4 class="mb-4">Gestión de historiales clínicos de pacientes atendidos</h4>
                <p class="mb-4">Consulte los historiales clínicos de los pacientes atendidos por usted.</p>

                <div class="card shadow-sm">
                    <div class="card-header card-header-primary">
                        <h5 class="mb-0 text-white">
                            <i class="bi bi-calendar-check me-2"></i>
                            Pacientes atendidos
                        </h5>
                    </div>
                    <div class="card-body" style="padding: 0;">
                        <!-- <?php if (empty($horarios)): ?>
                            <div class="alert alert-info text-center" role="alert">
                                <i class="bi bi-info-circle me-2"></i>
                                No tienes slots registrados en este momento
                            </div>
                        <?php else: ?> -->
                            <!-- Pacientes Table -->
                            <div class="bg-white rounded shadow-sm p-4 cont-tabla-pacientes">
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
                                                            <a href="<?= BASE_URL ?>/especialista/consultar-disponibilidad?id=<?= $horario['id'] ?>"><i class="fa-solid fa-magnifying-glass"></i></a>
                                                            <a href="<?= BASE_URL ?>/especialista/actualizar-disponibilidad?id=<?= $horario['id'] ?>"><i class="fa-solid fa-pen-to-square"></i></a>
                                                            <a href="<?= BASE_URL ?>/especialista/eliminar-disponibilidad?id=<?= $horario['id'] ?>&accion=eliminar"><i class="fa-solid fa-trash-can"></i></a>
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