<?php
require_once BASE_PATH . '/app/helpers/session_superadmin.php';
// ENLAZAMOS LA DEPENDENCIA, EN ESTE CASO EL CONTROLADOR QUE TIENE LA FUNCIÓN DE CONSULTAR CONSULTORIOS
require_once BASE_PATH . '/app/controllers/administradorConsultorioController.php';

// ENLAZAMOS LA DEPENDENCIA DE TIPOS DE DOCUMENTO
require_once BASE_PATH . '/app/controllers/tipoDocumentoController.php';


// ASIGNAMOS EL VALOR ID DEL REGISTRO SEGÚN LA TABLA
$id = $_GET['id'];
// LLAMAMOS LA FUNCIÓN ESPECÍFICA QUE EXISTE EN DICHO CONTROLADOR Y LE PASAMOS LOS DATOS A UNA VARIABLE
// QUE PODAMOS MANIPULAR EN ESTE ARCHIVO
$administrador = listarAdministradorConsultorioId($id);

$datos = traerTipoDocumento();
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
                    <h4 class="mb-4">Actualizar Administrador de Consultorio</h4>
                    <p class="text-muted mb-4 texto">En este formulario podrá modificar los datos del administrador de consultorio seleccionado</p>

                    <form id="adminConsultorioForm" action="<?= BASE_URL ?>/superadmin/guardar-cambios-admin-consultorio" method="POST" enctype="multipart/form-data">
                        <div class="row">

                            <!-- Tipo de Documento -->
                            <div class="mb-3 col-md-6">
                                <label for="tipo_documento" class="form-label">Tipo de Documento</label>
                                <select class="form-select" id="tipo_documento" name="tipo_documento" required>
                                    <option value="<?= $administrador['id_tipo_documento'] ?>"><?= $administrador['tipo_documento'] ?></option>
                                    <?php if (!empty($datos)) : ?>
                                        <?php foreach ($datos as $tipoDocumento) : ?>
                                            <option value="<?= $tipoDocumento['id'] ?>"><?= $tipoDocumento['nombre'] ?></option>
                                        <?php endforeach; ?>
                                    <?php else : ?>
                                        <option value="">No hay tipos de documento registrados</option>
                                    <?php endif; ?>
                                </select>
                            </div>

                            <!-- Nombres -->
                            <div class="col-md-6 mb-3">
                                <label for="nombres" class="form-label">Nombres</label>
                                <input type="text" class="form-control" id="nombres" name="nombres"
                                    value="<?= $administrador['nombres'] ?>" required>
                            </div>
                        </div>
                        <div class="row">


                            <!-- Apellidos -->
                            <div class="col-md-6 mb-3">
                                <label for="apellidos" class="form-label">Apellidos</label>
                                <input type="text" class="form-control" id="apellidos" name="apellidos"
                                    value="<?= $administrador['apellidos'] ?>" required>
                            </div>

                            <!-- Teléfono -->
                            <div class="col-md-6 mb-3">
                                <label for="telefono" class="form-label">Teléfono</label>
                                <input type="tel" class="form-control" id="telefono" name="telefono"
                                    value="<?= $administrador['telefono'] ?>" required>
                            </div>
                        </div>

                        <div class="alert alert-info" role="alert">
                            <i class="bi bi-info-circle"></i> La foto y el número de documento no se pueden actualizar y el correo no se puede en este módulo para hacer este cambio vaya al módulo gestión de usuarios.
                        </div>

                        <!-- Botones -->
                        <div class="d-flex justify-content-between cont-botones mt-4">
                            <a href="<?= BASE_URL ?>/superadmin/administradores-consultorio" class="btn btn-outline-secondary">Cancelar</a>
                            <button type="submit" class="btn boton">Actualizar Administrador</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <?php
    include_once __DIR__ . '/../../layouts/footer_superadministrador.php';
    ?>