<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../helpers/mailer_helper.php';

class Administrador
{

    private $conexion;
    public function __construct()
    {
        $db = new Conexion();
        $this->conexion = $db->getConexion();
    }

    public function registrar($data)
    {
        try {

            // HASEAMOS LA CONTRASEÑA
            $claveEncriptada = password_hash($data['numeroDocumento'], PASSWORD_DEFAULT);

            $insertar1 = "INSERT INTO usuarios(email, contrasena, id_rol, estado) VALUES (:email, :clave, 2, 'Activo')";

            $resultado1 = $this->conexion->prepare($insertar1);

            $resultado1->bindParam(':email', $data['email']);
            $resultado1->bindParam(':clave', $claveEncriptada);

            $resultado1->execute();



            $insertar2 = "INSERT INTO administradores(id_usuario, id_consultorio, nombres, apellidos, foto, telefono, id_tipo_documento, numero_documento) VALUES(LAST_INSERT_ID(), NULL, :nombres, :apellidos, :foto, :telefono, :tipoDocumento, :numeroDocumento)";



            $resultado2 = $this->conexion->prepare($insertar2);
            $resultado2->bindParam(':nombres', $data['nombres']);
            $resultado2->bindParam(':apellidos', $data['apellidos']);
            $resultado2->bindParam(':foto', $data['foto']);
            $resultado2->bindParam(':telefono', $data['telefono']);
            $resultado2->bindParam(':tipoDocumento', $data['tipoDocumento']);
            $resultado2->bindParam(':numeroDocumento', $data['numeroDocumento']);

            $resultado2->execute();

            // INICIALIZAR PHPMailer
            $mail = mailer_init(); // ← AQUÍ FALTABA EL PUNTO Y COMA ✔

            // EMISOR
            $mail->setFrom('evitalix558@gmail.com', 'Soporte E-VITALIX');

            // RECEPTOR
            $mail->addAddress($data['email']);

            // ASUNTO
            $mail->Subject = "E-VITALIX - Cuenta de administrador de consultorio creada";

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
    <title>E-VITALIX - Creación de Cuenta Administrador</title>
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

        .notification-badge {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            color: #ffffff;
            padding: 12px 30px;
            margin: -30px 40px 0;
            border-radius: 50px;
            font-size: 14px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
            position: relative;
            z-index: 3;
        }

        .content {
            padding: 50px 40px;
        }

        .welcome-message {
            text-align: center;
            margin-bottom: 35px;
        }

        .welcome-message h2 {
            color: #0c498a;
            font-size: 26px;
            font-weight: 800;
            margin-bottom: 15px;
        }

        .welcome-message p {
            color: #969696;
            font-size: 16px;
            line-height: 1.8;
        }

        .success-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
            font-size: 40px;
            box-shadow: 0 6px 20px rgba(40, 167, 69, 0.3);
        }

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

        .credentials-section {
            background: linear-gradient(135deg, #fff3e0 0%, #ffe0b2 100%);
            border: 3px solid #ff9800;
            border-radius: 20px;
            padding: 40px;
            margin-top: 30px;
            text-align: center;
            box-shadow: 0 8px 25px rgba(255, 152, 0, 0.2);
        }

        .credentials-header {
            margin-bottom: 25px;
        }

        .credentials-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #ff9800 0%, #f57c00 100%);
            border-radius: 15px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 15px;
            font-size: 28px;
            box-shadow: 0 4px 15px rgba(255, 152, 0, 0.3);
        }

        .credentials-title {
            color: #e65100;
            font-size: 20px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .credential-item {
            background-color: #ffffff;
            padding: 20px 25px;
            border-radius: 12px;
            margin: 15px 0;
            border: 2px solid #ff9800;
            text-align: left;
        }

        .credential-label {
            color: #f57c00;
            font-size: 14px;
            font-weight: 700;
            text-transform: uppercase;
            margin-bottom: 8px;
        }

        .credential-value {
            color: #e65100;
            font-size: 24px;
            font-weight: 800;
            letter-spacing: 2px;
            font-family: "Nunito", sans-serif;
            word-break: break-all;
        }

        .divider {
            height: 2px;
            background: linear-gradient(to right, transparent, #007bff, transparent);
            margin: 40px 0;
        }

        .permissions-section {
            background: #f8f9fa;
            border-radius: 15px;
            padding: 30px;
            margin-top: 30px;
        }

        .permissions-section h3 {
            color: #0c498a;
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
        }

        .permissions-section h3::before {
            content: "🔓";
            margin-right: 10px;
            font-size: 24px;
        }

        .permission-list {
            list-style: none;
            padding: 0;
        }

        .permission-item {
            color: #333333;
            font-size: 15px;
            padding: 12px 0 12px 40px;
            position: relative;
            line-height: 1.6;
            border-bottom: 1px solid #e3f2fd;
        }

        .permission-item:last-child {
            border-bottom: none;
        }

        .permission-item::before {
            content: "✓";
            position: absolute;
            left: 10px;
            color: #28a745;
            font-weight: 700;
            font-size: 18px;
        }

        .instructions {
            background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
            border-radius: 15px;
            padding: 30px;
            margin-top: 30px;
            border: 2px solid #007bff;
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
            border-bottom: 1px solid rgba(0, 123, 255, 0.1);
        }

        .instruction-item:last-child {
            border-bottom: none;
        }

        .instruction-item::before {
            content: "→";
            position: absolute;
            left: 10px;
            color: #007bff;
            font-weight: 700;
            font-size: 18px;
        }

        .warning-box {
            background-color: #fff3cd;
            color: #856404;
            padding: 20px;
            border-radius: 12px;
            border-left: 5px solid #ffc107;
            margin-top: 25px;
            font-size: 14px;
            line-height: 1.6;
        }

        .warning-box strong {
            display: block;
            margin-bottom: 8px;
            font-size: 16px;
        }

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

            .credentials-section {
                padding: 30px 20px;
            }

            .credential-value {
                font-size: 20px;
                letter-spacing: 1px;
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
                    <img src="https://raw.githubusercontent.com/CesarADSO/imagenes-evitalix/refs/heads/main/LOGO%20NEGATIVO.png" alt="E-VITALIX Logo" class="logo">
                </div>
                <h1 class="header-title">✨ Cuenta Creada Exitosamente</h1>
                <p class="header-subtitle">Bienvenido a E-VITALIX</p>
            </div>

            <!-- BADGE -->
            <div class="notification-badge">
                ✅ Cuenta Activa
            </div>

            <!-- CONTENIDO -->
            <div class="content">
                <!-- MENSAJE DE BIENVENIDA -->
                <div class="welcome-message">
                    <div class="success-icon">🎉</div>
                    <h2>¡Bienvenido al Sistema E-VITALIX!</h2>
                    <p>Tu cuenta de <strong>Administrador de Consultorio</strong> ha sido creada exitosamente. A continuación encontrarás tus credenciales de acceso.</p>
                </div>

                <!-- INFO: EMAIL -->
                <div class="info-card">
                    <div class="info-card-header">
                        <div class="info-icon">📧</div>
                        <div class="info-label">Correo Electrónico</div>
                    </div>
                    <div class="info-value">'.$data['email'].'</div>
                </div>

                <!-- INFO: NOMBRE -->
                <div class="info-card">
                    <div class="info-card-header">
                        <div class="info-icon">👤</div>
                        <div class="info-label">Nombre Completo</div>
                    </div>
                    <div class="info-value">'.$data['nombres'].' '.$data['apellidos'].'</div>
                </div>

                <div class="divider"></div>

                <!-- CREDENCIALES -->
                <div class="credentials-section">
                    <div class="credentials-header">
                        <div class="credentials-icon">🔑</div>
                        <div class="credentials-title">Tus Credenciales de Acceso</div>
                    </div>
                    
                    <div class="credential-item">
                        <div class="credential-label">📧 Usuario / Email</div>
                        <div class="credential-value">'.$data['email'].'</div>
                    </div>

                    <div class="credential-item">
                        <div class="credential-label">🔐 Contraseña Temporal</div>
                        <div class="credential-value">'.$data['numeroDocumento'].'</div>
                    </div>

                    <div class="warning-box">
                        <strong>⚠️ Importante:</strong>
                        Tu contraseña temporal es tu número de documento. Por seguridad, te recomendamos cambiarla inmediatamente después de iniciar sesión por primera vez.
                    </div>
                </div>

                <!-- PERMISOS -->
                <div class="permissions-section">
                    <h3>Permisos de Administrador de Consultorio</h3>
                    <ul class="permission-list">
                        <li class="permission-item">Gestionar consultorios y configuraciones</li>
                        <li class="permission-item">Administrar médicos y personal del consultorio</li>
                        <li class="permission-item">Configurar horarios y disponibilidad</li>
                        <li class="permission-item">Acceder a reportes y estadísticas</li>
                        <li class="permission-item">Gestionar información de pacientes</li>
                    </ul>
                </div>

                <!-- INSTRUCCIONES -->
                <div class="instructions">
                    <h3>Primeros Pasos</h3>
                    <ul class="instruction-list">
                        <li class="instruction-item">Ingresa a la plataforma E-VITALIX con tus credenciales</li>
                        <li class="instruction-item">Cambia tu contraseña temporal por una segura</li>
                        <li class="instruction-item">Completa tu perfil con tu información personal</li>
                        <li class="instruction-item">Configura los datos de tu consultorio</li>
                        <li class="instruction-item">Explora las funcionalidades del sistema</li>
                    </ul>
                </div>
            </div>

            <!-- FOOTER -->
            <div class="footer">
                <div class="footer-brand">
                    <span class="brand-name">E-VITALIX</span>
                    <span class="brand-tagline">Sistema Inteligente de Gestión Médica</span>
                </div>
                <div class="footer-info">
                    🎯 Portal de Administración<br>
                    📧 Correo automático del sistema
                </div>
                <div class="footer-note">
                    Este es un correo automático generado por E-VITALIX.<br>
                    Si tienes dudas, contacta con el soporte técnico.
                </div>
            </div>
        </div>
    </div>
</body>
</html>
                    ';

            $mail->AltBody = "Tu cuenta ha sido creada. Usuario: {$data['email']}, Contraseña: {$data['numeroDocumento']}";

            // ENVIAR CORREO
            $mail->send();


            return true;
        } catch (PDOException $e) {
            error_log("Error en Administrador::registrar->" . $e->getMessage());
            return false;
        }
    }

    public function consultar()
    {
        try {
            // Variable que almacena la sentencia de sql a ejecutar
            $consultar = "SELECT administradores.id, administradores.foto, administradores.nombres, administradores.apellidos, administradores.telefono, tipo_documento.nombre AS tipo_documento, administradores.numero_documento,usuarios.id AS id_usuario, usuarios.estado FROM administradores INNER JOIN tipo_documento ON administradores.id_tipo_documento = tipo_documento.id INNER JOIN usuarios ON administradores.id_usuario = usuarios.id ORDER BY administradores.nombres ASC";
            // Preparar lo necesario para ejecutar la función

            $resultado = $this->conexion->prepare($consultar);

            $resultado->execute();

            return $resultado->fetchAll();
        } catch (PDOException $e) {
            error_log("Error en Administrador::consultar->" . $e->getMessage());
            return [];
        }
    }

    public function listarAdministradorPorId($id)
    {
        try {
            // EN UNA VARIABLE GUARDAMOS LA CONSULTA SQL A EJECUTAR SEGÚN SEA EL CASO
            $consulta = "SELECT administradores.id, administradores.foto, administradores.nombres, administradores.apellidos, administradores.telefono, tipo_documento.id AS id_tipo_documento, tipo_documento.nombre AS tipo_documento, usuarios.estado FROM administradores INNER JOIN tipo_documento ON administradores.id_tipo_documento = tipo_documento.id INNER JOIN usuarios ON administradores.id_usuario = usuarios.id WHERE administradores.id = :id ORDER BY administradores.nombres ASC LIMIT 1";

            $resultado = $this->conexion->prepare($consulta);

            $resultado->bindParam(':id', $id);

            $resultado->execute();

            return $resultado->fetch();
        } catch (PDOException $e) {
            error_log("Error en Administrador::listarAdministradorPorId->" . $e->getMessage());
            return [];
        }
    }

    public function actualizar($data)
    {
        try {
            // EN UNA VARIABLE GUARDAMOS LA CONSULTA SQL A EJECUTAR SEGÚN SEA EL CASO
            $actualizar = "UPDATE administradores SET nombres = :nombres, apellidos = :apellidos, telefono = :telefono, id_tipo_documento = :tipoDocumento WHERE id = :id";

            $resultado = $this->conexion->prepare($actualizar);

            $resultado->bindParam(':id', $data['id']);
            $resultado->bindParam(':nombres', $data['nombres']);
            $resultado->bindParam(':apellidos', $data['apellidos']);
            $resultado->bindParam(':telefono', $data['telefono']);
            $resultado->bindParam(':tipoDocumento', $data['tipoDocumento']);

            $resultado->execute();

            return true;
        } catch (PDOException $e) {
            error_log("Error en Administrador::actualizar->" . $e->getMessage());
            return false;
        }
    }

    public function eliminar($id, $id_usuario)
    {
        try {
            // EN UNA VARIABLE GUARDAMOS LA CONSULTA SQL A EJECUTAR SEGÚN SEA EL CASO
            $eliminar = "DELETE FROM administradores WHERE id = :id";

            $resultado = $this->conexion->prepare($eliminar);

            $resultado->bindParam(':id', $id);

            $resultado->execute();

            $eliminar2 = "DELETE FROM usuarios WHERE id = :id_usuario";

            $resultado2 = $this->conexion->prepare($eliminar2);

            $resultado2->bindParam(':id_usuario', $id_usuario);

            $resultado2->execute();

            return true;
        } catch (PDOException $e) {
            error_log("Error en Administrador::eliminar->" . $e->getMessage());
            return false;
        }
    }
}
