<?php
require_once 'includes/config.php';
require_once 'includes/sesion.php';
require_once 'includes/funciones.php';
require_once 'clases/Cuenta.php';

// Verificar que el usuario esté autenticado
verificarSesion();

$usuario = obtenerUsuarioSesion();
$cuenta = Cuenta::cargarCuenta($usuario, ARCHIVO_CUENTAS);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menú Principal - <?php echo NOMBRE_APP; ?></title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>
    <div class="container">
        <h1>Menú Principal</h1>
        <p style="text-align: center; color: #666; margin-bottom: 20px;">
            Bienvenido, <strong><?php echo htmlspecialchars($usuario); ?></strong>
        </p>

        <div class="saldo-display">
            <h3>Saldo Actual</h3>
            <div class="monto"><?php echo formatearDinero($cuenta->getSaldo()); ?></div>
        </div>

        <div class="menu-grid">
            <a href="consultar_saldo.php" class="menu-item">
                📊 Consultar Saldo
            </a>
            <a href="depositar.php" class="menu-item">
                💰 Depositar
            </a>
            <a href="retirar.php" class="menu-item">
                💸 Retirar
            </a>
            <a href="historial.php" class="menu-item">
                📋 Historial
            </a>
        </div>

        <a href="recorridos.php" class="btn btn-success" style="margin-top: 20px;">
            🌳 Ver Recorridos del Árbol
        </a>

        <a href="logout.php" class="btn btn-danger" style="margin-top: 10px;">
            🚪 Cerrar Sesión
        </a>
    </div>
</body>
</html>