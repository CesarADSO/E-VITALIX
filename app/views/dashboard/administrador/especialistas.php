<?php
// IMPORTAMOS LAS DEPENDENCIAS NECESARIAS EN ESTE CASO EL SESSION ADMIN Y EL CONTROLADOR
require_once BASE_PATH . '/app/helpers/session_administrador.php';
require_once BASE_PATH . '/app/controllers/especialistaController.php';

// DECLARAMOS UNA VARIABLE PARA GUARDAR LA FUNCIÓN DEL MODELO Y ASÍ PODER USAR ESA VARIABLE PARA PINTAR LOS DATOS EN LA TABLA
$especialistas = mostrarEspecialistas();

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

                <!-- Especialistas Section -->
                <div id="EspecialistasSection" style="display: block;">
                    <!-- Top Bar -->
                    <?php
                    include_once __DIR__ . '/../../layouts/topbar_administrador.php';
                    ?>

                    <!-- Especialista Header -->
                    <h4 class="mb-4">Gestión De Especialistas</h4>
                    <p class="mb-4 d-none d-md-block">Gestione a los especialistas de su consultorio: registre nuevos profesionales, actualice su información, consulte sus datos y administre su estado dentro del sistema.</p>
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <button class="btn btn-link text-primary p-0"
                                style="text-decoration: none; font-size: 14px;">
                                ← Todos (<?= count($especialistas) ?>)
                            </button>
                        </div>
                        <div class="d-grid gap-2 d-lg-flex justify-content-lg-end align-items-lg-center">
                            <a href="/E-VITALIX/admin/registrar-especialista" class="btn btn-primary btn-sm btn-añadir-volver rounded-pill px-3"><i class="bi bi-plus-lg"></i> AÑADIR</a>
                            <a class="btn btn-outline-primary boton-reporte rounded-pill px-4" href="<?= BASE_URL ?>/admin/generar-reporte?tipo=especialistas" target="_blank">Generar reporte pdf</a>
                        </div>

                    </div>

                    <!-- Especialistas Table -->
                    <div class="bg-white rounded shadow-sm p-4 d-none d-lg-block">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle table-pacientes table-bordered">
                                <thead>
                                    <tr>
                                        <th>Foto</th>
                                        <th>
                                            Nombres y apellidos
                                            <i class="bi bi-chevron-down" style="font-size: 12px;"></i>
                                        </th>
                                        <th>Telefono</th>
                                        <th>Especialidad</th>
                                        <th>Estado</th>
                                        <th style="width: 80px;">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($especialistas)) : ?>
                                        <?php foreach ($especialistas as $especialista): ?>
                                            <tr>
                                                <td>
                                                    <div class="user-avatar">
                                                        <img class="especialistaImg" src="<?= BASE_URL ?>/public/uploads/usuarios/<?= $especialista['foto'] ?>" alt="<?= $especialista['nombres'] ?>">
                                                    </div>
                                                </td>
                                                <td><?= $especialista['nombres'] ?> <?= $especialista['apellidos'] ?></td>
                                                <td><?= $especialista['telefono'] ?></td>
                                                <td><?= $especialista['nombre_especialidad'] ?></td>
                                                <td><?= $especialista['estado'] ?></td>
                                                <td>
                                                    <a href="<?= BASE_URL ?>/admin/actualizar-especialista?id=<?= $especialista['id'] ?>" class="btn btn-success btn-sm text-white"><i class="fa-solid fa-pen-to-square"></i></a>
                                                    <a href="<?= BASE_URL ?>/admin/consultar-especialista?id=<?= $especialista['id'] ?>" class="btn btn-info btn-sm text-white"><i class="fa-solid fa-magnifying-glass"></i></a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <td>No hay especialistas registrados.</td>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- VISTA MOVIL -->
                    <div class="row d-lg-none mt-3">
                        <?php if (!empty($especialistas)): ?>
                            <?php foreach ($especialistas as $especialista): ?>
                                <div class="col-md-12 mt-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                <h5 class="card-title text-truncate"><?= $especialista['nombres'] ?> <?= $especialista['apellidos'] ?></h5>
                                                <?php if ($especialista['estado'] === 'Activo'): ?>
                                                    <span class="status-badge bg-success text-white"><?= $especialista['estado'] ?></span>
                                                <?php else: ?>
                                                    <span class="status-badge bg-danger text-white"><?= $especialista['estado'] ?></span>
                                                <?php endif; ?>
                                            </div>
                                            <div class="mb-3">
                                                <h6 class="card-subtitle mb-2 text-body-secondary">Teléfono: <?= $especialista['telefono'] ?></h6>
                                                <h6 class="card-subtitle mb-2 text-body-secondary">Especialidad: <?= $especialista['nombre_especialidad'] ?></h6>
                                            </div>
                                            <div class="cont-botones d-flex justify-content-end gap-2">
                                                <a href="<?= BASE_URL ?>/admin/actualizar-especialista?id=<?= $especialista['id'] ?>" class="btn btn-success btn-sm text-white"><i class="fa-solid fa-pen-to-square"></i></a>
                                                <a href="<?= BASE_URL ?>/admin/consultar-especialista?id=<?= $especialista['id'] ?>" class="btn btn-info btn-sm text-white"><i class="fa-solid fa-magnifying-glass"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p>No hay especialistas registrados.</p>

                        <?php endif; ?>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <?php
    include_once __DIR__ . '/../../layouts/footer_administrador.php';
    ?>