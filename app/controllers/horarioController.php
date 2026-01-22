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
        } else {
            registrarHorario();
        }

        break;
    case 'GET':

        $accion = $_GET['accion'] ?? '';
        if ($accion === 'eliminar') {
            eliminarHorario($_GET['id']);
        }

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
    $dias = $_POST['dias'] ?? [];
    $capacidadMaxima = $_POST['capacidad_citas'] ?? '';
    $horaInicio = $_POST['hora_inicio'] ?? '';
    $horaFin = $_POST['hora_fin'] ?? '';
    $inicioDescanso = $_POST['inicio_descanso'] ?? '';
    $finDescanso = $_POST['fin_descanso'] ?? '';
    $duracionCita = $_POST['duracion_cita'] ?? '';


    // VALIDAMOS LOS CAMPOS OBLIGATORIOS
    if (empty($dias) || empty($capacidadMaxima) || empty($horaInicio) || empty($horaFin) || empty($duracionCita)) {
        mostrarSweetAlert('error', 'Campos vacíos', 'Por favor completar los campos obligatorios');
        exit();
    }

    // Convertimos el arreglo de dias a JSON manteniendo acentos, eñes y caracteres especiales tal cual,
    // evitando que se conviertan en códigos Unicode como \u00f1 (JSON_UNESCAPED_UNICODE mejora la legibilidad).D
    $dias_json = json_encode($dias, JSON_UNESCAPED_UNICODE);

    // Iniciar o reanudar sesión de forma segura y obtener datos del usuario
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }

    // Obtenemos el id del especialista cuando inicia sesión
    $id_especialista = $_SESSION['user']['id_especialista'] ?? null;


    // ID del consultorio asignado al especialista (puede ser null si no aplica)
    $id_consultorio = $_SESSION['user']['id_consultorio'] ?? null;

    // POO - INSTANCIAMOS LA CLASE DE NUESTRO MODELO
    $objhorario = new Horario();

    $data = [
        'id_especialista' => $id_especialista,
        'id_consultorio' => $id_consultorio,
        'dias' => $dias_json,
        'capacidadMaxima' => $capacidadMaxima,
        'horaInicio' => $horaInicio,
        'horaFin' => $horaFin,
        'inicioDescanso' => $inicioDescanso,
        'finDescanso' => $finDescanso,
        'duracion_cita' => $duracionCita
    ];

    // ACCEDEMOS AL MÉTODO ESPECÍFICO DE DICHA CLASE
    $resultado = $objhorario->registrar($data);

    // Si la respuesta del modelo es verdadera confirmamos el registro y redireccionamos
    // Si es falsa notificamos y redirecciomamos
    if ($resultado === true) {
        mostrarSweetAlert('success', 'Registro exitoso', 'Se registró tu disponibilidad', '/E-VITALIX/especialista/disponibilidad');
    } else {
        mostrarSweetAlert('error', 'Error al registrar', 'No se pudo registrar tu disponibilidad');
    }
    exit();
}

function mostrarHorarios()
{   
    // Iniciar o reanudar sesión de forma segura y obtener datos del usuario
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }

    // Obtenemos el id del especialista cuando inicia sesión
    $id_especialista = $_SESSION['user']['id_especialista'] ?? null;

    // INSTANCIAMOS NUESTRA CLASE HORARIO
    $objhorario = new Horario();

    // ACCEDEMOS AL MÉTODO ESPECÍFICO
    $resultado = $objhorario->mostrarParaElEspecialista($id_especialista);

    return $resultado;
}

function listarHorarioPorId($id)
{
    // INSTANCIAMOS NUESTRA CLASE HORARIO

    $objhorario = new Horario();

    // ACCEDEMOS AL MÉTODO ESPECÍFICO
    $resultado = $objhorario->listarHorarioPorId($id);

    // Decodificamos el JSON de días a un array
    $diasSeleccionados = json_decode($resultado['dia_semana'], true);

    // Agregamos el array al resultado para usarlo en la vista
    $resultado['diasSeleccionados'] = $diasSeleccionados;
    

    return $resultado;
}

function actualizarHorario()
{
    // GUARDAMOS EN VARIABLES LO QUE VIENE DE LOS NAME DE LOS CAMPOS A TRAVÉS DEL METHOD POST
    $id = $_POST['id'] ?? '';
    $dias = $_POST['dias'] ?? [];
    $capacidadCitas = $_POST['capacidad_citas'] ?? '';
    $horaInicio = $_POST['hora_inicio'] ?? '';
    $horaFin = $_POST['hora_fin'] ?? '';
    $inicioDescanso = $_POST['inicio_descanso'] ?? '';
    $finDescanso = $_POST['fin_descanso'] ?? '';
    $estado = $_POST['estado'] ?? '';

    // VALIDAMOS LOS CAMPOS OBLIGATORIOS
    if (empty($dias) || empty($capacidadCitas) || empty($horaInicio) || empty($horaFin)) {
        mostrarSweetAlert('error', 'Campos vacíos', 'Por favor completar los campos obligatorios');
        exit();
    }

    // Convertimos el arreglo de dias a JSON manteniendo acentos, eñes y caracteres especiales tal cual,
    // evitando que se conviertan en códigos Unicode como \u00f1 (JSON_UNESCAPED_UNICODE mejora la legibilidad).D
    $dias_json = json_encode($dias, JSON_UNESCAPED_UNICODE);

    // PROGRAMACIÓN ORIENTADA A OBJETOS - INSTANCIAMOS NUESTRA CLASE HORARIO
    $objhorario = new Horario();

    // CREAMOS LA VARIABLE DATA PARA INGRESAR TODOS LOS DATOS QUE VIENEN A TRAVÉS DE METHOD POST
    $data = [
        'id' => $id,
        'dias' => $dias_json,
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
        mostrarSweetAlert('success', 'Modificación exitosa', 'Se ha modificado la disponibilidad', '/E-VITALIX/especialista/disponibilidad');
    } else {
        mostrarSweetAlert('error', 'Error al modificar', 'No se pudo modificar la disponibilidad');
    }
    exit();
}

function eliminarHorario($id)
{

    // INSTANCIAMOS NUESTRA CLASE HORARIO
    $objhorario = new Horario();

    // ACCEDEMOS AL MÉTODO ESPECÍFICO
    $resultado = $objhorario->eliminar($id);

    // Si la respuesta del modelo es verdadera confirmamos el registro y redireccionamos
    // Si es falsa notificamos y redirecciomamos
    if ($resultado === true) {
        mostrarSweetAlert('success', 'Eliminación exitosa', 'Se ha eliminado la disponibilidad', '/E-VITALIX/especialista/disponibilidad');
    } else {
        mostrarSweetAlert('error', 'Error al eliminar', 'No se pudo eliminar la disponibilidad');
    }
    exit();
}
