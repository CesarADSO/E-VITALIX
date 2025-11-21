<?php
require_once __DIR__ . '/../../config/database.php';


class Login
{
    private $conexion;

    public function __construct()
    {
        $db = new Conexion();
        $this->conexion = $db->getConexion();
    }

    public function autenticar($correo, $clave)
    {
        try {
            $consultar = "SELECT * FROM usuarios WHERE email = :correo AND estado = 'Activo' LIMIT 1";

            $resultado = $this->conexion->prepare($consultar);
            $resultado->bindParam(':correo', $correo);
            $resultado->execute();

            $user = $resultado->fetch();

            if (!$user) {
                return ['error' => 'Usuario no encontrado o inactivo'];
            }

            // Verificar la contraseña encriptada
            if (!password_verify($clave, $user['contrasena'])) {
                return ['error' => 'Contraseña incorrecta'];
            }


            // 2. Obtener datos adicionales según el rol
            $nombres = '';
            $apellidos = '';

            switch ($user['id_rol']) {
                case 1: // Paciente
                    $consulta = $this->conexion->prepare("SELECT * FROM pacientes WHERE id_usuario = :id LIMIT 1");
                    break;

                case 2: // Administrador
                    $consulta = $this->conexion->prepare("SELECT * FROM perfiles WHERE id_usuario = :id LIMIT 1");
                    break;

                case 3: // Especialista
                    $consulta = $this->conexion->prepare("SELECT * FROM especialistas WHERE id_usuario = :id LIMIT 1");
                    break;

                default:
                    return ['error' => 'Rol inválido'];
            }

            $consulta->bindParam(':id', $user['id']);
            $consulta->execute();
            $perfil = $consulta->fetch();

            if ($perfil) {
                $nombres = $perfil['nombres'];
                $apellidos = $perfil['apellidos'];
            }

            // 3. Retornar todos los datos que necesitas
            return [
                'id_usuario' => $user['id'],
                'id_rol' => $user['id_rol'],
                'email' => $user['email'],
                'nombres' => $nombres,
                'apellidos' => $apellidos
            ];

        } catch (PDOException $e) {
            error_log("Error de autenticacion: " . $e->getMessage());
            return ['error' => 'Error interno del servidor'];
        }
    }
}
