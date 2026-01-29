<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../helpers/mailer_helper.php';

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
            $consulta = "SELECT * FROM usuarios WHERE email = :email AND estado = 'Activo' LIMIT 1";
            $stmt = $this->conexion->prepare($consulta);
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            $user = $stmt->fetch();

            if ($user) {

                // GENERAR NUEVA CONTRASEÑA
                $caracteres = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
                $random = str_shuffle($caracteres);
                $nuevaClave = substr($random, 0, 8);

                // ENCRIPTAR CONTRASEÑA
                $claveEncriptada = password_hash($nuevaClave, PASSWORD_DEFAULT);

                // ACTUALIZAR CONTRASEÑA EN BD
                $update = "UPDATE usuarios SET contrasena = :clave WHERE id = :id";
                $stmt2 = $this->conexion->prepare($update);
                $stmt2->bindParam(':clave', $claveEncriptada);
                $stmt2->bindParam(':id', $user['id']);
                $stmt2->execute();

                // INICIALIZAR PHPMailer
                $mail = mailer_init(); // ← AQUÍ FALTABA EL PUNTO Y COMA ✔

                // EMISOR
                $mail->setFrom('evitalix558@gmail.com', 'Soporte E-VITALIX');

                // RECEPTOR
                $mail->addAddress($user['email']);

                // ASUNTO
                $mail->Subject = "E-VITALIX - NUEVA CLAVE GENERADA";

                // CUERPO HTML
                $mail->Body = '
                
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">
    <title>E-VITALIX - Recuperación de Contraseña</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: "Nunito", sans-serif;
            background: linear-gradient(135deg, #e3f2fd 0%, #f5f5f5 100%);
            padding: 30px 15px;
            min-height: 100vh;
        }

        .email-wrapper {
            max-width: 650px;
            margin: 0 auto;
        }

        .email-container {
            background-color: #ffffff;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 40px rgba(0, 123, 255, 0.15);
        }

        /* HEADER CON LOGO */
        .header {
            background: linear-gradient(135deg, #007bff 0%, #0c498a 100%);
            padding: 50px 40px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .header::before {
            content: "";
            position: absolute;
            top: -50%;
            right: -10%;
            width: 300px;
            height: 300px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
        }

        .header::after {
            content: "";
            position: absolute;
            bottom: -30%;
            left: -5%;
            width: 200px;
            height: 200px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 50%;
        }

        .logo-container {
            position: relative;
            z-index: 2;
            margin-bottom: 25px;
        }

        .logo {
            max-width: 200px;
            height: auto;
            filter: drop-shadow(0 4px 8px rgba(0, 0, 0, 0.2));
        }

        .header-title {
            position: relative;
            z-index: 2;
            color: #ffffff;
            font-size: 32px;
            font-weight: 800;
            margin: 0 0 10px 0;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .header-subtitle {
            position: relative;
            z-index: 2;
            color: rgba(255, 255, 255, 0.95);
            font-size: 16px;
            font-weight: 600;
        }

        /* BADGE DE NOTIFICACIÓN */
        .notification-badge {
            background: linear-gradient(135deg, #1a73d3 0%, #007bff 100%);
            color: #ffffff;
            padding: 12px 30px;
            margin: -30px 40px 0;
            border-radius: 50px;
            font-size: 14px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            box-shadow: 0 4px 15px rgba(0, 123, 255, 0.3);
            position: relative;
            z-index: 3;
        }

        /* CONTENIDO */
        .content {
            padding: 50px 40px;
        }

        .welcome-message {
            text-align: center;
            margin-bottom: 35px;
        }

        .welcome-message h2 {
            color: #0c498a;
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .welcome-message p {
            color: #969696;
            font-size: 16px;
            line-height: 1.6;
        }

        /* TARJETA DE INFORMACIÓN */
        .info-card {
            background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
            border: 2px solid #e3f2fd;
            border-left: 5px solid #007bff;
            padding: 25px;
            margin-bottom: 20px;
            border-radius: 15px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .info-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 123, 255, 0.1);
        }

        .info-card-header {
            display: flex;
            align-items: center;
            margin-bottom: 12px;
        }

        .info-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #007bff 0%, #1a73d3 100%);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            font-size: 20px;
        }

        .info-label {
            color: #0c498a;
            font-size: 14px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .info-value {
            color: #333333;
            font-size: 18px;
            font-weight: 600;
            line-height: 1.6;
            word-wrap: break-word;
            padding-left: 55px;
        }

        /* CAJA DE CONTRASEÑA */
        .password-section {
            background: linear-gradient(135deg, #e7f3ff 0%, #f0f8ff 100%);
            border: 3px solid #007bff;
            border-radius: 20px;
            padding: 40px;
            margin-top: 30px;
            text-align: center;
            box-shadow: 0 8px 25px rgba(0, 123, 255, 0.2);
            position: relative;
            overflow: hidden;
        }

        .password-section::before {
            content: "🔐";
            position: absolute;
            top: -20px;
            right: -20px;
            font-size: 120px;
            opacity: 0.05;
        }

        .password-header {
            margin-bottom: 25px;
            position: relative;
            z-index: 2;
        }

        .password-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #007bff 0%, #0c498a 100%);
            border-radius: 15px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 15px;
            font-size: 28px;
            box-shadow: 0 4px 15px rgba(0, 123, 255, 0.3);
        }

        .password-title {
            color: #0c498a;
            font-size: 20px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .password-box {
            background-color: #ffffff;
            padding: 25px 30px;
            border-radius: 15px;
            margin: 20px 0;
            border: 2px dashed #007bff;
            position: relative;
            z-index: 2;
        }

        .password-value {
            color: #007bff;
            font-size: 32px;
            font-weight: 800;
            letter-spacing: 4px;
            font-family: "Nunito", sans-serif;
            word-break: break-all;
            text-shadow: 0 2px 4px rgba(0, 123, 255, 0.1);
        }

        .password-note {
            color: #969696;
            font-size: 14px;
            margin-top: 20px;
            line-height: 1.6;
            position: relative;
            z-index: 2;
        }

        .password-warning {
            background-color: #fff3cd;
            color: #856404;
            padding: 15px 20px;
            border-radius: 10px;
            border-left: 4px solid #ffc107;
            margin-top: 20px;
            font-size: 14px;
            font-weight: 600;
            text-align: left;
        }

        /* SEPARADOR */
        .divider {
            height: 2px;
            background: linear-gradient(to right, transparent, #007bff, transparent);
            margin: 40px 0;
        }

        /* INSTRUCCIONES */
        .instructions {
            background: #f8f9fa;
            border-radius: 15px;
            padding: 30px;
            margin-top: 30px;
        }

        .instructions h3 {
            color: #0c498a;
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
        }

        .instructions h3::before {
            content: "📋";
            margin-right: 10px;
            font-size: 24px;
        }

        .instruction-list {
            list-style: none;
            padding: 0;
        }

        .instruction-item {
            color: #333333;
            font-size: 15px;
            padding: 12px 0 12px 40px;
            position: relative;
            line-height: 1.6;
            border-bottom: 1px solid #e3f2fd;
        }

        .instruction-item:last-child {
            border-bottom: none;
        }

        .instruction-item::before {
            content: "✓";
            position: absolute;
            left: 10px;
            color: #007bff;
            font-weight: 700;
            font-size: 18px;
        }

        /* FOOTER */
        .footer {
            background: linear-gradient(135deg, #f8f9fa 0%, #e3f2fd 100%);
            padding: 40px;
            text-align: center;
            border-top: 3px solid #007bff;
        }

        .footer-brand {
            margin-bottom: 20px;
        }

        .brand-name {
            color: #007bff;
            font-size: 28px;
            font-weight: 800;
            letter-spacing: 1px;
            display: block;
            margin-bottom: 5px;
        }

        .brand-tagline {
            color: #0c498a;
            font-size: 14px;
            font-weight: 600;
        }

        .footer-info {
            color: #969696;
            font-size: 14px;
            line-height: 1.8;
            margin-top: 15px;
        }

        .footer-note {
            color: #969696;
            font-size: 12px;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #dee2e6;
            font-style: italic;
        }

        /* RESPONSIVE */
        @media (max-width: 600px) {
            body {
                padding: 15px 10px;
            }

            .header {
                padding: 35px 25px;
            }

            .header-title {
                font-size: 26px;
            }

            .content {
                padding: 35px 25px;
            }

            .notification-badge {
                margin: -25px 25px 0;
                padding: 10px 20px;
                font-size: 12px;
            }

            .info-value {
                font-size: 16px;
                padding-left: 0;
                margin-top: 8px;
            }

            .password-section {
                padding: 30px 20px;
            }

            .password-value {
                font-size: 24px;
                letter-spacing: 2px;
            }

            .footer {
                padding: 30px 25px;
            }
        }
    </style>
</head>
<body>
    <div class="email-wrapper">
        <div class="email-container">
            <!-- HEADER -->
            <div class="header">
                <div class="logo-container">
                    <!-- REEMPLAZA "RUTA_DE_TU_LOGO" CON LA URL DE TU LOGO -->
                    <img src="https://raw.githubusercontent.com/CesarADSO/imagenes-evitalix/refs/heads/main/LOGO%20NEGATIVO.png" alt="E-VITALIX Logo" class="logo">
                </div>
                <h1 class="header-title">🔐 Recuperación de Contraseña</h1>
                <p class="header-subtitle">Sistema de Seguridad E-VITALIX</p>
            </div>

            <!-- BADGE -->
            <div class="notification-badge">
                ✅ Solicitud Procesada
            </div>
           

            <!-- CONTENIDO -->
            <div class="content">
                <!-- MENSAJE DE BIENVENIDA -->
                <div class="welcome-message">
                    <h2>¡Tu contraseña ha sido restablecida!</h2>
                   <div class="header-subtitle">    
                        Hola,

                        Hemos recibido una solicitud para restablecer la contraseña asociada a tu cuenta en la plataforma E-VITALIX. Este mensaje tiene como finalidad ayudarte a recuperar el acceso de forma segura y rápida. Esta es tu contraseña temporal, no la compartas con nadie.
                    </div>
                </div>
                



                <!-- INFO: EMAIL -->
                <div class="info-card">
                    <div class="info-card-header">
                        <div class="info-icon">👤</div>
                        <div class="info-label">Cuenta de Usuario</div>
                    </div>
                    <div class="info-value">' . htmlspecialchars($email) .'</div>
                </div>

                <div class="divider"></div>

                <!-- CONTRASEÑA -->
                <div class="password-section">
                    <div class="password-header">
                        <div class="password-icon">🔑</div>
                        <div class="password-title">Tu Nueva Contraseña</div>
                    </div>
                    
                    <div class="password-box">
                        <div class="password-value">'. htmlspecialchars($nuevaClave) .'</div>
                    </div>
                    
                    <p class="password-note">
                        Esta es tu contraseña temporal. Cópiala exactamente como se muestra, respetando mayúsculas y minúsculas.
                    </p>
                    
                    <div class="password-warning">
                        ⚠️ <strong>Importante:</strong> Por tu seguridad, te recomendamos cambiar esta contraseña inmediatamente después de iniciar sesión.
                    </div>
                </div>

                <!-- INSTRUCCIONES -->
                <div class="instructions">
                    <h3>Pasos a seguir</h3>
                    <ul class="instruction-list">
                        <li class="instruction-item">Copia la contraseña mostrada arriba</li>
                        <li class="instruction-item">Ingresa a la plataforma E-VITALIX</li>
                        <li class="instruction-item">Usa tu email y la nueva contraseña para iniciar sesión</li>
                        <li class="instruction-item">Ve a tu perfil y cambia la contraseña por una de tu preferencia</li>
                    </ul>
                </div>
            </div>

            <!-- FOOTER -->
            <div class="footer">
                <div class="footer-brand">
                    <span class="brand-name">E-VITALIX</span>
                    <span class="brand-tagline">Sistema Inteligente de Gestión</span>
                </div>
                <div class="footer-info">
                    🔒 Correo de seguridad automático<br>
                    📧 No responder a este mensaje
                </div>
                <div class="footer-note">
                    Este es un correo automático generado por el sistema E-VITALIX.<br>
                    Si no solicitaste este cambio, contacta al administrador inmediatamente.
                </div>
            </div>
        </div>
    </div>
</body>
</html>
                ';

                $mail->AltBody = "Tu nueva contraseña es: $nuevaClave";

                // ENVIAR CORREO
                $mail->send();
                return true;

            } else {
                return ['error' => 'Usuario no encontrado o inactivo'];
            }

        } catch (PDOException $e) {
            error_log("Error de autenticacion: " . $e->getMessage());
            return false;
        }
    }
}
