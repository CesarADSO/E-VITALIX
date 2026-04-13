<?php
require_once BASE_PATH . '/app/helpers/session_administrador.php';
require_once BASE_PATH . '/app/controllers/asistenteController.php';


$datos = mostrarAsistentes();
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
                    <h4 class="mb-4">Gestión de asistentes del consultorio</h4>
                    <p class="mb-4 d-none d-md-block">Gestione a los asistentes de su consultorio: registre nuevos asistentes, actualice su información, consulte sus datos y administre su estado dentro del sistema.</p>
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <button class="btn btn-link text-primary p-0"
                                style="text-decoration: none; font-size: 14px;">
                                ← Todos (<?= count($datos) ?>)
                            </button>
                        </div>
                        <div class="d-grid gap-2 d-lg-flex justify-content-lg-end align-items-lg-center">
                            <a href="<?= BASE_URL ?>/admin/registrar-asistente" class="btn btn-primary btn-sm rounded-pill px-3" style="border-radius: 20px;"><i class="bi bi-plus-lg"></i> AÑADIR</a>
                            <a class="btn btn-outline-primary boton-reporte rounded-pill px-4" href="<?= BASE_URL ?>/admin/generar-reporte?tipo=asistentes" target="_blank">Generar reporte pdf</a>
                        </div>

                    </div>

                    <div class="card shadow-sm d-none d-lg-block">
                        <div class="card-header card-header-primary">
                            <h5 class="mb-0 text-white">
                                <i class="bi bi-calendar-check me-2"></i>
                                Lista de asistentes
                            </h5>
                        </div>
                        <div class="card-body">
                            <?php if (empty($datos)): ?>
                                <div class="alert alert-info text-center" role="alert">
                                    <i class="bi bi-info-circle me-2"></i>
                                    No tienes asistentes registrados.
                                </div>
                            <?php else: ?>
                                <!-- asistentes Table -->
                                <div class="bg-white rounded shadow-sm p-4">
                                    <div class="table-responsive">
                                        <table class="table table-hover align-middle table-pacientes table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Foto</th>
                                                    <th>
                                                        Nombres y Apellidos
                                                        <i class="bi bi-chevron-down" style="font-size: 12px;"></i>
                                                    </th>
                                                    <th>Tipo de documento</th>
                                                    <th>Número de documento</th>
                                                    <th>Teléfono</th>
                                                    <th>Estado</th>
                                                    <th style="width: 80px;">Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if (isset($datos)) : ?>
                                                    <?php foreach ($datos as $asistente): ?>
                                                        <tr>
                                                            <td>
                                                                <img class="imgAsistente"
                                                                    src="<?= BASE_URL ?>/public/uploads/usuarios/<?= $asistente['foto'] ?>"
                                                                    alt="<?= $asistente['nombres'] ?> <?= $asistente['apellidos'] ?>"
                                                                    style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover;">
                                                            </td>
                                                            <td><?= $asistente['nombres'] ?> <?= $asistente['apellidos'] ?></td>
                                                            <td><?= $asistente['tipo_documento'] ?></td>
                                                            <td><?= $asistente['numero_documento'] ?></td>
                                                            <td><?= $asistente['telefono'] ?></td>
                                                            <td><?= $asistente['estado'] ?></td>
                                                            <td>
                                                                <!-- <a href=""><i class="fa-solid fa-magnifying-glass"></i></a> -->
                                                                <a href="<?= BASE_URL ?>/admin/actualizar-asistente?id=<?= $asistente['id'] ?>" class="btn btn-success btn-sm text-white"><i class="fa-solid fa-pen-to-square"></i></a>
                                                                <!-- <a href=""><i class="fa-solid fa-trash-can"></i></a> -->
                                                            </td>
                                                        </tr>


                                                    <?php endforeach; ?>
                                                <?php else : ?>
                                                    <td>No hay asistentes registrados</td>
                                                <?php endif; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                        </div>
                    </div>
                <?php endif; ?>
                </div>

                <!-- VISTA MOVIL -->
                <div class="row d-lg-none mt-3">
                    <?php if (!empty($datos)): ?>
                        <?php foreach ($datos as $asistente): ?>
                            <div class="col-md-12 mt-4">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <h5 class="card-title text-truncate"><?= $asistente['nombres'] ?> <?= $asistente['apellidos'] ?></h5>
                                            <?php if ($asistente['estado'] === 'Activo'): ?>
                                                <span class="status-badge bg-success text-white"><?= $asistente['estado'] ?></span>
                                            <?php else: ?>
                                                <span class="status-badge bg-danger text-white"><?= $asistente['estado'] ?></span>
                                            <?php endif; ?>
                                        </div>
                                        <div class="mb-3">
                                            <h6 class="card-subtitle mb-2 text-body-secondary">Tipo de documento: <?= $asistente['tipo_documento'] ?></h6>
                                            <h6 class="card-subtitle mb-2 text-body-secondary">Número de documento: <?= $asistente['numero_documento'] ?></h6>
                                            <h6 class="card-subtitle mb-2 text-body-secondary">Teléfono: <?= $asistente['telefono'] ?></h6>
                                        </div>
                                        <div class="cont-botones d-flex justify-content-end gap-2">
                                            <a href="<?= BASE_URL ?>/admin/actualizar-asistente?id=<?= $asistente['id'] ?>" class="btn btn-success btn-sm text-white"><i class="fa-solid fa-pen-to-square"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>No hay asistentes registrados.</p>

                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>


    <?php
    include_once __DIR__ . '/../../layouts/footer_administrador.php';
    ?>