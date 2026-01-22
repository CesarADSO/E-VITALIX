<?php
session_start();
// Validamos si hay una sesión activa
if (!isset($_SESSION['user'])) {
    header('Location: /E-VITALIX/login');
    exit();
}

// Validamos que el rol sea el correspondiente
if ($_SESSION['user']['rol'] != 4) {
    header ('Location: /E-VITALIX/login');
    exit();
}
?>