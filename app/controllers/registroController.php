<?php
// INICIAMOS LA SESIÓN
session_start();

// Importamos las dependencias
require_once __DIR__ . '/../helpers/alert_helper.php';
require_once __DIR__ . '/../models/registroModel.php';

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'POST':
        if (isset($_SESSION['user']['id_paciente'])) {
            completarPerfilPaciente($_SESSION['user']['id_paciente']);
        } else {
            registrarPaciente();
        }
        break;



    default:

        break;
}


function registrarPaciente()
{
    // CAPTURAMOS LOS DATOS QUE VIENEN A TRAVÉS DEL METHOD POST Y LOS NAME DE LOS CAMPOS
    $nombres = $_POST['nombres'] ?? '';
    $apellidos = $_POST['apellidos'] ?? '';
    $tipo_documento = $_POST['tipo_documento'] ?? '';
    $numero_documento = $_POST['numero_documento'] ?? '';
    $email = $_POST['email'] ?? '';
    $telefono = $_POST['telefono'] ?? '';


    // VALIDAMOS LOS CAMPOS OBLIGATORIOS
    if (empty($nombres) || empty($apellidos) || empty($tipo_documento) || empty($numero_documento) || empty($email) || empty($telefono)) {
        mostrarSweetAlert('error', 'Campos vacíos', 'Por favor completar los campos obligatorios');
        exit();
    }


    // INSTANCIAMOS LA CLASE DEL MODELO
    $objRegistro = new Registro();

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

    if ($resultado) {
        mostrarSweetAlert('success', 'Registro Exitoso', '¡Te has registrado correctamente! Ahora puedes iniciar sesión.', '/E-VITALIX/login');
    } else {
        mostrarSweetAlert('error', 'Error en el Registro', 'Hubo un problema al registrar tus datos. Por favor, intenta nuevamente.');
    }
}

function completarPerfilPaciente($id_paciente) {
    // CAPTURAMOS LOS DATOS QUE VIENEN A TRAVÉS DEL METHOD POST Y LOS NAME DE LOS CAMPOS
    $fecha_nacimiento = $_POST['fecha_nacimiento'] ?? '';
    $genero = $_POST['genero'] ?? '';
    $ciudad = $_POST['ciudad'] ?? '';
    $direccion = $_POST['direccion'] ?? '';
    $eps = $_POST['eps'] ?? '';
    $rh = $_POST['rh'] ?? '';
    $historial_medico = $_POST['historial_medico'] ?? '';
    $nombre_contacto = $_POST['nombre_contacto'] ?? '';
    $telefono_contacto = $_POST['telefono_contacto'] ?? '';
    $direccion_contacto = $_POST['direccion_contacto'] ?? '';


    // VALIDAMOS LOS CAMPOS OBLIGATORIOS
    if (empty($fecha_nacimiento) || empty($genero) || empty($ciudad) || empty($direccion) || empty($eps) || empty($rh) || empty($nombre_contacto) || empty($telefono_contacto) || empty($direccion_contacto)) {
        mostrarSweetAlert('error', 'Campos vacíos', 'Por favor completar los campos obligatorios');
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
        'historial_medico' => $historial_medico,
        'nombre_contacto' => $nombre_contacto,
        'telefono_contacto' => $telefono_contacto,
        'direccion_contacto' => $direccion_contacto
    ];

    $resultado = $objCompletar->completarPerfilPaciente($data);

    if ($resultado) {
        mostrarSweetAlert('success', 'Perfil Completado', '¡Has completado tu perfil correctamente!', '/E-VITALIX/paciente/dashboard');
    } else {
        mostrarSweetAlert('error', 'Error al Completar Perfil', 'Hubo un problema al completar tu perfil. Por favor, intenta nuevamente.');
    }
}
