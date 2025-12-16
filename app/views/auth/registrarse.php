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
    <!-- AOS Animation Library -->
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="public/assets/auth/css/registrarse.css">
</head>
<body>
    <div class="registro-container">
        <div class="registro-content">
            <div class="registro-row">
                <div class="form-section">
                    <div class="logo-header" data-aos="fade-down" data-aos-duration="800">
                        <!-- Reemplaza con tu logo -->
                        <a href="/E-VITALIX/"><img src="public/assets/auth/img/image-removebg-preview 1.png" alt="E-Vitalix" class="logo-registro"></a>
                    </div>

                    <p class="subtitle-registro" data-aos="fade-up" data-aos-duration="800" data-aos-delay="200">
                        Regístrate para poder crear tu cuenta
                    </p>

                    <!-- Wizard Progress Bar -->
                    <div class="wizard-progress" data-aos="fade-up" data-aos-duration="800" data-aos-delay="300">
                        <div class="progress-line" id="progressLine"></div>
                        <div class="wizard-step active" data-step="1">
                            <div class="step-circle">1</div>
                            <div class="step-label">Datos personales</div>
                        </div>
                        <div class="wizard-step" data-step="2">
                            <div class="step-circle">2</div>
                            <div class="step-label">Documentación</div>
                        </div>
                        <div class="wizard-step" data-step="3">
                            <div class="step-circle">3</div>
                            <div class="step-label">Seguridad</div>
                        </div>
                        <div class="wizard-step" data-step="4">
                            <div class="step-circle">4</div>
                            <div class="step-label">Info adicional</div>
                        </div>
                    </div>

                    <form id="registroForm">
                        <!-- Step 1: Datos Personales -->
                        <div class="wizard-form-step active" data-step="1">
                            <div class="form-row-custom" data-aos="fade-right" data-aos-duration="600" data-aos-delay="400">
                                <div class="form-group-custom">
                                    <label class="form-label-custom">Nombre:</label>
                                    <input 
                                        type="text" 
                                        class="campos-formulario" 
                                        placeholder="Ingresa tu nombre..." 
                                        id="nombre"
                                        required
                                    >
                                </div>
                                <div class="form-group-custom">
                                    <label class="form-label-custom">Apellidos:</label>
                                    <input 
                                        type="text" 
                                        class="campos-formulario" 
                                        placeholder="Ingresa tu apellido..." 
                                        id="apellidos"
                                        required
                                    >
                                </div>
                            </div>

                            <div class="form-row-custom" data-aos="fade-right" data-aos-duration="600" data-aos-delay="500">
                                <div class="form-group-custom">
                                    <label class="form-label-custom">Email:</label>
                                    <input 
                                        type="email" 
                                        class="campos-formulario" 
                                        placeholder="tucorreo@gmail.com" 
                                        id="email"
                                        required
                                    >
                                </div>
                                <div class="form-group-custom">
                                    <label class="form-label-custom">Teléfono:</label>
                                    <input 
                                        type="tel" 
                                        class="campos-formulario" 
                                        placeholder="xxxxxxxxxx" 
                                        id="telefono"
                                        required
                                    >
                                </div>
                            </div>
                        </div>

                        <!-- Step 2: Documentación -->
                        <div class="wizard-form-step" data-step="2">
                            <div class="form-row-custom" data-aos="fade-right" data-aos-duration="600" data-aos-delay="400">
                                <div class="form-group-custom">
                                    <label class="form-label-custom">Tipo de documento:</label>
                                    <select class="campos-formulario" id="tipoDocumento" required>
                                        <option value="">Selecciona tu tipo de documento</option>
                                        <option value="CC">Cédula de Ciudadanía</option>
                                        <option value="CE">Cédula de Extranjería</option>
                                        <option value="TI">Tarjeta de Identidad</option>
                                        <option value="PP">Pasaporte</option>
                                    </select>
                                </div>
                                <div class="form-group-custom">
                                    <label class="form-label-custom">Número de documento:</label>
                                    <input 
                                        type="text" 
                                        class="campos-formulario" 
                                        placeholder="xxxxxxxxxx" 
                                        id="numeroDocumento"
                                        required
                                    >
                                </div>
                            </div>
                        </div>

                        <!-- Step 3: Seguridad -->
                        <div class="wizard-form-step" data-step="3">
                            <div class="form-row-custom" data-aos="fade-right" data-aos-duration="600" data-aos-delay="400">
                                <div class="form-group-custom">
                                    <label class="form-label-custom">Contraseña:</label>
                                    <input 
                                        type="password" 
                                        class="campos-formulario" 
                                        placeholder="Crea una contraseña" 
                                        id="contrasena"
                                        required
                                    >
                                </div>
                                <div class="form-group-custom">
                                    <label class="form-label-custom">Confirmación de contraseña:</label>
                                    <input 
                                        type="password" 
                                        class="campos-formulario" 
                                        placeholder="Confirma tu contraseña" 
                                        id="confirmarContrasena"
                                        required
                                    >
                                </div>
                            </div>
                        </div>

                        <!-- Step 4: Información Adicional -->
                        <div class="wizard-form-step" data-step="4">
                            <div class="form-row-custom" data-aos="fade-right" data-aos-duration="600" data-aos-delay="400">
                                <div class="form-group-custom">
                                    <label class="form-label-custom">Género:</label>
                                    <select class="campos-formulario" id="genero" required>
                                        <option value="">Selecciona tu género</option>
                                        <option value="M">Masculino</option>
                                        <option value="F">Femenino</option>
                                        <option value="O">Otro</option>
                                        <option value="N">Prefiero no decir</option>
                                    </select>
                                </div>
                                <div class="form-group-custom">
                                    <label class="form-label-custom">Rol:</label>
                                    <select class="campos-formulario" id="rol" required>
                                        <option value="">Selecciona tu rol en el sistema</option>
                                        <option value="paciente">Paciente</option>
                                        <option value="medico">Médico</option>
                                        <option value="enfermero">Enfermero/a</option>
                                        <option value="admin">Administrador</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Wizard Navigation Buttons -->
                        <div class="wizard-buttons" data-aos="fade-up" data-aos-duration="800" data-aos-delay="600">
                            <button type="button" class="btn-wizard btn-secondary" id="btnAnterior" style="display: none;">
                                Anterior
                            </button>
                            <button type="button" class="btn-wizard" id="btnSiguiente">
                                Siguiente
                            </button>
                            <a href="login" target="_blank" class="btn-wizard" id="btnRegistrar" style="display: none; text-decoration: none; text-align: center; line-height: 1.5;">
                                Registrarse
                            </a>
                              <a href="login" target="_blank" class="btn-wizard" id="btnRegistrar" style="display: none; text-decoration: none; text-align: center; line-height: 1.5;">
                                Iniciar Sesión
                            </a>
                        </div>
                    </form>
                </div>

                <div class="image-section" data-aos="fade-left" data-aos-duration="1000" data-aos-delay="200">
                    <!-- Agrega tu imagen aquí -->
                    <img src="public/assets/auth/img/doctor 3.jpg" alt="Doctor" style="width: 100%; height: 100%; object-fit: cover;">
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- AOS Animation Library -->
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script src="public/assets/auth/js/registrarse.js"></script>
</body>
</html>