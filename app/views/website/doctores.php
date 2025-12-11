<?php
    require_once BASE_PATH . '/app/controllers/especialistaController.php';


    $datos = mostrarEspecialistas();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctores</title>
    <!-- AOS CSS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Bootstrap Icons CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <!-- Boostrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <!-- MI CSS -->
    <link rel="stylesheet" href="public/assets/website/css/styles.css">
    <link rel="stylesheet" href="public/assets/website/css/doctores.css">
</head>

<body>
    <header>
        <div class="container contenedor">
            <div class="row fila">
                <div class="col-md-3 cont-img">
                    <a href="/E-VITALIX/"><img src="public/assets/website/img/LOGO-PRINCIPAL 2.svg" alt="Logo E-VITALIX"></a>
                </div>
                <div class="col-md-3 col-info">
                    <i class="bi bi-telephone-outbound"></i>
                    <p>EMERGENCIA <br><span>(237) 681-812-255</span></p>
                </div>
                <div class="col-md-3 col-info">
                    <i class="bi bi-clock"></i>
                    <p>HORARIO DE TRABAJO <br><span>09:00-20:00 Todos los días</span></p>
                </div>
                <div class="col-md-3 col-info">
                    <i class="bi bi-geo-alt"></i>
                    <p>UBICACIÓN <br><span>SENA VILLETA</span></p>
                </div>
            </div>
        </div>
        <nav class="navbar navbar-expand-lg barra-navegacion">
            <div class="container">
                <a class="navbar-brand" href="/E-VITALIX/"><img src="public/assets/website/img/LOGO NEGATIVO 1.svg" alt=""></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse items-menu" id="navbarNav">
                    <ul class="navbar-nav lista-items">
                        <li class="nav-item item-menu">
                            <a class="nav-link" aria-current="page" href="/E-VITALIX/">Inicio</a>
                        </li>
                        <li class="nav-item item-menu">
                            <a class="nav-link" href="sobreNosotros">Sobre Nosotros</a>
                        </li>
                        <li class="nav-item item-menu">
                            <a class="nav-link" href="servicios">Servicios</a>
                        </li>
                        <li class="nav-item item-menu">
                            <a class="nav-link" href="doctores">Doctores</a>
                        </li>
                        <li class="nav-item item-menu">
                            <a class="nav-link" href="noticias">Noticias</a>
                        </li>
                        <li class="nav-item item-menu">
                            <a class="nav-link" href="contacto">Contacto</a>
                        </li>
                    </ul>
                    <ul class="navbar-nav ingresar">
                    <li class="nav-item item-ingresar">
                        <a class="nav-link" aria-current="page" href="login">Ingresar</a>
                    </li>
                    <li class="nav-item item-registrar">
                        <a class="nav-link" href="registro">Registrarse</a>
                    </li>
                </ul>
                </div>
            </div>
        </nav>
        <div id="hero" data-aos="fade-down" data-aos-duration="1000">
            <img src="public/assets/website/img/equipo de doctores.svg" alt="imagen de fondo" class="fondo-hero">
            <img src="public/assets/website/img/rectangulo del hero del about us.svg" alt=""
                class="rectangulo rectangulo-1">
            <img src="public/assets/website/img/rectangulo about us azul clarito.svg" alt=""
                class="rectangulo rectangulo-2">
            <img src="public/assets/website/img/Ellipse 2.svg" alt="elipse 2" class="elipse elipse-izquierda">
            <img src="public/assets/website/img/Ellipse 1.svg" alt="elipse 1" class="elipse elipse-derecha">
            <div class="container contenido">
                <div class="row fila">
                    <div class="col-md-6 cont-info">
                        <h3>Inicio / Doctores</h3>
                        <h1>Nuestros Doctores</h1>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <main>
        <section id="equipo">
            <div class="container">
                <div class="row fila">
                    <?php if(!empty($datos)):?>
                        <?php foreach ($datos as $especialista):?>
                    <div class="col-md-4" data-aos="flip-left" data-aos-duration="800" data-aos-delay="100">
                        <div class="card tarjeta" style="width: 18rem;">
                            <img src="<?= BASE_URL ?>/public/uploads/usuarios/<?= $especialista['foto'] ?>" class="card-img-top" alt="Nicolas">
                            <div class="card-body cuerpo-tarjeta">
                                <h5 class="card-title"><?= $especialista['nombres'] ?> <?= $especialista['apellidos'] ?></h5>
                                <p class="card-text"><?= $especialista['especialidad'] ?></p>
                                <div class="redes">
                                    <a class="social" href="#"><img class="social" src="public/assets/website/img/Linkedin.svg"
                                            alt="Linkedin"></a>
                                    <a class="social" href="#"><img class="social" src="public/assets/website/img/face.svg"
                                            alt="Facebook"></a>
                                    <a class="social" href="#"><img class="social" src="public/assets/website/img/insta.svg"
                                            alt="Instagram"></a>
                                </div>
                            </div>
                            <a class="perfil" href="#">Ver perfil</a>
                        </div>
                    </div>
                    <?php endforeach; ?>
                    <?php else: ?>
                        <p>No hay especialistas registrados.</p>
                    <?php endif; ?>
                    <!-- <div class="col-md-4" data-aos="flip-left" data-aos-duration="800" data-aos-delay="200">
                        <div class="card tarjeta" style="width: 18rem;">
                            <img src="public/assets/website/img/doctor 2.svg" class="card-img-top" alt="César">
                            <div class="card-body cuerpo-tarjeta">
                                <h5 class="card-title">Felipe Ramirez</h5>
                                <p class="card-text">NEURÓLOGO</p>
                                <div class="redes">
                                    <a class="social" href="#"><img class="social" src="public/assets/website/img/Linkedin.svg"
                                            alt="Linkedin"></a>
                                    <a class="social" href="#"><img class="social" src="public/assets/website/img/face.svg"
                                            alt="Facebook"></a>
                                    <a class="social" href="#"><img class="social" src="public/assets/website/img/insta.svg"
                                            alt="Instagram"></a>
                                </div>
                            </div>
                            <a class="perfil" href="#">Ver perfil</a>
                        </div>
                    </div>
                    <div class="col-md-4" data-aos="flip-left" data-aos-duration="800" data-aos-delay="300">
                        <div class="card tarjeta" style="width: 18rem;">
                            <img src="public/assets/website/img/doctor 3.svg" class="card-img-top" alt="Diego">
                            <div class="card-body cuerpo-tarjeta">
                                <h5 class="card-title">Felipe Ramirez</h5>
                                <p class="card-text">NEURÓLOGO</p>
                                <div class="redes">
                                    <a class="social" href="#"><img class="social" src="public/assets/website/img/Linkedin.svg"
                                            alt="Linkedin"></a>
                                    <a class="social" href="#"><img class="social" src="public/assets/website/img/face.svg"
                                            alt="Facebook"></a>
                                    <a class="social" href="#"><img class="social" src="public/assets/website/img/insta.svg"
                                            alt="Instagram"></a>
                                </div>
                            </div>
                            <a class="perfil" href="#">Ver perfil</a>
                        </div>
                    </div>
                    <div class="col-md-4" data-aos="flip-left" data-aos-duration="800" data-aos-delay="400">
                        <div class="card tarjeta" style="width: 18rem;">
                            <img src="public/assets/website/img/doctor 1.svg" class="card-img-top" alt="Diego">
                            <div class="card-body cuerpo-tarjeta">
                                <h5 class="card-title">Felipe Ramirez</h5>
                                <p class="card-text">NEURÓLOGO</p>
                                <div class="redes">
                                    <a class="social" href="#"><img class="social" src="public/assets/website/img/Linkedin.svg"
                                            alt="Linkedin"></a>
                                    <a class="social" href="#"><img class="social" src="public/assets/website/img/face.svg"
                                            alt="Facebook"></a>
                                    <a class="social" href="#"><img class="social" src="public/assets/website/img/insta.svg"
                                            alt="Instagram"></a>
                                </div>
                            </div>
                            <a class="perfil" href="#">Ver perfil</a>
                        </div>
                    </div>
                    <div class="col-md-4" data-aos="flip-left" data-aos-duration="800" data-aos-delay="500">
                        <div class="card tarjeta" style="width: 18rem;">
                            <img src="public/assets/website/img/doctor 2.svg" class="card-img-top" alt="Diego">
                            <div class="card-body cuerpo-tarjeta">
                                <h5 class="card-title">Felipe Ramirez</h5>
                                <p class="card-text">NEURÓLOGO</p>
                                <div class="redes">
                                    <a class="social" href="#"><img class="social" src="public/assets/website/img/Linkedin.svg"
                                            alt="Linkedin"></a>
                                    <a class="social" href="#"><img class="social" src="public/assets/website/img/face.svg"
                                            alt="Facebook"></a>
                                    <a class="social" href="#"><img class="social" src="public/assets/website/img/insta.svg"
                                            alt="Instagram"></a>
                                </div>
                            </div>
                            <a class="perfil" href="#">Ver perfil</a>
                        </div>
                    </div>
                    <div class="col-md-4" data-aos="flip-left" data-aos-duration="800" data-aos-delay="600">
                        <div class="card tarjeta" style="width: 18rem;">
                            <img src="public/assets/website/img/doctor 3.svg" class="card-img-top" alt="Diego">
                            <div class="card-body cuerpo-tarjeta">
                                <h5 class="card-title">Felipe Ramirez</h5>
                                <p class="card-text">NEURÓLOGO</p>
                                <div class="redes">
                                    <a class="social" href="#"><img class="social" src="public/assets/website/img/Linkedin.svg"
                                            alt="Linkedin"></a>
                                    <a class="social" href="#"><img class="social" src="public/assets/website/img/face.svg"
                                            alt="Facebook"></a>
                                    <a class="social" href="#"><img class="social" src="public/assets/website/img/insta.svg"
                                            alt="Instagram"></a>
                                </div>
                            </div>
                            <a class="perfil" href="#">Ver perfil</a>
                        </div>
                    </div> -->
                </div>
            </div>
        </section>
        <section id="motivacion" data-aos="zoom-in" data-aos-duration="1000">
            <div class="container">
                <div id="carouselFraseIndicators" class="carousel slide">
                    <div class="carousel-indicators dots">
                        <button type="button" data-bs-target="#carouselFraseIndicators" data-bs-slide-to="0"
                            class="active" aria-current="true" aria-label="Slide 1"></button>
                        <button type="button" data-bs-target="#carouselFraseIndicators" data-bs-slide-to="1"
                            aria-label="Slide 2"></button>
                        <button type="button" data-bs-target="#carouselFraseIndicators" data-bs-slide-to="2"
                            aria-label="Slide 3"></button>
                    </div>
                    <div class="carousel-inner cont-carrusel">
                        <div class="carousel-item active item">
                            <i class="fas fa-quote-right"></i>
                            <p>La salud no lo es todo, pero sin ella, todo lo demás es nada.
                                Cuidarte hoy es la mejor inversión para tu mañana. Cada paso que
                                das hacia tu bienestar es un acto de amor propio que transforma tu vida.</p>
                            <hr>
                            <h5>César Morales</h5>
                        </div>
                        <div class="carousel-item item">
                            <i class="fas fa-quote-right"></i>
                            <p>La salud no lo es todo, pero sin ella, todo lo demás es nada.
                                Cuidarte hoy es la mejor inversión para tu mañana. Cada paso que
                                das hacia tu bienestar es un acto de amor propio que transforma tu vida.</p>
                            <hr>
                            <h5>César Morales</h5>
                        </div>
                        <div class="carousel-item item">
                            <i class="fas fa-quote-right"></i>
                            <p>La salud no lo es todo, pero sin ella, todo lo demás es nada.
                                Cuidarte hoy es la mejor inversión para tu mañana. Cada paso que
                                das hacia tu bienestar es un acto de amor propio que transforma tu vida.</p>
                            <hr>
                            <h5>César Morales</h5>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section id="noticias">
            <div class="container">
                <h3 data-aos="fade-down" data-aos-duration="800">MEJOR INFORMACIÓN, MEJOR SALUD</h3>
                <h2 data-aos="fade-down" data-aos-duration="800">Noticias</h2>
                <div class="row">
                    <div class="col-md-6 cont-card" data-aos="fade-up" data-aos-duration="800" data-aos-delay="100">
                        <div class="card mb-3 car" style="max-width: 540px;">
                            <div class="row g-0">
                                <div class="col-md-4 cont-img">
                                    <img src="public/assets/website/img/foto para la noticia.svg"
                                        class="img-fluid rounded-start" alt="...">
                                </div>
                                <div class="col-md-8 info">
                                    <div class="card-body cuerpo">
                                        <h5 class="card-title title">Lunes 5 de septiembre de 2021 | El Tiempo</h5>
                                        <p class="card-text text">Nueva enfermedad descubierta:
                                            Cancer de Cuello.
                                        </p>
                                        <p class="card-text texto"><small class="text-body-secondary"><span
                                                    class="ojo"><i class="bi bi-eye me-1"></i>68</span><span
                                                    class="corazon ms-3"><i
                                                        class="bi bi-heart me-1"></i>35</span></small></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 cont-card" data-aos="fade-up" data-aos-duration="800" data-aos-delay="100">
                        <div class="card mb-3 car" style="max-width: 540px;">
                            <div class="row g-0">
                                <div class="col-md-4 cont-img">
                                    <img src="public/assets/website/img/foto para la noticia.svg"
                                        class="img-fluid rounded-start" alt="...">
                                </div>
                                <div class="col-md-8 info">
                                    <div class="card-body cuerpo">
                                        <h5 class="card-title title">Lunes 5 de septiembre de 2021 | El Tiempo</h5>
                                        <p class="card-text text">Nueva enfermedad descubierta:
                                            Cancer de Cuello.
                                        </p>
                                        <p class="card-text"><small class="text-body-secondary"><span class="ojo"><i
                                                        class="bi bi-eye me-1"></i>68</span><span
                                                    class="corazon ms-3"><i
                                                        class="bi bi-heart me-1"></i>35</span></small></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 cont-card" data-aos="fade-up" data-aos-duration="800" data-aos-delay="100">
                        <div class="card mb-3 car" style="max-width: 540px;">
                            <div class="row g-0">
                                <div class="col-md-4 cont-img">
                                    <img src="public/assets/website/img/foto para la noticia.svg"
                                        class="img-fluid rounded-start" alt="...">
                                </div>
                                <div class="col-md-8 info">
                                    <div class="card-body cuerpo">
                                        <h5 class="card-title title">Lunes 5 de septiembre de 2021 | El Tiempo</h5>
                                        <p class="card-text text">Nueva enfermedad descubierta:
                                            Cancer de Cuello.
                                        </p>
                                        <p class="card-text"><small class="text-body-secondary"><span class="ojo"><i
                                                        class="bi bi-eye me-1"></i>68</span><span
                                                    class="corazon ms-3"><i
                                                        class="bi bi-heart me-1"></i>35</span></small></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 cont-card" data-aos="fade-up" data-aos-duration="800" data-aos-delay="100">
                        <div class="card mb-3 car" style="max-width: 540px;">
                            <div class="row g-0">
                                <div class="col-md-4 cont-img">
                                    <img src="public/assets/website/img/foto para la noticia.svg"
                                        class="img-fluid rounded-start" alt="...">
                                </div>
                                <div class="col-md-8 info">
                                    <div class="card-body cuerpo">
                                        <h5 class="card-title title">Lunes 5 de septiembre de 2021 | El Tiempo</h5>
                                        <p class="card-text text">Nueva enfermedad descubierta:
                                            Cancer de Cuello.
                                        </p>
                                        <p class="card-text"><small class="text-body-secondary"><span class="ojo"><i
                                                        class="bi bi-eye me-1"></i>68</span><span
                                                    class="corazon ms-3"><i
                                                        class="bi bi-heart me-1"></i>35</span></small></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="cont-botones" data-aos="fade-up" data-aos-duration="800" data-aos-delay="500">
                    <button class="boton"></button>
                    <button class="boton active"></button>
                    <button class="boton"></button>
                </div>
            </div>
        </section>
        <section id="contacto">
            <div class="container">
                <h3 data-aos="fade-down" data-aos-duration="800">HABLEMOS</h3>
                <h2 data-aos="fade-down" data-aos-duration="800" data-aos-delay="100">Contacto</h2>
                <div class="row">
                    <div class="col-lg-3 col-md-6 cont-contacto" data-aos="flip-up" data-aos-duration="800" data-aos-delay="100">
                        <div class="card" style="width: 18rem;">
                            <div class="card-body tarjeta">
                                <i class="bi bi-telephone-outbound"></i>
                                <p class="card-text titulo">EMERGENCIA</p>
                                <p class="texto">(237) 681-812-255</p>
                                <p class="texto">(237) 666-331-894</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 cont-contacto" data-aos="flip-up" data-aos-duration="800" data-aos-delay="100">
                        <div class="card" style="width: 18rem;">
                            <div class="card-body tarjeta">
                                <i class="bi bi-geo-alt"></i>
                                <p class="card-text titulo">UBICACIÓN</p>
                                <p class="texto">SENA VILLETA</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 cont-contacto" data-aos="flip-up" data-aos-duration="800" data-aos-delay="100">
                        <div class="card" style="width: 18rem;">
                            <div class="card-body tarjeta">
                                <i class="bi bi-envelope"></i>
                                <p class="card-text titulo">EMAIL</p>
                                <p class="texto">evitalix@gmail.com</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 cont-contacto" data-aos="flip-up" data-aos-duration="800" data-aos-delay="100">
                        <div class="card" style="width: 18rem;">
                            <div class="card-body tarjeta">
                                <i class="bi bi-clock"></i>
                                <p class="card-text titulo">ATENCIÓN</p>
                                <p class="texto">Lunes-Domingo</p>
                                <p class="texto">09:00-20:00</p>
                            </div>
                        </div>
                    </div>
                </div>
        </section>
    </main>
    <footer data-aos="fade-up" data-aos-duration="1000">
        <div class="container">
            <div class="row">
                <div class="col-md-3 cont-info">
                    <a href="/E-VITALIX/"><img src="public/assets/website/img/LOGO NEGATIVO 1.svg" alt="Logo negativo"></a>
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

    <!-- AOS JS -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <!-- Boostrap Js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>
    <script src="public/assets/website/js/main.js"></script>
</body>

</html>