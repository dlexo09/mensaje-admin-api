<?php
require_once 'auth.php';

header('Content-Type: application/json');

// Requerir autenticación y permisos de administrador
if (!isAuthenticated() || !hasPermission('admin')) {
    echo json_encode(['success' => false, 'error' => 'Acceso denegado']);
    exit();
}

try {
    $logFiles = [
        'data/access-log.txt',
        'data/update-log.txt'
    ];
    
    $clearedFiles = [];
    
    foreach ($logFiles as $file) {
        if (file_exists($file)) {
            // Crear backup antes de limpiar
            $backupFile = $file . '.backup-' . date('Y-m-d-H-i-s');
            copy($file, $backupFile);
            
            // Limpiar archivo
            file_put_contents($file, '');
            $clearedFiles[] = $file;
        }
    }
    
    // Log de la acción
    $currentUser = getCurrentUser();
    $logEntry = sprintf(
        "[%s] Logs limpiados por: %s (%s) desde IP: %s\n",
        date('Y-m-d H:i:s'),
        $currentUser['name'],
        $currentUser['role'],
        $_SERVER['REMOTE_ADDR']
    );
    
    file_put_contents('data/access-log.txt', $logEntry, FILE_APPEND | LOCK_EX);
    
    echo json_encode([
        'success' => true,
        'message' => 'Logs limpiados exitosamente',
        'files_cleared' => $clearedFiles
    ]);
    
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}
?>
