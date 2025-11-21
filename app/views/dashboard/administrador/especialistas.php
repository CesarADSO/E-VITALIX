<?php
// IMPORTAMOS LAS DEPENDENCIAS NECESARIAS EN ESTE CASO EL SESSION ADMIN Y EL CONTROLADOR
require_once BASE_PATH . '/app/helpers/session_admin.php';
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
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <button class="btn btn-link text-primary p-0"
                                style="text-decoration: none; font-size: 14px;">
                                ← Todos (0)
                            </button>
                        </div>
                        <a href="/E-VITALIX/admin/registrar-especialista" class="btn btn-primary btn-sm" style="border-radius: 20px;"><i class="bi bi-plus-lg"></i> AÑADIR</a>
                    </div>

                    <!-- Especialistas Table -->
                    <div class="bg-white rounded shadow-sm p-4">
                        <table class="table-pacientes">
                            <thead>
                                <tr>
                                    <th style="width: 40px;">
                                        <input type="checkbox" class="form-check-input">
                                    </th>
                                    <th>Foto</th>
                                    <th>
                                        Nombres y apellidos
                                        <i class="bi bi-chevron-down" style="font-size: 12px;"></i>
                                    </th>
                                    <th>Telefono</th>
                                    <th>Especialidad</th>
                                    <th>Consultorio</th>
                                    <th>Estado</th>
                                    <th style="width: 80px;">Acciones</th>
                                </tr>
                            </thead>
                            <tbody
                             <?php if(!empty($especialistas)) :?>
                                <?php foreach($especialistas as $especialista):?>
                                <tr>
                                    <td><input type="checkbox" class="form-check-input"></td>
                                    <td><div class="user-avatar">
                                        <img class="especialistaImg" src="<?= BASE_URL ?>/public/uploads/usuarios/<?= $especialista['foto'] ?>" alt="<?= $especialista['nombres'] ?>">
                                    </div></td>
                                    <td><?= $especialista['nombres'] ?> <?= $especialista['apellidos'] ?></td>
                                    <td><?= $especialista['telefono'] ?></td>
                                    <td><?= $especialista['especialidad'] ?></td>
                                    <td><?= $especialista['consultorio'] ?></td>
                                    <td><?= $especialista['estado'] ?></td>
                                    <td>
                                        <div class="dropdown">
                                            <i class="bi bi-three-dots text-muted" style="cursor: pointer;" data-bs-toggle="dropdown"></i>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" href="/E-VITALIX/admin/actualizar-consultorio"><i class="bi bi-pencil"></i>Editar</a></li>
                                                <li><a class="dropdown-item text-danger" href="#"><i class="bi bi-trash"></i> Eliminar</a></li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach;?>
                            <?php else: ?>
                                <td>No hay especialistas registrados</td>
                            <?php endif;?>
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