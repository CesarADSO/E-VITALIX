function showSection(section) {
    const dashboardSection = document.getElementById('dashboardSection');
    const pacientesSection = document.getElementById('pacientesSection');
    const consultoriosSection = document.getElementById('consultoriosSection');
    const profesionalesSection = document.getElementById('profesionalesSection');
    const perfilSection = document.getElementById('perfilSection');
    const navItems = document.querySelectorAll('.nav-item');

    // Verificar que los elementos existen
    if (!dashboardSection || !pacientesSection || !perfilSection) {
        console.error('Una o más secciones no se encontraron en el DOM');
        return;
    }

    // Ocultar todas las secciones
    dashboardSection.style.display = 'none';
    pacientesSection.style.display = 'none';
    if (consultoriosSection) consultoriosSection.style.display = 'none';
    if (profesionalesSection) profesionalesSection.style.display = 'none';
    perfilSection.style.display = 'none';

    // Remover clase active de todos los nav-items
    navItems.forEach(item => {
        item.classList.remove('active');
    });

    // Mostrar la sección seleccionada
    if (section === 'dashboard') {
        dashboardSection.style.display = 'block';
        if (navItems[0]) navItems[0].classList.add('active');
    } else if (section === 'pacientes') {
        pacientesSection.style.display = 'block';
        if (navItems[1]) navItems[1].classList.add('active');
    } else if (section === 'consultorios') {
        if (consultoriosSection) {
            consultoriosSection.style.display = 'block';
            if (navItems[2]) navItems[2].classList.add('active');
        }
    } else if (section === 'profesionales') {
        if (profesionalesSection) {
            profesionalesSection.style.display = 'block';
            if (navItems[3]) navItems[3].classList.add('active');
        }
    } else if (section === 'perfil') {
        perfilSection.style.display = 'block';
        if (navItems[4]) navItems[4].classList.add('active');
    }
}

// ==================== GESTIÓN DE PACIENTES ====================

// Array para almacenar pacientes
let pacientes = [
    { id: 1, nombre: "Arlene McCoy", fecha: "Septiembre 8, 2013", email: "tuxome@gmail.com" },
    { id: 2, nombre: "Arlene McCoy", fecha: "Agosto 3, 2023", email: "tuxome@gmail.com" },
    { id: 3, nombre: "Cody Fisher", fecha: "Septiembre 24, 2017", email: "tuxome@gmail.com" },
    { id: 4, nombre: "Esther Howard", fecha: "Diciembre 28, 2012", email: "tuxome@gmail.com" },
    { id: 5, nombre: "Ronald Richards", fecha: "Mayo 20, 2015", email: "tuxome@gmail.com" },
    { id: 6, nombre: "Albert Flores", fecha: "Mayo 31, 2015", email: "tuxome@gmail.com" },
    { id: 7, nombre: "Marvin McKinney", fecha: "Febrero 25, 2012", email: "tuxome@gmail.com" },
    { id: 8, nombre: "Floyd Miles", fecha: "Octubre 24, 2016", email: "tuxome@gmail.com" },
    { id: 9, nombre: "Courtney Henry", fecha: "Noviembre 7, 2017", email: "tuxome@gmail.com" },
    { id: 10, nombre: "Guy Hawkins", fecha: "Mayo 25, 2021", email: "tuxome@gmail.com" },
    { id: 11, nombre: "Ralph Edwards", fecha: "Julio 14, 2015", email: "tuxome@gmail.com" },
    { id: 12, nombre: "Devon Lane", fecha: "Diciembre 16, 2015", email: "tuxome@gmail.com" },
    { id: 13, nombre: "Jenny Wilson", fecha: "Diciembre 2, 2018", email: "tuxome@gmail.com" },
    { id: 14, nombre: "Bessie Cooper", fecha: "Marzo 6, 2018", email: "tuxome@gmail.com" },
    { id: 15, nombre: "Cameron Williamson", fecha: "Octubre 30, 2017", email: "308.555.0121" },
    { id: 16, nombre: "Darlene Robertson", fecha: "Febrero 9, 2015", email: "270.555.0118" }
];

let nextId = 17;
let editingId = null;

