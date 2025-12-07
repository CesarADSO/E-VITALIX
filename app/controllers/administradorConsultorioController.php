<?php
// IMPORTAMOS LAS DEPENDENCIAS NECESARIAS
require_once __DIR__ . '/../helpers/alert_helper.php';
require_once __DIR__ . '/../models/administradorConsultorioModel.php';

// Capturamos en una variable el método o solicitud hecha al servidor
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'POST':
        registrarAdministradorConsultorio();
        break;
    case 'GET':
        if (isset($_GET['id'])) {
            listarAdministradorConsultorioId($_GET['id']);
        }
        mostrarAdministradoresConsultorios();
        break;
    default:
        # code...
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
        'foto' => $ruta_foto,
        'tipoDocumento' => $tipoDocumento,
        'numeroDocumento' => $numeroDocumento
    ];

    $resultado = $objAdministrador->registrar($data);

    // Si la respuesta del modelo es verdadera confirmamos el registro y redireccionamos
    // Si es falsa notificamos y redirecciomamos
    if ($resultado === true) {
        mostrarSweetAlert('success', 'Registro de administrador de consultorio exitoso', 'Se ha creado un nuevo administrador de consultorio', '/E-VITALIX/admin/consultorios');
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

function listarAdministradorConsultorioId($id) {
    $objAdministrador = new Administrador();

    $administrador = $objAdministrador->listarAdministradorPorId($id);

    return $administrador;
}
