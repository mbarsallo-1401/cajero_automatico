<?php
require_once 'includes/config.php';
require_once 'includes/funciones.php';
require_once 'clases/Usuario.php';

$mensaje = "";
$error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = sanitizar($_POST['nombre']);
    $email = sanitizar($_POST['email']);
    $password = $_POST['password'];
    $confirmar = $_POST['confirmar'];

    // Validaciones
    if (!validarCampoVacio($nombre) || !validarCampoVacio($email) || !validarCampoVacio($password)) {
        $error = "Todos los campos son obligatorios";
    } elseif ($password !== $confirmar) {
        $error = "Las contraseñas no coinciden";
    } elseif (strlen($password) < 8) {
        $error = "La contraseña debe tener al menos 8 caracteres";
    } elseif (!preg_match('/[A-Z]/', $password)) {
        $error = "La contraseña debe contener al menos una letra mayúscula";
    } elseif (!preg_match('/[a-z]/', $password)) {
        $error = "La contraseña debe contener al menos una letra minúscula";
    } elseif (!preg_match('/[0-9]/', $password)) {
        $error = "La contraseña debe contener al menos un número";
    } elseif (!preg_match('/[^A-Za-z0-9]/', $password)) {
        $error = "La contraseña debe contener al menos un carácter especial (@, #, $, etc.)";
    } elseif (Usuario::existeUsuario($nombre, ARCHIVO_USUARIOS)) {
        $error = "El nombre de usuario ya existe";
    } else {
        // Crear usuario
        $id = generarId();
        $usuario = new Usuario($id, $nombre, $password, $email);
        Usuario::guardarUsuario($usuario, ARCHIVO_USUARIOS);

        $mensaje = "Usuario registrado exitosamente. Redirigiendo al login...";
        header("refresh:2;url=login.php");
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - <?php echo NOMBRE_APP; ?></title>
    <link rel="stylesheet" href="css/estilos.css">
    <style>
        .password-strength {
            margin-top: 8px;
            height: 8px;
            background-color: #e0e0e0;
            border-radius: 4px;
            overflow: hidden;
            transition: all 0.3s;
        }

        .password-strength-bar {
            height: 100%;
            width: 0%;
            transition: all 0.3s;
        }

        .strength-weak { 
            width: 33%; 
            background-color: #ff4444; 
        }

        .strength-medium { 
            width: 66%; 
            background-color: #ffbb33; 
        }

        .strength-strong { 
            width: 100%; 
            background-color: #00C851; 
        }

        .password-requirements {
            margin-top: 10px;
            padding: 15px;
            background-color: #f8f9fa;
            border-radius: 8px;
            font-size: 14px;
        }

        .requirement {
            margin: 5px 0;
            color: #999;
            transition: color 0.3s;
        }

        .requirement.met {
            color: #00C851;
        }

        .requirement::before {
            content: "✗ ";
            font-weight: bold;
        }

        .requirement.met::before {
            content: "✓ ";
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Registro de Usuario</h1>

        <?php if ($mensaje): ?>
            <?php echo mostrarExito($mensaje); ?>
        <?php endif; ?>

        <?php if ($error): ?>
            <?php echo mostrarError($error); ?>
        <?php endif; ?>

        <form method="POST" action="" id="registroForm">
            <div class="form-group">
                <label for="nombre">Nombre de Usuario:</label>
                <input type="text" id="nombre" name="nombre" required 
                       value="<?php echo $_POST['nombre'] ?? ''; ?>">
            </div>

            <div class="form-group">
                <label for="email">Correo Electrónico:</label>
                <input type="email" id="email" name="email" required
                       value="<?php echo $_POST['email'] ?? ''; ?>">
            </div>

            <div class="form-group">
                <label for="password">Contraseña:</label>
                <input type="password" id="password" name="password" required>
                <div class="password-strength">
                    <div class="password-strength-bar" id="strengthBar"></div>
                </div>
                <div class="password-requirements">
                    <strong>Requisitos de seguridad:</strong>
                    <div class="requirement" id="req-length">Mínimo 8 caracteres</div>
                    <div class="requirement" id="req-uppercase">Al menos una letra mayúscula (A-Z)</div>
                    <div class="requirement" id="req-lowercase">Al menos una letra minúscula (a-z)</div>
                    <div class="requirement" id="req-number">Al menos un número (0-9)</div>
                    <div class="requirement" id="req-special">Al menos un carácter especial (@#$%^&*)</div>
                </div>
            </div>

            <div class="form-group">
                <label for="confirmar">Confirmar Contraseña:</label>
                <input type="password" id="confirmar" name="confirmar" required>
            </div>

            <button type="submit" class="btn" id="submitBtn">Registrarse</button>
        </form>

        <a href="login.php" class="link">¿Ya tienes cuenta? Inicia sesión</a>
        <a href="index.php" class="link">Volver al inicio</a>
    </div>

    <script>
        const passwordInput = document.getElementById('password');
        const confirmarInput = document.getElementById('confirmar');
        const strengthBar = document.getElementById('strengthBar');
        const submitBtn = document.getElementById('submitBtn');

        const requirements = {
            length: { regex: /.{8,}/, element: document.getElementById('req-length') },
            uppercase: { regex: /[A-Z]/, element: document.getElementById('req-uppercase') },
            lowercase: { regex: /[a-z]/, element: document.getElementById('req-lowercase') },
            number: { regex: /[0-9]/, element: document.getElementById('req-number') },
            special: { regex: /[^A-Za-z0-9]/, element: document.getElementById('req-special') }
        };

        passwordInput.addEventListener('input', function() {
            const password = this.value;
            let metCount = 0;

            // Verificar cada requisito
            for (let key in requirements) {
                const req = requirements[key];
                if (req.regex.test(password)) {
                    req.element.classList.add('met');
                    metCount++;
                } else {
                    req.element.classList.remove('met');
                }
            }

            // Actualizar barra de fortaleza
            strengthBar.className = 'password-strength-bar';
            if (metCount <= 2) {
                strengthBar.classList.add('strength-weak');
            } else if (metCount <= 4) {
                strengthBar.classList.add('strength-medium');
            } else {
                strengthBar.classList.add('strength-strong');
            }
        });

        // Validar antes de enviar
        document.getElementById('registroForm').addEventListener('submit', function(e) {
            const password = passwordInput.value;
            const confirmar = confirmarInput.value;

            if (password !== confirmar) {
                e.preventDefault();
                alert('Las contraseñas no coinciden');
                return false;
            }

            // Verificar todos los requisitos
            for (let key in requirements) {
                if (!requirements[key].regex.test(password)) {
                    e.preventDefault();
                    alert('Por favor, cumple todos los requisitos de seguridad');
                    return false;
                }
            }
        });
    </script>
</body>
</html>