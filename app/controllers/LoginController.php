<?php
// Importamos las dependencias
require_once __DIR__ . '/../helpers/alert_helper.php';
require_once __DIR__ . '/../models/LoginModel.php';

// $clave = '123';
// echo password_hash($clave, PASSWORD_DEFAULT);

// Ejecutar según la solicitud al servidor en este caso POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Capturamos en variables los valores enviados a través de los name de los campos y method post del formulario
    $correo = $_POST['email'] ?? '';
    $clave = $_POST['clave'] ?? '';


    // Validamos que los campos/variables no estén vacias

    if (empty($correo) || empty($clave)) {
        mostrarSweetAlert('error', 'Campos vacíos', 'Por favor completar');
        exit();
    }

    // pdo - instanciamos la clase del modelo, para acceder a un method (función) en específico
    $login = new Login();
    $resultado = $login->autenticar($correo, $clave);

    // Verificar si el modelo devolvio un error
    if (isset($resultado['error'])) {
        mostrarSweetAlert('error', 'Error de autenticación', $resultado['error']);
        exit();
    }

    // Si pasa esta línea, el usuario es válido
    session_start();


    // Guardamos los datos principales del usuario en la sesión
    $_SESSION['user'] = [
        'id' => $resultado['id_usuario'],
        'nombres' => $resultado['nombres'],
        'apellidos' => $resultado['apellidos'],
        'rol' => $resultado['id_rol'],
        'id_consultorio' => $resultado['id_consultorio'] ?? null,
        'id_especialista' => $resultado['id_especialista'] ?? null,
        'id_paciente' => $resultado['id_paciente'] ?? null,
        'perfil_completo' => $resultado['perfil_completo'] ?? null
    ];

    // Redirección según el rol
    $redirecUrl = '/E-VITALIX/login';
    $mensaje = 'Rol inexistente. Redirigiendo al inicio de sesión';

    switch ($resultado['id_rol']) {
        case 1:
            if ($resultado['perfil_completo'] === 0) {
                $redirecUrl = '/E-VITALIX/paciente/completar-perfil';
            }
            else {
                $redirecUrl = '/E-VITALIX/paciente/dashboard';
            }
            $mensaje = 'Bienvenido Paciente';
            break;

        case 2:
            $redirecUrl = '/E-VITALIX/administrador/dashboard';
            $mensaje = 'Bienvenido Administrador';
            break;

        case 3:
            $redirecUrl = '/E-VITALIX/especialista/dashboard';
            $mensaje = 'Bienvenido Especialista';
            break;

        case 4:
            $redirecUrl = '/E-VITALIX/asistente/dashboard';
            $mensaje = 'Bienvenido asistente';
            break;
        case 5:
            $redirecUrl = '/E-VITALIX/superadmin/dashboard';
            $mensaje = 'Bienvenido Superadministrador';
            break;
    }

    mostrarSweetAlert('success', 'Ingreso Exitoso', $mensaje, $redirecUrl);
    exit();
} else {
    http_response_code(405);
    echo "Método no permitido";
    exit();
}
