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
        require BASE_PATH . '/app/views/website/doctores.php';
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
        require BASE_PATH . '/app/views/auth/registrarse.php';
        break;

    case '/registrarse':
        require BASE_PATH . '/app/controllers/registroController.php';
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
    case '/superadmin/registrar-usuario':
        require BASE_PATH . '/app/views/dashboard/superadministrador/registrar-usuario.php';
        break;
    case '/superadmin/guardar-usuario':
        require BASE_PATH . '/app/controllers/usuarioController.php';
        break;
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

    case '/superadmin/administradores-consultorios':
        require BASE_PATH . '/app/views/dashboard/superadministrador/administradores-consultorios.php';
        break;

    case '/superadmin/asignar-consultorio':
        require BASE_PATH . '/app/views/dashboard/superadministrador/asignar-consultorio.php';
        break;

    case '/superadmin/asignar-consultorio-admin':
        require BASE_PATH . '/app/controllers/administradorConsultorioController.php';
        break;

    case '/superadmin/desasignar-consultorio':
        require BASE_PATH . '/app/controllers/administradorConsultorioController.php';
        break;

    case '/superadmin/perfil':
        require BASE_PATH . '/app/views/dashboard/superadministrador/perfil-superAdmin.php';
        break;


    // ADMIN INTERFACES
    case '/administrador/dashboard':
        require BASE_PATH . '/app/views/dashboard/administrador/dashboard-administrador.php';
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

    case '/admin/consultar-especialista':
        require BASE_PATH . '/app/views/dashboard/administrador/consultar-especialista.php';


    case '/especialista/calendario':
        require BASE_PATH . '/app/views/dashboard/especialista/calendario_especialista.php';
        break;

    case '/especialista/calendario-api':
        require BASE_PATH . '/app/controllers/calendarioController.php';
        break;

    case '/admin/generar-reporte':
        require BASE_PATH . '/app/controllers/reportesPdfControllerAdministrador.php';
        reportesPdfController();
        break;

    case '/admin/asistentes':
        require BASE_PATH . '/app/views/dashboard/administrador/asistentes.php';
        break;

    case '/admin/registrar-asistente':
        require BASE_PATH . '/app/views/dashboard/administrador/registrar-asistente.php';
        break;

    case '/admin/guardar-asistente':
        require BASE_PATH . '/app/controllers/asistenteController.php';
        break;

    case '/admin/actualizar-asistente':
        require BASE_PATH . '/app/views/dashboard/administrador/actualizar-asistente.php';
        break;

    case '/admin/guardar-cambios-asistente':
        require BASE_PATH . '/app/controllers/asistenteController.php';
        break;

    case '/admin/servicios':
        require BASE_PATH . '/app/views/dashboard/administrador/servicios.php';
        break;

    case '/admin/registrar-servicio':
        require BASE_PATH . '/app/views/dashboard/administrador/registrar-servicio.php';
        break;

    case '/admin/guardar-servicio':
        require BASE_PATH . '/app/controllers/servicioController.php';
        break;

    case '/admin/actualizar-servicio':
        require BASE_PATH . '/app/views/dashboard/administrador/actualizar-servicio.php';
        break;

    case '/admin/guardar-cambios-servicio':
        require BASE_PATH . '/app/controllers/servicioController.php';
        break;

    case '/admin/eliminar-servicio':
        require BASE_PATH . '/app/controllers/servicioController.php';
        break;

    case '/admin/consultar-servicio':
        require BASE_PATH . '/app/views/dashboard/administrador/consultar-servicio.php';
        break;

    case '/admin/especialidades';
        require BASE_PATH . '/app/views/dashboard/administrador/especialidades.php';
        break;

    case '/admin/registrar-especialidad';
        require BASE_PATH . '/app/views/dashboard/administrador/registrar-especialidad.php';
        break;

    case '/admin/guardar-especialidad';
        require BASE_PATH . '/app/controllers/especialidadController.php';
        break;

    case '/admin/cambiar-estado-especialidad';
        require BASE_PATH . '/app/controllers/especialidadController.php';
        break;

    case '/admin/editar-especialidad';
        require BASE_PATH . '/app/views/dashboard/administrador/editar-especialidad.php';
        break;

    case '/admin/guardar-cambios-especialidad';
        require BASE_PATH . '/app/controllers/especialidadController.php';
        break;
    // case '/admin/disponibilidades':
    //     require BASE_PATH . '/app/views/dashboard/administrador/disponibilidades_medicas.php';
    //     break;

    // case '/admin/registrar-disponibilidad':
    //     require BASE_PATH . '/app/views/dashboard/administrador/registrar-disponibilidad.php';
    //     break;

    // case '/admin/guardar-disponibilidad':
    //     require BASE_PATH . '/app/controllers/disponibilidadController.php';
    //     break;

    // case '/admin/actualizar-disponibilidad':
    //     require BASE_PATH . '/app/views/dashboard/administrador/actualizar-disponibilidad.php';
    //     break;

    // case '/admin/guardar-cambios-disponibilidad':
    //     require BASE_PATH . '/app/controllers/disponibilidadController.php';
    //     break;

    // case '/admin/eliminar-disponibilidad':
    //     require BASE_PATH . '/app/controllers/disponibilidadController.php';
    //     break;


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

    case '/admin/perfil':
        require BASE_PATH . '/app/views/dashboard/administrador/perfil-admin.php';
        break;

    // ESPECIALISTA INTERFACES
    case '/especialista/dashboard':
        require BASE_PATH . '/app/views/dashboard/especialista/dashboard_especialista.php';
        break;

    case '/especialista/disponibilidad':
        require BASE_PATH . '/app/views/dashboard/especialista/disponibilidades_medicas.php';
        break;

    case '/especialista/registrar-disponibilidad':
        require BASE_PATH . '/app/views/dashboard/especialista/registrar-disponibilidad.php';
        break;

    case '/especialista/guardar-disponibilidad':
        require BASE_PATH . '/app/controllers/horarioController.php';
        break;

    case '/especialista/actualizar-disponibilidad':
        require BASE_PATH . '/app/views/dashboard/especialista/actualizar-disponibilidad.php';
        break;

    case '/especialista/guardar-cambios-disponibilidad':
        require BASE_PATH . '/app/controllers/horarioController.php';
        break;

    case '/especialista/eliminar-disponibilidad':
        require BASE_PATH . '/app/controllers/horarioController.php';
        break;

    case '/especialista/consultar-disponibilidad':
        require BASE_PATH . '/app/views/dashboard/especialista/consultar-disponibilidad.php';
        break;

    case '/especialista/perfil':
        require BASE_PATH . '/app/views/dashboard/especialista/perfil-especialista.php';
        break;

    case '/especialista/guardar-foto-perfil':
        require BASE_PATH . '/app/controllers/perfilController.php';
        break;

    case '/especialista/guardar-configuracion-usuario':
        require BASE_PATH . '/app/controllers/perfilController.php';
        break;

    case '/especialista/cambiar-contrasena':
        require BASE_PATH . '/app/controllers/perfilController.php';
        break;

    case '/especialista/slots':
        require BASE_PATH . '/app/views/dashboard/especialista/slots.php';
        break;

    case '/especialista/actualizar-slot':
        require BASE_PATH . '/app/controllers/slotController.php';
        break;

    // NUEVA RUTA: Módulo Mis Citas del Especialista
    case '/especialista/mis-citas':
        require BASE_PATH . '/app/controllers/misCitasController.php';
        mostrarMisCitas();
        break;

    case '/especialista/aceptar-cita':
        require BASE_PATH . '/app/controllers/misCitasController.php';
        break;

    case '/especialista/cancelar-cita':
        require BASE_PATH . '/app/controllers/misCitasController.php';
        break;

    case '/especialista/iniciar-consulta':
        require BASE_PATH . '/app/views/dashboard/especialista/registrar_consulta.php';
        break;

    case '/especialista/guardar-consulta':
        require BASE_PATH . '/app/controllers/consultaMedicaController.php';
        break;

    case '/especialista/pacientes-atendidos':
        require BASE_PATH . '/app/views/dashboard/especialista/pacientes_atendidos.php';
        break;

    case '/especialista/historial_clinico':
        require BASE_PATH . '/app/views/dashboard/especialista/historial_clinico.php';
        break;

    case '/especialista/formular_medicamentos':
        require BASE_PATH . '/app/views/dashboard/especialista/formular_medicamentos.php';
        break;

    case '/especialista/guardar-medicamento':
        require BASE_PATH . '/app/controllers/medicamentoController.php';
        break;

    // ASISTENTE INTERFACES
    case '/asistente/dashboard':
        require BASE_PATH . '/app/views/dashboard/asistente/dashboard_asistente.php';
        break;

    case '/asistente/perfil':
        require BASE_PATH . '/app/views/dashboard/asistente/perfil-asistente.php';
        break;

    case '/asistente/guardar-configuracion-usuario':
        require BASE_PATH . '/app/controllers/perfilController.php';
        break;

    case '/asistente/cambiar-contrasena':
        require BASE_PATH . '/app/controllers/perfilController.php';
        break;

    case '/asistente/guardar-foto-perfil':
        require BASE_PATH . '/app/controllers/perfilController.php';
        break;

    case '/cerrarSesion':
        require BASE_PATH . '/app/controllers/cerrarSesionController.php';
        break;

    // PACIENTE INTERFACES
    case '/paciente/dashboard':
        require BASE_PATH . '/app/views/dashboard/paciente/dashboard_paciente.php';
        break;

    case '/paciente/completar-perfil':
        require BASE_PATH . '/app/views/dashboard/paciente/completar-perfil.php';
        break;

    case '/paciente/terminar-perfil':
        require BASE_PATH . '/app/controllers/registroController.php';
        break;

    case '/paciente/modulo-citas':
        require BASE_PATH . '/app/views/dashboard/paciente/buscar-consultorio.php';
        break;

    case '/paciente/buscar-consultorio':
        require BASE_PATH . '/app/controllers/consultorioController.php';
        break;

    case '/paciente/agendar_paso2':
        require BASE_PATH . '/app/views/dashboard/paciente/seleccionar-horario.php';
        break;

    case '/paciente/confirmar-cita':
        require BASE_PATH . '/app/controllers/citaController.php';
        break;

    case '/paciente/lista-de-citas':
        require BASE_PATH . '/app/views/dashboard/paciente/lista-de-citas.php';
        break;

    case '/paciente/agendarCita':
        require BASE_PATH . '/app/views/dashboard/paciente/agendar_cita.php';
        break;

    case '/paciente/guardar-cita':
        require BASE_PATH . '/app/controllers/citaController.php';
        break;

    case '/paciente/reprogramar-cita':
        require BASE_PATH . '/app/views/dashboard/paciente/reprogramar-cita.php';
        break;

    case '/paciente/actualizar-cita':
        require BASE_PATH . '/app/controllers/citaController.php';
        break;

    case '/paciente/guardar-cambios-cita':
        require BASE_PATH . '/app/controllers/citaController.php';
        break;

    case '/paciente/cancelarCita':
        require BASE_PATH . '/app/controllers/citaController.php';
        break;

    case '/paciente/perfil':
        require BASE_PATH . '/app/views/dashboard/paciente/perfil-paciente.php';
        break;

    case '/paciente/guardar-foto-perfil':
        require BASE_PATH . '/app/controllers/perfilController.php';
        break;

    case '/debug_citas.php':
        require BASE_PATH . '/debug_citas_mejorado.php';

    case '/paciente/cambiar-contrasena':
        require BASE_PATH . '/app/controllers/perfilController.php';
        break;

    case '/paciente/guardar-configuracion-usuario':
        require BASE_PATH . '/app/controllers/perfilController.php';
        break;

    case '/superadmin/tickets-usuarios':
        require BASE_PATH . '/app/views/dashboard/superadministrador/tickets-usuarios.php';
        break;

    case '/superadmin/consultar-ticket':
        require BASE_PATH . '/app/views/dashboard/superadministrador/consultar-ticket.php';
        break;

    case '/superadmin/responder-ticket':
        require BASE_PATH . '/app/views/dashboard/superadministrador/responder-ticket.php';
        break;


    case '/superadmin/guardar-respuesta-ticket':
        require BASE_PATH . '/app/controllers/ticketController.php';
        break;

    case '/admin/mis-tickets':
        require BASE_PATH . '/app/views/dashboard/administrador/mis-tickets.php';
        break;

    case '/admin/consultar-ticket':
        require BASE_PATH . '/app/views/dashboard/administrador/consultar-ticket.php';
        break;

    case '/admin/cerrar-ticket':
        require BASE_PATH . '/app/controllers/ticketController.php';
        break;

    case '/admin/crear-ticket':
        require BASE_PATH . '/app/views/dashboard/administrador/crear-ticket.php';
        break;

    case '/crear-ticket-asistente':
        require BASE_PATH . '/app/views/dashboard/asistente/crear-ticket-asistente.php';

    case '/admin/guardar-ticket':
        require BASE_PATH . '/app/controllers/ticketController.php';
        break;

    case '/admin/actualizar-ticket':
        require BASE_PATH . '/app/views/dashboard/administrador/actualizar-ticket.php';
        break;

    case '/admin/guardar-cambios-ticket':
        require BASE_PATH . '/app/controllers/ticketController.php';
        break;

    case '/asistente/crear-ticket':
        require BASE_PATH . '/app/views/dashboard/asistente/crear-ticket.php';
        break;

    case '/especialista/mis-tickets':
        require BASE_PATH . '/app/views/dashboard/especialista/mis-tickets.php';
        break;

    case '/crear-ticket-especialista':
        require BASE_PATH . '/app/views/dashboard/especialista/crear-ticket-especialista.php';
        break;

    case '/especialista/consultar-ticket':
        require BASE_PATH . '/app/views/dashboard/especialista/consultar-ticket.php';
        break;

    case '/especialista/actualizar-ticket':
        require BASE_PATH . '/app/views/dashboard/especialista/actualizar-ticket.php';
        break;

    case '/especialista/guardar-cambios-ticket':
        require BASE_PATH . '/app/controllers/ticketController.php';
        break;

    case '/especialista/cerrar-ticket':
        require BASE_PATH . '/app/controllers/ticketController.php';
        break;

    case '/asistente/mis-tickets':
        require BASE_PATH . '/app/views/dashboard/asistente/mis-tickets.php';
        break;

    case '/asistente/crear-ticket':
        require BASE_PATH . '/app/views/dashboard/asistente/crear-ticket.php';
        break;

    case '/asistente/guardar-ticket':
        require BASE_PATH . '/app/controllers/ticketController.php';
        break;

    case '/asistente/consultar-ticket':
        require BASE_PATH . '/app/views/dashboard/asistente/consultar-ticket.php';
        break;

    case '/asistente/actualizar-ticket':
        require BASE_PATH . '/app/views/dashboard/asistente/actualizar-ticket.php';
        break;

    case '/asistente/guardar-cambios-ticket':
        require BASE_PATH . '/app/controllers/ticketController.php';
        break;

    case '/asistente/cerrar-ticket':
        require BASE_PATH . '/app/controllers/ticketController.php';
        break;

    case '/paciente/mis-tickets':
        require BASE_PATH . '/app/views/dashboard/paciente/mis-tickets.php';
        break;

    case '/asistente/crear-ticket':
        require BASE_PATH . '/app/views/dashboard/asistente/crear-ticket.php';
        break;
    default:
        http_response_code(404);
        require BASE_PATH . '/app/views/auth/404.php';
        break;
}
