<?php
session_start();

// Configuración de usuarios (en producción, usar base de datos)
$users = [
    'admin' => [
        'password' => password_hash('admin123', PASSWORD_DEFAULT),
        'name' => 'Administrador',
        'role' => 'admin'
    ],
    'supervisor' => [
        'password' => password_hash('super123', PASSWORD_DEFAULT),
        'name' => 'Supervisor',
        'role' => 'supervisor'
    ],
    'editor' => [
        'password' => password_hash('Mega2025', PASSWORD_DEFAULT),
        'name' => 'Editor',
        'role' => 'editor'
    ]
];

// Función para verificar credenciales
function authenticateUser($username, $password, $users) {
    if (!isset($users[$username])) {
        return false;
    }
    
    if (password_verify($password, $users[$username]['password'])) {
        return $users[$username];
    }
    
    return false;
}

// Función para verificar si el usuario está autenticado
function isAuthenticated() {
    return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
}

// Función para obtener información del usuario actual
function getCurrentUser() {
    if (!isAuthenticated()) {
        return null;
    }
    
    return [
        'id' => $_SESSION['user_id'],
        'name' => $_SESSION['user_name'],
        'role' => $_SESSION['user_role'],
        'login_time' => $_SESSION['login_time']
    ];
}

// Función para cerrar sesión
function logout() {
    session_destroy();
    header('Location: login.php');
    exit();
}

// Función para requerir autenticación
function requireAuth() {
    if (!isAuthenticated()) {
        header('Location: login.php');
        exit();
    }
}

// Función para verificar permisos
function hasPermission($requiredRole) {
    if (!isAuthenticated()) {
        return false;
    }
    
    $roles = ['editor' => 1, 'supervisor' => 2, 'admin' => 3];
    $userRole = $_SESSION['user_role'];
    
    return $roles[$userRole] >= $roles[$requiredRole];
}

// Procesar login
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $remember = isset($_POST['remember']);
    
    if (empty($username) || empty($password)) {
        $error = 'Usuario y contraseña son requeridos';
    } else {
        $user = authenticateUser($username, $password, $users);
        
        if ($user) {
            // Iniciar sesión
            $_SESSION['user_id'] = $username;
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_role'] = $user['role'];
            $_SESSION['login_time'] = time();
            
            // Configurar cookie de recordar (opcional)
            if ($remember) {
                setcookie('remember_user', $username, time() + (30 * 24 * 60 * 60), '/');
            }
            
            // Log de acceso
            $logEntry = sprintf(
                "[%s] Login exitoso: %s (%s) desde IP: %s\n",
                date('Y-m-d H:i:s'),
                $user['name'],
                $user['role'],
                $_SERVER['REMOTE_ADDR']
            );
            
            file_put_contents('data/access-log.txt', $logEntry, FILE_APPEND | LOCK_EX);
            
            // Redirigir al admin
            header('Location: admin.php');
            exit();
        } else {
            $error = 'Usuario o contraseña incorrectos';
            
            // Log de intento fallido
            $logEntry = sprintf(
                "[%s] Login fallido: %s desde IP: %s\n",
                date('Y-m-d H:i:s'),
                $username,
                $_SERVER['REMOTE_ADDR']
            );
            
            file_put_contents('data/access-log.txt', $logEntry, FILE_APPEND | LOCK_EX);
        }
    }
}

// Procesar logout
if (isset($_GET['logout'])) {
    $user = getCurrentUser();
    if ($user) {
        // Log de logout
        $logEntry = sprintf(
            "[%s] Logout: %s (%s)\n",
            date('Y-m-d H:i:s'),
            $user['name'],
            $user['role']
        );
        
        file_put_contents('data/access-log.txt', $logEntry, FILE_APPEND | LOCK_EX);
    }
    
    logout();
}

// Auto-login con cookie
if (!isAuthenticated() && isset($_COOKIE['remember_user'])) {
    $username = $_COOKIE['remember_user'];
    if (isset($users[$username])) {
        $_SESSION['user_id'] = $username;
        $_SESSION['user_name'] = $users[$username]['name'];
        $_SESSION['user_role'] = $users[$username]['role'];
        $_SESSION['login_time'] = time();
    }
}
?>
