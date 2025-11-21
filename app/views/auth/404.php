<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Vitalix - Página no encontrada</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200..1000;1,200..1000&display=swap" rel="stylesheet">
    <!-- AOS Animation Library -->
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/auth/css/404.css">
</head>
<body>
    <!-- Header superior con información de contacto -->
    <div class="top-header" data-aos="fade-down" data-aos-duration="800">
        <div class="container">
            <div class="contact-info">
                <div class="contact-item" data-aos="fade-right" data-aos-duration="600" data-aos-delay="200">
                    <span class="contact-icon">📞</span>
                    <strong>EMERGENCIA</strong>
                    <span>+57 3214472736</span>
                </div>
                <div class="contact-item" data-aos="fade-down" data-aos-duration="600" data-aos-delay="300">
                    <span class="contact-icon">🕐</span>
                    <strong>HORARIO DE ATENCIÓN</strong>
                    <span>08:00 - 20:00 Todos los días</span>
                </div>
                <div class="contact-item" data-aos="fade-left" data-aos-duration="600" data-aos-delay="400">
                    <span class="contact-icon">📍</span>
                    <strong>UBICACIÓN</strong>
                    <span>SENA VILLETA</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Barra de navegación principal -->
    <nav class="main-navbar" data-aos="fade-down" data-aos-duration="800" data-aos-delay="200">
        <div class="container">
            <div class="navbar-content">
                <div class="logo-nav" data-aos="zoom-in" data-aos-duration="600" data-aos-delay="400">
                    <!-- Reemplaza con tu logo -->
                    <img src="<?= BASE_URL ?>/public/assets/auth/img/image-removebg-preview 1.png" alt="E-Vitalix Logo">
                </div>

                <button class="mobile-menu-toggle" onclick="toggleMenu()">
                    ☰
                </button>

                <ul class="nav-links" id="navLinks">
                    <li data-aos="fade-down" data-aos-duration="500" data-aos-delay="500">
                        <a  href="/E-VITALIX/">Inicio</a>
                    </li>
                    <li data-aos="fade-down" data-aos-duration="500" data-aos-delay="550">
                        <a  href="sobreNosotros">Sobre Nosotros</a>
                    </li>
                    <li data-aos="fade-down" data-aos-duration="500" data-aos-delay="600">
                        <a  href="servicios">Servicios</a>
                    </li>
                    <li data-aos="fade-down" data-aos-duration="500" data-aos-delay="650">
                        <a  href="doctores">Profesionales</a>
                    </li>
                    <li data-aos="fade-down" data-aos-duration="500" data-aos-delay="700">
                        <a  href="noticias">Noticias</a>
                    </li>
                    <li data-aos="fade-down" data-aos-duration="500" data-aos-delay="750">
                        <a  href="contacto">Contáctanos</a>
                    </li>
                </ul>

                <div class="nav-buttons">
                    <a href="login"  class="btn-entrar" data-aos="fade-left" data-aos-duration="600" data-aos-delay="800">
                        Entrar
                    </a>
                    <a href="registro"  class="btn-registrarse" data-aos="fade-left" data-aos-duration="600" data-aos-delay="900">
                        Registrarse
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Contenido 404 -->
    <div class="error-container">
        <h1 class="error-code" data-aos="zoom-in" data-aos-duration="1000" data-aos-delay="300">
            404!
        </h1>
        <p class="error-message" data-aos="fade-up" data-aos-duration="800" data-aos-delay="500">
            No pudimos encontrar lo que buscabas.
        </p>
        <p class="error-submessage" data-aos="fade-up" data-aos-duration="800" data-aos-delay="600">
            Intenta buscar de nuevo.
        </p>
        <a  href="/E-VITALIX/" class="btn-volver" data-aos="fade-up" data-aos-duration="800" data-aos-delay="700">
            Volver al inicio
        </a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- AOS Animation Library -->
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script src="<?= BASE_URL ?>/public/assets/auth/js/404.js"></script>
</body>
</html>