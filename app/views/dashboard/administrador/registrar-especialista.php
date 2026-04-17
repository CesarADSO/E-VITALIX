<?php
// ENLAZAMOS EL ARCHIVO DE SEGURIDAD
require_once BASE_PATH . '/app/helpers/session_administrador.php';

// ENLAZAMOS LA DEPENDENCIA, EN ESTE CASO EL CONTROLADOR QUE TIENE LA FUNCIÓN DE TRAER()
require_once BASE_PATH . '/app/controllers/tipoDocumentoController.php';

// ENLAZAMOS LA DEPENDENCIA, EN ESTE CASO EL CONTROLADOR DE LOS ROLES QUE TIENE LA FUNCIÓN DE mostrarConsultorios()
require_once BASE_PATH . '/app/controllers/consultorioController.php';

require_once BASE_PATH . '/app/controllers/especialidadController.php';
// LLAMAMOS LA FUNCIÓN ESPECÍFICA QUE EXISTE EN DICHO CONTROLADOR
$datos = traertipoDocumento();
// LLAMAMOS LA FUNCIÓN ESPECÍFICA QUE EXISTE EN DICHO CONTROLADOR
$consultorios = mostrarConsultorios();
// LLAMAMOS LA FUNCIÓN ESPECÍFICA QUE EXISTE EN DICHO CONTROLADOR
$especialidades = listarEspecialidades();
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

                <!-- Especialistas Section -->
                <div id="EspecialistaSection">
                    <!-- Top Bar -->
                    <?php
                    include_once __DIR__ . '/../../layouts/topbar_administrador.php';
                    ?>

                    <!-- Consultorios Header -->
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <button class="btn btn-link text-primary p-0"
                                style="text-decoration: none; font-size: 14px;">
                                ← Todos (0)
                            </button>
                        </div>
                        <a href="<?= BASE_URL ?>/admin/especialistas" class="btn btn-primary btn-sm" style="border-radius: 20px;"><i class="bi bi-arrow-left"></i> VOLVER</a>
                    </div>

                    <!-- Formulario con Wizard -->
                    <div class="bg-white rounded shadow-sm p-4">
                        <h4 class="mb-4">Registrar Especialista</h4>
                        <p class="text-muted mb-4">Por favor diligencia este formulario para registrar un especialista</p>

                        <!-- Indicador de Pasos -->
                        <div class="wizard-progress mb-4">
                            <div class="steps">
                                <div class="step active" data-step="1">
                                    <span class="step-number">1</span>
                                    <span class="step-label">Personal</span>
                                </div>
                                <div class="step" data-step="2">
                                    <span class="step-number">2</span>
                                    <span class="step-label">Información Profesional</span>
                                </div>

                                <div class="step" data-step="3">
                                    <span class="step-number">3</span>
                                    <span class="step-label">Confirmación</span>
                                </div>
                            </div>
                        </div>

                        <!-- Formulario -->
                        <form id="especialistaForm" action="<?= BASE_URL ?>/admin/guardar-especialista" method="POST" enctype="multipart/form-data">
                            <!-- Paso 1: Información Personal -->
                            <div class="wizard-step active" id="step1">
                                <div class="row">

                                    <div class="col-md-6 mb-3">
                                        <label for="nombres" class="form-label">Nombres</label>
                                        <input type="text" name="nombres" class="form-control" id="nombres" placeholder="Ingresa los nombres">
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="apellidos" class="form-label">Apellidos</label>
                                        <input type="text" name="apellidos" class="form-control" id="apellidos" placeholder="Ingresa los apellidos">
                                    </div>
                                </div>
                                <div class="row">

                                    <div class="col-md-6 mb-3">
                                        <label for="tipo_documento" class="form-label">Tipo de Documento</label>
                                        <select name="tipoDocumento" class="form-select" id="tipo_documento">
                                            <!-- Los tipos de documento se cargarán desde la base de datos -->
                                            <option value="">Seleccionar tipo</option>
                                            <?php if (!empty($datos)) : ?>
                                                <?php foreach ($datos as $tipoDocumento) : ?>
                                                    <option value="<?= $tipoDocumento['id'] ?>"><?= $tipoDocumento['nombre'] ?></option>
                                                <?php endforeach; ?>
                                            <?php else : ?>
                                                <option value="">No hay tipos de documento registrados</option>
                                            <?php endif; ?>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="numero_documento" class="form-label">Número de Documento</label>
                                        <input type="text" name="numeroDocumento" class="form-control" id="numero_documento" placeholder="Ingresa el número de documento">
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" name="correo" class="form-control" id="email" placeholder="Ingresa el correo electrónico">
                                    </div>

                                    <div class="mb-3 col-md-6">
                                        <label for="telefono" class="form-label">Teléfono</label>
                                        <input type="tel" name="telefono" class="form-control" id="telefono" placeholder="Ingresa el número telefónico">
                                    </div>

                                </div>

                                <div class="row">

                                    <div class="mb-3 col-md-6">
                                        <label for="direccion" class="form-label">Dirección</label>
                                        <input type="text" name="direccion" class="form-control" id="direccion" placeholder="Ingresa la dirección">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="tipo_documento" class="form-label">Fecha de nacimiento</label>
                                        <input type="date" name="nacimiento" class="form-control" id="fecha_nacimiento">
                                    </div>
                                </div>


                                <div class="row">

                                    <div class="col-md-6 mb-3">
                                        <label for="numero_documento" class="form-label">Genero</label>
                                        <select name="genero" id="genero" class="form-select">
                                            <option value="">Seleccione su género</option>
                                            <option value="Masculino">Masculino</option>
                                            <option value="Femenino">Femenino</option>
                                            <option value="Otro">Otro</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="foto" class="form-label">Foto</label>
                                        <input type="file" name="foto" class="form-control" id="foto" placeholder="Ingresa la dirección">
                                    </div>
                                </div>
                                <div class="d-flex justify-content-end">
                                    <button type="button" class="btn btn-primary next-step" data-next="2">Siguiente</button>
                                </div>
                            </div>

                            <!-- Paso 2: Contacto -->
                            <div class="wizard-step" id="step2">

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="especialidad" class="form-label">Especialidad</label>
                                        <select name="especialidad" id="especialidad" class="form-control">
                                            <option value="">Selecciona una especialidad</option>
                                            <?php if (!empty($especialidades)): ?>
                                                <?php foreach ($especialidades as $especialidad): ?>
                                                    <option value="<?= $especialidad['id'] ?>"><?= $especialidad['nombre'] ?></option>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <option value="">No hay especialidades registradas</option>
                                            <?php endif; ?>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="registro_profesional" class="form-label">Registro Profesional</label>
                                        <input type="text" name="registro" class="form-control" id="registro_profesional" placeholder="Ingresa el registro profesional">
                                    </div>
                                </div>



                                <div class="d-flex justify-content-between">
                                    <button type="button" class="btn btn-outline-secondary prev-step" data-prev="1">Anterior</button>
                                    <button type="button" class="btn btn-primary next-step" data-next="3">Siguiente</button>
                                </div>
                            </div>

                            <!-- Paso 3: Información Profesional -->
                            <!-- <div class="wizard-step" id="step3">
                               

                                <div class="d-flex justify-content-between">
                                    <button type="button" class="btn btn-outline-secondary prev-step" data-prev="2">Anterior</button>
                                    <button type="button" class="btn btn-primary next-step" data-next="4">Siguiente</button>
                                </div>
                            </div> -->


                            <!-- Paso 4: Confirmación -->
                            <!-- Paso 3: Confirmación -->
                            <div class="wizard-step is-last" id="step3">
                                <div class="mb-3">
                                    <h5>Resumen de la información</h5>
                                    <div class="card shadow-sm">
                                        <div class="card-body">
                                            <div class="row">

                                                <!-- Columna 1 -->
                                                <div class="col-md-6">
                                                    <p><strong>Tipo Documento:</strong><br> <span id="resumen-tipo-documento"></span></p>
                                                    <p><strong>Número Documento:</strong><br> <span id="resumen-numero-documento"></span></p>
                                                    <p><strong>Nombres:</strong><br> <span id="resumen-nombres"></span></p>
                                                    <p><strong>Apellidos:</strong><br> <span id="resumen-apellidos"></span></p>
                                                    <p><strong>Fecha Nacimiento:</strong><br> <span id="resumen-fecha-nacimiento"></span></p>
                                                    <p><strong>Género:</strong><br> <span id="resumen-genero"></span></p>
                                                </div>

                                                <!-- Columna 2 -->
                                                <div class="col-md-6">
                                                    <p><strong>Teléfono:</strong><br> <span id="resumen-telefono"></span></p>
                                                    <p><strong>Email:</strong><br> <span id="resumen-email"></span></p>
                                                    <p><strong>Dirección:</strong><br> <span id="resumen-direccion"></span></p>
                                                    <p><strong>Especialidad:</strong><br> <span id="resumen-especialidad"></span></p>
                                                    <p><strong>Registro Profesional:</strong><br> <span id="resumen-registro-profesional"></span></p>
                                                    <p><strong>Foto:</strong><br> <span id="resumen-foto"></span></p>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-between">
                                    <button type="button" class="btn btn-outline-secondary prev-step" data-prev="2">Anterior</button>
                                    <button type="submit" class="btn boton">Registrar Especialista</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
    include_once __DIR__ . '/../../layouts/footer_administrador.php';
    ?>