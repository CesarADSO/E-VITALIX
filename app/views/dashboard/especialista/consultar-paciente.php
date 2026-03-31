<?php
require_once BASE_PATH . '/app/helpers/session_especialista.php';


// // ENLAZAMOS LA DEPENDENCIA DE TIPOS DE DOCUMENTO
// require_once BASE_PATH . '/app/controllers/tipoDocumentoController.php';


// // ASIGNAMOS EL VALOR ID DEL REGISTRO SEGÚN LA TABLA
// $id = $_GET['id'];
// // LLAMAMOS LA FUNCIÓN ESPECÍFICA QUE EXISTE EN DICHO CONTROLADOR Y LE PASAMOS LOS DATOS A UNA VARIABLE
// // QUE PODAMOS MANIPULAR EN ESTE ARCHIVO
// $administrador = listarAdministradorConsultorioId($id);

// $datos = traerTipoDocumento();
?>


<?php
include_once __DIR__ . '/../../layouts/header_especialista.php';
?>

<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <?php
            include_once __DIR__ . '/../../layouts/sidebar_especialista.php';
            ?>

            <!-- Main Content -->
            <div class="col-lg-10 col-md-9 main-content">

                <!-- Top Bar -->
                <?php
                include_once __DIR__ . '/../../layouts/topbar_especialista.php';
                ?>

                <!-- Formulario de Registro de Administrador de Consultorio -->
                <div class="bg-white rounded shadow-sm p-4">
                    <h4 class="mb-4">Consultar paciente</h4>
                    <p class="text-muted mb-4 texto">En este formulario podrá consultar la información completa del paciente seleccionado</p>

                    <form id="adminConsultorioForm">
                        <div class="row">

                            <!-- Nombres -->
                            <div class="col-md-6 mb-3">
                                <label for="nombres" class="form-label">Nombres</label>
                                <input type="text" class="form-control" id="nombres" name="nombres"
                                    value="<?= $paciente['nombres'] ?>" disabled>
                            </div>

                            <!-- Apellidos -->
                            <div class="col-md-6 mb-3">
                                <label for="apellidos" class="form-label">Apellidos</label>
                                <input type="text" class="form-control" id="apellidos" name="apellidos"
                                    value="<?= $paciente['apellidos'] ?>" disabled>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="edad" class="form-label">Edad</label>
                                <input type="number" class="form-control" id="edad" name="edad"
                                    value="<?= $paciente['edad'] ?>" disabled>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="tipo_documento" class="form-label">Tipo de documento</label>
                                <input type="text" class="form-control" id="tipo_documento" name="tipo_documento"
                                    value="<?= $paciente['tipo_documento'] ?>" disabled>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="numero_documento" class="form-label">Número de documento</label>
                                <input type="text" class="form-control" id="numero_documento" name="numero_documento"
                                    value="<?= $paciente['numero_documento'] ?>" disabled>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="numero_documento" class="form-label">Número de documento</label>
                                <input type="number" class="form-control" id="numero_documento" name="numero_documento"
                                    value="<?= $paciente['numero_documento'] ?>" disabled>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="fecha_nacimiento" class="form-label">Fecha de nacimiento</label>
                                <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento"
                                    value="<?= $paciente['fecha_nacimiento'] ?>" disabled>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="genero" class="form-label">Género</label>
                                <input type="text" class="form-control" id="genero" name="genero"
                                    value="<?= $paciente['genero'] ?>" disabled>
                            </div>


                            <!-- Teléfono -->
                            <div class="col-md-6 mb-3">
                                <label for="telefono" class="form-label">Teléfono</label>
                                <input type="tel" class="form-control" id="telefono" name="telefono"
                                    value="<?= $paciente['telefono'] ?>" disabled>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="ciudad" class="form-label">Ciudad</label>
                                <input type="text" class="form-control" id="ciudad" name="ciudad"
                                    value="<?= $paciente['ciudad'] ?>" disabled>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="direccion" class="form-label">dirección</label>
                                <input type="text" class="form-control" id="direccion" name="direccion"
                                    value="<?= $paciente['direccion'] ?>" disabled>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="eps" class="form-label">Eps</label>
                                <input type="text" class="form-control" id="eps" name="eps"
                                    value="<?= $paciente['eps'] ?>" disabled>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="rh" class="form-label">RH</label>
                                <input type="text" class="form-control" id="rh" name="rh"
                                    value="<?= $paciente['rh'] ?>" disabled>
                            </div>
                        </div>

                        <!-- Botones -->
                        <div class="d-flex justify-content-between cont-botones mt-4">
                            <a href="<?= BASE_URL ?>/superadmin/administradores-consultorio" class="btn btn-outline-secondary">Cancelar</a>
                            <button type="submit" class="btn boton">Actualizar Administrador</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <?php
    include_once __DIR__ . '/../../layouts/footer_especialista.php';
    ?>