// Función para renderizar la tabla de pacientes
function renderPacientesTable() {
    const tbody = document.querySelector('#pacientesSection .table-pacientes tbody');
    if (!tbody) {
        console.warn('No se encontró el tbody de la tabla de pacientes');
        return;
    }

    tbody.innerHTML = '';

    pacientes.forEach(paciente => {
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td><input type="checkbox" class="form-check-input"></td>
            <td><div class="specialist-avatar"></div></td>
            <td>${paciente.nombre}</td>
            <td>${paciente.fecha}</td>
            <td>${paciente.email}</td>
            <td>
                <div class="dropdown">
                    <i class="bi bi-three-dots text-muted" style="cursor: pointer;" data-bs-toggle="dropdown"></i>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#" onclick="editarPaciente(${paciente.id}); return false;"><i class="bi bi-pencil"></i> Editar</a></li>
                        <li><a class="dropdown-item text-danger" href="#" onclick="eliminarPaciente(${paciente.id}); return false;"><i class="bi bi-trash"></i> Eliminar</a></li>
                    </ul>
                </div>
            </td>
        `;
        tbody.appendChild(tr);
    });

    // Actualizar contador
    const btnLink = document.querySelector('#pacientesSection .btn-link');
    if (btnLink) {
        btnLink.textContent = `← Todos (${pacientes.length})`;
    }
}

// Función para mostrar modal de agregar/editar paciente
function mostrarModalPaciente(id = null) {
    editingId = id;
    const paciente = id ? pacientes.find(p => p.id === id) : null;

    const modalHTML = `
        <div class="modal fade" id="pacienteModal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content" style="border-radius: 15px;">
                    <div class="modal-header border-0">
                        <h5 class="modal-title" style="font-weight: 600;">${id ? 'Editar' : 'Agregar'} Paciente</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body p-4">
                        <form id="pacienteForm">
                            <div class="mb-3">
                                <label class="form-label" style="font-size: 13px; color: var(--gris-proyecto);">Nombre Completo</label>
                                <input type="text" class="form-control campos-formulario" id="nombrePaciente" value="${paciente ? paciente.nombre : ''}" placeholder="Nombre completo del paciente" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" style="font-size: 13px; color: var(--gris-proyecto);">Fecha de Nacimiento</label>
                                <input type="text" class="form-control campos-formulario" id="fechaPaciente" value="${paciente ? paciente.fecha : ''}" placeholder="Mes día, año" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" style="font-size: 13px; color: var(--gris-proyecto);">Email / Teléfono</label>
                                <input type="text" class="form-control campos-formulario" id="emailPaciente" value="${paciente ? paciente.email : ''}" placeholder="correo@ejemplo.com" required>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="border-radius: 20px;">Cancelar</button>
                        <button type="button" class="btn btn-primary" onclick="guardarPaciente()" style="border-radius: 20px;">${id ? 'Actualizar' : 'Agregar'}</button>
                    </div>
                </div>
            </div>
        </div>
    `;

    const oldModal = document.getElementById('pacienteModal');
    if (oldModal) oldModal.remove();

    document.body.insertAdjacentHTML('beforeend', modalHTML);

    const modal = new bootstrap.Modal(document.getElementById('pacienteModal'));
    modal.show();
}

// Función para guardar paciente
function guardarPaciente() {
    const nombreInput = document.getElementById('nombrePaciente');
    const fechaInput = document.getElementById('fechaPaciente');
    const emailInput = document.getElementById('emailPaciente');

    if (!nombreInput || !fechaInput || !emailInput) {
        alert('Error al acceder a los campos del formulario');
        return;
    }

    const nombre = nombreInput.value.trim();
    const fecha = fechaInput.value.trim();
    const email = emailInput.value.trim();

    if (!nombre || !fecha || !email) {
        alert('Por favor complete todos los campos');
        return;
    }

    if (editingId) {
        const index = pacientes.findIndex(p => p.id === editingId);
        pacientes[index] = { id: editingId, nombre, fecha, email };
    } else {
        pacientes.push({ id: nextId++, nombre, fecha, email });
    }

    renderPacientesTable();

    const modalElement = document.getElementById('pacienteModal');
    if (modalElement) {
        const modal = bootstrap.Modal.getInstance(modalElement);
        if (modal) modal.hide();
    }

    editingId = null;
}

// Función para editar paciente
function editarPaciente(id) {
    mostrarModalPaciente(id);
}

// Función para eliminar paciente
function eliminarPaciente(id) {
    if (confirm('¿Está seguro de que desea eliminar este paciente?')) {
        pacientes = pacientes.filter(p => p.id !== id);
        renderPacientesTable();
    }
}

// ==================== GESTIÓN DE CONSULTORIOS ====================

let consultorios = [
    { id: 1, nombre: "Consultorio Central", direccion: "Av. Principal 123", telefono: "+51 987 654 321", ciudad: "Lima" },
    { id: 2, nombre: "Clínica San José", direccion: "Calle Los Pinos 456", telefono: "+51 912 345 678", ciudad: "Arequipa" },
    { id: 3, nombre: "Centro Médico Norte", direccion: "Jr. Las Flores 789", telefono: "+51 998 765 432", ciudad: "Trujillo" }
];

let nextConsultorioId = 4;
let editingConsultorioId = null;

function renderConsultoriosTable() {
    const tbody = document.querySelector('#consultoriosSection .table-pacientes tbody');
    if (!tbody) {
        console.warn('No se encontró el tbody de la tabla de consultorios');
        return;
    }

    tbody.innerHTML = '';

    consultorios.forEach(consultorio => {
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td><input type="checkbox" class="form-check-input"></td>
            <td>${consultorio.nombre}</td>
            <td>${consultorio.direccion}</td>
            <td>${consultorio.telefono}</td>
            <td>${consultorio.ciudad}</td>
            <td>
                <div class="dropdown">
                    <i class="bi bi-three-dots text-muted" style="cursor: pointer;" data-bs-toggle="dropdown"></i>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#" onclick="editarConsultorio(${consultorio.id}); return false;"><i class="bi bi-pencil"></i> Editar</a></li>
                        <li><a class="dropdown-item text-danger" href="#" onclick="eliminarConsultorio(${consultorio.id}); return false;"><i class="bi bi-trash"></i> Eliminar</a></li>
                    </ul>
                </div>
            </td>
        `;
        tbody.appendChild(tr);
    });

    const btnLink = document.querySelector('#consultoriosSection .btn-link');
    if (btnLink) {
        btnLink.textContent = `← Todos (${consultorios.length})`;
    }
}

