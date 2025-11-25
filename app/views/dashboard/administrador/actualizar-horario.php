<?php 
    require_once BASE_PATH . '/app/helpers/session_admin.php';
    require_once BASE_PATH . '/app/controllers/horarioController.php';
    require_once BASE_PATH . '/app/controllers/especialistaController.php';
    require_once BASE_PATH . '/app/controllers/consultorioController.php';

    $id = $_GET['id'];

    $horario = listarHorarioPorId($id);
    $especialistas = mostrarEspecialistas();
    $consultorios = mostrarConsultorios();
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
                <div id="HorariosSection">
                    <!-- Top Bar -->
                    <?php
                    include_once __DIR__ . '/../../layouts/topbar_administrador.php';
                    ?>

                    <!-- Horarios Header -->
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <button class="btn btn-link text-primary p-0"
                                style="text-decoration: none; font-size: 14px;">
                                ← Todos (0)
                            </button>
                        </div>
                        <a href="/E-VITALIX/admin/horarios" class="btn btn-primary btn-sm"
                            style="border-radius: 20px;"><i class="bi bi-arrow-left"></i> VOLVER</a>
                    </div>

                    <!-- Formulario de Horarios Médicos -->
                    <div class="bg-white rounded shadow-sm p-4">
                        <h4 class="mb-4">Actualizar Horario Médico</h4>
                        <p class="text-muted mb-4 texto">Actualiza el horario médico del especialista seleccionado</p>

                        <form id="horarioForm" action="<?= BASE_URL ?>/admin/guardar-cambios-horario" method="POST">
                            <div class="row">
                                <!-- Especialista -->
                                <div class="col-md-6 mb-3">
                                    <label for="especialista" class="form-label">Especialista</label>
                                    <select class="form-select" name="idEspecialista" id="especialista" required>
                                        <option value="<?= $horario['id_especialista'] ?>"><?= $horario['nombres'] ?> <?= $horario['apellidos'] ?></option>
                                        <?php if (!empty($especialistas)) :?>
                                            <?php foreach($especialistas as $especialista) :?>
                                            <option value="<?= $especialista['id'] ?>"><?= $especialista['nombres'] ?> <?= $especialista['apellidos'] ?></option>
                                            <?php endforeach;?>
                                        <?php else:?>
                                            <option value="">No hay especialistas registrados</option>
                                        <?php endif;?>
                                    </select>
                                </div>

                                <!-- Consultorio -->
                                <div class="col-md-6 mb-3">
                                    <label for="consultorio" class="form-label">Consultorio</label>
                                    <select class="form-select" name="idConsultorio" id="consultorio" required>
                                        <option value="<?= $horario['id_consultorio'] ?>"><?= $horario['nombre'] ?></option>
                                        <!-- Los consultorios se cargarán desde la base de datos -->
                                         <?php if (!empty($consultorios)) :?>
                                            <?php foreach($consultorios as $consultorio) :?>
                                            <option value="<?= $consultorio['id'] ?>"><?= $consultorio['nombre'] ?></option>
                                            <?php endforeach;?>
                                        <?php else: ?>
                                            <option value="">No hay consultorios registrados</option>
                                        <?php endif;?>
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <!-- Día de la Semana -->
                                <div class="col-md-6 mb-3">
                                    <label for="dia_semana" class="form-label">Día de la Semana</label>
                                    <select class="form-select" id="dia_semana" name="dia_semana" required>
                                        <option value="<?= $horario['dia_semana'] ?>"><?= $horario['dia_semana'] ?></option>
                                        <option value="lunes">Lunes</option>
                                        <option value="martes">Martes</option>
                                        <option value="miercoles">Miércoles</option>
                                        <option value="jueves">Jueves</option>
                                        <option value="viernes">Viernes</option>
                                        <option value="sabado">Sábado</option>
                                        <option value="domingo">Domingo</option>
                                    </select>
                                </div>

                                <!-- Capacidad Máxima de Citas -->
                                <div class="col-md-6 mb-3">
                                    <label for="capacidad_citas" class="form-label">Capacidad Máxima de Citas por
                                        Día</label>
                                    <input type="number" class="form-control" id="capacidad_citas"
                                        name="capacidad_citas" min="1" max="50" placeholder="Ej: 20" value="<?= $horario['capacidad_maxima'] ?>" required>
                                    <div class="form-text">Número máximo de citas que puede atender en este día</div>
                                </div>
                            </div>

                            <div class="row">
                                <!-- Hora Inicio -->
                                <div class="col-md-6 mb-3">
                                    <label for="hora_inicio" class="form-label">Hora Inicio de Trabajo</label>
                                    <input type="time" class="form-control" id="hora_inicio" name="hora_inicio" value="<?= $horario['hora_inicio'] ?>"
                                        required>
                                </div>

                                <!-- Hora Fin -->
                                <div class="col-md-6 mb-3">
                                    <label for="hora_fin" class="form-label">Hora Fin de Trabajo</label>
                                    <input type="time" class="form-control" id="hora_fin" name="hora_fin" value="<?= $horario['hora_fin'] ?>" required>
                                </div>
                            </div>

                            <div class="row">
                                <!-- Inicio Descanso -->
                                <div class="col-md-6 mb-3">
                                    <label for="inicio_descanso" class="form-label">Inicio de Descanso</label>
                                    <input type="time" class="form-control" id="inicio_descanso" name="inicio_descanso" value="<?= $horario['pausa_inicio'] ?>">
                                </div>

                                <!-- Fin Descanso -->
                                <div class="col-md-6 mb-3">
                                    <label for="fin_descanso" class="form-label">Fin de Descanso</label>
                                    <input type="time" class="form-control" id="fin_descanso" name="fin_descanso" value="<?= $horario['pausa_fin'] ?>">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="estado" class="form-label">Estado</label>
                                    <select class="form-select" id="estado" name="estado" required>
                                        <option value="<?= $horario['estado_disponibilidad'] ?>"><?= $horario['estado_disponibilidad'] ?></option>
                                        <option value="Activo">Activo</option>
                                        <option value="Inactivo">Inactivo</option>
                                    </select>
                                </div>
                            </div>
                            <!-- Botones -->
                            <div class="d-flex justify-content-between cont-botones mt-4">
                                <a href="<?= BASE_URL ?>/admin/horarios" class="btn btn-outline-secondary">Cancelar</a>
                                <button type="submit" class="btn boton">Actualizar Horario</button>
                            </div>
                        </form>
                    </div>
                    <?php
                    include_once __DIR__ . '/../../layouts/footer_administrador.php';
                    ?>