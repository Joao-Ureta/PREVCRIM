<?php
// Incluir la configuración de la base de datos
include('../config/config.php');

// Iniciar la sesión
session_start();

// Variable para almacenar mensajes de error
$error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $correo = trim($_POST['correo']);
    $contrasena = trim($_POST['contrasena']);

    if (empty($correo) || empty($contrasena)) {
        $error = "⚠️ Por favor, ingrese todos los campos.";
    } else {
        $sql = "SELECT * FROM usuario WHERE correo = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $correo);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $usuario = $result->fetch_assoc();
            if (password_verify($contrasena, $usuario['contrasena'])) {
                $_SESSION['id_usuario'] = $usuario['id_usuario'];
                $_SESSION['rol'] = $usuario['rol'];
                $_SESSION['id_institucion'] = $usuario['id_institucion'];

                // ✅ Registrar en bitácora
                $actividad = "Inicio de sesión exitoso";
                $id_usuario = $usuario['id_usuario'];

                $sqlBitacora = "INSERT INTO bitacora_accesos (id_usuario, actividad) VALUES (?, ?)";
                $stmtBitacora = $conn->prepare($sqlBitacora);
                $stmtBitacora->bind_param("is", $id_usuario, $actividad);
                $stmtBitacora->execute();

                // Verificar si la institución es "Carabineros"
$institucion_carabineros = 1; // Asegúrate de que este ID corresponde a "Carabineros"

switch ($_SESSION['rol']) {
    case 'Administrador':
        if ($_SESSION['id_institucion'] == $institucion_carabineros) {
            header('Location: http://localhost/SIPC/vistas/instituciones/carabineros/admin/admin.php');
            exit();
        } else {
            $error = "❌ No tienes permiso para acceder a esta sección.";
        }
        break;

    case 'JefeZona':
        if ($_SESSION['id_institucion'] == $institucion_carabineros) {
            header('Location: http://localhost/SIPC/vistas/instituciones/carabineros/jefe_zona.php');
            exit();
        } else {
            $error = "❌ No tienes permiso para acceder a esta sección.";
        }
        break;

    case 'Operador':
        if ($_SESSION['id_institucion'] == $institucion_carabineros) {
            header('Location: http://localhost/SIPC/vistas/instituciones/carabineros/operador/operador.php');
            exit();
        } else {
            $error = "❌ No tienes permiso para acceder a esta sección.";
        }
        break;

    default:
        $error = "⚠️ Rol no válido.";
}

            } else {
                $error = "❌ Contraseña incorrecta.";
            }
        } else {
            $error = "❌ Correo no registrado.";
        }
    }
}
?>


<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="Ejemplo de HTML5">
    <meta name="keywords" content="HTML5, CSS3, JavaScript">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/docs.css" rel="stylesheet"> 
    <script src="js/bootstrap.bundle.min.js"></script> 
    <title>Login - Carabineros de Chile</title>
	
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #0b6623;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .title {
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            color: white;
            margin-bottom: 20px;
        }

        .login-container {
			background: linear-gradient(45deg, #0b6623, #0d8a2b, #13a43c);
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
            width: 100%;
            max-width: 500px;
            display: flex;
            align-items: center;
        }

        .logo-container {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 10px;
        }

        .logo-container img {
            width: 120px;
            height: auto;
        }

        .login-form {
            padding: 30px;
            width: 100%;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: white;
        }

        label {
            display: block;
            margin: 10px 0 5px;
            color: white;
        }

        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 2px solid #ccc;
            border-radius: 4px;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #0b6623;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background-color: #228B22;
        }

        .error-message {
            background-color: #ffdddd;
            color: #d8000c;
            padding: 10px;
            border-left: 5px solid #d8000c;
            margin-bottom: 15px;
            font-weight: bold;
            text-align: center;
            border-radius: 5px;
        }

        .help-link a, .return-link a {
            color: white;
            text-decoration: none;
        }

        .help-link a:hover, .return-link a:hover {
            text-decoration: underline;
        }

        .help-link, .return-link {
            text-align: center;
            margin-top: 10px;
        }
		
		footer {
            background: linear-gradient(45deg, #0b6623, #0d8a2b, #13a43c);
			text-align: center;
            color: white;
            padding: 10px;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>
<body>

    <!-- Título del sistema -->
    <div class="title">Sistema SIPC - Carabineros de Chile</div>
	</br></br>
    <div class="login-container">
        <div class="logo-container">
            <img src="/SIPC/estaticos/img/carabineros.png" alt="Carabineros de Chile">
        </div>
        <div class="login-form">
            <h2>Inicio de Sesión</h2>

            <!-- Mostrar mensaje de error si existe -->
            <?php if (!empty($error)): ?>
                <div class="error-message"><?php echo $error; ?></div>
            <?php endif; ?>

            <form method="POST" action="">
                <label for="correo">Correo electrónico</label>
                <input type="email" name="correo" required>

                <label for="contrasena">Contraseña</label>
                <input type="password" name="contrasena" required>

                <button type="submit">Iniciar sesión</button>

                <div class="help-link">
                    <a href="../vistas/instituciones/carabineros/ayuda.php">¿Necesitas ayuda?</a>
                </div>
                <div class="return-link">
                    <a href="../public/index.php">Volver a inicio</a>
                </div>
            </form>
        </div>
    </div>
	
	<footer>
    &copy; 2025 Sistema Integrado de Prevención de Crímenes (SIPC) - Todos los derechos reservados.
	</footer>

</body>
</html>
