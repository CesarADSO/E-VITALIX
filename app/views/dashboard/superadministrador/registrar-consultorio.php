<?php
require_once BASE_PATH . '/app/controllers/tipoDocumentoController.php';

$datos = traertipoDocumento();
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
                        <h4 class="mb-4">Registrar Consultorio</h4>
                        <p class="text-muted mb-4 texto">Por favor diligencia este formulario para registrar un consultorio</p>

                        <!-- Indicador de Pasos -->
                        <div class="wizard-progress mb-4">
                            <div class="steps">
                                <div class="step active" data-step="1">
                                    <span class="step-number">1</span>
                                    <span class="step-label">Información Básica</span>
                                </div>
                                <!-- <div class="step" data-step="2">
                                    <span class="step-number">2</span>
                                    <span class="step-label">Contacto</span>
                                </div> -->
                                <div class="step" data-step="2">
                                    <span class="step-number">2</span>
                                    <span class="step-label">Administrador</span>
                                </div>
                                <div class="step" data-step="3">
                                    <span class="step-number">3</span>
                                    <span class="step-label">Servicios</span>
                                </div>
                                <div class="step" data-step="4">
                                    <span class="step-number">4</span>
                                    <span class="step-label">Confirmación</span>
                                </div>
                            </div>
                        </div>

                        <!-- Formulario -->
                        <form id="consultorioForm" action="<?= BASE_URL ?>/superadmin/guardar-consultorio" method="POST" enctype="multipart/form-data">
                            <!-- Paso 1: Información Básica -->
                            <div class="wizard-step active" id="step1">
                                <div class="row">
                                    

                                    <div class="col-md-6 mb-3">
                                        <label for="nombre" class="form-label">Nombre</label>
                                        <input type="text" name="nombre" class="form-control" id="nombre" placeholder="Ingresa el nombre del consultorio">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="ciudad" class="form-label">Ciudad</label>
                                        <input type="text" name="ciudad" class="form-control" id="ciudad" placeholder="Ingresa la ciudad">
                                    </div>
                                </div>

                                <div class="row">
                                    
                                    <div class="col-md-6 mb-3">
                                        <label for="direccion" class="form-label">Dirección</label>
                                        <input type="text" name="direccion" class="form-control" id="direccion" placeholder="Ingresa la dirección">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="telefono" class="form-label">Teléfono</label>
                                        <input type="tel" name="telefono" class="form-control" id="telefono" placeholder="Ingresa el número telefónico del consultorio">
                                    </div>
                                </div>
                                <div class="row">
                                    
                                    <div class="col-md-6 mb-3">
                                        <label for="correo_contacto" class="form-label">Correo de Contacto</label>
                                        <input type="email" name="correo" class="form-control" id="correo_contacto" placeholder="Ingresa el correo electrónico">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="foto" class="form-label">Foto</label>
                                        <input type="file" name="foto" class="form-control" id="foto" accept=".jpg, .png, .svg">
                                    </div>
                                </div>

                                

                                <div class="d-flex justify-content-end">
                                    <button type="button" class="btn btn-primary next-step" data-next="2">Siguiente</button>
                                </div>
                            </div>

                            <!-- Paso 2: Contacto
                            <div class="wizard-step" id="step2">
                                <div class="row">
                                    

                                    
                                </div>

                                <div class="d-flex justify-content-between">
                                    <button type="button" class="btn btn-outline-secondary prev-step" data-prev="1">Anterior</button>
                                    <button type="button" class="btn btn-primary next-step" data-next="3">Siguiente</button>
                                </div>
                            </div> -->

                            <!-- Paso 3: Administrador -->
                            <div class="wizard-step" id="step2">

                               

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="nombres_admin" class="form-label">Nombres</label>
                                        <input type="text" name="nombres_admin" class="form-control" id="nombre_admin" placeholder="Ingresa los nombres">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="apellidos_admin" class="form-label">Apellidos</label>
                                        <input type="text" name="apellidos_admin" class="form-control" id="apellido_admin" placeholder="Ingresa los apellidos">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="tipo_documento_admin" class="form-label">Tipo de documento</label>
                                        <select class="form-select" name="tipo_documento_admin" id="tipo_documento">
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
                                        <label for="numero_documento_admin" class="form-label">Número de documento</label>
                                        <input type="text" name="numero_documento_admin" class="form-control" id="numero_documento_admin" placeholder="Ingresa el número de documento">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="correo_admin" class="form-label">Email</label>
                                        <input type="email" name="correo_admin" class="form-control" id="correo_admin" placeholder="Ingresa el correo electrónico">
                                    </div>
                                   
                                    <div class="col-md-6 mb-3">
                                        <label for="telefono_admin" class="form-label">Teléfono</label>
                                        <input type="tel" name="telefono_admin" class="form-control" id="telefono_admin" placeholder="Ingresa el número telefónico">
                                    </div>
                                </div>

                                <div class="row">

                                    <div class="col-md-6 mb-3">
                                        <label for="foto_admin" class="form-label">Foto</label>
                                        <input type="file" name="foto_admin" class="form-control" id="foto_admin" accept=".jpg, .png, .svg">
                                    </div>

                                </div>


                                <div class="d-flex justify-content-between">
                                    <button type="button" class="btn btn-outline-secondary prev-step" data-prev="2">Anterior</button>
                                    <button type="button" class="btn btn-primary next-step" data-next="3">Siguiente</button>
                                </div>
                            </div>

                            <!-- Paso 4: Servicios -->
                            <div class="wizard-step" id="step3">
                                <div class="mb-3">
                                    <label class="form-label" for="especialidades">Especialidades (Selecciona una o varias)</label>
                                    <div class="form-check check-especialidad">
                                        <input class="form-check-input" type="checkbox" id="dermatologia" name="especialidades[]" value="Dermatologia">
                                        <label for="dermatologia" class="form-check-label mi-label">Dermatología</label>
                                    </div>
                                    <div class="form-check check-especialidad">
                                        <input class="form-check-input" type="checkbox" id="urologia" name="especialidades[]" value="urologia">
                                        <label for="urologia" class="form-check-label mi-label">Urología</label>
                                    </div>
                                    <div class="form-check check-especialidad">
                                        <input class="form-check-input" type="checkbox" id="cardiologia" name="especialidades[]" value="Cardiologia">
                                        <label for="cardiologia" class="form-check-label mi-label">Cardiología</label>
                                    </div>
                                    <div class="form-check check-especialidad">
                                        <input class="form-check-input" type="checkbox" id="medicina-general" name="especialidades[]" value="Medicina_general">
                                        <label for="medicinaGeneral" class="form-check-label mi-label">Medicina General</label>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="horario_atencion" class="form-label">Días de Atención</label>
                                    <div class="form-check check-dia">
                                        <input class="form-check-input" type="checkbox" name="dias[]" value="Lunes">
                                        <label class="form-check-label mi-label">Lunes</label>
                                    </div>
                                    <div class="form-check check-dia">
                                        <input class="form-check-input" type="checkbox" name="dias[]" value="Martes">
                                        <label class="form-check-label mi-label">Martes</label>
                                    </div>
                                    <div class="form-check check-dia">
                                        <input class="form-check-input" type="checkbox" name="dias[]" value="Miercoles">
                                        <label class="form-check-label mi-label">Miercoles</label>
                                    </div>
                                    <div class="form-check check-dia">
                                        <input class="form-check-input" type="checkbox" name="dias[]" value="Jueves">
                                        <label class="form-check-label mi-label">Jueves</label>
                                    </div>
                                    <div class="form-check check-dia">
                                        <input class="form-check-input" type="checkbox" name="dias[]" value="Viernes">
                                        <label class="form-check-label mi-label">Viernes</label>
                                    </div>
                                    <div class="form-check check-dia">
                                        <input class="form-check-input" type="checkbox" name="dias[]" value="Sabado">
                                        <label class="form-check-label mi-label">Sabado</label>
                                    </div>
                                    <div class="form-check check-dia">
                                        <input class="form-check-input" type="checkbox" name="dias[]" value="Domingo">
                                        <label class="form-check-label mi-label">Domingo</label>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Horario de atención</label>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="hora_apertura" class="form-label">Hora apertura</label>
                                            <input type="time" id="hora_apertura" name="hora_apertura" class="form-control">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="hora_cierre" class="form-label">Hora cierre</label>
                                            <input type="time" id="hora_cierre" name="hora_cierre" class="form-control">
                                        </div>
                                    </div>
                                </div>


                                <div class="d-flex justify-content-between">
                                    <button type="button" class="btn btn-outline-secondary prev-step" data-prev="2">Anterior</button>
                                    <button type="button" class="btn btn-primary next-step" data-next="4">Siguiente</button>
                                </div>
                            </div>

                            <!-- Paso 5: Confirmación -->
                            <div class="wizard-step is-last" id="step5">
                                <div class="mb-3">
                                    <h5>Resumen de la información</h5>
                                    <div class="card">
                                        <div class="card-body">
                                            <p><strong>Nombre del consultorio:</strong> <span id="resumen-nombre"></span></p>
                                            <p><strong>Dirección del consultorio:</strong> <span id="resumen-direccion"></span></p>
                                            <p><strong>Foto del consultorio:</strong> <span id="resumen-foto"></span></p>
                                            <p><strong>Ciudad:</strong> <span id="resumen-ciudad"></span></p>
                                            <p><strong>Teléfono del consultorio:</strong> <span id="resumen-telefono"></span></p>
                                            <p><strong>Correo del consultorio:</strong> <span id="resumen-correo"></span></p>
                                            <p><strong>Correo del administrador:</strong> <span id="resumen-correo-administrador"></span></p>
                                            <p><strong>Nombres del administrador:</strong> <span id="resumen-nombre-administrador"></span></p>
                                            <p><strong>Apellidos del administrador:</strong> <span id="resumen-apellidos-administrador"></span></p>
                                            <p><strong>Foto del administrador:</strong> <span id="resumen-foto-administrador"></span></p>
                                            <p><strong>Teléfono del administrador:</strong> <span id="resumen-telefono-administrador"></span></p>
                                            <p><strong>Tipo de documento del administrador:</strong> <span id="resumen-tipo-documento"></span></p>
                                            <p><strong>Número de documento del administrador:</strong> <span id="resumen-numero-documento"></span></p>
                                            <p><strong>Especialidades:</strong> <span id="resumen-especialidades"></span></p>
                                            <p><strong>Horario del consultorio:</strong> <span id="resumen-horario"></span></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between cont-botones">
                                    <button type="button" class="btn btn-outline-secondary prev-step" data-prev="3">Anterior</button>
                                    <button type="submit" class="btn boton">Registrar Consultorio</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
    include_once __DIR__ . '/../../layouts/footer_superadministrador.php';
    ?>