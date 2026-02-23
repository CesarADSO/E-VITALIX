<?php
// IMPORTAMOS LAS DEPENDENCIAS NECESARIAS
// QUE ES LA CONEXIÓN A LA BASE DE DATOS
require_once __DIR__ . '/../../config/database.php';


class Ticket
{
    private $conexion;

    public function __construct()
    {
        $db = new Conexion();
        $this->conexion = $db->getConexion();
    }

    public function crear($data)
    {
        try {
            $crear = "INSERT INTO tickets (id_usuario, titulo, descripcion, imagen, estado) VALUES (:id_usuario, :titulo, :descripcion, :foto, 'ABIERTO')";
            $resultado = $this->conexion->prepare($crear);
            $resultado->bindParam(':id_usuario', $data['id_usuario']);
            $resultado->bindParam(':titulo', $data['titulo']);
            $resultado->bindParam(':descripcion', $data['descripcion']);
            $resultado->bindParam(':foto', $data['foto']);

            $resultado->execute();

            return true;
        } catch (PDOException $e) {
            error_log("Error en Ticket::crear->" . $e->getMessage());
            return false;
        }
    }

    public function listarConIdDeUsuario($id_usuario)
    {
        try {

            $listar = "SELECT * FROM tickets WHERE id_usuario = :id_usuario";

            $resultado = $this->conexion->prepare($listar);
            $resultado->bindParam(':id_usuario', $id_usuario);
            $resultado->execute();

            return $resultado->fetchAll();

        } catch (PDOException $e) {
            error_log("Error en Ticket::listarConIdDeUsuario->" . $e->getMessage());
            return [];
        }
    }

    public function listarTodosParaSuperAdmin() {
        try {

            $listar = "SELECT tickets.*, usuarios.email, roles.nombre AS rol FROM tickets INNER JOIN usuarios ON tickets.id_usuario = usuarios.id INNER JOIN roles ON usuarios.id_rol = roles.id";

            $resultado = $this->conexion->prepare($listar);
            $resultado->execute();

            return $resultado->fetchAll();

        } catch (PDOException $e) {
            error_log("Error en Ticket::listarTodosParaSuperAdmin->" . $e->getMessage());
            return [];
        }
    }

    public function consultarTicketPorId($id) {
        try {
            $consultarPorId = "SELECT tickets.*, usuarios.email, roles.nombre AS rol FROM tickets INNER JOIN usuarios ON tickets.id_usuario = usuarios.id INNER JOIN roles ON usuarios.id_rol = roles.id WHERE tickets.id = :id";
            $resultado = $this->conexion->prepare($consultarPorId);
            $resultado->bindParam(':id', $id);
            $resultado->execute();

            return $resultado->fetch();

        } catch (PDOException $e) {
            error_log("Error en Ticket::consultarTicketPorId->" . $e->getMessage());
            return [];
        }
    }

    public function actualizarTicket($data) {
        try {
            $actualizar = "UPDATE tickets SET titulo = :titulo, descripcion = :descripcion, imagen = :foto WHERE id = :id"; 
            $resultado = $this->conexion->prepare($actualizar);
            $resultado->bindParam(':titulo', $data['titulo']);
            $resultado->bindParam(':descripcion', $data['descripcion']);
            $resultado->bindParam(':foto', $data['foto']);
            $resultado->bindParam(':id', $data['id']);

            $resultado->execute();

            return true;
        } catch (PDOException $e) {
            error_log("Error en Ticket::actualizarTicket->" . $e->getMessage());
            return false;
        }
    }

    public function responderTicket($data) {
        try {
            $responder = "UPDATE tickets SET respuesta = :respuesta, estado = 'RESPONDIDO' WHERE id = :id"; 
            $resultado = $this->conexion->prepare($responder);
            $resultado->bindParam(':respuesta', $data['respuesta']);
            $resultado->bindParam(':id', $data['id']);

            $resultado->execute();

            return true;
        } catch (PDOException $e) {
            error_log("Error en Ticket::responderTicket->" . $e->getMessage());
            return false;
        }
    }

    public function cerrarTicket($id) {
        try {
            $cerrar = "UPDATE tickets SET estado = 'CERRADO' WHERE id = :id"; 
            $resultado = $this->conexion->prepare($cerrar);
            $resultado->bindParam(':id', $id);

            $resultado->execute();

            return true;
        } catch (PDOException $e) {
            error_log("Error en Ticket::cerrarTicket->" . $e->getMessage());
            return false;
        }
    }

    // public function responder($id, $respuesta) {
    //     $sql = "UPDATE tickets SET respuesta=?, estado='respondido' WHERE id=?";
    //     $stmt = $this->db->prepare($sql);
    //     return $stmt->execute([$respuesta, $id]);
    // }

    
}
