<?php
/**
 * Funciones auxiliares
 */

/**
 * Validar que un campo no esté vacío
 */
function validarCampoVacio($campo) {
    return !empty(trim($campo));
}

/**
 * Validar que un monto sea válido
 */
function validarMonto($monto) {
    return is_numeric($monto) && $monto > 0;
}

/**
 * Sanitizar entrada de texto
 */
function sanitizar($texto) {
    return htmlspecialchars(strip_tags(trim($texto)));
}

/**
 * Formatear dinero
 */
function formatearDinero($monto) {
    return "$" . number_format($monto, 2);
}

/**
 * Mostrar mensaje de éxito
 */
function mostrarExito($mensaje) {
    return '<div class="alert alert-success">' . $mensaje . '</div>';
}

/**
 * Mostrar mensaje de error
 */
function mostrarError($mensaje) {
    return '<div class="alert alert-error">' . $mensaje . '</div>';
}

/**
 * Generar ID único
 */
function generarId() {
    return uniqid() . time();
}
?>