<!-- PESTAÑA REPORTE DE TIPOS DE DELITO DE ADMIN CARABINEROS -->

<?php
require_once("../../../../config/config.php"); // Ajusta la ruta según tu estructura de carpetas
$conn->set_charset("utf8");

// Consulta para tabla y gráfico
$sql_resumen = "
    SELECT 
        td.id_tipo_delito,
        td.nombre_tipo AS tipo_delito,
        COUNT(d.id_delito) AS cantidad,
        GROUP_CONCAT(DISTINCT s.nombre_sector SEPARATOR ', ') AS sectores
    FROM tipo_delito td
    LEFT JOIN delito d ON td.id_tipo_delito = d.id_tipo_delito
    LEFT JOIN sector s ON d.id_sector = s.id_sector
    GROUP BY td.id_tipo_delito
";
$resumen = $conn->query($sql_resumen);

// Consulta para el mapa
$sql_mapa = "
    SELECT d.latitud, d.longitud, td.nombre_tipo AS tipo, d.descripcion, d.fecha
    FROM delito d
    JOIN tipo_delito td ON d.id_tipo_delito = td.id_tipo_delito
";
$mapa = $conn->query($sql_mapa);

// Consulta para el selector
$sql_tipos = "SELECT id_tipo_delito, nombre_tipo FROM tipo_delito";
$tipos = $conn->query($sql_tipos);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte - Tipos de Delitos</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        /* Reset básico */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
            font-family: Arial, sans-serif;
            background-color: #2E8B57;
     
            text-align: center;
            margin-top: 0;
        }
		
		h2 {
            margin: 0;
            font-family: Arial, sans-serif;
            font-size: 48px;
			background-color: white;
        }
		
        #map {
            height: 600px;
            width: 100%;
        }
		
		.nav-links a:hover {
            text-decoration: underline;
        }

        .nav-links a {
            color: white;
            text-decoration: none;
            font-size: 18px;
        }

        .nav-links {
            display: flex;
            justify-content: flex-start; /* Alinea los enlaces al principio */
            gap: 15px; /* Espacio entre los enlaces */
            margin-left: -550px; /* Elimina el margen izquierdo */
        }
		
		.help-link a, .return-link a {
            color: black;
            text-decoration: none;
        }

        .help-link a:hover, .return-link a:hover {
            text-decoration: underline;
        }

        .help-link, .return-link {
            text-align: left;
            margin-top: 10px;
        }
		
		.navbar {
			background-color: #0b6623 !important;
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

		  .dropdown-menu {
			background-color: #0b6623;
		  }

		  .dropdown-item:hover {
			background-color: #0e7d2d;
		  }


table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 25px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    background-color: white;
}

th, td {
    text-align: left;
    padding: 12px;
    border: 1px solid #ddd;
}

th {
    background-color: #2980b9;
    color: white;
}

tr:nth-child(even) {
    background-color: #f9f9f9;
}

tr:hover {
    background-color: #eaf2f8;
}

select {
    padding: 10px;
    font-size: 16px;
    border: 1px solid #bbb;
    border-radius: 4px;
    background-color: #fff;
    margin-top: 10px;
}

#resultadosDelito {
    padding: 15px;
    background-color: #fff;
    border: 1px solid #ccc;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
}

#grafico {
    max-width: 800px;
    margin: 200px;
	background-color: #fff;
	text-align: center;
}

#map {
    height: 450px;
    border: 2px solid #ccc;
    border-radius: 8px;
    margin-bottom: 30px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
}

/* Responsive */
@media screen and (max-width: 768px) {
    body {
        padding: 15px;
    }

    table, #grafico, #map {
        width: 100%;
        overflow-x: auto;
    }

    select {
        width: 100%;
    }
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

<h2>Resumen de Tipos de Delitos</h2>
<table>
    <thead>
        <tr>
            <th>Tipo de Delito</th>
            <th>Cantidad</th>
            <th>Sectores</th>
        </tr>
    </thead>
    <tbody>
        <?php while($row = $resumen->fetch_assoc()): ?>
            <tr>
                <td><?= $row["tipo_delito"] ?></td>
                <td><?= $row["cantidad"] ?></td>
                <td><?= $row["sectores"] ?></td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<!-- Filtro -->
<h2>Buscar por Tipo de Delito</h2>
<form id="filtroForm">
    <select name="id_tipo" id="id_tipo">
        <option value="">Seleccione tipo de delito</option>
        <?php while($t = $tipos->fetch_assoc()): ?>
            <option value="<?= $t["id_tipo_delito"] ?>"><?= $t["nombre_tipo"] ?></option>
        <?php endwhile; ?>
    </select>
</form>
<div id="resultadosDelito" style="margin-top: 20px;"></div>

<script>
document.getElementById('id_tipo').addEventListener('change', function() {
    const tipo = this.value;
    const contenedor = document.getElementById('resultadosDelito');
    if (tipo === '') {
        contenedor.innerHTML = '';
        return;
    }
    contenedor.innerHTML = 'Cargando...';
    fetch('/SIPC/controladores/buscar_por_tipo.php?id_tipo=' + tipo)
        .then(res => res.text())
        .then(html => contenedor.innerHTML = html);
});
</script>

<!-- Mapa -->
<h2>Mapa de Delitos Geolocalizados</h2>
<div id="map"></div>
<script>
    const map = L.map('map').setView([-33.45, -70.6667], 11);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    <?php $mapa->data_seek(0); while($p = $mapa->fetch_assoc()): ?>
        L.marker([<?= $p["latitud"] ?>, <?= $p["longitud"] ?>])
            .bindPopup("<strong><?= $p["tipo"] ?></strong><br><?= $p["descripcion"] ?><br><em><?= $p["fecha"] ?></em>")
            .addTo(map);
    <?php endwhile; ?>
</script>

<!-- Gráfico -->
<h2>Estadísticas por Tipo de Delito</h2>
<canvas id="grafico"></canvas>
<script>
    const ctx = document.getElementById('grafico').getContext('2d');
    const chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: [<?php
                $resumen->data_seek(0);
                while($row = $resumen->fetch_assoc()) echo "'".$row["tipo_delito"]."',";
            ?>],
            datasets: [{
                label: 'Cantidad de Delitos',
                data: [<?php
                    $resumen->data_seek(0);
                    while($row = $resumen->fetch_assoc()) echo $row["cantidad"].",";
                ?>],
                backgroundColor: 'rgba(54, 162, 235, 0.7)'
            }]
        }
    });
</script>

</body>
</html>