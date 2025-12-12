<?php
require_once 'includes/config.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo NOMBRE_APP; ?> - Inicio</title>
    <link rel="stylesheet" href="css/estilos.css">
    <style>
        .logo-utp {
            position: fixed;
            width: 130px;
            height: 130px;
            z-index: 1000;
            opacity: 0.9;
            transition: transform 0.3s;
        }

        .logo-utp:hover {
            transform: scale(1.1);
        }

        .logo-utp-tl {
            top: 40px;
            left: 40px;
        }

        .logo-utp-tr {
            top: 40px;
            right: 40px;
        }

        .logo-utp-bl {
            bottom: 20px;
            left: 20px;
        }

        .logo-utp-br {
            bottom: 20px;
            right: 20px;
        }

        @media (max-width: 768px) {
            .logo-utp {
                width: 60px;
                height: 60px;
            }

            .logo-utp-tl, .logo-utp-tr {
                top: 10px;
            }

            .logo-utp-tl, .logo-utp-bl {
                left: 10px;
            }

            .logo-utp-tr, .logo-utp-br {
                right: 10px;
            }

            .logo-utp-bl, .logo-utp-br {
                bottom: 10px;
            }
        }

        .features-container {
            margin-top: 30px;
            padding: 20px;
            background-color: #f8f9fa;
            border-radius: 10px;
        }

        .features-container h2 {
            color: #667eea;
            margin-bottom: 15px;
            font-size: 20px;
        }

        .features-list {
            list-style: none;
            padding: 0;
        }

        .features-list li {
            padding: 10px 0;
            color: #555;
            border-bottom: 1px solid #e0e0e0;
        }

        .features-list li:last-child {
            border-bottom: none;
        }

        .icon {
            margin-right: 10px;
            font-size: 20px;
        }
    </style>
</head>
<body>
    <!-- Logos UTP en las esquinas superiores izquierda y derecha -->
    <img src="img/utp-logo.png" alt="UTP Logo" class="logo-utp logo-utp-tl">
    <img src="img/utp.png" alt="UTP Logo GIF" class="logo-utp logo-utp-tr">

    <div class="container">
        <div class="logo">
            <div class="logo-text">💳 ATM</div>
        </div>
        <h1>Bienvenido al Cajero Automático</h1>
	<h1>UTP TECNOCASH</h1>
        <p style="text-align: center; color: #666; margin-bottom: 30px;">
            Sistema de gestión bancaria con árbol de decisiones
        </p>

        <a href="login.php" class="btn">Iniciar Sesión</a>
        <a href="registro.php" class="btn btn-secondary">Registrarse</a>
        <a href="recorridos.php" class="btn btn-success">Ver Recorridos del Árbol</a>

        <!-- Sección de características -->
        <div class="features-container">
            <h2>Características del Cajero</h2>
            <ul class="features-list">
                <li><span class="icon">🔐</span> Autenticación segura</li>
                <li><span class="icon">📊</span> Consulta de saldo</li>
                <li><span class="icon">💰</span> Depósitos y retiros</li>
                <li><span class="icon">📋</span> Historial de transacciones</li>
                <li><span class="icon">🌳</span> Árbol de decisiones</li>
            </ul>
        </div>
    </div>
</body>
</html>