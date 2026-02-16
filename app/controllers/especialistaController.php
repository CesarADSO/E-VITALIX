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
        // CREAMOS LA VARIABLE ACCIÓN QUE LO QUE TRAE ES LO QUE VIENE EN EL NAME DEL INPUT ACCION
        $accion = $_POST['accion'] ?? '';
        // ACÁ VALIDAMOS EL VALUE DE DICHO INPUT
        if ($accion === 'actualizar') {
            actualizarEspecialista();
        } else {
            registrarEspecialista();
        }

        break;

    case 'GET':

        $accion = $_GET['accion'] ?? '';

        if ($accion === 'eliminar') {
            // ESTA FUNCIÓN ELIMINAR EL CONSULTORIO A PARTIR DE UN ID ESPECÍFICO DEL REGISTRO SELECCIONADO (ESPECIALISTA)
            eliminarEspecialista($_GET['idUsuario'], $_GET['id']);
        }

        // SI EXISTE EL ID QUE TRAEMOS POR METODO GET ENTONCES SE EJECUTA ESTA FUNCIÓN
        if (isset($_GET['id'])) {
            listarEspecialista($_GET['id']);
        } else {
            mostrarEspecialistas();
        }

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
    // VALIDAR QUE SEA MAYOR DE 18 AÑOS
    $fechaNacimientoObj = new DateTime($fechaNacimiento);
    $fechaActual = new DateTime();
    $edad = $fechaNacimientoObj->diff($fechaActual)->y;

    if ($edad < 18) {
        mostrarSweetAlert(
            'error',
            'Edad no permitida',
            'El especialista debe ser mayor de 18 años'
        );
        exit();
    }

    $genero = $_POST['genero'] ?? '';
    $telefono = $_POST['telefono'] ?? '';
    $direccion = $_POST['direccion'] ?? '';
    $email = $_POST['correo'] ?? '';
    $especialidad = $_POST['especialidad'] ?? '';
    $registroProfesional = $_POST['registro'] ?? '';


    // VALIDAMOS LOS DATOS QUE SON OBLIGATORIOS
    if (empty($tipoDocumento) || empty($numeroDocumento) || empty($nombres) || empty($apellidos) || empty($fechaNacimiento) || empty($genero) || empty($telefono) || empty($direccion) || empty($email) || empty($especialidad) || empty($registroProfesional)) {
        mostrarSweetAlert('error', 'Campos vacíos', 'Por favor completar los campos obligatorios');
        exit();
    }

    // Iniciar o reanudar sesión de forma segura y obtener datos del usuario
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }

    // ID del consultorio asignado al administrador (puede ser null si no aplica)
    $id_consultorio = $_SESSION['user']['id_consultorio'] ?? null;

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
    } else {
        // AGREGAR LA LÓGICA DE LA IMAGEN POR DEFECTO
        $ruta_foto = 'default-especialista.jpg';
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
        'especialidad' => $especialidad,
        'registroProfesional' => $registroProfesional,
        'id_consultorio' => $id_consultorio
    ];


    // CREAMOS UNA VARIABLE DONDE SE VA A GUARDAR EL OBJETO DONDE INSTANCIAMOS LA CLASE ACCEDIENDO AL MÉTODO DEL MODELO
    $resultado = $objEspecialista->registrar($data);

    // ESPERAMOS UNA RESPUESTA BOOLEANA DEL MODELO
    // Si la respuesta del modelo es verdadera confirmamos el registro y redireccionamos
    // Si es falsa notificamos y redirecciomamos

    if ($resultado === true) {
        mostrarSweetAlert('success', 'Registro de especialista exitoso', 'Se ha creado un nuevo especialista', '/E-VITALIX/admin/especialistas');
    } else {
        mostrarSweetAlert('error', 'Error al registrar', 'No se puedo registrar el especialista. Intenta nuevamente');
    }
    exit();
}

// CREAMOS LA FUNCIÓN QUE DECLARAMOS ANTERIOMENTE EN EL SWITCH METHOD mostrarEspecialistas();
function mostrarEspecialistas()
{
    // ID del consultorio asignado al administrador (puede ser null si no aplica)
    $id_consultorio = $_SESSION['user']['id_consultorio'] ?? null;

    // INSTANCIAMOS NUESTRA CLASE DEL MODELO
    $objEspecialista = new Especialista();

    // EN UNA VARIABLE ACCEDEMOS AL METODO DE DICHA CLASE QUE NECESITAMOS
    $resultado = $objEspecialista->mostrar($id_consultorio);

    // RETORNAMOS LOS DATOS A LA VISTA
    return $resultado;
}

