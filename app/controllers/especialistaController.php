<?php
// IMPORTAMOS LA DEPENDENCIAS NECESARIAS
// EN ESTE CASO EL ALERT HELPER Y EL MODELO
require_once __DIR__ . '/../helpers/alert_helper.php';
require_once __DIR__ . '/../models/especialistaModel.php';

// DECLARAMOS LA VARIBALE METHOD CON EL REQUEST METHOD PARA PODER VALIDAR QUE FUNCIÓN SE VA A EJECUTAR SEGÚN LA PETICIÓN HTTP

$method = $_SERVER['REQUEST_METHOD'];

// HACEMOS EL SWITCH CASE PARA VALIDAR LOS CASOS POSIBLES
switch ($method) {
    case 'POST':
            registrarEspecialista();
        break;

    case 'GET':
        # code...
        break;
    default:
        # code...
        break;
}

// CREAMOS LA FUNCIÓN QUE DECLARAMOS ANTERIORMENTE EN ESTE CASO ES LA DE registrarEspecialista() y la actualizarEspecialista();
function registrarEspecialista()
{
    // CAPTURAMOS EN VARIABLES LO QUE VENGA A TRAVÉS DEL METHOD POST Y LOS NAME DE LOS CAMPOS
    $tipoDocumento = $_POST['tipoDocumento'] ?? '';
    $numeroDocumento = $_POST['numeroDocumento'] ?? '';
    $nombres = $_POST['nombres'] ?? '';
    $apellidos = $_POST['apellidos'] ?? '';
    $fechaNacimiento = $_POST['nacimiento'] ?? '';
    $genero = $_POST['genero'] ?? '';
    $telefono = $_POST['telefono'] ?? '';
    $direccion = $_POST['direccion'] ?? '';
    $email = $_POST['correo'] ?? '';
    $clave = $_POST['clave'] ?? '';
    $especialidad = $_POST['especialidad'] ?? '';
    $registroProfesional = $_POST['registro'] ?? '';
    $consultorio = $_POST['consultorio'] ?? '';
    $diaSemana = $_POST['dia'] ?? '';
    $horaInicio = $_POST['horaInicio'] ?? '';
    $horaFin = $_POST['horaFin'] ?? '';
    $descansoInicio = $_POST['inicioDescanso'] ?? '';
    $descansoFinal = $_POST['finDescanso'] ?? '';
    $capacidad =  $_POST['capacidad'] ?? '';


    // VALIDAMOS LOS DATOS QUE SON OBLIGATORIOS
    if (empty($tipoDocumento) || empty($numeroDocumento) || empty($nombres) || empty($apellidos) || empty($fechaNacimiento) || empty($genero) || empty($telefono) || empty($direccion) || empty($email) || empty($clave) || empty($especialidad) || empty($registroProfesional) || empty($consultorio) || empty($diaSemana) || empty($horaInicio) || empty($horaFin) || empty($descansoInicio) || empty($descansoFinal) || empty($capacidad)) {
        mostrarSweetAlert('error', 'Campos vacíos', 'Por favor completar los campos obligatorios');
        exit();
    }

    // CAPTURAMOS EL ID DEL USUARIO QUE INICIA SESIÓN PARA GUARDARLO SOLO SI ES NECESARIO
    // session_start();
    // $id_admin = $_SESSION['user']['id'];

    // LÓGICA PARA CARGAR IMÁGENES

    $ruta_foto = null;

    // VALIDAMOS SI SE ENVIÓ O NO LA FOTO DESDE EL FORMULARIO
    // **** SI EL ADMINISTRADOR NO REGISTRÓ UNA FOTO DEJAR UNA IMAGEN POR DEFECTO


    if (!empty($_FILES['foto']['name'])) {

        // EN LA VARIABLE $file guardamos todos los atributos que tiene $_FILES
        $file = $_FILES['foto'];

        // OBTENEMOS LA EXTENSIÓN DEL ARCHIVO
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

        // DEFINIMOS LAS EXTENSIONES PERMITIDAS
        $permitidas = ['jpg', 'png', 'jpeg'];

        // VALIDAMOS QUE LA EXTENSIÓN DE LA IMAGEN CARGADA ESTÉ DENTRO DE LAS PERMITIDAS    
        if (!in_array($ext, $permitidas)) {
            mostrarSweetAlert('error', 'Extensión no permitida', 'Señor usuario cargue una extensión que sea permitida');
            exit();
        }

        // VALIDAMOS EL TAMAÑO O PESO DE LA IMAGEN MÁXIMO 2MB
        if ($file['size'] > 2 * 1024 * 1024) {
            mostrarSweetAlert('error', 'Error al cargar la foto', 'Señor usuario el peso de la foto es superior a 2MB');
            exit();
        }

        // DEFINIMOS EL NOMBRE DEL ARCHIVO Y LE CONCATENAMOS LA EXTENSIÓN
        $ruta_foto = uniqid('especialistas_') . '.' . $ext;

        // DEFINIMOS EL DESTINO DONDE MOVEREMOS EL ARCHIVO
        $destino = BASE_PATH . "/public/uploads/usuarios/" . $ruta_foto;

        // MOVEMOS EL ARCHIVO AL DESTINO
        move_uploaded_file($file['tmp_name'], $destino);
    }
    else {
        // AGREGAR LA LÓGICA DE LA IMAGEN POR DEFECTO
    }

    // POO - INSTANCIAMOS LA CLASE
    $objEspecialista = new Especialista();

    // LUEGO EN LA VARIABLE DATA GUARDAMOS TODOS LOS VALORES QUE VAN A VENIR DESDE LOS INPUT CON UN ARREGLO-OBJETO CLAVE VALOR
    $data = [
        'tipoDocumento' => $tipoDocumento,
        'numeroDocumento' => $numeroDocumento,
        'nombres' => $nombres,
        'apellidos' => $apellidos,
        'fechaNacimiento' => $fechaNacimiento,
        'genero' => $genero,
        'telefono' => $telefono,
        'direccion' => $direccion,
        'foto' => $ruta_foto,
        'email' => $email,
        'clave' => $clave,
        'especialidad' => $especialidad,
        'registroProfesional' => $registroProfesional,
        'consultorio' => $consultorio,
        'diaSemana' => $diaSemana,
        'horaInicio' => $horaInicio,
        'horaFin' => $horaFin,
        'descansoInicio' => $descansoInicio,
        'descansoFinal' => $descansoFinal,
        'capacidad' => $capacidad
    ];

    // CREAMOS UNA VARIABLE DONDE SE VA A GUARDAR EL OBJETO DONDE INSTANCIAMOS LA CLASE ACCEDIENDO AL MÉTODO DEL MODELO
    $resultado = $objEspecialista->registrar($data);

    // ESPERAMOS UNA RESPUESTA BOOLEANA DEL MODELO
    // Si la respuesta del modelo es verdadera confirmamos el registro y redireccionamos
    // Si es falsa notificamos y redirecciomamos

    if ($resultado === true) {
        mostrarSweetAlert('success', 'Registro de especialista exitoso', 'Se ha creado un nuevo especialista', '/E-VITALIX/admin/especialistas');
    }
    else {
        mostrarSweetAlert('error', 'Error al registrar', 'No se puedo registrar el especialista. Intenta nuevamente');
    }
    exit();
}


function actualizarEspecialista() {}
