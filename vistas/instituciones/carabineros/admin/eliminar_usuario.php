<?php
session_start();
include("../../../../config/config.php");

$mensaje = "";
$datosUsuario = null;

$idInstitucionActual = $_SESSION['id_institucion']; // Asegúrate de que esté definido en la sesión

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["rut_buscar"])) {
        $rutBuscar = $_POST["rut_buscar"];

        $sql = "SELECT u.rut, u.nombre_completo, u.correo, u.rol, i.nombre_institucion 
                FROM usuario u
                LEFT JOIN institucion i ON u.id_institucion = i.id_institucion
                WHERE u.rut = '$rutBuscar' AND u.id_institucion = $idInstitucionActual";

        $resultado = $conn->query($sql);

        if ($resultado && $resultado->num_rows > 0) {
            $datosUsuario = $resultado->fetch_assoc();
        } else {
            $mensaje = "No se encontró ningún usuario con ese RUT en tu institución.";
        }
    }

    if (isset($_POST["rut_eliminar"])) {
        $rutEliminar = $_POST["rut_eliminar"];

        // Verificar que el usuario a eliminar pertenece a la misma institución
        $sqlCheck = "SELECT * FROM usuario WHERE rut = '$rutEliminar' AND id_institucion = $idInstitucionActual";
        $resultadoCheck = $conn->query($sqlCheck);

        if ($resultadoCheck && $resultadoCheck->num_rows > 0) {
            $sql = "DELETE FROM usuario WHERE rut = '$rutEliminar' AND id_institucion = $idInstitucionActual";
            if ($conn->query($sql) === TRUE) {
                $mensaje = "Usuario eliminado correctamente.";
                $datosUsuario = null;
            } else {
                $mensaje = "Error al eliminar el usuario: " . $conn->error;
            }
        } else {
            $mensaje = "El usuario no existe en tu institución o no tienes permiso para eliminarlo.";
        }
    }
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
            background-color: #2E8B57;
            color: white;
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
			background-color:#0b6623;
			border-radius: 10px;
			box-shadow: 0 10px 20px rgba(0, 0, 0, 0.90); /* Efecto de sombra con relieve */
			margin: 50px auto; /* Centra horizontalmente y añade margen superior/inferior */
        }
		
		  input.form-control {
    border-radius: 6px;
  }
	
		
		.dropdown-menu {
			background-color: #0b6623;
		  }

		  .dropdown-item:hover {
			background-color: #0e7d2d;
		  }
		
        label, p {
            font-weight: bold;
            margin-top: 10px;
        }
        .btn-buscar {
            background-color: #2E8B57;
            color: white;
            border: none;
            padding: 10px 15px;
            margin-top: 20px;
            font-weight: bold;
            cursor: pointer;
            border-radius: 5px;
        }
        .btn:hover {
            background-color: #00FF7F;
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
            background-color: #00FF7F;
        }
		
		.navbar a,
		  .navbar .nav-link,
		  .navbar .navbar-brand,
		  .navbar .dropdown-toggle,
		  .navbar .dropdown-item,
		  .return-link a,
		  .search-bar button {
			color: white !important;
		  }
		
				footer {
            background-color: #0b6623;
            color: white;
            padding: 10px;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg" style="background-color: #0b6623;">
  <div class="container-fluid">
    <div class="logo-container" style="margin-right: 40px;">
        <img src="/SIPC/estaticos/img/carabineros.png" alt="Carabineros de Chile" width="120">
		<a class="navbar-brand" href="admin.php">Administrador</a>
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

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Delincuentes
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="form_ingresar_delincuente.php">Ingresar delincuente</a></li>
            <li><a class="dropdown-item" href="ver_delincuentes.php">Ver delincuentes</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#">Something else here</a></li>
          </ul>
        </li>
		
		<li class="nav-item dropdown">
		  <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
			Delitos
		  </a>
		  <ul class="dropdown-menu">
			<li><a class="dropdown-item" href="form_registrar_delito.php">Registrar Delitos</a></li>
			<li><a class="dropdown-item" href="ver_delitos.php">Listado de Delitos</a></li>
		  </ul>
		</li>
		
		<li class="nav-item dropdown">
		  <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
			Victimas
		  </a>
		  <ul class="dropdown-menu">
			<li><a class="dropdown-item" href="form_registrar_victima.php">Registrar Victima</a></li>
			<li><a class="dropdown-item" href="ver_victimas.php">Listado de Victimas</a></li>
		  </ul>
		</li>
		
		<li class="nav-item dropdown">
		  <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
			Controles
		  </a>
		  <ul class="dropdown-menu">
			<li><a class="dropdown-item" href="form_registrar_control.php">Agregar Control</a></li>
			<li><a class="dropdown-item" href="ver_controles.php">Historial de Controles</a></li>
		  </ul>
		</li>
		
		<li class="nav-item dropdown">
		  <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
			Sentencias
		  </a>
		  <ul class="dropdown-menu">
			<li><a class="dropdown-item" href="form_registrar_sentencia.php">Ingresar Sentencias</a></li>
			<li><a class="dropdown-item" href="ver_sentencia.php">Ver Sentencias</a></li>
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

    <!-- Formulario de búsqueda -->
    <form method="POST">
        <label for="rut_buscar">Ingrese RUT del usuario:</label>
        <input type="text" id="rut_buscar" name="rut_buscar" required>
        <button type="submit">Buscar</button>
    </form>

    <?php if (!empty($mensaje)): ?>
        <p><strong><?php echo $mensaje; ?></strong></p>
    <?php endif; ?>

    <?php if ($datosUsuario): ?>
        <!-- Mostrar los datos del usuario encontrado -->
        <form method="POST">
            <p>RUT: <?php echo $datosUsuario['rut']; ?></p>
            <p>Nombre: <?php echo $datosUsuario['nombre_completo']; ?></p>
            <p>Correo: <?php echo $datosUsuario['correo']; ?></p>
            <p>Rol: <?php echo $datosUsuario['rol']; ?></p>
            <p>Institución: <?php echo $datosUsuario['nombre_institucion']; ?></p>

            <!-- Campo oculto para saber qué usuario eliminar -->
            <input type="hidden" name="rut_eliminar" value="<?php echo $datosUsuario['rut']; ?>">
            <button type="submit" onclick="return confirm('¿Estás seguro de eliminar este usuario?')">Eliminar Usuario</button>
        </form>
    <?php endif; ?>
</body>
</html>