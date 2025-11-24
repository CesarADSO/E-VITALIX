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
                </head>
                <body style="font-family: Arial; background:#f5f5f5; padding:20px;">
                    <div style="max-width:600px;margin:0 auto;background:white;padding:30px;border-radius:12px;">
                        <h2 style="color:#007bff;">🔐 Recuperación de Contraseña</h2>
                        <p>Tu nueva contraseña es:</p>
                        <div style="padding:15px;background:#e7f3ff;border:1px dashed #007bff;font-size:24px;font-weight:bold;text-align:center;">
                            ' . htmlspecialchars($nuevaClave) . '
                        </div>
                        <p style="margin-top:20px;color:#555;font-size:12px;">
                            ⚠️ Te recomendamos cambiarla al iniciar sesión.
                        </p>
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
