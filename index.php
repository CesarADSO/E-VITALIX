<?php
// index.php - Router principal (EN LARAVEL SE TIENE UN ARCHIVO POR CADA CARPETA DE VIEWS)

define('BASE_PATH', __DIR__);

// Obtener la URL actual (por ejemplo: /E-VITALIX/login)
$requestUri = $_SERVER['REQUEST_URI'];

// Quitar el prefijo de la carpeta del proyecto
$request = str_replace('/E-VITALIX', '', $requestUri);

// Quitar parámetros tipo = ?id=123
$request = strtok($request, '?');

// Quitar la barra final (si existe)
$request = rtrim($request, '/');

// Si la ruta vacia queda como un "/"
if($request === '') $request = '/';

// Enrutamiento básico
switch ($request) {
    case '/':
        require BASE_PATH . '/app/views/website/index.html';
        break;
    case '/sobreNosotros':
        require BASE_PATH . '/app/views/website/about us.html';
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
    case '/login':
        require BASE_PATH . '/app/views/auth/inicioSesion.html';
        break;
    case '/registro':
        require BASE_PATH . '/app/views/auth/registrarse.html';
        break;
    case '/recuperacion': 
        require BASE_PATH . '/app/views/auth/recuperar-contraseña.html';
        break;
    case '/admin': 
        require BASE_PATH . '/app/views/dashboard/administrador/dashboard_admin.html';
        break;
    default:
        http_response_code(404);
        require BASE_PATH . '/app/views/auth/404.html';
        break;
}
?>