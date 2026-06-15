<?php
// INICIAMOS LA SESIÓN
session_start();

// Importamos las dependencias
require_once __DIR__ . '/../helpers/alert_helper.php';
require_once __DIR__ . '/../helpers/validacion_helper.php';
require_once __DIR__ . '/../models/registroModel.php';

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'POST':
        $accion = $_POST['accion'] ?? '';
        if (isset($_SESSION['user']['id_paciente'])) {
            completarPerfilPaciente($_SESSION['user']['id_paciente']);
        }

        if ($accion === 'registrarPaciente') {
            registrarPaciente();
        }
        break;
    default:
        break;
}

function registrarPaciente()
{
    // CAPTURAMOS LOS DATOS QUE VIENEN A TRAVÉS DEL METHOD POST Y LOS NAME DE LOS CAMPOS
    $nombres = Validaciones::sanitizarString($_POST['nombres'] ?? '');
    $apellidos = Validaciones::sanitizarString($_POST['apellidos'] ?? '');
    $tipo_documento = $_POST['tipo_documento'] ?? '';
    $numero_documento = Validaciones::sanitizarNumero($_POST['numero_documento'] ?? '');
    $email = Validaciones::sanitizarEmail($_POST['email'] ?? '');
    $telefono = Validaciones::sanitizarString($_POST['telefono'] ?? '');

    // VALIDACIONES INDIVIDUALES
    // Validar nombres
    $validacion_nombres = Validaciones::validarNombres($nombres);
    if (!$validacion_nombres['valido']) {
        mostrarSweetAlert('error', 'Error en nombres', $validacion_nombres['mensaje']);
        exit();
    }

    // Validar apellidos
    $validacion_apellidos = Validaciones::validarApellidos($apellidos);
    if (!$validacion_apellidos['valido']) {
        mostrarSweetAlert('error', 'Error en apellidos', $validacion_apellidos['mensaje']);
        exit();
    }

    // Validar tipo de documento
    $validacion_tipo_doc = Validaciones::validarSelect($tipo_documento, 'tipo de documento');
    if (!$validacion_tipo_doc['valido']) {
        mostrarSweetAlert('error', 'Error de validación', $validacion_tipo_doc['mensaje']);
        exit();
    }

    // Validar número de documento
    $validacion_num_doc = Validaciones::validarDocumento($numero_documento, $tipo_documento);
    if (!$validacion_num_doc['valido']) {
        mostrarSweetAlert('error', 'Error en documento', $validacion_num_doc['mensaje']);
        exit();
    }

    // Validar email
    $validacion_email = Validaciones::validarEmail($email);
    if (!$validacion_email['valido']) {
        mostrarSweetAlert('error', 'Error en email', $validacion_email['mensaje']);
        exit();
    }

    // Validar teléfono
    $validacion_telefono = Validaciones::validarTelefono($telefono);
    if (!$validacion_telefono['valido']) {
        mostrarSweetAlert('error', 'Error en teléfono', $validacion_telefono['mensaje']);
        exit();
    }

    // INSTANCIAMOS LA CLASE DEL MODELO
    $objRegistro = new Registro();

    // Verificar que el email no existe ya en la base de datos
    if ($objRegistro->emailExiste($email)) {
        mostrarSweetAlert('error', 'Email duplicado', 'Este email ya está registrado en el sistema');
        exit();
    }

    // Verificar que el documento no existe ya en la base de datos
    if ($objRegistro->documentoExiste($numero_documento)) {
        mostrarSweetAlert('error', 'Documento duplicado', 'Este documento ya está registrado en el sistema');
        exit();
    }

    // CREAMOS UNA VARIABLE LLAMADA DATA PARA ALMACENAR LOS DATOS PARA LUEGO PASARSELOS AL MODELO
    $data = [
        'nombres' => $nombres,
        'apellidos' => $apellidos,
        'tipo_documento' => $tipo_documento,
        'numero_documento' => $numero_documento,
        'email' => $email,
        'telefono' => $telefono
    ];

    $resultado = $objRegistro->registrar($data);

    if ($resultado === true) {
        mostrarSweetAlert('success', 'Registro Exitoso', '¡Te has registrado correctamente! Ahora puedes iniciar sesión.', BASE_URL . '/login');
    } else {
        mostrarSweetAlert('error', 'Error en el Registro', 'Hubo un problema al registrar tus datos. Por favor, intenta nuevamente.');
    }
}

