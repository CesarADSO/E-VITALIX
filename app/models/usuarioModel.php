<?php
require_once __DIR__ . '/../../config/database.php';

class Usuario
{
    private $conexion;
    public function __construct()
    {
        $db = new Conexion();
        $this->conexion = $db->getConexion();
    }

    public function registrarSuperAdministrador($data) {
        try {

            $claveEncriptada = password_hash('123', PASSWORD_DEFAULT);

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

            return true;

        } catch (\Throwable $th) {
            //throw $th;
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

            $claveEncriptada = password_hash($data ['contrasena'], PASSWORD_DEFAULT);

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

      public function eliminar($id) {
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
}

