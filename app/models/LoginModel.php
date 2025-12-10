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
                    $consulta = $this->conexion->prepare("SELECT * FROM administradores WHERE id_usuario = :id LIMIT 1");
                    break;

                case 3: // Especialista
                    $consulta = $this->conexion->prepare("SELECT * FROM especialistas WHERE id_usuario = :id LIMIT 1");
                    break;

                case 4: // asistente del especialista
                    $consulta = $this->conexion->prepare("SELECT * FROM asistentes WHERE id_usuario = :id LIMIT 1");
                    break;

                case 5: // superadministrador
                    $consulta = $this->conexion->prepare("SELECT * FROM superadministradores WHERE id_usuario = :id LIMIT 1");
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

    // Busca el consultorio asociado a un usuario administrador
    public function obtenerConsultorioPorAdmin($id_usuario)
    {
        try {
            // Primero, obtener el id del administrador en la tabla administradores
            $sqlAdmin = "SELECT id FROM administradores WHERE id_usuario = :id_usuario LIMIT 1";
            $stmtAdmin = $this->conexion->prepare($sqlAdmin);
            $stmtAdmin->bindParam(':id_usuario', $id_usuario);
            $stmtAdmin->execute();
            $admin = $stmtAdmin->fetch(PDO::FETCH_ASSOC);

            if (!$admin || !isset($admin['id'])) {
                return null; // No se encontró el administrador
            }

            // Ahora, buscar el consultorio con ese id_administrador
            $sqlConsultorio = "SELECT id FROM consultorios WHERE id_administrador = :id_admin LIMIT 1";
            $stmtConsultorio = $this->conexion->prepare($sqlConsultorio);
            $stmtConsultorio->bindParam(':id_admin', $admin['id']);
            $stmtConsultorio->execute();
            return $stmtConsultorio->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error en obtenerConsultorioPorAdmin: " . $e->getMessage());
            return null;
        }
    }
}
