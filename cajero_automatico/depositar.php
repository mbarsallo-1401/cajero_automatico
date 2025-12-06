<?php
require_once 'includes/config.php';
require_once 'includes/sesion.php';
require_once 'includes/funciones.php';
require_once 'clases/Cuenta.php';
require_once 'clases/Transaccion.php';

// Verificar sesión
verificarSesion();

$usuario = obtenerUsuarioSesion();
$cuenta = Cuenta::cargarCuenta($usuario, ARCHIVO_CUENTAS);

$mensaje = "";
$error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $monto = $_POST['monto'];

    // Validaciones
    if (!validarCampoVacio($monto)) {
        $error = "El monto es obligatorio";
    } elseif (!validarMonto($monto)) {
        $error = "El monto debe ser un número positivo";
    } elseif ($monto > 10000) {
        $error = "El monto máximo por depósito es $10,000";
    } else {
        $saldoAnterior = $cuenta->getSaldo();

        if ($cuenta->depositar(floatval($monto))) {
            $saldoNuevo = $cuenta->getSaldo();
            $cuenta->guardarCuenta(ARCHIVO_CUENTAS);

            // Registrar transacción
            $transaccion = new Transaccion("Depósito", $monto, $usuario, $saldoAnterior, $saldoNuevo);
            $transaccion->registrar(ARCHIVO_TRANSACCIONES);

            $mensaje = "Depósito realizado exitosamente. Nuevo saldo: " . formatearDinero($saldoNuevo);
        } else {
            $error = "Error al realizar el depósito";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Depositar - <?php echo NOMBRE_APP; ?></title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>
    <div class="container">
        <h1>Realizar Depósito</h1>

        <div class="saldo-display">
            <h3>Saldo Actual</h3>
            <div class="monto"><?php echo formatearDinero($cuenta->getSaldo()); ?></div>
        </div>

        <?php if ($mensaje): ?>
            <?php echo mostrarExito($mensaje); ?>
        <?php endif; ?>

        <?php if ($error): ?>
            <?php echo mostrarError($error); ?>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="form-group">
                <label for="monto">Monto a Depositar:</label>
                <input type="number" id="monto" name="monto" step="0.01" min="0.01" 
                       placeholder="0.00" required>
            </div>

            <button type="submit" class="btn btn-success">💰 Depositar</button>
        </form>

        <a href="menu.php" class="btn btn-secondary" style="margin-top: 10px;">Volver al Menú</a>
    </div>
</body>
</html>