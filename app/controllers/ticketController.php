<?php
require_once __DIR__ . '/../helpers/alert_helper.php';
require_once __DIR__ . '/../models/ticketModel.php';

// GUARDAMOS EN UNA VARIABLE METODO PARA USARLO EN EL SWITCH LA REQUEST QUE HAGA EL CLIENTE
$method = $_SERVER['REQUEST_METHOD'];

// ACÁ VALIDAMOS QUE SI LA REQUEST QUE VIENE EN LA VARIABLE ES TAL PUES QUE HAGA TAL COSA
switch ($method) {
    case 'POST':
        crear();
        break;

    default:
        # code...
        break;
}

// CREAMOS LA FUNCIÓN QUE SE EJECUTARÁ CUANDO LA REQUEST SEA POST, ESTA FUNCIÓN SE ENCARGARÁ DE PROCESAR LOS DATOS DEL FORMULARIO Y GUARDAR EL TICKET EN LA BASE DE DATOS
function crear()
{

    // REANUDAMOS LA SESIÓN PARA PODER ACCEDER A LOS DATOS DEL USUARIO LOGUEADO
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }

    // GUARDAMOS EN UNA VARIABLE EL ID DEL USUARIO LOGUEADO PARA USARLO COMO FK EN LA BASE DE DATOS EN EL CAMPOS id_usuario DE LA TABLA TICKETS

    $id_usuario = $_SESSION['user']['id'];

    if (empty($id_usuario)) {
        mostrarSweetAlert('error', 'Id de usuario vacio', 'No está llegando el id del usuario logeado');
        exit();
    }

    // GUARDAMOS EN VARIABLES LOS DATOS QUE VIENEN A TRAVÉS DEL METHOD POST Y LOS NAME DE LOS CAMPOS DEL FORMULARIO
    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];

    // VALIDAMOS LOS CAMPOS QUE SON OBLIGATORIOS
    if (empty($id_usuario) || empty($titulo) || empty($descripcion)) {
        mostrarSweetAlert('error', 'Campos vacios', 'Por favor completar los campos obligatorios');
        exit();
    }

    // DECLARAMOS UNA VARIABLE VACÍA QUE DESPUES CONTENDRÁ LA IMAGEN QUE SE ENVIARA DESDE EL TICKET DE SOPORTE
    $ruta_foto = null;

    // VALIDAMOS SI SE ENVIÓ O NO LA FOTO DESDE EL FORMULARIO
    // **** SI EL ADMINISTRADOR NO REGISTRÓ UNA FOTO DEJAR UNA IMAGEN POR DEFECTO
    if (!empty($_FILES['foto']['name'])) {

        $file = $_FILES['foto'];

        // OBTENEMOS LA EXTENSIÓN DEL ARCHIVO
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

        // DEFINIMOS LAS EXTENSIONES PERMITIDAS
        $permitidas = ['png', 'jpg', 'jpeg'];

        // VALIDAMOS QUE LA EXTENSIÓN DE LA IMAGEN CARGADA ESTÉ DENTRO DE LAS PERMITIDAS
        if (!in_array($ext, $permitidas)) {
            mostrarSweetAlert('error', 'Extensión no permitida', 'Señor usuario cargue una extensión que sea permitida');
            exit();
        }

        // VALIDAMOS QUE EL TAMAÑO DE LA IMAGEN SEA MAX DE 2MB
        if ($file['size'] > 2 * 1024 * 1024) {
            mostrarSweetAlert('error', 'Error al cargar la foto', 'Señor usuario el peso de la foto es superior a 2 mb');
            exit();
        }

        // DEFINIMOS EL NOMBRE DEL ARCHIVO Y LE CONCATENAMOS LA EXTENSIÓN
        $ruta_foto = uniqid('ticket_') . '.' . $ext;

        // DEFINIMOS EL DESTINO DONDE MOVEREMOS EL ARCHIVO
        $destino = BASE_PATH . '/app/public/uploads/tickets/' . $ruta_foto;

        // MOVEMOS EL ARCHIVO A DESTINO
        move_uploaded_file($file['tmp_name'], $destino);
    } else {
        // AGREGAR LA LÓGICA DE LA IMAGEN POR DEFAULT
        $ruta_foto = 'default-administrador.jpg';
    }

    // INSTANCIAMOS LA CLASE Ticket DEL MODELO ticketModel.php
    $objTicket = new Ticket();

    // EN EL ARREGLO DATA INSERTAMOS LOS DATOS QUE SE VAN A ENVIAR
    $data = [
        'titulo' => $titulo,
        'descripcion' => $descripcion,
        'foto' => $ruta_foto,
        'id_usuario' => $id_usuario
    ];

    // ACCEDEMOS AL MÉTODO O FUNCIÓN DE LA CLASE Ticket
    $resultado = $objTicket->crear($data);

    // ESPERAMOS UNA RESPUESTA BOOLEANA DEL MODELO Y NOTIFICAMOS SI HAY ÉXITO O ERROR
    if ($resultado === true) {
        mostrarSweetAlert('success', 'Creación de ticket exitosa', 'Espera a que el super administrador devuelva una respuesta', '/E-VITALIX/administrador/dashboard');
    } else {
        mostrarSweetAlert('error', 'Error al crear el ticket', 'No se pudo crear el ticket. Intenta nuevamente');
    }
    exit();
}



// require_once __DIR__ . '/../views/dashboard/administrador/crear-ticket.php';





// function crear() {

//     // 1️⃣ Verificar sesión
//     if (!isset($_SESSION['id'])) {
//         header("Location: login");
//         exit;
//     }

//     // 2️⃣ Verificar método POST
//     if ($_SERVER['REQUEST_METHOD'] === 'POST') {

//         // 3️⃣ Validaciones básicas
//         if (empty($_POST['titulo']) || empty($_POST['descripcion'])) {
//             $_SESSION['error'] = "Todos los campos son obligatorios";
//             header("Location: /admin/crear-ticket ");
//             exit;
//         }

//         // 4️⃣ Manejo de imagen
//         $imagen = null;
//         if (!empty($_FILES['imagen']['name'])) {

//             $permitidos = ['image/jpeg', 'image/png'];
//             if (!in_array($_FILES['imagen']['type'], $permitidos)) {
//                 $_SESSION['error'] = "Formato de imagen no permitido";
//                 header("Location: /admin/crear-ticket");
//                 exit;
//             }

//             if ($_FILES['imagen']['size'] > 2000000) {
//                 $_SESSION['error'] = "La imagen no debe superar 2MB";
//                 header("Location: /admin/crear-ticket");
//                 exit;
//             }

//             $imagen = time() . "_" . $_FILES['imagen']['name'];
//             move_uploaded_file(
//                 $_FILES['imagen']['tmp_name'],
//                 "public/uploads/" . $imagen
//             );
//         }

//         // 5️⃣ Guardar ticket
//         $ticket = new Ticket($GLOBALS['db']);
//         $ticket->crear(
//             $_SESSION['id'],        // FK usuario_id
//             $_POST['titulo'],
//             $_POST['descripcion'],
//             $imagen
//         );

//         // 6️⃣ Correo al superadmin
//         mail(
//             "superadmin@e-vitalix.com",
//             "Nuevo Ticket de Soporte - E-VITALIX",
//             "Un usuario ha creado un nuevo ticket.\n\nTítulo: {$_POST['titulo']}"
//         );

//         // 7️⃣ Redirección
//         header("Location: tickets");
//         exit;
//     }

//     // 8️⃣ Vista
//     require 'views/tickets/crear.php';
// }