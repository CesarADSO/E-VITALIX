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
    
    // ADMIN INTERFACES
    case '/admin/dashboard':
        require BASE_PATH . '/app/views/dashboard/administrador/dashboard_admin.php';
        break;

    case '/admin/consultorios':
        require BASE_PATH . '/app/views/dashboard/administrador/consultorios.php';
        break;

    case '/admin/registrar-consultorio':
        require BASE_PATH . '/app/views/dashboard/administrador/registrar-consultorio.php';
        break;
    case '/admin/guardar-consultorio':
        require BASE_PATH . '/app/controllers/consultorioController.php';
        break;
    case '/admin/actualizar-consultorio':
        require BASE_PATH . '/app/views/dashboard/administrador/actualizar-consultorio.php';
        break;

    case '/admin/guardar-cambios-consultorio':
        require BASE_PATH . '/app/controllers/consultorioController.php';
        break;

    case '/admin/eliminar-consultorio':
        require BASE_PATH . '/app/controllers/consultorioController.php';
        break;

    case '/admin/generar-reporte-consultorios':
        require BASE_PATH . '/app/controllers/reportesPdfController.php';
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
        
    case '/admin/horarios':
        require BASE_PATH . '/app/views/dashboard/administrador/horarios.php';
        break;
        
    case '/admin/registrar-horario':
        require BASE_PATH . '/app/views/dashboard/administrador/registrar-horario.php';
        break;

    case '/admin/guardar-horario':
        require BASE_PATH . '/app/controllers/horarioController.php';
        break;
    
    case '/admin/actualizar-horario':
        require BASE_PATH . '/app/views/dashboard/administrador/actualizar-horario.php';
        break;   

    case '/admin/perfil':
        require BASE_PATH . '/app/views/dashboard/administrador/perfil-admin.php';
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
    case '/doctor':
        require BASE_PATH . '/app/views/dashboard/especialista/dashboard_especialista.html';
        break;
    case '/paciente':
        require BASE_PATH . '/app/views/dashboard/paciente/dashboard_paciente.html';
        break;
    case '/cerrarSesion':
        require BASE_PATH . '/app/controllers/cerrarSesionController.php';
        break;
    case '/admin/usuarios':
        require BASE_PATH . '/app/views/dashboard/administrador/usuarios.php';
        break;
    case '/admin/registrarUsuario':
        require BASE_PATH . '/app/views/dashboard/administrador/registrar-Usuarios.php';
        break;
    case '/admin/guardar-usuario':
        require BASE_PATH . '/app/controllers/usuarioController.php';
        break;
    case '/admin/guardar-usuario':
        require BASE_PATH . '/app/controllers/usuarioController.php';
        break;
    default:
        http_response_code(404);
        require BASE_PATH . '/app/views/auth/404.php';
        break;
}
