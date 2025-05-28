<?php
require_once("../../../../config/config.php"); 

// Inicializar condiciones
$condiciones = [];
$params = [];

// Filtro por fecha (desde el GET)
if (!empty($_GET['fecha'])) {
    $condiciones[] = "c.fecha = ?";
    $params[] = $_GET['fecha'];
}

// Filtro por tipo de control (desde el GET)
if (!empty($_GET['tipo_control'])) {
    $condiciones[] = "c.tipo_control = ?";
    $params[] = $_GET['tipo_control'];
}

// Construir cláusula WHERE si hay condiciones
$where = '';
if (!empty($condiciones)) {
    $where = "WHERE " . implode(" AND ", $condiciones);
}

// Consulta SQL con posibles filtros
$sql = "SELECT 
            c.id_control,
            c.fecha,
            c.hora,
            c.lugar_control,
            c.tipo_control,
            c.resultado,
            c.observaciones,
            u.nombre_completo AS nombre_usuario,
            s.nombre_sector AS nombre_sector,
            d.nombre_completo AS nombre_delincuente,
            i.nombre_institucion AS nombre_institucion,
            c.latitud,
            c.longitud
        FROM control c
        INNER JOIN usuario u ON c.id_usuario = u.id_usuario
        LEFT JOIN sector s ON c.id_sector = s.id_sector
        LEFT JOIN delincuente d ON c.id_delincuente = d.id_delincuente
        LEFT JOIN institucion i ON c.id_institucion = i.id_institucion
        $where
        ORDER BY c.fecha DESC, c.hora DESC";

// Preparar consulta segura
$stmt = $conn->prepare($sql);

// Enlazar parámetros si los hay
if (!empty($params)) {
    $types = str_repeat("s", count($params)); // todos los parámetros como string
    $stmt->bind_param($types, ...$params);
}

// Ejecutar y obtener resultados
$stmt->execute();
$result = $stmt->get_result();

// Cargar resultados en un array
$controles = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $controles[] = $row;
    }
}
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
        <title>Listado de controles</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
	<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<style>

body {
            font-family: Arial, sans-serif;
            background-color: #2E8B57;
            color: white;
            text-align: center;
            margin-top: 0;
        } 
				
		.dropdown-menu {
			background-color: #0b6623;
		  }

		  .dropdown-item:hover {
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
		  
		 .btn {
			background-color: #0b6623;
			color: white;
			text-align: right;
			font-weight: bold;
			border: none;
			display: right;
			margin: 0 auto;
			padding: 10px 20px;
		  }

		.btn:hover {
			background-color: #00FF7F;
		  }
		
		footer {
            background-color: #0b6623;
            color: white;
            padding: 10px;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
		
        #map {
            height: 500px;
            margin-top: 30px;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg" style="background-color: #0b6623;">
  <div class="container-fluid">
    <div class="logo-container" style="margin-right: 40px;">
        <img src="/SIPC/estaticos/img/carabineros.png" alt="Carabineros de Chile" width="120">
		<a class="navbar-brand" href="operador.php">Operador</a>
    </div>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">

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
    <h2 class="mb-4 text-center">Lista de Controles</h2>

    <div class="mb-3 text-end">
		<form method="GET" class="row g-3 justify-content-center mb-4">
			<div class="col-md-3">
				<label for="fecha" class="form-label">Filtrar por Fecha</label>
				<input type="date" class="form-control" name="fecha" id="fecha" value="<?= htmlspecialchars($_GET['fecha'] ?? '') ?>">
			</div>
			<div class="col-md-3">
				<label for="tipo_control" class="form-label">Tipo de Control</label>
				<select class="form-select" name="tipo_control" id="tipo_control">
					<option value="">Todos</option>
					<option value="Identidad" <?= (($_GET['tipo_control'] ?? '') == 'Identidad') ? 'selected' : '' ?>>Control de identidad</option>
					<option value="Vehicular" <?= (($_GET['tipo_control'] ?? '') == 'Vehicular') ? 'selected' : '' ?>>Control vehicular</option>
					<option value="Patrullaje" <?= (($_GET['tipo_control'] ?? '') == 'Patrullaje') ? 'selected' : '' ?>>Control de patrullaje</option>
					<option value="Otro" <?= (($_GET['tipo_control'] ?? '') == 'Otro') ? 'selected' : '' ?>>Otro</option>
					<!-- Agrega más tipos según tus datos -->
				</select>
			</div>
			<div class="col-md-2 align-self-end">
				<button type="submit" class="btn btn-success w-100">Filtrar</button>
			</div>
		</form>

        <a href="form_registrar_control.php" class="btn btn-success">Registrar Nuevo Control</a>
    </div>
	
    <table class="table table-striped table-bordered">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Fecha</th>
                <th>Hora</th>
                <th>Lugar</th>
                <th>Tipo de Control</th>
                <th>Resultado</th>
                <th>Observaciones</th>
                <th>Usuario</th>
				<th>Institucion</th>
                <th>Sector</th>
                <th>Delincuente</th>
                <th>Latitud</th>
                <th>Longitud</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($controles)): ?>
                <?php foreach($controles as $row): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['id_control']) ?></td>
                        <td><?= htmlspecialchars($row['fecha']) ?></td>
                        <td><?= htmlspecialchars($row['hora']) ?></td>
                        <td><?= htmlspecialchars($row['lugar_control']) ?></td>
                        <td><?= htmlspecialchars($row['tipo_control']) ?></td>
                        <td><?= htmlspecialchars($row['resultado']) ?></td>
                        <td><?= htmlspecialchars($row['observaciones']) ?></td>
                        <td><?= htmlspecialchars($row['nombre_usuario']) ?></td>
						<td><?= htmlspecialchars($row['nombre_institucion']) ?></td>
                        <td><?= htmlspecialchars($row['nombre_sector'] ?? 'No asignado') ?></td>
                        <td><?= htmlspecialchars($row['nombre_delincuente'] ?? 'No asignado') ?></td>
                        <td><?= htmlspecialchars($row['latitud']) ?></td>
                        <td><?= htmlspecialchars($row['longitud']) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="12" class="text-center">No se encontraron controles registrados.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- Mapa -->
    <h3 class="mt-5 text-center">Ubicación de los Controles</h3>
    <div id="map"></div>
</div>

<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<script>
// Inicializar mapa centrado en una ubicación inicial
var map = L.map('map').setView([-33.45, -70.6667], 10); // Cambia las coordenadas a tu ciudad si quieres

// Cargar capa de mapa base
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '© OpenStreetMap contributors'
}).addTo(map);

// Controles traídos desde PHP
var controles = <?php echo json_encode($controles); ?>;

// Agregar marcadores
controles.forEach(function(control) {
    if (control.latitud && control.longitud) {
        var marker = L.marker([control.latitud, control.longitud]).addTo(map);
        marker.bindPopup(
            "<strong>Lugar:</strong> " + control.lugar_control + "<br>" +
            "<strong>Tipo:</strong> " + control.tipo_control + "<br>" +
            "<strong>Usuario:</strong> " + control.nombre_usuario + "<br>" +
            "<strong>Resultado:</strong> " + control.resultado
        );
    }
});
</script>

</br></br></br></br>
<footer>
    &copy; 2025 Sistema Integrado de Prevención de Crímenes (SIPC) - Todos los derechos reservados.
</footer>

</body>
</html>
