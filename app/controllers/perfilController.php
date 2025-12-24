<?php
// Importamos las dependencias
require_once __DIR__ . '/../helpers/alert_helper.php';
require_once __DIR__ . '/../models/perfilModel.php';

function mostrarPerfilSuperAdmin($id)
{
    $objPerfil = new Perfil();

    $usuario = $objPerfil->mostrarPerfilSuperAdmin($id);

    return $usuario;
}

function mostrarPerfilAdmin($id)
{
    $objPerfil = new Perfil();

    $usuario = $objPerfil->mostrarPerfilAdmin($id);

    return $usuario;
}

function mostrarPerfilEspecialista($id)
{
    $objPerfil = new Perfil();

    $usuario = $objPerfil->mostrarPerfilEspecialista($id);

    return $usuario;
}

// Capturamos en una variable el método o solicitud hecha al servidor
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'POST':
        $accion = $_POST['accion'] ?? '';
        if ($accion === 'actualizarInfoPersonalSuperAdmin') {
            actInfoPersonalSuperAdmin();
        } elseif ($accion === 'actualizarContrasenaSuperAdmin') {
            actContrasenaSuperAdmin();
        } elseif ($accion === 'actualizarFotoSuperAdmin') {
            actFotoSuperAdmin();
        } elseif ($accion === 'actualizarInfoPersonalAdmin') {
            actInfoPersonalAdmin();
        } elseif ($accion === 'actualizarFotoAdmin') {
            actFotoAdmin();
        } elseif ($accion === 'actualizarContrasenaAdmin') {
            actContrasenaAdmin();
        } elseif ($accion === 'actualizarInfoPersonalEspecialista') {
            actInfoPersonalEspecialista();
        } elseif ($accion === 'actualizarContrasenaEspecialista') {
            actContrasenaEspecialista();
        }
        elseif ($accion === 'actualizarFotoEspecialista') {
            actFotoEspecialista();
        }
        break;

    default:
        break;
}

function actInfoPersonalSuperAdmin()
{
    // CAPTURAMOS EN VARIABLES LOS VALORES ENVIADOS A TRAVÉS DEL METHOD POST Y LOS NAME DE LOS CAMPOS
    $id = $_POST['id'];
    $nombres = $_POST['nombres'];
    $apellidos = $_POST['apellidos'];
    $email = $_POST['email'];
    $telefono = $_POST['telefono'];

    // VALIDAMOS LOS DATOS OBLIGATORIOS
    if (empty($nombres) || empty($apellidos) || empty($email) || empty($telefono)) {
        mostrarSweetAlert('error', 'Campos vacíos', 'Todos los campos son obligatorios');
        exit();
    }

    // POO - INSTANCIAMOS LA CLASE
    $objPerfil = new Perfil();

    $data = [
        'id' => $id,
        'nombres' => $nombres,
        'apellidos' => $apellidos,
        'email' => $email,
        'telefono' => $telefono
    ];

    // ENVIAMOS LA DATA AL METODO actualizarInfoPersonalAdmin() de la clase instanciada anteriormente Perfil()
    // Y ESPERAMOS UNA RESPUESTA BOOLEANA DEL MODELO
    $resultado = $objPerfil->actualizarInfoPersonalSuperAdmin($data);

    // SI LA RESPUESTA DEL MODELO ES VERDADERA CONFIRMAMOS LA MODIFICACIÓN A REDIRECCIONAMOS
    // SI ES FALSA NOTIFICAMOS Y REDIRECCIONAMOS
    if ($resultado === true) {
        mostrarSweetAlert('success', 'Modificación exitosa', 'Se ha actualizado su información personal', '/E-VITALIX/superadmin/perfil');
    } else {
        mostrarSweetAlert('error', 'Error al actualizar', 'No se pudo modificar su información personal. Intenta nuevamente');
    }
    exit();
}

