
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
                    <p class="mb-4">Gestione a los especialistas de su consultorio: registre nuevos profesionales, actualice su información, consulte sus datos y administre su estado dentro del sistema.</p>
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <button class="btn btn-link text-primary p-0"
                                style="text-decoration: none; font-size: 14px;">
                                ← Todos (<?= count($especialistas) ?>)
                            </button>
                        </div>
                        <a href="/E-VITALIX/admin/registrar-especialista" class="btn btn-primary btn-sm btn-añadir-volver"><i class="bi bi-plus-lg"></i> AÑADIR</a>
                    </div>

                    <!-- Especialistas Table -->
                    <div class="bg-white rounded shadow-sm p-4">
                        <a class="btn btn-primary boton-reporte" href="<?= BASE_URL ?>/admin/generar-reporte?tipo=especialistas" target="_blank">Generar reporte pdf</a>
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
                                                <a href="<?= BASE_URL ?>/admin/consultar-especialista?id=<?= $especialista['id'] ?>"><i class="fa-solid fa-magnifying-glass"></i></a>
                                                <a href="<?= BASE_URL ?>/admin/actualizar-especialista?id=<?= $especialista['id'] ?>"><i class="fa-solid fa-pen-to-square"></i></a>
                                               
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <td>No hay especialistas registrados</td>
                                <?php endif; ?>
                            </tbody>
                        </table>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>

    <?php
    include_once __DIR__ . '/../../layouts/footer_administrador.php';
    ?>