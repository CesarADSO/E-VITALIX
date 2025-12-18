<?php
// Importamos las dependencias
require_once __DIR__ . '/../helpers/alert_helper.php';
require_once __DIR__ . '/../models/usuarioModel.php';

// Capturamos en una variable el método o solicitud hecha al servidor
$method = $_SERVER['REQUEST_METHOD'];


switch ($method) {
    case 'POST':
        $accion = $_POST['accion'] ?? '';
        if ($accion === 'actualizar') {
            actualizarUsuario();
        } else {
            registrarSuperAdministrador();
        }
        break;

    case 'GET':

        $accion = $_GET['accion'] ?? '';

        if ($accion === 'eliminar') {
            // ESTA FUNCIÓN ELIMINA EL USUARIO A PARTIR DE UN ID ESPECÍFICO DEL REGISTRO SELECCIONADO (usuario)
            eliminarUsuario($_GET['id']);
            exit();
        }

        // SI EXISTE EL ID QUE TRAEMOS POR METODO GET ENTONCES SE EJECUTA ESTA FUNCIÓN
        if (isset($_GET['id'])) {
            // Esta función llena el formulario de editar con un solo usuario
            listarUsuario($_GET['id']);
        } else {
            // Esta función llena toda la tabla de usuarios
            $datos = mostrarUsuario();

            require_once __DIR__ . '/../views/dashboard/superadministrador/usuarios.php';
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

function registrarSuperAdministrador()
{
    // CAPTURAMOS EN VARIABLES LOS VALORES ENVIADOS A TRAVÉS DEL METHOD POST Y LOS NAME DE LOS CAMPOS
    $email = $_POST['email'] ?? '';
    $nombres = $_POST['nombres'] ?? '';
    $apellidos = $_POST['apellidos'] ?? '';
    $telefono = $_POST['telefono'] ?? '';

    // Validamos los campos que son obligatorios
    if (empty($email) || empty($nombres) || empty($apellidos) || empty($telefono)) {
        mostrarSweetAlert('error', 'Campos vacíos', 'Por favor completar los campos obligatorios');
        exit();
    }

    // LÓGICA PARA CARGAR IMÁGENES
    $ruta_foto = null;

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
        $ruta_foto = uniqid('superadministrador_') . '.' . $ext;

        // DEFINIMOS EL DESTINO DONDE MOVEREMOS EL ARCHIVO
        $destino = BASE_PATH . "/public/uploads/usuarios/" . $ruta_foto;

        // MOVEMOS EL ARCHIVO AL DESTINO
        move_uploaded_file($file['tmp_name'], $destino);
    } else {
        // AGREGAR LA LÓGICA DE LA IMAGEN POR DEFAULT
    }


    // POO - INSTANTIAMOS LA CLASE DEL MODELO USUARIO PARA ACCEDER AL MÉTODO REGISTRAR
    $objUsuario = new Usuario();
    $data = [
        'email' => $email,
        'nombres' => $nombres,
        'apellidos' => $apellidos,
        'foto' => $ruta_foto,
        'telefono' => $telefono
    ];

    // ENVIAMOS LA DATA AL MÉTODO "registrar()" DE LA CLASE INSTANTIADA ANTERIORMENTE "Usuario()"
    $resultado = $objUsuario->registrarSuperAdministrador($data);

    // ESPERAMOS UNA RESPUESTA BOOLEANA DEL MODELO
    if ($resultado === true) {
        mostrarSweetAlert('success', 'Registro exitoso', 'Se ha registrado el Superadministrador', '/E-VITALIX/superadmin/usuarios');
    } else {
        mostrarSweetAlert('error', 'Error al registrar', 'No se puedo registrar el Superadministrador. Intenta nuevamente');
    }
}

function mostrarUsuario()
{

    // session_start();
    // $id_admin = $_SESSION['user']['id_admin'];

    $resultado = new Usuario();
    $usuario = $resultado->consultar();

    return $usuario;
}

function listarUsuario($id)
{
    $objUsuario = new Usuario();

    $usuario = $objUsuario->listarUsuarioPorId($id);

    return $usuario;
}

function actualizarUsuario()
{
    // CAPTURAMOS EN VARIABLES LOS VALORES ENVIADOS A TRAVÉS DEL METHOD POST Y LOS NAME DE LOS CAMPOS
    $id = $_POST['id'] ?? '';
    $email = $_POST['correo'] ?? '';
    $contrasena = $_POST['contrasena'] ?? '';
    $estado = $_POST['estado'] ?? '';

    // Validamos los campos que son obligatorios
    if (empty($email) || empty($estado)) {
        mostrarSweetAlert('error', 'Campos vacíos', 'Por favor completar los campos obligatorios');
        exit();
    }

    $ObjUsuario = new Usuario();
    $data = [
        'id' => $id,
        'email' => $email,
        'contrasena' => $contrasena,
        'estado' => $estado

        // 'id_admin' => $id_admin
    ];
    // Enviamos la data al método "actualizar()" de la clase instanciada anteriormente "Consultorio()"
    // Y esperamos una respuesta booleana del modelo
    $resultado = $ObjUsuario->actualizar($data);

    // Si la respuesta del modelo es verdadera confirmamos el registro y redireccionamos
    // Si es falsa notificamos y redirecciomamos
    if ($resultado === true) {
        mostrarSweetAlert('success', 'Modificación exitosa', 'Se ha actualizado el Usuario', '/E-VITALIX/superadmin/usuarios');
    } else {
        mostrarSweetAlert('error', 'Error al actualizar', 'No se puedo actualizar el Usuario. Intenta nuevamente');
    }
    exit();
}


function eliminarUsuario($id)
{
    $objUsuario = new Usuario();

    $resultado = $objUsuario->eliminar($id);

    // Si la respuesta del modelo es verdadera confirmamos la eliminación y redireccionamos
    // Si es falsa notificamos y redirecciomamos
    if ($resultado === true) {
        mostrarSweetAlert('success', 'Eliminación exitosa', 'Se ha eliminado el usuario', '/E-VITALIX/superadmin/usuarios');
    } else {
        mostrarSweetAlert('error', 'Error al eliminar', 'No se pudo eliminar el usuario. Intenta nuevamente');
    }
    exit();
}
