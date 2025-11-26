<?php
// IMPORTAMOS LAS DEPENDENCIAS NECESARIAS 
require_once __DIR__ . '/../helpers/alert_helper.php';
require_once __DIR__ . '/../models/horarioModel.php';

// CREAMOS LA VARIABLE $method para guardar las peticiones HTTPS

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'POST':
        $accion = $_POST['accion'] ?? '';
        if ($accion === 'actualizar') {
            actualizarHorario();
        }
        else {
            registrarHorario();
        }
        
        break;
    case 'GET':
        if (isset($_GET['id'])) {
            listarHorarioPorId($_GET['id']);
        } else {
            mostrarHorarios();
        }
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
    } else {
        mostrarSweetAlert('error', 'Error al registrar', 'No se pudo registrar una nueva disponibilidad');
    }
    exit();
}

function mostrarHorarios()
{
    // INSTANCIAMOS NUESTRA CLASE HORARIO
    $objhorario = new Horario();

    // ACCEDEMOS AL MÉTODO ESPECÍFICO
    $resultado = $objhorario->mostrar();

    return $resultado;
}

function listarHorarioPorId($id)
{
    // INSTANCIAMOS NUESTRA CLASE HORARIO

    $objhorario = new Horario();

    // ACCEDEMOS AL MÉTODO ESPECÍFICO
    $resultado = $objhorario->listarHorarioPorId($id);

    return $resultado;
}

function actualizarHorario()
{
    // GUARDAMOS EN VARIABLES LO QUE VIENE DE LOS NAME DE LOS CAMPOS A TRAVÉS DEL METHOD POST
    $id = $_POST['id'] ?? '';
    $diaSemana = $_POST['dia_semana'] ?? '';
    $capacidadCitas = $_POST['capacidad_citas'] ?? '';
    $horaInicio = $_POST['hora_inicio'] ?? '';
    $horaFin = $_POST['hora_fin'] ?? '';
    $inicioDescanso = $_POST['inicio_descanso'] ?? '';
    $finDescanso = $_POST['fin_descanso'] ?? '';
    $estado = $_POST['estado'] ?? '';

    // VALIDAMOS LOS CAMPOS OBLIGATORIOS
    if (empty($diaSemana) || empty($capacidadCitas) || empty($horaInicio) || empty($horaFin)) {
        mostrarSweetAlert('error', 'Campos vacíos', 'Por favor completar los campos obligatorios');
        exit();
    }

    // PROGRAMACIÓN ORIENTADA A OBJETOS - INSTANCIAMOS NUESTRA CLASE HORARIO
    $objhorario = new Horario();

    // CREAMOS LA VARIABLE DATA PARA INGRESAR TODOS LOS DATOS QUE VIENEN A TRAVÉS DE METHOD POST
    $data = [
        'id' => $id,
        'diaSemana' => $diaSemana,
        'capacidadCitas' => $capacidadCitas,
        'horaInicio' => $horaInicio,
        'horaFin' => $horaFin,
        'inicioDescanso' => $inicioDescanso,
        'finDescanso' => $finDescanso,
        'estado' => $estado
    ];

    // ACCEDEMOS AL MÉTODO EN ESPECÍFICO QUE VAMOS A UTILIZAR
    $resultado = $objhorario->actualizar($data);

    // Si la respuesta del modelo es verdadera confirmamos el registro y redireccionamos
    // Si es falsa notificamos y redirecciomamos
    if ($resultado === true) {
        mostrarSweetAlert('success', 'Modificación exitosa', 'Se ha Modificado la disponibilidad', '/E-VITALIX/admin/horarios');
    } else {
        mostrarSweetAlert('error', 'Error al Modificar', 'No se pudo modificar la disponibilidad');
    }
    exit();
}
