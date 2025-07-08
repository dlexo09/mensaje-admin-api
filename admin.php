<?php
require_once 'auth.php';

// Requerir autenticación
requireAuth();

// Verificar permisos (solo editor, supervisor y admin pueden acceder)
if (!hasPermission('editor')) {
    header('Location: login.php');
    exit();
}

$currentUser = getCurrentUser();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MEGA | Administrador de Contenido</title>
    
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    
    <style>
        .admin-container {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            min-height: 100vh;
        }
        
        .admin-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        }
        
        .preview-card {
            background: #f8f9fa;
            border-radius: 15px;
            border: 2px dashed #dee2e6;
        }
        
        .btn-custom {
            background: linear-gradient(45deg, #1e3c72, #2a5298);
            border: none;
            border-radius: 10px;
            color: white;
            transition: all 0.3s ease;
        }
        
        .btn-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(30, 60, 114, 0.4);
            color: white;
        }
        
        .status-badge {
            position: absolute;
            top: -8px;
            right: -8px;
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.1); }
            100% { transform: scale(1); }
        }
        
        .char-counter {
            font-size: 0.8rem;
            color: #6c757d;
        }
        
        .char-counter.warning {
            color: #ffc107;
        }
        
        .char-counter.danger {
            color: #dc3545;
        }
        
        .navbar-custom {
            background: linear-gradient(45deg, #1e3c72, #2a5298);
            border-radius: 15px;
            margin-bottom: 2rem;
        }
        
        .user-info {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            padding: 0.5rem 1rem;
            margin-right: 1rem;
        }
        
        .role-badge {
            font-size: 0.7rem;
            padding: 0.25rem 0.5rem;
            border-radius: 10px;
            margin-left: 0.5rem;
        }
        
        .role-admin { background: #dc3545; }
        .role-supervisor { background: #ffc107; color: #000; }
        .role-editor { background: #28a745; }
    </style>
</head>

<body class="admin-container">
    <div class="container py-4">
        
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-custom">
            <div class="container-fluid">
                <a class="navbar-brand text-white fw-bold" href="#">
                    <i class="bi bi-gear-fill me-2"></i>
                    Administrador MEGA
                </a>
                
                <div class="navbar-nav ms-auto">
                    <div class="user-info d-flex align-items-center text-white">
                        <i class="bi bi-person-circle me-2"></i>
                        <span class="me-2"><?php echo htmlspecialchars($currentUser['name']); ?></span>
                        <span class="role-badge role-<?php echo $currentUser['role']; ?>">
                            <?php echo strtoupper($currentUser['role']); ?>
                        </span>
                    </div>
                    
                    <a href="?logout=1" class="btn btn-outline-light btn-sm ms-2">
                        <i class="bi bi-box-arrow-right me-1"></i>
                        Salir
                    </a>
                </div>
            </div>
        </nav>
        
        <div class="row justify-content-center">
            <div class="col-lg-10">
                
                <!-- Session Info -->
                <div class="alert alert-info alert-dismissible fade show" role="alert">
                    <i class="bi bi-info-circle me-2"></i>
                    <strong>Sesión activa:</strong> <?php echo htmlspecialchars($currentUser['name']); ?> 
                    (<?php echo $currentUser['role']; ?>) - 
                    Conectado desde: <?php echo date('H:i:s', $currentUser['login_time']); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>

                <!-- Main Card -->
                <div class="admin-card p-4 p-md-5 position-relative">
                    
                    <!-- Status Badge -->
                    <span class="badge bg-success status-badge" id="status-badge">
                        <i class="bi bi-check-circle-fill"></i> Activo
                    </span>

                    <div class="row">
                        <!-- Editor Column -->
                        <div class="col-lg-6 mb-4">
                            <h3 class="h4 mb-4">
                                <i class="bi bi-pencil-square text-primary me-2"></i>
                                Editor de Contenido
                            </h3>
                            
                            <form id="content-form">
                                <div class="mb-4">
                                    <label for="promotional-text" class="form-label fw-semibold">
                                        Texto Promocional
                                    </label>
                                    <textarea 
                                        class="form-control form-control-lg" 
                                        id="promotional-text" 
                                        rows="6" 
                                        placeholder="Ingresa el texto promocional aquí..."
                                        maxlength="500"
                                        <?php echo ($currentUser['role'] === 'editor') ? '' : ''; ?>
                                    ></textarea>
                                    <div class="d-flex justify-content-between mt-2">
                                        <small class="text-muted">Máximo 500 caracteres</small>
                                        <small class="char-counter" id="char-counter">0/500</small>
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <label for="updated-by" class="form-label fw-semibold">
                                            Actualizado por
                                        </label>
                                        <input 
                                            type="text" 
                                            class="form-control" 
                                            id="updated-by" 
                                            placeholder="Nombre del usuario"
                                            value="<?php echo htmlspecialchars($currentUser['name']); ?>"
                                            readonly
                                        >
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Estado</label>
                                        <div class="form-check form-switch mt-2">
                                            <input 
                                                class="form-check-input" 
                                                type="checkbox" 
                                                id="active-toggle" 
                                                checked
                                                <?php echo hasPermission('supervisor') ? '' : 'disabled'; ?>
                                            >
                                            <label class="form-check-label" for="active-toggle">
                                                Contenido activo
                                                <?php if (!hasPermission('supervisor')): ?>
                                                    <small class="text-muted">(Solo supervisores)</small>
                                                <?php endif; ?>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-grid gap-2 d-md-flex justify-content-md-start">
                                    <button type="submit" class="btn btn-custom btn-lg px-4 me-md-2">
                                        <i class="bi bi-save me-2"></i>
                                        Guardar Cambios
                                    </button>
                                    <button type="button" class="btn btn-outline-secondary btn-lg px-4" id="reset-btn">
                                        <i class="bi bi-arrow-clockwise me-2"></i>
                                        Recargar
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Preview Column -->
                        <div class="col-lg-6">
                            <h3 class="h4 mb-4">
                                <i class="bi bi-eye text-success me-2"></i>
                                Vista Previa
                            </h3>
                            
                            <div class="preview-card p-4 mb-4">
                                <h5 class="text-muted mb-3">Cómo se verá en el call center:</h5>
                                <div class="bg-white p-4 rounded border">
                                    <p class="mb-0 text-center fw-semibold" id="preview-text">
                                        Cargando texto...
                                    </p>
                                </div>
                            </div>

                            <!-- Info Panel -->
                            <div class="card border-info">
                                <div class="card-header bg-info text-white">
                                    <i class="bi bi-info-circle me-2"></i>
                                    Información del Sistema
                                </div>
                                <div class="card-body">
                                    <div class="row text-center">
                                        <div class="col-6">
                                            <div class="h5 text-primary mb-1" id="last-updated">-</div>
                                            <small class="text-muted">Última actualización</small>
                                        </div>
                                        <div class="col-6">
                                            <div class="h5 text-success mb-1" id="version">-</div>
                                            <small class="text-muted">Versión</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Test Button -->
                            <div class="mt-4">
                                <button class="btn btn-outline-primary w-100" id="test-api">
                                    <i class="bi bi-lightning me-2"></i>
                                    Probar API
                                </button>
                            </div>
                            
                            <!-- User Actions -->
                            <?php if (hasPermission('admin')): ?>
                            <div class="mt-4">
                                <div class="card border-warning">
                                    <div class="card-header bg-warning text-dark">
                                        <i class="bi bi-tools me-2"></i>
                                        Acciones de Administrador
                                    </div>
                                    <div class="card-body">
                                        <button class="btn btn-sm btn-outline-info w-100 mb-2" id="view-logs">
                                            <i class="bi bi-file-text me-2"></i>
                                            Ver Logs de Acceso
                                        </button>
                                        <button class="btn btn-sm btn-outline-secondary w-100" id="manage-users">
                                            <i class="bi bi-people me-2"></i>
                                            Gestionar Usuarios
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <div class="text-center text-white mt-4">
                    <p class="mb-0">
                        <i class="bi bi-shield-check me-2"></i>
                        Sistema de gestión de contenido - MEGA Departamento Web MKT
                    </p>
                    <small class="opacity-75">
                        Usuario: <?php echo htmlspecialchars($currentUser['name']); ?> | 
                        Rol: <?php echo strtoupper($currentUser['role']); ?> | 
                        Sesión: <?php echo date('d/m/Y H:i', $currentUser['login_time']); ?>
                    </small>
                </div>
            </div>
        </div>
    </div>

    <!-- Toast Notifications -->
    <div class="toast-container position-fixed top-0 end-0 p-3">
        <div id="success-toast" class="toast align-items-center text-bg-success border-0" role="alert">
            <div class="d-flex">
                <div class="toast-body">
                    <i class="bi bi-check-circle me-2"></i>
                    ¡Cambios guardados exitosamente!
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
        
        <div id="error-toast" class="toast align-items-center text-bg-danger border-0" role="alert">
            <div class="d-flex">
                <div class="toast-body">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    Error al guardar los cambios
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Pasar datos del usuario al JavaScript
        window.currentUser = {
            name: '<?php echo htmlspecialchars($currentUser['name']); ?>',
            role: '<?php echo $currentUser['role']; ?>',
            hasAdminPermission: <?php echo hasPermission('admin') ? 'true' : 'false'; ?>,
            hasSupervisorPermission: <?php echo hasPermission('supervisor') ? 'true' : 'false'; ?>
        };
    </script>
    <script src="admin-script.js"></script>
</body>
</html>