function actInfoPersonalAdmin()
{
    // CAPTURAMOS EN VARIABLES LOS VALORES ENVIADOS A TRAVÉS DEL METHOD POST Y LOS NAME DE LOS CAMPOS
    $id = $_POST['id'];
    $nombres = $_POST['nombres'];
    $apellidos = $_POST['apellidos'];
    $email = $_POST['email'];
    $telefono = $_POST['telefono'];

    // VALIDAMOS LOS DATOS OBLIGATORIOS
    if (empty($nombres) || empty($apellidos) || empty($email) || empty($telefono)) {
        mostrarSweetAlert('error', 'Campos vacíos', 'Todos los campos son obligatorios');
        exit();
    }

    // POO - INSTANCIAMOS LA CLASE
    $objPerfil = new Perfil();

    $data = [
        'id' => $id,
        'nombres' => $nombres,
        'apellidos' => $apellidos,
        'email' => $email,
        'telefono' => $telefono
    ];

    // ENVIAMOS LA DATA AL METODO actualizarInfoPersonalAdmin() de la clase instanciada anteriormente Perfil()
    // Y ESPERAMOS UNA RESPUESTA BOOLEANA DEL MODELO
    $resultado = $objPerfil->actualizarInfoPersonalAdmin($data);

    // SI LA RESPUESTA DEL MODELO ES VERDADERA CONFIRMAMOS LA MODIFICACIÓN A REDIRECCIONAMOS
    // SI ES FALSA NOTIFICAMOS Y REDIRECCIONAMOS
    if ($resultado === true) {


        mostrarSweetAlert('success', 'Modificación exitosa', 'Se ha actualizado su información personal', '/E-VITALIX/admin/perfil');
    } else {
        mostrarSweetAlert('error', 'Error al actualizar', 'No se pudo modificar su información personal. Intenta nuevamente');
    }
    exit();
}

function actInfoPersonalEspecialista()
{
    // CAPTURAMOS EN VARIABLES LOS VALORES ENVIADOS A TRAVÉS DEL METHOD POST Y LOS NAME DE LOS CAMPOS
    $id = $_POST['id'];
    $nombres = $_POST['nombres'];
    $apellidos = $_POST['apellidos'];
    $email = $_POST['email'];
    $telefono = $_POST['telefono'];

    // VALIDAMOS LOS DATOS OBLIGATORIOS
    if (empty($nombres) || empty($apellidos) || empty($email) || empty($telefono)) {
        mostrarSweetAlert('error', 'Campos vacíos', 'Todos los campos son obligatorios');
        exit();
    }

    // POO - INSTANCIAMOS LA CLASE
    $objPerfil = new Perfil();

    $data = [
        'id' => $id,
        'nombres' => $nombres,
        'apellidos' => $apellidos,
        'email' => $email,
        'telefono' => $telefono
    ];

    // ENVIAMOS LA DATA AL METODO actualizarInfoPersonalAdmin() de la clase instanciada anteriormente Perfil()
    // Y ESPERAMOS UNA RESPUESTA BOOLEANA DEL MODELO
    $resultado = $objPerfil->actualizarInfoPersonalEspecialista($data);

    // SI LA RESPUESTA DEL MODELO ES VERDADERA CONFIRMAMOS LA MODIFICACIÓN A REDIRECCIONAMOS
    // SI ES FALSA NOTIFICAMOS Y REDIRECCIONAMOS
    if ($resultado === true) {


        mostrarSweetAlert('success', 'Modificación exitosa', 'Se ha actualizado su información personal', '/E-VITALIX/especialista/perfil');
    } else {
        mostrarSweetAlert('error', 'Error al actualizar', 'No se pudo modificar su información personal. Intenta nuevamente');
    }
    exit();
}

