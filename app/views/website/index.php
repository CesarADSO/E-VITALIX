<?php 
    // IMPORTAMOS EL CONTROLADOR DE LOS PLANES
    require_once BASE_PATH . '/app/controllers/planesController.php';

    // Creamos la variable donde vamos a traer los ids de los planes
    $plan = traerId();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>e-vitalix</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="public/assets/website/css/landing.css">
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg">
            <div class="container">
                <a class="navbar-brand" href="/E-VITALIX/"><img src="public/assets/website/img/LOGO NEGATIVO 1.svg"
                        alt="Logo de evitalix"></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse cont-nav" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item item">
                            <a class="nav-link active text-white enlace" aria-current="page" href="#"><img
                                    src="public/assets/website/img/puntito blanco del nav.svg"
                                    alt="Punto blanco">Inicio</a>
                        </li>
                        <li class="nav-item item">
                            <a class="nav-link text-white enlace" href="#funcionalidades"><img
                                    src="public/assets/website/img/puntito blanco del nav.svg"
                                    alt="Punto blanco">Funcionalidades</a>
                        </li>
                        <li class="nav-item item">
                            <a class="nav-link text-white enlace" href="#beneficios"><img
                                    src="public/assets/website/img/puntito blanco del nav.svg"
                                    alt="Punto blanco">Beneficios</a>
                        </li>
                        <li class="nav-item item">
                            <a class="nav-link text-white enlace" href="#precios"><img
                                    src="public/assets/website/img/puntito blanco del nav.svg"
                                    alt="Punto blanco">Planes</a>
                        </li>
                        <li class="nav-item item">
                            <a class="nav-link text-white enlace" href="#preguntas"><img
                                    src="public/assets/website/img/puntito blanco del nav.svg"
                                    alt="Punto blanco">Preguntas</a>
                        </li>
                    </ul>
                </div>
                <div class="cont-botones">
                    <a href="login" class="btn btn-primary boton1">Iniciar sesión</a>
                    <a href="registro" class="btn btn-outline-primary boton boton2">Soy paciente</a>
                </div>
            </div>
        </nav>
        <div id="hero">
            <div class="container-fluid pe-0">
                <div class="row fila-hero">
                    <div class="col-md-6 cont-info">
                        <h3 class="subtitulo-pequeño text-white"><img src="public/assets/website/img/estetoscopio.svg"
                                alt="">Plataforma de gestión médica
                            integral</h3>
                        <h1 class="text-white titulo-principal">Optimiza el tiempo de tu consultorio médico sin
                            complicaciones</h1>
                        <h2 class="text-white info-hero">E-VITALIX centraliza el agendamiento de citas, las historias
                            clínicas y las órdenes médicas
                            en una plataforma en la nube, rápida y segura.</h2>
                        <div class="cont-botones">
                            <a href="registroAdmin" class="btn btn-primary boton1">Empieza gratis <span
                                    class="rounded-circle d-inline-block align-middle circulo"><i
                                        class="bi bi-chevron-right text-white flecha-derecha"></i></span></a>
                            <a href="#precios" class="btn btn-outline-primary boton2">Ver planes <span
                                    class="rounded-circle d-inline-block align-middle circulo"><i
                                        class="bi bi-chevron-right text-white flecha-derecha"></i></span></a>
                        </div>
                    </div>
                    <div class="col-md-6 cont-foto pe-0 d-flex justify-content-end">
                        <img src="public/assets/website/img/dashboard hero prueba.svg" alt="Dashboard">
                    </div>
                </div>
            </div>
        </div>
    </header>
    <main>
        <section id="funcionalidades">
            <div class="container">
                <h2 class="text-center titulo-funcionalidades">Funcionalidades</h2>
                <div class="row">
                    <div class="col-md-12">
                        <div class="bg-white cont-fun-1">
                            <div class="row">
                                <div class="col-md-4 cont-info-1">
                                    <h5>Funcionalidad 01</h5>
                                    <h2>Historias clínicas Electrónicas</h2>
                                    <p>Acceso inmediato y seguro al historial completo de tus pacientes. Genera reportes
                                        en
                                        PDF al instante y mantén la información siempre disponible.</p>
                                </div>
                                <div class="col-md-8 cont-foto-1">
                                    <img src="public/assets/website/img/imagen de prueba 1.svg" alt="Imagen de prueba">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="bg-white cont-fun-2">
                            <div class="row">
                                <div class="col-md-12 cont-foto-2">
                                    <img src="public/assets/website/img/imagen de prueba 2.svg"
                                        alt="Imagen de prueba 2">
                                </div>
                                <div class="col-md-12 cont-info-2">
                                    <h5>Funcionalidad 02</h5>
                                    <h2>Visualización Clara de Agenda</h2>
                                    <p>Controla tu disponibilidad al instante. Calendario interactivo diseñado para
                                        identificar espacios libres rápidamente y consultar los detalles de cada
                                        paciente programado, manteniendo tu día organizado sin complicaciones.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="bg-white cont-fun-3">
                            <div class="row">
                                <div class="col-md-12 cont-foto-3">
                                    <img src="public/assets/website/img/imagen de prueba 3.svg"
                                        alt="Imagen de prueba 3">
                                </div>
                                <div class="col-md-12 cont-info-3">
                                    <h5>Funcionalidad 03</h5>
                                    <h2>Portal de Agendamiento Directo</h2>
                                    <p>Facilita la vida de tu recepción y de tus pacientes. E-VITALIX incluye un módulo
                                        donde el paciente puede buscar por especialidad y elegir tu consultorio
                                        directamente, automatizando el ingreso de nuevas citas a tu sistema.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section id="beneficios">
            <div class="container">
                <h2 class="text-center text-white titulo-beneficios">Beneficios para el consultorio</h2>
                <div class="row fila-beneficios gx-3">
                    <div class="col-md-6">
                        <div class="cont-foto cont-1">
                            <img src="public/assets/website/img/beneficios 1.svg" alt="beneficios 1">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="cont-foto cont-2">
                            <img src="public/assets/website/img/beneficios 2.svg" alt="beneficios 2">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="cont-foto cont-3">
                            <img src="public/assets/website/img/beneficios 3.svg" alt="beneficios 3">
                        </div>
                    </div>
                </div>
                <div id="carouselExample" class="carousel slide">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <h3 class="text-white titulo-carrusel">Cero papel máxima eficiencia</h3>
                                    <p class="text-white parrafo-carrusel">Transforma montañas de carpetas en un archivo
                                        digital organizado. Encuentra la
                                        historia
                                        clínica de cualquier paciente en segundos, sin ocupar espacio físico en tu
                                        clínica.
                                    </p>
                                </div>
                                <div class="carousel-item">
                                    <h3 class="text-white titulo-carrusel">Cero papel máxima eficiencia</h3>
                                    <p class="text-white parrafo-carrusel">Transforma montañas de carpetas en un archivo
                                        digital organizado. Encuentra la
                                        historia
                                        clínica de cualquier paciente en segundos, sin ocupar espacio físico en tu
                                        clínica.
                                    </p>
                                </div>
                                <div class="carousel-item">
                                    <h3 class="text-white titulo-carrusel">Cero papel máxima eficiencia</h3>
                                    <p class="text-white parrafo-carrusel">Transforma montañas de carpetas en un archivo
                                        digital organizado. Encuentra la
                                        historia
                                        clínica de cualquier paciente en segundos, sin ocupar espacio físico en tu
                                        clínica.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 cont-botones-carrusel">
                            <button class="boton-carrusel" type="button" data-bs-target="#carouselExample"
                                data-bs-slide="prev">
                                <i class="bi bi-chevron-left"></i>
                            </button>
                            <button class="boton-carrusel" type="button" data-bs-target="#carouselExample"
                                data-bs-slide="next">
                                <i class="bi bi-chevron-right"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section id="precios">
            <div class="container">
                <h2 class="text-white text-center titulo-precios">Planes y precios</h2>
                <p class="text-white text-center parrafo-planes">Planes simples y transparentes diseñados para el
                    crecimiento de tu consultorio.</p>
                <div class="row">
                    <div class="col-md-4 cont-plan">
                        <div class="bg-white plan">
                            <h3>Plan semilla</h3>
                            <h2>Gratis</h2>
                            <p class="p-descriptivo-plan">Perfecto para comenzar y probar la plataforma</p>
                            <a href="registroAdmin" class="btn btn-primary boton-plan">Crear cuenta gratis</a>
                            <p><i class="bi bi-check2 chulo"></i>Hasta 30 citas mensuales</p>
                        </div>
                    </div>
                    <div class="col-md-4 cont-plan">
                        <div class="bg-white plan">
                            <div class="cont-popular">
                                <h3>Plan pro</h3>
                                <span>El más popular</span>
                            </div>
                            <h2>$50,000/ mensual</h2>
                            <p class="p-descriptivo-plan">Ideal para consultorios en crecimiento</p>
                            <a href="registroAdmin?plan=<?= $plan[1]['id'] ?>" class="btn btn-primary boton-plan">Comprar plan pro</a>
                            <p><i class="bi bi-check2 chulo"></i>Hasta 300 citas mensuales</p>
                        </div>
                    </div>
                    <div class="col-md-4 cont-plan">
                        <div class="bg-white plan">
                            <h3>Plan premium</h3>
                            <h2>$150,000/ mensual</h2>
                            <p class="p-descriptivo-plan">Para grandes redes de consultorios médicos</p>
                            <a href="registroAdmin?plan=<?= $plan[2]['id'] ?>" class="btn btn-primary boton-plan">Comprar plan premium</a>
                            <p><i class="bi bi-check2 chulo"></i>Hasta 3,000 citas mensuales</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section id="preguntas">
            <div class="container">
                <h2 class="text-white text-center titulo-preguntas">Preguntas frecuentes</h2>
                <div class="row">
                    <div class="col-md-12">
                        <div class="bg-white cont-pregunta">
                            <div class="accordion accordion-flush" id="accordionExample">
                                <div class="accordion-item">
                                    <div class="accordion-header cabecera-acordion">
                                        <h3>¿Cómo funciona el plan gratuito y cuáles son sus límites?</h3>
                                        <button class="btn btn-primary boton-acordion collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false"
                                            aria-controls="collapseOne"><i
                                                class="bi bi-chevron-down text-white icono-flecha"></i></button>
                                    </div>
                                    <div id="collapseOne" class="accordion-collapse collapse"
                                        data-bs-parent="#accordionExample">
                                        <div class="accordion-body cuerpo-acordion">
                                            <strong>Nuestro Plan Básico te permite usar E-VITALIX sin costo por tiempo
                                                indefinido, con un límite de 30 citas agendadas al mes. Es la forma
                                                perfecta de digitalizar tu consultorio sin riesgo. Si tu clínica crece y
                                                necesitas gestionar un volumen mayor, puedes actualizar en cualquier
                                                momento a nuestro Plan Profesional para obtener más citas que se puedan
                                                agendar en tu consultorio.</strong>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="bg-white cont-pregunta">
                            <div class="accordion accordion-flush" id="accordionExample">
                                <div class="accordion-item">
                                    <div class="accordion-header cabecera-acordion">
                                        <h3>¿Necesito conocimientos técnicos avanzados para usar el sistema?</h3>
                                        <button class="btn btn-primary boton-acordion collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false"
                                            aria-controls="collapseTwo"><i
                                                class="bi bi-chevron-down text-white icono-flecha"></i></button>
                                    </div>
                                    <div id="collapseTwo" class="accordion-collapse collapse"
                                        data-bs-parent="#accordionExample">
                                        <div class="accordion-body cuerpo-acordion">
                                            <strong>En absoluto. Diseñamos E-VITALIX con una interfaz moderna, limpia e
                                                intuitiva (Clarity over complexity). Tanto los médicos como el personal
                                                administrativo pueden agendar citas, generar órdenes y redactar
                                                historias clínicas desde el primer día, como si estuvieran usando su
                                                correo electrónico.</strong>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="bg-white cont-pregunta">
                            <div class="accordion accordion-flush" id="accordionExample">
                                <div class="accordion-item">
                                    <div class="accordion-header cabecera-acordion">
                                        <h3>¿Puedo acceder a la información desde mi celular o fuera del consultorio?
                                        </h3>
                                        <button class="btn btn-primary boton-acordion collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapseThree"
                                            aria-expanded="false" aria-controls="collapseThree"><i
                                                class="bi bi-chevron-down text-white icono-flecha"></i></button>
                                    </div>
                                    <div id="collapseThree" class="accordion-collapse collapse"
                                        data-bs-parent="#accordionExample">
                                        <div class="accordion-body cuerpo-acordion">
                                            <strong>Sí. E-VITALIX es una plataforma 100% en la nube. Puedes acceder al
                                                historial completo de tus pacientes, revisar tu agenda del día o emitir
                                                recetas desde cualquier computador, tablet o smartphone con conexión a
                                                internet, las 24 horas del día.</strong>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="bg-white cont-pregunta">
                            <div class="accordion accordion-flush" id="accordionExample">
                                <div class="accordion-item">
                                    <div class="accordion-header cabecera-acordion">
                                        <h3>¿Están seguros los datos médicos y las historias clínicas de mis pacientes?
                                        </h3>
                                        <button class="btn btn-primary boton-acordion collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapseFour"
                                            aria-expanded="false" aria-controls="collapseFour"><i
                                                class="bi bi-chevron-down text-white icono-flecha"></i></button>
                                    </div>
                                    <div id="collapseFour" class="accordion-collapse collapse"
                                        data-bs-parent="#accordionExample">
                                        <div class="accordion-body cuerpo-acordion">
                                            <strong>La seguridad es nuestra máxima prioridad. Toda la información
                                                operativa y los historiales clínicos se almacenan en servidores seguros
                                                con arquitecturas de bases de datos robustas. Solo el personal de salud
                                                autorizado por el consultorio tiene acceso a los datos de los pacientes,
                                                garantizando la confidencialidad.</strong>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section id="convencer">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 cont-info">
                        <h2 class="titulo-convencer text-white">100%</h2>
                        <h4 class="text-white">De tu consultorio gestionado de forma digital y segura en la nube.</h4>
                    </div>
                    <div class="col-md-6 cont-descriptivo">
                        <h3 class="text-white">E-VITALIX transformó el caos de las agendas y el papeleo en un flujo de
                            trabajo organizado.
                            Dejamos de perder tiempo buscando historias clínicas y empezamos a enfocarnos en lo que
                            importa: los pacientes.</h3>
                        <div class="cont-botones-2">
                            <a href="#" class="btn btn-primary boton1">Empieza gratis <span
                                    class="rounded-circle d-inline-block align-middle circulo"><i
                                        class="bi bi-chevron-right text-white flecha-derecha"></i></span></a>
                            <a href="#precios" class="btn btn-outline-primary boton2">Ver planes <span
                                    class="rounded-circle d-inline-block align-middle circulo"><i
                                        class="bi bi-chevron-right text-white flecha-derecha"></i></span></a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <footer>
        <nav class="navbar navbar-expand-lg">
            <div class="container">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse cont-nav" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item item">
                            <a class="nav-link active text-white enlace" aria-current="page" href="#"><img
                                    src="public/assets/website/img/puntito blanco del nav.svg"
                                    alt="Punto blanco">Inicio</a>
                        </li>
                        <li class="nav-item item">
                            <a class="nav-link text-white enlace" href="#funcionalidades"><img
                                    src="public/assets/website/img/puntito blanco del nav.svg"
                                    alt="Punto blanco">Funcionalidades</a>
                        </li>
                        <li class="nav-item item">
                            <a class="nav-link text-white enlace" href="#beneficios"><img
                                    src="public/assets/website/img/puntito blanco del nav.svg"
                                    alt="Punto blanco">Beneficios</a>
                        </li>
                        <li class="nav-item item">
                            <a class="nav-link text-white enlace" href="#precios"><img
                                    src="public/assets/website/img/puntito blanco del nav.svg"
                                    alt="Punto blanco">Planes</a>
                        </li>
                        <li class="nav-item item">
                            <a class="nav-link text-white enlace" href="#preguntas"><img
                                    src="public/assets/website/img/puntito blanco del nav.svg"
                                    alt="Punto blanco">Preguntas</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="container">
            <div class="row fila-footer">
                <div class="col-md-10 cont-logo-footer">
                    <a href="/E-VITALIX/"><img src="public/assets/website/img/LOGO NEGATIVO 1.svg" alt="Logo evitalix"></a>
                    <p class="text-white"> E-VITALIX — Plataforma integral de gestión médica y agendamiento.</p>
                </div>
                <div class="col-md-2 cont-info-footer">
                    <div class="cont-redes-sociales">
                        <a href="#" class="text-white redes"><i class="bi bi-instagram"></i></a>
                        <a href="#" class="text-white redes"><i class="bi bi-twitter-x"></i></a>
                    </div>
                    <p class="text-white text-end">evitalix558@gmail.com</p>
                </div>
            </div>
        </div>
    </footer>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>
</body>

</html>