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

    public function registrar($data)
    {
        try {

            $claveEncriptada = password_hash($data ['contrasena'], PASSWORD_DEFAULT);

            $insertar = "INSERT INTO usuarios(email, contrasena, id_rol, estado) VALUES(:email, :contrasena, :rol, 'Activo')";

            $resultado = $this->conexion->prepare($insertar);
            $resultado->bindParam(':email', $data['email']);
            $resultado->bindParam(':contrasena', $claveEncriptada);
            $resultado->bindParam(':rol', $data['id_rol']);
       

            $resultado->execute();
            return true;
        } catch (PDOException $e) {
            error_log("Error en usuario::registrar->" . $e->getMessage());
            return false;
        }
    }



    public function consultar()
    {
        try {
            // Variable que almacena la sentencia de sql a ejecutar
            $consultar = "SELECT * FROM  usuarios ORDER BY id ASC";
            // Preparar lo necesario para ejecutar la función

            $resultado = $this->conexion->prepare($consultar);

            $resultado->execute();
            

            return $resultado->fetchAll();
        } catch (PDOException $e) {
            error_log("Error en usuario::consultar->" . $e->getMessage());
            return [];
        }
    }
}