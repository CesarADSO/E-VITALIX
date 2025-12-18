<?php
// IMPORTAMOS LAS DEPENDENCIAS NECESARIAS   
require_once __DIR__ . '/../helpers/alert_helper.php';
require_once __DIR__ . '/../models/asistenteModel.php';

// Capturamos en una variable el método o solicitud hecha al servidor
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'POST':

        // CREAMOS LA VARIABLE ACCIÓN QUE TRAE EL NAME="accion" DEL FORMULARIO
        $accion = $_POST['accion'] ?? '';

        // VALIDAMOS LA ACCIÓN
        if ($accion === 'actualizar') {
            actualizarAsistente();
        } else {
            registrarAsistente();
        }

        break;
    case 'GET':
        if (isset($_GET['id'])) {
            listarAsistente($_GET['id']);
        } else {
            mostrarAsistentes();
        }
        break;
}


function registrarAsistente()
{
    // Capturamos en variables los datos desde el formulario a través del method posh y los name de los campos
    $nombres = $_POST['nombres'] ?? '';
    $apellidos = $_POST['apellidos'] ?? '';
    $email = $_POST['email'] ?? '';
    $telefono = $_POST['telefono'] ?? '';
    $tipoDocumento = $_POST['tipo_documento'] ?? '';
    $numeroDocumento = $_POST['numero_documento'] ?? '';

    // Validamos los campos que son obligatorios
    if (empty($nombres) || empty($apellidos) || empty($email) || empty($telefono) || empty($tipoDocumento) || empty($numeroDocumento)) {
        mostrarSweetAlert('error', 'Campos vacíos', 'Por favor completar los campos obligatorios');
        exit();
    }

    // LÓGICA PARA CARGAR IMÁGENES

    $ruta_foto = null;


    // VALIDAMOS SI SE ENVIÓ O NO LA FOTO DESDE EL FORMULARIO
    // **** SI EL ADMINISTRADOR NO REGISTRÓ UNA FOTO DEJAR UNA IMAGEN POR DEFECTO

    if (!empty($_FILES['foto']['name'])) {

        $file = $_FILES['foto'];

        // OBTENEMOS LA EXTENSIÓN DEL ARCHIVO
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

        // DEFINIMOS LAS EXTENSIONES PERMITIDAS
        $permitidas = ['png', 'jpg', 'jpeg'];

        // VALIDAMOS QUE LA EXTENSIÓN DE LA IMAGEN CARGADA ESTÉ DENTRO DE LAS PERIMITIDAS
        if (!in_array($ext, $permitidas)) {
            mostrarSweetAlert('error', 'Extensión no permitida', 'Señor usuario cargue una extensión que sea permitida');
            exit();
        }

        // VALIDAMOS EL TAMAÑO O PESO DE LA IMAGEN MAX 2MB
        if ($file['size'] > 2 * 1024 * 1024) {
            mostrarSweetAlert('error', 'Error al cargar la foto', 'Señor usuario el peso de la foto es superior a 2MB');
            exit();
        }

        // DEFINIMOS EL NOMBRE DEL ARCHIVO Y LE CONCATENAMOS LA EXTENSIÓN
        $ruta_foto = uniqid('asistente-consultorio_') . '.' . $ext;

        // DEFINIMOS EL DESTINO DONDE MOVEREMOS EL ARCHIVO
        $destino = BASE_PATH . "/public/uploads/usuarios/" . $ruta_foto;

        // MOVEMOS EL ARCHIVO AL DESTINO
        move_uploaded_file($file['tmp_name'], $destino);
    } else {
        // AGREGAR LA LÓGICA DE LA IMAGEN POR DEFAULT
        $ruta_foto = 'default-asistente.jpg';
    }

    // Verificamos el estado actual de la sesión en PHP
    // Esto nos permite saber si ya existe una sesión iniciada,
    // si no hay ninguna o si las sesiones están deshabilitadas.
    if (session_status() !== PHP_SESSION_ACTIVE) {

        // Si la sesión NO está activa, la iniciamos.
        // session_start() crea una nueva sesión o reanuda una existente
        // (por ejemplo, cuando el usuario ya inició sesión anteriormente).
        // 
        // Esto es importante para poder usar el arreglo $_SESSION,
        // donde se almacenan los datos del usuario autenticado
        // como el id, el rol, el correo, etc.
        session_start();
    }

    // EN UNA VARIABLE GUARDAMOS EL ID DEL CONSULTORIO DEL ADMINISTRADOR QUE ESTÁ HACIENDO EL REGISTRO
    $id_consultorio = $_SESSION['user']['id_consultorio'] ?? null;


    // POO - INSTANCIAMOS LA CLASE AsistenteModel
    $ObjAsistente = new Asistente();

    // GUARDAMOS EN EL ARRAY DATA TODOS LOS DATOS DEL ASISTENTE
    $data = [
        'nombres' => $nombres,
        'apellidos' => $apellidos,
        'email' => $email,
        'telefono' => $telefono,
        'tipo_documento' => $tipoDocumento,
        'numero_documento' => $numeroDocumento,
        'foto' => $ruta_foto,
        'id_consultorio' => $id_consultorio
    ];

    // ACCEDEMOS AL METODO ESPECÍFICO DE LA CLASE PARA REGISTRAR EL ASISTENTE
    $resultado = $ObjAsistente->registrar($data);

    // MOSTRAMOS ALERTAS DEPENDIENDO DEL RESULTADO

    if ($resultado === true) {
        mostrarSweetAlert('success', 'Asistente registrado', 'El asistente ha sido registrado exitosamente', '/E-VITALIX/admin/asistentes');
    } else {
        mostrarSweetAlert('error', 'Error al registrar', 'Ha ocurrido un error al registrar el asistente');
    }
}

