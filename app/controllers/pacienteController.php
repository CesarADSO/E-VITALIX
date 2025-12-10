<?php
// Importamos las dependencias 
require_once __DIR__ . '/../helpers/alert_helper.php';
require_once __DIR__ . '/../helpers/session_admin.php';
require_once __DIR__ . '/../models/pacienteModel.php';

// Capturamos en una variable el metodo o solicitud hecha al servidor 
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'POST':
        $accion = $_POST['accion'] ?? '';
        if ($accion === 'actualizar') {
            actualizarPaciente();
        } else {
            registrarPaciente();
        }
        break;

    case 'GET':
        $accion = $_GET['accion'] ?? '';
        if ($accion === 'eliminar') {
            eliminarPaciente($_GET['id']);
        }
        if (isset($_GET['id'])) {
            listarPaciente($_GET['id']);
        } else {
            mostrarPacientes();
        }
        break;

    default:
        http_response_code(405);
        echo "Metodo no permitido";
        break;
}
function registrarPaciente()
{
    // capturamos en variables los datos desde el formulario
    $nombres = $_POST['nombres'] ?? '';
    $apellidos = $_POST['apellidos'] ?? '';
    $id_tipo_documento = $_POST['tipoDocumento'] ?? '';
    $numero_documento = $_POST['numeroDocumento'] ?? '';
    $fecha_nacimiento = $_POST['nacimiento'] ?? '';
    $genero = $_POST['genero'] ?? '';
    $telefono = $_POST['telefono'] ?? '';
    $ciudad = $_POST['ciudad'] ?? '';
    $direccion = $_POST['direccion'] ?? '';
    $email = $_POST['correo'] ?? '';
    $eps = $_POST['eps'] ?? '';
    $rh = $_POST['rh'] ?? '';
    $historial_medico = $_POST['historial'] ?? null;
    $nombre_contacto_emergencia = $_POST['nombreContacto'] ?? null;
    $telefono_contacto_emergencia = $_POST['telefonoContacto'] ?? null;
    $direccion_contacto_emergencia = $_POST['direccionContacto'] ?? null;
    $id_aseguradora = $_POST['aseguradora'] ?? null;

    // Validamos los campos obligatorios
    if (
        empty($nombres) || empty($apellidos) || empty($id_tipo_documento) ||
        empty($numero_documento) || empty($fecha_nacimiento) || empty($genero) || empty($telefono) || empty($ciudad) || empty($direccion) || empty($email)
    ) {
        mostrarSweetAlert('error', 'Campos vacíos', 'Por favor completar los campos obligatorios');
        exit();
    }

    // Validar formato de email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        mostrarSweetAlert('error', 'Email inválido', 'Por favor ingresa un email válido');
        exit();
    }
    // // hashear la contraseña
    // $contrasena_hash = password_hash($, PASSWORD_BCRYPT);
    // Logica para cargar imagenes
    $ruta_foto = null;
    if (!empty($_FILES['foto']['name'])) {
        $file = $_FILES['foto'];
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $permitidas = ['png', 'jpg', 'jpeg'];
        if (!in_array($ext, $permitidas)) {
            mostrarSweetAlert('error', 'Extension no permitida', 'Señor usuario cargue una extension que sea permitida (jpg, jpeg, png)');
            exit();
        }
        if ($file['size'] > 2 * 1024 * 1024) {
            mostrarSweetAlert('error', 'Error al cargar la foto', 'Señor usuario el peso de la foto es superior a 2mb');
            exit();
        }
        $ruta_foto = uniqid('paciente_') . '.' . $ext;
        $destino = BASE_PATH . "/public/uploads/pacientes/" . $ruta_foto;
        move_uploaded_file($file['tmp_name'], $destino);
    } else {
        // Imagen por defecto si no se carga ninguna
        $ruta_foto = 'default-paciente.png';
    }
    // el id_rol para pacientes
    $id_rol = 1;
    // instaciamos la clase Paciente
    $objPaciente = new Paciente();
    $data = [
        'nombres' => $nombres,
        'apellidos' => $apellidos,
        'id_tipo_documento' => $id_tipo_documento,
        'numero_documento' => $numero_documento,
        'fecha_nacimiento' => $fecha_nacimiento,
        'genero' => $genero,
        'telefono' => $telefono,
        'ciudad' => $ciudad,
        'direccion' => $direccion,
        'foto' => $ruta_foto,
        'email' => $email,
        'id_rol' => $id_rol,
        'eps' => $eps,
        'rh' => $rh,
        'historial_medico' => $historial_medico,
        'nombre_contacto_emergencia' => $nombre_contacto_emergencia,
        'telefono_contacto_emergencia' => $telefono_contacto_emergencia,
        'direccion_contacto_emergencia' => $direccion_contacto_emergencia,
        'id_aseguradora' => $id_aseguradora
    ];
    $resultado = $objPaciente->registrar($data);
    if ($resultado === true) {
        mostrarSweetAlert('success', 'Registro de paciente exitoso', 'Se ha creado un nuevo paciente', '/E-VITALIX/admin/pacientes');
    } else {
        mostrarSweetAlert('error', 'Error al registrar paciente', 'Ha ocurrido un error al registrar el paciente, por favor intente de nuevo.');
    }
    exit();
}
function mostrarPacientes()
{
    $resultado = new Paciente();
    $paciente = $resultado->consultar();

    return $paciente;
}
function listarPaciente($id)
{
    $objPaciente = new Paciente();
    $paciente = $objPaciente->listarPacientePorId($id);

    return $paciente;
}
function actualizarPaciente()
{
    // Capturamos en variables los valores enviados
    $id = $_POST['id'] ?? '';
    $id_usuario = $_POST['id_usuario'] ?? '';
    $nombres = $_POST['nombres'] ?? '';
    $apellidos = $_POST['apellidos'] ?? '';
    $id_tipo_documento = $_POST['tipoDocumento'] ?? '';
    $numero_documento = $_POST['numeroDocumento'] ?? '';
    $fecha_nacimiento = $_POST['nacimiento'] ?? '';
    $genero = $_POST['genero'] ?? '';
    $telefono = $_POST['telefono'] ?? '';
    $direccion = $_POST['direccion'] ?? '';
    $email = $_POST['correo'] ?? '';
    $eps = $_POST['eps'] ?? '';
    $rh = $_POST['rh'] ?? '';
    $historial_medico = $_POST['historial'] ?? null;
    $nombre_contacto_emergencia = $_POST['nombreContacto'] ?? null;
    $telefono_contacto_emergencia = $_POST['telefonoContacto'] ?? null;
    $direccion_contacto_emergencia = $_POST['direccionContacto'] ?? null;
    $id_aseguradora = $_POST['aseguradora'] ?? null;
    $estado = $_POST['estado'] ?? '';

    if (
        empty($nombres) || empty($apellidos) || empty($id_tipo_documento) ||
        empty($numero_documento) || empty($fecha_nacimiento) || empty($genero) ||
        empty($telefono) || empty($direccion) || empty($email)
    ) {
        mostrarSweetAlert('error', 'Campos vacíos', 'Por favor completar los campos obligatorios');
        exit();
    }
    // Instanciamos la clase Paciente
    $objPaciente = new Paciente();
    $data = [
        'id' => $id,
        'id_usuario' => $id_usuario,
        'nombres' => $nombres,
        'apellidos' => $apellidos,
        'id_tipo_documento' => $id_tipo_documento,
        'numero_documento' => $numero_documento,
        'fecha_nacimiento' => $fecha_nacimiento,
        'genero' => $genero,
        'telefono' => $telefono,
        'direccion' => $direccion,
        'email' => $email,
        'eps' => $eps,
        'rh' => $rh,
        'historial_medico' => $historial_medico,
        'nombre_contacto_emergencia' => $nombre_contacto_emergencia,
        'telefono_contacto_emergencia' => $telefono_contacto_emergencia,
        'direccion_contacto_emergencia' => $direccion_contacto_emergencia,
        'id_aseguradora' => $id_aseguradora,
        'estado' => $estado
    ];
    $resultado = $objPaciente->actualizar($data);

    if ($resultado ===  true) {
        mostrarSweetAlert('success', 'Modificacion exitosa', 'Se ha actualizado el paciente', '/E-VITALIX/admin/pacientes');
    } else {
        mostrarSweetAlert('error', 'Error al actualizar', 'No se pudo actualizar el paciente');
    }
    exit();
}
function eliminarPaciente($id)
{
    $objPaciente = new Paciente();
    $resultado = $objPaciente->eliminar($id);

    if ($resultado === true) {
        mostrarSweetAlert('success', 'Eliminación de Paciente exitosa', 'Se ha eliminado un paciente', '/E-VITALIX/admin/pacientes');
    } else {
        mostrarSweetAlert('error', 'Error al eliminar', 'No se pudo eliminar el paciente, intente nuevamente');
    }
    exit();
}
