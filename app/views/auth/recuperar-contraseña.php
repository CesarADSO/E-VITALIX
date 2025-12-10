<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Vitalix - Recuperar Contraseña</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200..1000;1,200..1000&display=swap" rel="stylesheet">
    <!-- AOS Animation Library -->
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="public/assets/auth/css/recuperarContraseña.css">
</head>

<body>
    <div class="recuperar-container">
        <div class="logo-container">
            <div class="logo">
                <a href="/E-VITALIX/"><img src="public/assets/auth/img/image-removebg-preview 1.png" alt="E-Vitalix Logo" class="img-fluid" style="max-width: 100%;"></a>
                <!-- Placeholder temporal -->
                <!-- <div class="logo-placeholder">E-VITALIX</div> -->
            </div>
        </div>

        <div class="recuperar-content">
            <div class="recuperar-card">
                <!-- Formulario de recuperación -->
                <div id="recuperarForm">
                    <h2 class="recuperar-title">
                        Recuperar contraseña
                    </h2>
                    <p class="recuperar-subtitle">
                        Ingresa tu correo electrónico y te enviaremos un enlace para restablecer tu contraseña.
                    </p>

                    <form id="formRecuperar" action="<?= BASE_URL ?>/generar-clave" method="POST">
                        <div>
                            <label class="correo" for="correo">Correo</label>
                            <input
                                type="email"
                                class="campos-formulario"
                                name="email"
                                placeholder="Ingresa tu email"
                                id="email"
                                required>
                        </div>
                        <div>

                            <button type="submit" class="btn-azul" id="btnEnviar" style="display: block; text-decoration: none; text-align: center;">Restablecer</button>
                        </div>
                    </form>

                    <div class="volver-login">
                        <a href="login">
                            ← Volver al inicio de sesión
                        </a>
                    </div>
                </div>

                <!-- Mensaje de éxito (oculto por defecto) -->
                <div class="success-message" id="successMessage">
                    <div class="success-icon">✓</div>
                    <h3 class="success-title">
                        ¡Correo enviado!
                    </h3>
                    <p class="success-text">
                        Hemos enviado un enlace de recuperación a tu correo electrónico.
                        Por favor, revisa tu bandeja de entrada y sigue las instrucciones.
                    </p>
                    <div data-aos="fade-up">
                        <a href="recuperacion" target="_blank" class="btn-azul" style="display: block; text-decoration: none; text-align: center;">
                            Enviar otro correo
                        </a>
                    </div>
                    <div class="volver-login">
                        <a target="_blank" href="login">
                            ← Volver al inicio de sesión
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- AOS Animation Library -->
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
</body>

</html>