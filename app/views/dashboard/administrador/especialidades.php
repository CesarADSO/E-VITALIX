<?php
    require_once BASE_PATH . '/app/helpers/session_administrador.php';
    require_once BASE_PATH . '/app/controllers/especialidadController.php';

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

                <!-- asistentes Section -->
                <div id="asistentesSection" style="display: block;">
                    <!-- Top Bar -->
                    <?php
                    include_once __DIR__ . '/../../layouts/topbar_administrador.php';
                    ?>

                    <!-- Pacientes Header -->
                    <h4 class="mb-4">Gestión de especialidades del consultorio</h4>
                    <p class="mb-4">Gestione las especialidades de su consultorio.</p>
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <button class="btn btn-link text-primary p-0"
                                style="text-decoration: none; font-size: 14px;">
                                ← Todos (0)
                            </button>
                        </div>
                        <button class="btn btn-primary btn-sm btn-añadir-volver" data-bs-toggle="modal" data-bs-target="#formularioModal"><i class="bi bi-plus-lg"></i>AÑADIR</button>
                    </div>

                    <div class="card shadow-sm">
                        <div class="card-header card-header-primary">
                            <h5 class="mb-0 text-white">
                                <i class="bi bi-calendar-check me-2"></i>
                                Lista de especialidades
                            </h5>
                        </div>
                        <div class="card-body">
                            <!-- <div class="alert alert-info text-center" role="alert">
                                    <i class="bi bi-info-circle me-2"></i>
                                    No tienes especialidades registradas.
                                </div> -->
                            <!-- asistentes Table -->
                            <div class="bg-white rounded shadow-sm p-4">
                                <!-- <a class="btn btn-primary boton-reporte" href="<?= BASE_URL ?>/admin/generar-reporte?tipo=asistentes" target="_blank">Generar reporte pdf</a> -->
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle table-pacientes table-bordered">
                                        <thead>
                                            <tr>
                                                <th>
                                                    Nombre
                                                    <i class="bi bi-chevron-down" style="font-size: 12px;"></i>
                                                </th>
                                                <th>Descripción</th>
                                                <th>Estado</th>
                                                <th style="width: 80px;">Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if(!empty($especialidades)):?>
                                                <?php foreach($especialidades as $especialidad):?>
                                            <tr>
                                                <td><?= $especialidad['nombre'] ?></td>
                                                <td><?= $especialidad['descripcion'] ?></td>
                                                <td>
                                                    <?php if($especialidad['estado'] === 'ACTIVA'):?>
                                                    <a class="badge bg-success status-badge status btn-estado" href="#"><?= $especialidad['estado'] ?></a>
                                                    <?php else:?>
                                                    <a class="badge bg-danger status-badge status btn-estado" href="#"><?= $especialidad['estado'] ?></a>
                                                    <?php endif;?>
                                                </td>
                                                <td>
                                                    <a href="#" class="btn btn-sm btn-info"
                                                        title="Editar especialidad">
                                                        <i class="fa-solid fa-pen-to-square editar"></i></a>
                                                </td>
                                            </tr>
                                            <?php endforeach;?>
                                            <?php else:?>
                                                <h2>No hay especialidades registradas</h2>
                                            <?php endif;?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Modal -->
                <div class="modal fade" id="formularioModal" tabindex="-1" aria-labelledby="formularioModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">

                            <!-- Header del Modal -->
                            <div class="modal-header">
                                <h5 class="modal-title" id="formularioModalLabel">
                                    Registrar especialidad
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>

                            <!-- Body del Modal con Formulario -->
                            <div class="modal-body">
                                <form id="miFormulario" action="<?= BASE_URL ?>/admin/guardar-especialidad" method="POST">

                                    <!-- Campo Nombre -->
                                    <div class="mb-4">
                                        <label for="nombre" class="form-label">
                                            Nombre <span class="required">*</span>
                                        </label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="nombre"
                                            name="nombre"
                                            placeholder="Ingrese el nombre"
                                            required>

                                    </div>

                                    <!-- Campo Descripción -->
                                    <div class="mb-4">
                                        <label for="descripcion" class="form-label">
                                            Descripción <span class="required">*</span>
                                        </label>

                                        <textarea
                                            class="form-control"
                                            id="descripcion"
                                            name="descripcion"
                                            rows="4"
                                            placeholder="Ingrese una descripción detallada"
                                            required></textarea>

                                        <div class="form-text">
                                            Proporcione una descripción clara y detallada
                                        </div>
                                    </div>

                                    <!-- Footer del Modal -->
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                            Cancelar
                                        </button>
                                        <button type="submit" class="btn btn-primary">
                                            Registrar especialidad
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <?php
    include_once __DIR__ . '/../../layouts/footer_administrador.php';
    ?>