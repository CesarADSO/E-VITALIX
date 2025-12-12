<?php
// Importamos las dependencias
require_once __DIR__ . '/../helpers/alert_helper.php';
require_once __DIR__ . '/../models/consultorioModel.php';

// Capturamos en una variable el método o solicitud hecha al servidor
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'POST':
        $accion = $_POST['accion'] ?? '';
        if ($accion === 'actualizar') {
            actualizarConsultorio();
        } else {
            registrarConsultorio();
        }
        break;

    case 'GET':

        $accion = $_GET['accion'] ?? '';

        if ($accion === 'eliminar') {
            // ESTA FUNCIÓN ELIMINAR EL CONSULTORIO A PARTIR DE UN ID ESPECÍFICO DEL REGISTRO SELECCIONADO (CONSULTORIO)
            eliminarConsultorio($_GET['id']);
        }

        // SI EXISTE EL ID QUE TRAEMOS POR METODO GET ENTONCES SE EJECUTA ESTA FUNCIÓN
        if (isset($_GET['id'])) {
            // Esta función llena el formulario de editar con un solo consultorio
            listarConsultorio($_GET['id']);
        } else {
            // Esta función llena toda la tabla de consultorios
            mostrarConsultorios();
        }
        break;
    // ESTO ES POR SI AGREGAMOS UNA API RESTFUL

    // case 'PUT':
    //     actualizarConsultorio();
    //     break;

    // case 'DELETE':
    //     eliminarConsultorio();
    //     break;
    default:
        http_response_code(405);
        echo "Método no permitido";
        break;
}
// Funciones crud

function registrarConsultorio()
{
    // Capturamos en variables los datos desde el formulario a través del method posh y los name de los campos
    $nombre = $_POST['nombre'] ?? '';
    $direccion = $_POST['direccion'] ?? '';
    $ciudad = $_POST['ciudad'] ?? '';
    $telefono = $_POST['telefono'] ?? '';
    $correo_contacto = $_POST['correo'] ?? '';
    $especialidades = $_POST['especialidades'] ?? [];
    $dias = $_POST['dias'] ?? [];
    $hora_apertura = $_POST['hora_apertura'] ?? '';
    $hora_cierre = $_POST['hora_cierre'] ?? '';
    $email_admin = $_POST['correo_admin'] ?? '';
    $nombres_admin = $_POST['nombres_admin'] ?? '';
    $apellidos_admin = $_POST['apellidos_admin'] ?? '';
    $telefono_admin = $_POST['telefono_admin'] ?? '';
    $tipo_documento_admin = $_POST['tipo_documento_admin'] ?? '';
    $numero_documento_admin = $_POST['numero_documento_admin'] ?? '';

    // Validamos los campos que son obligatorios
    if (empty($nombre) || empty($direccion) || empty($ciudad) || empty($telefono) || empty($correo_contacto) || empty($especialidades) || empty($dias) || empty($hora_apertura) || empty($hora_cierre) || empty($email_admin) || empty($nombres_admin) || empty($apellidos_admin) || empty($telefono_admin) || empty($tipo_documento_admin) || empty($numero_documento_admin)) {
        mostrarSweetAlert('error', 'Campos vacíos', 'Por favor completar los campos obligatorios');
        exit();
    }

    // CAPTURAMOS EL ID DEL USUARIO QUE INICIA SESIÓN PARA GUARDARLO SOLO SI ES NECESARIO
    // session_start();
    // $id_admin = $_SESSION['user']['id'];

    //POO - INSTANCIAMOS LA CLASE
    // LÓGICA PARA CARGAR IMÁGENES

    $ruta_foto_consultorio = null;

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
        $ruta_foto_consultorio = uniqid('consultorio_') . '.' . $ext;

        // DEFINIMOS EL DESTINO DONDE MOVEREMOS EL ARCHIVO
        $destino = BASE_PATH . "/public/uploads/consultorios/" . $ruta_foto_consultorio;

        // MOVEMOS EL ARCHIVO AL DESTINO
        move_uploaded_file($file['tmp_name'], $destino);
    } else {
        // AGREGAR LA LÓGICA DE LA IMAGEN POR DEFAULT
    }

    $ruta_foto_administrador = null;

    if (!empty($_FILES['foto_admin']['name'])) {

        $file = $_FILES['foto_admin'];

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
        $ruta_foto_administrador = uniqid('administrador_') . '.' . $ext;

        // DEFINIMOS EL DESTINO DONDE MOVEREMOS EL ARCHIVO
        $destino = BASE_PATH . "/public/uploads/usuarios/" . $ruta_foto_administrador;

        // MOVEMOS EL ARCHIVO AL DESTINO
        move_uploaded_file($file['tmp_name'], $destino);
    } else {
        // AGREGAR LA LÓGICA DE LA IMAGEN POR DEFAULT
    }


    $horario_atencion = [
        'dias' => $dias,
        'hora_apertura' => $hora_apertura,
        'hora_cierre' => $hora_cierre
    ];

    // Convertimos el arreglo de especialidades en un texto JSON
    // Ejemplo: ["dermatologia", "urologia"] → '["dermatologia","urologia"]'
    $especialidades_json = json_encode($especialidades);

    // Convertimos el arreglo de horario a JSON manteniendo acentos, eñes y caracteres especiales tal cual,
    // evitando que se conviertan en códigos Unicode como \u00f1 (JSON_UNESCAPED_UNICODE mejora la legibilidad).
    $horario_atencion_json = json_encode($horario_atencion, JSON_UNESCAPED_UNICODE);

    $ObjConsultorio = new Consultorio();
    $data = [
        'nombre' => $nombre,
        'direccion' => $direccion,
        'foto' => $ruta_foto_consultorio,
        'ciudad' => $ciudad,
        'telefono' => $telefono,
        'correo_contacto' => $correo_contacto,
        'especialidades' => $especialidades_json,
        'horario_atencion' => $horario_atencion_json,
        'email_admin' => $email_admin,
        'nombres_admin' => $nombres_admin,
        'apellidos_admin' => $apellidos_admin,
        'telefono_admin' => $telefono_admin,
        'foto_admin' => $ruta_foto_administrador,
        'tipo_documento_admin' => $tipo_documento_admin,
        'numero_documento_admin' => $numero_documento_admin,
        // 'id_admin' => $id_admin
    ];
    // Enviamos la data al método "registrar()" de la clase instanciada anteriormente "Consultorio()"
    // Y esperamos una respuesta booleana del modelo
    $resultado = $ObjConsultorio->registrar($data);

    // Si la respuesta del modelo es verdadera confirmamos el registro y redireccionamos
    // Si es falsa notificamos y redirecciomamos
    if ($resultado === true) {
        mostrarSweetAlert('success', 'Registro de consultorio exitoso', 'Se ha creado un nuevo consultorio', '/E-VITALIX/superadmin/consultorios');
    } else {
        mostrarSweetAlert('error', 'Error al registrar', 'No se puedo registrar el consultorio. Intenta nuevamente');
    }
    exit();
}