function mostrarModalConsultorio(id = null) {
    editingConsultorioId = id;
    const consultorio = id ? consultorios.find(c => c.id === id) : null;

    const modalHTML = `
        <div class="modal fade" id="consultorioModal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content" style="border-radius: 15px;">
                    <div class="modal-header border-0">
                        <h5 class="modal-title" style="font-weight: 600;">${id ? 'Editar' : 'Agregar'} Consultorio</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body p-4">
                        <form id="consultorioForm">
                            <div class="mb-3">
                                <label class="form-label" style="font-size: 13px; color: var(--gris-proyecto);">Nombre del Consultorio</label>
                                <input type="text" class="form-control campos-formulario" id="nombreConsultorio" value="${consultorio ? consultorio.nombre : ''}" placeholder="Nombre del consultorio" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" style="font-size: 13px; color: var(--gris-proyecto);">Dirección</label>
                                <input type="text" class="form-control campos-formulario" id="direccionConsultorio" value="${consultorio ? consultorio.direccion : ''}" placeholder="Dirección completa" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" style="font-size: 13px; color: var(--gris-proyecto);">Teléfono</label>
                                <input type="text" class="form-control campos-formulario" id="telefonoConsultorio" value="${consultorio ? consultorio.telefono : ''}" placeholder="+51 999 999 999" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" style="font-size: 13px; color: var(--gris-proyecto);">Ciudad</label>
                                <input type="text" class="form-control campos-formulario" id="ciudadConsultorio" value="${consultorio ? consultorio.ciudad : ''}" placeholder="Ciudad" required>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="border-radius: 20px;">Cancelar</button>
                        <button type="button" class="btn btn-primary" onclick="guardarConsultorio()" style="border-radius: 20px;">${id ? 'Actualizar' : 'Agregar'}</button>
                    </div>
                </div>
            </div>
        </div>
    `;

    const oldModal = document.getElementById('consultorioModal');
    if (oldModal) oldModal.remove();

    document.body.insertAdjacentHTML('beforeend', modalHTML);

    const modal = new bootstrap.Modal(document.getElementById('consultorioModal'));
    modal.show();
}

function guardarConsultorio() {
    const nombreInput = document.getElementById('nombreConsultorio');
    const direccionInput = document.getElementById('direccionConsultorio');
    const telefonoInput = document.getElementById('telefonoConsultorio');
    const ciudadInput = document.getElementById('ciudadConsultorio');

    if (!nombreInput || !direccionInput || !telefonoInput || !ciudadInput) {
        alert('Error al acceder a los campos del formulario');
        return;
    }

    const nombre = nombreInput.value.trim();
    const direccion = direccionInput.value.trim();
    const telefono = telefonoInput.value.trim();
    const ciudad = ciudadInput.value.trim();

    if (!nombre || !direccion || !telefono || !ciudad) {
        alert('Por favor complete todos los campos');
        return;
    }

    if (editingConsultorioId) {
        const index = consultorios.findIndex(c => c.id === editingConsultorioId);
        consultorios[index] = { id: editingConsultorioId, nombre, direccion, telefono, ciudad };
    } else {
        consultorios.push({ id: nextConsultorioId++, nombre, direccion, telefono, ciudad });
    }

    renderConsultoriosTable();

    const modalElement = document.getElementById('consultorioModal');
    if (modalElement) {
        const modal = bootstrap.Modal.getInstance(modalElement);
        if (modal) modal.hide();
    }

    editingConsultorioId = null;
}

