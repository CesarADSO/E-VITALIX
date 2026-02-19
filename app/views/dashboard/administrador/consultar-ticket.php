<?php
require_once BASE_PATH . '/app/helpers/session_administrador.php';
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
                                    <h2 class="ticket-title">Ticket Número ()</h2>
                                    <p class="text-muted">Este espacio está destinado para consultar si su ticket de soporte ya fue respondido por el super administrador.</p>
                                </div>

                                <form>

                                    <!-- TÍTULO -->
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Título del Ticket</label>
                                        <input type="text" class="form-control" disabled>
                                    </div>

                                    <!-- DESCRIPCIÓN -->
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Descripción</label>
                                        <textarea rows="4" class="form-control"
                                            disabled></textarea>
                                    </div>

                                    <!-- DESCRIPCIÓN -->
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Respuesta</label>
                                        <textarea rows="4" class="form-control"
                                            disabled></textarea>
                                    </div>

                                    <!-- BOTONES -->

                                        <a href="<?= BASE_URL ?>/admin/cerrar-ticket" class="btn btn-primary btn-custom">Cerrar Ticket</a>
                                </form>

                            </div>

                        </div>
                    </div>
                </div>



            </div>


        </div>
    </div>