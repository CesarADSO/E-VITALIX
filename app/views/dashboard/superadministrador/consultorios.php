<?php
require_once BASE_PATH . '/app/helpers/session_superadmin.php';
// ENLAZAMOS LA DEPENDENCIA, EN ESTE CASO EL CONTROLADOR QUE TIENE LA FUNCIÓN DE CONSULTAR CONSULTORIOS
require_once BASE_PATH . '/app/controllers/consultorioController.php';

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

                <!-- Consultorios Section -->
                <div id="consultoriosSection" style="display: block;">
                    <!-- Top Bar -->
                    <?php
                    include_once __DIR__ . '/../../layouts/topbar_superadministrador.php';
                    ?>

                    <!-- Consultorios Header -->
                    <h4 class="mb-4">Gestión de consultorios</h4>
                    <p class="mb-4 d-none d-md-block">Este módulo le permite gestionar todos los consultorios del sistema. Desde aquí puede crear, editar, consultar y eliminar consultorios, así como generar reportes y visualizar la información general de cada uno para mantener un control completo y actualizado.</p>
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <button class="btn btn-link text-primary p-0"
                                style="text-decoration: none; font-size: 14px;">
                                ← Todos (<?= count($datos) ?>)
                            </button>
                        </div>
                        <div class="d-grid gap-2 d-lg-flex justify-content-lg-end align-items-lg-center">
                            <a href="<?= BASE_URL ?>/superadmin/registrar-consultorio" class="btn btn-primary btn-sm rounded-pill px-3" style="border-radius: 20px;"><i class="bi bi-plus-lg"></i>AÑADIR</a>
                            <a class="btn btn-outline-primary boton-reporte rounded-pill px-4" href="<?= BASE_URL ?>/superadmin/generar-reporte?tipo=consultorios" target="_blank">Generar reporte pdf</a>
                        </div>

                    </div>

                    <!-- Consultorios Table -->
                    <div class="bg-white rounded shadow-sm p-4 d-none d-lg-block">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle table-pacientes table-bordered">

                                <thead>
                                    <tr>
                                        <th>Foto</th>
                                        <th>
                                            Nombre
                                            <i class="bi bi-chevron-down" style="font-size: 12px;"></i>
                                        </th>
                                        <th>Dirección</th>
                                        <th>Teléfono</th>
                                        <th>
                                            Ciudad
                                            <i class="bi bi-chevron-down" style="font-size: 12px;"></i>
                                        </th>
                                        <th>Estado</th>
                                        <th style="width: 80px;">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($datos)) :  ?>
                                        <?php foreach ($datos as $consultorio) : ?>
                                            <tr>
                                                <td><img class="imgconsultorio" src="<?= BASE_URL ?>/public/uploads/consultorios/<?= $consultorio['foto'] ?>" alt="<?= $consultorio['nombre'] ?>"></td>
                                                <td><?= $consultorio['nombre'] ?></td>
                                                <td><?= $consultorio['direccion'] ?></td>
                                                <td><?= $consultorio['telefono'] ?></td>
                                                <td><?= $consultorio['ciudad'] ?></td>
                                                <td><?= $consultorio['estado'] ?></td>
                                                <td>
                                                    <a href="<?= BASE_URL ?>/superadmin/consultar-consultorio?id=<?= $consultorio['id'] ?>" class="btn btn-info btn-sm text-white"><i class="fa-solid fa-magnifying-glass"></i></a>
                                                    <a href="<?= BASE_URL ?>/superadmin/actualizar-consultorio?id=<?= $consultorio['id'] ?>" class="btn btn-success btn-sm text-white"><i class="fa-solid fa-pen-to-square"></i></a>
                                                    <!-- <a href="<?= BASE_URL ?>/superadmin/eliminar-consultorio?accion=eliminar&id=<?= $consultorio['id'] ?>"><i class="fa-solid fa-trash-can"></i></a> -->
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td>No hay consultorios registrados!</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- VISTA MOVIL -->
                    <div class="row d-lg-none mt-3">
                        <?php if (!empty($datos)): ?>
                            <?php foreach ($datos as $consultorio): ?>
                                <div class="col-md-12 mt-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                <h5 class="card-title"><?= $consultorio['nombre'] ?></h5>
                                                <span class="status-badge bg-success text-white">Activo</span>
                                            </div>
                                            <div class="mb-3">
                                                <h6 class="card-subtitle mb-2 text-body-secondary">Ciudad: <?= $consultorio['ciudad'] ?></h6>
                                                <h6 class="card-subtitle mb-2 text-body-secondary">Dirección: <?= $consultorio['direccion'] ?></h6>
                                                <h6 class="card-subtitle mb-2 text-body-secondary">Teléfono: <?= $consultorio['telefono'] ?></h6>
                                            </div>
                                            <div class="cont-botones d-flex justify-content-end gap-2">
                                                <a href="<?= BASE_URL ?>/superadmin/actualizar-consultorio?id=<?= $consultorio['id'] ?>" class="btn btn-success btn-sm text-white"><i class="fa-solid fa-pen-to-square"></i></a>
                                                <a href="<?= BASE_URL ?>/superadmin/consultar-consultorio?id=<?= $consultorio['id'] ?>" class="btn btn-info btn-sm text-white"><i class="fa-solid fa-magnifying-glass"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p>No hay consultorios registrados.</p>

                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <?php
    include_once __DIR__ . '/../../layouts/footer_superadministrador.php';
    ?>