<?php
require_once __DIR__ . '/../../config/database.php';

class Asistente
{
    private $conexion;
    public function __construct()
    {
        $db = new Conexion();
        $this->conexion = $db->getConexion();
    }

    public function registrar($data) {
        // USAMOS EL TRY CATCH PARA MANEJAR ERRORES
        try {
            
            // HASEAMOS LA CONTRASEÑA POR DEFECTO QUE SERÁ SU NÚMERO DE DOCUMENTO
            $clave_encriptada = password_hash($data['numero_documento'], PASSWORD_DEFAULT);


            // EN UNA VARIABLE GUARDAMOS LA SENTENCIA SQL QUE VAMOS A UTILIZAR
            $insertarUsuario = "INSERT INTO usuarios(email, contrasena, id_rol, estado) VALUES(:email, :contrasena, 4, 'Activo')";

            $resultadoUsuario = $this->conexion->prepare($insertarUsuario);
            $resultadoUsuario->bindParam(':email', $data['email']);
            $resultadoUsuario->bindParam(':contrasena', $clave_encriptada);
            $resultadoUsuario->execute();

            // OBTENEMOS EL ID DEL USUARIO REGISTRADO
            $id_usuario = $this->conexion->lastInsertId();

            // DEFINIMOS EN OTRA VARIABLE LA SIGUIENTE CONSULTA SQL
            $insertarAsistente = "INSERT INTO asistentes(id_usuario, id_consultorio, nombres, apellidos, id_tipo_documento, numero_documento, telefono, foto) VALUES(:id_usuario, :id_consultorio, :nombres, :apellidos, :id_tipo_documento, :numero_documento, :telefono, :foto)";

            $resultadoAsistente = $this->conexion->prepare($insertarAsistente);
            $resultadoAsistente->bindParam(':id_usuario', $id_usuario);
            $resultadoAsistente->bindParam(':id_consultorio', $data['id_consultorio']);
            $resultadoAsistente->bindParam(':nombres', $data['nombres']);
            $resultadoAsistente->bindParam(':apellidos', $data['apellidos']);
            $resultadoAsistente->bindParam(':id_tipo_documento', $data['tipo_documento']);
            $resultadoAsistente->bindParam(':numero_documento', $data['numero_documento']);
            $resultadoAsistente->bindParam(':telefono', $data['telefono']);
            $resultadoAsistente->bindParam(':foto', $data['foto']);

            $resultadoAsistente->execute();

            return true;

        } catch (PDOException $e) {
            error_log("Error en Asistente::registrar->" . $e->getMessage());
            return false;
        }
    }

}