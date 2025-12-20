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

                <!-- Servicios Section -->
                <div id="serviciosSection">
                    <!-- Top Bar -->
                    <?php
                    include_once __DIR__ . '/../../layouts/topbar_administrador.php';
                    ?>

                    <!-- Asistentes Header -->
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <button class="btn btn-link text-primary p-0"
                                style="text-decoration: none; font-size: 14px;">
                                ← Todos (0)
                            </button>
                        </div>
                        <a href="<?= BASE_URL ?>/admin/servicios" class="btn btn-primary btn-sm" style="border-radius: 20px;"><i class="bi bi-arrow-left"></i> VOLVER</a>
                    </div>

                    <!-- Formulario de modificación de Servicios -->
                    <div class="bg-white rounded shadow-sm p-4">
                        <h4 class="mb-4">Actualizar Servicio</h4>
                        <p class="text-muted mb-4 texto">Actualiza la información del servicio médico seleccionado</p>


                        <form id="servicioForm" action="<?= BASE_URL ?>/admin/guardar-cambios-servicio" method="POST">

                            <!-- Descripción -->
                            <div class="mb-3">
                                <label for="descripcion" class="form-label">Descripción</label>
                                <textarea class="form-control" id="descripcion" name="descripcion"
                                    rows="3" placeholder="Descripción detallada del servicio"></textarea>
                            </div>

                            <div class="row">
                                <!-- Duración en Minutos -->
                                <div class="col-md-6 mb-3">
                                    <label for="duracion_minutos" class="form-label">Duración (Minutos)</label>
                                    <select class="form-select" id="duracion_minutos" name="duracion_minutos" required>
                                        <option value="">Seleccionar duración</option>
                                        <option value="15">15 minutos</option>
                                        <option value="30">30 minutos</option>
                                        <option value="45">45 minutos</option>
                                        <option value="60">60 minutos</option>
                                        <option value="90">90 minutos</option>
                                        <option value="120">120 minutos</option>
                                    </select>
                                </div>

                                <!-- Precio -->
                                <div class="col-md-6 mb-3">
                                    <label for="precio" class="form-label">Precio ($)</label>
                                    <input type="number" class="form-control" id="precio" name="precio"
                                        placeholder="0.00" step="0.01" min="0">
                                    <div class="form-text">Precio del servicio en pesos colombianos</div>
                                </div>
                            </div>

                            <div class="row">
                                <!-- Método de Pago -->
                                <div class="col-md-6 mb-3">
                                    <label for="id_metodo_pago" class="form-label">Método de Pago</label>
                                    <select class="form-select" id="id_metodo_pago" name="id_metodo_pago" required>
                                        <option value="">Seleccionar método de pago</option>
                                        <!-- Métodos de pago desde BD -->
                                    </select>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="estado" class="form-label">Estado</label>
                                    <select class="form-select" id="estado" name="estado" required>
                                        <option value="activo">Activo</option>
                                        <option value="inactivo">Inactivo</option>
                                    </select>
                                </div>
                            </div>


                            <div class="d-flex justify-content-between">
                                <a href="<?= BASE_URL ?>/admin/servicios" class="btn btn-outline-secondary">Cancelar</a>
                                <button type="submit" class="btn boton">Registrar Servicio</button>
                            </div>
                    </div>
                    </form>
                </div>


            </div>
        </div>
    </div>
    </div>
    </div>

    <?php
    include_once __DIR__ . '/../../layouts/footer_administrador.php';
    ?>