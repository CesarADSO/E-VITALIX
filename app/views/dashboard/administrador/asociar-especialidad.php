<?php
require_once BASE_PATH . '/app/helpers/session_administrador.php';
require_once BASE_PATH . '/app/controllers/especialidadController.php';


$especialidades = listarParaLosPacientes();
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

                <!-- especialidades Section -->
                <div id="especialidadesSection">
                    <!-- Top Bar -->
                    <?php
                    include_once __DIR__ . '/../../layouts/topbar_administrador.php';
                    ?>

                    <!-- Asistentes Header -->
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <a href="<?= BASE_URL ?>/admin/especialidades" class="btn btn-link text-primary p-0" style="text-decoration: none; font-size: 14px;">← Todos</a>
                        <a href="<?= BASE_URL ?>/admin/especialidades" class="btn btn-primary btn-sm btn-añadir-volver"><i class="bi bi-arrow-left"></i> VOLVER</a>
                    </div>

                    <!-- Formulario de modificación de especialidades -->
                    <div class="bg-white rounded shadow-sm p-4">
                        <h4 class="mb-4">Asociar especialidad</h4>
                        <p class="text-muted mb-4 texto">Asocia una especialidad para tu consultorio al asociarla tu consultorio ya la ofrece y los paciente podrán encontrar tu consultorio al buscar esta especialidad</p>


                        <form id="especialidadForm" action="<?= BASE_URL ?>/admin/guardar-asociacion" method="POST">
                            <input type="hidden" name="id" value="<?= $especialidad['id'] ?>">
                            <input type="hidden" name="accion" value="asociarEspecialidad">

                            <!-- SELECT DE ESPECIALIDADES -->

                            <div class="mb-3">
                                <label class="form-label">Especialidad</label>
                                <select name="id_especialidad" id="#" class="form-control">
                                    <?php if(!empty($especialidades)): ?>
                                        <?php foreach($especialidades as $especialidad):?>
                                    <option value="<?= $especialidad['id'] ?>"><?= $especialidad['nombre'] ?></option>
                                    <?php endforeach;?>
                                    <?php endif;?>
                                </select>
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="<?= BASE_URL ?>/admin/especialidades" class="btn btn-outline-secondary">Cancelar</a>
                                <button type="submit" class="btn boton">Asociar Especialidad</button>
                            </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php
    include_once __DIR__ . '/../../layouts/footer_administrador.php';
?>