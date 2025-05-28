<?php
include("../../../config/config.php");

// Consulta de todos los usuarios
$sql = "SELECT id_usuario, nombre_completo, rut, correo, rol FROM usuario";
$resultado = $conn->query($sql);
?>
<html lang="es">
  <head>
    <meta charset="UTF-8">
    <meta name="description" content="Ejemplo de HRML5">
    <meta name="keywords" content="HTML5, CSS3, JavaScript">
    <meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="/SIPC/estaticos/css/bootstrap.min.css">
	
<!-- Incluye los archivos de Bootstrap (si no lo has hecho aún) -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<!-- Asegúrate de que jQuery también esté incluido -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<title>Listado de usuarios</title>
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

		.table {
			color: white;
			background-color: white;
		}
		
		btn {
            width: 100%;
            padding: 10px;
            background-color: #808080;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
        }

        btn:hover {
            background-color: #C0C0C0;
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

<div class="container mt-5">
  <h2 class="mb-4">Listado de Usuarios</h2>
  
  </br></br>
  
  <table class="table table-bordered table-hover shadow">
    <thead class="table-dark">
      <tr>
        <th>ID</th>
        <th>Nombre completo</th>
        <th>RUT</th>
        <th>Correo</th>
        <th>Rol</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>
      <?php while ($fila = $resultado->fetch_assoc()): ?>
      <tr>
        <td><?= $fila['id_usuario'] ?></td>
        <td><?= htmlspecialchars($fila['nombre_completo']) ?></td>
        <td><?= htmlspecialchars($fila['rut']) ?></td>
        <td><?= htmlspecialchars($fila['correo']) ?></td>
        <td><?= htmlspecialchars($fila['rol']) ?></td>
        <td>
          <a href="modificar_usuario.php?id_usuario=<?= $fila['id_usuario'] ?>" class="btn btn-sm btn-primary">
            Modificar
          </a>
        </td>
      </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>

</br></br></br>

<footer>
    &copy; 2025 Sistema Integrado de Prevención de Crímenes (SIPC) - Todos los derechos reservados.
</footer>

</body>
</html>