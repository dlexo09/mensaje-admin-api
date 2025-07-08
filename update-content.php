<?php
require_once 'auth.php';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Requerir autenticación
if (!isAuthenticated()) {
    http_response_code(401);
    echo json_encode(['error' => 'No autenticado']);
    exit();
}

// Verificar permisos mínimos (editor)
if (!hasPermission('editor')) {
    http_response_code(403);
    echo json_encode(['error' => 'Permisos insuficientes']);
    exit();
}

// Manejar preflight request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Solo permitir POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Método no permitido']);
    exit();
}

try {
    // Obtener datos del request
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);
    
    if (!$data) {
        throw new Exception('Datos JSON inválidos');
    }
    
    // Validar campos requeridos
    if (!isset($data['promotional_text']) || empty(trim($data['promotional_text']))) {
        throw new Exception('El texto promocional es requerido');
    }
    
    // Validar longitud del texto
    if (strlen($data['promotional_text']) > 500) {
        throw new Exception('El texto no puede exceder 500 caracteres');
    }
    
    // Obtener usuario actual
    $currentUser = getCurrentUser();
    
    // Preparar datos para guardar
    $contentData = [
        'promotional_text' => trim($data['promotional_text']),
        'last_updated' => $data['last_updated'] ?? date('c'),
        'updated_by' => $currentUser['name'], // Usar el nombre del usuario autenticado
        'version' => $data['version'] ?? '1.0',
        'active' => isset($data['active']) ? (bool)$data['active'] : true
    ];
    
    // Verificar permisos para cambiar el estado activo
    if (isset($data['active']) && !hasPermission('supervisor')) {
        $contentData['active'] = true; // Forzar activo si no tiene permisos
    }
    
    // Ruta del archivo JSON
    $jsonFile = 'data/promotional-text.json';
    
    // Crear directorio si no existe
    $dir = dirname($jsonFile);
    if (!is_dir($dir)) {
        if (!mkdir($dir, 0755, true)) {
            throw new Exception('No se pudo crear el directorio de datos');
        }
    }
    
    // Hacer backup del archivo actual si existe
    if (file_exists($jsonFile)) {
        $backupFile = $dir . '/promotional-text-backup-' . date('Y-m-d-H-i-s') . '.json';
        if (!copy($jsonFile, $backupFile)) {
            error_log("Warning: No se pudo crear backup en $backupFile");
        }
        
        // Limpiar backups antiguos (mantener solo los últimos 5)
        $backups = glob($dir . '/promotional-text-backup-*.json');
        if (count($backups) > 5) {
            // Ordenar por fecha de modificación (más reciente primero)
            array_multisort(array_map('filemtime', $backups), SORT_DESC, $backups);
            
            // Eliminar los backups más antiguos
            for ($i = 5; $i < count($backups); $i++) {
                unlink($backups[$i]);
            }
        }
    }
    
    // Guardar archivo JSON
    $jsonContent = json_encode($contentData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    
    if (file_put_contents($jsonFile, $jsonContent, LOCK_EX) === false) {
        throw new Exception('No se pudo escribir el archivo');
    }
    
    // Verificar que el archivo se guardó correctamente
    if (!file_exists($jsonFile)) {
        throw new Exception('El archivo no se guardó correctamente');
    }
    
    // Log de la operación
    $logEntry = sprintf(
        "[%s] Contenido actualizado por: %s (%s) | Versión: %s | Activo: %s | IP: %s\n",
        date('Y-m-d H:i:s'),
        $currentUser['name'],
        $currentUser['role'],
        $contentData['version'],
        $contentData['active'] ? 'Sí' : 'No',
        $_SERVER['REMOTE_ADDR']
    );
    
    file_put_contents($dir . '/update-log.txt', $logEntry, FILE_APPEND | LOCK_EX);
    
    // Respuesta exitosa
    http_response_code(200);
    echo json_encode([
        'success' => true,
        'message' => 'Contenido actualizado exitosamente',
        'data' => $contentData,
        'timestamp' => date('c')
    ]);
    
} catch (Exception $e) {
    // Log del error
    error_log("Error en update-content.php: " . $e->getMessage());
    
    // Respuesta de error
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage(),
        'timestamp' => date('c')
    ]);
}
?>
