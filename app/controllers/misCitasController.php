<?php
require_once __DIR__ . '/../models/CitasModel.php';
require_once __DIR__ . '/../helpers/session_especialista.php';
require_once __DIR__ . '/../helpers/alert_helper.php';

$method = $_SERVER['REQUEST_METHOD'];
switch ($method) {
    case 'GET':
        $accion = $_GET['accion'] ?? '';
        if ($accion === 'aceptar') {
            aceptarCita($_GET['id']);
        }
        elseif ($accion === 'cancelar') {
            cancelarCita($_GET['id']);
        }
        elseif (isset($_GET['id_cita']) && isset($_GET['id_paciente'])) {
            obtenerIdCitaYPaciente($_GET['id_cita'], $_GET['id_paciente']);
        }
        break;
    
    default:
        # code...
        break;
}

/**
 * Función para mostrar la vista de Mis Citas
 */
function mostrarMisCitas()
{
    // Verificar que el usuario sea especialista
    if (!isset($_SESSION['user']) || $_SESSION['user']['rol'] != 3) {
        header('Location: ' . BASE_URL . '/login');
        exit();
    }

    $id_especialista = $_SESSION['user']['id_especialista'];

    // Instanciar el modelo
    $citasModel = new CitasModel();

    // Obtener las citas del especialista
    $citas = $citasModel->obtenerCitasPorEspecialista($id_especialista);

    // Obtener estadísticas
    $estadisticas = $citasModel->contarCitasPorEstado($id_especialista);

    // DEBUG TEMPORAL - Eliminar después de verificar
    if (isset($_GET['debug'])) {
        echo "<h2>DEBUG - Controlador</h2>";
        echo "<h3>ID Especialista:</h3>";
        echo "<pre>";
        var_dump($id_especialista);
        echo "</pre>";
        echo "<h3>Estadísticas:</h3>";
        echo "<pre>";
        print_r($estadisticas);
        echo "</pre>";
        echo "<h3>Total Citas:</h3>";
        echo "<pre>";
        echo count($citas);
        echo "</pre>";
        echo "<h3>Primeras 3 citas:</h3>";
        echo "<pre>";
        print_r(array_slice($citas, 0, 3));
        echo "</pre>";
        exit();
    }

    // Incluir la vista
    require_once __DIR__ . '/../views/dashboard/especialista/mis_citas_especialista.php';
}


function actualizarEstadoCita()
{
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        echo json_encode(['success' => false, 'message' => 'Método no permitido']);
        return;
    }

    if (!isset($_SESSION['user']) || $_SESSION['user']['rol'] != 3) {
        echo json_encode(['success' => false, 'message' => 'No autorizado']);
        return;
    }

    $idCita = $_POST['id_cita'] ?? null;
    $estado = $_POST['estado'] ?? null;

    if (!$idCita || !$estado) {
        echo json_encode(['success' => false, 'message' => 'Datos incompletos']);
        return;
    }

    require_once __DIR__ . '/../models/CitasModel.php';
    $model = new CitasModel();

    $ok = $model->actualizarEstadoCita($idCita, $estado, $_SESSION['user']['id_especialista']);

    echo json_encode([
        'success' => $ok,
        'message' => $ok ? 'Estado actualizado correctamente' : 'No se pudo actualizar'
    ]);
};


/**
 * Procesar actualización de estado de cita (AJAX)
 */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    // Validar sesión
    if (!isset($_SESSION['user']) || $_SESSION['user']['rol'] != 3) {
        echo json_encode([
            'success' => false,
            'message' => 'Sesión inválida o permisos insuficientes'
        ]);
        exit();
    }

    $action = $_POST['action'];
    $id_especialista = $_SESSION['user']['id_especialista'];
    $citasModel = new CitasModel();

    switch ($action) {
        case 'actualizar_estado':
            $id_cita = isset($_POST['id_cita']) ? (int)$_POST['id_cita'] : 0;
            $nuevo_estado = isset($_POST['estado']) ? trim($_POST['estado']) : '';

            // Validar datos
            if ($id_cita <= 0 || empty($nuevo_estado)) {
                echo json_encode([
                    'success' => false,
                    'message' => 'Datos inválidos'
                ]);
                exit();
            }

            // Validar que el estado sea válido
            $estados_validos = ['CONFIRMADA', 'CANCELADA', 'RECHAZADA'];
            if (!in_array($nuevo_estado, $estados_validos)) {
                echo json_encode([
                    'success' => false,
                    'message' => 'Estado no válido'
                ]);
                exit();
            }

            // Actualizar estado
            $resultado = $citasModel->actualizarEstadoCita($id_cita, $nuevo_estado, $id_especialista);
            echo json_encode($resultado);
            break;

        case 'obtener_detalle':
            $id_cita = isset($_POST['id_cita']) ? (int)$_POST['id_cita'] : 0;

            if ($id_cita <= 0) {
                echo json_encode([
                    'success' => false,
                    'message' => 'ID de cita inválido'
                ]);
                exit();
            }

            $detalle = $citasModel->obtenerDetalleCita($id_cita, $id_especialista);

            if ($detalle) {
                echo json_encode([
                    'success' => true,
                    'data' => $detalle
                ]);
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'Cita no encontrada'
                ]);
            }
            break;

        default:
            echo json_encode([
                'success' => false,
                'message' => 'Acción no reconocida'
            ]);
            break;
    }
    exit();
}


function aceptarCita($id) {
    // INSTANCIAMOS EL MODELO
    $objCita = new CitasModel();


    // ACCEDEMOS AL METHOD DE LA CLASE
    $resultado = $objCita->aceptarCita($id);

    // ESPERAMOS UNA RESPUESTA BOOLEANA DEL MODELO
    if ($resultado === true) {
         mostrarSweetAlert('success', 'Cita aceptada exitosamente', 'La cita ha sido aceptada', '/E-VITALIX/especialista/mis-citas');
    }
    else {
        mostrarSweetAlert('error', 'Error al aceptar la cita', 'No se pudo aceptar la cita', '/E-VITALIX/especialista/mis-citas');
    }
}

function cancelarCita($id) {
    // INSTANCIAMOS EL MODELO
    $objCita = new CitasModel();

    // ACCEDEMOS AL METHOD DE LA CLASE
    $resultado = $objCita->cancelarCita($id);

    // ESPERAMOS UNA RESPUESTA BOOLEANA DEL MODELO
    if ($resultado === true) {
         mostrarSweetAlert('success', 'Cita cancelada exitosamente', 'La cita ha sido cancelada', '/E-VITALIX/especialista/mis-citas');
    }
    else {
        mostrarSweetAlert('error', 'Error al cancelar la cita', 'No se pudo cancelar la cita', '/E-VITALIX/especialista/mis-citas');
    }
}

function obtenerIdCitaYPaciente($id_cita, $id_paciente) {
    // INSTANCIAMOS EL MODELO
    $objCita = new CitasModel();

    // ACCEDEMOS AL METHOD DE LA CLASE
    $resultado = $objCita->obtenerIdCita($id_cita, $id_paciente);

    return $resultado;
}