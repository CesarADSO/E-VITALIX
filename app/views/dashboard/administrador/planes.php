<?php
include_once __DIR__ . '/../../layouts/header_administrador.php';
require_once BASE_PATH . '/app/helpers/session_administrador.php';
require_once BASE_PATH . '/app/controllers/planesController.php';

$plan = traerId();
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
                <div class="seccion-planes">
                    <!-- Header de la sección -->
                    <!-- <div class="encabezado-planes" data-aos="fade-up" data-aos-duration="800">
                        <span class="etiqueta-superior">Planes de Suscripción</span>
                        <h1 class="titulo-principal-planes">
                            Elige el plan perfecto para tu consultorio
                        </h1>
                        <p class="descripcion-planes">
                            Gestiona tu equipo médico con planes flexibles diseñados para consultorios de todos los tamaños.
                            Sin contratos a largo plazo, cancela cuando quieras.
                        </p>
                    </div>

                    <div class="selector-periodo" data-aos="fade-up" data-aos-duration="800" data-aos-delay="100">
                        <div class="contenedor-selector">
                            <button class="boton-periodo activo" data-periodo="mensual">
                                Mensual
                            </button>
                        </div>
                    </div> -->

                    <!-- Grid de planes -->
                    <div class="row grid-planes">

                        <!-- Plan Gratuito -->
                        <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up" data-aos-duration="800" data-aos-delay="200">
                            <article class="tarjeta-plan plan-gratuito">

                                <!-- Header del plan -->
                                <div class="encabezado-plan">
                                    <div class="icono-plan">
                                        <i class="bi bi-gift-fill"></i>
                                    </div>
                                    <h3 class="nombre-plan">Plan semilla (gratuito)</h3>
                                    <p class="descripcion-plan">
                                        Perfecto para comenzar y probar la plataforma
                                    </p>
                                </div>

                                <!-- Precio -->
                                <div class="contenedor-precio">
                                    <div class="precio-principal">
                                        <span class="simbolo-moneda">$</span>
                                        <span class="numero-precio" data-precio-mensual="0" data-precio-anual="0">0</span>
                                        <span class="periodo-precio">/mes</span>
                                    </div>
                                    <p class="texto-precio-anual">Gratis para siempre</p>
                                </div>

                                <!-- Característica destacada -->
                                <div class="caracteristica-destacada">
                                    <i class="bi bi-people-fill"></i>
                                    <div class="info-destacada">
                                        <span class="numero-destacado">30</span>
                                        <span class="texto-destacado">Citas al mes</span>
                                    </div>
                                </div>

                                <!-- Lista de características -->
                                <ul class="lista-caracteristicas">
                                    <li class="item-caracteristica">
                                        <i class="bi bi-check-circle-fill icono-check"></i>
                                        <span>Hasta 30 citas agendadas en tu consultorio al mes</span>
                                    </li>
                                </ul>

                                <!-- Botón de acción -->
                                <div class="contenedor-boton">
                                    <span class="boton-plan boton-gratuito">Este es tu plan actual</span>
                                </div>

                            </article>
                        </div>

                        <!-- Plan Básico -->
                        <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up" data-aos-duration="800" data-aos-delay="300">
                            <article class="tarjeta-plan plan-basico plan-destacado">

                                <!-- Badge de popular
                            <div class="insignia-popular">
                                <i class="bi bi-star-fill"></i>
                                Más popular
                            </div> -->

                                <!-- Header del plan -->
                                <div class="encabezado-plan">
                                    <div class="icono-plan">
                                        <i class="bi bi-rocket-takeoff-fill"></i>
                                    </div>
                                    <h3 class="nombre-plan">Plan profesional</h3>
                                    <p class="descripcion-plan">
                                        Ideal para consultorios en crecimiento
                                    </p>
                                </div>

                                <!-- Precio -->
                                <div class="contenedor-precio">
                                    <div class="precio-principal">
                                        <span class="simbolo-moneda">$</span>
                                        <span class="numero-precio" data-precio-mensual="49"
                                            data-precio-anual="39">49</span>
                                        <span class="periodo-precio">/mes</span>
                                    </div>
                                </div>

                                <!-- Característica destacada -->
                                <div class="caracteristica-destacada">
                                    <i class="bi bi-people-fill"></i>
                                    <div class="info-destacada">
                                        <span class="numero-destacado">300</span>
                                        <span class="texto-destacado">Citas al mes</span>
                                    </div>
                                </div>

                                <!-- Lista de características -->
                                <ul class="lista-caracteristicas">
                                    <li class="item-caracteristica">
                                        <i class="bi bi-check-circle-fill icono-check"></i>
                                        <span>Hasta 300 citas al mes agendadas en tu consultorio</span>
                                    </li>
                                </ul>

                                <!-- Botón de acción -->
                                <div class="contenedor-boton">
                                    <a href="<?= BASE_URL ?>/admin/confirmar-compra?id_plan<?= $plan[0]['id'] ?>" class="boton-plan boton-basico">
                                        Elegir Plan profesional
                                        <i class="bi bi-arrow-right"></i>
                                    </a>
                                </div>

                            </article>
                        </div>

                        <!-- Plan Premium -->
                        <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up" data-aos-duration="800" data-aos-delay="400">
                            <article class="tarjeta-plan plan-premium">

                                <!-- Header del plan -->
                                <div class="encabezado-plan">
                                    <div class="icono-plan">
                                        <i class="bi bi-gem"></i>
                                    </div>
                                    <h3 class="nombre-plan">Plan élite</h3>
                                    <p class="descripcion-plan">
                                        Para grandes redes de consultorios médicos
                                    </p>
                                </div>

                                <!-- Precio -->
                                <div class="contenedor-precio">
                                    <div class="precio-principal">
                                        <span class="simbolo-moneda">$</span>
                                        <span class="numero-precio" data-precio-mensual="99"
                                            data-precio-anual="79">99</span>
                                        <span class="periodo-precio">/mes</span>
                                    </div>
                                    <p class="texto-precio-anual">
                                        <span class="precio-anual-mostrar">$948 al año</span>
                                    </p>
                                </div>

                                <!-- Característica destacada -->
                                <div class="caracteristica-destacada">
                                    <i class="bi bi-people-fill"></i>
                                    <div class="info-destacada">
                                        <span class="numero-destacado">3.000</span>
                                        <span class="texto-destacado">Citas al mes</span>
                                    </div>
                                </div>

                                <!-- Lista de características -->
                                <ul class="lista-caracteristicas">
                                    <li class="item-caracteristica">
                                        <i class="bi bi-check-circle-fill icono-check"></i>
                                        <span>Hasta 3.000 citas al mes agendadas en tu consultorio</span>
                                    </li>
                                </ul>

                                <!-- Botón de acción -->
                                <div class="contenedor-boton">
                                    <a href="<?= BASE_URL ?>/admin/confirmar-compra?id_plan=<?= $plan[1]['id'] ?>" class="boton-plan boton-premium">
                                        Elegir plan élite
                                        <i class="bi bi-arrow-right"></i>
                                    </a>
                                </div>

                            </article>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