function actContrasenaSuperAdmin()
{
    // CAPTURAMOS EN VARIABLES LOS VALORES ENVIADOS A TRAVÉS DEL METHOD POST Y LOS NAME DE LOS CAMPOS
    $id = $_POST['id'];
    $claveActual = $_POST['claveActual'];
    $claveNueva = $_POST['claveNueva'];
    $confirmarClave = $_POST['confirmarClave'];

    // VALIDAMOS LOS DATOS QUE SON OBLIGATORIOS
    if (empty($claveActual) || empty($claveNueva) || empty($confirmarClave)) {
        mostrarSweetAlert('error', 'Campos vacíos', 'Todos los campos son obligatorios');
        exit();
    }


    // VALIDAMOS QUE LA NUEVA CONTRASEÑA Y SU CONFIRMACIÓN COINCIDAN
    if ($claveNueva !== $confirmarClave) {
        mostrarSweetAlert('error', 'Contraseñas no coinciden', 'La nueva contraseña y su confirmación deben ser iguales');
        exit();
    }

    // POO - INSTANCIAMOS LA CLASE
    $objPerfil = new Perfil();

    $data = [
        'id' => $id,
        'claveActual' => $claveActual,
        'claveNueva' => $claveNueva,
    ];

    // ENVIAMOS LA DATA AL METODO actualizarContrasenaAdmin() de la clase instanciada anteriormente Perfil()
    // Y ESPERAMOS UNA RESPUESTA BOOLEANA DEL MODELO

    $resultado = $objPerfil->actualizarContrasenaSuperAdmin($data);

    // SI LA RESPUESTA DEL MODELO ES VERDADERA CONFIRMAMOS LA MODIFICACIÓN A REDIRECCIONAMOS
    // SI ES FALSA NOTIFICAMOS Y REDIRECCIONAMOS
    if ($resultado === true) {
        mostrarSweetAlert('success', 'Modificación exitosa', 'Se actualizó su contraseña correctamente', '/E-VITALIX/superadmin/perfil');
    } else {
        mostrarSweetAlert('error', 'Error al Modificar', 'No se pudo modificar su contraseña. Intenta nuevamente');
    }
    exit();
}

function actContrasenaAdmin()
{
    // CAPTURAMOS EN VARIABLES LOS VALORES ENVIADOS A TRAVÉS DEL METHOD POST Y LOS NAME DE LOS CAMPOS
    $id = $_POST['id'];
    $claveActual = $_POST['claveActual'];
    $claveNueva = $_POST['claveNueva'];
    $confirmarClave = $_POST['confirmarClave'];

    // VALIDAMOS LOS DATOS QUE SON OBLIGATORIOS
    if (empty($claveActual) || empty($claveNueva) || empty($confirmarClave)) {
        mostrarSweetAlert('error', 'Campos vacíos', 'Todos los campos son obligatorios');
        exit();
    }
    // VALIDAMOS QUE LA NUEVA CONTRASEÑA Y SU CONFIRMACIÓN COINCIDAN
    if ($claveNueva !== $confirmarClave) {
        mostrarSweetAlert('error', 'Contraseñas no coinciden', 'La nueva contraseña y su confirmación deben ser iguales');
        exit();
    }
    // POO - INSTANCIAMOS LA CLASE
    $objPerfil = new Perfil();
    $data = [
        'id' => $id,
        'claveActual' => $claveActual,
        'claveNueva' => $claveNueva,
    ];
    // ENVIAMOS LA DATA AL METODO actualizarContrasenaAdmin() de la clase instanciada anteriormente Perfil()
    // Y ESPERAMOS UNA RESPUESTA BOOLEANA DEL MODELO
    $resultado = $objPerfil->actualizarContrasenaAdmin($data);
    // SI LA RESPUESTA DEL MODELO ES VERDADERA CONFIRMAMOS LA MODIFICACIÓN A REDIRECCIONAMOS
    // SI ES FALSA NOTIFICAMOS Y REDIRECCIONAMOS
    if ($resultado === true) {
        mostrarSweetAlert('success', 'Modificación exitosa', 'Se actualizó su contraseña correctamente', '/E-VITALIX/admin/perfil');
    } else {
        mostrarSweetAlert('error', 'Error al Modificar', 'No se pudo modificar su contraseña. Intenta nuevamente');
    }
    exit();
}

