<?php
// Conectar a la base de datos
require_once("../../../../config/config.php"); 

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
            background-color: #dcdcdc;
            color: black;
            text-align: center;
            margin-top: 0;
        } 
				
		.dropdown-menu {
			background-color: #0033A0;
		  }

		  .dropdown-item:hover {
			background-color: #FFCC00;
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
			background-color: #FFCC00;
			color: black;
			text-align: right;
			font-weight: bold;
			border: none;
			display: right;
			margin: 0 auto;
			padding: 10px 20px;
		  }

		.btn:hover {
			background-color: #E6E6E6;
            color: black;
		  }
		
		footer {
            background-color: #FFCC00;
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

<nav class="navbar navbar-expand-lg" style="background-color: #0033A0;">
  <div class="container-fluid">
    <div class="logo-container" style="margin-right: 40px;">
        <img src="/SIPC/estaticos/img/pdi.jpg" alt="PDI" width="120">
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


</br></br></br></br>
<footer>
    &copy; 2025 Sistema Integrado de Prevención de Crímenes (SIPC) - Todos los derechos reservados.
</footer>

</body>
</html>