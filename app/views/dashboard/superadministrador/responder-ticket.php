<?php
require_once BASE_PATH . '/app/helpers/session_superadmin.php';
require_once BASE_PATH . '/app/controllers/ticketController.php';

$id = $_GET['id'];

$ticket = consultarTicketPorId($id);

?>

<!-- AQUI VA EL INCLUDE DEL HEADER -->
<?php
include_once __DIR__ . '/../../layouts/header_superadministrador.php';

?>

<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <!-- AQUI VA EL INCLUDE EL SIDEBAR -->

            <?php
            include_once __DIR__ . '/../../layouts/sidebar_superadministrador.php';
            ?>

            <!-- Main Content -->
            <div class="col-lg-10 col-md-9 main-content">
                <!-- Dashboard Section -->
                <div id="dashboardSection">
                    <!-- Top Bar -->
                    <!-- AQUI VA EL INCLUDE DEL TOP BAR -->

                    <?php
                    include_once __DIR__ . '/../../layouts/topbar_superadministrador.php';
                    ?>

                    <div class="container-fluid ticket-wrapper d-flex align-items-center justify-content-center">
                        <div class="col-lg-7 col-md-9">
                            <div class="card ticket-card p-4 bg-white">

                                <div class="text-center mb-4">
                                    <h2 class="ticket-title">Responder ticket número (<?= $ticket['id'] ?>)</h2>
                                    <p class="text-muted">Acá podrá dar una respuesta al ticket seleccionado.</p>
                                </div>

                                <form action="<?= BASE_URL ?>/superadmin/guardar-respuesta-ticket" method="POST">

                                    <input type="hidden" name="id" value="<?= $ticket['id'] ?>">
                                    <input type="hidden" name="accion" value="responder">

                                    <div class="row">
                                        <div class="mb-3 col-md-6">
                                            <label class="form-label fw-semibold">Correo del usuario</label>
                                            <input type="text" class="form-control" value="<?= $ticket['email'] ?>" disabled>
                                        </div>

                                        <div class="mb-3 col-md-6">
                                            <label class="form-label fw-semibold">Rol del usuario</label>
                                            <input type="text" class="form-control" value="<?= $ticket['rol'] ?>" disabled>
                                        </div>
                                    </div>

                                    <!-- TÍTULO -->
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Título del Ticket</label>
                                        <input type="text" class="form-control" value="<?= $ticket['titulo'] ?>" disabled>
                                    </div>

                                    <!-- DESCRIPCIÓN -->
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Descripción</label>
                                        <textarea rows="4" class="form-control" disabled><?= $ticket['descripcion'] ?></textarea>
                                    </div>

                                    <!-- RESPUESTA -->
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Respuesta</label>
                                        <textarea name="respuesta" rows="4" class="form-control" placeholder="Escriba aquí la respuesta al ticket..."></textarea>
                                    </div>

                                    <!-- BOTONES -->
                                    <div class="d-flex justify-content-between">
                                        <a href="<?= BASE_URL ?>/superadmin/tickets-usuarios" class="btn btn-outline-secondary btn-custom">
                                            ← Regresar
                                        </a>

                                        <button type="submit" class="btn btn-primary btn-custom">
                                            Responder Ticket
                                        </button>
                                    </div>

                                </form>

                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- AQUI VA EL FOOTER INCLUDE -->

    <?php
    include_once __DIR__ . '/../../layouts/footer_superadministrador.php';
    ?>