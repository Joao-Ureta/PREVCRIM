<!-- PESTAÑA ELIMINAR USUARIO DE JEFE ZONA PAZ CIUDADANA -->
<?php
include("../../../config/config.php");

$datosUsuario = null;
$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["rut_buscar"])) {
    $rut = $_POST["rut_buscar"];

    $consulta = $conn->prepare("
        SELECT u.nombre_completo, u.rut, u.correo, u.rol, i.nombre_institucion 
        FROM usuario u
        LEFT JOIN institucion i ON u.id_institucion = i.id_institucion
        WHERE u.rut = ?
    ");
    $consulta->bind_param("s", $rut);
    $consulta->execute();
    $resultado = $consulta->get_result();

    if ($resultado->num_rows > 0) {
        $datosUsuario = $resultado->fetch_assoc();
    } else {
        $mensaje = "Usuario no encontrado.";
    }

    $consulta->close();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["rut_eliminar"])) {
    $rut = $_POST["rut_eliminar"];

    // Verificar el rol del usuario antes de eliminar
    $verificar = $conn->prepare("SELECT rol FROM usuario WHERE rut = ?");
    $verificar->bind_param("s", $rut);
    $verificar->execute();
    $resultado = $verificar->get_result();

    if ($resultado->num_rows > 0) {
        $usuario = $resultado->fetch_assoc();
        
        // Verificar si el usuario tiene rol AdministradorGeneral o JefeZona
        if ($usuario["rol"] === "AdministradorGeneral" || $usuario["rol"] === "Administrador" || $usuario["rol"] === "JefeZona") {
            $mensaje = "No se puede eliminar a un usuario con rol de Administrador General, Administrador o Jefe Zona.";
        } else {
            // Si no es AdministradorGeneral ni JefeZona, se puede eliminar
            $stmt = $conn->prepare("DELETE FROM usuario WHERE rut = ?");
            $stmt->bind_param("s", $rut);

            if ($stmt->execute()) {
                $mensaje = "Usuario eliminado correctamente.";
            } else {
                $mensaje = "Error al eliminar el usuario.";
            }

            $stmt->close();
        }
    } else {
        $mensaje = "Usuario no encontrado.";
    }

    $verificar->close();
}


?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Eliminar Usuario</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <style>

		 body {
            font-family: Arial, sans-serif;
            background: #D0D0D0;
            color: black;
            text-align: center;
            margin-top: 0;
        } 
        .container {
            display: flex;
			flex-direction: column; /* Asegura que los elementos dentro estén en columna */
			justify-content: center;
			align-items: center;
			text-align: left;
			width: 80%;
			max-width: 800px;
			padding: 80px;
			background-color: #C0C0C0;
			border-radius: 10px;
			box-shadow: 0 10px 20px rgba(0, 0, 0, 0.90); /* Efecto de sombra con relieve */
			margin: 50px auto; /* Centra horizontalmente y añade margen superior/inferior */
        }
		
		  input.form-control {
            border-radius: 6px;
        }
	
		
		.dropdown-menu {
			background-color: #C0C0C0;
		  }

		  .dropdown-item:hover {
			background-color: #A9A9A9;
		  }
		
        label, p {
            font-weight: bold;
            margin-top: 10px;
        }
        .btn-buscar {
            background-color: #808080;
            color: white;
            border: none;
            padding: 10px 15px;
            margin-top: 20px;
            font-weight: bold;
            cursor: pointer;
            border-radius: 5px;
        }
        .btn-buscar:hover {
            background-color: #D3D3D3;
        }
		
		.btn-eliminar {
            background-color: #FF0000;
            color: white;
            border: none;
            padding: 10px 15px;
            margin-top: 20px;
            font-weight: bold;
            cursor: pointer;
            border-radius: 5px;
        }
        .btn-eliminar:hover {
            background-color: #FA8072;
        }
		
		.navbar a,
		  .navbar .nav-link,
		  .navbar .navbar-brand,
		  .navbar .dropdown-toggle,
		  .navbar .dropdown-item,
		  .return-link a,
		  .search-bar button {
			color: black !important;
		  }
		
				footer {
            background-color: #C0C0C0;
            color: black;
            padding: 10px;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg" style="background: #C0C0C0;">
  <div class="container-fluid">
    <div class="logo-container" style="margin-right: 40px;">
        <img src="/SIPC/estaticos/img/paz_ciudadana.jpg" alt="Carabineros de Chile" width="120">
		<a class="navbar-brand" href="jefe_zona.php">JEFE DE ZONA</a>
    </div>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Administracion de usuarios
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="ingresar_usuario.php">Ingresar nuevo usuario</a></li>
            <li><a class="dropdown-item" href="eliminar_usuario.php">Eliminar usuario</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#">Something else here</a></li>
          </ul>
        </li>
		
		<li class="nav-item dropdown">
		  <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
			Reportes
		  </a>
		  <ul class="dropdown-menu">
			<li><a class="dropdown-item" href="reporte_zonas_conflictivas.php">Zonas conflictivas</a></li>
			<li><a class="dropdown-item" href="ubicacion_delincuentes.php">Ubicación de delincuentes</a></li>
			<li><a class="dropdown-item" href="reporte_tipos_delitos.php">Tipos de delitos</a></li>
			<li><a class="dropdown-item" href="ver_controles.php">Controles preventivos</a></li>
			<li><a class="dropdown-item" href="ver_sentencia.php">Reporte de sentencias</a></li>
		  </ul>
		</li>


      </ul>
      <div class="return-link">
			<div>
				<a href="/SIPC/public/logout.php" style="color: white;">Cerrar sesión</a>
			</div> 
	</div>

    </div>
  </div>
</nav>
</br></br>
<div class="container">
    <h2>Eliminar Usuario</h2>

    <?php if ($mensaje): ?>
        <script>alert("<?= $mensaje ?>");</script>
    <?php endif; ?>

    <form method="POST">
        <label for="rut_buscar">Ingrese RUT del usuario:</label>
        <input type="text" name="rut_buscar" required>
        <button class="btn-buscar" type="submit">Buscar</button>
    </form>

    <?php if ($datosUsuario): ?>
        <hr>
        <h3>Datos del Usuario</h3>
        <p>Nombre: <?= $datosUsuario["nombre_completo"] ?></p>
        <p>RUT: <?= $datosUsuario["rut"] ?></p>
        <p>Correo: <?= $datosUsuario["correo"] ?></p>
        <p>Rol: <?= $datosUsuario["rol"] ?></p>
        <p>Institución: <?= $datosUsuario["nombre_institucion"] ?></p>

        <form method="POST" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este usuario?');">
            <input type="hidden" name="rut_eliminar" value="<?= $datosUsuario["rut"] ?>">
            <button class="btn-eliminar" type="submit">Eliminar Usuario</button>
        </form>
    <?php endif; ?>
</div>

<footer>
    &copy; 2025 Sistema Integrado de Prevención de Crímenes (SIPC) - Todos los derechos reservados.
</footer>

</body>
</html>