function editarConsultorio(id) {
    mostrarModalConsultorio(id);
}

function eliminarConsultorio(id) {
    if (confirm('¿Está seguro de que desea eliminar este consultorio?')) {
        consultorios = consultorios.filter(c => c.id !== id);
        renderConsultoriosTable();
    }
}

// ==================== GESTIÓN DE PROFESIONALES ====================


function renderProfesionalesTable() {
    const tbody = document.querySelector('#profesionalesSection .table-pacientes tbody');
    if (!tbody) {
        console.warn('No se encontró el tbody de la tabla de profesionales');
        return;
    }

    tbody.innerHTML = '';

    profesionales.forEach(profesional => {
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td><input type="checkbox" class="form-check-input"></td>
            <td><div class="specialist-avatar"></div></td>
            <td>${profesional.nombre}</td>
            <td>${profesional.edad}</td>
            <td>${profesional.email}</td>
            <td>${profesional.especialidad}</td>
            <td>${profesional.consultorio}</td>
            <td>
                <div class="dropdown">
                    <i class="bi bi-three-dots text-muted" style="cursor: pointer;" data-bs-toggle="dropdown"></i>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#" onclick="editarProfesional(${profesional.id}); return false;"><i class="bi bi-pencil"></i> Editar</a></li>
                        <li><a class="dropdown-item text-danger" href="#" onclick="eliminarProfesional(${profesional.id}); return false;"><i class="bi bi-trash"></i> Eliminar</a></li>
                    </ul>
                </div>
            </td>
        `;
        tbody.appendChild(tr);
    });

    const btnLink = document.querySelector('#profesionalesSection .btn-link');
    if (btnLink) {
        btnLink.textContent = `← Todos (${profesionales.length})`;
    }
}

function mostrarModalProfesional(id = null) {
    editingProfesionalId = id;
    const profesional = id ? profesionales.find(p => p.id === id) : null;

    const consultoriosOptions = consultorios.map(c =>
        `<option value="${c.nombre}" ${profesional && profesional.consultorio === c.nombre ? 'selected' : ''}>${c.nombre}</option>`
    ).join('');

    const modalHTML = `
        <div class="modal fade" id="profesionalModal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content" style="border-radius: 15px;">
                    <div class="modal-header border-0">
                        <h5 class="modal-title" style="font-weight: 600;">${id ? 'Editar' : 'Agregar'} Profesional</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body p-4">
                        <form id="profesionalForm">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label" style="font-size: 13px; color: var(--gris-proyecto);">Nombre Completo</label>
                                    <input type="text" class="form-control campos-formulario" id="nombreProfesional" value="${profesional ? profesional.nombre : ''}" placeholder="Dr. Nombre Apellido" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" style="font-size: 13px; color: var(--gris-proyecto);">Edad</label>
                                    <input type="number" class="form-control campos-formulario" id="edadProfesional" value="${profesional ? profesional.edad : ''}" placeholder="Edad" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label" style="font-size: 13px; color: var(--gris-proyecto);">Email</label>
                                    <input type="email" class="form-control campos-formulario" id="emailProfesional" value="${profesional ? profesional.email : ''}" placeholder="correo@ejemplo.com" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" style="font-size: 13px; color: var(--gris-proyecto);">Especialidad</label>
                                    <input type="text" class="form-control campos-formulario" id="especialidadProfesional" value="${profesional ? profesional.especialidad : ''}" placeholder="Especialidad médica" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" style="font-size: 13px; color: var(--gris-proyecto);">Consultorio</label>
                                <select class="form-control campos-formulario" id="consultorioProfesional" required>
                                    <option value="">Seleccione un consultorio</option>
                                    ${consultoriosOptions}
                                </select>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="border-radius: 20px;">Cancelar</button>
                        <button type="button" class="btn btn-primary" onclick="guardarProfesional()" style="border-radius: 20px;">${id ? 'Actualizar' : 'Agregar'}</button>
                    </div>
                </div>
            </div>
        </div>
    `;

    const oldModal = document.getElementById('profesionalModal');
    if (oldModal) oldModal.remove();

    document.body.insertAdjacentHTML('beforeend', modalHTML);

    const modal = new bootstrap.Modal(document.getElementById('profesionalModal'));
    modal.show();
}

function guardarProfesional() {
    const nombreInput = document.getElementById('nombreProfesional');
    const edadInput = document.getElementById('edadProfesional');
    const emailInput = document.getElementById('emailProfesional');
    const especialidadInput = document.getElementById('especialidadProfesional');
    const consultorioInput = document.getElementById('consultorioProfesional');

    if (!nombreInput || !edadInput || !emailInput || !especialidadInput || !consultorioInput) {
        alert('Error al acceder a los campos del formulario');
        return;
    }

    const nombre = nombreInput.value.trim();
    const edad = parseInt(edadInput.value);
    const email = emailInput.value.trim();
    const especialidad = especialidadInput.value.trim();
    const consultorio = consultorioInput.value;

    if (!nombre || !edad || !email || !especialidad || !consultorio) {
        alert('Por favor complete todos los campos');
        return;
    }

    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
        alert('Por favor ingrese un email válido');
        return;
    }

    if (editingProfesionalId) {
        const index = profesionales.findIndex(p => p.id === editingProfesionalId);
        profesionales[index] = { id: editingProfesionalId, nombre, edad, email, especialidad, consultorio };
    } else {
        profesionales.push({ id: nextProfesionalId++, nombre, edad, email, especialidad, consultorio });
    }

    renderProfesionalesTable();

    const modalElement = document.getElementById('profesionalModal');
    if (modalElement) {
        const modal = bootstrap.Modal.getInstance(modalElement);
        if (modal) modal.hide();
    }

    editingProfesionalId = null;
}

function editarProfesional(id) {
    mostrarModalProfesional(id);
}

function eliminarProfesional(id) {
    if (confirm('¿Está seguro de que desea eliminar este profesional?')) {
        profesionales = profesionales.filter(p => p.id !== id);
        renderProfesionalesTable();
    }
}

// ==================== GESTIÓN DE PERFIL ====================

function guardarCambiosPerfil() {
    const nombresInput = document.getElementById('nombresInput');
    const apellidosInput = document.getElementById('apellidosInput');
    const emailInput = document.getElementById('emailInput');
    const telefonoInput = document.getElementById('telefonoInput');

    if (!nombresInput || !apellidosInput || !emailInput || !telefonoInput) {
        alert('Error al acceder a los campos del formulario');
        return;
    }

    const nombres = nombresInput.value.trim();
    const apellidos = apellidosInput.value.trim();
    const email = emailInput.value.trim();
    const telefono = telefonoInput.value.trim();

    if (!nombres || !apellidos || !email || !telefono) {
        alert('Por favor complete todos los campos');
        return;
    }

    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
        alert('Por favor ingrese un email válido');
        return;
    }

    alert('Cambios guardados exitosamente');

    const nombreUsuario = document.querySelector('#perfilSection .text-center h6');
    const emailUsuario = document.querySelector('#perfilSection .text-center p');

    if (nombreUsuario) nombreUsuario.textContent = `@${nombres}`;
    if (emailUsuario) emailUsuario.textContent = email;
}

function guardarCambiosContrasena() {
    const actualInput = document.getElementById('contrasenaActual');
    const nuevaInput = document.getElementById('nuevaContrasena');
    const confirmarInput = document.getElementById('confirmarContrasena');

    if (!actualInput || !nuevaInput || !confirmarInput) {
        alert('Error al acceder a los campos del formulario');
        return;
    }

    const actual = actualInput.value.trim();
    const nueva = nuevaInput.value.trim();
    const confirmar = confirmarInput.value.trim();

    if (!actual || !nueva || !confirmar) {
        alert('Por favor complete todos los campos');
        return;
    }

    if (nueva !== confirmar) {
        alert('Las contraseñas no coinciden');
        return;
    }

    if (nueva.length < 6) {
        alert('La contraseña debe tener al menos 6 caracteres');
        return;
    }

    alert('Contraseña cambiada exitosamente');

    actualInput.value = '';
    nuevaInput.value = '';
    confirmarInput.value = '';
}
// ==================== INICIALIZACIÓN DE GRÁFICOS ====================

function initCharts() {
    // Gráfico de barras mensual
    const ctxMonthly = document.getElementById('monthlyChart');
    if (ctxMonthly) {
        new Chart(ctxMonthly.getContext('2d'), {
            type: 'bar',
            data: {
                labels: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
                datasets: [{
                    label: 'Nuevos',
                    data: [45, 60, 75, 55, 40, 50, 65, 72, 60, 50, 45, 70],
                    backgroundColor: '#007bff',
                    borderRadius: 4,
                    barThickness: 20
                }, {
                    label: 'Recurrentes',
                    data: [55, 65, 70, 60, 50, 58, 60, 75, 63, 48, 42, 72],
                    backgroundColor: '#90CAF9',
                    borderRadius: 4,
                    barThickness: 20
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            display: true,
                            color: '#f0f0f0'
                        },
                        ticks: {
                            stepSize: 20
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
    }

    // Gráfico de dona
    const ctxDonut = document.getElementById('donutChart');
    if (ctxDonut) {
        new Chart(ctxDonut.getContext('2d'), {
            type: 'doughnut',
            data: {
                labels: ['Exitosas', 'Canceladas'],
                datasets: [{
                    data: [65, 35],
                    backgroundColor: ['#007bff', '#90CAF9'],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                cutout: '70%',
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        enabled: true
                    }
                }
            }
        });
    }
}
// ==================== GESTIÓN DE CONSULTORIOS ====================

// Función para renderizar la tabla de consultorios
function renderConsultoriosTable() {
    const tbody = document.querySelector('#consultoriosSection .table-pacientes tbody');
    if (!tbody) {
        console.warn('No se encontró el tbody de la tabla de consultorios');
        return;
    }

    tbody.innerHTML = '';

    consultorios.forEach(consultorio => {
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td><input type="checkbox" class="form-check-input"></td>
            <td>${consultorio.nombre}</td>
            <td>${consultorio.direccion}</td>
            <td>${consultorio.telefono}</td>
            <td>${consultorio.ciudad}</td>
            <td>
                <div class="dropdown">
                    <i class="bi bi-three-dots text-muted" style="cursor: pointer;" data-bs-toggle="dropdown"></i>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#" onclick="editarConsultorio(${consultorio.id}); return false;"><i class="bi bi-pencil"></i> Editar</a></li>
                        <li><a class="dropdown-item text-danger" href="#" onclick="eliminarConsultorio(${consultorio.id}); return false;"><i class="bi bi-trash"></i> Eliminar</a></li>
                    </ul>
                </div>
            </td>
        `;
        tbody.appendChild(tr);
    });

    // Actualizar contador
    const btnLink = document.querySelector('#consultoriosSection .btn-link');
    if (btnLink) {
        btnLink.textContent = `← Todos (${consultorios.length})`;
    }
}

