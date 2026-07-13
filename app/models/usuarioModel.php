<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../helpers/mailer_helper.php';

class Usuario
{
    private $conexion;
    public function __construct()
    {
        $db = new Conexion();
        $this->conexion = $db->getConexion();
    }

    // GENERA UNA CONTRASEÑA TEMPORAL ALEATORIA Y SEGURA (CUMPLE EL MÍNIMO DE 8 CARACTERES DEL LOGIN)
    private function generarClaveTemporal($longitud = 12)
    {
        $mayusculas = 'ABCDEFGHJKLMNPQRSTUVWXYZ';
        $minusculas = 'abcdefghjkmnpqrstuvwxyz';
        $numeros    = '23456789';
        $simbolos   = '!#$%&*+-?';

        // GARANTIZAMOS AL MENOS UN CARACTER DE CADA TIPO
        $clave = $mayusculas[random_int(0, strlen($mayusculas) - 1)]
               . $minusculas[random_int(0, strlen($minusculas) - 1)]
               . $numeros[random_int(0, strlen($numeros) - 1)]
               . $simbolos[random_int(0, strlen($simbolos) - 1)];

        // COMPLETAMOS EL RESTO DE LA CLAVE CON CARACTERES ALEATORIOS DE TODOS LOS TIPOS
        $todos = $mayusculas . $minusculas . $numeros . $simbolos;
        for ($i = strlen($clave); $i < $longitud; $i++) {
            $clave .= $todos[random_int(0, strlen($todos) - 1)];
        }

        return str_shuffle($clave);
    }

    public function registrarSuperAdministrador($data)
    {
        try {

            // GENERAMOS UNA CONTRASEÑA TEMPORAL ALEATORIA Y LA HASHEAMOS
            $claveTemporal = $this->generarClaveTemporal();
            $claveEncriptada = password_hash($claveTemporal, PASSWORD_DEFAULT);

            $insertarUsuario = "INSERT INTO usuarios(email, contrasena, id_rol, estado) VALUES (:email, :contrasena, 5, 'Activo')";

            $resultadoUsuario = $this->conexion->prepare($insertarUsuario);
            $resultadoUsuario->bindParam(':email', $data['email']);
            $resultadoUsuario->bindParam(':contrasena', $claveEncriptada);

            $resultadoUsuario->execute();

            // OBTENEMOS EL ID DEL ÚLTIMO USUARIO REGISTRADO
            $id_usuario = $this->conexion->lastInsertId();

            // HACEMOS EL INSERT EN SUPERADMINISTRADORES
            $insertarSuperAdministrador = "INSERT INTO superadministradores(id_usuario, nombres, apellidos, foto, telefono) VALUES(:id_usuario, :nombres, :apellidos, :foto, :telefono)";

            $resultadoSuperAdministrador = $this->conexion->prepare($insertarSuperAdministrador);
            $resultadoSuperAdministrador->bindParam(':id_usuario', $id_usuario);
            $resultadoSuperAdministrador->bindParam(':nombres', $data['nombres']);
            $resultadoSuperAdministrador->bindParam(':apellidos', $data['apellidos']);
            $resultadoSuperAdministrador->bindParam(':foto', $data['foto']);
            $resultadoSuperAdministrador->bindParam(':telefono', $data['telefono']);

            $resultadoSuperAdministrador->execute();

            // ENVIAMOS LAS CREDENCIALES DE ACCESO AL CORREO DEL NUEVO SUPERADMINISTRADOR
            try {
                $mail = mailer_init();

                // EMISOR
                $mail->setFrom('evitalix558@gmail.com', 'Soporte E-VITALIX');

                // RECEPTOR
                $mail->addAddress($data['email']);

                // ASUNTO
                $mail->Subject = "E-VITALIX - Cuenta de superadministrador creada";

                // CUERPO HTML
                $mail->Body = '
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-VITALIX - Cuenta de superadministrador creada</title>
</head>
<body style="margin:0; padding:30px 15px; background:linear-gradient(135deg, #e3f2fd 0%, #f5f5f5 100%); font-family: Nunito, Arial, sans-serif;">
    <div style="max-width:650px; margin:0 auto; background-color:#ffffff; border-radius:20px; overflow:hidden; box-shadow:0 10px 40px rgba(0,123,255,0.15);">

        <!-- HEADER -->
        <div style="background:linear-gradient(135deg, #007bff 0%, #0c498a 100%); padding:50px 40px; text-align:center;">
            <img src="https://raw.githubusercontent.com/CesarADSO/imagenes-evitalix/refs/heads/main/LOGO%20NEGATIVO.png" alt="E-VITALIX Logo" style="max-width:220px;">
            <h1 style="color:#ffffff; margin:20px 0 0 0; font-size:24px;">Cuenta de Superadministrador Creada</h1>
        </div>

        <!-- CONTENIDO -->
        <div style="padding:40px;">
            <h2 style="color:#0c498a; margin-top:0;">&#127881; ¡Bienvenido al Sistema E-VITALIX!</h2>
            <p style="color:#444; font-size:15px;">Hola <strong>' . $data['nombres'] . ' ' . $data['apellidos'] . '</strong>, tu cuenta de <strong>Superadministrador</strong> ha sido creada exitosamente. A continuación encontrarás tus credenciales de acceso.</p>

            <!-- CREDENCIALES -->
            <div style="background:#f0f7ff; border:1px solid #cfe4ff; border-radius:12px; padding:20px; margin:25px 0;">
                <p style="margin:0 0 12px 0; color:#0c498a; font-weight:bold;">&#128273; Tus Credenciales de Acceso</p>
                <p style="margin:0 0 8px 0; color:#444;">&#128231; <strong>Usuario / Email:</strong> ' . $data['email'] . '</p>
                <p style="margin:0; color:#444;">&#128272; <strong>Contraseña Temporal:</strong> <span style="font-family:monospace; font-size:16px;">' . $claveTemporal . '</span></p>
            </div>

            <!-- ADVERTENCIA -->
            <div style="background:#fff8e1; border:1px solid #ffe082; border-radius:12px; padding:15px; margin:25px 0; color:#795548; font-size:14px;">
                <strong>&#9888;&#65039; Importante:</strong> esta contraseña fue generada automáticamente por el sistema. Por seguridad, te recomendamos cambiarla inmediatamente después de iniciar sesión por primera vez.
            </div>

            <!-- INSTRUCCIONES -->
            <h3 style="color:#0c498a;">Primeros Pasos</h3>
            <ul style="color:#444; font-size:14px; padding-left:20px;">
                <li>Ingresa a la plataforma E-VITALIX con tus credenciales</li>
                <li>Cambia tu contraseña temporal por una segura</li>
                <li>Explora las funcionalidades del sistema</li>
            </ul>
        </div>

        <!-- FOOTER -->
        <div style="background:#f5f5f5; padding:25px 40px; text-align:center; color:#888; font-size:12px;">
            <strong style="color:#0c498a;">E-VITALIX</strong> — Sistema Inteligente de Gestión Médica<br>
            Este es un correo automático generado por E-VITALIX.<br>
            Si tienes dudas, contacta con el soporte técnico.
        </div>
    </div>
</body>
</html>
                ';

                $mail->AltBody = "Tu cuenta de superadministrador ha sido creada. Usuario: {$data['email']}, Contraseña temporal: {$claveTemporal}";

                // ENVIAR CORREO
                $mail->send();
            } catch (\Throwable $mailError) {
                // LA CUENTA YA FUE CREADA PERO EL CORREO NO SE PUDO ENVIAR:
                // NOTIFICAMOS AL CONTROLADOR PARA QUE INDIQUE ASIGNAR LA CONTRASEÑA MANUALMENTE
                error_log("Error enviando credenciales de superadministrador -> " . $mailError->getMessage());
                return 'correo_fallido';
            }

            return true;
        } catch (\Throwable $th) {
            error_log("Error en Usuario::registrarSuperAdministrador -> " . $th->getMessage());
            return false;
        }
    }

