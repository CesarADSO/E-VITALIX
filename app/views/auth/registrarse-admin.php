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
    <link rel="stylesheet" href="public/assets/auth/css/registrarse.css">
    <style>
        /* Solo agrego esto para que el JS pueda ocultar/mostrar los pasos */
        .wizard-form-step { display: none; }
        .wizard-form-step.active { display: block; }
    </style>
</head>

<body>
    <div class="registro-container">
        <div class="registro-content">
            <div class="row fila-general">
                <div class="form-section col-md-6">
                    <div class="logo-header">
                        <a href="/E-VITALIX/"><img src="public/assets/auth/img/image-removebg-preview 1.png" alt="E-Vitalix" class="logo-registro"></a>
                    </div>

                    <p class="subtitle-registro">
                        Regístrate para poder crear tu cuenta de administrador de consultorio.
                    </p>

                    <div class="wizard-progress mb-4">
                        <div class="steps">
                            <div class="step active" data-step="1">
                                <span class="step-number">1</span>
                                <span class="step-label">Crea tu consultorio</span>
                            </div>
                            <div class="step" data-step="2">
                                <span class="step-number">2</span>
                                <span class="step-label">Crea tu cuenta</span>
                            </div>
                        </div>
                        <div style="width: 100%; height: 2px; background: #eee; margin-top: 10px; position: relative;">
                            <div id="progressLine" style="height: 100%; background: var(--primary-color, blue); width: 0%; transition: 0.3s;"></div>
                        </div>
                    </div>


                    <form id="registroForm" action="<?= BASE_URL ?>/registrarse" method="POST" enctype="multipart/form-data">

                        <div class="wizard-form-step active" data-step="1" id="step1">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label-custom">Nombre:</label>
                                    <input type="text" class="campos-formulario" placeholder="Ingresa el nombre del consultorio" id="nombre_consultorio" name="nombre_consultorio" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label-custom">Ciudad:</label>
                                    <input type="text" class="campos-formulario" placeholder="Ingresa la ciudad" id="ciudad_consultorio" name="ciudad_consultorio" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label-custom">Dirección:</label>
                                    <input type="text" class="campos-formulario" placeholder="Ingresa la dirección del consultorio" id="direccion_consultorio" name="direccion_consultorio" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label-custom">Teléfono:</label>
                                    <input type="number" class="campos-formulario" id="telefono_consultorio" name="telefono_consultorio">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label-custom">Foto:</label>
                                    <input type="file" class="campos-formulario" id="foto_consultorio" name="foto_consultorio">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label-custom">Correo de contacto:</label>
                                    <input type="email" class="campos-formulario" id="correo_contacto" placeholder="ingrese el correo del consultorio" name="correo_contacto">
                                </div>
                            </div>
                        </div>

                        <div class="wizard-form-step" data-step="2" id="step2">
                            <div class="form-row-custom">
                                <div class="form-group-custom">
                                    <label class="form-label-custom">Nombres:</label>
                                    <input type="text" class="campos-formulario" placeholder="Ingresa tu nombre..." id="nombre" name="nombres" required>
                                </div>

                                <div class="form-group-custom">
                                    <label class="form-label-custom">Apellidos:</label>
                                    <input type="text" class="campos-formulario" placeholder="Ingresa tu apellido..." id="apellidos" name="apellidos" required>
                                </div>
                            </div>

                            <div class="form-row-custom">
                                <div class="form-group-custom">
                                    <label class="form-label-custom">Tipo de documento:</label>
                                    <select name="tipo_documento" class="campos-formulario" id="tipoDocumento" required>
                                        <option value="">Selecciona tu tipo de documento</option>
                                        <option value="1">Cédula de Ciudadanía</option>
                                        <option value="2">Cédula de Extranjería</option>
                                        <option value="3">Tarjeta de Identidad</option>
                                    </select>
                                </div>

                                <div class="form-group-custom">
                                    <label class="form-label-custom">Número de documento:</label>
                                    <input type="text" class="campos-formulario" placeholder="xxxxxxxxxx" id="numeroDocumento" name="numero_documento" required>
                                </div>
                            </div>

                            <div class="form-row-custom">
                                <div class="form-group-custom">
                                    <label class="form-label-custom">Email:</label>
                                    <input type="email" class="campos-formulario" placeholder="tucorreo@gmail.com" id="email" name="email" required>
                                </div>

                                <div class="form-group-custom">
                                    <label class="form-label-custom">Teléfono:</label>
                                    <input type="text" class="campos-formulario" placeholder="Ingresa tu número de teléfono..." id="telefono" name="telefono" required>
                                </div>
                            </div>
                            
                            <div class="form-row-custom" style="margin-top: 15px;">
                                <div class="form-group-custom" style="width: 100%;">
                                    <label class="form-label-custom">Contraseña:</label>
                                    <input type="password" class="campos-formulario" placeholder="Crea una contraseña segura" id="password" name="password" required>
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
                        <a href="login" class="btn-login-link">
                            ¿Ya tienes cuenta? <strong>Inicia sesión</strong>
                        </a>
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