<?php 
include_once __DIR__ . '/../../layouts/header_paciente.php';
require_once BASE_PATH . '/app/controllers/gestionCitaController.php';


$datos = mostrarCitas();

?>


<div class="container-fluid">
    <div class="row">

        <!-- Sidebar -->
        <?php include_once __DIR__ . '/../../layouts/sidebar_paciente.php'; ?>

        <!-- Main -->
        <div class="col-lg-10 col-md-9 main-content">

            <!-- Topbar -->
            <?php include_once __DIR__ . '/../../layouts/topbar_paciente.php'; ?>

            <h3 class="mb-4">Agendar Nueva Cita</h3>

            <div class="card shadow-sm p-4">

                <!-- WIZARD -->
                <form id="wizardCita" action="<?= BASE_URL ?>GestionCitaController/guardar" method="POST">

                    <!-- STEP 1 -->
                    <h4>Datos Básicos</h4>
                    <section>
                        <div class="row">

                            <!-- PACIENTE -->
                            <div class="col-md-6 mb-3">
                                <label>Paciente</label>

                                <!-- MUESTRA EL NOMBRE -->
                                <input 
                                    type="text" 
                                    class="form-control"
                                    value="<?= $_SESSION['user']['nombres'] . ' ' . $_SESSION['user']['apellidos'] ?>"
                                    readonly
                                >

                                <!-- ENVÍA EL ID REAL DEL PACIENTE -->
                                <input 
                                    type="hidden" 
                                    name="id_paciente"
                                    value="<?= $_SESSION['user']['id']; ?>"
                                >
                            </div>

                            <!-- ESPECIALISTA -->
                            <div class="col-md-6 mb-3">
                                <label>Especialista</label>
                                <select name="id_especialista" id="id_especialista" class="form-control" required>
                                    <option value="">Seleccione...</option>
                                    <option value="cardiologo">Luis</option>
                                    <option value="odontologo">odontologo</option>


                                    
                                </select>
                            </div>



                            <!-- ESPECIALIDAD (AUTOMÁTICA) -->
                            <div class="col-md-6 mb-3">
                                <label>Especialidad</label>
                                <input 
                                    type="text" 
                                    id="especialidad_field" 
                                    class="form-control" 
                                    readonly
                                >
                            </div>

                            <!-- SERVICIO (dinámico por especialista) -->
                            <!-- <div class="col-md-6 mb-3">
                                <label>Servicio</label>
                                <select name="id_servicio" id="id_servicio" class="form-control" required>
                                    <option value="">Seleccione un especialista...</option>
                                </select>
                            </div> -->

                            <!-- CONSULTORIO -->
                            <div class="col-md-6 mb-3">
                                <label>Consultorio / Clínica</label>
                                <select name="id_consultorio" id="id_consultorio" class="form-control" required>
                                    <option value="">Seleccione...</option>
                                    <?php foreach ($consultorios as $c): ?>
                                        <option value="<?= $c['id']; ?>"><?= $c['nombre']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                        </div>
                    </section>

                    <!-- STEP 2 -->
                    <h4>Fecha y Hora</h4>
                    <section>
                        <div class="row">

                            <div class="col-md-6 mb-3">
                                <label>Fecha de la cita</label>
                                <input type="date" name="fecha_cita" id="fecha_cita" class="form-control" required>
                            </div>

                            <div class="col-md-3 mb-3">
                                <label>Hora Inicio</label>
                                <input type="time" name="hora_inicio" id="hora_inicio" class="form-control" required>
                            </div>

                            <div class="col-md-3 mb-3">
                                <label>Hora Fin</label>
                                <input type="time" name="hora_fin" id="hora_fin" class="form-control" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label>Prioridad</label>
                                <select name="prioridad" class="form-control">
                                    <option value="normal">Normal</option>
                                    <option value="prioritaria">Prioritaria</option>
                                </select>
                            </div>

                         <div class="d-flex justify-content-between cont-botones">
                             <button type="submit" class="btn boton">Agendar cita</button>
                        </div>
                </form>
            </div>
        </div>
    </div>   
</div>                   
