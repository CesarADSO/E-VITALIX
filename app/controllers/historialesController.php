<?php
require_once __DIR__ . '/../helpers/alert_helper.php';
require_once __DIR__ . '/../models/historialesModel.php';

$method = $_SERVER['REQUEST_METHOD'];
switch ($method) {
    case 'GET':
        if (isset($_GET['id_paciente'])) {
            consultarHistorialClinicoPaciente($_GET['id_paciente']);
        } else {
            mostrarPacientesConConsulta();
        }
        break;

    default:
        # code...
        break;
}

function mostrarPacientesConConsulta()
{

    // INSTANCIAMOS LA CLASE 
    $historiales = new Historiales();

    // REANUDAMOS LA SESIÓN DE FORMA SEGURA
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    // OBTENEMOS EL ID DEL ESPECIALISTA 
    $id_especialista = $_SESSION['user']['id_especialista'];


    // ACCEDEMOS AL MÉTODO DE LA CLASE HISTORIALES
    $resultado = $historiales->ConsultarPacienteConConsulta($id_especialista);

    return $resultado;
}




function consultarHistorialClinicoPaciente($id_paciente)
{
    // INSTANCIAMOS EL MODELO
    $objHistorial = new Historiales();

    return [
        'paciente'   => $objHistorial->consultarInfoPaciente($id_paciente),
        'historial'  => $objHistorial->consultarHistorialClinicoPaciente($id_paciente)
    ];
}
