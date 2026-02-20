<?php
// IMPORTAMOS LAS DEPENDENCIAS NECESARIAS
require_once BASE_PATH . '/app/helpers/alert_helper.php';
require_once BASE_PATH . '/app/models/consultaMedicaModel.php';

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {

    case 'POST':
        registrarConsultaMedica();
        break;

    // case 'GET':
    //     mostrarFormularioConsultaMedica($_GET['id_cita'], $_GET['id_paciente']);
    //     break;

    default:
        # code...
        break;
}

// function mostrarFormularioConsultaMedica($id_cita, $id_paciente)
// {
//     // INCLUIMOS LA VISTA DEL FORMULARIO DE REGISTRO DE CONSULTA MÉDICA
//     include_once BASE_PATH . '/app/views/dashboard/especialista/registrar_consulta.php';
// }

function registrarConsultaMedica()
{

    // GUARDAMOS EN VARIABLES LOS DATOS QUE SE VAN A ENVIAR A TRAVÉS DEL METHOD POST Y LOS NAME DE LOS CAMPOS
    $id_cita = $_POST['id_cita'] ?? '';
    $id_paciente = $_POST['id_paciente'] ?? '';
    $motivo_consulta = $_POST['motivo_consulta'] ?? '';
    $sintomas = $_POST['sintomas'] ?? '';
    $diagnostico = $_POST['diagnostico'] ?? '';
    $tratamiento = $_POST['tratamiento'] ?? '';
    $presion_sistolica = $_POST['presion_sistolica'] ?? '';
    $presion_diastolica = $_POST['presion_diastolica'] ?? '';
    $temperatura = $_POST['temperatura'] ?? '';
    $frecuencia_cardiaca = $_POST['frecuencia_cardiaca'] ?? '';
    $frecuencia_respiratoria = $_POST['frecuencia_respiratoria'] ?? '';
    $observaciones = $_POST['observaciones'] ?? '';
    $medicamento = $_POST['medicamento'] ?? '';
    $dosis = $_POST['dosis'] ?? '';
    $frecuencia = $_POST['frecuencia'] ?? '';
    $duracion = $_POST['duracion'] ?? '';

    // VALIDAMOS LOS CAMPOS OBLIGATORIOS
    if (empty($motivo_consulta) || empty($sintomas) || empty($diagnostico) || empty($tratamiento) || empty($presion_sistolica) || empty($presion_diastolica) || empty($temperatura) || empty($frecuencia_cardiaca) || empty($frecuencia_respiratoria)) {
        mostrarSweetAlert('error', 'Campos vacios','Por favor llene todos los campos');
        exit();
    }

    // Iniciar o reanudar sesión de forma segura y obtener datos del usuario
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }

    // OBTENEMOS EL ID DEL ESPECIALISTA QUE ESTÁ LOGUEADO Y REALIZANDO LA CONSULTA
    $id_especialista = $_SESSION['user']['id_especialista'] ?? null;
    

    // INSTANCIAMOS LA CLASE DEL MODELO
    $objConsultaMedica = new ConsultaMedica();

    // EN UNA VARIABLE-ARREGLO DATA GUARDAMOS TODOS LOS DATOS QUE VAMOS A ENVIAR AL MODELO
    $data = [
        'id_cita' => $id_cita,
        'id_paciente' => $id_paciente,
        'id_especialista' => $id_especialista,
        'motivo_consulta' => $motivo_consulta,
        'sintomas' => $sintomas,
        'diagnostico' => $diagnostico,
        'tratamiento' => $tratamiento,
        'presion_sistolica' => $presion_sistolica,
        'presion_diastolica' => $presion_diastolica,
        'temperatura' => $temperatura,
        'frecuencia_cardiaca' => $frecuencia_cardiaca,
        'frecuencia_respiratoria' => $frecuencia_respiratoria,
        'observaciones' => $observaciones,
        'medicamento' => $medicamento,
        'dosis' => $dosis,
        'frecuencia' => $frecuencia,
        'duracion' => $duracion
    ];

    // ACCEDEMOS AL MÉTODO DEL MODELO
    $resultado = $objConsultaMedica->registrarConsultaMedica($data);


    // ESPERAMOS UNA RESPUESTA BOOLEANA DEL MODELO
    if ($resultado === true) {
        mostrarSweetAlert('success', 'Consulta registrada exitosamente', 'La consulta médica ha sido registrada', '/E-VITALIX/especialista/mis-citas');
    } else {
        mostrarSweetAlert('error', 'Error al registrar la consulta', 'No se pudo registrar la consulta médica', '/E-VITALIX/especialista/mis-citas');
    }
}


