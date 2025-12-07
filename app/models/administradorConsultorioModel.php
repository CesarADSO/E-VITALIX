<?php
require_once __DIR__ . '/../../config/database.php';

class Administrador {

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



            $insertar2 = "INSERT INTO administradores(id_usuario, nombres, apellidos, foto, telefono, id_tipo_documento, numero_documento) VALUES(LAST_INSERT_ID(), :nombres, :apellidos, :foto, :telefono, :tipoDocumento, :numeroDocumento)";

            

            $resultado2 = $this->conexion->prepare($insertar2);
            $resultado2->bindParam(':nombres', $data['nombres']);
            $resultado2->bindParam(':apellidos', $data['apellidos']);
            $resultado2->bindParam(':foto', $data['foto']);
            $resultado2->bindParam(':telefono', $data['telefono']);
            $resultado2->bindParam(':tipoDocumento', $data['tipoDocumento']);
            $resultado2->bindParam(':numeroDocumento', $data['numeroDocumento']);

            $resultado2->execute();

            return true;
        } catch (PDOException $e) {
            error_log("Error en Administrador::registrar->" . $e->getMessage());
            return false;
        }
    }

    public function consultar() {
         try {
            // Variable que almacena la sentencia de sql a ejecutar
            $consultar = "SELECT administradores.foto, administradores.nombres, administradores.apellidos, administradores.telefono, tipo_documento.nombre AS tipo_documento, administradores.numero_documento, usuarios.estado FROM administradores INNER JOIN tipo_documento ON administradores.id_tipo_documento = tipo_documento.id INNER JOIN usuarios ON administradores.id_usuario = usuarios.id ORDER BY administradores.nombres ASC";
            // Preparar lo necesario para ejecutar la función

            $resultado = $this->conexion->prepare($consultar);

            $resultado->execute();

            return $resultado->fetchAll();
        } catch (PDOException $e) {
            error_log("Error en consultorio::consultar->" . $e->getMessage());
            return [];
        }
    }
}


?>