// Función para mostrar modal de agregar/editar consultorio
function mostrarModalConsultorio(id = null) {
    editingConsultorioId = id;
    const consultorio = id ? consultorios.find(c => c.id === id) : null;

    const modalHTML = `
        <div class="modal fade" id="consultorioModal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content" style="border-radius: 15px;">
                    <div class="modal-header border-0">
                        <h5 class="modal-title" style="font-weight: 600;">${id ? 'Editar' : 'Agregar'} Consultorio</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body p-4">
                        <form id="consultorioForm">
                            <div class="mb-3">
                                <label class="form-label" style="font-size: 13px; color: var(--gris-proyecto);">Nombre del Consultorio</label>
                                <input type="text" class="form-control campos-formulario" id="nombreConsultorio" value="${consultorio ? consultorio.nombre : ''}" placeholder="Nombre del consultorio" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" style="font-size: 13px; color: var(--gris-proyecto);">Dirección</label>
                                <input type="text" class="form-control campos-formulario" id="direccionConsultorio" value="${consultorio ? consultorio.direccion : ''}" placeholder="Dirección completa" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" style="font-size: 13px; color: var(--gris-proyecto);">Teléfono</label>
                                <input type="text" class="form-control campos-formulario" id="telefonoConsultorio" value="${consultorio ? consultorio.telefono : ''}" placeholder="+51 999 999 999" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" style="font-size: 13px; color: var(--gris-proyecto);">Ciudad</label>
                                <input type="text" class="form-control campos-formulario" id="ciudadConsultorio" value="${consultorio ? consultorio.ciudad : ''}" placeholder="Ciudad" required>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="border-radius: 20px;">Cancelar</button>
                        <button type="button" class="btn btn-primary" onclick="guardarConsultorio()" style="border-radius: 20px;">${id ? 'Actualizar' : 'Agregar'}</button>
                    </div>
                </div>
            </div>
        </div>
    `;

    const oldModal = document.getElementById('consultorioModal');
    if (oldModal) oldModal.remove();

    document.body.insertAdjacentHTML('beforeend', modalHTML);

    const modal = new bootstrap.Modal(document.getElementById('consultorioModal'));
    modal.show();
}

