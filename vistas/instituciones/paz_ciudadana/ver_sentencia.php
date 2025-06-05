<!-- PESTAÑA VER SENTENCIAS DE JEFE ZONA PAZ CIUDADANA -->
 <?php
// Conectar a la base de datos
include_once($_SERVER['DOCUMENT_ROOT'] . '/SIPC/config/config.php');

// Comprobar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Variables para los filtros
$fecha_sentencia = isset($_POST['fecha_sentencia']) ? $_POST['fecha_sentencia'] : '';
$delincuente = isset($_POST['delincuente']) ? $_POST['delincuente'] : '';
$tribunal = isset($_POST['tribunal']) ? $_POST['tribunal'] : '';

// Consulta SQL para obtener la información de las sentencias con filtros
$sql = "
    SELECT 
        s.id_sentencia, 
        s.fecha_sentencia, 
        s.condena, 
        d.fecha AS fecha_delito, 
        td.nombre_tipo AS tipo_delito, 
        CONCAT(d1.nombre_completo, ' (', d1.rut, ')') AS delincuente,
        t.nombre AS tribunal
    FROM sentencia s
    JOIN delincuente d1 ON s.id_delincuente = d1.id_delincuente
    JOIN delito d ON s.id_delito = d.id_delito
    JOIN tipo_delito td ON d.id_tipo_delito = td.id_tipo_delito
    JOIN tribunales t ON s.id_tribunal = t.id_tribunal
    WHERE 1=1
";

// Filtrar por fecha de sentencia
if ($fecha_sentencia) {
    $sql .= " AND s.fecha_sentencia = '$fecha_sentencia'";
}

// Filtrar por delincuente
if ($delincuente) {
    $sql .= " AND CONCAT(d1.nombre_completo, ' ', d1.rut) LIKE '%$delincuente%'";
}

// Filtrar por tribunal
if ($tribunal) {
    $sql .= " AND t.id_tribunal = '$tribunal'";
}

// Ejecutar la consulta
$result = $conn->query($sql);

// Almacenar los resultados
$sentencias = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $sentencias[] = $row;
    }
} 

// Obtener los tribunales para el filtro
$tribunales_result = $conn->query("SELECT id_tribunal, nombre FROM tribunales");
$tribunales = [];
if ($tribunales_result->num_rows > 0) {
    while($row = $tribunales_result->fetch_assoc()) {
        $tribunales[] = $row;
    }
}

// Cerrar la conexión
$conn->close();
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
            background: #D0D0D0;
            color: black;
            text-align: center;
            margin-top: 0;
        } 
				
		.dropdown-menu {
			background-color: #C0C0C0;
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
		  
		 .btn {
			background-color: #808080;
			color: white;
			text-align: right;
			font-weight: bold;
			border: none;
			display: right;
			margin: 0 auto;
			padding: 10px 20px;
		  }

		.btn:hover {
			background-color: #D3D3D3;  
            color: black;
		  }
		
		footer {
            background-color: #C0C0C0;
            color: black;
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

    <div class="container mt-4">
        <h2 class="mb-4">Detalles de Sentencias</h2>
		
		<!-- Formulario de filtros -->
        <form method="POST" class="mb-4">
            <div class="row">
                <div class="col-md-3">
                    <label for="fecha_sentencia" class="form-label">Fecha Sentencia</label>
                    <input type="date" name="fecha_sentencia" id="fecha_sentencia" class="form-control" value="<?= htmlspecialchars($fecha_sentencia) ?>">
                </div>
                <div class="col-md-3">
                    <label for="delincuente" class="form-label">Delincuente</label>
                    <input type="text" name="delincuente" id="delincuente" class="form-control" placeholder="Nombre o Rut" value="<?= htmlspecialchars($delincuente) ?>">
                </div>
                <div class="col-md-3">
                    <label for="tribunal" class="form-label">Tribunal</label>
                    <select name="tribunal" id="tribunal" class="form-control">
                        <option value="">Seleccione un Tribunal</option>
                        <?php foreach ($tribunales as $tribunal_option): ?>
                            <option value="<?= htmlspecialchars($tribunal_option['id_tribunal']) ?>" 
                                <?= ($tribunal == $tribunal_option['id_tribunal']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($tribunal_option['nombre']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary">Filtrar</button>
                </div>
            </div>
        </form>
		
        <table class="table table-striped table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>ID Sentencia</th>
                    <th>Fecha Sentencia</th>
                    <th>Condena</th>
                    <th>Delito (Fecha y Tipo)</th>
                    <th>Delincuente</th>
                    <th>Tribunal</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($sentencias)): ?>
                    <?php foreach($sentencias as $row): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['id_sentencia']) ?></td>
                            <td><?= htmlspecialchars($row['fecha_sentencia']) ?></td>
                            <td><?= htmlspecialchars($row['condena']) ?></td>
                            <td><?= htmlspecialchars($row['fecha_delito']) ?> - <?= htmlspecialchars($row['tipo_delito']) ?></td>
                            <td><?= htmlspecialchars($row['delincuente']) ?></td>
                            <td><?= htmlspecialchars($row['tribunal']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center">No se encontraron sentencias registradas.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
	
	<form method="POST" action="reporte_pdf_sentencias.php" target="_blank">
        <input type="hidden" name="fecha_sentencia" value="<?= htmlspecialchars($fecha_sentencia) ?>">
        <input type="hidden" name="delincuente" value="<?= htmlspecialchars($delincuente) ?>">
        <input type="hidden" name="tribunal" value="<?= htmlspecialchars($tribunal) ?>">
        <button type="submit" class="btn btn-danger mb-3">Generar Reporte PDF</button>
    </form>


</br></br></br></br>
<footer>
    &copy; 2025 Sistema Integrado de Prevención de Crímenes (SIPC) - Todos los derechos reservados.
</footer>

</body>
</html>