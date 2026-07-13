<?php
require_once BASE_PATH . '/app/helpers/session_superadmin.php';
require_once BASE_PATH . '/app/controllers/especialidadController.php';

$id = $_GET['id'];

$especialidad = listarEspecialidadPorId($id);
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

                <!-- especialidades Section -->
                <div id="especialidadesSection">
                    <!-- Top Bar -->
                    <?php
                    include_once __DIR__ . '/../../layouts/topbar_superadministrador.php';
                    ?>

                    <!-- Asistentes Header -->
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <a href="<?= BASE_URL ?>/superadmin/especialidades" class="btn btn-link text-primary p-0" style="text-decoration: none; font-size: 14px;">← Todos</a>
                        <a href="<?= BASE_URL ?>/superadmin/especialidades" class="btn btn-primary btn-sm btn-añadir-volver"><i class="bi bi-arrow-left"></i> VOLVER</a>
                    </div>

                    <!-- Formulario de modificación de especialidades -->
                    <div class="bg-white rounded shadow-sm p-4">
                        <h4 class="mb-4">Actualizar Especialidad</h4>
                        <p class="text-muted mb-4 texto">Actualiza la información de la especialidad seleccionada</p>


                        <form id="especialidadForm" action="<?= BASE_URL ?>/superadmin/guardar-cambios-especialidad" method="POST" novalidate>
                            <input type="hidden" name="id" value="<?= $especialidad['id'] ?>">
                            <input type="hidden" name="accion" value="actualizar">

                            <!-- Nombre y descripción -->

                            <div class="mb-3">
                                <label for="nombre" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" value="<?= $especialidad['nombre'] ?>">
                            </div>

                            <div class="mb-3">
                                <label for="descripcion" class="form-label">Descripción</label>
                                <textarea id="descripcion" name="descripcion" class="form-control"><?= $especialidad['descripcion'] ?></textarea>
                            </div>



                            <div class="d-flex justify-content-between">
                                <a href="<?= BASE_URL ?>/superadmin/especialidades" class="btn btn-outline-secondary">Cancelar</a>
                                <button type="submit" class="btn boton">Actualizar Especialidad</button>
                            </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php
    include_once __DIR__ . '/../../layouts/footer_superadministrador.php';
?>

<!-- VALIDACIONES EN ESPAÑOL (MISMO SISTEMA DEL LOGIN) -->
<script src="<?= BASE_URL ?>/public/assets/js/validaciones.js"></script>
<script>
    // Configurar validaciones para el formulario de actualización de especialidad
    configurarValidacionesFormulario('especialidadForm', {
        'nombre': {
            tipo: 'nombres',
            opciones: {}
        },
        'descripcion': {
            tipo: 'textarea',
            opciones: {}
        }
    });
</script>