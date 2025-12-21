<?php
    require_once BASE_PATH . '/app/helpers/session_administrador.php';
    require_once BASE_PATH . '/app/controllers/servicioController.php';


    $id = $_GET['id'];

    $servicio = listarServicio($id);

    $estado = strtolower($servicio['estado_servicio']);

    $claseEstado = ($estado === 'activo') ? 'activo' : 'inactivo';
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

                <div class="container mt-4">
                    <div class="card shadow-sm">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Detalle del Servicio</h5>
                            <span class="badge <?= $claseEstado ?>">
                                <?php if($estado === 'activo'): ?>
                                    <span class="badge bg-success"><?= $servicio['estado_servicio'] ?></span>
                                <?php else:?>
                                    <span class="badge bg-danger"><?= $servicio['estado_servicio'] ?></span>
                                <?php endif;?>
                                
                            </span>
                        </div>

                        <div class="card-body">
                            <h4 class=""><?= $servicio['nombre'] ?></h4>
                            <p class="text-muted"><?= $servicio['descripcion'] ?></p>

                            <hr>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <strong>Código:</strong> <?= $servicio['codigo_servicio'] ?>
                                </div>
                                <div class="col-md-6">
                                    <strong>Duración:</strong> <?= $servicio['duracion_minutos'] ?>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <strong>Precio:</strong> $<?= $servicio['precio'] ?> COP
                                </div>
                                <div class="col-md-6">
                                    <strong>Método de pago:</strong> <?= $servicio['metodo_pago'] ?>
                                </div>
                            </div>

                            <hr>

                            <h6>Especialista asignado</h6>
                            <p>
                                <?= $servicio['nombre_especialista'] ?> <?= $servicio['apellido_especialista'] ?>
                            </p>
                        </div>

                        <div class="card-footer d-flex justify-content-between">
                            <a href="<?= BASE_URL ?>/admin/servicios" class="btn btn-outline-secondary">Volver</a>
                            <a href="<?= BASE_URL ?>/admin/actualizar-servicio?id=<?= $servicio['id'] ?>" class="btn btn-primary">Editar</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
    include_once __DIR__ . '/../../layouts/footer_administrador.php';
    ?>