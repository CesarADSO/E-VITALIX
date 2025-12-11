<?php
require_once BASE_PATH . '/app/helpers/session_superadmin.php';
// ENLAZAMOS LA DEPENDENCIA, EN ESTE CASO EL CONTROLADOR QUE TIENE LA FUNCIÓN DE CONSULTAR CONSULTORIOS
require_once BASE_PATH . '/app/controllers/consultorioController.php';
// ENLAZAMOS LA DEPENDENCIA, EN ESTE CASO EL CONTROLADOR QUE TIENE LA FUNCIÓN DE CONSULTAR CONSULTORIOS
require_once BASE_PATH . '/app/controllers/administradorConsultorioController.php';

// ASIGNAMOS EL VALOR ID DEL REGISTRO SEGÚN LA TABLA
$id = $_GET['id'];
// LLAMAMOS LA FUNCIÓN ESPECÍFICA QUE EXISTE EN DICHO CONTROLADOR Y LE PASAMOS LOS DATOS A UNA VARIABLE
// QUE PODAMOS MANIPULAR EN ESTE ARCHIVO
$administrador = listarAdministradorConsultorioId($id);

// LLAMAMOS LA FUNCIÓN ESPECÍFICA QUE EXISTE EN DICHO CONTROLADOR

$datos = mostrarConsultorios();
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

                <!-- Formulario Simple de Asignación -->
                <div class="bg-white rounded shadow-sm p-4">
                    <h4 class="mb-4">Asignar Administrador a Consultorio</h4>

                    <form id="asignarAdminForm" action="<?= BASE_URL ?>/superadmin/asignar-consultorio-admin" method="POST">
                        <input type="hidden" name="id" value="<?= $administrador['id'] ?>">
                        <input type="hidden" name="accion" value="asignar">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Administrador</label>
                                <input type="text" class="form-control" value="<?= $administrador['nombres'] ?> <?= $administrador['apellidos'] ?>" disabled selected>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="consultorio" class="form-label">Consultorio</label>
                                <select class="form-select" id="consultorio" name="consultorio">
                                    <option value="">Seleccionar consultorio</option>
                                    <?php if (!empty($datos)) : ?>
                                        <?php foreach ($datos as $consultorio) : ?>
                                            <option value="<?= $consultorio['id'] ?>"><?= $consultorio['nombre'] ?></option>
                                        <?php endforeach; ?>
                                    <?php else : ?>
                                        <option value="">No hay consultorios registrados</option>
                                    <?php endif; ?>
                                </select>
                            </div>

                        </div>
                        <div class="d-flex justify-content-between cont-botones mt-4">
                            <a href="<?= BASE_URL ?>/superadmin/administradores-consultorios" class="btn btn-outline-secondary">Cancelar</a>
                            <button type="submit" class="btn boton">Asignar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <?php
    include_once __DIR__ . '/../../layouts/footer_superadministrador.php';
    ?>