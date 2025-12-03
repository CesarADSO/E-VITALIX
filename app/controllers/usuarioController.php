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

            require_once __DIR__ . '/../views/dashboard/administrador/usuarios.php';
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
       if  (empty($email) || empty($contrasena) || empty($estado)) {
        mostrarSweetAlert('error', 'Campos vacíos', 'Por favor completar los campos obligatorios');
        exit();
    }

    $ObjUsuario = new Usuario();
    $data = [
        'id'=> $id,
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
        mostrarSweetAlert('success', 'Modificación exitosa', 'Se ha actualizado el Usuario', '/E-VITALIX/admin/usuarios');
    } else {
        mostrarSweetAlert('error', 'Error al actualizar', 'No se puedo actualizar el cUsuario. Intenta nuevamente');
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
        mostrarSweetAlert('success', 'Eliminación exitosa', 'Se ha eliminado el usuario', '/E-VITALIX/admin/usuarios');
    } else {
        mostrarSweetAlert('error', 'Error al eliminar', 'No se pudo eliminar el usuario. Intenta nuevamente');
    }
    exit();
}


