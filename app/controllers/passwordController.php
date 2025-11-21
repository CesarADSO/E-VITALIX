<?php
// Importamos las dependencias
require_once __DIR__ . '/../helpers/alert_helper.php';
require_once __DIR__ . '/../models/recoveryPassModel.php';

// CAPTURAMOS EN VARIABLES LO QUE VENGAS A TRAVÉS DEL METHOD POST Y LOS NAME DE LOS CAMPOS
$email = $_POST['email'] ?? '';

if (empty($email)) {
    mostrarSweetAlert('error', 'Campo vacío', 'Por favor completar');
    exit();
}

// POO - INSTANCIAMOS LA CLASE
$objModelo = new RecoveryPass();
$resultado = $objModelo->recuperarClave($email);

// AGREGAR SWEETALERT DE ENVIO O NO ENVÍO DEL CORREO
// Si la respuesta del modelo es verdadera confirmamos el registro y redireccionamos
// Si es falsa notificamos y redirecciomamos
if ($resultado === true) {
    mostrarSweetAlert('success', 'Nueva clave generada', 'Se ha enviado una nueva contraseña a tu correo electrónico', '/E-VITALIX/login');
} else {
    mostrarSweetAlert('error', 'Usuario no encontrado', 'Verifique su correo electrónico e intente nuevamente');
}
exit();
