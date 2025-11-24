<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


require_once __DIR__ . '/../../vendor/PHPMailer/Exception.php';
require_once __DIR__ . '/../../vendor/PHPMailer/PHPMailer.php';
require_once __DIR__ . '/../../vendor/PHPMailer/SMTP.php';

function mailer_init() {
    $mail = new PHPMailer(true);

    $mail->SMTPDebug = 0;                      //Enable verbose debug output
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->isSMTP();                                            //Send using SMTP
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'evitalix558@gmail.com';                     //SMTP username
    $mail->Password   = 'eerxgardjexasalb';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 465;
    $mail->isHTML(true); //Set email format to HTML
    $mail->CharSet = "UTF-8";

    return $mail;
}
?>