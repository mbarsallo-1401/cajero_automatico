<?php
require_once 'includes/config.php';
require_once 'includes/sesion.php';
require_once 'includes/funciones.php';
require_once 'clases/Usuario.php';

$error = "";

// Generar números aleatorios para el CAPTCHA
if (!isset($_SESSION['captcha_num1']) || !isset($_SESSION['captcha_num2'])) {
    $_SESSION['captcha_num1'] = rand(1, 10);
    $_SESSION['captcha_num2'] = rand(1, 10);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = sanitizar($_POST['usuario']);
    $password = $_POST['password'];
    $captcha_respuesta = $_POST['captcha'];

    // Validar CAPTCHA primero
    $captcha_correcto = $_SESSION['captcha_num1'] + $_SESSION['captcha_num2'];
    
    if (empty($captcha_respuesta) || $captcha_respuesta != $captcha_correcto) {
        $error = "CAPTCHA incorrecto. Por favor, verifica la suma.";
        // Regenerar CAPTCHA
        $_SESSION['captcha_num1'] = rand(1, 10);
        $_SESSION['captcha_num2'] = rand(1, 10);
    } elseif (!validarCampoVacio($nombre) || !validarCampoVacio($password)) {
        $error = "Todos los campos son obligatorios";
    } else {
        // Buscar usuario
        $usuario = Usuario::buscarUsuario($nombre, ARCHIVO_USUARIOS);

        if ($usuario && $usuario->autenticar($password)) {
            // Login exitoso
            $_SESSION['usuario'] = $nombre;
            $_SESSION['login_time'] = time();
            
            // Limpiar CAPTCHA
            unset($_SESSION['captcha_num1']);
            unset($_SESSION['captcha_num2']);
            
            header('Location: menu.php');
            exit();
        } else {
            $error = "Usuario o contraseña incorrectos";
            // Regenerar CAPTCHA por seguridad
            $_SESSION['captcha_num1'] = rand(1, 10);
            $_SESSION['captcha_num2'] = rand(1, 10);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - <?php echo NOMBRE_APP; ?></title>
    <link rel="stylesheet" href="css/estilos.css">
    <style>
        .logo-utp {
            position: fixed;
            width: 100px;
            height: 100px;
            z-index: 1000;
            opacity: 0.9;
            transition: transform 0.3s;
        }

        .logo-utp:hover {
            transform: scale(1.1);
        }

        .logo-utp-tl {
            top: 20px;
            left: 20px;
        }

        .logo-utp-tr {
            top: 20px;
            right: 20px;
        }

        .logo-utp-bl {
            bottom: 20px;
            left: 20px;
        }

        .logo-utp-br {
            bottom: 20px;
            right: 20px;
        }

        .captcha-box {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            margin: 15px 0;
            font-size: 24px;
            font-weight: bold;
            letter-spacing: 2px;
            user-select: none;
        }

        .captcha-label {
            font-size: 14px;
            color: #666;
            margin-bottom: 5px;
            display: block;
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
    </style>
</head>
<body>
    <!-- Logos UTP en las esquinas -->
    <img src="img/utp-logo.png" alt="UTP Logo" class="logo-utp logo-utp-tl">
    <img src="img/utp-logo.png" alt="UTP Logo" class="logo-utp logo-utp-tr">
    <img src="img/utp-logo.png" alt="UTP Logo" class="logo-utp logo-utp-bl">
    <img src="img/utp-logo.png" alt="UTP Logo" class="logo-utp logo-utp-br">

    <div class="container">
        <div class="logo">
            <div class="logo-text">💳 ATM</div>
        </div>
        <h1>Iniciar Sesión</h1>

        <?php if ($error): ?>
            <?php echo mostrarError($error); ?>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="form-group">
                <label for="usuario">Usuario:</label>
                <input type="text" id="usuario" name="usuario" required 
                       placeholder="Ingrese su usuario"
                       value="<?php echo $_POST['usuario'] ?? ''; ?>">
            </div>

            <div class="form-group">
                <label for="password">Contraseña:</label>
                <input type="password" id="password" name="password" required
                       placeholder="Ingrese su contraseña">
            </div>

            <div class="form-group">
                <span class="captcha-label">🤖 Verificación de seguridad - Resuelve la suma:</span>
                <div class="captcha-box">
                    <?php echo $_SESSION['captcha_num1']; ?> + <?php echo $_SESSION['captcha_num2']; ?> = ?
                </div>
                <label for="captcha">Tu respuesta:</label>
                <input type="number" id="captcha" name="captcha" required 
                       placeholder="Ingresa el resultado de la suma">
            </div>

            <button type="submit" class="btn">Ingresar</button>
        </form>

        <a href="registro.php" class="link">¿No tienes cuenta? Regístrate</a>
        <a href="index.php" class="link">Volver al inicio</a>
    </div>
</body>
</html>