function mostrarAsistentes()
{
    // POO - INSTANCIAMOS LA CLASE Asistente
    $ObjAsistente = new Asistente();

    $id_consultorio = $_SESSION['user']['id_consultorio'] ?? null;

    // ACCEDEMOS AL MÉTODO ESPECÍFICO DE LA CLASE PARA MOSTRAR LOS ASISTENTES
    $resultado = $ObjAsistente->mostrar($id_consultorio);

    return $resultado;
}

// FUNCIÓN PARA LISTAR UN ASISTENTE POR ID
function listarAsistente($id)
{
    // INSTANCIAMOS EL MODELO
    $objAsistente = new Asistente();

    // LLAMAMOS AL MÉTODO DEL MODELO
    $resultado = $objAsistente->listarAsistentePorId($id);

    // RETORNAMOS LOS DATOS A LA VISTA
    return $resultado;
}

function actualizarAsistente()
{
    // CAPTURAMOS LOS DATOS QUE VIENEN DEL FORMULARIO
    $idUsuario     = $_POST['id_usuario'] ?? '';
    $idAsistente   = $_POST['id_asistente'] ?? '';
    $estado        = $_POST['estado'] ?? '';
    $tipoDocumento = $_POST['tipo_documento'] ?? '';
    $nombres       = $_POST['nombres'] ?? '';
    $apellidos     = $_POST['apellidos'] ?? '';
    $telefono      = $_POST['telefono'] ?? '';

    // VALIDAMOS CAMPOS OBLIGATORIOS
    if (
        empty($idUsuario) ||
        empty($idAsistente) ||
        empty($estado) ||
        empty($tipoDocumento) ||
        empty($nombres) ||
        empty($apellidos) ||
        empty($telefono)
    ) {
        mostrarSweetAlert(
            'error',
            'Campos incompletos',
            'Por favor completa todos los campos obligatorios'
        );
        exit();
    }

    // INSTANCIAMOS EL MODELO
    $objAsistente = new Asistente();

    // ARMAMOS EL ARREGLO DE DATOS
    $data = [
        'idUsuario'     => $idUsuario,
        'idAsistente'   => $idAsistente,
        'estado'        => $estado,
        'tipoDocumento' => $tipoDocumento,
        'nombres'       => $nombres,
        'apellidos'     => $apellidos,
        'telefono'      => $telefono
    ];

    // EJECUTAMOS EL MÉTODO DEL MODELO
    $resultado = $objAsistente->actualizar($data);

    // VALIDAMOS RESPUESTA
    if ($resultado === true) {
        mostrarSweetAlert(
            'success',
            'Actualización exitosa',
            'El asistente fue actualizado correctamente',
            '/E-VITALIX/admin/asistentes'
        );
    } else {
        mostrarSweetAlert(
            'error',
            'Error al actualizar',
            'No se pudo actualizar el asistente, intenta nuevamente'
        );
    }

    exit();
}
