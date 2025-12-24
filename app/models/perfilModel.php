<?php
require_once __DIR__ . '/../../config/database.php';

class Perfil
{
    private $conexion;
    public function __construct()
    {
        $db = new Conexion();
        $this->conexion = $db->getConexion();
    }

    // ESTA FUNCIÓN SE DUPLICA POR CADA ROL

    public function mostrarPerfilSuperAdmin($id)
    {
        try {
            // EN UNA VARIABLE GUARDAMOS LA CONSULTA SQL A EJECUTAR SEGÚN SEA EL CASO
            $consulta = "SELECT usuarios.*, roles.nombre AS roles_nombre, superadministradores.nombres AS superadmin_nombre, superadministradores.apellidos, superadministradores.telefono, superadministradores.foto FROM superadministradores INNER JOIN usuarios ON superadministradores.id_usuario = usuarios.id INNER JOIN roles ON usuarios.id_rol = roles.id WHERE usuarios.id = :id LIMIT 1";

            $resultado = $this->conexion->prepare($consulta);

            $resultado->bindParam(':id', $id);

            $resultado->execute();

            return $resultado->fetch();
        } catch (PDOException $e) {
            error_log("Error en Perfil::mostrarPerfilAdmin->" . $e->getMessage());
            return [];
        }
    }

    public function mostrarPerfilAdmin($id)
    {
        try {
            // EN UNA VARIABLE GUARDAMOS LA CONSULTA SQL A EJECUTAR SEGÚN SEA EL CASO
            $consulta = "SELECT usuarios.*, roles.nombre AS roles_nombre, administradores.nombres AS admin_nombre, administradores.apellidos, administradores.telefono, administradores.foto FROM administradores INNER JOIN usuarios ON administradores.id_usuario = usuarios.id INNER JOIN roles ON usuarios.id_rol = roles.id WHERE usuarios.id = :id LIMIT 1";

            $resultado = $this->conexion->prepare($consulta);

            $resultado->bindParam(':id', $id);

            $resultado->execute();

            return $resultado->fetch();}
        catch (PDOException $e) {
            error_log("Error en Perfil::mostrarPerfilAdmin->" . $e->getMessage());
            return [];
        }
    }

    public function mostrarPerfilEspecialista($id)
    {
        try {
            // EN UNA VARIABLE GUARDAMOS LA CONSULTA SQL A EJECUTAR SEGÚN SEA EL CASO
            $consulta = "SELECT usuarios.*, roles.nombre AS roles_nombre, especialistas.nombres AS especialista_nombre, especialistas.apellidos, especialistas.telefono, especialistas.foto FROM especialistas INNER JOIN usuarios ON especialistas.id_usuario = usuarios.id INNER JOIN roles ON usuarios.id_rol = roles.id WHERE usuarios.id = :id LIMIT 1";

            $resultado = $this->conexion->prepare($consulta);

            $resultado->bindParam(':id', $id);

            $resultado->execute();

            return $resultado->fetch();}
        catch (PDOException $e) {
            error_log("Error en Perfil::mostrarPerfilEspecialista->" . $e->getMessage());
            return [];
        }
    }

    public function actualizarInfoPersonalSuperAdmin($data)
    {
        try {
            // EN UNA VARIABLE GUARDAMOS LA CONSULTA SQL A EJECUTAR SEGÚN SEA EL CASO


            // UPDATE EN PERFILES
            $actualizarInfo = "UPDATE superadministradores SET nombres = :nombres, apellidos = :apellidos, telefono = :telefono WHERE id_usuario = :id";

            $resultado = $this->conexion->prepare($actualizarInfo);

            $resultado->bindParam(':id', $data['id']);

            $resultado->bindParam(':nombres', $data['nombres']);

            $resultado->bindParam(':apellidos', $data['apellidos']);

            $resultado->bindParam(':telefono', $data['telefono']);


            $resultado->execute();

            // UPDATE EN USUARIOS
            $actualizarCorreo = "UPDATE usuarios SET email = :email WHERE id = :id";

            $resultado2 = $this->conexion->prepare($actualizarCorreo);

            $resultado2->bindParam(':id', $data['id']);

            $resultado2->bindParam(':email', $data['email']);

            $resultado2->execute();

            return true;
        } catch (PDOException $e) {
            error_log("Error en perfil::actualizarInfoPersonalAdmin->" . $e->getMessage());
            return false;
        }
    }

