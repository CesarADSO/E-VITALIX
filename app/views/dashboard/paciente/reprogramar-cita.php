<?php
include_once __DIR__ . '/../../layouts/header_paciente.php';
require_once BASE_PATH . '/app/controllers/slotController.php';
require_once BASE_PATH . '/app/controllers/servicioController.php';

$id_consultorio = $_GET['id_consultorio'];
$id_especialidad = $_GET['id_especialidad'];
$id_servicio = $_GET['id_servicio'];
$id_cita = $_GET['id_cita'];

$servicio = consultarNombreServicio($id_servicio);


$espaciosDeAgendamiento = listarDisponibilidad($id_consultorio, $id_especialidad, $id_servicio);
?>

<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <!-- AQUI VA EL INCLUDE EL SIDEBAR -->

            <?php
            include_once __DIR__ . '/../../layouts/sidebar_paciente.php';
            ?>

            <!-- Main Content -->
            <div class="col-lg-10 col-md-9 main-content">
                <!-- Dashboard Section -->
                <div id="dashboardSection">
                    <!-- Top Bar -->
                    <!-- AQUI VA EL INCLUDE DEL TOP BAR -->

                    <?php
                    include_once __DIR__ . '/../../layouts/topbar_paciente.php';
                    ?>

                    <!-- Header de la sección -->
                    <div class="header-seccion">
                        <div class="header-content">
                            <h1 class="header-title">
                                <i class="bi bi-calendar-check-fill"></i>
                                Selecciona tu Horario
                            </h1>

                            <div class="servicio-info">
                                <div class="servicio-label">Servicio Seleccionado</div>
                                <h3 class="servicio-nombre text-white">
                                    <?= $servicio['nombre'] ?>
                                </h3>
                            </div>
                        </div>
                    </div>

                    <!-- Grid de horarios disponibles -->
                    <div class="row">

                        <!-- Horario 1 -->
                        <?php if (!empty($espaciosDeAgendamiento)) : ?>
                            <?php foreach ($espaciosDeAgendamiento as $espacioDeAgendamiento): ?>

                                <div class="col-md-4 mb-4">
                                    <div class="horario-card">
                                        <div class="horario-card-header">
                                            <div class="patient-avatar">
                                                <img class="img-usuario" src="<?= BASE_URL ?>/public/uploads/usuarios/<?= $espacioDeAgendamiento['foto_especialista'] ?>" alt="<?= $espacioDeAgendamiento['nombre_especialista'] ?> <?= $espacioDeAgendamiento['apellidos_especialista'] ?>">
                                            </div>
                                            <h5 class="doctor-nombre"><?= $espacioDeAgendamiento['nombre_especialista'] ?> <?= $espacioDeAgendamiento['apellidos_especialista'] ?></h5>
                                            <span class="badge-disponible">
                                                <i class="bi bi-check-circle-fill"></i>
                                                <?= $espacioDeAgendamiento['estado_slot'] ?>
                                            </span>
                                        </div>

                                        <div class="horario-card-body">
                                            <div class="horario-info-group">
                                                <div class="horario-info-item">
                                                    <div class="horario-info-icon">
                                                        <i class="bi bi-calendar-event-fill"></i>
                                                    </div>
                                                    <div class="horario-info-content">
                                                        <div class="horario-info-label">Fecha</div>
                                                        <div class="horario-info-value"><?= date('d/m/Y', strtotime($espacioDeAgendamiento['fecha'])) ?></div>
                                                    </div>
                                                </div>

                                                <div class="horario-info-item">
                                                    <div class="horario-info-icon">
                                                        <i class="bi bi-clock-fill"></i>
                                                    </div>
                                                    <div class="horario-info-content">
                                                        <div class="horario-info-label">Hora</div>
                                                        <div class="horario-info-value"><?= $espacioDeAgendamiento['hora_inicio'] ?> - <?= $espacioDeAgendamiento['hora_fin'] ?></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="horario-card-footer">
                                            <form action="<?= BASE_URL ?>/paciente/actualizar-cita" method="POST">
                                                <input type="hidden" name="accion" value="reagendar">
                                                <input type="hidden" name="id_slot" value="<?= $espacioDeAgendamiento['id_slot'] ?>">
                                                <input type="hidden" name="id_cita" value="<?= $id_cita ?>">
                                                <!-- <input type="hidden" name="id_servicio" value="<?= $id_servicio ?>"> -->
                                                <button type="submit" class="btn-seleccionar">
                                                    <i class="bi bi-check-circle-fill"></i>
                                                    Seleccionar este Turno
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>


                    </div>
                </div>
            </div>
        </div>
        <?php
        include_once __DIR__ . '/../../layouts/footer_paciente.php';
        ?>