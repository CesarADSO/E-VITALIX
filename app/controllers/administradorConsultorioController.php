<?php
// IMPORTAMOS LAS DEPENDENCIAS NECESARIAS
require_once __DIR__ . '/../helpers/alert_helper.php';
require_once __DIR__ . '/../models/administradorConsultorioModel.php';

// Capturamos en una variable el método o solicitud hecha al servidor
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'POST':
        $accion = $_POST['accion'] ?? '';
        if ($accion === 'actualizar') {
            actualizarAdministradorConsultorio();
        }
        elseif ($accion === 'asignar') {
            asignarConsultorioAdministrador();
        }
        else {
            registrarAdministradorConsultorio();
        }
        
        break;
    case 'GET':
        $accion = $_GET['accion'] ?? '';
        if ($accion === 'eliminar') {
            eliminarAdministradorConsultorio($_GET['id'], $_GET['id_usuario']);
        }
        elseif ($accion === 'desasignar') {
            desasignarConsultorioAdministrador($_GET['id']);
        }
        if (isset($_GET['id'])) {
            listarAdministradorConsultorioId($_GET['id']);
        }
        else {
            mostrarAdministradoresConsultorios();
        }
        
        break;
}

function registrarAdministradorConsultorio()
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
        $ruta_foto = uniqid('administrador-consultorio_') . '.' . $ext;

        // DEFINIMOS EL DESTINO DONDE MOVEREMOS EL ARCHIVO
        $destino = BASE_PATH . "/public/uploads/usuarios/" . $ruta_foto;

        // MOVEMOS EL ARCHIVO AL DESTINO
        move_uploaded_file($file['tmp_name'], $destino);
    } else {
        // AGREGAR LA LÓGICA DE LA IMAGEN POR DEFAULT
    }

    //POO - INSTANCIAMOS LA CLASE
    $objAdministrador = new Administrador();
    $data = [
        'nombres' => $nombres,
        'apellidos' => $apellidos,
        'email' => $email,
        'telefono' => $telefono,
        'foto' => $ruta_foto,
        'tipoDocumento' => $tipoDocumento,
        'numeroDocumento' => $numeroDocumento
    ];

    $resultado = $objAdministrador->registrar($data);

    // Si la respuesta del modelo es verdadera confirmamos el registro y redireccionamos
    // Si es falsa notificamos y redirecciomamos
    if ($resultado === true) {
        mostrarSweetAlert('success', 'Registro de administrador de consultorio exitoso', 'Se ha creado un nuevo administrador de consultorio', '/E-VITALIX/superadmin/administradores-consultorio');
    } else {
        mostrarSweetAlert('error', 'Error al registrar', 'No se puedo registrar el administrador de consultorio. Intenta nuevamente');
    }
    exit();
}

function mostrarAdministradoresConsultorios()
{
    $resultado = new Administrador();
    $Administrador = $resultado->consultar();

    return $Administrador;
}

function listarAdministradorConsultorioId($id)
{
    $objAdministrador = new Administrador();

    $administrador = $objAdministrador->listarAdministradorPorId($id);

    return $administrador;
}

function actualizarAdministradorConsultorio()
{
    // Capturamos en variables los datos desde el formulario a través del method posh y los name de los campos
    $id = $_POST['id'] ?? '';
    $nombres = $_POST['nombres'] ?? '';
    $apellidos = $_POST['apellidos'] ?? '';
    $telefono = $_POST['telefono'] ?? '';
    $tipoDocumento = $_POST['tipo_documento'] ?? '';

    // Validamos los campos que son obligatorios
    if (empty($nombres) || empty($apellidos) || empty($telefono) || empty($tipoDocumento)) {
        mostrarSweetAlert('error', 'Campos vacíos', 'Por favor completar los campos obligatorios');
        exit();
    }

    //POO - INSTANCIAMOS LA CLASE
    $objAdministrador = new Administrador();
    $data = [
        'id' => $id,
        'nombres' => $nombres,
        'apellidos' => $apellidos,
        'telefono' => $telefono,
        'tipoDocumento' => $tipoDocumento
    ];

    $resultado = $objAdministrador->actualizar($data);

    // Si la respuesta del modelo es verdadera confirmamos el registro y redireccionamos
    // Si es falsa notificamos y redirecciomamos
    if ($resultado === true) {
        mostrarSweetAlert('success', 'Modificación de administrador de consultorio exitoso', 'Se ha modificado el administrador de consultorio seleccionado', '/E-VITALIX/superadmin/administradores-consultorio');
    } else {
        mostrarSweetAlert('error', 'Error al registrar', 'No se puedo registrar el administrador de consultorio. Intenta nuevamente');
    }
    exit();
}

function eliminarAdministradorConsultorio($id, $id_usuario) {
    $objAdministrador = new Administrador();

    $resultado = $objAdministrador->eliminar($id, $id_usuario);

     // Si la respuesta del modelo es verdadera confirmamos el registro y redireccionamos

    if ($resultado === true) {
        mostrarSweetAlert('success', 'Eliminación exitosa', 'Se ha eliminado el administrador de consultorio seleccionado', '/E-VITALIX/superadmin/administradores-consultorio');
    } else {
        mostrarSweetAlert('error', 'Error al eliminar', 'No se puedo eliminar el administrador de consultorio. Intenta nuevamente');
    }
    exit();
}

function asignarConsultorioAdministrador() {
    // Capturamos en variables los datos desde el formulario a través del method posh y los name de los campos
    $id = $_POST['id'] ?? '';
    $id_consultorio = $_POST['consultorio'] ?? '';

    // Validamos los campos que son obligatorios
    if (empty($id_consultorio)) {
        mostrarSweetAlert('error', 'Campos vacíos', 'Por favor completar los campos obligatorios');
        exit();
    }

    //POO - INSTANCIAMOS LA CLASE
    $objAdministrador = new Administrador();
    $data = [
        'id' => $id,
        'id_consultorio' => $id_consultorio
    ];

    $resultado = $objAdministrador->asignarConsultorio($data);

    // Si la respuesta del modelo es verdadera confirmamos el registro y redireccionamos
    // Si es falsa notificamos y redirecciomamos
    if ($resultado === true) {
        mostrarSweetAlert('success', 'Asignación exitosa', 'Se ha asignado el consultorio al administrador seleccionado', '/E-VITALIX/superadmin/administradores-consultorios');
    } else {
        mostrarSweetAlert('error', 'Error al asignar', 'No se puedo asignar el consultorio al administrador. Intenta nuevamente');
    }
    exit();
}

function desasignarConsultorioAdministrador($id) {
    $objAdministrador = new Administrador();

    $resultado = $objAdministrador->desasignarConsultorio($id);

     // Si la respuesta del modelo es verdadera confirmamos el registro y redireccionamos

    if ($resultado === true) {
        mostrarSweetAlert('success', 'Desasignación exitosa', 'Se ha desasignado el consultorio al administrador seleccionado', '/E-VITALIX/superadmin/administradores-consultorios');
    } else {
        mostrarSweetAlert('error', 'Error al desasignar', 'No se puedo desasignar el consultorio al administrador. Intenta nuevamente');
    }
    exit();
}