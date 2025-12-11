<?php
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: /E-VITALIX/login');
    exit();
}

// Validar rol correcto (1 = Paciente)
if ($_SESSION['user']['rol'] != 1) {
    header('Location: /E-VITALIX/login');
    exit();
}

?>