<?php
require_once __DIR__ . '/../helpers/alert_helper.php';
require_once __DIR__ . '/../models/especialidadModel.php';





$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'POST':
        registrarEspecialidad();
        break;

    case 'GET':
        $accion = $_GET['accion'] ?? '';
        if ($accion === 'modificarEstado') {
            modificarEstadoEspecialidad($_GET['id']);
        }
        listarEspecialidades();
        break;

    default:
        # code...
        break;
}

function registrarEspecialidad()
{

    // GUARDAMOS EN VARIABLES LOS DATOS QUE VIENEN EN METHOD POST Y LOS NAME DE LOS CAMPOS
    $nombre = $_POST['nombre'] ?? '';
    $descripcion = $_POST['descripcion'] ?? '';

    // VALIDAMOS LOS CAMPOS QUE SON OBLIGATORIOS
    if (empty($nombre) || empty($descripcion)) {
        mostrarSweetAlert('error', 'Campos vacíos', 'Por favor completar los campos obligatorios');
        exit();
    }

    // Iniciar o reanudar sesión de forma segura y obtener datos del usuario
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }


    // OBTENEMOS EL ID DEL CONSULTORIO
    $id_consultorio = $_SESSION['user']['id_consultorio'];

    // INSTANCIAMOS LA CLASE
    $objEspecialidad = new Especialidad();

    $data = [
        'id_consultorio' => $id_consultorio,
        'nombre' => $nombre,
        'descripcion' => $descripcion
    ];

    // ACCEDEMOS AL MÉTODO DE LA CLASE
    $resultado = $objEspecialidad->registrar($data);

    // Si la respuesta del modelo es verdadera confirmamos el registro y redireccionamos
    // Si es falsa notificamos y redirecciomamos
    if ($resultado === true) {
        mostrarSweetAlert('success', 'Registro de Especialidad exitoso', 'Se ha creado un nueva especialidad', '/E-VITALIX/admin/especialidades');
    } else {
        mostrarSweetAlert('error', 'Error al registrar', 'No se puedo registrar la especialidad. Intenta nuevamente');
    }
    exit();
}

function listarEspecialidades()
{

    // Iniciar o reanudar sesión de forma segura y obtener datos del usuario
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }


    $id_consultorio = $_SESSION['user']['id_consultorio'] ?? null;

    $objEspecialidad = new Especialidad();

    $resultado = $objEspecialidad->listar($id_consultorio);

    return $resultado;
}

function modificarEstadoEspecialidad($id)
{
    // INSTANCIAMOS LA CLASE Especialidad del modelo especialidadModel.php
    $objEspecialidad = new Especialidad();

    // ACCEDEMOS AL MÉTODO modificarEstado DE LA CLASE Especialidad
    $resultado = $objEspecialidad->modificarEstado($id);

    // ESPERAMOS UNA RESPUESTA BOOLEANA DEL MODELO PARA CONFIRMAR LA MODIFICACIÓN DEL ESTADO O INFORMAR UN ERROR
    if ($resultado === true) {
        mostrarSweetAlert('success', 'Modificación de estado exitosa', 'Se ha modificado el estado de la especialidad', '/E-VITALIX/admin/especialidades');
    } else {
        mostrarSweetAlert('error', 'Error al Modificar', 'No se pudo modificar el estado de la especialidad. Intenta nuevamente');
    }
}
