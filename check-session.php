<?php
require_once 'auth.php';

header('Content-Type: application/json');

// Verificar autenticación
if (!isAuthenticated()) {
    echo json_encode(['authenticated' => false]);
    exit();
}

// Verificar si la sesión es válida (no expirada)
$sessionTimeout = 24 * 60 * 60; // 24 horas
if (time() - $_SESSION['login_time'] > $sessionTimeout) {
    session_destroy();
    echo json_encode(['authenticated' => false, 'reason' => 'expired']);
    exit();
}

// Sesión válida
echo json_encode([
    'authenticated' => true,
    'user' => getCurrentUser(),
    'timestamp' => time()
]);
?>
