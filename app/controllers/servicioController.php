<?php
require_once __DIR__ . '/../helpers/alert_helper.php';
require_once __DIR__ . '/../models/servicioModel.php';


$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'POST':
        registrarServicio();
        break;

    case 'GET':
        // mostrarServicios();
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

    // INSTANCIAMOS EL MODELO
    $objServicio = new Servicio();

    // TRAEMOS EL ID DEL CONSULTORIO DEL ADMINISTRADOR QUE INICIÓ SESIÓN
    $id_consultorio = $_SESSION['user']['id_consultorio'] ?? null;

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