function completarPerfilPaciente($id_paciente)
{
    // CAPTURAMOS LOS DATOS QUE VIENEN A TRAVÉS DEL METHOD POST Y LOS NAME DE LOS CAMPOS
    $fecha_nacimiento = $_POST['fecha_nacimiento'] ?? '';
    $genero = $_POST['genero'] ?? '';
    $ciudad = $_POST['ciudad'] ?? '';
    $direccion = Validaciones::sanitizarString($_POST['direccion'] ?? '');
    $eps = $_POST['eps'] ?? '';
    $rh = $_POST['rh'] ?? '';
    $nombre_contacto = Validaciones::sanitizarString($_POST['nombre_contacto'] ?? '');
    $telefono_contacto = Validaciones::sanitizarString($_POST['telefono_contacto'] ?? '');
    $direccion_contacto = Validaciones::sanitizarString($_POST['direccion_contacto'] ?? '');

    // VALIDACIONES INDIVIDUALES
    // Validar fecha de nacimiento
    $validacion_fecha = Validaciones::validarFechaNacimiento($fecha_nacimiento);
    if (!$validacion_fecha['valido']) {
        mostrarSweetAlert('error', 'Error en fecha', $validacion_fecha['mensaje']);
        exit();
    }

    // Validar ciudad
    $validacion_ciudad = Validaciones::validarCiudad($ciudad);
    if (!$validacion_ciudad['valido']) {
        mostrarSweetAlert('error', 'Error en ciudad', $validacion_ciudad['mensaje']);
        exit();
    }

    // Validar dirección
    $validacion_direccion = Validaciones::validarDireccion($direccion);
    if (!$validacion_direccion['valido']) {
        mostrarSweetAlert('error', 'Error en dirección', $validacion_direccion['mensaje']);
        exit();
    }

    // Validar EPS
    $validacion_eps = Validaciones::validarEPS($eps);
    if (!$validacion_eps['valido']) {
        mostrarSweetAlert('error', 'Error de validación', $validacion_eps['mensaje']);
        exit();
    }

    // Validar RH
    $validacion_rh = Validaciones::validarRH($rh);
    if (!$validacion_rh['valido']) {
        mostrarSweetAlert('error', 'Error en RH', $validacion_rh['mensaje']);
        exit();
    }

    // Validar nombre contacto
    $validacion_nombre_contacto = Validaciones::validarNombres($nombre_contacto);
    if (!$validacion_nombre_contacto['valido']) {
        mostrarSweetAlert('error', 'Error en contacto de emergencia', $validacion_nombre_contacto['mensaje']);
        exit();
    }

    // Validar teléfono contacto
    $validacion_tel_contacto = Validaciones::validarTelefono($telefono_contacto);
    if (!$validacion_tel_contacto['valido']) {
        mostrarSweetAlert('error', 'Error en teléfono de contacto', $validacion_tel_contacto['mensaje']);
        exit();
    }

    // Validar dirección contacto
    $validacion_dir_contacto = Validaciones::validarDireccion($direccion_contacto);
    if (!$validacion_dir_contacto['valido']) {
        mostrarSweetAlert('error', 'Error en dirección de contacto', $validacion_dir_contacto['mensaje']);
        exit();
    }

    // INSTANCIAMOS LA CLASE DEL MODELO
    $objCompletar = new Registro();

    // CREAMOS UNA VARIABLE LLAMADA DATA PARA ALMACENAR LOS DATOS PARA LUEGO PASARSELOS AL MODELO
    $data = [
        'id_paciente' => $id_paciente,
        'fecha_nacimiento' => $fecha_nacimiento,
        'genero' => $genero,
        'ciudad' => $ciudad,
        'direccion' => $direccion,
        'eps' => $eps,
        'rh' => $rh,
        'nombre_contacto' => $nombre_contacto,
        'telefono_contacto' => $telefono_contacto,
        'direccion_contacto' => $direccion_contacto
    ];

    $resultado = $objCompletar->completarPerfilPaciente($data);

    if ($resultado) {
        mostrarSweetAlert('success', 'Perfil Completado', '¡Has completado tu perfil correctamente!', BASE_URL . '/paciente/dashboard');
    } else {
        mostrarSweetAlert('error', 'Error al Completar Perfil', 'Hubo un problema al completar tu perfil. Por favor, intenta nuevamente.');
    }
}
