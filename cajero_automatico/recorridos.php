<?php
require_once 'includes/config.php';
require_once 'clases/Nodo.php';
require_once 'clases/ArbolDecision.php';

$arbol = new ArbolDecision();
$arbol->construirArbol();

$preorden = $arbol->recorridoPreorden();
$inorden = $arbol->recorridoInorden();
$postorden = $arbol->recorridoPostorden();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recorridos del Árbol - <?php echo NOMBRE_APP; ?></title>
    <link rel="stylesheet" href="css/estilos.css">
    <style>
        .tree-container {
            background-color: #f8f9fa;
            padding: 30px;
            border-radius: 10px;
            margin: 20px 0;
            overflow-x: auto;
        }

        .tree {
            display: flex;
            justify-content: center;
            margin: 20px 0;
        }

        .tree ul {
            padding-top: 20px;
            position: relative;
            transition: all 0.5s;
            list-style-type: none;
        }

        .tree li {
            float: left;
            text-align: center;
            list-style-type: none;
            position: relative;
            padding: 20px 5px 0 5px;
            transition: all 0.5s;
        }

        .tree li::before,
        .tree li::after {
            content: '';
            position: absolute;
            top: 0;
            right: 50%;
            border-top: 2px solid #667eea;
            width: 50%;
            height: 20px;
        }

        .tree li::after {
            right: auto;
            left: 50%;
            border-left: 2px solid #667eea;
        }

        .tree li:only-child::after,
        .tree li:only-child::before {
            display: none;
        }

        .tree li:only-child {
            padding-top: 0;
        }

        .tree li:first-child::before,
        .tree li:last-child::after {
            border: 0 none;
        }

        .tree li:last-child::before {
            border-right: 2px solid #667eea;
            border-radius: 0 5px 0 0;
        }

        .tree li:first-child::after {
            border-radius: 5px 0 0 0;
        }

        .tree ul ul::before {
            content: '';
            position: absolute;
            top: 0;
            left: 50%;
            border-left: 2px solid #667eea;
            width: 0;
            height: 20px;
        }

        .tree li span {
            border: 2px solid #667eea;
            padding: 10px 15px;
            text-decoration: none;
            color: #333;
            font-family: arial, verdana, tahoma;
            font-size: 13px;
            display: inline-block;
            border-radius: 8px;
            transition: all 0.5s;
            background: white;
            font-weight: 600;
        }

        .tree li span:hover,
        .tree li span:hover + ul li span {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: 2px solid #667eea;
        }

        .explicacion-box {
            background-color: white;
            border-left: 4px solid #667eea;
            padding: 20px;
            margin: 20px 0;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .explicacion-box h4 {
            color: #667eea;
            margin-bottom: 10px;
            font-size: 16px;
        }

        .explicacion-box p {
            color: #555;
            line-height: 1.6;
            margin: 8px 0;
        }

        .explicacion-box strong {
            color: #333;
        }

        .recorrido-box {
            background-color: #fff;
            border: 2px solid #667eea;
            border-radius: 8px;
            padding: 20px;
            margin: 15px 0;
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
        }

        .recorrido-box h3 {
            color: #667eea;
            margin-bottom: 15px;
            font-size: 18px;
        }

        .recorrido-box p {
            color: #555;
            line-height: 1.6;
            font-size: 15px;
        }

        @media (max-width: 768px) {
            .tree li span {
                font-size: 11px;
                padding: 8px 10px;
            }
        }
    </style>
</head>
<body>
    <div class="container" style="max-width: 900px;">
        <h1>Recorridos del Árbol de Decisiones</h1>

        <!-- Visualización del árbol -->
        <div class="tree-container">
            <h2 style="text-align: center; color: #667eea; margin-bottom: 20px;">
                Estructura del Árbol de Decisiones
            </h2>
            <div class="tree">
                <ul>
                    <li>
                        <span>Inicio</span>
                        <ul>
                            <li>
                                <span>Login</span>
                                <ul>
                                    <li>
                                        <span>Menu Principal</span>
                                        <ul>
                                            <li>
                                                <span>Consultar<br>Saldo</span>
                                            </li>
                                            <li>
                                                <span>Operaciones</span>
                                                <ul>
                                                    <li><span>Depositar</span></li>
                                                    <li><span>Retirar</span></li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <span>Registro</span>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Explicaciones de los recorridos -->
        <h2 style="color: #667eea; margin-top: 30px;">¿Qué son los Recorridos?</h2>
        
        <div class="explicacion-box">
            <h4>📖 Recorrido Preorden (Root-Left-Right)</h4>
            <p><strong>Definición:</strong> Visita primero la raíz, luego el subárbol izquierdo y finalmente el subárbol derecho.</p>
            <p><strong>Uso:</strong> Útil para crear una copia del árbol o generar expresiones prefix.</p>
            <p><strong>Orden:</strong> Raíz → Izquierda → Derecha</p>
        </div>

        <div class="explicacion-box">
            <h4>📖 Recorrido Inorden (Left-Root-Right)</h4>
            <p><strong>Definición:</strong> Visita primero el subárbol izquierdo, luego la raíz y finalmente el subárbol derecho.</p>
            <p><strong>Uso:</strong> En árboles binarios de búsqueda, produce los elementos en orden ascendente.</p>
            <p><strong>Orden:</strong> Izquierda → Raíz → Derecha</p>
        </div>

        <div class="explicacion-box">
            <h4>📖 Recorrido Postorden (Left-Right-Root)</h4>
            <p><strong>Definición:</strong> Visita primero el subárbol izquierdo, luego el subárbol derecho y finalmente la raíz.</p>
            <p><strong>Uso:</strong> Útil para eliminar el árbol o evaluar expresiones postfix.</p>
            <p><strong>Orden:</strong> Izquierda → Derecha → Raíz</p>
        </div>

        <!-- Resultados de los recorridos -->
        <h2 style="color: #667eea; margin-top: 30px;">Resultados de los Recorridos</h2>

        <div class="recorrido-box">
            <h3>🔹 Recorrido Preorden</h3>
            <p><?php echo implode(' → ', $preorden); ?></p>
        </div>

        <div class="recorrido-box">
            <h3>🔹 Recorrido Inorden</h3>
            <p><?php echo implode(' → ', $inorden); ?></p>
        </div>

        <div class="recorrido-box">
            <h3>🔹 Recorrido Postorden</h3>
            <p><?php echo implode(' → ', $postorden); ?></p>
        </div>

        <a href="index.php" class="btn">Volver al Inicio</a>
    </div>
</body>
</html>