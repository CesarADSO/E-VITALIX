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
                                <a href="<?= BASE_URL ?>/especialista/pacientes-atendidos" class="btn btn-outline-light btn-sm mb-3"><i class="bi bi-arrow-left"></i>Volver a pacientes atendidos</a>
                            </div>
                        </div>

                        <div class="card patient-card shadow-sm">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-md-auto text-center mb-3 mb-md-0">
                                        <div class="patient-avatar">
                                            <img class="img-paciente" src="<?= BASE_URL ?>/public/uploads/pacientes/<?= $paciente['foto'] ?>" alt="<?= $paciente['nombre_paciente'] ?>">
                                        </div>
                                    </div>

                                    <div class="col-md">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <h2 class="patient-name mb-2"><?= $paciente['nombre_paciente'] ?> <?= $paciente['apellido_paciente'] ?></h2>
                                                <p class="patient-info mb-1">
                                                    <i class="bi bi-card-text text-primary"></i>
                                                    <strong><?= $paciente['tipo_documento'] ?>:</strong> <?= $paciente['numero_documento'] ?>
                                                </p>
                                                <p class="patient-info mb-1">
                                                    <i class="bi bi-calendar text-primary"></i>
                                                    <strong>Edad:</strong> <?= $paciente['edad'] ?> años
                                                </p>
                                            </div>

                                            <div class="col-md-6">
                                                <p class="patient-info mb-1">
                                                    <i class="bi bi-droplet-fill text-danger"></i>
                                                    <strong>Tipo de sangre:</strong> <?= $paciente['rh'] ?>
                                                </p>
                                                <p class="patient-info mb-1">
                                                    <i class="fa-solid fa-user"></i>
                                                    <strong>Sexo:</strong> <?= $paciente['genero'] ?>
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