function actContrasenaEspecialista()
{
    // CAPTURAMOS EN VARIABLES LOS VALORES ENVIADOS A TRAVÉS DEL METHOD POST Y LOS NAME DE LOS CAMPOS
    $id = $_POST['id'];
    $claveActual = $_POST['claveActual'];
    $claveNueva = $_POST['claveNueva'];
    $confirmarClave = $_POST['confirmarClave'];

    // VALIDAMOS LOS DATOS QUE SON OBLIGATORIOS
    if (empty($claveActual) || empty($claveNueva) || empty($confirmarClave)) {
        mostrarSweetAlert('error', 'Campos vacíos', 'Todos los campos son obligatorios');
        exit();
    }
    // VALIDAMOS QUE LA NUEVA CONTRASEÑA Y SU CONFIRMACIÓN COINCIDAN
    if ($claveNueva !== $confirmarClave) {
        mostrarSweetAlert('error', 'Contraseñas no coinciden', 'La nueva contraseña y su confirmación deben ser iguales');
        exit();
    }

    // POO - INSTANCIAMOS LA CLASE
    $objPerfil = new Perfil();
    $data = [
        'id' => $id,
        'claveActual' => $claveActual,
        'claveNueva' => $claveNueva,
    ];
    // ENVIAMOS LA DATA AL METODO actualizarContrasenaAdmin() de la clase instanciada anteriormente Perfil()
    // Y ESPERAMOS UNA RESPUESTA BOOLEANA DEL MODELO
    $resultado = $objPerfil->actualizarContrasenaEspecialista($data);
    // SI LA RESPUESTA DEL MODELO ES VERDADERA CONFIRMAMOS LA MODIFICACIÓN A REDIRECCIONAMOS
    // SI ES FALSA NOTIFICAMOS Y REDIRECCIONAMOS
    if ($resultado === true) {
        mostrarSweetAlert('success', 'Modificación exitosa', 'Se actualizó su contraseña correctamente', '/E-VITALIX/especialista/perfil');
    } else {
        mostrarSweetAlert('error', 'Error al Modificar', 'No se pudo modificar su contraseña. Intenta nuevamente');
    }
    exit();
}

function actFotoSuperAdmin()
{
    // CAPTURAMOS EN VARIABLES LOS VALORES ENVIADOS A TRAVÉS DEL METHOD POST Y LOS NAME DE LOS CAMPOS
    $id = $_POST['id'];

    // VALIDAMOS LOS DATOS OBLIGATORIOS
    if (empty($_FILES['foto']['name'])) {
        mostrarSweetAlert('error', 'Campo vacío', 'Este campo es obligatorio');
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
        $permitidas = ['jpg', 'png', 'jpeg'];

        // VALIDAMOS QUE LA EXTENSIÓN DE LA IMAGEN CARGADA ESTÉ DENTRO DE LAS PERMITIDAS
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
        $destino = BASE_PATH . '/public/uploads/usuarios/' . $ruta_foto;

        // MOVEMOS EL ARCHIVO A DESTINO
        move_uploaded_file($file['tmp_name'], $destino);
    } else {
        // AGREGAR LA LÓGICA DE UNA IMAGEN POR DEFECTO
    }

    // POO - INSTANCIAMOS LA CLASE
    $objPerfil = new Perfil();

    $data = [
        'id' => $id,
        'foto' => $ruta_foto
    ];

    // ENVIAMOS LA DATA AL METODO actualizarFotoAdmin() de la clase instanciada anteriormente Perfil()
    // Y ESPERAMOS UNA RESPUESTA BOOLEANA DEL MODELO

    $resultado = $objPerfil->actualizarFotoSuperAdmin($data);

    // SI LA RESPUESTA DEL MODELO ES VERDADERA CONFIRMAMOS LA MODIFICACIÓN A REDIRECCIONAMOS
    // SI ES FALSA NOTIFICAMOS Y REDIRECCIONAMOS
    if ($resultado === true) {
        mostrarSweetAlert('success', 'Modificación exitosa', 'Se actualizó su foto correctamente', '/E-VITALIX/superadmin/perfil');
    } else {
        mostrarSweetAlert('error', 'Error al Modificar', 'No se pudo modificar su foto. Intenta nuevamente');
    }
    exit();
}