    public function actualizarContrasenaSuperAdmin($data)
    {
        try {
            // EN UNA VARIABLE GUARDAMOS LA CONSULTA SQL A EJECUTAR SEGÚN SEA EL CASO

            $consultar = "SELECT contrasena FROM usuarios WHERE id = :id";

            $resultado = $this->conexion->prepare($consultar);

            $resultado->bindParam(':id', $data['id']);

            $resultado->execute();

            // TOMAMOS EL RESULTADO DE LA CONSULTA Y LO CONVERTIMOS EN UN ARREGLO PARA PODER LEER LA CONTRASEÑA GUARDADA
            $usuario = $resultado->fetch(PDO::FETCH_ASSOC);

            // VALIDAMOS SI EL USUARIO EXISTE
            if (!$usuario) {
                return false;
            }

            // VALIDAMOS SI LA CONTRASEÑA ACTUAL COINCIDE CON LA DE LA BASE DE DATOS
            if (!password_verify($data['claveActual'], $usuario['contrasena'])) {
                return false;
            }

            // VALIDAMOS QUE LA CONTRASEÑA NUEVA NO SEA IGUAL A LA ACTUAL
            if (password_verify($data['claveNueva'], $usuario['contrasena'])) {
                return false;
            }

            // ENCRIPTAMOS LA NUEVA CONTRASEÑA
            $claveEncriptada = password_hash($data['claveNueva'], PASSWORD_DEFAULT);

            // EN UNA VARIABLE GUARDAMOS LA CONSULTA SQL A EJECUTAR SEGÚN SEA EL CASO
            // EN ESTE CASO HACEMOS EL UPDATE

            $actualizar = "UPDATE usuarios SET contrasena = :claveNueva WHERE id = :id";

            $resultado2 = $this->conexion->prepare($actualizar);

            $resultado2->bindParam(':id', $data['id']);
            $resultado2->bindParam(':claveNueva', $claveEncriptada);

            $resultado2->execute();

            

            return true;
        } catch (PDOException $e) {
            error_log("Error en perfil::actualizarContrasenaAdmin->" . $e->getMessage());
            return false;
        }
    }

    public function actualizarFotoSuperAdmin($data) {
        try {
            
            // DEFINIMOS EN UNA VARIABLE LA CONSULTA SQL A EJECUTAR SEGÚN SEA EL CASO
            $actualizar = "UPDATE superadministradores SET foto = :foto WHERE id_usuario = :id";

            $resultado = $this->conexion->prepare($actualizar);

            $resultado->bindParam(':id', $data['id']);
            $resultado->bindParam(':foto', $data['foto']);

            $resultado->execute();

            return true;



        } catch (PDOException $e) {
            error_log("Error en perfil::actualizarFotoAdmin->" . $e->getMessage());
            return false;
        }
    }


    public function actualizarInfoPersonalAdmin($data)
    {
        try {
            // EN UNA VARIABLE GUARDAMOS LA CONSULTA SQL A EJECUTAR SEGÚN SEA EL CASO


            // UPDATE EN PERFILES
            $actualizarInfo = "UPDATE administradores SET nombres = :nombres, apellidos = :apellidos, telefono = :telefono WHERE id_usuario = :id";

            $resultado = $this->conexion->prepare($actualizarInfo);

            $resultado->bindParam(':id', $data['id']);

            $resultado->bindParam(':nombres', $data['nombres']);

            $resultado->bindParam(':apellidos', $data['apellidos']);

            $resultado->bindParam(':telefono', $data['telefono']);


            $resultado->execute();

            // UPDATE EN USUARIOS
            $actualizarCorreo = "UPDATE usuarios SET email = :email WHERE id = :id";

            $resultado2 = $this->conexion->prepare($actualizarCorreo);

            $resultado2->bindParam(':id', $data['id']);

            $resultado2->bindParam(':email', $data['email']);

            $resultado2->execute();

            return true;
        } catch (PDOException $e) {
            error_log("Error en perfil::actualizarInfoPersonalAdmin->" . $e->getMessage());
            return false;
        }
    }

