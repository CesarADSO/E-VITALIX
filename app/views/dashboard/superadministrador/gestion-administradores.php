<?php
require_once BASE_PATH . '/app/helpers/session_superadmin.php';
// ENLAZAMOS LA DEPENDENCIA, EN ESTE CASO EL CONTROLADOR QUE TIENE LA FUNCIÓN DE CONSULTAR CONSULTORIOS
require_once BASE_PATH . '/app/controllers/administradorConsultorioController.php';

// LLAMAMOS LA FUNCIÓN ESPECÍFICA QUE EXISTE EN DICHO CONTROLADOR

$administradores = mostrarAdministradoresConsultorios();

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
                <div id="consultoriosSection" style="display: block;">
                    <!-- Top Bar -->
                    <?php
                    include_once __DIR__ . '/../../layouts/topbar_superadministrador.php';
                    ?>

                    <!-- Consultorios Header -->
                    <h4 class="mb-4">Gestión de administradores de los consultorios</h4>
                    <p class="mb-4 d-none d-lg-block">Este módulo le permite gestionar y administrar la información de los administradores de cada consultorio.</p>
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <button class="btn btn-link text-primary p-0"
                                style="text-decoration: none; font-size: 14px;">
                                ← Todos (<?= count($administradores) ?>)
                            </button>
                        </div>
                        <a class="btn btn-primary boton-reporte" href="<?= BASE_URL ?>/superadmin/generar-reporte?tipo=administradores" target="_blank">Generar reporte pdf</a>
                        <!-- <a href="<?= BASE_URL ?>/superadmin/registrar-administrador" class="btn btn-primary btn-sm" style="border-radius: 20px;"><i class="bi bi-plus-lg"></i> AÑADIR</a> -->
                    </div>

                    <!-- Consultorios Table -->
                    <div class="bg-white rounded shadow-sm p-4 d-none d-lg-block">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle table-pacientes table-bordered">
                                <thead>
                                    <tr>
                                        <th>Foto</th>
                                        <th>
                                            Nombres y apellidos
                                        </th>
                                        <th>
                                            Consultorio
                                        </th>
                                        <th>Teléfono</th>
                                        <th>Tipo de documento</th>
                                        <th>Número de documento</th>
                                        <th>Estado</th>
                                        <th style="width: 80px;">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($administradores)) : ?>
                                        <?php foreach ($administradores as $administrador) : ?>
                                            <tr>
                                                <td><img class="imgconsultorio" src="<?= BASE_URL ?>/public/uploads/usuarios/<?= $administrador['foto'] ?>" alt="<?= $administrador['nombres'] ?>"></td>
                                                <td><?= $administrador['nombres'] ?> <?= $administrador['apellidos'] ?></td>
                                                <td><?= $administrador['nombre_consultorio'] ?></td>
                                                <td><?= $administrador['telefono'] ?></td>
                                                <td><?= $administrador['tipo_documento'] ?></td>
                                                <td><?= $administrador['numero_documento'] ?></td>
                                                <td><?= $administrador['estado'] ?></td>
                                                <td>
                                                    <!-- <a href="#"><i class="fa-solid fa-magnifying-glass"></i></a> -->
                                                    <a href="<?= BASE_URL ?>/superadmin/actualizar-administrador?id=<?= $administrador['id'] ?>"><i class="fa-solid fa-pen-to-square"></i></a>
                                                    <a href="<?= BASE_URL ?>/superadmin/eliminar-administrador?id=<?= $administrador['id'] ?>&accion=eliminar&id_usuario=<?= $administrador['id_usuario'] ?>"><i class="fa-solid fa-trash-can"></i></a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <td>
                                            no hay administradores de consultorio registrados
                                        </td>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- VISTA MOVIL -->
                    <div class="row d-lg-none mt-3">
                        <?php if (!empty($administradores)): ?>
                            <?php foreach ($administradores as $administrador): ?>
                                <div class="col-md-12 mt-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                <h5 class="card-title"><?= $administrador['nombres'] ?> <?= $administrador['apellidos'] ?></h5>
                                                <?php if ($administrador['estado'] === 'Activo'): ?>
                                                    <span class="status-badge bg-success text-white"><?= $administrador['estado'] ?></span>
                                                <?php else: ?>
                                                    <span class="status-badge bg-danger text-white"><?= $administrador['estado'] ?></span>
                                                <?php endif; ?>
                                            </div>
                                            <div class="mb-3">
                                                <h6 class="card-subtitle mb-2 text-body-secondary">Consultorio: <?= $administrador['nombre_consultorio'] ?></h6>
                                                <h6 class="card-subtitle mb-2 text-body-secondary">Teléfono: <?= $administrador['telefono'] ?></h6>
                                                <h6 class="card-subtitle mb-2 text-body-secondary">Tipo de documento: <?= $administrador['tipo_documento'] ?></h6>
                                                <h6 class="card-subtitle mb-2 text-body-secondary">Número de documento: <?= $administrador['numero_documento'] ?></h6>
                                            </div>
                                            <div class="cont-botones d-flex justify-content-end gap-2">
                                                <a href="<?= BASE_URL ?>/superadmin/actualizar-administrador?id=<?= $administrador['id'] ?>" class="btn btn-success btn-sm text-white"><i class="fa-solid fa-pen-to-square"></i></a>
                                                <a href="<?= BASE_URL ?>/superadmin/eliminar-administrador?id=<?= $administrador['id'] ?>&accion=eliminar&id_usuario=<?= $administrador['id_usuario'] ?>" class="btn btn-danger btn-sm text-white"><i class="fa-solid fa-trash-can"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p>No hay administradores registrados.</p>
                        <?php endif; ?>
                    </div>

                </div>
            </div>
        </div>
    </div>


    <?php
    include_once __DIR__ . '/../../layouts/footer_superadministrador.php';
    ?>