function actFotoAdmin()
{
    // CAPTURAMOS EN VARIABLES LOS VALORES ENVIADOS A TRAVÉS DEL METHOD POST Y LOS NAME DE LOS CAMPOS
    $id = $_POST['id'];

    // VALIDAMOS LOS DATOS OBLIGATORIOS
    if (empty($_FILES['foto']['name'])) {
        mostrarSweetAlert('error', 'Campo vacío', 'Este campo es obligatorio');
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
        $permitidas = ['jpg', 'png', 'jpeg'];

        // VALIDAMOS QUE LA EXTENSIÓN DE LA IMAGEN CARGADA ESTÉ DENTRO DE LAS PERMITIDAS
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
        $ruta_foto = uniqid('administrador_') . '.' . $ext;

        // DEFINIMOS EL DESTINO DONDE MOVEREMOS EL ARCHIVO
        $destino = BASE_PATH . '/public/uploads/usuarios/' . $ruta_foto;

        // MOVEMOS EL ARCHIVO A DESTINO
        move_uploaded_file($file['tmp_name'], $destino);
    } else {
        // AGREGAR LA LÓGICA DE UNA IMAGEN POR DEFECTO
    }

    // POO - INSTANCIAMOS LA CLASE
    $objPerfil = new Perfil();

    $data = [
        'id' => $id,
        'foto' => $ruta_foto
    ];

    // ENVIAMOS LA DATA AL METODO actualizarFotoAdmin() de la clase instanciada anteriormente Perfil()
    // Y ESPERAMOS UNA RESPUESTA BOOLEANA DEL MODELO

    $resultado = $objPerfil->actualizarFotoAdmin($data);

    // SI LA RESPUESTA DEL MODELO ES VERDADERA CONFIRMAMOS LA MODIFICACIÓN A REDIRECCIONAMOS
    // SI ES FALSA NOTIFICAMOS Y REDIRECCIONAMOS
    if ($resultado === true) {
        mostrarSweetAlert('success', 'Modificación exitosa', 'Se actualizó su foto correctamente', '/E-VITALIX/admin/perfil');
    } else {
        mostrarSweetAlert('error', 'Error al Modificar', 'No se pudo modificar su foto. Intenta nuevamente');
    }
    exit();
}

function actFotoEspecialista()
{
    // CAPTURAMOS EN VARIABLES LOS VALORES ENVIADOS A TRAVÉS DEL METHOD POST Y LOS NAME DE LOS CAMPOS
    $id = $_POST['id'];

    // VALIDAMOS LOS DATOS OBLIGATORIOS
    if (empty($_FILES['foto']['name'])) {
        mostrarSweetAlert('error', 'Campo vacío', 'Este campo es obligatorio');
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
        $permitidas = ['jpg', 'png', 'jpeg'];

        // VALIDAMOS QUE LA EXTENSIÓN DE LA IMAGEN CARGADA ESTÉ DENTRO DE LAS PERMITIDAS
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
        $ruta_foto = uniqid('especialista_') . '.' . $ext;

        // DEFINIMOS EL DESTINO DONDE MOVEREMOS EL ARCHIVO
        $destino = BASE_PATH . '/public/uploads/usuarios/' . $ruta_foto;

        // MOVEMOS EL ARCHIVO A DESTINO
        move_uploaded_file($file['tmp_name'], $destino);
    } else {
        // AGREGAR LA LÓGICA DE UNA IMAGEN POR DEFECTO
    }

    // POO - INSTANCIAMOS LA CLASE
    $objPerfil = new Perfil();

    $data = [
        'id' => $id,
        'foto' => $ruta_foto
    ];

    // ENVIAMOS LA DATA AL METODO actualizarFotoAdmin() de la clase instanciada anteriormente Perfil()
    // Y ESPERAMOS UNA RESPUESTA BOOLEANA DEL MODELO

    $resultado = $objPerfil->actualizarFotoEspecialista($data);

    // SI LA RESPUESTA DEL MODELO ES VERDADERA CONFIRMAMOS LA MODIFICACIÓN A REDIRECCIONAMOS
    // SI ES FALSA NOTIFICAMOS Y REDIRECCIONAMOS
    if ($resultado === true) {
        mostrarSweetAlert('success', 'Modificación exitosa', 'Se actualizó su foto correctamente', '/E-VITALIX/especialista/perfil');
    } else {
        mostrarSweetAlert('error', 'Error al Modificar', 'No se pudo modificar su foto. Intenta nuevamente');
    }
    exit();
}
