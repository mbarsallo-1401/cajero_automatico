<?php
/**
 * Archivo de configuración general
 */

// Zona horaria
date_default_timezone_set('America/Panama');

// Rutas de archivos
define('ARCHIVO_USUARIOS', 'datos/usuarios.txt');
define('ARCHIVO_CUENTAS', 'datos/cuentas.txt');
define('ARCHIVO_TRANSACCIONES', 'datos/transacciones.txt');

// Configuración de la aplicación
define('NOMBRE_APP', 'Cajero Automático');
define('VERSION', '1.0');

// Crear archivos si no existen
if (!file_exists('datos')) {
    mkdir('datos', 0777, true);
}

if (!file_exists(ARCHIVO_USUARIOS)) {
    file_put_contents(ARCHIVO_USUARIOS, "");
}

if (!file_exists(ARCHIVO_CUENTAS)) {
    file_put_contents(ARCHIVO_CUENTAS, "");
}

if (!file_exists(ARCHIVO_TRANSACCIONES)) {
    file_put_contents(ARCHIVO_TRANSACCIONES, "");
}
?>