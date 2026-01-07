<?php
require_once BASE_PATH . '/app/helpers/session_paciente.php';
require_once BASE_PATH . '/app/controllers/citaController.php';

$citas = mostrarCitas();
?>

<?php
include_once __DIR__ . '/../../layouts/header_paciente.php';
?>

<div class="container-fluid">
    <div class="row">

        <?php include_once __DIR__ . '/../../layouts/sidebar_paciente.php'; ?>

        <div class="col-lg-10 col-md-9 main-content">

            <!-- Top Bar -->
            <?php include_once __DIR__ . '/../../layouts/topbar_paciente.php'; ?>

            <!-- Header -->
            <h4 class="mb-4">Gestión de citas médicas</h4>
            <p class="mb-4">Gestione sus citas médicas: Agende una cita, reagéndela y cancélela si es necesario.</p>
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <button class="btn btn-link text-primary p-0"
                        style="text-decoration: none; font-size: 14px;">
                        ← Todos (0)
                    </button>
                </div>
                <a href="<?= BASE_URL ?>/paciente/agendarCita" class="btn btn-primary btn-sm" style="border-radius: 20px;">
                    <i class="bi bi-plus-lg"></i> Agendar cita
                </a>
            </div>

            <!-- Tabla de Citas -->
            <div class="bg-white rounded shadow-sm p-4 ">



                <table class="table-pacientes">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Hora</th>
                            <th>Especialista</th>
                            <th>Consultorio</th>
                            <th>Estado</th>
                            <th style="width: 80px;">Acciones</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php if (!empty($citas)) : ?>
                            <?php foreach ($citas as $cita): ?>
                                <tr>
                                    <td><?= date('d/m/Y', strtotime($cita['fecha'])) ?></td>
                                    <td><?= substr($cita['hora_inicio'], 0, 5) ?> - <?= substr($cita['hora_fin'], 0, 5) ?></td>
                                    <td><?= $cita['nombres'] ?> <?= $cita['apellidos'] ?></td>
                                    <td><?= $cita['nombre_consultorio'] ?></td>
                                    <td><?= $cita['estado_cita'] ?></td>
                                    <td>
                                        <a href="#"><i class="fa-solid fa-magnifying-glass"></i></a>
                                        <a href="<?= BASE_URL ?>/paciente/reagendarCita?id=<?= $cita['id'] ?>"><i class="fa-solid fa-pen-to-square"></i></a>
                                        <a href="<?= BASE_URL ?>/paciente/cancelarCita?id=<?= $cita['id'] ?>&accion=cancelar"><i class="fa-solid fa-x"></i></a>
                                    </td>
                                </tr>

                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="6" class="text-center text-muted">
                                    ¡No hay citas agendadas!
                                </td>
                            </tr>
                        <?php endif; ?>


                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

<?php include_once __DIR__ . '/../../layouts/footer_paciente.php'; ?>