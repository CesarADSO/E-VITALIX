<?php
require_once __DIR__ . '/../../config/database.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


require_once __DIR__ . '/../../vendor/PHPMailer/Exception.php';
require_once __DIR__ . '/../../vendor/PHPMailer/PHPMailer.php';
require_once __DIR__ . '/../../vendor/PHPMailer/SMTP.php';

class RecoveryPass
{
    private $conexion;

    public function __construct()
    {
        $db = new Conexion();
        $this->conexion = $db->getConexion();
    }

    public function recuperarClave($email)
    {
        try {
            $consultar = "SELECT * FROM usuarios WHERE email = :email AND estado = 'Activo' LIMIT 1";

            $resultado = $this->conexion->prepare($consultar);

            $resultado->bindParam(':email', $email);

            $resultado->execute();

            $user = $resultado->fetch();

            if ($user) {

                // GENERAMOS LA NUEVA CONTRASEÑA A PARTIR DE UNA BASE DE CARACTERES Y UN RANDOM
                $caracteres = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

                // MEZCLAMOS LA CADENA DE CARACTERES
                $random = str_shuffle($caracteres);

                // SUBSTRAEMOS UNA CANTIDAD DEFINIDA DE ESTE RANDOM
                // EL 0 SIGNIFICA LA POSICIÓN DESDE DONDE VOY A EMPEZAR A CONTAR
                // EL 8 SIGNIFICA LA CANTIDAD CARACTERES QUE VA A MOSTRAR
                $nuevaClave = substr($random, 0, 8);

                // EMCRIPTAMOS LA NUEVA CLAVE
                $claveEncriptada = password_hash($nuevaClave, PASSWORD_DEFAULT);


                // ACTUALIZAMOS LA CLAVE EN LA TABLA USUARIOS ANTES DE ENVIAR EL EMAIL
                $actualizarClave = "UPDATE usuarios SET contrasena = :claveEncriptada WHERE id = :id";

                $resultado2 = $this->conexion->prepare($actualizarClave);
                $resultado2->bindParam(':id', $user['id']);
                $resultado2->bindParam(':claveEncriptada', $claveEncriptada);

                $resultado2->execute();

                // DESPUES DE ACTUALIZAR SE ENVÍA EL EMAIL

                $mail = new PHPMailer(true);

                try {
                    //Server settings
                    $mail->SMTPDebug = 0;                      //Enable verbose debug output
                    $mail->isSMTP();                                            //Send using SMTP
                    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
                    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                    $mail->Username   = 'evitalix558@gmail.com';                     //SMTP username
                    $mail->Password   = 'eerxgardjexasalb';                               //SMTP password
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
                    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                    //Recipients
                    // EMISOR Y NOMBRE DE LA PERSONA O ROL
                    $mail->setFrom('evitalix558@gmail.com', 'Soporte E-VITALIX');
                    // RECEPTOR, A QUIÉN QUIERO QUE LLEGUE EL CORREO
                    $mail->addAddress($user['email']);     //Add a recipient
                    // $mail->addAddress('ellen@example.com');               //Name is optional
                    // $mail->addReplyTo('info@example.com', 'Information');
                    // $mail->addCC('cc@example.com');
                    // $mail->addBCC('bcc@example.com');

                    //Attachments
                    // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
                    // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

                    //Content
                    $mail->isHTML(true); //Set email format to HTML
                    $mail->CharSet = "UTF-8";
                    $mail->Subject = "E-VITALIX - NUEVA CLAVE GENERADA";
                    $mail->Body    = '
            
            

           <!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: "Nunito", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            background-color: #f5f5f5;
            padding: 20px;
        }
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 123, 255, 0.1);
        }
        .header {
            background: linear-gradient(135deg, #007bff 0%, #0c498a 100%);
            padding: 40px 30px;
            text-align: center;
        }
        .logo {
            max-width: 180px;
            height: auto;
            margin-bottom: 20px;
        }
        .header h1 {
            color: #ffffff;
            font-size: 30px;
            font-weight: 600;
            margin: 0;
        }
        .header p {
            color: #ffffff;
            font-size: 14px;
            margin-top: 8px;
            opacity: 0.95;
        }
        .content {
            padding: 40px 30px;
        }
        .info-card {
            background-color: #f8f9fa;
            border-left: 4px solid #007bff;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 8px;
        }
        .info-label {
            color: #0c498a;
            font-size: 14px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
        }
        .info-value {
            color: #333333;
            font-size: 16px;
            line-height: 1.6;
            word-wrap: break-word;
        }
        .password-box {
            background: linear-gradient(135deg, #e7f3ff 0%, #f0f8ff 100%);
            border: 2px solid #007bff;
            border-radius: 12px;
            padding: 25px;
            margin-top: 20px;
            text-align: center;
        }
        .password-box .info-label {
            color: #0c498a;
            font-size: 16px;
            margin-bottom: 15px;
        }
        .password-value {
            background-color: #ffffff;
            color: #007bff;
            font-size: 28px;
            font-weight: 700;
            letter-spacing: 3px;
            padding: 20px;
            border-radius: 8px;
            border: 2px dashed #007bff;
            font-family: "Nunito", sans-serif;
            word-break: break-all;
        }
        .password-note {
            color: #969696;
            font-size: 12px;
            margin-top: 15px;
            font-style: italic;
        }
        .footer {
            background-color: #f8f9fa;
            padding: 25px 30px;
            text-align: center;
            border-top: 1px solid #e9ecef;
        }
        .footer p {
            color: #969696;
            font-size: 14px;
            margin: 5px 0;
        }
        .brand-name {
            color: #007bff;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <img src="https://raw.githubusercontent.com/CesarADSO/imagenes-evitalix/refs/heads/main/LOGO%20NEGATIVO.png" alt="E-VITALIX Logo" class="logo">
            <h1>🔐 Recuperación de Contraseña</h1>
            <p>Sistema E-VITALIX</p>
        </div>
        
        <div class="content">
            <div class="password-box">
                <div class="info-label">🔐 Tu Nueva Contraseña</div>
                <div class="password-value">' . htmlspecialchars($nuevaClave) . '</div>
                <p class="password-note">⚠️ Por seguridad, te recomendamos cambiar esta contraseña después de iniciar sesión</p>
            </div>
        </div>
        
        <div class="footer">
            <p><strong class="brand-name">E-VITALIX</strong></p>
            <p>Sistema de Recuperación de Contraseñas</p>
            <p style="margin-top: 15px; font-size: 12px;">Este es un correo automático, por favor no responder directamente.</p>
        </div>
    </div>
</body>
</html>

            
            
            ';
                    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

                    $mail->send();
                    return true;
                } catch (Exception $e) {
                    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                }
            } else {
                return ['error' => 'Usuario no encontrado o inactivo'];
            }
        } catch (PDOException $e) {
            error_log("Error de autenticacion: " . $e->getMessage());
            return false;
        }
    }
}
