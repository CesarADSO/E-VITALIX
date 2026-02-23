<?php
require_once BASE_PATH . '/app/helpers/session_asistente.php';
require_once BASE_PATH . '/app/controllers/ticketController.php';

$tickets = listarConIdDeUsuario();
?>

<?php
include_once __DIR__ . '/../../layouts/header_asistente.php';
?>

<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <?php
            include_once __DIR__ . '/../../layouts/sidebar_asistente.php';
            ?>

            <!-- Main Content -->
            <div class="col-lg-10 col-md-9 main-content">

                <div class="section-tickets">
                    <!-- TOP BAR -->
                    <?php
                    include_once __DIR__ . '/../../layouts/topbar_asistente.php';
                    ?>

                    <!-- TICKETS HEADER -->
                    <h4 class="mb-4">Mis tickets</h4>
                    <p class="mb-4">En esta interfaz usted podrá consultar los tickets de soporte técnico que ha enviado, podrá visualizar su estado y podrá dar por finalizado el ticket cuando usted quiera</p>
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <button class="btn btn-link text-primary p-0" style="text-decoration: none; font-size: 14px;">← Todos()</button>
                        </div>
                        <a href="<?= BASE_URL ?>/asistente/crear-ticket" class="btn btn-primary btn-sm btn-añadir-volver"><i class="bi bi-plus-lg"></i>CREAR</a>
                    </div>

                    <div class="card shadow-sm">
                        <div class="card-header card-header-primary">
                            <h5 class="mb-0 text-white"><i class="bi bi-calendar-check me-2"></i>Lista de tickets</h5>
                        </div>

                        <div class="card-body">
                            <div class="bg-white rounded shadow-sm mb-4">
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle table-pacientes table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Título</th>
                                                <th>Estado</th>
                                                <th>Fecha de creación</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if(!empty($tickets)):?>
                                                <?php foreach($tickets as $ticket):?>
                                                
                                            <tr>
                                                <td><?= $ticket['titulo'] ?></td>
                                                <td>
                                                    <?php if($ticket['estado'] === 'ABIERTO'):?>
                                                    <span class="badge bg-info status-badge status text-white"><?= $ticket['estado'] ?></span>
                                                    <?php elseif($ticket['estado'] === 'RESPONDIDO'):?>
                                                        <span class="badge bg-success status-badge status text-white"><?= $ticket['estado'] ?></span>
                                                    <?php else:?>
                                                        <span class="badge bg-danger status-badge status text-white"><?= $ticket['estado'] ?></span>
                                                    <?php endif;?>
                                                </td>
                                                <td><?= $ticket['created_at'] ?></td>
                                                <td>
                                                    <?php if($ticket['estado'] === 'ABIERTO'):?>
                                                    <a href="<?= BASE_URL ?>/asistente/consultar-ticket?id=<?= $ticket['id'] ?>" class="btn btn-sm btn-info" title="Consultar ticket"><i class="fa-solid fa-magnifying-glass lupa"></i></a>
                                                    <a href="<?= BASE_URL ?>/asistente/actualizar-ticket?id=<?= $ticket['id'] ?>" class="btn btn-sm btn-success" title="Editar ticket"><i class="fa-solid fa-pen-to-square editar"></i></a>
                                                    <a href="<?= BASE_URL ?>/asistente/cerrar-ticket?id=<?= $ticket['id'] ?>&accion=cerrar" class="btn btn-sm btn-danger" title="Cerrar ticket"><i class="fa-solid fa-x"></i></a>
                                                    <?php elseif($ticket['estado'] === 'RESPONDIDO'):?>
                                                        <a href="<?= BASE_URL ?>/asistente/consultar-ticket?id=<?= $ticket['id'] ?>" class="btn btn-sm btn-info" title="Consultar ticket"><i class="fa-solid fa-magnifying-glass lupa"></i></a>
                                                        <a href="<?= BASE_URL ?>/asistente/cerrar-ticket?id=<?= $ticket['id'] ?>&accion=cerrar" class="btn btn-sm btn-danger" title="Cerrar ticket"><i class="fa-solid fa-x"></i></a>
                                                    <?php else:?>
                                                        <span class="text-muted small">No hay acciones disponibles</span>
                                                    <?php endif;?>
                                                </td>
                                            </tr>
                                            <?php endforeach;?>
                                            <?php else:?>
                                                <td>No hay tickets creados</td>
                                            <?php endif;?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php 
    include_once __DIR__ . '/../../layouts/footer_asistente.php';
?>