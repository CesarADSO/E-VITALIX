<?php
include_once __DIR__ . '/../../layouts/header_paciente.php';
require_once BASE_PATH . '/app/controllers/citaController.php';
require_once BASE_PATH . '/app/controllers/slotController.php';
require_once BASE_PATH . '/app/controllers/servicioController.php';

$id = $_GET['id'];

$cita = listarCita($id);

$slots = mostrarSlots2();

$servicios = mostrarServicios2();

?>


<div class="container-fluid">
    <div class="row">

        <!-- Sidebar -->
        <?php include_once __DIR__ . '/../../layouts/sidebar_paciente.php'; ?>

        <!-- Main -->
        <div class="col-lg-10 col-md-9 main-content">

            <!-- Topbar -->
            <?php include_once __DIR__ . '/../../layouts/topbar_paciente.php'; ?>

            <!-- Formulario de Horarios Médicos -->
            <div class="bg-white rounded shadow-sm p-4">
                <h4 class="mb-4">Reagendar Cita</h4>
                <p class="text-muted mb-4 texto">Como rol paciente, reagenda la cita médica seleccionada</p>

                <form id="horarioForm" action="<?= BASE_URL ?>/paciente/guardar-cambios-cita" method="POST">
                    <input type="hidden" name="id" value="<?= $cita['id_cita'] ?>">
                    <input type="hidden" name="accion" value="reagendar">

                    <div class="row">
                        <!-- Espacio de agendamiento -->
                        <div class="col-md-6 mb-3">
                            <label for="hora_fin" class="form-label">Horario</label>
                            <select class="form-select" name="horario" id="">
                                <option value="<?= $cita['id_horario'] ?>"><?= date('d/m/Y', strtotime($cita['fecha'])) ?> | <?= substr($cita['hora_inicio'], 0, 5) ?> - <?= substr($cita['hora_fin'], 0, 5) ?> | Dr(a). <?= $cita['nombres'] ?> <?= $cita['apellidos'] ?> | <?= $cita['nombre_consultorio'] ?></option>
                                <?php if (!empty($slots)) : ?>
                                    <?php foreach ($slots as $slot) : ?>
                                        <option value="<?= $slot['id'] ?>"> <?= date('d/m/Y', strtotime($slot['fecha'])) ?> |
                                            <?= substr($slot['hora_inicio'], 0, 5) ?> - <?= substr($slot['hora_fin'], 0, 5) ?> |
                                            Dr(a). <?= $slot['nombres'] ?> <?= $slot['apellidos'] ?> |
                                            <?= $slot['nombre_consultorio'] ?></option>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <option value="">No hay slots registrados</option>
                                <?php endif; ?>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="hora_fin" class="form-label">Servicio</label>
                            <select class="form-select" name="servicio" id="">
                                <option value="<?= $cita['id_servicio'] ?>"><?= $cita['nombre_servicio'] ?></option>
                                <?php if (!empty($servicios)) : ?>
                                    <?php foreach ($servicios as $servicio) : ?>
                                        <option value="<?= $servicio['id'] ?>"><?= $servicio['nombre'] ?> </option>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <option value="">No hay slots registrados</option>
                                <?php endif; ?>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="">Motivo de la consulta</label>
                        <textarea class="form-control" name="motivo" id="" placeholder="Escribe el motivo de la consulta aquí"><?= $cita['motivo_consulta'] ?></textarea>
                    </div>

                    <div class="alert alert-info" role="alert">
                        <i class="bi bi-info-circle"></i> Al reagendar la cita el estado de dicha cita por defecto será pendiente.
                    </div>

                    <!-- Botones -->
                    <div class="d-flex justify-content-between cont-botones mt-4">
                        <a href="<?= BASE_URL ?>/paciente/ListaDeCitas" class="btn btn-outline-secondary">Cancelar</a>
                        <button type="submit" class="btn boton">Agendar Cita</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>