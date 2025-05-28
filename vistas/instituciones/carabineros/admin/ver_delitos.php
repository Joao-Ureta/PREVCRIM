<!-- PESTAÑA VER DELITOS ADMIN CARABINEROS -->

<?php
// Conexión a la base de datos
require_once("../../../../config/config.php"); 

// Obtener tipos de delito para el select
$tipos_result = $conn->query("SELECT id_tipo_delito, nombre_tipo FROM tipo_delito");

// Filtros (vienen por GET)
$tipoFiltro = isset($_GET['tipo']) ? $_GET['tipo'] : '';
$desde = isset($_GET['desde']) ? $_GET['desde'] : '';
$hasta = isset($_GET['hasta']) ? $_GET['hasta'] : '';

// Construir la cláusula WHERE dinámicamente
$where = "1=1";
if ($tipoFiltro !== '') {
    $where .= " AND d.id_tipo_delito = " . intval($tipoFiltro);
}
if ($desde !== '') {
    $where .= " AND d.fecha >= '" . $conn->real_escape_string($desde) . "'";
}
if ($hasta !== '') {
    $where .= " AND d.fecha <= '" . $conn->real_escape_string($hasta) . "'";
}

// Consulta principal
$sql = "
SELECT 
    d.id_delito,
    d.fecha,
    d.descripcion AS descripcion_delito,
    td.nombre_tipo,
    s.nombre_sector,
    i.nombre_institucion,
    d.latitud,
    d.longitud,

    del.id_delincuente,
    del.nombre_completo AS nombre_delincuente,
    dd.rol_en_el_delito,

    v.id_victima,
    CONCAT(v.nombres, ' ', v.apellidos) AS nombre_victima

FROM delito d
LEFT JOIN tipo_delito td ON d.id_tipo_delito = td.id_tipo_delito
LEFT JOIN sector s ON d.id_sector = s.id_sector
LEFT JOIN institucion i ON d.id_institucion = i.id_institucion
LEFT JOIN delito_delincuente dd ON d.id_delito = dd.id_delito
LEFT JOIN delincuente del ON dd.id_delincuente = del.id_delincuente
LEFT JOIN delito_victima dv ON d.id_delito = dv.id_delito
LEFT JOIN victima v ON dv.id_victima = v.id_victima

WHERE $where
ORDER BY d.fecha DESC;
";

$result = $conn->query($sql);

// Agrupar delitos
$delitos = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $id = $row['id_delito'];
        if (!isset($delitos[$id])) {
            $delitos[$id] = [
                'fecha' => $row['fecha'],
                'tipo' => $row['nombre_tipo'],
                'descripcion' => $row['descripcion_delito'],
                'sector' => $row['nombre_sector'],
                'institucion' => $row['nombre_institucion'],
                'latitud' => $row['latitud'],
                'longitud' => $row['longitud'],
                'delincuentes' => [],
                'victimas' => []
            ];
        }

        if (!empty($row['id_delincuente'])) {
            $delitos[$id]['delincuentes'][] = $row['nombre_delincuente'] . " ({$row['rol_en_el_delito']})";
        }

        if (!empty($row['id_victima'])) {
            $delitos[$id]['victimas'][] = $row['nombre_victima'];
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <title>Ver Delitos</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
	
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

<div class="container mt-5">
    <h2 class="mb-4">Listado de Delitos</h2>

    <!-- Filtros -->
    <form class="row g-3 mb-4" method="GET" action="">
        <div class="col-md-4">
            <label class="form-label">Tipo de delito</label>
            <select class="form-select" name="tipo">
                <option value="">-- Todos --</option>
                <?php while ($tipo = $tipos_result->fetch_assoc()): ?>
                    <option value="<?= $tipo['id_tipo_delito'] ?>" <?= ($tipoFiltro == $tipo['id_tipo_delito']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($tipo['nombre_tipo']) ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="col-md-3">
            <label class="form-label">Desde</label>
            <input type="date" class="form-control" name="desde" value="<?= htmlspecialchars($desde) ?>">
        </div>
        <div class="col-md-3">
            <label class="form-label">Hasta</label>
            <input type="date" class="form-control" name="hasta" value="<?= htmlspecialchars($hasta) ?>">
        </div>
        <div class="col-md-2 d-flex align-items-end">
            <button class="btn btn-primary w-100" type="submit">Filtrar</button>
        </div>
    </form>

    <!-- Tabla -->
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>Fecha</th>
                <th>Tipo de Delito</th>
                <th>Descripción</th>
                <th>Sector</th>
                <th>Institución</th>
                <th>Delincuentes</th>
                <th>Víctimas</th>
                <th>Coordenadas</th>
            </tr>
        </thead>
        <tbody>
        <?php if (empty($delitos)): ?>
            <tr>
                <td colspan="9" class="text-center">No se encontraron delitos con los filtros seleccionados.</td>
            </tr>
        <?php else: ?>
            <?php foreach ($delitos as $delito): ?>
                <tr>
                    <td><?= htmlspecialchars($delito['fecha']) ?></td>
                    <td><?= htmlspecialchars($delito['tipo']) ?></td>
                    <td><?= htmlspecialchars($delito['descripcion']) ?></td>
                    <td><?= htmlspecialchars($delito['sector']) ?></td>
                    <td><?= htmlspecialchars($delito['institucion']) ?></td>
                    <td><?= implode('<br>', array_unique($delito['delincuentes'])) ?></td>
                    <td><?= implode('<br>', array_unique($delito['victimas'])) ?></td>
                    <td><?= $delito['latitud'] ?>, <?= $delito['longitud'] ?></td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        </tbody>
    </table>
</div>

</br></br>
<footer>
    &copy; 2025 Sistema Integrado de Prevención de Crímenes (SIPC) - Todos los derechos reservados.
</footer>
</body>
</html>