    public function consultar()
    {
        try {
            $sql = "SELECT u.id, u.email, u.contrasena, r.nombre AS rol, u.estado
                    FROM usuarios u
                    LEFT JOIN roles r ON u.id_rol = r.id
                    ORDER BY u.id ASC";

            $stmt = $this->conexion->prepare($sql);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error en Usuario::consultar->" . $e->getMessage());
            return [];
        }
    }




    public function listarUsuarioPorId($id)
    {
        try {
            // EN UNA VARIABLE GUARDAMOS LA CONSULTA SQL A EJECUTAR SEGÚN SEA EL CASO
            $consulta = "SELECT * FROM usuarios WHERE id = :id LIMIT 1";

            $resultado = $this->conexion->prepare($consulta);

            $resultado->bindParam(':id', $id);

            $resultado->execute();

            return $resultado->fetch();
        } catch (PDOException $e) {
            error_log("Error en usuario::consultar->" . $e->getMessage());
            return [];
        }
    }

    public function actualizar($data)
    {
        try {

            $claveEncriptada = password_hash($data['contrasena'], PASSWORD_DEFAULT);

            $insertar = "UPDATE usuarios SET email=:email, contrasena=:contrasena, estado=:estado WHERE id=:id";

            $resultado = $this->conexion->prepare($insertar);
            $resultado->bindParam(':id', $data['id']);
            $resultado->bindParam(':email', $data['email']);
            $resultado->bindParam(':contrasena', $claveEncriptada);
            $resultado->bindParam(':estado', $data['estado']);


            $resultado->execute();
            return true;
        } catch (PDOException $e) {
            error_log("Error en actualizar::registrar->" . $e->getMessage());
            return false;
        }
    }

    public function eliminar($id)
    {
        try {
            $eliminar = "DELETE FROM usuarios WHERE id = :id";
            $resultado = $this->conexion->prepare($eliminar);
            $resultado->bindParam(':id', $id);

            $resultado->execute();

            return true;
        } catch (PDOException $e) {
            error_log("Error en usuario::eliminar->" . $e->getMessage());
            return false;
        }
    }

    /**
     * Verificar si un email ya está registrado
     */
    public function emailExiste($email, $excluir_id = null)
    {
        try {
            if ($excluir_id) {
                $query = "SELECT id FROM usuarios WHERE email = :email AND id != :id LIMIT 1";
                $resultado = $this->conexion->prepare($query);
                $resultado->bindParam(':email', $email);
                $resultado->bindParam(':id', $excluir_id);
            } else {
                $query = "SELECT id FROM usuarios WHERE email = :email LIMIT 1";
                $resultado = $this->conexion->prepare($query);
                $resultado->bindParam(':email', $email);
            }
            $resultado->execute();
            
            return $resultado->rowCount() > 0;
        } catch (PDOException $e) {
            error_log("Error en Usuario::emailExiste->" . $e->getMessage());
            return false;
        }
    }
}