<?php include_once __DIR__ . '/../../layouts/footer_administrador.php'; ?>
    <!-- <section class="seccion-planes">
        <div class="container">



            <!-- Sección de garantía
                <div class="seccion-garantia" data-aos="fade-up" data-aos-duration="800" data-aos-delay="500">
                    <div class="contenedor-garantia">
                        <div class="icono-garantia">
                            <i class="bi bi-shield-fill-check"></i>
                        </div>
                        <div class="texto-garantia">
                            <h4 class="titulo-garantia">Garantía de 30 días</h4>
                            <p class="descripcion-garantia">
                                Si no estás satisfecho con nuestro servicio, te devolvemos tu dinero sin preguntas.
                                Prueba e-Vitalix sin riesgo.
                            </p>
                        </div>
                    </div>
                </div> -->

            <!-- Sección de preguntas frecuentes -->
            <!-- <div class="seccion-faq" data-aos="fade-up" data-aos-duration="800" data-aos-delay="600">
                <h2 class="titulo-faq">Preguntas Frecuentes</h2>

                <div class="accordion accordion-flush acordeon-personalizado" id="accordionPreguntas">

                    <!-- Pregunta 1 -->
                    <!-- <div class="accordion-item item-pregunta">


                        <h3 class="accordion-header">
                            <button class="accordion-button boton-pregunta collapsed" type="button"
                                data-bs-toggle="collapse" data-bs-target="#pregunta1">
                                <i class="bi bi-question-circle-fill icono-pregunta"></i>
                                ¿Puedo cambiar de plan en cualquier momento?
                            </button>
                        </h3>
                        <div id="pregunta1" class="accordion-collapse collapse"
                            data-bs-parent="#accordionPreguntas">
                            <div class="accordion-body cuerpo-respuesta">
                                Sí, puedes actualizar o cambiar tu plan en cualquier momento desde tu panel de
                                administración.
                                Los cambios se reflejan de inmediato y el costo se prorratea según tu ciclo de
                                facturación.
                            </div>
                        </div>
                    </div>

                    Pregunta 2
                    <div class="accordion-item item-pregunta">
                        <h3 class="accordion-header">
                            <button class="accordion-button boton-pregunta collapsed" type="button"
                                data-bs-toggle="collapse" data-bs-target="#pregunta2">
                                <i class="bi bi-question-circle-fill icono-pregunta"></i>
                                ¿Qué sucede si supero el límite de especialistas?
                            </button>
                        </h3>
                        <div id="pregunta2" class="accordion-collapse collapse"
                            data-bs-parent="#accordionPreguntas">
                            <div class="accordion-body cuerpo-respuesta">
                                Si llegas al límite de especialistas que tu plan te permite registrar entonces simplemente tendrás que actualizar a un plan superior para poder seguir registrando los especialistas que tengas trabajando en tu consultorio.
                            </div>
                        </div>
                    </div>

                    Pregunta 4
                    <div class="accordion-item item-pregunta">
                        <h3 class="accordion-header">
                            <button class="accordion-button boton-pregunta collapsed" type="button"
                                data-bs-toggle="collapse" data-bs-target="#pregunta4">
                                <i class="bi bi-question-circle-fill icono-pregunta"></i>
                                ¿Cómo funciona el plan gratuito?
                            </button>
                        </h3>
                        <div id="pregunta4" class="accordion-collapse collapse"
                            data-bs-parent="#accordionPreguntas">
                            <div class="accordion-body cuerpo-respuesta">
                                El plan gratuito es completamente funcional y no requiere tarjeta de crédito.
                                Puedes gestionar hasta 10 especialistas de forma ilimitada. Es perfecto para
                                consultorios pequeños o para probar la plataforma antes de comprometerte con un plan
                                de pago.
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- CTA Final
                <div class="seccion-cta-final" data-aos="fade-up" data-aos-duration="800" data-aos-delay="700">
                    <div class="contenedor-cta-final">
                        <h2 class="titulo-cta-final">¿Necesitas más de 1,000 especialistas?</h2>
                        <p class="descripcion-cta-final">
                            Contáctanos para planes empresariales personalizados con soporte dedicado y características
                            a medida.
                        </p>
                        <a href="contacto" class="boton-cta-final">
                            <i class="bi bi-envelope-fill"></i>
                            Contactar al equipo de ventas
                        </a>
                    </div>
                </div> -->

        <!-- </div>
    </section>
    </main>
    <footer data-aos="fade-up" data-aos-duration="1000">
        <div class="container">
            <div class="row">
                <div class="col-md-3 cont-info">
                    <a href="/E-VITALIX/"><img src="public/assets/website/img/LOGO NEGATIVO 1.svg"
                            alt="Logo negativo"></a>
                    <p class="descriptivo">Liderando el camino en
                        excelencia médica
                        y atención confiable</p>
                </div>
                <div class="col-md-3 cont-enlaces">
                    <h5>Otros Links</h5>
                    <a href="/E-VITALIX/">Inicio</a>
                    <a href="doctores">Doctores</a>
                    <a href="servicios">Servicios</a>
                    <a href="sobreNosotros">Sobre Nosotros</a>
                </div>
                <div class="col-md-3 cont-info">
                    <h5 class="titulo-contacto">Contactanos</h5>
                    <p class="contacto">Llama: 3219219323</p>
                    <p class="contacto">Email: evitalix@gmail.com</p>
                    <p class="contacto">Dirección: SENA VILLETA</p>
                    <p class="contacto">Villeta - Cundinamarca</p>
                </div>
                <div class="col-md-3 cont-info">
                    <h5 class="hoja-informativa">Hoja informativa</h5>
                    <form action="" method="post">
                        <input type="email" name="email" placeholder="Introduce tu correo">
                        <button type="submit" class="btn-enviar">
                            <i class="bi bi-send-fill"></i>
                        </button>
                    </form>
                </div>
            </div>
            <hr>
            <div class="row fila">
                <div class="col-md-10">
                    <p class="derechos">© 2025 E-VITALIX Todos los Derechos Reservados by PNTEC-LTD</p>
                </div>
                <div class="col-md-2 cont-redes d-flex gap-3">
                    <a href="#"><img src="public/assets/website/img/linkedin blanco.svg" alt="Linkedin"></a>
                    <a href="#"><img src="public/assets/website/img/facebook circulo.svg" alt=""></a>
                    <a href="#"><img src="public/assets/website/img/instagram blanco.svg" alt="Instagram"></a>
                </div>
            </div>
        </div>
    </footer>


    AOS JS
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <!-- Swiper JS -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <!-- Boostrap Js -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script> -->
    <!-- <script src="public/assets/website/js/main.js"></script>
</body>

</html>   -->