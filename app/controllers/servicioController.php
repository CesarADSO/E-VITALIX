<?php
require_once __DIR__ . '/../helpers/alert_helper.php';
require_once __DIR__ . '/../models/servicioModel.php';


$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'POST':
        $accion = $_POST['accion'] ?? '';

        if ($accion === 'actualizar') {
            actualizarServicio();
        } else {
            registrarServicio();
        }
        break;

    case 'GET':
        $accion = $_GET['accion'] ?? '';

        if ($accion === 'eliminar') {
            eliminarServicio($_GET['id']);
        }

        if (isset($_GET['id'])) {
            listarServicio($_GET['id']);
        } else {
            mostrarServicios();
        }

        break;

    default:
        http_response_code(405);
        echo "Metodo no permitido";
        break;
}


function registrarServicio()
{
    // CAPTURAMOS LOS DATOS DEL FORMULARIO
    $nombre = $_POST['nombre'] ?? '';
    $descripcion = $_POST['descripcion'] ?? '';
    $codigoServicio = $_POST['codigo_servicio'] ?? '';
    $idEspecialista = $_POST['id_especialista'] ?? '';
    $duracion = $_POST['duracion_minutos'] ?? '';
    $precio = $_POST['precio'] ?? '';
    $idMetodoPago = $_POST['id_metodo_pago'] ?? '';

    // VALIDAMOS CAMPOS OBLIGATORIOS
    if (empty($nombre) || empty($idEspecialista) || empty($duracion) || empty($idMetodoPago)) {
        mostrarSweetAlert('error', 'Campos obligatorios', 'Por favor completa los campos requeridos');
        exit();
    }

    // INICIAR O REANUDAR LA SESIÓN PARA OBTENER LOS DATOS DEL USUARIO
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }

    // INSTANCIAMOS EL MODELO
    $objServicio = new Servicio();

    // TRAEMOS EL ID DEL CONSULTORIO DEL ADMINISTRADOR QUE INICIÓ SESIÓN
    $id_consultorio = $_SESSION['user']['id_consultorio'] ?? null;

    // AGREGAMOS UNA VALIDACIÓN POR SI NO SE LOGRÓ TRAER EL ID DEL CONSULTORIO
    if (empty($id_consultorio)) {
        mostrarSweetAlert('error', 'Error al traer el id del consultorio', 'Está vacio');
        exit();
    }

    // ARMAMOS EL ARREGLO DE DATOS
    $data = [
        'nombre' => $nombre,
        'descripcion' => $descripcion,
        'codigo_servicio' => $codigoServicio,
        'id_especialista' => $idEspecialista,
        'duracion_minutos' => $duracion,
        'precio' => $precio,
        'id_metodo_pago' => $idMetodoPago,
        'id_consultorio' => $id_consultorio
    ];

    // LLAMAMOS AL MODELO
    $resultado = $objServicio->registrar($data);

    if ($resultado === true) {
        mostrarSweetAlert(
            'success',
            'Registro exitoso',
            'El servicio fue registrado correctamente',
            '/E-VITALIX/admin/servicios'
        );
    } else {
        mostrarSweetAlert(
            'error',
            'Error',
            'No se pudo registrar el servicio. Intenta nuevamente'
        );
    }
    exit();
}

function mostrarServicios()
{
    // REANUDAMOS LA SESIÓN
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }

    $id_consultorio = $_SESSION['user']['id_consultorio'] ?? null;

    // INSTANCIAMOS EL MODELO
    $objServicio = new Servicio();

    // LLAMAMOS AL MODELO
    $resultado = $objServicio->mostrar($id_consultorio);

    return $resultado;
}

function listarServicio($id)
{

    $objServicio = new Servicio();

    $resultado = $objServicio->listarServicio($id);


    return $resultado;
}

function actualizarServicio()
{
    $id = $_POST['id'] ?? '';
    $descripcion = $_POST['descripcion'] ?? '';
    $duracion = $_POST['duracion_minutos'] ?? '';
    $precio = $_POST['precio'] ?? '';
    $idMetodoPago = $_POST['id_metodo_pago'] ?? '';
    $estado = $_POST['estado'] ?? '';

    // VALIDAMOS CAMPOS OBLIGATORIOS
    if (empty($descripcion) || empty($precio) || empty($duracion) || empty($idMetodoPago)) {
        mostrarSweetAlert('error', 'Campos obligatorios', 'Por favor completa los campos requeridos');
        exit();
    }

    // INSTANCIAMOS EL MODELO
    $objServicio = new Servicio();

    $data = [
        'id' => $id,
        'descripcion' => $descripcion,
        'duracion_minutos' => $duracion,
        'precio' => $precio,
        'id_metodo_pago' => $idMetodoPago,
        'estado' => $estado
    ];

    $resultado = $objServicio->actualizar($data);

    if ($resultado === true) {
        mostrarSweetAlert(
            'success',
            'Modificación exitosa',
            'El servicio fue modificado correctamente',
            '/E-VITALIX/admin/servicios'
        );
    } else {
        mostrarSweetAlert('error', 'Error al modificar', 'No se pudo modificar el servicio. Intenta nuevamente');
    }
}

function eliminarServicio($id)
{

    $objServicio = new Servicio();

    $resultado = $objServicio->eliminar($id);

    if ($resultado === true) {
        mostrarSweetAlert(
            'success',
            'Eliminación exitosa',
            'El servicio fue eliminado correctamente',
            '/E-VITALIX/admin/servicios'
        );
    } else {
        mostrarSweetAlert('error', 'Error al eliminar', 'No se pudo eliminar el servicio. Intenta nuevamente');
    }
}
