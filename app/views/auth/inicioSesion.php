<?php
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");
header("Expires: 0");
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Vitalix - Iniciar Sesión</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200..1000;1,200..1000&display=swap"
        rel="stylesheet">
    <!-- AOS Animation Library -->
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="public/assets/auth/css/inicionSesion.css">
</head>

<body>
    <div class="login-container">
        <div class="login-content">


            <div class="login-card">
                <div class="logo-container">
                    <!-- Aquí va tu logo - Reemplaza el src con la ruta de tu imagen -->
                    <div class="logo">
                        <a href="/E-VITALIX/"><img src="public/assets/auth/img/image-removebg-preview 1.png" alt="E-Vitalix Logo"
                            class="img-fluid" style="max-width: 100%;"></a>
                        <!-- Mientras tanto, placeholder: -->
                        <!-- <div class="logo-placeholder">E-VITALIX</div> -->
                    </div>
                </div>
                <h2 class="login-title">
                    Iniciar sesión
                </h2>
                <p class="login-pharagraf">Ingrese sus
                    credenciales para Iniciar sesión</p>
                <form id="loginForm" action="iniciar-sesion" method="POST">
                    <div>
                        <input type="email" name="email" class="campos-formulario" placeholder="Email" id="email" required>
                    </div>

                    <div>
                        <input type="password" name="clave" class="campos-formulario" placeholder="Contraseña" id="password"
                            required>
                    </div>

                    <div class="form-options">
                        

                        <a href="recuperacion" class="forgot-password">
                            ¿Olvidó su contraseña?
                        </a>
                    </div>

                    <div>
                        <button class="btn-azul" type="submit">Ingresar</button>
                    </div>

                    <div>
                        <a href="registro" class="btn-azul-2">
                            Registrarse
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>