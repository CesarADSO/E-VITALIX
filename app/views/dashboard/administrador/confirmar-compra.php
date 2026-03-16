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

                <!-- resumen Section -->
                <div class="contenedor-resumen">
                    <!-- Breadcrumb de pasos -->
                    <div class="breadcrumb-personalizado">
                        <div class="pasos-progreso">
                            <div class="paso-item completado">
                                <div class="numero-paso">
                                    <i class="bi bi-check-lg"></i>
                                </div>
                                <span class="texto-paso d-none d-md-inline">Seleccionar Plan</span>
                            </div>
                            <div class="separador-paso"></div>
                            <div class="paso-item activo">
                                <div class="numero-paso">2</div>
                                <span class="texto-paso d-none d-md-inline">Revisar Pedido</span>
                            </div>
                            <div class="separador-paso"></div>
                            <div class="paso-item">
                                <div class="numero-paso">3</div>
                                <span class="texto-paso d-none d-md-inline">Pago</span>
                            </div>
                        </div>
                    </div>

                    <!-- Card de resumen -->
                    <div class="card-resumen">

                        <!-- Header -->
                        <div class="header-resumen">
                            <div class="icono-resumen">
                                <i class="bi bi-clipboard-check-fill"></i>
                            </div>
                            <h1 class="titulo-resumen">Resumen de tu Plan</h1>
                            <p class="subtitulo-resumen">Revisa los detalles antes de proceder al pago</p>
                        </div>

                        <!-- Información del plan seleccionado -->
                        <div class="seccion-plan">
                            <span class="badge-plan-seleccionado">
                                <i class="bi bi-star-fill"></i> Plan Seleccionado
                            </span>

                            <h2 class="nombre-plan-seleccionado">
                                <div class="icono-plan-nombre">
                                    <i class="bi bi-rocket-takeoff-fill"></i>
                                </div>
                                Plan Básico
                            </h2>

                            <p class="descripcion-plan-seleccionado">
                                Ideal para consultorios en crecimiento. Gestiona hasta 100 especialistas
                                con todas las herramientas necesarias para optimizar tu consultorio médico.
                            </p>

                            <!-- Características incluidas -->
                            <div class="caracteristicas-incluidas">
                                <h3 class="titulo-caracteristicas">
                                    <i class="bi bi-check-circle-fill"></i>
                                    Lo que incluye este plan
                                </h3>
                                <ul class="lista-incluye">
                                    <li class="item-incluye">
                                        <i class="bi bi-check-circle-fill icono-check-verde"></i>
                                        <span class="texto-incluye">Hasta 100 especialistas registrados</span>
                                    </li>
                                    <li class="item-incluye">
                                        <i class="bi bi-check-circle-fill icono-check-verde"></i>
                                        <span class="texto-incluye">Gestión avanzada de citas médicas</span>
                                    </li>
                                    <li class="item-incluye">
                                        <i class="bi bi-check-circle-fill icono-check-verde"></i>
                                        <span class="texto-incluye">Historial clínico digital completo</span>
                                    </li>
                                    <li class="item-incluye">
                                        <i class="bi bi-check-circle-fill icono-check-verde"></i>
                                        <span class="texto-incluye">Soporte prioritario 24/7</span>
                                    </li>
                                    <li class="item-incluye">
                                        <i class="bi bi-check-circle-fill icono-check-verde"></i>
                                        <span class="texto-incluye">Reportes y analíticas avanzadas</span>
                                    </li>
                                    <li class="item-incluye">
                                        <i class="bi bi-check-circle-fill icono-check-verde"></i>
                                        <span class="texto-incluye">Recordatorios automáticos por SMS</span>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <!-- Selector de período -->
                        <div class="seccion-periodo">
                            <h3 class="titulo-seccion">
                                <i class="bi bi-calendar-range"></i>
                                Elige tu período de facturación
                            </h3>

                            <div class="opciones-periodo">
                                <!-- Opción Mensual -->
                                <div class="opcion-periodo">
                                    <input type="radio" name="periodo" id="mensual" value="mensual" checked>
                                    <label for="mensual" class="label-periodo">
                                        <span class="nombre-periodo">Mensual</span>
                                        <span class="precio-periodo">
                                            $49 <small>/mes</small>
                                        </span>
                                    </label>
                                </div>

                                <!-- Opción Anual -->
                                <div class="opcion-periodo">
                                    <span class="badge-ahorro">Ahorra 20%</span>
                                    <input type="radio" name="periodo" id="anual" value="anual">
                                    <label for="anual" class="label-periodo">
                                        <span class="nombre-periodo">Anual</span>
                                        <span class="precio-periodo">
                                            $39 <small>/mes</small>
                                        </span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Resumen de costos -->
                        <div class="seccion-costos">
                            <h3 class="titulo-seccion">Desglose de costos</h3>

                            <div class="fila-costo">
                                <span class="label-costo">Subtotal (Plan Básico - Mensual)</span>
                                <span class="valor-costo" id="subtotal">$49.00</span>
                            </div>

                            <div class="fila-costo fila-descuento" style="display: none;" id="fila-descuento">
                                <span class="label-costo">Descuento (20% pago anual)</span>
                                <span class="valor-costo" id="descuento">-$0.00</span>
                            </div>

                            <div class="fila-costo">
                                <span class="label-costo">IVA (19%)</span>
                                <span class="valor-costo" id="iva">$9.31</span>
                            </div>

                            <div class="fila-costo fila-total">
                                <span class="label-costo">Total a pagar</span>
                                <span class="valor-costo" id="total">$58.31</span>
                            </div>
                        </div>

                        <!-- Información adicional -->
                        <div class="seccion-info-adicional">
                            <div class="caja-info">
                                <i class="bi bi-shield-fill-check icono-info"></i>
                                <div class="texto-info">
                                    <h6>Garantía de 30 días</h6>
                                    <p>Si no estás satisfecho, te devolvemos tu dinero sin hacer preguntas.</p>
                                </div>
                            </div>

                            <div class="caja-info">
                                <i class="bi bi-credit-card-fill icono-info"></i>
                                <div class="texto-info">
                                    <h6>Pago seguro</h6>
                                    <p>Tus datos están protegidos con encriptación de nivel bancario SSL.</p>
                                </div>
                            </div>

                            <div class="caja-info">
                                <i class="bi bi-arrow-repeat icono-info"></i>
                                <div class="texto-info">
                                    <h6>Renovación automática</h6>
                                    <p>Tu plan se renovará automáticamente. Puedes cancelar en cualquier momento.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Botones de acción -->
                        <div class="seccion-acciones">
                            <a href="pasarela-pago.php" class="boton-proceder-pago">
                                <i class="bi bi-lock-fill"></i>
                                Proceder al Pago Seguro
                            </a>

                            <br>

                            <a href="planes.php" class="boton-volver">
                                <i class="bi bi-arrow-left"></i>
                                Volver a planes
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
    include_once __DIR__ . '/../../layouts/footer_administrador.php';
    ?>