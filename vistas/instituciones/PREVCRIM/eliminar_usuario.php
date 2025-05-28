<?php
include("../../../config/config.php");

$mensaje = "";

// Función para eliminar un usuario por ID
function eliminarUsuario($idUsuario) {
    global $conn;
    $sql = "DELETE FROM usuario WHERE id_usuario = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $idUsuario); // 'i' para enteros (id_usuario es un entero)
    
    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
}

// Verificar si se ha enviado el ID del usuario a eliminar
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id_usuario"])) {
    $idUsuario = $_POST["id_usuario"];
    
    // Llamar a la función para eliminar el usuario
    if (eliminarUsuario($idUsuario)) {
        $mensaje = "<div class='alert alert-success'>Usuario eliminado correctamente.</div>";
    } else {
        $mensaje = "<div class='alert alert-danger'>Hubo un error al eliminar el usuario.</div>";
    }
}

// Obtener usuarios desde la base de datos para mostrar en un dropdown (si es necesario)
$sqlUsuarios = "SELECT id_usuario, nombre_completo FROM usuario";
$resultadoUsuarios = $conn->query($sqlUsuarios);
?>

<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="Eliminar Usuario">
    <meta name="keywords" content="PHP, MySQL, eliminar usuario">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/SIPC/estaticos/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <title>Eliminación de usuarios</title>
    <style>
                body {
            font-family: Arial, sans-serif;
            background-color: #C0C0C0;
            color: white;
            text-align: center;
            margin-top: 0;
        } 
		
		.dropdown-menu {
			background-color: #A9A9A9;
		  }

		  .dropdown-item:hover {
			background-color: #808080;
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
			background-color:#808080;
			border-radius: 10px;
			box-shadow: 0 10px 20px rgba(0, 0, 0, 0.90); /* Efecto de sombra con relieve */
			margin: 50px auto; /* Centra horizontalmente y añade margen superior/inferior */
        }
		
		small.form-text {
    color: white !important;
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
            background-color: #808080;
            color: white;
            padding: 10px;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
    </style>
	
	<script>
        // Función de confirmación antes de eliminar un usuario
        function confirmarEliminacion() {
            return confirm("¿Estás seguro de que quieres eliminar a este usuario?");
        }
    </script>
	
</head>
<body>
<nav class="navbar navbar-expand-lg" style="background-color: #808080;">
  <div class="container-fluid">
    <div class="logo-container" style="margin-right: 40px;">
        <img src="/SIPC/estaticos/img/logo_prevcrim4.jpg" alt="PREVCRIM" width="120">
		<a class="navbar-brand" href="admin_general.php">Administrador PREVCRIM</a>
    </div>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
	  
		<li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Administracion de usuarios
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="listar_usuarios.php">Lista de usuarios / Modificar</a></li>
            <li><a class="dropdown-item" href="ingresar_usuario.php">Ingresar nuevo usuario</a></li>
            <li><a class="dropdown-item" href="eliminar_usuario.php">Eliminar usuario</a></li>
          </ul>
        </li>
		
				<li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Administracion de instituciones
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="ingresar_institucion.php">Ingresar nueva institucion</a></li>
			      <li><a class="dropdown-item" href="listar_instituciones.php">Listado de instituciones / Modificar-Eliminar</a></li>
          </ul>
        </li>
		
        <li class="nav-item dropdown">
		  <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
			Bitacora de accesos
		  </a>
		  <ul class="dropdown-menu">
			<li><a class="dropdown-item" href="reporte_accesos.php">Registro de accesos</a></li>
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

<div class="container mt-4">
    <h2>Eliminar Usuario</h2>
	</br></br>
    <?= $mensaje ?>
    <form method="POST" onsubmit="return confirmarEliminacion();">
        <div class="mb-3">
            <label class="form-label">Seleccione el usuario a eliminar</label>
            <select name="id_usuario" class="form-select" required>
                <option value="">Seleccione un usuario</option>
                <?php while($row = $resultadoUsuarios->fetch_assoc()): ?>
                    <option value="<?= $row['id_usuario'] ?>"><?= $row['nombre_completo'] ?></option>
                <?php endwhile; ?>
            </select>
        </div>
		</br>
        <button type="submit" class="btn btn-danger">Eliminar Usuario</button>
    </form>
</div>

</br></br>
<footer>
    &copy; 2025 Sistema Integrado de Prevención de Crímenes (SIPC) - Todos los derechos reservados.
</footer>

</body>
</html>
