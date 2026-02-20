<?php
require_once BASE_PATH . '/app/helpers/session_superadmin.php';
// ENLAZAMOS LA DEPENDENCIA, EN ESTE CASO EL CONTROLADOR QUE TIENE LA FUNCIÓN DE CONSULTAR CONSULTORIOS
require_once BASE_PATH . '/app/controllers/consultorioController.php';

// ASIGNAMOS EL VALOR ID DEL REGISTRO SEGÚN LA TABLA
$id = $_GET['id'];
// LLAMAMOS LA FUNCIÓN ESPECÍFICA QUE EXISTE EN DICHO CONTROLADOR Y LE PASAMOS LOS DATOS A UNA VARIABLE
// QUE PODAMOS MANIPULAR EN ESTE ARCHIVO
$consultorio = listarConsultorio($id);
// Decodificamos el campo "horario_atencion" que viene almacenado en la base de datos.
// Este campo es un JSON con estructura similar a:
// {"dias":["Martes","Miercoles"],"hora_apertura":"23:13","hora_cierre":"23:13"}
//
// json_decode convierte ese texto JSON en un arreglo de PHP.
// El parámetro "true" indica que queremos un array asociativo, no un objeto.
$horario = json_decode($consultorio['horario_atencion'], true);

// Si existen días en el JSON los guardamos, si no creamos un array vacío
$diasSeleccionados = isset($horario['dias']) ? $horario['dias'] : [];

?>



<?php
include_once __DIR__ . '/../../layouts/header_superadministrador.php';
?>

