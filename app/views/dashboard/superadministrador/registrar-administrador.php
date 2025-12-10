<?php
// ENLAZAMOS EL ARCHIVO DE SEGURIDAD
require_once BASE_PATH . '/app/helpers/session_superadmin.php';

// ENLAZAMOS LA DEPENDENCIA, EN ESTE CASO EL CONTROLADOR QUE TIENE LA FUNCIÓN DE TRAER()
require_once BASE_PATH . '/app/controllers/tipoDocumentoController.php';


// LLAMAMOS LA FUNCIÓN ESPECÍFICA QUE EXISTE EN DICHO CONTROLADOR
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

                <!-- Top Bar -->
                <?php
                include_once __DIR__ . '/../../layouts/topbar_superadministrador.php';
                ?>

                <!-- Formulario de Registro de Administrador de Consultorio -->
                <div class="bg-white rounded shadow-sm p-4">
                    <h4 class="mb-4">Registrar Administrador de Consultorio</h4>
                    <p class="text-muted mb-4 texto">Crear cuenta para administrador del consultorio</p>

                    <form id="adminConsultorioForm" action="<?= BASE_URL ?>/superadmin/guardar-admin-consultorio" method="POST" enctype="multipart/form-data">
                        <!-- Foto -->
                        <div class="mb-3">
                            <label for="foto" class="form-label">Foto</label>
                            <input type="file" class="form-control" id="foto" name="foto" accept=".jpg,.jpeg,.png,.gif">
                            <div class="form-text">Formatos: JPG, PNG, GIF (Opcional)</div>
                        </div>

                        <div class="row">
                            <!-- Tipo de Documento -->
                            <div class="col-md-6 mb-3">
                                <label for="tipo_documento" class="form-label">Tipo de Documento</label>
                                <select class="form-select" id="tipo_documento" name="tipo_documento" required>
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

                            <!-- Número de Documento -->
                            <div class="col-md-6 mb-3">
                                <label for="numero_documento" class="form-label">Número de Documento</label>
                                <input type="text" class="form-control" id="numero_documento" name="numero_documento"
                                    placeholder="Ingresa el número de documento" required>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Nombres -->
                            <div class="col-md-6 mb-3">
                                <label for="nombres" class="form-label">Nombres</label>
                                <input type="text" class="form-control" id="nombres" name="nombres"
                                    placeholder="Ingresa los nombres" required>
                            </div>

                            <!-- Apellidos -->
                            <div class="col-md-6 mb-3">
                                <label for="apellidos" class="form-label">Apellidos</label>
                                <input type="text" class="form-control" id="apellidos" name="apellidos"
                                    placeholder="Ingresa los apellidos" required>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Teléfono -->
                            <div class="col-md-6 mb-3">
                                <label for="telefono" class="form-label">Teléfono</label>
                                <input type="tel" class="form-control" id="telefono" name="telefono"
                                    placeholder="Ingresa el número telefónico" required>
                            </div>

                            <!-- Email -->
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email"
                                    placeholder="ejemplo@correo.com" required>
                            </div>
                        </div>

                        <!-- Botones -->
                        <div class="d-flex justify-content-between cont-botones mt-4">
                            <a href="<?= BASE_URL ?>/superadmin/administradores-consultorio" class="btn btn-outline-secondary">Cancelar</a>
                            <button type="submit" class="btn boton">Registrar Administrador</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <?php
    include_once __DIR__ . '/../../layouts/footer_superadministrador.php';
    ?>