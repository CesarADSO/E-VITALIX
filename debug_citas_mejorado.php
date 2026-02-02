<?php
/**
 * DEBUG MEJORADO - MIS CITAS ESPECIALISTA
 * 
 * INSTRUCCIONES:
 * 1. Guardar en: E-VITALIX/debug_citas.php
 * 2. Estar logueado como ESPECIALISTA
 * 3. Visitar: http://localhost/E-VITALIX/debug_citas.php
 * 4. Copiar TODA la salida y enviársela a quien te está ayudando
 */

session_start();
require_once __DIR__ . '/config/config.php';

echo "<!DOCTYPE html>";
echo "<html><head>";
echo "<title>Debug Citas</title>";
echo "<style>
body { font-family: Arial; padding: 20px; background: #f5f5f5; }
.section { background: white; padding: 20px; margin: 20px 0; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
.success { color: green; font-weight: bold; }
.error { color: red; font-weight: bold; }
.warning { color: orange; font-weight: bold; }
pre { background: #f8f8f8; padding: 10px; border-radius: 4px; overflow-x: auto; }
h1 { color: #333; }
h2 { color: #0066cc; border-bottom: 2px solid #0066cc; padding-bottom: 5px; }
</style>";
echo "</head><body>";

echo "<h1>🔍 DEBUG - Módulo Mis Citas del Especialista</h1>";

// ========================================
// 1. VERIFICAR SESIÓN
// ========================================
echo "<div class='section'>";
echo "<h2>1️⃣ Verificación de Sesión</h2>";

if (!isset($_SESSION['user'])) {
    echo "<p class='error'>❌ ERROR: No hay sesión activa</p>";
    echo "<p><a href='/E-VITALIX/login'>Ir al Login</a></p>";
    echo "</div></body></html>";
    exit();
}

echo "<p class='success'>✅ Sesión activa</p>";
echo "<pre>";
print_r($_SESSION['user']);
echo "</pre>";

if ($_SESSION['user']['rol'] != 3) {
    echo "<p class='error'>❌ ERROR: No eres especialista (rol = {$_SESSION['user']['rol']})</p>";
    echo "<p>Debes iniciar sesión como especialista</p>";
    echo "</div></body></html>";
    exit();
}

if (!isset($_SESSION['user']['id_especialista'])) {
    echo "<p class='error'>❌ ERROR CRÍTICO: No existe 'id_especialista' en la sesión</p>";
    echo "<p class='warning'>⚠️ PROBLEMA: El LoginController no está guardando el id_especialista</p>";
    echo "<p><strong>SOLUCIÓN:</strong> Revisar LoginController.php línea donde se guarda la sesión</p>";
    echo "</div></body></html>";
    exit();
}

$id_especialista = $_SESSION['user']['id_especialista'];
echo "<p class='success'>✅ ID Especialista en sesión: <strong>$id_especialista</strong></p>";
echo "</div>";

// ========================================
// 2. VERIFICAR CONEXIÓN A BD
// ========================================
echo "<div class='section'>";
echo "<h2>2️⃣ Verificación de Conexión a BD</h2>";

try {
    require_once BASE_PATH . '/config/database.php';
    $db = new Conexion();
    $conn = $db->getConexion();
    echo "<p class='success'>✅ Conexión a BD exitosa</p>";
} catch (Exception $e) {
    echo "<p class='error'>❌ ERROR de conexión: " . $e->getMessage() . "</p>";
    echo "</div></body></html>";
    exit();
}
echo "</div>";

// ========================================
// 3. VERIFICAR TABLA CITAS
// ========================================
echo "<div class='section'>";
echo "<h2>3️⃣ Verificación de Tabla 'citas'</h2>";

try {
    $query = "DESCRIBE citas";
    $stmt = $conn->query($query);
    $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "<p class='success'>✅ Tabla 'citas' existe</p>";
    echo "<h3>Columnas de la tabla:</h3>";
    echo "<pre>";
    print_r($columns);
    echo "</pre>";
    
    // Verificar ENUM
    $enumQuery = "SHOW COLUMNS FROM citas LIKE 'estado_cita'";
    $enumStmt = $conn->query($enumQuery);
    $enumInfo = $enumStmt->fetch(PDO::FETCH_ASSOC);
    echo "<h3>Valores permitidos en 'estado_cita':</h3>";
    echo "<pre>";
    print_r($enumInfo);
    echo "</pre>";
    
} catch (Exception $e) {
    echo "<p class='error'>❌ ERROR: " . $e->getMessage() . "</p>";
}
echo "</div>";

// ========================================
// 4. BUSCAR CITAS EN BD (CONSULTA DIRECTA)
// ========================================
echo "<div class='section'>";
echo "<h2>4️⃣ Buscar Citas Directamente en BD</h2>";

try {
    // Consulta 1: Todas las citas del especialista
    $query1 = "
        SELECT 
            c.id,
            c.id_agenda_slot,
            c.id_paciente,
            c.estado_cita,
            c.motivo_consulta,
            c.created_at
        FROM citas c
        INNER JOIN agenda_slot s ON c.id_agenda_slot = s.id
        WHERE s.id_especialista = :id_esp
        ORDER BY c.created_at DESC
    ";
    
    $stmt1 = $conn->prepare($query1);
    $stmt1->bindParam(':id_esp', $id_especialista, PDO::PARAM_INT);
    $stmt1->execute();
    $citasDirectas = $stmt1->fetchAll(PDO::FETCH_ASSOC);
    
    echo "<p><strong>Total de citas encontradas para especialista $id_especialista:</strong> " . count($citasDirectas) . "</p>";
    
    if (empty($citasDirectas)) {
        echo "<p class='warning'>⚠️ NO HAY CITAS en la BD para este especialista</p>";
        
        // Verificar si hay slots
        echo "<h3>Verificando slots del especialista...</h3>";
        $querySlots = "SELECT COUNT(*) as total FROM agenda_slot WHERE id_especialista = :id_esp";
        $stmtSlots = $conn->prepare($querySlots);
        $stmtSlots->bindParam(':id_esp', $id_especialista);
        $stmtSlots->execute();
        $totalSlots = $stmtSlots->fetch()['total'];
        echo "<p>Slots creados por el especialista: <strong>$totalSlots</strong></p>";
        
        if ($totalSlots == 0) {
            echo "<p class='error'>❌ NO HAY SLOTS. El especialista debe crear disponibilidad primero.</p>";
        }
        
        // Verificar si hay citas SIN relación correcta
        echo "<h3>Verificando todas las citas en la BD (sin filtro)...</h3>";
        $queryAllCitas = "SELECT COUNT(*) as total FROM citas";
        $stmtAll = $conn->query($queryAllCitas);
        $totalCitas = $stmtAll->fetch()['total'];
        echo "<p>Total de citas en toda la BD: <strong>$totalCitas</strong></p>";
        
        if ($totalCitas > 0) {
            echo "<h3>Últimas 5 citas creadas (todas):</h3>";
            $queryLast = "
                SELECT 
                    c.id,
                    c.id_agenda_slot,
                    c.id_paciente,
                    c.estado_cita,
                    s.id_especialista,
                    c.created_at
                FROM citas c
                LEFT JOIN agenda_slot s ON c.id_agenda_slot = s.id
                ORDER BY c.created_at DESC
                LIMIT 5
            ";
            $stmtLast = $conn->query($queryLast);
            $lastCitas = $stmtLast->fetchAll(PDO::FETCH_ASSOC);
            echo "<pre>";
            print_r($lastCitas);
            echo "</pre>";
            
            echo "<p class='warning'>⚠️ Verificar que id_agenda_slot de las citas corresponda a slots del especialista $id_especialista</p>";
        }
        
    } else {
        echo "<p class='success'>✅ Se encontraron citas</p>";
        echo "<pre>";
        print_r($citasDirectas);
        echo "</pre>";
        
        // Contar por estado
        $queryEstados = "
            SELECT 
                c.estado_cita,
                COUNT(*) as total
            FROM citas c
            INNER JOIN agenda_slot s ON c.id_agenda_slot = s.id
            WHERE s.id_especialista = :id_esp
            GROUP BY c.estado_cita
        ";
        $stmtEstados = $conn->prepare($queryEstados);
        $stmtEstados->bindParam(':id_esp', $id_especialista);
        $stmtEstados->execute();
        $estados = $stmtEstados->fetchAll(PDO::FETCH_ASSOC);
        
        echo "<h3>Conteo por estado:</h3>";
        echo "<pre>";
        print_r($estados);
        echo "</pre>";
    }
    
} catch (Exception $e) {
    echo "<p class='error'>❌ ERROR en consulta: " . $e->getMessage() . "</p>";
}
echo "</div>";

// ========================================
// 5. PROBAR EL MODELO
// ========================================
echo "<div class='section'>";
echo "<h2>5️⃣ Probar CitasModel.php</h2>";

try {
    require_once BASE_PATH . '/app/models/CitasModel.php';
    $citasModel = new CitasModel();
    echo "<p class='success'>✅ Modelo instanciado correctamente</p>";
    
    // Probar obtener estadísticas
    echo "<h3>Resultado de contarCitasPorEstado():</h3>";
    $estadisticas = $citasModel->contarCitasPorEstado($id_especialista);
    echo "<pre>";
    print_r($estadisticas);
    echo "</pre>";
    
    // Probar obtener citas
    echo "<h3>Resultado de obtenerCitasPorEspecialista():</h3>";
    $citas = $citasModel->obtenerCitasPorEspecialista($id_especialista);
    echo "<p>Total retornado: " . count($citas) . "</p>";
    if (!empty($citas)) {
        echo "<pre>";
        print_r($citas);
        echo "</pre>";
    }
    
} catch (Exception $e) {
    echo "<p class='error'>❌ ERROR en modelo: " . $e->getMessage() . "</p>";
    echo "<pre>" . $e->getTraceAsString() . "</pre>";
}
echo "</div>";

// ========================================
// 6. DIAGNÓSTICO FINAL
// ========================================
echo "<div class='section'>";
echo "<h2>6️⃣ Diagnóstico y Recomendaciones</h2>";

if (count($citasDirectas) == 0) {
    echo "<div style='background: #fff3cd; padding: 15px; border-radius: 5px;'>";
    echo "<h3>🔍 PROBLEMA IDENTIFICADO:</h3>";
    echo "<p>No hay citas en la base de datos para el especialista ID: $id_especialista</p>";
    
    echo "<h3>✅ POSIBLES SOLUCIONES:</h3>";
    echo "<ol>";
    echo "<li><strong>Verificar que el paciente agendó la cita correctamente:</strong>";
    echo "<ul>";
    echo "<li>El slot seleccionado debe pertenecer al especialista con id_especialista = $id_especialista</li>";
    echo "<li>Revisar tabla 'agenda_slot' para confirmar que los slots tienen el id_especialista correcto</li>";
    echo "</ul></li>";
    
    echo "<li><strong>Verificar el flujo de creación de cita del paciente:</strong>";
    echo "<ul>";
    echo "<li>¿Se guarda correctamente el id_agenda_slot?</li>";
    echo "<li>¿El id_agenda_slot seleccionado corresponde a un slot del especialista?</li>";
    echo "</ul></li>";
    
    echo "<li><strong>Crear una cita de prueba manualmente:</strong>";
    echo "<pre style='background: #f8f9fa; padding: 10px;'>";
    echo "-- SQL para insertar cita de prueba:\n";
    echo "INSERT INTO citas (id_agenda_slot, id_paciente, id_servicio, motivo_consulta, estado_cita)\n";
    echo "VALUES (\n";
    echo "  (SELECT id FROM agenda_slot WHERE id_especialista = $id_especialista LIMIT 1),\n";
    echo "  1, -- ID de un paciente de prueba\n";
    echo "  1, -- ID de un servicio\n";
    echo "  'Cita de prueba',\n";
    echo "  'Pendiente'\n";
    echo ");\n";
    echo "</pre>";
    echo "</li>";
    echo "</ol>";
    echo "</div>";
} else {
    echo "<p class='success'>✅ TODO PARECE ESTAR BIEN. El problema puede estar en la vista o el controlador.</p>";
}

echo "</div>";

echo "<div class='section'>";
echo "<p><a href='/E-VITALIX/especialista/mis-citas' style='background: #007bff; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; display: inline-block;'>← Volver a Mis Citas</a></p>";
echo "</div>";

echo "</body></html>";
