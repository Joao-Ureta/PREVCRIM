<!-- PESTAÑA ZONAS CONFLICTIVAS DE JEFE ZONA PDI -->
<?php
require_once("../../../config/config.php"); // Ajusta la ruta según tu estructura de carpetas

// Consulta para la tabla
$sql = "SELECT 
            s.nombre_sector, 
            COUNT(d.id_delito) AS cantidad_delitos, 
            GROUP_CONCAT(DISTINCT t.nombre_tipo ORDER BY t.nombre_tipo ASC SEPARATOR ', ') AS tipos_delitos
        FROM 
            sector s
        LEFT JOIN 
            delito d ON s.id_sector = d.id_sector
        LEFT JOIN 
            tipo_delito t ON d.id_tipo_delito = t.id_tipo_delito
        GROUP BY 
            s.id_sector";
$result_tabla = $conn->query($sql);

// Consulta para los puntos del mapa
$sql_mapa = "SELECT d.latitud, d.longitud, s.nombre_sector, t.nombre_tipo
             FROM delito d
             INNER JOIN sector s ON d.id_sector = s.id_sector
             INNER JOIN tipo_delito t ON d.id_tipo_delito = t.id_tipo_delito";
$result_mapa = $conn->query($sql_mapa);

// Almacenamos los puntos en un array para pasarlo a JavaScript
$delitos = [];
if ($result_mapa && $result_mapa->num_rows > 0) {
    while ($row = $result_mapa->fetch_assoc()) {
        $delitos[] = $row;
    }
}

// Datos de las zonas pintadas, ejemplo de polígonos
$zonas_pintadas = [
    ["lat" => -33.45, "lng" => -70.68, "name" => "Zona 1"],
    ["lat" => -33.46, "lng" => -70.69, "name" => "Zona 2"],
    // Agregar más zonas pintadas según sea necesario
];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte Zonas Conflictivas</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/leaflet.css"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/leaflet.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <style>
	
	        body {
            font-family: Arial, sans-serif;
            background-color: #dcdcdc;
            color: white;
            text-align: center;
            margin-top: 0;
        } 
		
		/* Estilos para nav links inicial */
		.logo-container img {
            width: 120px;
            height: auto;
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
		
		h2 {
            margin: 0;
            font-family: Arial, sans-serif;
            font-size: 48px;
			background-color: #0033A0;
        }

        .help-link a, .return-link a {
            color: white;
            text-decoration: none;
        }

        .help-link a:hover, .return-link a:hover {
            text-decoration: underline;
        }

        .help-link, .return-link {
            text-align: left;
            margin-top: 10px;
        }

		.card-columns {
			display: grid;
			grid-template-columns: repeat(4, 1fr);
			gap: 20px;
			padding: 20px;
		}
		
		/* Estilos para nav links y busqueda */
		  .navbar {
			background-color: #0033A0; !important;
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
			background-color: #0033A0;
		  }

		  .dropdown-item:hover {
			background-color: #FFCC00;
		  }
		  
		  /* -------------------------------------------------------------------------------------------- */
		
        #map {
            width: 800px;
            height: 620px;
            margin: 20px auto;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.5);
            display: block;
        }

		
		/* Estilo de la tabla */
table {
    width: 75%;
    margin-top: 20px;
	margin: 20px auto; /* Centrado horizontalmente */
    border-collapse: collapse;
    background-color: #87CEFA; /* Fondo gris claro */
}

th, td {
    padding: 10px;
    text-align: left;
    border-bottom: 1px solid #ddd;
}

/* Contenedor de los títulos de la tabla */
th {
    background-color: #0033A0;
    color: white; 
    font-size: 18px;
}

/* Estilo de las celdas de la tabla */
td {
    background-color: #87CEFA; /* Fondo verde claro */
    color: #333; /* Texto negro */
}

tr:hover {
    background-color: #f1c40f; /* Amarillo cuando pasa el mouse */
}

.btn {
			display: inline-block;
			padding: 10px 20px;
			background-color: #FFCC00;
			color: black;
			text-decoration: none;
			border-radius: 5px;
			font-weight: bold;
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

    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg" style="background-color: #0033A0;">
  <div class="container-fluid">
    <div class="logo-container" style="margin-right: 40px;">
        <img src="/SIPC/estaticos/img/pdi.jpg" alt="PDI" width="120">
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
<h2>Zonas Conflictivas</h2>
</br></br>
<!-- Botón para mostrar zonas pintadas -->
<button class="btn" onclick="mostrarZonasPintadas()">Mostrar Zonas Pintadas</button>


<div id="map"></div>

<h3>Tabla de Delitos por Sector</h3>
<table>
    <tr>
        <th>Sector</th>
        <th>Cantidad de Delitos</th>
        <th>Tipos de Delitos</th>
    </tr>
    <?php
    if ($result_tabla && $result_tabla->num_rows > 0) {
        while ($row = $result_tabla->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["nombre_sector"] . "</td>";
            echo "<td>" . $row["cantidad_delitos"] . "</td>";
            echo "<td>" . $row["tipos_delitos"] . "</td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='3'>No hay datos disponibles.</td></tr>";
    }
    ?>
</table>
</br></br>
<script>
// Crear el mapa centrado en Santiago
const map = L.map('map').setView([-33.45, -70.6667], 12);

// Capa base
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: 'Map data © <a href="https://openstreetmap.org">OpenStreetMap</a>'
}).addTo(map);

// Función para ajustar la luminosidad de un color HEX
function ajustarColor(hex, percent) {
    const num = parseInt(hex.replace('#', ''), 16);
    const amt = Math.round(2.55 * percent);
    const R = Math.min(255, Math.max(0, (num >> 16) + amt));
    const G = Math.min(255, Math.max(0, ((num >> 8) & 0x00FF) + amt));
    const B = Math.min(255, Math.max(0, (num & 0x0000FF) + amt));
    return '#' + (0x1000000 + (R << 16) + (G << 8) + B).toString(16).slice(1).toUpperCase();
}

// Crear un grupo para las zonas pintadas
let zonasPintadasLayer = L.layerGroup().addTo(map);

// Función para obtener las zonas desde el archivo PHP
function obtenerZonas() {
    fetch('/SIPC/controladores/zonas_conflicto.php')
        .then(response => response.json())
        .then(zonas => {
            zonasPintadasLayer.clearLayers();

            zonas.forEach(zona => {
                let baseColor = '#00FF7F'; // Verde bajo
                let radio = zona.radio_km * 1000;

                if (zona.total_delitos > 10) {
                    baseColor = '#FF6347'; // Rojo alto
                    radio = zona.radio_km * 1500;
                } else if (zona.total_delitos > 5) {
                    baseColor = '#FFD700'; // Amarillo medio
                    radio = zona.radio_km * 1200;
                }

                const bordeColor = ajustarColor(baseColor, -30);  // Más oscuro
                const rellenoColor = ajustarColor(baseColor, +30); // Más claro

                L.circle([zona.latitud, zona.longitud], {
                    color: bordeColor,
                    fillColor: rellenoColor,
                    fillOpacity: 0.5,
                    radius: radio
                }).addTo(zonasPintadasLayer).bindPopup(`
                    <strong>Zona:</strong> ${zona.nombre_sector}<br>
                    <strong>Total de Delitos:</strong> ${zona.total_delitos}
                `);
            });
        });
}

// Mostrar zonas cuando se hace clic en el botón
function mostrarZonasPintadas() {
    obtenerZonas();
}
</script>



<footer>
    &copy; 2025 Sistema Integrado de Prevención de Crímenes (SIPC) - Todos los derechos reservados.
</footer>

</body>
</html>