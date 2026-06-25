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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="public/assets/auth/css/registrarse.css">
    <link rel="icon" href="public/assets/auth/img/FAVICON.png">
</head>

<body>
    <div class="registro-container">
        <div class="registro-content">
            <div class="row fila-general">
                <div class="form-section col-md-6">
                    <div class="logo-header">
                        <!-- Reemplaza con tu logo -->
                        <a href="<?= BASE_URL ?>/"><img src="public/assets/auth/img/image-removebg-preview 1.png" alt="E-Vitalix" class="logo-registro"></a>
                    </div>

                    <p class="subtitle-registro">
                        Regístrate para poder crear tu cuenta de paciente.
                    </p>

                    <div class="alert alert-info" role="alert">
                        <i class="bi bi-info-circle"></i> La contraseña es tu número de documento.
                    </div>

                    <form id="registroForm" action="<?= BASE_URL ?>/registrarse" method="POST" enctype="multipart/form-data" novalidate>
                        <input type="hidden" name="accion" value="registrarPaciente">
                        <div class="row">
                            <div class="col-md-6">
                                <label class="form-label-custom">Nombres:</label>
                                <input
                                    type="text"
                                    class="campos-formulario"
                                    placeholder="Ingresa tu nombre..."
                                    id="nombre"
                                    name="nombres"
                                    required
                                    minlength="2"
                                    maxlength="100"
                                    pattern="[a-záéíóúñ\s\-'áéíóúÁÉÍÓÚÑ]+"
                                    title="Solo se permiten letras">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label-custom">Apellidos:</label>
                                <input
                                    type="text"
                                    class="campos-formulario"
                                    placeholder="Ingresa tu apellido..."
                                    id="apellidos"
                                    name="apellidos"
                                    required
                                    minlength="2"
                                    maxlength="100"
                                    pattern="[a-záéíóúñ\s\-'áéíóúÁÉÍÓÚÑ]+"
                                    title="Solo se permiten letras">
                            </div>

                            <div class="col-md-6 cont-input">
                                <label class="form-label-custom">Tipo de documento:</label>
                                <select name="tipo_documento" class="campos-formulario" id="tipoDocumento" required>
                                    <option value="">Selecciona tu tipo de documento</option>
                                    <option value="1">Cédula de Ciudadanía</option>
                                    <option value="2">Cédula de Extranjería</option>
                                    <option value="3">Tarjeta de Identidad</option>
                                </select>
                            </div>

                            <div class="col-md-6 cont-input">
                                <label class="form-label-custom">Número de documento:</label>
                                <input
                                    type="text"
                                    class="campos-formulario"
                                    placeholder="xxxxxxxxxx"
                                    id="numeroDocumento"
                                    name="numero_documento"
                                    required
                                    minlength="5"
                                    maxlength="10"
                                    pattern="[0-9]+"
                                    inputmode="numeric"
                                    title="Solo números">
                            </div>

                            <div class="col-md-6 cont-input">
                                <label class="form-label-custom">Email:</label>
                                <input
                                    type="email"
                                    class="campos-formulario"
                                    placeholder="tucorreo@gmail.com"
                                    id="email"
                                    name="email"
                                    required
                                    maxlength="255">
                            </div>

                            <div class="col-md-6 cont-input">
                                <label class="form-label-custom">Teléfono:</label>
                                <input
                                    type="tel"
                                    class="campos-formulario"
                                    placeholder="Ingresa tu número de teléfono..."
                                    id="telefono"
                                    name="telefono"
                                    required
                                    minlength="10"
                                    maxlength="10"
                                    pattern="[0-9]{10}"
                                    inputmode="numeric"
                                    title="El teléfono debe tener exactamente 10 dígitos">
                            </div>

                        </div>


                        <button type="submit" class="btn-azul btn-registrarse-paciente">Registrarse</button>

                    </form>

                    <div class="login-link-container">
                        <a href="login" class="btn-login-link">
                            ¿Ya tienes cuenta? <strong>Inicia sesión</strong>
                        </a>
                    </div>
                </div>

                <div class="image-section col-md-6">
                    <!-- Agrega tu imagen aquí -->
                    <img src="public/assets/auth/img/doctor 3.jpg" alt="Doctor" style=" height: 100%; object-fit: cover;">
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- AOS Animation Library -->
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script src="public/assets/js/validaciones.js"></script>
    <script>
        // Configurar validaciones para el formulario de registro
        configurarValidacionesFormulario('registroForm', {
            'nombre': {
                tipo: 'nombres',
                opciones: {}
            },
            'apellidos': {
                tipo: 'nombres',
                opciones: {}
            },
            'tipoDocumento': {
                tipo: 'select',
                opciones: {
                    nombre: 'tipo de documento'
                }
            },
            'numeroDocumento': {
                tipo: 'documento',
                opciones: {}
            },
            'email': {
                tipo: 'email',
                opciones: {}
            },
            'telefono': {
                tipo: 'telefono',
                opciones: {}
            }
        });
    </script>
    <script src="public/assets/auth/js/registrarse.js"></script>
</body>

</html>