function mostrarConsultorios()
{

    // session_start();
    // $id_admin = $_SESSION['user']['id_admin'];

    $resultado = new Consultorio();
    $consultorios = $resultado->consultar();

    return $consultorios;
}

function listarConsultorio($id)
{
    $objConsultorio = new Consultorio();

    $consultorio = $objConsultorio->listarConsultorioPorId($id);

    return $consultorio;
}

function actualizarConsultorio()
{
    // CAPTURAMOS EN VARIABLES LOS VALORES ENVIADOS A TRAVÉS DEL METHOD POST Y LOS NAME DE LOS CAMPOS
    $id = $_POST['id'] ?? '';
    $nombre = $_POST['nombre'] ?? '';
    $direccion = $_POST['direccion'] ?? '';
    $ciudad = $_POST['ciudad'] ?? '';
    $telefono = $_POST['telefono'] ?? '';
    $correo_contacto = $_POST['correo'] ?? '';
    $especialidades = $_POST['especialidades'] ?? [];
    $dias = $_POST['dias'] ?? [];
    $hora_apertura = $_POST['hora_apertura'] ?? '';
    $hora_cierre = $_POST['hora_cierre'] ?? '';
    $estado = $_POST['estado'] ?? '';

    // Validamos los campos que son obligatorios
    if (empty($nombre) || empty($direccion) || empty($ciudad) || empty($telefono) || empty($correo_contacto) || empty($especialidades) || empty($dias) || empty($hora_apertura) || empty($hora_cierre) || empty($estado)) {
        mostrarSweetAlert('error', 'Campos vacíos', 'Por favor completar los campos obligatoriosaaaaa');
        exit();
    }

    $horario_atencion = [
        'dias' => $dias,
        'hora_apertura' => $hora_apertura,
        'hora_cierre' => $hora_cierre
    ];

    // Convertimos el arreglo de especialidades en un texto JSON
    // Ejemplo: ["dermatologia", "urologia"] → '["dermatologia","urologia"]'
    $especialidades_json = json_encode($especialidades);

    // Convertimos el arreglo de horario a JSON manteniendo acentos, eñes y caracteres especiales tal cual,
    // evitando que se conviertan en códigos Unicode como \u00f1 (JSON_UNESCAPED_UNICODE mejora la legibilidad).
    $horario_atencion_json = json_encode($horario_atencion, JSON_UNESCAPED_UNICODE);

    //POO - INSTANCIAMOS LA CLASE
    $ObjConsultorio = new Consultorio();
    $data = [
        'id' => $id,
        'nombre' => $nombre,
        'direccion' => $direccion,
        'ciudad' => $ciudad,
        'telefono' => $telefono,
        'correo_contacto' => $correo_contacto,
        'especialidades' => $especialidades_json,
        'horario_atencion' => $horario_atencion_json,
        'estado' => $estado
        // 'id_admin' => $id_admin
    ];
    // Enviamos la data al método "actualizar()" de la clase instanciada anteriormente "Consultorio()"
    // Y esperamos una respuesta booleana del modelo
    $resultado = $ObjConsultorio->actualizar($data);

    // Si la respuesta del modelo es verdadera confirmamos el registro y redireccionamos
    // Si es falsa notificamos y redirecciomamos
    if ($resultado === true) {
        mostrarSweetAlert('success', 'Modificación exitosa', 'Se ha actualizado el consultorio', '/E-VITALIX/superadmin/consultorios');
    } else {
        mostrarSweetAlert('error', 'Error al actualizar', 'No se puedo actualizar el consultorio. Intenta nuevamente');
    }
    exit();
}

function eliminarConsultorio($id)
{
    $objConsultorio = new Consultorio();

    $resultado = $objConsultorio->eliminar($id);

    // Si la respuesta del modelo es verdadera confirmamos la eliminación y redireccionamos
    // Si es falsa notificamos y redirecciomamos
    if ($resultado === true) {
        mostrarSweetAlert('success', 'Eliminación exitosa', 'Se ha eliminado el consultorio', '/E-VITALIX/superadmin/consultorios');
    } else {
        mostrarSweetAlert('error', 'Error al eliminar', 'No se pudo eliminar el consultorio. Intenta nuevamente');
    }
    exit();
}
