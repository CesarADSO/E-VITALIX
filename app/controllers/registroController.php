<?php
// Importamos las dependencias
require_once __DIR__ . '/../helpers/alert_helper.php';
require_once __DIR__ . '/../models/registroModel.php';

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'POST':
        registrarPaciente();
        break;
    
    default:
        
        break;
}


function registrarPaciente() {
    // CAPTURAMOS LOS DATOS QUE VIENEN A TRAVÉS DEL METHOD POST Y LOS NAME DE LOS CAMPOS
    $nombres = $_POST['nombres'];
    $apellidos = $_POST['apellidos'];
    $tipo_documento = $_POST['tipo_documento'];
    $numero_documento = $_POST['numero_documento'];
    $email = $_POST['email'];
    $telefono = $_POST['telefono'];


    // VALIDAMOS LOS CAMPOS OBLIGATORIOS
    if (empty($nombres) || empty($apellidos) || empty($tipo_documento) || empty($numero_documento) || empty($email) || empty($telefono)) {
        mostrarSweetAlert('error', 'Campos vacíos', 'Por favor completar los campos obligatorios');
        exit();
    }


    // INSTANCIAMOS LA CLASE DEL MODELO
    $objRegistro = new Registro();

    // CREAMOS UNA VARIABLE LLAMADA DATA PARA ALMACENAR LOS DATOS PARA LUEGO PASARSELOS AL MODELO
    $data = [
        'nombres'=> $nombres,
        'apellidos'=> $apellidos,
        'tipo_documento'=> $tipo_documento,
        'numero_documento'=> $numero_documento,
        'email'=> $email,
        'telefono'=> $telefono
    ];

    $resultado = $objRegistro->registrar($data);

    if ($resultado) {
        mostrarSweetAlert('success', 'Registro Exitoso', '¡Te has registrado correctamente! Ahora puedes iniciar sesión.', '/E-VITALIX/login');
    } else {
        mostrarSweetAlert('error', 'Error en el Registro', 'Hubo un problema al registrar tus datos. Por favor, intenta nuevamente.');
    }
}