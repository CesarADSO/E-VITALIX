<?php
// IMPORTAMOS DEPENDENCIAS
require_once BASE_PATH . '/app/helpers/session_administrador.php';
require_once BASE_PATH . '/app/controllers/asistenteController.php';
require_once BASE_PATH . '/app/controllers/tipoDocumentoController.php';

// OBTENEMOS EL ID DESDE LA URL
$id = $_GET['id'];

// TRAEMOS LOS DATOS DEL ASISTENTE
$asistente = listarAsistente($id);

// TRAEMOS LOS TIPOS DE DOCUMENTO
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
                        <h4 class="mb-4">Actualizar Asistente de Consultorio</h4>
                        <p class="text-muted mb-4 texto">En este formulario usted puede modificar la información de los asistentes del consultorio</p>

                        <form id="asistenteForm" action="<?= BASE_URL ?>/admin/guardar-cambios-asistente" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="id_usuario" value="<?= $asistente['id_usuario'] ?>">
                            <input type="hidden" name="id_asistente" value="<?= $asistente['id_asistente'] ?>">
                            <input type="hidden" name="accion" value="actualizar">

                            <!-- 2. DATOS DE IDENTIFICACIÓN LEGAL -->
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="estado" class="form-label">Estado</label>
                                    <select name="estado" id="estado" class="form-select">
                                        <!-- Estado actual -->
                                        <option value="<?= $asistente['estado'] ?>">
                                            <?= $asistente['estado'] ?>
                                        </option>
                                        <option value="Activo">Activo</option>
                                        <option value="Inactivo">Inactivo</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="tipo_documento" class="form-label">Tipo de Documento</label>
                                    <select class="form-select" id="tipo_documento" name="tipo_documento" required>
                                        <!-- Tipo actual -->
                                        <option value="<?= $asistente['id_tipo_documento'] ?>">
                                            <?= $asistente['documento'] ?>
                                        </option>
                                        <!-- Tipos de documento desde BD -->
                                        <?php if (!empty($datos)) : ?>
                                            <?php foreach ($datos as $tipoDocumento) : ?>
                                                <option value="<?= $tipoDocumento['id'] ?>">
                                                    <?= $tipoDocumento['nombre'] ?>
                                                </option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                            </div>

                            <!-- 3. DATOS PERSONALES -->
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="nombres" class="form-label">Nombres</label>
                                    <input type="text" class="form-control" id="nombres" name="nombres" value="<?= $asistente['nombres'] ?>" required>
                                </div>

                                <div class="col-md-6">
                                    <label for="apellidos" class="form-label">Apellidos</label>
                                    <input type="text" class="form-control" id="apellidos" name="apellidos" value="<?= $asistente['apellidos'] ?>" required>
                                </div>
                            </div>

                            <!-- 4. DATOS DE CONTACTO -->

                            <div class="mb-4">
                                <label for="telefono" class="form-label">Teléfono</label>
                                <input type="tel" class="form-control" id="telefono" name="telefono" value="<?= $asistente['telefono'] ?>" required>
                                <div class="form-text">Para contacto directo</div>
                            </div>

                            <div class="alert alert-info" role="alert">
                                <i class="bi bi-info-circle"></i> La foto solo la puede modificar el usuario, el número de documento no se puede modificar y el correo solo lo puede modificar el superadministrador o en su defecto el usuario en su sección del perfil.
                            </div>

                            <!-- Botones -->
                            <div class="d-flex justify-content-between cont-botones mt-4">
                                <a href="<?= BASE_URL ?>/admin/asistentes" class="btn btn-outline-secondary">Cancelar</a>
                                <button type="submit" class="btn boton">Actualizar Asistente</button>
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