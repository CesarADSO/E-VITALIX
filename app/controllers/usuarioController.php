<?php
// Importamos las dependencias
require_once __DIR__ . '/../helpers/alert_helper.php';
require_once __DIR__ . '/../helpers/validacion_helper.php';
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
    $email = Validaciones::sanitizarEmail($_POST['email'] ?? '');
    $nombres = Validaciones::sanitizarString($_POST['nombres'] ?? '');
    $apellidos = Validaciones::sanitizarString($_POST['apellidos'] ?? '');
    $telefono = Validaciones::sanitizarString($_POST['telefono'] ?? '');

    // VALIDACIONES INDIVIDUALES
    // Validar email
    $validacion_email = Validaciones::validarEmail($email);
    if (!$validacion_email['valido']) {
        mostrarSweetAlert('error', 'Error en email', $validacion_email['mensaje']);
        exit();
    }

    // Validar nombres
    $validacion_nombres = Validaciones::validarNombres($nombres);
    if (!$validacion_nombres['valido']) {
        mostrarSweetAlert('error', 'Error en nombres', $validacion_nombres['mensaje']);
        exit();
    }

    // Validar apellidos
    $validacion_apellidos = Validaciones::validarApellidos($apellidos);
    if (!$validacion_apellidos['valido']) {
        mostrarSweetAlert('error', 'Error en apellidos', $validacion_apellidos['mensaje']);
        exit();
    }

    // Validar teléfono
    $validacion_telefono = Validaciones::validarTelefono($telefono);
    if (!$validacion_telefono['valido']) {
        mostrarSweetAlert('error', 'Error en teléfono', $validacion_telefono['mensaje']);
        exit();
    }

    // Verificar que el email no existe ya
    $objUsuario = new Usuario();
    if ($objUsuario->emailExiste($email)) {
        mostrarSweetAlert('error', 'Email duplicado', 'Este email ya está registrado en el sistema');
        exit();
    }

    // LÓGICA PARA CARGAR IMÁGENES
    $ruta_foto = null;

    if (!empty($_FILES['foto']['name'])) {
        // Validar el archivo de imagen
        $validacion_imagen = Validaciones::validarImagenUpload($_FILES['foto'], 2);
        if (!$validacion_imagen['valido']) {
            mostrarSweetAlert('error', 'Error en imagen', $validacion_imagen['mensaje']);
            exit();
        }

        $file = $_FILES['foto'];

        // OBTENEMOS LA EXTENSIÓN DEL ARCHIVO
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

        // DEFINIMOS EL NOMBRE DEL ARCHIVO Y LE CONCATENAMOS LA EXTENSIÓN
        $ruta_foto = uniqid('superadministrador_') . '.' . $ext;

        // DEFINIMOS EL DESTINO DONDE MOVEREMOS EL ARCHIVO
        $destino = BASE_PATH . "/public/uploads/usuarios/" . $ruta_foto;

        // MOVEMOS EL ARCHIVO AL DESTINO
        if (!move_uploaded_file($file['tmp_name'], $destino)) {
            mostrarSweetAlert('error', 'Error al cargar', 'No se pudo cargar la imagen. Intenta nuevamente');
            exit();
        }
    } else {
        $ruta_foto = 'default-superadministrador.jpg';
    }

    // POO - INSTANTIAMOS LA CLASE DEL MODELO USUARIO PARA ACCEDER AL MÉTODO REGISTRAR
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
    $id = Validaciones::sanitizarNumero($_POST['id'] ?? '');
    $email = Validaciones::sanitizarEmail($_POST['correo'] ?? '');
    $contrasena = $_POST['contrasena'] ?? '';
    $estado = $_POST['estado'] ?? '';

    // Validar ID
    $validacion_id = Validaciones::validarNumero($id, 1);
    if (!$validacion_id['valido']) {
        mostrarSweetAlert('error', 'Error de validación', 'ID de usuario inválido');
        exit();
    }

    // Validar email
    $validacion_email = Validaciones::validarEmail($email);
    if (!$validacion_email['valido']) {
        mostrarSweetAlert('error', 'Error en email', $validacion_email['mensaje']);
        exit();
    }

    // Validar estado
    $estados_validos = ['Activo', 'Inactivo', 'Suspendido'];
    if (!in_array($estado, $estados_validos)) {
        mostrarSweetAlert('error', 'Error de validación', 'Estado de usuario inválido');
        exit();
    }

    // Validar contraseña si se proporcionó
    if (!empty($contrasena)) {
        $validacion_contrasena = Validaciones::validarContrasenasimple($contrasena);
        if (!$validacion_contrasena['valido']) {
            mostrarSweetAlert('error', 'Error en contraseña', $validacion_contrasena['mensaje']);
            exit();
        }
        // Encriptar la contraseña
        $contrasena = password_hash($contrasena, PASSWORD_DEFAULT);
    }

    $ObjUsuario = new Usuario();
    
    $data = [
        'id' => $id,
        'email' => $email,
        'contrasena' => $contrasena,
        'estado' => $estado
    ];
    
    // Enviamos la data al método "actualizar()" de la clase instanciada anteriormente "Usuario()"
    $resultado = $ObjUsuario->actualizar($data);

    // Si la respuesta del modelo es verdadera confirmamos el registro y redireccionamos
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
