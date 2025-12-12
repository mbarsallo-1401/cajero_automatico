<?php
require_once 'includes/config.php';
require_once 'includes/sesion.php';
require_once 'includes/funciones.php';
require_once 'clases/Cuenta.php';

// Verificar sesión
verificarSesion();

$usuario = obtenerUsuarioSesion();
$cuenta = Cuenta::cargarCuenta($usuario, ARCHIVO_CUENTAS);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultar Saldo - <?php echo NOMBRE_APP; ?></title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>
    <div class="container">
        <h1>Consultar Saldo</h1>

        <div class="saldo-display">
            <h3>Tu Saldo Actual</h3>
            <div class="monto"><?php echo formatearDinero($cuenta->getSaldo()); ?></div>
        </div>

        <div style="background-color: #f8f9fa; padding: 20px; border-radius: 8px; margin: 20px 0;">
            <h3 style="color: #667eea; margin-bottom: 10px;">Información de la Cuenta</h3>
            <p style="color: #555; line-height: 1.8;">
                <strong>Usuario:</strong> <?php echo htmlspecialchars($usuario); ?><br>
                <strong>Número de Cuenta:</strong> <?php echo htmlspecialchars($cuenta->getNumeroCuenta()); ?><br>
                <strong>Saldo Disponible:</strong> <?php echo formatearDinero($cuenta->getSaldo()); ?>
            </p>
        </div>

        <a href="menu.php" class="btn">Volver al Menú</a>
        <a href="historial.php" class="btn btn-success">Ver Historial</a>
    </div>
</body>
</html>