<?php
    require_once BASE_PATH . '/app/helpers/session_administrador.php';
   

?>

<!-- AQUI VA EL INCLUDE DEL HEADER -->
<?php
include_once __DIR__ . '/../../layouts/header_administrador.php';

?>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <!-- AQUI VA EL INCLUDE EL SIDEBAR -->

            <?php
            include_once __DIR__ . '/../../layouts/sidebar_administrador.php';
            ?>

            <!-- Main Content -->
            <div class="col-lg-10 col-md-9 main-content">
                <!-- Dashboard Section -->
                <div id="dashboardSection">
                    <!-- Top Bar -->
                    <!-- AQUI VA EL INCLUDE DEL TOP BAR -->

                    <?php
                    include_once __DIR__ . '/../../layouts/topbar_administrador.php';
                    ?>

                    <div class="container-fluid ticket-wrapper d-flex align-items-center justify-content-center">
                        <div class="col-lg-7 col-md-9">
                             <div class="card ticket-card p-4 bg-white">

                                <div class="text-center mb-4">
                                    <h2 class="ticket-title">🎫 Soporte E-VITALIX</h2>
                                    <p class="text-muted">Este espacio está destinado para reportar errores, fallas o inconvenientes relacionados con el funcionamiento del aplicativo. Envíanos tu inconveniente y nuestro equipo lo solucionará pronto..</p>
                                </div>

                                <form action="<?= BASE_URL ?>/admin/guardar-ticket" method="POST" enctype="multipart/form-data">

                                    <!-- TÍTULO -->
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Título del Ticket</label>
                                        <input type="text" name="titulo" class="form-control" placeholder="Ej: Error al iniciar sesión" required>
                                    </div>

                                    <!-- DESCRIPCIÓN -->
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Descripción</label>
                                        <textarea name="descripcion" rows="4" class="form-control"
                                            placeholder="Describe detalladamente el problema..." required></textarea>
                                    </div>

                                    <!-- IMAGEN -->
                                    <div class="mb-4">
                                        <label class="form-label fw-semibold">Adjuntar Imagen (opcional)</label>
                                        <input type="file" name="foto" class="form-control" accept=".jpg, .png, .jpeg">
                                    </div>

                                    <!-- BOTONES -->
                                    <div class="d-flex justify-content-between">
                                        <a href="<?= BASE_URL ?>/admin/mis-tickets" class="btn btn-outline-secondary btn-custom">
                                            ← Regresar
                                        </a>

                                        <button type="submit" class="btn btn-primary btn-custom">
                                            Enviar Ticket
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
include_once __DIR__ . '/../../layouts/footer_administrador.php';
?>


