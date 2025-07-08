<?php
require_once 'auth.php';

// Requerir autenticación y permisos de administrador
requireAuth();
if (!hasPermission('admin')) {
    die('Acceso denegado');
}

$logFile = 'data/access-log.txt';
$updateLogFile = 'data/update-log.txt';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MEGA | Logs del Sistema</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <style>
        .log-container {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 1rem;
            max-height: 400px;
            overflow-y: auto;
            font-family: 'Courier New', monospace;
            font-size: 0.85rem;
        }
        
        .log-entry {
            margin: 0.25rem 0;
            padding: 0.5rem;
            border-radius: 5px;
            background: white;
            border-left: 3px solid #007bff;
        }
        
        .log-entry.success {
            border-left-color: #28a745;
        }
        
        .log-entry.error {
            border-left-color: #dc3545;
        }
        
        .log-entry.warning {
            border-left-color: #ffc107;
        }
    </style>
</head>
<body class="bg-light">
    <div class="container py-4">
        <div class="row">
            <div class="col-12">
                <h2 class="mb-4">
                    <i class="bi bi-file-text text-primary me-2"></i>
                    Logs del Sistema
                </h2>
                
                <div class="row">
                    <!-- Access Logs -->
                    <div class="col-md-6 mb-4">
                        <div class="card">
                            <div class="card-header bg-primary text-white">
                                <i class="bi bi-person-check me-2"></i>
                                Logs de Acceso
                            </div>
                            <div class="card-body">
                                <div class="log-container" id="access-logs">
                                    <?php
                                    if (file_exists($logFile)) {
                                        $logs = file($logFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
                                        $logs = array_reverse(array_slice($logs, -50)); // Últimas 50 entradas
                                        
                                        foreach ($logs as $log) {
                                            $class = 'log-entry';
                                            if (strpos($log, 'Login exitoso') !== false) {
                                                $class .= ' success';
                                            } elseif (strpos($log, 'Login fallido') !== false) {
                                                $class .= ' error';
                                            } elseif (strpos($log, 'Logout') !== false) {
                                                $class .= ' warning';
                                            }
                                            
                                            echo '<div class="' . $class . '">' . htmlspecialchars($log) . '</div>';
                                        }
                                    } else {
                                        echo '<div class="text-muted">No hay logs de acceso disponibles</div>';
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Update Logs -->
                    <div class="col-md-6 mb-4">
                        <div class="card">
                            <div class="card-header bg-success text-white">
                                <i class="bi bi-pencil-square me-2"></i>
                                Logs de Actualización
                            </div>
                            <div class="card-body">
                                <div class="log-container" id="update-logs">
                                    <?php
                                    if (file_exists($updateLogFile)) {
                                        $logs = file($updateLogFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
                                        $logs = array_reverse(array_slice($logs, -50)); // Últimas 50 entradas
                                        
                                        foreach ($logs as $log) {
                                            echo '<div class="log-entry success">' . htmlspecialchars($log) . '</div>';
                                        }
                                    } else {
                                        echo '<div class="text-muted">No hay logs de actualización disponibles</div>';
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Actions -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header bg-warning">
                                <i class="bi bi-tools me-2"></i>
                                Acciones
                            </div>
                            <div class="card-body">
                                <div class="btn-group" role="group">
                                    <button class="btn btn-outline-primary" onclick="location.reload()">
                                        <i class="bi bi-arrow-clockwise me-2"></i>
                                        Actualizar
                                    </button>
                                    <button class="btn btn-outline-info" onclick="downloadLogs()">
                                        <i class="bi bi-download me-2"></i>
                                        Descargar Logs
                                    </button>
                                    <button class="btn btn-outline-danger" onclick="clearLogs()">
                                        <i class="bi bi-trash me-2"></i>
                                        Limpiar Logs
                                    </button>
                                    <button class="btn btn-outline-secondary" onclick="window.close()">
                                        <i class="bi bi-x-circle me-2"></i>
                                        Cerrar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function downloadLogs() {
            // Crear un archivo temporal con todos los logs
            const accessLogs = document.getElementById('access-logs').innerText;
            const updateLogs = document.getElementById('update-logs').innerText;
            
            const content = `=== LOGS DE ACCESO ===\n${accessLogs}\n\n=== LOGS DE ACTUALIZACIÓN ===\n${updateLogs}`;
            
            const blob = new Blob([content], { type: 'text/plain' });
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = `mega-logs-${new Date().toISOString().split('T')[0]}.txt`;
            a.click();
            URL.revokeObjectURL(url);
        }
        
        function clearLogs() {
            if (confirm('¿Está seguro de que desea limpiar todos los logs? Esta acción no se puede deshacer.')) {
                fetch('clear-logs.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert('Error al limpiar los logs: ' + data.error);
                    }
                })
                .catch(error => {
                    alert('Error: ' + error.message);
                });
            }
        }
        
        // Auto-refresh cada 10 segundos
        setInterval(() => {
            location.reload();
        }, 10000);
    </script>
</body>
</html>
