<?php
require_once BASE_PATH . '/app/helpers/session_administrador.php';
require_once BASE_PATH . '/app/controllers/especialistaController.php';

$id = $_GET['id'];

$especialista = listarEspecialista($id);
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
            <div class="main-content col-lg-10 col-md-9">
                <!-- Top Bar -->
                <?php
                include_once __DIR__ . '/../../layouts/topbar_administrador.php';
                ?>

                <!-- Header del Paciente -->
                <div class="patient-header">
                    <div class="container">
                        <div class="row align-items-center">
                            <div class="col-md-12">
                                <a href="<?= BASE_URL ?>/admin/especialistas" class="btn btn-outline-light btn-sm mb-3"><i class="bi bi-arrow-left"></i>Volver a especialistas</a>
                            </div>
                        </div>

                        <div class="card patient-card shadow-sm">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-md-auto text-center mb-3 mb-md-0">
                                        <div class="patient-avatar">
                                            <img class="img-usuario" src="<?= BASE_URL ?>/public/uploads/usuarios/<?= $especialista['foto'] ?>" alt="<?= $especialista['nombres'] ?>">
                                        </div>
                                    </div>

                                    <div class="col-md">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <h2 class="patient-name mb-2"><?= $especialista['nombres'] . ' ' . $especialista['apellidos'] ?></h2>
                                                <p class="patient-info mb-1">
                                                    <i class="bi bi-card-text text-primary"></i>
                                                    <strong><?= $especialista['documento'] ?>:</strong> <?= $especialista['numero_documento'] ?>
                                                </p>
                                                <p class="patient-info mb-1">
                                                    <i class="fa-solid fa-user-doctor text-primary"></i>
                                                    <strong>Especialidad:</strong> <?= $especialista['especialidad'] ?>
                                                </p>
                                                <p class="patient-info mb-1">
                                                    <i class="fa-solid fa-at text-primary"></i>
                                                    <strong>Correo:</strong> <?= $especialista['email'] ?>
                                                </p>
                                            </div>

                                            <div class="col-md-6">
                                                <p class="patient-info mb-1">
                                                    <i class="fa-solid fa-book-medical text-primary"></i>
                                                    <strong>Registro Profesional:</strong> <?= $especialista['registro_profesional'] ?>
                                                </p>
                                                <p class="patient-info mb-1">
                                                    <i class="fa-solid fa-phone text-primary"></i>
                                                    <strong>Teléfono:</strong> <?= $especialista['telefono'] ?>
                                                </p>
                                                <p class="patient-info mb-1">
                                                    <i class="fa-solid fa-location-crosshairs text-primary"></i>
                                                    <strong>Dirección:</strong> <?= $especialista['direccion'] ?>
                                                </p>
                                                <p class="patient-info mb-1">
                                                    <i class="fa-solid fa-user text-primary"></i>
                                                    <strong>Estado:</strong>
                                                    <?php if ($especialista['estado'] == 'Activo'): ?>
                                                        <span class="badge bg-success status-badge status btn-estado text-white"><?= $especialista['estado'] ?></span>
                                                    <?php else: ?>
                                                        <span class="badge bg-danger status-badge status btn-estado text-white"><?= $especialista['estado'] ?></span>
                                                    <?php endif; ?>
                                                </p>
                                                <span class="badge badge-readonly">
                                                    <i class="bi bi-lock-fill"></i> Solo lectura
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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