<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Vitalix - Registrarse</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700&display=swap" rel="stylesheet">

    <!-- AOS -->
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">

    <!-- CSS propio -->
    <link rel="stylesheet" href="public/assets/auth/css/registrarse.css">

    
</head>

<body>
<div class="registro-container">
    <div class="registro-content">
        <div class="registro-row">

            <!-- FORMULARIO -->
            <div class="form-section">

                <!-- LOGO -->
                <div class="logo-header" data-aos="fade-down">
                    <a href="/E-VITALIX/">
                        <img src="public/assets/auth/img/image-removebg-preview 1.png"
                             alt="E-Vitalix" class="logo-registro">
                    </a>
                </div>

                <p class="subtitle-registro" data-aos="fade-up">
                    Regístrate para poder crear tu cuenta
                </p>

                <!-- PROGRESO -->
                <div class="wizard-progress" data-aos="fade-up">
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

                <!-- FORM -->
                <form id="registroForm">

                    <!-- STEP 1 -->
                    <div class="wizard-form-step active" data-step="1">
                        <div class="form-row-custom">
                            <div class="form-group-custom">
                                <label>Nombre</label>
                                <input type="text" class="campos-formulario" placeholder="Ingresa tu nombre" required>
                            </div>
                            <div class="form-group-custom">
                                <label>Apellidos</label>
                                <input type="text" class="campos-formulario" placeholder="Ingresa tus apellidos" required>
                            </div>
                        </div>

                        <div class="form-row-custom">
                            <div class="form-group-custom">
                                <label>Email</label>
                                <input type="email" class="campos-formulario" placeholder="correo@email.com" required>
                            </div>
                            <div class="form-group-custom">
                                <label>Teléfono</label>
                                <input type="tel" class="campos-formulario" placeholder="xxxxxxxxxx" required>
                            </div>
                        </div>
                    </div>

                    <!-- STEP 2 -->
                    <div class="wizard-form-step" data-step="2">
                        <div class="form-row-custom">
                            <div class="form-group-custom">
                                <label>Tipo de documento</label>
                                <select class="campos-formulario" required>
                                    <option value="">Seleccione</option>
                                    <option>CC</option>
                                    <option>CE</option>
                                    <option>TI</option>
                                    <option>PP</option>
                                </select>
                            </div>
                            <div class="form-group-custom">
                                <label>Número de documento</label>
                                <input type="text" class="campos-formulario" required>
                            </div>
                        </div>
                    </div>

                    <!-- STEP 3 -->
                    <div class="wizard-form-step" data-step="3">
                        <div class="form-row-custom">
                            <div class="form-group-custom">
                                <label>Contraseña</label>
                                <input type="password" class="campos-formulario" required>
                            </div>
                            <div class="form-group-custom">
                                <label>Confirmar contraseña</label>
                                <input type="password" class="campos-formulario" required>
                            </div>
                        </div>
                    </div>

                    <!-- STEP 4 -->
                    <div class="wizard-form-step" data-step="4">
                        <div class="form-row-custom">
                            <div class="form-group-custom">
                                <label>Género</label>
                                <select class="campos-formulario" required>
                                    <option value="">Seleccione</option>
                                    <option>M</option>
                                    <option>F</option>
                                    <option>Otro</option>
                                </select>
                            </div>
                            <div class="form-group-custom">
                                <label>Rol</label>
                                <select class="campos-formulario" required>
                                    <option value="">Seleccione</option>
                                    <option>Paciente</option>
                                    <option>Médico</option>
                                    <option>Administrador</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- BOTONES -->
                    <div class="wizard-buttons">
                        <button type="button" class="btn-wizard btn-secondary" id="btnAnterior" style="display:none">
                            Anterior
                        </button>
                        <button type="button" class="btn-wizard" id="btnSiguiente">
                            Siguiente
                        </button>
                    </div>

                    <!-- LINK LOGIN -->


                    <div class="login-link-container">
                        <a href="login" class="btn-login-link">
                            ¿Ya tienes cuenta?   <strong>Inicia sesión</strong>
                        </a>
                    </div>

                </form>
            </div>

            <!-- IMAGEN -->
            <div class="image-section" data-aos="fade-left">
                <img src="public/assets/auth/img/doctor 3.jpg" alt="Doctor"
                     style="width:100%; height:100%; object-fit:cover;">
            </div>

        </div>
    </div>
</div>

<!-- JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
<script>
    AOS.init();
</script>
<script src="public/assets/auth/js/registrarse.js"></script>

</body>
</html>
