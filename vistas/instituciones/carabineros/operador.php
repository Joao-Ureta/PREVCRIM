<?php
session_start();
if ($_SESSION['rol'] != 'Operador') {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel Operador - Carabineros de Chile</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #2E8B57; }

        header {
            background-color: #0b6623;
            color: white;
            padding: 20px;
            text-align: center;
        }
		
        nav {
            background-color: #3CB371;
            overflow: hidden;
        }

        nav ul {
            list-style-type: none;
            display: flex;
        }

        nav ul li {
            position: relative;
        }

        nav ul li a {
            display: block;
            color: white;
            padding: 14px 20px;
            text-decoration: none;
        }

        nav ul li:hover {
            background-color: #00FF7F;
        }

        nav ul li ul {
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            background-color: #006fa6;
            min-width: 200px;
            z-index: 1;
        }

        nav ul li:hover ul {
            display: block;
        }

        nav ul li ul li a {
            padding: 12px 16px;
        }

        .contenido {
            padding: 20px;
        }

        .bienvenida {
            background: white;
            padding: 20px;
            border-radius: 6px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>

<header>
<img src="/SIPC/estaticos/img/carabineros.png" alt="Carabineros de Chile" width="120">
    <h1>Panel del Usuario Operador</h1>
    <h3>Carabineros de Chile</h3>
</header>

<nav>
    <ul>
        <li><a href="#">Delincuentes</a>
            <ul>
                <li><a href="#">Ingresar Delincuente</a></li>
                <li><a href="#">Ver Delincuentes</a></li>
            </ul>
        </li>
        <li><a href="#">Delitos</a>
            <ul>
                <li><a href="#">Registrar Delito</a></li>
                <li><a href="#">Listado de Delitos</a></li>
            </ul>
        </li>
        <li><a href="#">Controles</a>
            <ul>
                <li><a href="#">Agregar Control</a></li>
                <li><a href="#">Historial de Controles</a></li>
            </ul>
        </li>
        <li><a href="#">Antecedentes</a>
            <ul>
                <li><a href="#">Ingresar Antecedente</a></li>
                <li><a href="#">Ver Antecedentes</a></li>
            </ul>
        </li>
        <li><a href="/SIPC/public/logout.php" style="color: white;">Cerrar sesión</a></li>
    </ul>
</nav>
<div class="contenido">
    <div class="bienvenida">
        <h2>Bienvenido Operador</h2>
        <p>Desde este panel podrá ingresar y consultar información relativa a delincuentes, delitos, controles y antecedentes.</p>
        <p>Recuerde validar correctamente todos los datos antes de ingresarlos al sistema.</p>
    </div>
</div>

</body>
</html>
