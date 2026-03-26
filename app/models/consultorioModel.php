<?php
require_once __DIR__ . '/../../config/database.php';

class Consultorio
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

            // ENCRIPTAMOS LA CONTRASEÑA POR DEFECTO DEL NUEVO ADMINISTRADOR QUE VA A SER SU NÚMERO DE DOCUMENTO
            $clave_encriptada = password_hash($data['numero_documento_admin'], PASSWORD_DEFAULT);

            // HACEMOS EL INSERT EN USUARIOS
            $insertarUsuario = "INSERT INTO usuarios(email, contrasena, id_rol, estado) VALUES(:email, :contrasena, 2, 'Activo')";

            $resultadoUsuario = $this->conexion->prepare($insertarUsuario);
            $resultadoUsuario->bindParam(':email', $data['email_admin']);
            $resultadoUsuario->bindParam(':contrasena', $clave_encriptada);

            $resultadoUsuario->execute();

            // OBTENEMOS EL ID DEL USUARIO REGISTRADO
            $id_usuario_admin = $this->conexion->lastInsertId();

            // HACEMOS EL INSERT EN ADMINISTRADORES SIN EL ID DEL CONSULTORIO, LO MANTENEMOS EN NULL
            $insertarAdmin = "INSERT INTO administradores(id_usuario, id_consultorio, nombres, apellidos, foto, telefono, id_tipo_documento, numero_documento) VALUES (:id_usuario, NULL, :nombres, :apellidos, :foto, :telefono, :id_tipo_documento, :numero_documento)";


            $resultadoAdmin = $this->conexion->prepare($insertarAdmin);
            // AQUÍ LE ASIGNAMOS AL CAMPO ID_USUARIO EL ID DEL ÚLTIMO USUARIO REGISTRADO
            $resultadoAdmin->bindParam(':id_usuario', $id_usuario_admin);
            $resultadoAdmin->bindParam(':nombres', $data['nombres_admin']);
            $resultadoAdmin->bindParam(':apellidos', $data['apellidos_admin']);
            $resultadoAdmin->bindParam(':foto', $data['foto_admin']);
            $resultadoAdmin->bindParam(':telefono', $data['telefono_admin']);
            $resultadoAdmin->bindParam(':id_tipo_documento', $data['tipo_documento_admin']);
            $resultadoAdmin->bindParam(':numero_documento', $data['numero_documento_admin']);

            $resultadoAdmin->execute();

            // OBTENEMOS EL ID DEL ÚLTIMO ADMINISTRADOR REGISTRADO PARA LUEGO PODER HACER EL UPDATE EN EL CAMPO ID_CONSULTORIO
            $id_admin = $this->conexion->lastInsertId();

            // HACEMOS EL INSERT EN CONSULTORIOS
            $insertar = "INSERT INTO consultorios(nombre, direccion, foto, ciudad, telefono, correo_contacto, horario_atencion, estado) VALUES(:nombre, :direccion, :foto, :ciudad, :telefono, :correo_contacto, :horario_atencion, 'Activo')";



            $resultado = $this->conexion->prepare($insertar);
            $resultado->bindParam(':nombre', $data['nombre']);
            $resultado->bindParam(':direccion', $data['direccion']);
            $resultado->bindParam(':foto', $data['foto']);
            $resultado->bindParam(':ciudad', $data['ciudad']);
            $resultado->bindParam(':telefono', $data['telefono']);
            $resultado->bindParam(':correo_contacto', $data['correo_contacto']);
            $resultado->bindParam(':horario_atencion', $data['horario_atencion']);

            $resultado->execute();

            // OBTENEMOS EL ID DEL ÚLTIMO CONSULTORIO REGISTRADO
            $id_consultorio = $this->conexion->lastInsertId();

            // HACEMOS EL UPDATE EN ADMINISTRADORES PARA ASIGNARLE EL ID DEL ÚLTIMO CONSULTORIO REGISTRADO AL CAMPO ID_CONSULTORIO Y HACEMOS EL WHERE CON EL ID DEL ADMIN OBTENIDO ANTERIORMENTE
            $asignarConusultorioAdmin = "UPDATE administradores SET id_consultorio = :id_consultorio WHERE id = :id LIMIT 1";

            $resultadoAsignar = $this->conexion->prepare($asignarConusultorioAdmin);
            $resultadoAsignar->bindParam(':id_consultorio', $id_consultorio);
            $resultadoAsignar->bindParam(':id', $id_admin);

            $resultadoAsignar->execute();

            return true;
        } catch (PDOException $e) {
            error_log("Error en consultorio::registrar->" . $e->getMessage());
            return false;
        }
    }

    public function consultar()
    {
        try {
            // Variable que almacena la sentencia de sql a ejecutar
            $consultar = "SELECT consultorios.*, administradores.nombres, administradores.apellidos FROM consultorios LEFT JOIN administradores ON consultorios.id = administradores.id_consultorio ORDER BY consultorios.nombre ASC";
            // Preparar lo necesario para ejecutar la función

            $resultado = $this->conexion->prepare($consultar);

            $resultado->execute();

            return $resultado->fetchAll();
        } catch (PDOException $e) {
            error_log("Error en consultorio::consultar->" . $e->getMessage());
            return [];
        }
    }

    public function listarConsultoriosPorEspecialidad($id_especialidad)
    {
        try {

            // HACEMOS LA CONSULTA DE LOS CONSULTORIOS

            $consulta = "SELECT 
        consultorios.*, consultorios.id AS id_consultorio,
        consultorio_especialidad.id_especialidad,
        /* DISTINCT evita que se repitan nombres si hay cruces en los JOIN */
        /* SEPARATOR define cómo separaremos los nombres para luego usarlos en PHP */
        GROUP_CONCAT(DISTINCT especialidades.nombre SEPARATOR ', ') AS nombres_especialidades,
        /* TRUCO PARA EL PROYECTO: Agrupamos ID y Nombre del servicio juntos */
        /* Usamos un formato como 'ID:Nombre' para separarlos luego en PHP */
        GROUP_CONCAT(DISTINCT CONCAT(servicios.id, ':', servicios.nombre, ':', servicios.precio) SEPARATOR '|') AS servicios_agrupados
    FROM consultorios
    INNER JOIN consultorio_especialidad 
        ON consultorio_especialidad.id_consultorio = consultorios.id
    INNER JOIN especialidades 
        ON especialidades.id = consultorio_especialidad.id_especialidad
    LEFT JOIN servicios 
        ON servicios.id_consultorio = consultorios.id
        AND servicios.id_especialidad = :id_especialidad -- <--- ESTA ES LA LÍNEA CLAVE PARA QUE NO ME TRAIGA LOS SERVICIOS DE OTRA ESPECIALIDAD
        AND servicios.estado_servicio = 'ACTIVO' -- <--- NUEVA LÍNEA CLAVE PARA QUE SOLO SE PUEDAN AGENDAR SERVICIOS ACTIVOS
    WHERE consultorios.id IN (
        /* SUBQUERY: Primero encontramos TODOS los IDs de consultorios que tengan la especialidad buscada */
        /* Esto permite que el JOIN traiga TODAS las especialidades del consultorio, no solo la seleccionada */
        SELECT id_consultorio FROM consultorio_especialidad WHERE id_especialidad = :id_especialidad
    )
    /* LA CLAVE: Colapsa todos los resultados en una sola fila por cada ID de consultorio */
    /* El GROUP_CONCAT ahora captura TODAS las especialidades del consultorio */
    GROUP BY consultorios.id";

            $resultado = $this->conexion->prepare($consulta);
            $resultado->bindParam(':id_especialidad', $id_especialidad);
            $resultado->execute();

            return $resultado->fetchAll();
        } catch (PDOException $e) {
            error_log("Error en consultorio::listarConsultoriosPorEspecialidad->" . $e->getMessage());
            return [];
        }
    }

    public function listarConsultorioPorId($id)
    {
        try {
            // EN UNA VARIABLE GUARDAMOS LA CONSULTA SQL A EJECUTAR SEGÚN SEA EL CASO
            $consulta = "SELECT consultorios.*, planes_suscripcion.limite_citas_mensuales FROM consultorios INNER JOIN planes_suscripcion ON consultorios.id_plan = planes_suscripcion.id WHERE consultorios.id = :id LIMIT 1";

            $resultado = $this->conexion->prepare($consulta);

            $resultado->bindParam(':id', $id);

            $resultado->execute();

            return $resultado->fetch();
        } catch (PDOException $e) {
            error_log("Error en consultorio::consultar->" . $e->getMessage());
            return [];
        }
    }

    public function actualizar($data)
    {
        try {
            $actualizar = "UPDATE consultorios SET nombre = :nombre, direccion = :direccion, ciudad = :ciudad, telefono = :telefono, correo_contacto = :correo_contacto, horario_atencion = :horario_atencion, estado = :estado WHERE id = :id";

            $resultado = $this->conexion->prepare($actualizar);
            $resultado->bindParam(':id', $data['id']);
            $resultado->bindParam(':nombre', $data['nombre']);
            $resultado->bindParam(':ciudad', $data['ciudad']);
            $resultado->bindParam(':direccion', $data['direccion']);
            $resultado->bindParam(':telefono', $data['telefono']);
            $resultado->bindParam(':correo_contacto', $data['correo_contacto']);
            $resultado->bindParam(':horario_atencion', $data['horario_atencion']);
            $resultado->bindParam(':estado', $data['estado']);

            $resultado->execute();

            return true;
        } catch (PDOException $e) {
            error_log("Error en consultorio::actualizar->" . $e->getMessage());
            return false;
        }
    }

    public function eliminar($id)
    {
        try {
            $eliminar = "DELETE FROM consultorios WHERE id = :id";
            $resultado = $this->conexion->prepare($eliminar);
            $resultado->bindParam(':id', $id);

            $resultado->execute();

            return true;
        } catch (PDOException $e) {
            error_log("Error en consultorio::eliminar->" . $e->getMessage());
            return false;
        }
    }

    public function verificarVigenciaPlan($id_consultorio)
    {
        try {
            // Obtenemos los datos actuales del consultorio
            $obtenerDatosConsultorio = "SELECT id_plan, fecha_vencimiento_plan FROM consultorios WHERE id = :id_consultorio";

            $resultado = $this->conexion->prepare($obtenerDatosConsultorio);
            $resultado->bindParam(':id_consultorio', $id_consultorio);

            $resultado->execute();

            // En la variable consultorio guardamos esos datos
            $consultorio = $resultado->fetch();

            // Si el consultorio no existe o está en el plan 1 no hacemos nada
            if (!$consultorio || $consultorio['id_plan'] == 1 || $consultorio['fecha_vencimiento_plan'] == null) {
                return false;
            }

            // ==========================================
            // PASO 2: LA MATEMÁTICA EN PHP (El IF)
            // ==========================================

            // Extraemos en una variable la fecha de vencimiento de ese plan
            $fechaVencimiento = $consultorio['fecha_vencimiento_plan'];

            // Obtenemos la fecha de hoy
            $fechaHoy = date('Y-m-d');

            // Validamos que si la fecha de vencimiento es menor a la fecha de hoy para hacer el update del id_plan a 1
            if ($fechaVencimiento < $fechaHoy) {
                // ==========================================
                // PASO 3: IR A MODIFICAR (El UPDATE)
                // ==========================================

                $modificarIdPlan = "UPDATE consultorios SET id_plan = 1, fecha_vencimiento_plan = NULL WHERE id = :id_consultorio";
                $resultado2 = $this->conexion->prepare($modificarIdPlan);
                $resultado2->bindParam(':id_consultorio', $id_consultorio);

                // Ejecutamos la consulta sql
                $resultado2->execute();

                // Retornamos true
                return true;
            }
            
        } catch (PDOException $e) {
            error_log("Error en Consultorio::verificarVigenciaPlan->" . $e->getMessage());
            return false;
        }
    }
}