// Función para guardar consultorio
function guardarConsultorio() {
    const nombreInput = document.getElementById('nombreConsultorio');
    const direccionInput = document.getElementById('direccionConsultorio');
    const telefonoInput = document.getElementById('telefonoConsultorio');
    const ciudadInput = document.getElementById('ciudadConsultorio');

    if (!nombreInput || !direccionInput || !telefonoInput || !ciudadInput) {
        alert('Error al acceder a los campos del formulario');
        return;
    }

    const nombre = nombreInput.value.trim();
    const direccion = direccionInput.value.trim();
    const telefono = telefonoInput.value.trim();
    const ciudad = ciudadInput.value.trim();

    if (!nombre || !direccion || !telefono || !ciudad) {
        alert('Por favor complete todos los campos');
        return;
    }

    if (editingConsultorioId) {
        const index = consultorios.findIndex(c => c.id === editingConsultorioId);
        consultorios[index] = { id: editingConsultorioId, nombre, direccion, telefono, ciudad };
    } else {
        consultorios.push({ id: nextConsultorioId++, nombre, direccion, telefono, ciudad });
    }

    renderConsultoriosTable();

    const modalElement = document.getElementById('consultorioModal');
    if (modalElement) {
        const modal = bootstrap.Modal.getInstance(modalElement);
        if (modal) modal.hide();
    }

    editingConsultorioId = null;
}