    public function actualizarContrasenaAdmin($data)
    {
        try {
            // EN UNA VARIABLE GUARDAMOS LA CONSULTA SQL A EJECUTAR SEGÚN SEA EL CASO

            $consultar = "SELECT contrasena FROM usuarios WHERE id = :id";

            $resultado = $this->conexion->prepare($consultar);

            $resultado->bindParam(':id', $data['id']);

            $resultado->execute();

            // TOMAMOS EL RESULTADO DE LA CONSULTA Y LO CONVERTIMOS EN UN ARREGLO PARA PODER LEER LA CONTRASEÑA GUARDADA
            $usuario = $resultado->fetch(PDO::FETCH_ASSOC);

            // VALIDAMOS SI EL USUARIO EXISTE
            if (!$usuario) {
                return false;
            }

            // VALIDAMOS SI LA CONTRASEÑA ACTUAL COINCIDE CON LA DE LA BASE DE DATOS
            if (!password_verify($data['claveActual'], $usuario['contrasena'])) {
                return false;
            }

            // VALIDAMOS QUE LA CONTRASEÑA NUEVA NO SEA IGUAL A LA ACTUAL
            if (password_verify($data['claveNueva'], $usuario['contrasena'])) {
                return false;
            }

            // ENCRIPTAMOS LA NUEVA CONTRASEÑA
            $claveEncriptada = password_hash($data['claveNueva'], PASSWORD_DEFAULT);

            // EN UNA VARIABLE GUARDAMOS LA CONSULTA SQL A EJECUTAR SEGÚN SEA EL CASO
            // EN ESTE CASO HACEMOS EL UPDATE

            $actualizar = "UPDATE usuarios SET contrasena = :claveNueva WHERE id = :id";

            $resultado2 = $this->conexion->prepare($actualizar);

            $resultado2->bindParam(':id', $data['id']);
            $resultado2->bindParam(':claveNueva', $claveEncriptada);

            $resultado2->execute();

            

            return true;
        } catch (PDOException $e) {
            error_log("Error en perfil::actualizarContrasenaAdmin->" . $e->getMessage());
            return false;
        }
    }

    public function actualizarFotoAdmin($data) {
        try {
            
            // DEFINIMOS EN UNA VARIABLE LA CONSULTA SQL A EJECUTAR SEGÚN SEA EL CASO
            $actualizar = "UPDATE administradores SET foto = :foto WHERE id_usuario = :id";

            $resultado = $this->conexion->prepare($actualizar);

            $resultado->bindParam(':id', $data['id']);
            $resultado->bindParam(':foto', $data['foto']);

            $resultado->execute();

            return true;



        } catch (PDOException $e) {
            error_log("Error en perfil::actualizarFotoAdmin->" . $e->getMessage());
            return false;
        }
    }

    public function actualizarInfoPersonalEspecialista($data) {

        try {
            
            $actualizarEspecialista = "UPDATE especialistas SET nombres = :nombres, apellidos = :apellidos, telefono = :telefono WHERE id_usuario = :id";

            $resultadoEspecialista = $this->conexion->prepare($actualizarEspecialista);

            $resultadoEspecialista->bindParam(':id', $data['id']);
            $resultadoEspecialista->bindParam(':nombres', $data['nombres']);
            $resultadoEspecialista->bindParam(':apellidos', $data['apellidos']);
            $resultadoEspecialista->bindParam(':telefono', $data['telefono']);

            $resultadoEspecialista->execute();

            $actualizarUsuario = "UPDATE usuarios SET email = :email WHERE id = :id";

            $resultadoUsuario = $this->conexion->prepare($actualizarUsuario);

            $resultadoUsuario->bindParam(':id', $data['id']);
            $resultadoUsuario->bindParam(':email', $data['email']);

            $resultadoUsuario->execute();

            return true;


        } catch (PDOException $e) {
            error_log("Error en perfil::actualizarInfoPersonalEspecialista->" . $e->getMessage());
            return false;
        }


    }

    
}
