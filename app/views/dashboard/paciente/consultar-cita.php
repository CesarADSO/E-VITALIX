<?php
require_once BASE_PATH . '/app/helpers/session_paciente.php';

require_once BASE_PATH . '/app/controllers/citaController.php';

$id_cita = $_GET['id_cita'] ?? null;

$cita = listarCita($id_cita);
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

                <!-- Top Bar -->
                <?php
                include_once __DIR__ . '/../../layouts/topbar_paciente.php';
                ?>

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <a href="<?= BASE_URL ?>/paciente/lista-de-citas" class="btn btn-link text-primary p-0" style="text-decoration: none; font-size: 14px;">← Todos</a>
                    <a href="<?= BASE_URL ?>/paciente/lista-de-citas" class="btn btn-primary btn-sm btn-añadir-volver"><i class="bi bi-arrow-left"></i> VOLVER</a>
                </div>

                <!-- Formulario de Registro de Administrador de Consultorio -->
                <div class="bg-white rounded shadow-sm p-4">
                    <h4 class="mb-4">Detalle de la cita</h4>
                    <p class="text-muted mb-4 texto">En este formulario podrá consultar la información completa de la cita seleccionada</p>

                    <form id="detalleCitaForm">
                        <div class="row">

                            <!-- Nombres -->
                            <div class="col-md-6 mb-3">
                                <label for="fecha" class="form-label">Fecha de la cita</label>
                                <input type="text" class="form-control" id="fecha" name="fecha"
                                    value="<?= date('d/m/Y', strtotime($cita['fecha'])) ?>" disabled>
                            </div>

                            <!-- Apellidos -->
                            <div class="col-md-6 mb-3">
                                <label for="apellidos" class="form-label">Hora programada</label>
                                <input type="text" class="form-control" id="apellidos" name="apellidos"
                                    value="<?= date('H:i', strtotime($cita['hora_inicio'])) ?>" disabled>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="edad" class="form-label">Nombre del especialista</label>
                                <input type="text" class="form-control" id="edad" name="edad"
                                    value="<?= $cita['nombres'] ?> <?= $cita['apellidos'] ?>" disabled>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="nombre_consultorio" class="form-label">Nombre del consultorio</label>
                                <input type="text" class="form-control" id="nombre_consultorio" name="nombre_consultorio"
                                    value="<?= $cita['nombre_consultorio'] ?>" disabled>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="direccion" class="form-label">Dirección del consultorio</label>
                                <input type="text" class="form-control" id="direccion" name="direccion"
                                    value="<?= $cita['ciudad'] ?> <?= $cita['direccion'] ?>" disabled>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="estado_cita" class="form-label">Estado de la cita</label>
                                <input type="text" class="form-control" id="estado_cita" name="estado_cita"
                                    value="<?= $cita['estado_cita'] ?>" disabled>
                            </div>

                            <!-- Botones -->
                            <div class="d-flex justify-content-between cont-botones mt-4">
                                <a href="<?= BASE_URL ?>/paciente/lista-de-citas" class="btn btn-primary">Volver a mi lista de citas</a>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <?php
    include_once __DIR__ . '/../../layouts/footer_paciente.php';
    ?>