// Función para editar consultorio
function editarConsultorio(id) {
    mostrarModalConsultorio(id);
}

// Función para eliminar consultorio
function eliminarConsultorio(id) {
    if (confirm('¿Está seguro de que desea eliminar este consultorio?')) {
        consultorios = consultorios.filter(c => c.id !== id);
        renderConsultoriosTable();
    }
}

// ==================== GESTIÓN DE PROFESIONALES ====================

// Array para almacenar profesionales
let profesionales = [
    { id: 1, nombre: "Dr. Juan Pérez", edad: 45, email: "juan.perez@mail.com", especialidad: "Cardiólogo", consultorio: "Consultorio Central" },
    { id: 2, nombre: "Dr. Nicolas Pinzon", edad: 38, email: "nicolas.pinzon@mail.com", especialidad: "Dermatólogo", consultorio: "Clínica San José" },
    { id: 3, nombre: "Dr. Carlos Rodríguez", edad: 52, email: "carlos.rodriguez@mail.com", especialidad: "Médico General", consultorio: "Centro Médico Norte" }
];

let nextProfesionalId = 4;
let editingProfesionalId = null;

// Función para renderizar la tabla de profesionales
function renderProfesionalesTable() {
    const tbody = document.querySelector('#profesionalesSection .table-pacientes tbody');
    if (!tbody) {
        console.warn('No se encontró el tbody de la tabla de profesionales');
        return;
    }

    tbody.innerHTML = '';

    profesionales.forEach(profesional => {
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td><input type="checkbox" class="form-check-input"></td>
            <td><div class="specialist-avatar"></div></td>
            <td>${profesional.nombre}</td>
            <td>${profesional.edad}</td>
            <td>${profesional.email}</td>
            <td>${profesional.especialidad}</td>
            <td>${profesional.consultorio}</td>
            <td>
                <div class="dropdown">
                    <i class="bi bi-three-dots text-muted" style="cursor: pointer;" data-bs-toggle="dropdown"></i>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#" onclick="editarProfesional(${profesional.id}); return false;"><i class="bi bi-pencil"></i> Editar</a></li>
                        <li><a class="dropdown-item text-danger" href="#" onclick="eliminarProfesional(${profesional.id}); return false;"><i class="bi bi-trash"></i> Eliminar</a></li>
                    </ul>
                </div>
            </td>
        `;
        tbody.appendChild(tr);
    });

    // Actualizar contador
    const btnLink = document.querySelector('#profesionalesSection .btn-link');
    if (btnLink) {
        btnLink.textContent = `← Todos (${profesionales.length})`;
    }
}

// Función para mostrar modal de agregar/editar profesional
function mostrarModalProfesional(id = null) {
    editingProfesionalId = id;
    const profesional = id ? profesionales.find(p => p.id === id) : null;

    // Obtener lista de consultorios para el select
    const consultoriosOptions = consultorios.map(c =>
        `<option value="${c.nombre}" ${profesional && profesional.consultorio === c.nombre ? 'selected' : ''}>${c.nombre}</option>`
    ).join('');

    const modalHTML = `
        <div class="modal fade" id="profesionalModal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content" style="border-radius: 15px;">
                    <div class="modal-header border-0">
                        <h5 class="modal-title" style="font-weight: 600;">${id ? 'Editar' : 'Agregar'} Profesional</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body p-4">
                        <form id="profesionalForm">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label" style="font-size: 13px; color: var(--gris-proyecto);">Nombre Completo</label>
                                    <input type="text" class="form-control campos-formulario" id="nombreProfesional" value="${profesional ? profesional.nombre : ''}" placeholder="Dr. Nombre Apellido" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" style="font-size: 13px; color: var(--gris-proyecto);">Edad</label>
                                    <input type="number" class="form-control campos-formulario" id="edadProfesional" value="${profesional ? profesional.edad : ''}" placeholder="Edad" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label" style="font-size: 13px; color: var(--gris-proyecto);">Email</label>
                                    <input type="email" class="form-control campos-formulario" id="emailProfesional" value="${profesional ? profesional.email : ''}" placeholder="correo@ejemplo.com" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" style="font-size: 13px; color: var(--gris-proyecto);">Especialidad</label>
                                    <input type="text" class="form-control campos-formulario" id="especialidadProfesional" value="${profesional ? profesional.especialidad : ''}" placeholder="Especialidad médica" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" style="font-size: 13px; color: var(--gris-proyecto);">Consultorio</label>
                                <select class="form-control campos-formulario" id="consultorioProfesional" required>
                                    <option value="">Seleccione un consultorio</option>
                                    ${consultoriosOptions}
                                </select>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="border-radius: 20px;">Cancelar</button>
                        <button type="button" class="btn btn-primary" onclick="guardarProfesional()" style="border-radius: 20px;">${id ? 'Actualizar' : 'Agregar'}</button>
                    </div>
                </div>
            </div>
        </div>
    `;

    const oldModal = document.getElementById('profesionalModal');
    if (oldModal) oldModal.remove();

    document.body.insertAdjacentHTML('beforeend', modalHTML);

    const modal = new bootstrap.Modal(document.getElementById('profesionalModal'));
    modal.show();
}

// Función para guardar profesional
function guardarProfesional() {
    const nombreInput = document.getElementById('nombreProfesional');
    const edadInput = document.getElementById('edadProfesional');
    const emailInput = document.getElementById('emailProfesional');
    const especialidadInput = document.getElementById('especialidadProfesional');
    const consultorioInput = document.getElementById('consultorioProfesional');

    if (!nombreInput || !edadInput || !emailInput || !especialidadInput || !consultorioInput) {
        alert('Error al acceder a los campos del formulario');
        return;
    }

    const nombre = nombreInput.value.trim();
    const edad = parseInt(edadInput.value);
    const email = emailInput.value.trim();
    const especialidad = especialidadInput.value.trim();
    const consultorio = consultorioInput.value;

    if (!nombre || !edad || !email || !especialidad || !consultorio) {
        alert('Por favor complete todos los campos');
        return;
    }

    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
        alert('Por favor ingrese un email válido');
        return;
    }

    if (editingProfesionalId) {
        const index = profesionales.findIndex(p => p.id === editingProfesionalId);
        profesionales[index] = { id: editingProfesionalId, nombre, edad, email, especialidad, consultorio };
    } else {
        profesionales.push({ id: nextProfesionalId++, nombre, edad, email, especialidad, consultorio });
    }

    renderProfesionalesTable();

    const modalElement = document.getElementById('profesionalModal');
    if (modalElement) {
        const modal = bootstrap.Modal.getInstance(modalElement);
        if (modal) modal.hide();
    }

    editingProfesionalId = null;
}

// Función para editar profesional
function editarProfesional(id) {
    mostrarModalProfesional(id);
}

// Función para eliminar profesional
function eliminarProfesional(id) {
    if (confirm('¿Está seguro de que desea eliminar este profesional?')) {
        profesionales = profesionales.filter(p => p.id !== id);
        renderProfesionalesTable();
    }
}

// ==================== INICIALIZACIÓN AL CARGAR LA PÁGINA ====================
document.addEventListener('DOMContentLoaded', function () {
    // Mostrar dashboard por defecto
    showSection('dashboard');

    // Inicializar gráficos
    initCharts();

    // Renderizar todas las tablas
    renderPacientesTable();
    renderConsultoriosTable();
    renderProfesionalesTable();

    // Event listeners para botones AÑADIR - usando delegación de eventos
    document.body.addEventListener('click', function (e) {
        // Botón añadir paciente
        if (e.target.closest('#pacientesSection .btn-primary')) {
            e.preventDefault();
            mostrarModalPaciente();
        }

        // Botón añadir consultorio
        if (e.target.closest('#consultoriosSection .btn-primary')) {
            e.preventDefault();
            mostrarModalConsultorio();
        }

        // Botón añadir profesional
        if (e.target.closest('#profesionalesSection .btn-primary')) {
            e.preventDefault();
            mostrarModalProfesional();
        }
    });
});