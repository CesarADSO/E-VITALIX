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

    public function registrar($data)
    {
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

    public function mostrar($id_consultorio)
    {
        try {

            // DEFINIMOS EN UNA VARIABLE LA CONSULTA SQL
            $consultar = "SELECT asistentes.id, asistentes.foto, asistentes.nombres, asistentes.apellidos, asistentes.numero_documento, asistentes.telefono, tipo_documento.nombre AS tipo_documento , usuarios.estado FROM asistentes INNER JOIN tipo_documento ON asistentes.id_tipo_documento = tipo_documento.id INNER JOIN usuarios ON asistentes.id_usuario = usuarios.id WHERE asistentes.id_consultorio = :id_consultorio ORDER BY asistentes.nombres ASC";


            $resultado = $this->conexion->prepare($consultar);
            $resultado->bindParam(':id_consultorio', $id_consultorio);
            $resultado->execute();

            return $resultado->fetchAll();
        } catch (PDOException $e) {
            error_log("Error en Asistente::mostrar->" . $e->getMessage());
            return [];
        }
    }

    // CREAMOS LA FUNCIÓN PARA TRAER UN ASISTENTE POR ID
    public function listarAsistentePorId($id)
    {
        try {
            // CONSULTA SQL CON LOS CAMPOS NECESARIOS
            $consultar = "SELECT
                            asistentes.id AS id_asistente,
                            asistentes.nombres,
                            asistentes.apellidos,
                            asistentes.telefono,
                            tipo_documento.id AS id_tipo_documento,
                            tipo_documento.nombre AS documento,
                            usuarios.id AS id_usuario,
                            usuarios.estado
                          FROM asistentes
                          INNER JOIN usuarios 
                            ON asistentes.id_usuario = usuarios.id
                          INNER JOIN tipo_documento
                            ON asistentes.id_tipo_documento = tipo_documento.id
                          WHERE asistentes.id = :id
                          LIMIT 1;";

            // PREPARAMOS LA CONSULTA
            $resultado = $this->conexion->prepare($consultar);

            // BIND DEL PARÁMETRO
            $resultado->bindParam(':id', $id);

            // EJECUTAMOS
            $resultado->execute();

            // RETORNAMOS LOS DATOS
            return $resultado->fetch();
        } catch (PDOException $e) {
            error_log("Error en Asistente::listarAsistentePorId -> " . $e->getMessage());
            return [];
        }
    }


    public function actualizar($data)
    {
        // CREAMOS EL TRY-CATCH PARA MANEJAR ERRORES
        try {

            // 1️⃣ ACTUALIZAMOS EL ESTADO EN LA TABLA USUARIOS
            $actualizarUsuario = "UPDATE usuarios 
                              SET estado = :estado 
                              WHERE id = :idUsuario";

            $resultadoUsuario = $this->conexion->prepare($actualizarUsuario);
            $resultadoUsuario->bindParam(':estado', $data['estado']);
            $resultadoUsuario->bindParam(':idUsuario', $data['idUsuario']);
            $resultadoUsuario->execute();

            // 2️⃣ ACTUALIZAMOS LOS DATOS DEL ASISTENTE
            $actualizarAsistente = "UPDATE asistentes 
                                SET 
                                    nombres = :nombres,
                                    apellidos = :apellidos,
                                    id_tipo_documento = :tipoDocumento,
                                    telefono = :telefono
                                WHERE id = :idAsistente";

            $resultadoAsistente = $this->conexion->prepare($actualizarAsistente);
            $resultadoAsistente->bindParam(':idAsistente', $data['idAsistente']);
            $resultadoAsistente->bindParam(':nombres', $data['nombres']);
            $resultadoAsistente->bindParam(':apellidos', $data['apellidos']);
            $resultadoAsistente->bindParam(':tipoDocumento', $data['tipoDocumento']);
            $resultadoAsistente->bindParam(':telefono', $data['telefono']);

            $resultadoAsistente->execute();

            return true;
        } catch (PDOException $e) {
            error_log("Error en Asistente::actualizar -> " . $e->getMessage());
            return false;
        }
    }
}
