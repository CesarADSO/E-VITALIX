<?php
require_once BASE_PATH . '/app/helpers/session_admin.php';
require_once BASE_PATH . '/app/controllers/usuarioController.php';

$datos = mostrarUsuario();

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

                <!-- Consultorios Section -->
                <div id="consultoriosSection" style="display: block;">
                    <!-- Top Bar -->
                    <?php
                    include_once __DIR__ . '/../../layouts/topbar_administrador.php';
                    ?>

                    <!-- Consultorios Header -->
                    <h4 class="mb-4">Gestión de usuarios</h4>
                    <p class="mb-4">Aquí puede ver la lista de usuarios registrados con su correo, rol y estado. A la derecha encontrará los botones para gestionar cada usuario.</p>
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <button class="btn btn-link text-primary p-0"
                                style="text-decoration: none; font-size: 14px;">
                                ← Todos (<?= count($datos) ?>)
                            </button>
                        </div>
                    </div>

                    <!-- Consultorios Table -->
                    <div class="bg-white rounded shadow-sm p-4">
                        <!-- <a href="<?= BASE_URL ?>/admin/generar-reporte-consultorios" target="_blank">generar reporte pdf</a> -->
                        <table class="table-pacientes" action="<?= BASE_URL ?>/admin/usuarios" method="POST">

                            <thead>
                                <tr>


                                    <th>
                                        Correo
                                        <i class="bi bi-chevron-down" style="font-size: 12px;"></i>
                                    </th>
                                    <th>rol</th>

                                    <th>Estado</th>
                                    <th style="width: 80px;">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($datos)) :  ?>
                                    <?php foreach ($datos as $usuario) : ?>
                                        <tr>


                                            <td><?= $usuario['email'] ?></td>
                                            <td><?= $usuario['rol'] ?></td>
                                            <td><?= $usuario['estado'] ?></td>
                                            <td>
                                                <a href="<?= BASE_URL ?>/admin/actualizar-usuario?id=<?= $usuario['id'] ?>"><i class="fa-solid fa-pen-to-square"></i></a>
                                                <a href="<?= BASE_URL ?>/admin/eliminar-usuario?accion=eliminar&id=<?= $usuario['id'] ?>"><i class="fa-solid fa-trash-can"></i></a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td>No hay usuarios registrados!</td>
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