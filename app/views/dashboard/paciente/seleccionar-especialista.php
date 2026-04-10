<?php
include_once __DIR__ . '/../../layouts/header_paciente.php';
// require_once BASE_PATH . '/app/controllers/slotController.php';
require_once BASE_PATH . '/app/controllers/servicioController.php';
require_once BASE_PATH . '/app/controllers/especialistaController.php';

$id_consultorio = $_GET['id_consultorio'];
$id_especialidad = $_GET['id_especialidad'];
$id_servicio = $_GET['id_servicio'];

$servicio = consultarNombreServicio($id_servicio);

$especialistas = listarEspecialistasPorEspecialidad($id_especialidad);

// $espaciosDeAgendamiento = listarDisponibilidad($id_consultorio, $id_especialidad, $id_servicio);
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
                                Selecciona el especialista que quieras
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
                        <?php if (!empty($especialistas)) : ?>
                            <?php foreach ($especialistas as $especialista): ?>

                                <div class="col-md-4 mb-4">
                                    <div class="horario-card">
                                        <div class="horario-card-header">
                                            <div class="patient-avatar">
                                                <img class="img-usuario" src="<?= BASE_URL ?>/public/uploads/usuarios/<?= $especialista['foto'] ?>" alt="<?= $especialista['nombres'] ?> <?= $especialista['apellidos'] ?>">
                                            </div>
                                            <h5 class="doctor-nombre"><?= $especialista['nombres'] ?> <?= $especialista['apellidos'] ?></h5>
                                            <span class="badge-disponible">
                                                <i class="bi bi-check-circle-fill"></i>
                                                <?= $especialista['estado'] ?>
                                            </span>
                                        </div>

                                        <div class="horario-card-footer">

                                            <a href="<?= BASE_URL ?>/paciente/seleccionar-horario?id_especialista=<?= $especialista['id'] ?>&id_consultorio=<?= $id_consultorio ?>&id_servicio=<?= $id_servicio ?>" class="btn-seleccionar"><i class="bi bi-check-circle-fill"></i>Seleccionar este especialista</a>
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