function listarEspecialista($id)
{

    // INSTANCIAMOS LA CLASE DE NUESTRO MODELO AL CUAL ESTAMOS RELACIONADOS
    $objEspecialista = new Especialista();

    // ACCEDEMOS AL MÉTODO QUE VAMOS A USAR
    $resultado = $objEspecialista->listarEspecialistaPorId($id);

    // RETORNAMOS LOS DATOS A LA VISTA
    return $resultado;
}


function actualizarEspecialista()
{
    // CAPTURAMOS EN VARIABLES LO QUE VENGA A TRAVÉS DEL METHOD POST Y LOS NAME DE LOS CAMPOS
    $idUsuario = $_POST['idUsuario'] ?? '';
    $idEspecialista = $_POST['idEspecialista'] ?? '';
    $tipoDocumento = $_POST['tipoDocumento'] ?? '';
    $numeroDocumento = $_POST['numeroDocumento'] ?? '';
    $nombres = $_POST['nombres'] ?? '';
    $apellidos = $_POST['apellidos'] ?? '';
    $fechaNacimiento = $_POST['nacimiento'] ?? '';
    // VALIDAR QUE SEA MAYOR DE 18 AÑOS
    $fechaNacimientoObj = new DateTime($fechaNacimiento);
    $fechaActual = new DateTime();
    $edad = $fechaNacimientoObj->diff($fechaActual)->y;

    if ($edad < 18) {
        mostrarSweetAlert(
            'error',
            'Edad no permitida',
            'El especialista debe ser mayor de 18 años'
        );
        exit();
    }
    $genero = $_POST['genero'] ?? '';
    $telefono = $_POST['telefono'] ?? '';
    $direccion = $_POST['direccion'] ?? '';
    $especialidad = $_POST['especialidad'] ?? '';
    $registroProfesional = $_POST['registro'] ?? '';
    $estadoEspecialista = $_POST['estadoEspecialista'] ?? '';

    // VALIDAMOS LOS CAMPOS QUE SON OBLIGATORIOS
    if (empty($tipoDocumento) || empty($numeroDocumento) || empty($nombres) || empty($apellidos) || empty($fechaNacimiento) || empty($genero) || empty($telefono) || empty($direccion) ||  empty($especialidad) || empty($registroProfesional)) {
        mostrarSweetAlert('error', 'Campos vacíos', 'Por favor completar los campos obligatorios');
        exit();
    }

    // POO - INSTANCIAMOS LA CLASE
    $objEspecialista = new Especialista();

    // LUEGO EN LA VARIABLE DATA GUARDAMOS TODOS LOS VALORES QUE VAN A VENIR DESDE LOS INPUT CON UN ARREGLO-OBJETO CLAVE VALOR
    $data = [
        'idUsuario' => $idUsuario,
        'idEspecialista' => $idEspecialista,
        'tipoDocumento' => $tipoDocumento,
        'numeroDocumento' => $numeroDocumento,
        'nombres' => $nombres,
        'apellidos' => $apellidos,
        'fechaNacimiento' => $fechaNacimiento,
        'genero' => $genero,
        'telefono' => $telefono,
        'direccion' => $direccion,
        'especialidad' => $especialidad,
        'registroProfesional' => $registroProfesional,
        'estadoEspecialista' => $estadoEspecialista
    ];

    // CREAMOS UNA VARIABLE DONDE SE VA A GUARDAR EL OBJETO DONDE INSTANCIAMOS LA CLASE ACCEDIENDO AL MÉTODO DEL MODELO
    $resultado = $objEspecialista->actualizar($data);

    // ESPERAMOS UNA RESPUESTA BOOLEANA DEL MODELO
    // Si la respuesta del modelo es verdadera confirmamos el registro y redireccionamos
    // Si es falsa notificamos y redirecciomamos

    if ($resultado === true) {
        mostrarSweetAlert('success', 'Modificación de especialista exitoso', 'Se ha modificado este especialista', '/E-VITALIX/admin/especialistas');
    } else {
        mostrarSweetAlert('error', 'Error al modificar', 'No se pudo modificar el especialista. Intenta nuevamente');
    }
    exit();
}

function eliminarEspecialista($idUsuario, $id)
{

    // INSTANCIAMOS NUESTRA CLASE ESPECIALISTA 
    $objEspecialista = new Especialista();

    // EN UNA VARIABLE ACCEDEMOS A NUESTRO MÉTODO DE LA CLASE INSTANCIADA
    $resultado = $objEspecialista->eliminar($idUsuario, $id);

    // Si la respuesta del modelo es verdadera confirmamos la eliminación y redireccionamos
    // Si es falsa notificamos y redirecciomamos
    if ($resultado === true) {
        mostrarSweetAlert('success', 'Eliminación exitosa', 'Se ha eliminado el consultorio', '/E-VITALIX/admin/especialistas');
    } else {
        mostrarSweetAlert('error', 'Error al eliminar', 'No se pudo eliminar el consultorio. Intenta nuevamente');
    }
    exit();
}
