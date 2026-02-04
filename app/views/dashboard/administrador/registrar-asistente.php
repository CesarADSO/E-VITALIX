<?php
    require_once BASE_PATH . '/app/helpers/session_administrador.php';
    require_once BASE_PATH . '/app/controllers/tipoDocumentoController.php';

    $datos = traerTipoDocumento();
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

                <!-- Asistentes Section -->
                <div id="asistenteSection">
                    <!-- Top Bar -->
                    <?php
                    include_once __DIR__ . '/../../layouts/topbar_administrador.php';
                    ?>

                    <!-- Asistentes Header -->
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <button class="btn btn-link text-primary p-0"
                                style="text-decoration: none; font-size: 14px;">
                                ← Todos (0)
                            </button>
                        </div>
                        <a href="<?= BASE_URL ?>/admin/asistentes" class="btn btn-primary btn-sm" style="border-radius: 20px;"><i class="bi bi-arrow-left"></i> VOLVER</a>
                    </div>

                    <!-- Formulario de Registro de Asistente de Consultorio -->
                    <div class="bg-white rounded shadow-sm p-4">
                        <h4 class="mb-4">Registrar Asistente de Consultorio</h4>
                        <p class="text-muted mb-4 texto">Crear cuenta para asistente del consultorio</p>

                        <form id="asistenteForm" action="<?= BASE_URL ?>/admin/guardar-asistente" method="POST" enctype="multipart/form-data">

                           

                            <!-- 1. DATOS PERSONALES -->
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="nombres" class="form-label">Nombres</label>
                                    <input type="text" class="form-control" id="nombres" name="nombres"
                                        placeholder="Ingresa los nombres" required>
                                </div>

                                <div class="col-md-6">
                                    <label for="apellidos" class="form-label">Apellidos</label>
                                    <input type="text" class="form-control" id="apellidos" name="apellidos"
                                        placeholder="Ingresa los apellidos" required>
                                </div>
                            </div>

                            <!-- 2. DATOS DE IDENTIFICACIÓN LEGAL -->
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="tipo_documento" class="form-label">Tipo de Documento</label>
                                    <select class="form-select" id="tipo_documento" name="tipo_documento" required>
                                        <option value="">Seleccionar tipo</option>
                                        <?php if(isset($datos)): ?>
                                            <?php foreach ($datos as $tipoDocumento): ?>
                                                <option value="<?= $tipoDocumento['id'] ?>"><?= $tipoDocumento['nombre'] ?></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label for="numero_documento" class="form-label">Número de Documento</label>
                                    <input type="text" class="form-control" id="numero_documento" name="numero_documento"
                                        placeholder="Ingresa el número de documento" required>
                                </div>
                            </div>

                            

                            <!-- 3. DATOS DE CONTACTO -->
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="email" class="form-label">Correo Electrónico</label>
                                    <input type="email" class="form-control" id="email" name="email"
                                        placeholder="ejemplo@correo.com" required>
                                    <div class="form-text">Para inicio de sesión y comunicación</div>
                                </div>

                                <div class="col-md-6">
                                    <label for="telefono" class="form-label">Teléfono</label>
                                    <input type="tel" class="form-control" id="telefono" name="telefono"
                                        placeholder="Ingresa el número telefónico" required>
                                    <div class="form-text">Para contacto directo</div>
                                </div>
                            </div>

                             <!-- 4. FOTO -->
                             <div class="mb-4">
                                <label for="foto" class="form-label">Foto de Perfil</label>
                                <input type="file" class="form-control" id="foto" name="foto"
                                    accept=".jpg,.jpeg,.png">
                                <div class="form-text">Tamaño máximo: 2MB</div>
                            </div>

                            <!-- Botones -->
                            <div class="d-flex justify-content-between cont-botones mt-4">
                                <a href="<?= BASE_URL ?>/admin/asistentes" class="btn btn-outline-secondary">Cancelar</a>
                                <button type="submit" class="btn boton">Registrar Asistente</button>
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