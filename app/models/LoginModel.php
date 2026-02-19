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
            $id_consultorio = null;
            $id_especialista = null;
            $id_paciente = null;
            $perfil_completo = null;

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

            // Si el usuario tiene rol de especialista (id_rol == 3)
            // Y además sí se encontró su registro en la tabla 'especialistas' ($perfil no es false ni está vacío),
            // entonces podemos tomar con seguridad el id del especialista desde ese perfil.
            if ($user['id_rol'] === 3 && $perfil) {
                $id_especialista = $perfil['id'];
            }

            // Si el usuario tiene rol de paciente (id_rol == 1)
            // Y además sí se encontró su registro en la tabla 'pacientes' ($perfil no es false ni está vacío),
            // entonces podemos tomar con seguridad el id del especialista desde ese perfil.
            if ($user['id_rol'] === 1 && $perfil) {
                $id_paciente = $perfil['id'];
            }

            if ($perfil) {
                $nombres = $perfil['nombres'];
                $apellidos = $perfil['apellidos'];
                if (isset($perfil['id_consultorio'])) {
                    $id_consultorio = $perfil['id_consultorio']; // <-- LO GUARDA SOLO SI EXISTE
                }
            }

            // 3. Retornar todos los datos que necesitas
            return [
                'id_usuario' => $user['id'],
                'id_rol' => $user['id_rol'],
                'email' => $user['email'],
                'nombres' => $nombres,
                'apellidos' => $apellidos,
                'id_consultorio' => $id_consultorio,
                'id_especialista' => $id_especialista,
                'id_paciente' => $id_paciente,
                'perfil_completo' => $perfil_completo
            ];
        } catch (PDOException $e) {
            error_log("Error de autenticacion: " . $e->getMessage());
            return ['error' => 'Error interno del servidor'];
        }
    }
}
