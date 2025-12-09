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
$consultorio = listarConsultorio($id);

// LLAMAMOS LA FUNCIÓN ESPECÍFICA QUE EXISTE EN DICHO CONTROLADOR

$datos = mostrarAdministradoresConsultorios();
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

                    <form id="asignarAdminForm" action="<?= BASE_URL ?>/superadmin/asignar-admin-consultorio" method="POST">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Consultorio</label>
                                <input type="text" class="form-control" value="<?= $consultorio['nombre'] ?>" disabled>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="administrador" class="form-label">Administrador</label>
                                <select class="form-select" id="administrador" name="administrador" required>
                                    <option value="">Seleccionar administrador</option>
                                    <?php if (!empty($datos)) : ?>
                                        <?php foreach ($datos as $admin) : ?>
                                            <option value="<?= $admin['id'] ?>"><?= $admin['nombres'] . ' ' . $admin['apellidos'] ?></option>
                                        <?php endforeach; ?>
                                    <?php else : ?>
                                        <option value="">No hay administradores registrados</option>
                                    <?php endif; ?>
                                </select>
                            </div>

                        </div>
                        <div class="d-flex justify-content-between cont-botones mt-4">
                            <a href="<?= BASE_URL ?>/superadmin/consultorios-administradores" class="btn btn-outline-secondary">Cancelar</a>
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