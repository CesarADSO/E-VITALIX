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
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <button class="btn btn-link text-primary p-0"
                                style="text-decoration: none; font-size: 14px;">
                                ← Todos (<?= count($datos) ?>)
                            </button>
                        </div>
                        <a href="<?= BASE_URL ?>/admin/registrar-asistente" class="btn btn-primary btn-sm" style="border-radius: 20px;"><i class="bi bi-plus-lg"></i> AÑADIR</a>
                    </div>

                    <!-- asistentes Table -->
                    <div class="bg-white rounded shadow-sm p-4">
                        <table class="table-pacientes">
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
                                <?php if(isset($datos)) :?>
                                <?php foreach($datos as $asistente):?>
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
                                        <a href="<?= BASE_URL ?>/admin/actualizar-asistente"><i class="fa-solid fa-pen-to-square"></i></a>
                                        <!-- <a href=""><i class="fa-solid fa-trash-can"></i></a> -->
                                    </td>
                                </tr>
                                

                                <?php endforeach; ?>
                                <?php else :?>
                                    <tr>
                                        <td colspan="10" class="text-center" style="padding: 40px;">
                                            <i class="bi bi-inbox" style="font-size: 48px; color: var(--gris-proyecto);"></i>
                                            <p style="color: var(--gris-proyecto); margin-top: 10px;">No hay asistentes registrados</p>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>


    <?php
    include_once __DIR__ . '/../../layouts/footer_administrador.php';
    ?>