<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <?php
            include_once __DIR__ . '/../../layouts/sidebar_superadministrador.php';
            ?>

            <!-- Main Content -->
            <div class="col-lg-10 col-md-9 main-content">

                <!-- Consultorios Section -->
                <div id="consultoriosSection">
                    <!-- Top Bar -->
                    <?php
                    include_once __DIR__ . '/../../layouts/topbar_superadministrador.php';
                    ?>

                    <!-- Consultorios Header -->
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <button class="btn btn-link text-primary p-0"
                                style="text-decoration: none; font-size: 14px;">
                                ← Todos (0)
                            </button>
                        </div>
                        <a href="<?= BASE_URL ?>/superadmin/consultorios" class="btn btn-primary btn-sm" style="border-radius: 20px;"><i class="bi bi-arrow-left"></i> VOLVER</a>
                    </div>

                    <!-- Formulario con Wizard -->
                    <div class="bg-white rounded shadow-sm p-4">
                        <h4 class="mb-4">Actualizar Consultorio</h4>
                        <p class="text-muted mb-4">Por favor diligencia este formulario para actualizar el consultorio seleccionado</p>

                        <!-- Indicador de Pasos -->
                        <div class="wizard-progress mb-4">
                            <div class="steps">
                                <div class="step active" data-step="1">
                                    <span class="step-number">1</span>
                                    <span class="step-label">Información Básica</span>
                                </div>
                                <div class="step" data-step="2">
                                    <span class="step-number">2</span>
                                    <span class="step-label">Servicios</span>
                                </div>
                            </div>
                        </div>

                        <!-- Formulario -->
                        <form id="consultorioForm" action="<?= BASE_URL ?>/superadmin/guardar-cambios-consultorio" method="POST">
                            <input type="hidden" name="id" value="<?= $consultorio['id'] ?>">
                            <input type="hidden" name="accion" value="actualizar">
                            <!-- Paso 1: Información Básica -->
                            <div class="wizard-step active" id="step1">
                                <div class="row">
                                    <div class="mb-3 col-md-6">
                                        <label for="nombre" class="form-label">Nombre</label>
                                        <input type="text" name="nombre" class="form-control" id="nombre" placeholder="Ingresa el nombre del consultorio" value="<?= $consultorio['nombre'] ?>">
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="direccion" class="form-label">Dirección</label>
                                        <input type="text" name="direccion" class="form-control" id="direccion" placeholder="Ingresa la dirección" value="<?= $consultorio['direccion'] ?>">
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="ciudad" class="form-label">Ciudad</label>
                                        <input type="text" name="ciudad" class="form-control" id="ciudad" placeholder="Ingresa la ciudad" value="<?= $consultorio['ciudad'] ?>">
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="telefono" class="form-label">Teléfono</label>
                                        <input type="tel" name="telefono" class="form-control" id="telefono" placeholder="Ingresa tu número telefónico" value="<?= $consultorio['telefono'] ?>">
                                    </div>
                                    <div class="mb-3">
                                        <label for="correo_contacto" class="form-label">Correo de Contacto</label>
                                        <input type="email" name="correo" class="form-control" id="correo_contacto" placeholder="Ingresa el correo electrónico" value="<?= $consultorio['correo_contacto'] ?>">
                                    </div>
                                </div>

                                <div class="d-flex justify-content-end">
                                    <button type="button" class="btn btn-primary next-step" data-next="2">Siguiente</button>
                                </div>
                            </div>

                            <!-- Paso 3: Servicios -->
                            <div class="wizard-step" id="step2">
                                <div class="mb-3">
                                    <label for="horario_atencion" class="form-label">Días de Atención</label>
                                    <div class="form-check check-dia">
                                        <input class="form-check-input" type="checkbox" name="dias[]" value="Lunes" <?= in_array("Lunes", $diasSeleccionados) ? "checked" : "" ?>>
                                        <label class="form-check-label mi-label">Lunes</label>
                                    </div>
                                    <div class="form-check check-dia">
                                        <input class="form-check-input" type="checkbox" name="dias[]" value="Martes" <?= in_array("Martes", $diasSeleccionados) ? "checked" : "" ?>>
                                        <label class="form-check-label mi-label">Martes</label>
                                    </div>
                                    <div class="form-check check-dia">
                                        <input class="form-check-input" type="checkbox" name="dias[]" value="Miercoles" <?= in_array("Miercoles", $diasSeleccionados) ? "checked" : "" ?>>
                                        <label class="form-check-label mi-label">Miercoles</label>
                                    </div>
                                    <div class="form-check check-dia">
                                        <input class="form-check-input" type="checkbox" name="dias[]" value="Jueves" <?= in_array("Jueves", $diasSeleccionados) ? "checked" : "" ?>>
                                        <label class="form-check-label mi-label">Jueves</label>
                                    </div>
                                    <div class="form-check check-dia">
                                        <input class="form-check-input" type="checkbox" name="dias[]" value="Viernes" <?= in_array("Viernes", $diasSeleccionados) ? "checked" : "" ?>>
                                        <label class="form-check-label mi-label">Viernes</label>
                                    </div>
                                    <div class="form-check check-dia">
                                        <input class="form-check-input" type="checkbox" name="dias[]" value="Sabado" <?= in_array("Sabado", $diasSeleccionados) ? "checked" : "" ?>>
                                        <label class="form-check-label mi-label">Sabado</label>
                                    </div>
                                    <div class="form-check check-dia">
                                        <input class="form-check-input" type="checkbox" name="dias[]" value="Domingo" <?= in_array("Domingo", $diasSeleccionados) ? "checked" : "" ?>>
                                        <label class="form-check-label mi-label">Domingo</label>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Horario de atención</label>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="hora_apertura" class="form-label">Hora apertura</label>
                                            <input type="time" id="hora_apertura" name="hora_apertura" class="form-control" value="<?= $horario['hora_apertura'] ?>">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="hora_cierre" class="form-label">Hora cierre</label>
                                            <input type="time" id="hora_cierre" name="hora_cierre" class="form-control" value="<?= $horario['hora_cierre'] ?>">
                                        </div>
                                    </div>
                                </div>

                                <!-- NUEVO CAMPO ESTADO PARA ACTUALIZAR -->
                                <div class="mb-3">
                                    <label for="estado" class="form-label">Estado del Consultorio</label>
                                    <select class="form-select" id="estado" name="estado">
                                        <option value="<?= $consultorio['estado'] ?>"><?= $consultorio['estado'] ?></option>
                                        <option value="Activo">Activo</option>
                                        <option value="Inactivo">Inactivo</option>
                                    </select>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <button type="button" class="btn btn-outline-secondary prev-step" data-prev="1">Anterior</button>
                                    <button type="submit" class="btn boton">Actualizar Consultorio</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <?php
    include_once __DIR__ . '/../../layouts/footer_superadministrador.php';
    ?>