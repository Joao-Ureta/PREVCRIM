<!-- PESTAÑA REGISTRAR SENTENCIA ADMIN PAZ CIUDADANA -->

<?php
// Conexión a la base de datos
require_once("../../../../config/config.php"); 
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener delincuentes
$delincuentes = $conn->query("SELECT id_delincuente, nombre_completo, rut FROM delincuente");

// Obtener tribunales
$tribunales = $conn->query("SELECT id_tribunal, nombre FROM tribunales");

// Obtener delitos
$delitos = $conn->query("
    SELECT d.id_delito, td.nombre_tipo, d.fecha 
    FROM delito d
    LEFT JOIN tipo_delito td ON d.id_tipo_delito = td.id_tipo_delito
    ORDER BY d.fecha DESC
");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <title>Registrar Sentencia</title>
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
		  
		  .container{
            background: #C0C0C0;
			color: black;
			font-weight: bold;
            padding: 20px;
			text-align: left;
            max-width: 700px;
            margin: auto;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }
		
		h2 { text-align: center; color: black; }
		
		.btn {
			background-color: #808080;
			color: white;
			font-weight: bold;
			border: none;
			display: block;
			margin: 0 auto;
			padding: 10px 20px;
		  }

		.btn:hover {
			background-color: #D3D3D3;
            color: black;
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
	<h2 class="mb-4 text-center">Registrar Sentencia</h2>
		<form action="../../../../controladores/guardar_sentencia_pc.php" method="POST" class="bg-white p-4 rounded shadow">
			<div class="mb-3">
				<label for="id_delincuente" class="form-label">Delincuente:</label>
				<select id="id_delincuente" name="id_delincuente" class="form-select" required>
					<option value="">Seleccione un delincuente</option>
					<?php while ($d = $delincuentes->fetch_assoc()): ?>
						<option value="<?= $d['id_delincuente'] ?>">
							<?= $d['nombre_completo'] ?> (<?= $d['rut'] ?>)
						</option>
					<?php endwhile; ?>
				</select>
			</div>
			
			<div class="mb-3">
				<label for="id_delito"class="form-label">Delito:</label>
				<select name="id_delito"name="id_delito" class="form-select" required>
					<option value="">Seleccione un delito</option>
					<?php while ($dl = $delitos->fetch_assoc()): ?>
						<option value="<?= $dl['id_delito'] ?>">
							<?= $dl['nombre_tipo'] ?> - <?= $dl['fecha'] ?>
						</option>
					<?php endwhile; ?>
				</select>
			</div>
			
			<div class="mb-3">
				<label for="id_tribunal" class="form-label">Tribunal:</label>
				<select name="id_tribunal" class="form-select" required>
					<option value="">Seleccione un tribunal</option>
					<?php while ($t = $tribunales->fetch_assoc()): ?>
						<option value="<?= $t['id_tribunal'] ?>"><?= $t['nombre'] ?></option>
					<?php endwhile; ?>
				</select>
			</div>

			
			<?php
				$hoy = date('Y-m-d');
			?>
			
			<div class="mb-3">
				<label for="fecha" class="form-label">Fecha de sentencia</label>
				<input type="date" name="fecha" class="form-control" max="<?= date('Y-m-d') ?>" required>
			</div>
			
			<div class="mb-3">
				<label for="condena" class="form-label">Condena impuesta:</label>
				<input type="text" id="condena" name="condena" class="form-control" required>
			</div>
			</br>
			<div class="d-grid gap-2">
				<button type="submit" class="btn btn-primary">Guardar Sentencia</button>
			</div>
		</form>
</div>

<script>
function validarFormulario() {
    const tribunal = document.forms["formSentencia"]["tribunal"].value.trim();
    const condena = document.forms["formSentencia"]["condena"].value.trim();

    if (tribunal === "" || condena === "") {
        alert("Por favor, complete todos los campos obligatorios.");
        return false;
    }
    return true;
}
</script>

</br></br></br></br>
<footer>
    &copy; 2025 Sistema Integrado de Prevención de Crímenes (SIPC) - Todos los derechos reservados.
</footer>

</body>
</html>

