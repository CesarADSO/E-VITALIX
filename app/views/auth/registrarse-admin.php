<?php
require_once BASE_PATH . '/app/controllers/ciudadesController.php';
$ciudades = listarCiudades();

?>

<?php
// Validamos si hay un plan seleccionado en la URL, y lo guardamos en la sesión
if (isset($_GET['plan'])) {
    $_SESSION['suscripcion_deseada'] = $_GET['plan'];
}
?>



<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Vitalix - Registrarse</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200..1000;1,200..1000&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="public/assets/auth/css/registrarse.css">
    <link rel="icon" href="public/assets/auth/img/FAVICON.png">
    <style>
        /* Solo agrego esto para que el JS pueda ocultar/mostrar los pasos */
        .wizard-form-step {
            display: none;
        }

        .wizard-form-step.active {
            display: block;
        }
    </style>
</head>

<body>
    <div class="registro-container">
        <div class="registro-content">
            <div class="row fila-general">
                <div class="form-section col-md-6">
                    <div class="logo-header">
                        <a href="<?= BASE_URL ?>/"><img src="public/assets/auth/img/image-removebg-preview 1.png" alt="E-Vitalix" class="logo-registro"></a>
                    </div>

                    <p class="subtitle-registro">
                        Regístrate para poder crear tu cuenta de administrador de consultorio.
                    </p>

                    <div class="alert alert-info" role="alert">
                        <i class="bi bi-info-circle"></i> La contraseña es tu número de documento.
                    </div>

                    <div class="wizard-progress mb-4">
                        <div class="steps">
                            <div class="step active" data-step="1">
                                <span class="step-number">1</span>
                                <span class="step-label">Crea tu consultorio</span>
                            </div>
                            <div class="step" data-step="2">
                                <span class="step-number">2</span>
                                <span class="step-label">Selección de horario</span>
                            </div>
                            <div class="step" data-step="3">
                                <span class="step-number">3</span>
                                <span class="step-label">Crea tu cuenta</span>
                            </div>
                        </div>
                    </div>


                    <form id="registroForm" action="<?= BASE_URL ?>/registrarse-admin" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="accion" value="registrar">
                        <input type="hidden" name="origen" value="publico">

                        <div class="wizard-form-step active" data-step="1" id="step1">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label-custom">Nombre:</label>
                                    <input type="text" class="campos-formulario" placeholder="Ingresa el nombre del consultorio" id="nombre_consultorio" name="nombre" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label-custom">Ciudad:</label>
                                    <select class="campos-formulario" name="ciudad" required>
                                        <option value="">Selecciona una ciudad</option>
                                        <?php foreach ($ciudades as $ciudad): ?>
                                            <option value="<?= $ciudad['id'] ?>"><?= htmlspecialchars($ciudad['nombre']) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-6 cont-input">
                                    <label class="form-label-custom">Dirección:</label>
                                    <input type="text" class="campos-formulario" placeholder="Ingresa la dirección del consultorio" id="direccion_consultorio" name="direccion" required>
                                </div>
                                <div class="col-md-6 cont-input">
                                    <label class="form-label-custom">Teléfono:</label>
                                    <input type="tel" class="campos-formulario" id="telefono_consultorio" placeholder="ingresa el teléfono" name="telefono" minlength="10" maxlength="10" pattern="[0-9]{10}" inputmode="numeric" title="El teléfono debe tener exactamente 10 dígitos">
                                </div>
                                <div class="col-md-6 cont-input">
                                    <label class="form-label-custom">Foto:</label>
                                    <input type="file" class="campos-formulario" id="foto_consultorio" name="foto">
                                </div>
                                <div class="col-md-6 cont-input">
                                    <label class="form-label-custom">Correo de contacto:</label>
                                    <input type="email" class="campos-formulario" id="correo_contacto" placeholder="ingrese el correo del consultorio" name="correo">
                                </div>
                            </div>
                        </div>

                        <div class="wizard-form-step" data-step="2" id="step2">
                            <div class="mb-3">
                                <label for="horario_atencion" class="form-label">Días de Atención</label>
                                <div class="row">
                                    <div class="form-check check-dia col-md-6">
                                        <input class="form-check-input" type="checkbox" name="dias[]" value="Lunes">
                                        <label class="form-check-label mi-label">Lunes</label>
                                    </div>
                                    <div class="form-check check-dia">
                                        <input class="form-check-input" type="checkbox" name="dias[]" value="Martes">
                                        <label class="form-check-label mi-label">Martes</label>
                                    </div>
                                    <div class="form-check check-dia">
                                        <input class="form-check-input" type="checkbox" name="dias[]" value="Miercoles">
                                        <label class="form-check-label mi-label">Miercoles</label>
                                    </div>
                                    <div class="form-check check-dia">
                                        <input class="form-check-input" type="checkbox" name="dias[]" value="Jueves">
                                        <label class="form-check-label mi-label">Jueves</label>
                                    </div>
                                    <div class="form-check check-dia">
                                        <input class="form-check-input" type="checkbox" name="dias[]" value="Viernes">
                                        <label class="form-check-label mi-label">Viernes</label>
                                    </div>
                                    <div class="form-check check-dia">
                                        <input class="form-check-input" type="checkbox" name="dias[]" value="Sabado">
                                        <label class="form-check-label mi-label">Sabado</label>
                                    </div>
                                    <div class="form-check check-dia">
                                        <input class="form-check-input" type="checkbox" name="dias[]" value="Domingo">
                                        <label class="form-check-label mi-label">Domingo</label>
                                    </div>
                                </div>

                            </div>
                            <div class="mb-3">
                                <label class="form-label">Horario de atención</label>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="hora_apertura" class="form-label">Hora apertura</label>
                                        <input type="time" id="hora_apertura" name="hora_apertura" class="form-control">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="hora_cierre" class="form-label">Hora cierre</label>
                                        <input type="time" id="hora_cierre" name="hora_cierre" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="wizard-form-step" data-step="3" id="step3">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label-custom">Nombres:</label>
                                    <input type="text" class="campos-formulario" placeholder="Ingresa tu nombre..." id="nombre" name="nombres_admin" required>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label-custom">Apellidos:</label>
                                    <input type="text" class="campos-formulario" placeholder="Ingresa tu apellido..." id="apellidos" name="apellidos_admin" required>
                                </div>

                                <div class="col-md-6 cont-input">
                                    <label class="form-label-custom">Tipo de documento:</label>
                                    <select name="tipo_documento_admin" class="campos-formulario" id="tipoDocumento" required>
                                        <option value="">Selecciona tu tipo de documento</option>
                                        <option value="1">Cédula de Ciudadanía</option>
                                        <option value="2">Cédula de Extranjería</option>
                                        <option value="3">Tarjeta de Identidad</option>
                                    </select>
                                </div>

                                <div class="col-md-6 cont-input">
                                    <label class="form-label-custom">Número de documento:</label>
                                    <input type="text" class="campos-formulario" placeholder="xxxxxxxxxx" id="numeroDocumento" name="numero_documento_admin" required>
                                </div>

                                <div class="col-md-6 cont-input">
                                    <label class="form-label-custom">Email:</label>
                                    <input type="email" class="campos-formulario" placeholder="tucorreo@gmail.com" id="email" name="correo_admin" required>
                                </div>

                                <div class="col-md-6 cont-input">
                                    <label class="form-label-custom">Teléfono:</label>
                                    <input type="tel" class="campos-formulario" placeholder="Ingresa tu número de teléfono..." id="telefono" name="telefono_admin" required minlength="10" maxlength="10" pattern="[0-9]{10}" inputmode="numeric" title="El teléfono debe tener exactamente 10 dígitos">
                                </div>

                            </div>
                        </div>

                        <div style="display: flex; justify-content: space-between; margin-top: 20px;">
                            <button type="button" class="btn btn-secondary" id="btnAnterior" style="display: none; width: 48%;">Anterior</button>
                            <button type="button" class="btn-azul" id="btnSiguiente" style="width: 100%;">Siguiente</button>
                            <button type="submit" class="btn-azul" id="btnRegistrar" style="display: none; width: 48%;">Registrarse</button>
                        </div>

                    </form>

                    <div class="login-link-container">
                        <!-- Este condicional es para validar si el usuario trae un id del plan deseado -->
                        <?php
                        if (isset($_SESSION['suscripcion_deseada'])):
                        ?>
                            <a href="login?plan=<?= $_SESSION['suscripcion_deseada'] ?>" class="btn-login-link">
                                ¿Ya tienes cuenta? <strong>Inicia sesión</strong>
                            </a>

                        <?php else: ?>
                            <a href="login" class="btn-login-link">
                                ¿Ya tienes cuenta? <strong>Inicia sesión</strong>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="image-section col-md-6">
                    <img src="public/assets/auth/img/doctor 3.jpg" alt="Doctor" style=" height: 100%; object-fit: cover;">
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script src="public/assets/auth/js/registrarse.js"></script>
</body>

</html>