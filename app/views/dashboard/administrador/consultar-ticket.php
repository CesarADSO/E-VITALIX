<?php
require_once BASE_PATH . '/app/helpers/session_administrador.php';
require_once BASE_PATH . '/app/controllers/ticketController.php';

// EN UNA VARIABLE ID GUARDAMOS LA VARIABLE QUE VIENE POR METHOD GET DESDE LA TABLA DE MIS TICKETS
$id = $_GET['id'];

// EN OTRA VARIABLE TRAEMOS LA FUNCIÓN DEL CONTROLADOR QUE VA A LLENAR LOS DATOS
$ticket = consultarTicketPorId($id);
?>

<?php
include_once __DIR__ . '/../../layouts/header_administrador.php';
?>


<body>
    <div class="container-fluid">
        <div class="row">

            <!-- SIDEBAR -->
            <?php
            include_once __DIR__ . '/../../layouts/sidebar_administrador.php';
            ?>

            <div class="col-lg-10 col-md-9 main-content">

                <div class="ticketsSection">
                    <!-- TOP BAR -->
                    <?php
                    include_once __DIR__ . '/../../layouts/topbar_administrador.php';
                    ?>

                    <div class="container-fluid ticket-wrapper d-flex align-items-center justify-content-center">
                        <div class="col-lg-7 col-md-9">
                            <div class="card ticket-card p-4 bg-white">

                                <div class="text-center mb-4">
                                    <h2 class="ticket-title">Ticket Número (<?= $ticket['id'] ?>)</h2>
                                    <p class="text-muted">Este espacio está destinado para consultar si su ticket de soporte ya fue respondido por el super administrador.</p>
                                </div>

                                <form>

                                    <!-- TÍTULO -->
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Título</label>
                                        <input type="text" class="form-control" value="<?= $ticket['titulo'] ?>" disabled>
                                    </div>

                                    <!-- DESCRIPCIÓN -->
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Descripción</label>
                                        <textarea rows="4" class="form-control"
                                            disabled><?= $ticket['descripcion'] ?></textarea>
                                    </div>

                                    <!-- DESCRIPCIÓN -->
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Respuesta</label>
                                        <textarea rows="4" class="form-control"
                                            disabled><?= $ticket['respuesta'] ?></textarea>
                                    </div>

                                    <!-- BOTONES -->

                                        <a href="<?= BASE_URL ?>/admin/cerrar-ticket?id=<?= $ticket['id'] ?>&accion=cerrar" class="btn btn-primary btn-custom">Cerrar Ticket</a>
                                </form>

                            </div>

                        </div>
                    </div>
                </div>



            </div>


        </div>
    </div>