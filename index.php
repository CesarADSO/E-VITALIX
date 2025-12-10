<?php
// index.php - Router principal (EN LARAVEL SE TIENE UN ARCHIVO POR CADA CARPETA DE VIEWS)

require_once __DIR__ . '/config/config.php';

// Obtener la URL actual (por ejemplo: /E-VITALIX/login)
$requestUri = $_SERVER['REQUEST_URI'];

// Quitar el prefijo de la carpeta del proyecto
$request = str_replace('/E-VITALIX', '', $requestUri);

// Quitar parámetros tipo = ?id=123
$request = strtok($request, '?');

// Quitar la barra final (si existe)
$request = rtrim($request, '/');

// Si la ruta vacia queda como un "/"
if ($request === '') $request = '/';

// Enrutamiento básico
switch ($request) {
    case '/':
        require BASE_PATH . '/app/views/website/index.html';
        break;
    case '/sobreNosotros':
        require BASE_PATH . '/app/views/website/about_us.html';
        break;
    case '/servicios':
        require BASE_PATH . '/app/views/website/servicios.html';
        break;
    case '/servicio':
        require BASE_PATH . '/app/views/website/servicio.html';
        break;
    case '/doctores':
        require BASE_PATH . '/app/views/website/doctores.html';
        break;
    case '/noticias':
        require BASE_PATH . '/app/views/website/noticias.html';
        break;
    case '/noticia':
        require BASE_PATH . '/app/views/website/noticia.html';
        break;
    case '/contacto':
        require BASE_PATH . '/app/views/website/contacto.html';
        break;
    // Inicio rutas login
    case '/login':
        require BASE_PATH . '/app/views/auth/inicioSesion.php';
        break;
    case '/iniciar-sesion':
        require BASE_PATH . '/app/controllers/LoginController.php';
        break;
    case '/registro':
        require BASE_PATH . '/app/views/auth/registrarse.html';
        break;
    case '/recuperacion':
        require BASE_PATH . '/app/views/auth/recuperar-contraseña.php';
        break;

    case '/generar-clave':
        require BASE_PATH . '/app/controllers/passwordController.php';
        break;

    // SUPER ADMIN INTERFACES
    case '/superadmin/dashboard':
        require BASE_PATH . '/app/views/dashboard/superadministrador/dashboard_superadmin.php';
        break;

    case '/superadmin/consultorios':
        require BASE_PATH . '/app/views/dashboard/superadministrador/consultorios.php';
        break;

    case '/superadmin/registrar-consultorio':
        require BASE_PATH . '/app/views/dashboard/superadministrador/registrar-consultorio.php';
        break;
    case '/superadmin/guardar-consultorio':
        require BASE_PATH . '/app/controllers/consultorioController.php';
        break;
    case '/superadmin/actualizar-consultorio':
        require BASE_PATH . '/app/views/dashboard/superadministrador/actualizar-consultorio.php';
        break;

    case '/superadmin/guardar-cambios-consultorio':
        require BASE_PATH . '/app/controllers/consultorioController.php';
        break;

    case '/superadmin/consultar-consultorio':
        require BASE_PATH . '/app/views/dashboard/superadministrador/consultar-consultorio.php';
        break;

    case '/superadmin/eliminar-consultorio':
        require BASE_PATH . '/app/controllers/consultorioController.php';
        break;

    case '/superadmin/generar-reporte':
        require BASE_PATH . '/app/controllers/reportesPdfController.php';
        reportesPdfController();
        break;

    case '/superadmin/usuarios':
        require BASE_PATH . '/app/views/dashboard/superadministrador/usuarios.php';
        break;
    // case '/superadmin/registrarUsuario':
    //     require BASE_PATH . '/app/views/dashboard/superadministrador/registrar-Usuarios.php';
    //     break;
    // case '/superadmin/guardar-usuario':
    //     require BASE_PATH . '/app/controllers/usuarioController.php';
    //     break;
    case '/superadmin/actualizar-usuario':
        require BASE_PATH . '/app/views/dashboard/superadministrador/actualizar-usuario.php';
        break;
    case '/superadmin/eliminar-usuario':
        require BASE_PATH . '/app/controllers/usuarioController.php';
        break;

    case '/superadmin/administradores-consultorio':
        require BASE_PATH . '/app/views/dashboard/superadministrador/gestion-administradores.php';
        break;

    case '/superadmin/registrar-administrador':
        require BASE_PATH . '/app/views/dashboard/superadministrador/registrar-administrador.php';
        break;

    case '/superadmin/guardar-admin-consultorio':
        require BASE_PATH . '/app/controllers/administradorConsultorioController.php';
        break;

    case '/superadmin/actualizar-administrador':
        require BASE_PATH . '/app/views/dashboard/superadministrador/actualizar-administrador.php';
        break;

    case '/superadmin/guardar-cambios-admin-consultorio':
        require BASE_PATH . '/app/controllers/administradorConsultorioController.php';
        break;

    case '/superadmin/eliminar-administrador':
        require BASE_PATH . '/app/controllers/administradorConsultorioController.php';
        break;

    case '/superadmin/consultorios-administradores':
        require BASE_PATH . '/app/views/dashboard/superadministrador/consultorios-administradores.php';
        break;

    case '/superadmin/asignar-administrador':
        require BASE_PATH . '/app/views/dashboard/superadministrador/asignar-administrador.php';
        break;

    case '/superadmin/asignar-admin-consultorio':
        require BASE_PATH . '/app/controllers/consultorioController.php';
        break;

    case '/superadmin/desasignar-administrador':
        require BASE_PATH . '/app/controllers/consultorioController.php';
        break;

    case '/superadmin/perfil':
        require BASE_PATH . '/app/views/dashboard/superadministrador/perfil-admin.php';
        break;


    // ADMIN INTERFACES
    case '/admin/dashboard':
        require BASE_PATH . '/app/views/dashboard/administrador/dashboard_admin.php';
        break;

    case '/admin/especialistas':
        require BASE_PATH . '/app/views/dashboard/administrador/especialistas.php';
        break;

    case '/admin/registrar-especialista':
        require BASE_PATH . '/app/views/dashboard/administrador/registrar-especialista.php';
        break;

    case '/admin/guardar-especialista':
        require BASE_PATH . '/app/controllers/especialistaController.php';
        break;

    case '/admin/actualizar-especialista':
        require BASE_PATH . '/app/views/dashboard/administrador/actualizar-especialista.php';
        break;

    case '/admin/guardar-cambios-especialista':
        require BASE_PATH . '/app/controllers/especialistaController.php';
        break;

    case '/admin/eliminar-especialista':
        require BASE_PATH . '/app/controllers/especialistaController.php';
        break;

    case '/admin/disponibilidades':
        require BASE_PATH . '/app/views/dashboard/administrador/disponibilidades_medicas.php';
        break;

    case '/admin/registrar-disponibilidad':
        require BASE_PATH . '/app/views/dashboard/administrador/registrar-disponibilidad.php';
        break;

    case '/admin/guardar-disponibilidad':
        require BASE_PATH . '/app/controllers/disponibilidadController.php';
        break;

    case '/admin/actualizar-disponibilidad':
        require BASE_PATH . '/app/views/dashboard/administrador/actualizar-disponibilidad.php';
        break;

    case '/admin/guardar-cambios-disponibilidad':
        require BASE_PATH . '/app/controllers/disponibilidadController.php';
        break;

    case '/admin/eliminar-disponibilidad':
        require BASE_PATH . '/app/controllers/disponibilidadController.php';
        break;


    case '/admin/guardar-foto-perfil':
        require BASE_PATH . '/app/controllers/perfilController.php';
        break;

    case '/admin/guardar-configuracion-usuario':
        require BASE_PATH . '/app/controllers/perfilController.php';
        break;

    case '/admin/cambiar-contrasena':
        require BASE_PATH . '/app/controllers/perfilController.php';
        break;
    // En tu index.php, agrega estas rutas:
    case '/admin/pacientes':
        require BASE_PATH . '/app/views/dashboard/administrador/pacientes.php';
        break;

    case '/admin/registrar-paciente':
        require BASE_PATH . '/app/views/dashboard/administrador/registrar-paciente.php';
        break;

    case '/admin/guardar-paciente':
        require BASE_PATH . '/app/controllers/pacienteController.php';
        break;

    case '/admin/actualizar-paciente':
        require BASE_PATH . '/app/views/dashboard/administrador/actualizar-paciente.php';
        break;

    case '/admin/guardar-cambios-paciente':
        require BASE_PATH . '/app/controllers/pacienteController.php';
        break;

    case '/admin/consultar-paciente':
        require BASE_PATH . '/app/views/dashboard/administrador/consultar-paciente.php';
        break;

    case '/admin/eliminar-paciente':
        require BASE_PATH . '/app/controllers/pacienteController.php';
        break;
    case '/doctor':
        require BASE_PATH . '/app/views/dashboard/especialista/dashboard_especialista.html';
        break;
    case '/paciente':
        require BASE_PATH . '/app/views/dashboard/paciente/dashboard_paciente.html';
        break;
    case '/cerrarSesion':
        require BASE_PATH . '/app/controllers/cerrarSesionController.php';
        break;

    default:
        http_response_code(404);
        require BASE_PATH . '/app/views/auth/404.php';
        break;
}
