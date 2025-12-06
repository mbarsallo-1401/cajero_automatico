<?php
require_once 'includes/config.php';
require_once 'includes/sesion.php';
require_once 'includes/funciones.php';
require_once 'clases/Transaccion.php';

// Verificar sesión
verificarSesion();

$usuario = obtenerUsuarioSesion();
$transacciones = Transaccion::obtenerHistorial($usuario, ARCHIVO_TRANSACCIONES);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historial - <?php echo NOMBRE_APP; ?></title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>
    <div class="container">
        <h1>Historial de Transacciones</h1>

        <?php if (empty($transacciones)): ?>
            <div class="alert alert-info">No hay transacciones registradas.</div>
        <?php else: ?>
            <table class="historial-table">
                <tr>
                    <th>Fecha</th>
                    <th>Tipo</th>
                    <th>Monto</th>
                    <th>Saldo Anterior</th>
                    <th>Saldo Nuevo</th>
                </tr>
                <?php foreach ($transacciones as $t): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($t['fecha']); ?></td>
                        <td class="<?php echo $t['tipo'] === 'Depósito' ? 'tipo-deposito' : 'tipo-retiro'; ?>">
                            <?php echo htmlspecialchars($t['tipo']); ?>
                        </td>
                        <td><?php echo formatearDinero($t['monto']); ?></td>
                        <td><?php echo formatearDinero($t['saldoAnterior']); ?></td>
                        <td><?php echo formatearDinero($t['saldoNuevo']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php endif; ?>

        <a href="menu.php" class="btn">Volver al Menú</a>
    </div>
</body>
</html>