<?php
include("../../../config/config.php");
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

<title>Listado de instituciones</title>
	
	        <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #C0C0C0;
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
			background-color: #A9A9A9;
		  }

		  .dropdown-item:hover {
			background-color: #808080;
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
            background-color: #1E90FF;
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
		
		.contenido {
            padding: 20px;
        }

        .bienvenida {
            background: white;
			color: black;
            padding: 20px;
            border-radius: 6px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }	
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg" style="background-color: #808080;">
  <div class="container-fluid">
    <div class="logo-container" style="margin-right: 40px;">
        <img src="/SIPC/estaticos/img/logo_prevcrim6.png" alt="PREVCRIM" width="120">
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

<div class="container mt-5" style="background-color: #808080;">
    <h2 class="text-center mb-4">Listado de Instituciones</h2>
    <table class="table table-bordered table-striped table-hover bg-light text-dark">
      <thead class="table-dark">
        <tr>
          <th>ID</th>
          <th>Institución</th>
          <th>Dirección</th>
          <th>Teléfono</th>
          <th>Correo</th>
          <th>Comuna</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $sql = "SELECT i.id_institucion, i.nombre_institucion, i.direccion, i.telefono, i.correo, c.nombre_comuna 
                FROM institucion i
                JOIN comuna c ON i.id_comuna = c.id_comuna";
        $resultado = $conn->query($sql);

        while ($row = $resultado->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['id_institucion']}</td>
                    <td>{$row['nombre_institucion']}</td>
                    <td>{$row['direccion']}</td>
                    <td>{$row['telefono']}</td>
                    <td>{$row['correo']}</td>
                    <td>{$row['nombre_comuna']}</td>
                    <td>
                      <a href='modificar_institucion.php?id={$row['id_institucion']}' class='btn btn-warning btn-sm'>Editar</a>
                      <a href='/SIPC/controladores/eliminar_institucion.php?id={$row['id_institucion']}' class='btn btn-danger btn-sm' onclick=\"return confirm('¿Está seguro que desea eliminar esta institución?');\">Eliminar</a>
                    </td>
                  </tr>";
        }
        ?>
      </tbody>
    </table>
    <a href="ingresar_institucion.php" class="btn btn-primary">Agregar Nueva Institución</a>
  </div>
    </br></br>
<footer>
    &copy; 2025 Sistema Integrado de Prevención de Crímenes (SIPC) - Todos los derechos reservados.
</footer>

</body>
</html>