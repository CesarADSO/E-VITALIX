<?php
// IMPORTAMOS LAS DEPENDENCIAS NECESARIAS 
require_once __DIR__ . '/../helpers/alert_helper.php';
require_once __DIR__ . '/../models/horarioModel.php';

// CREAMOS LA VARIABLE $method para guardar las peticiones HTTPS

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'POST':
        registrarHorario();
        break;
    case 'GET':

        break;
}

function registrarHorario()
{
    // GUARDAMOS EN VARIABLES LOS VALORES QUE NOS ENVIAN A TRAVÉS DEL METHOD POST Y LOS NAME DE LOS CAMPOS
    $idEspecialista = $_POST['idEspecialista'] ?? '';
    $idConsultorio = $_POST['idConsultorio'] ?? '';
    $diaSemana = $_POST['dia_semana'] ?? '';
    $capacidadMaxima = $_POST['capacidad_citas'] ?? '';
    $horaInicio = $_POST['hora_inicio'] ?? '';
    $horaFin = $_POST['hora_fin'] ?? '';
    $inicioDescanso = $_POST['inicio_descanso'] ?? '';
    $finDescanso = $_POST['fin_descanso'] ?? '';


    // VALIDAMOS LOS CAMPOS OBLIGATORIOS
    if (empty($idEspecialista) || empty($idConsultorio) || empty($diaSemana) || empty($capacidadMaxima) || empty($horaInicio) || empty($horaFin)) {
        mostrarSweetAlert('error', 'Campos vacíos', 'Por favor completar los campos obligatorios');
        exit();
    }

    // POO - INSTANCIAMOS LA CLASE DE NUESTRO MODELO
    $objhorario = new Horario();

    $data = [
        'idEspecialista' => $idEspecialista,
        'idConsultorio' => $idConsultorio,
        'diaSemana' => $diaSemana,
        'capacidadMaxima' => $capacidadMaxima,
        'horaInicio' => $horaInicio,
        'horaFin' => $horaFin,
        'inicioDescanso' => $inicioDescanso,
        'finDescanso' => $finDescanso
    ];

    // ACCEDEMOS AL MÉTODO ESPECÍFICO DE DICHA CLASE
    $resultado = $objhorario->registrar($data);

    // Si la respuesta del modelo es verdadera confirmamos el registro y redireccionamos
    // Si es falsa notificamos y redirecciomamos
    if ($resultado === true) {
        mostrarSweetAlert('success', 'Registro exitoso', 'Se ha registrado una nueva disponibilidad', '/E-VITALIX/admin/horarios');
    }
    else {
        mostrarSweetAlert('error', 'Error al registrar', 'No se pudo registrar una nueva disponibilidad');
    }
    exit();
}
