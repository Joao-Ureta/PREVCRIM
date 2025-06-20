<!-- PESTAÑA REGISTRAR CONTROL ADMIN PAZ CIUDADANA -->

<?php
// Conexión a la base de datos
require_once("../../../../config/config.php"); 
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Consultas
$delincuentes = $conn->query("SELECT id_delincuente, nombre_completo FROM delincuente");
$usuarios = $conn->query("SELECT id_usuario, nombre_completo FROM usuario");
$sectores = $conn->query("SELECT id_sector, nombre_sector FROM sector");
$instituciones = $conn->query("SELECT id_institucion, nombre_institucion FROM institucion");
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <title>Registrar Víctima</title>
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
    <h2 class="mb-4 text-center">Registrar Nuevo Control</h2>

    <form action="../../../../controladores/guardar_control_pc.php" method="POST" class="bg-white p-4 rounded shadow">
	
	<?php
		$hoy = date('Y-m-d');
	?>

        <div class="mb-3">
			<label for="fecha" class="form-label">Fecha del Control</label>
			<input type="date" name="fecha" class="form-control" max="<?= date('Y-m-d') ?>" required>
		</div>


        <div class="mb-3">
            <label for="hora" class="form-label">Hora del Control:</label>
            <input type="time" id="hora" name="hora" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="lugar_control" class="form-label">Lugar del Control:</label>
            <input type="text" id="lugar_control" name="lugar_control" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="tipo_control" class="form-label">Tipo de Control:</label>
            <select id="tipo_control" name="tipo_control" class="form-select" required>
                <option value="Identidad">Identidad</option>
                <option value="Vehicular">Vehicular</option>
                <option value="Patrullaje">Patrullaje</option>
                <option value="Otro">Otro</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="resultado" class="form-label">Resultado del Control:</label>
            <select id="resultado" name="resultado" class="form-select" required>
                <option value="Sin novedad">Sin novedad</option>
                <option value="Detenido">Detenido</option>
                <option value="Incautación">Incautación</option>
                <option value="Multa">Multa</option>
                <option value="Otro">Otro</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="observaciones" class="form-label">Observaciones:</label>
            <textarea id="observaciones" name="observaciones" rows="4" class="form-control"></textarea>
        </div>

        <div class="mb-3">
            <label for="id_delincuente" class="form-label">Delincuente (opcional):</label>
            <select id="id_delincuente" name="id_delincuente" class="form-select">
                <option value="">Seleccione un delincuente</option>
                <?php while($row = $delincuentes->fetch_assoc()): ?>
                    <option value="<?= $row['id_delincuente'] ?>"><?= htmlspecialchars($row['nombre_completo']) ?></option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="id_usuario" class="form-label">Usuario (quien registra el control):</label>
            <select id="id_usuario" name="id_usuario" class="form-select" required>
                <option value="">Seleccione un usuario</option>
                <?php while($row = $usuarios->fetch_assoc()): ?>
                    <option value="<?= $row['id_usuario'] ?>"><?= htmlspecialchars($row['nombre_completo']) ?></option>
                <?php endwhile; ?>
            </select>
        </div>

		<div class="mb-3">
			<label for="id_institucion" class="form-label">Institución:</label>
			<select id="id_institucion" name="id_institucion" class="form-select" required>
				<option value="3" selected>Paz Ciudadana</option>
			</select>
		</div>

        <div class="mb-3">
            <label for="id_sector" class="form-label">Sector (opcional):</label>
            <select id="id_sector" name="id_sector" class="form-select">
                <option value="">Seleccione un sector</option>
                <?php while($row = $sectores->fetch_assoc()): ?>
                    <option value="<?= $row['id_sector'] ?>"><?= htmlspecialchars($row['nombre_sector']) ?></option>
                <?php endwhile; ?>
            </select>
        </div>
		
		<div class="mb-3">
			<label class="form-label">Ubicación en el Mapa (click para seleccionar):</label>
			<div id="map" style="height: 400px; width: 100%;"></div>
		</div>


        <div class="mb-3">
            <label for="latitud" class="form-label">Latitud:</label>
            <input type="text" id="latitud" name="latitud" class="form-control">
        </div>

        <div class="mb-3">
            <label for="longitud" class="form-label">Longitud:</label>
            <input type="text" id="longitud" name="longitud" class="form-control">
        </div>

        <div class="d-grid gap-2">
            <button type="submit" class="btn btn-primary">Guardar Control</button>
        </div>

    </form>
</div>

<script>
let map;
let marker;

function initMap() {
    const centroInicial = { lat: -33.4489, lng: -70.6693 }; // Santiago, Chile como centro inicial

    map = new google.maps.Map(document.getElementById("map"), {
        center: centroInicial,
        zoom: 12,
    });

    map.addListener("click", (e) => {
        placeMarkerAndPanTo(e.latLng, map);
    });
}

function placeMarkerAndPanTo(latLng, map) {
    if (marker) {
        marker.setPosition(latLng);
    } else {
        marker = new google.maps.Marker({
            position: latLng,
            map: map,
        });
    }

    map.panTo(latLng);

    // Setear valores en los campos de texto
    document.getElementById("latitud").value = latLng.lat();
    document.getElementById("longitud").value = latLng.lng();
}
</script>

<script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA3wzdatwG0njMap89LqBnbWdGFfd73Vsk&callback=initMap">
</script>

</br></br></br></br>
<footer>
    &copy; 2025 Sistema Integrado de Prevención de Crímenes (SIPC) - Todos los derechos reservados.
</footer>

</body>
</html>


