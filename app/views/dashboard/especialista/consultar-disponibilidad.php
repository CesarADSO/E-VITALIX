<?php
require_once BASE_PATH . '/app/helpers/session_especialista.php';
require_once BASE_PATH . '/app/controllers/horarioController.php';

$id = $_GET['id'];

$horario = listarHorarioPorId($id);
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
                <div id="HorariosSection">
                    <!-- Top Bar -->
                    <?php
                    include_once __DIR__ . '/../../layouts/topbar_especialista.php';
                    ?>

                    <!-- Horarios Header -->
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <button class="btn btn-link text-primary p-0"
                                style="text-decoration: none; font-size: 14px;">
                                ← Todos (0)
                            </button>
                        </div>
                        <a href="/E-VITALIX/especialista/disponibilidad" class="btn btn-primary btn-sm"
                            style="border-radius: 20px;"><i class="bi bi-arrow-left"></i> VOLVER</a>
                    </div>

                    <!-- Formulario de Horarios Médicos -->
                    <div class="bg-white rounded shadow-sm p-4">
                        <h4 class="mb-4">Consultar disponibilidad</h4>
                        <p class="text-muted mb-4 texto">En esta interfaz usted podrá consultar toda la información de su disponibilidad.</p>

                        <form id="horarioForm">
                            <input type="hidden" name="id" value="<?= $horario['id'] ?>">

                            <div class="alert alert-info" role="alert">
                                <i class="bi bi-info-circle"></i> Vista de solo lectura.
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="especialista" class="form-label">Especialista</label>
                                    <input type="text" class="form-control" value="<?= $horario['nombre_especialista'] ?> <?= $horario['apellido_especialista'] ?>" disabled>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="consultorio" class="form-label">Consultorio</label>
                                    <input type="text" class="form-control" value="<?= $horario['consultorio'] ?>" disabled>
                                </div>
                            </div>

                            <div class="row">
                                <!-- Día de la Semana -->
                                <div class="col-md-6 mb-3">
                                    <label for="dias_semana" class="form-label">Días de la semana</label>
                                    <?php
                                    $diasArray = json_decode($horario['dia_semana'], true);
                                    $diasTexto = is_array($diasArray) ? implode(',', $diasArray) : '';
                                    ?>
                                    <input class="form-control" type="text" value="<?= $diasTexto ?>" disabled>
                                </div>

                                <!-- Capacidad Máxima de Citas -->
                                <div class="col-md-6 mb-3">
                                    <label for="capacidad_citas" class="form-label">Capacidad Máxima de Citas por
                                        Día</label>
                                    <input type="number" class="form-control" id="capacidad_citas"
                                        name="capacidad_citas" min="1" max="50" placeholder="Ej: 20" value="<?= $horario['capacidad_maxima'] ?>" disabled>
                                    <div class="form-text">Número máximo de citas que puede atender en este día</div>
                                </div>
                            </div>

                            <div class="row">
                                <!-- Hora Inicio -->
                                <div class="col-md-6 mb-3">
                                    <label for="hora_inicio" class="form-label">Hora Inicio de Trabajo</label>
                                    <input type="time" class="form-control" id="hora_inicio" name="hora_inicio" value="<?= $horario['hora_inicio'] ?>"
                                        disabled>
                                </div>

                                <!-- Hora Fin -->
                                <div class="col-md-6 mb-3">
                                    <label for="hora_fin" class="form-label">Hora Fin de Trabajo</label>
                                    <input type="time" class="form-control" id="hora_fin" name="hora_fin" value="<?= $horario['hora_fin'] ?>" disabled>
                                </div>
                            </div>

                            <div class="row">
                                <!-- Inicio Descanso -->
                                <div class="col-md-6 mb-3">
                                    <label for="inicio_descanso" class="form-label">Inicio de Descanso</label>
                                    <input type="time" class="form-control" id="inicio_descanso" name="inicio_descanso" value="<?= $horario['pausa_inicio'] ?>" disabled>
                                </div>

                                <!-- Fin Descanso -->
                                <div class="col-md-6 mb-3">
                                    <label for="fin_descanso" class="form-label">Fin de Descanso</label>
                                    <input type="time" class="form-control" id="fin_descanso" name="fin_descanso" value="<?= $horario['pausa_fin'] ?>" disabled>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="estado" class="form-label">Estado</label>
                                    <input type="text" class="form-control" value="<?= $horario['estado_disponibilidad'] ?>" disabled>
                                </div>
                            </div>
                            <!-- Botones -->
                            <div class="d-flex justify-content-between cont-botones mt-4">
                                <a href="<?= BASE_URL ?>/especialista/disponibilidad" class="btn btn-outline-secondary">Volver a la interfaz anterior</a>
                                <a href="<?= BASE_URL ?>/especialista/actualizar-disponibilidad?id=<?= $horario['id'] ?>" class="btn boton">Ir a actualizar la disponibilidad</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
    include_once __DIR__ . '/../../layouts/footer_especialista.php';
    ?>