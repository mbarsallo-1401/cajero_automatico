<?php
/**
 * Manejo de sesiones
 */

// Iniciar sesión si no está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Verificar si el usuario está autenticado
 */
function verificarSesion() {
    if (!isset($_SESSION['usuario'])) {
        header('Location: login.php');
        exit();
    }
}

/**
 * Obtener usuario de la sesión
 */
function obtenerUsuarioSesion() {
    return $_SESSION['usuario'] ?? null;
}

/**
 * Cerrar sesión
 */
function cerrarSesion() {
    session_unset();
    session_destroy();
    header('Location: index.php');
    exit();
}
?>