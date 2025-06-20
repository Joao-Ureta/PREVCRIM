<?php
require_once("../../../../config/config.php"); 

// Consulta para obtener las víctimas y los delitos vinculados
$query = "SELECT v.id_victima, v.rut, v.nombres, v.apellidos, v.edad, v.sexo, v.nacionalidad, v.direccion, v.telefono, 
                 d.id_delito, d.fecha, td.nombre_tipo AS tipo_delito
          FROM victima v
          LEFT JOIN delito_victima dv ON v.id_victima = dv.id_victima
          LEFT JOIN delito d ON dv.id_delito = d.id_delito
          LEFT JOIN tipo_delito td ON d.id_tipo_delito = td.id_tipo_delito
          ORDER BY v.apellidos, v.nombres";

$resultado = mysqli_query($conn, $query);

if (!$resultado) {
    die('Error en la consulta: ' . mysqli_error($conn));
}

?>


<!DOCTYPE html>
<html lang="es">
<head>

<meta charset="UTF-8">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
        <title>Listado de Víctimas</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">

	<style>
	body {
            font-family: Arial, sans-serif;
            background: #D0D0D0;
            color: black;
            text-align: center;
            margin-top: 0;
        } 
				
		.dropdown-menu {
			background: #C0C0C0;
		  }

		  .dropdown-item:hover {
			background-color: #A9A9A9;
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
            background: #C0C0C0;
            color: black;
            padding: 10px;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
		</style>
</head>
<body>

<nav class="navbar navbar-expand-lg" style="background-color: #C0C0C0;">
  <div class="container-fluid">
    <div class="logo-container" style="margin-right: 40px;">
        <img src="/SIPC/estaticos/img/paz_ciudadana.jpg" alt="Paz Ciudadana" width="120">
		<a class="navbar-brand" href="admin_pc.php">Administrador</a>
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
            <li><a class="dropdown-item" href="lista_usuarios.php">Listado de usuarios</a></li>
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

<div class="container mt-5">
    <h2>Listado de Víctimas Registradas</h2>
    <table class="table">
    <thead>
        <tr>
            <th>Rut</th>
            <th>Nombre</th>
            <th>Apellidos</th>
            <th>Edad</th>
            <th>Sexo</th>
            <th>Nacionalidad</th>
            <th>Dirección</th>
            <th>Teléfono</th>
            <th>Delito Asociado</th>
            <th>Fecha Delito</th>
            <th>Tipo de Delito</th>
        </tr>
    </thead>
    <tbody>
        <?php while($fila = mysqli_fetch_assoc($resultado)) { ?>
            <tr>
                <td><?php echo $fila['rut']; ?></td>
                <td><?php echo $fila['nombres']; ?></td>
                <td><?php echo $fila['apellidos']; ?></td>
                <td><?php echo $fila['edad']; ?></td>
                <td><?php echo $fila['sexo']; ?></td>
                <td><?php echo $fila['nacionalidad']; ?></td>
                <td><?php echo $fila['direccion']; ?></td>
                <td><?php echo $fila['telefono']; ?></td>
                <td>
                    <?php 
                        if ($fila['id_delito']) {
                            echo "Delito #" . $fila['id_delito'];
                        } else {
                            echo "No vinculado";
                        }
                    ?>
                </td>
                <td><?php echo $fila['fecha']; ?></td>
                <td><?php echo $fila['tipo_delito']; ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>
</div>
</body>
</html>