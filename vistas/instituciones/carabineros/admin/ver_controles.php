<!-- PESTAÑA VER CONTROLES DE ADMIN CARABINEROS -->

<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/SIPC/config/config.php');

// Consultar todos los controles con JOINs para traer los nombres
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
            c.latitud,
            c.longitud
        FROM control c
        INNER JOIN usuario u ON c.id_usuario = u.id_usuario
        LEFT JOIN sector s ON c.id_sector = s.id_sector
        LEFT JOIN delincuente d ON c.id_delincuente = d.id_delincuente
        ORDER BY c.fecha DESC, c.hora DESC";

$result = $conn->query($sql);

// Cargamos todos los datos en un array para usarlos en JS después
$controles = [];
if ($result && $result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
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
	
	<!-- jsPDF y autoTable -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.23/jspdf.plugin.autotable.min.js"></script>


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

<div class="container mt-5">
    <h2 class="mb-4 text-center">Lista de Controles</h2>

    <div class="mb-3 text-end">
		<button class="btn btn-success" onclick="generarPDF()">Generar Reporte PDF</button>
	</div>


</br>
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

<script>
// Esperar a que carguen los módulos de jsPDF
window.jsPDF = window.jspdf.jsPDF;

async function generarPDF() {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF();

    // Cargar el logo de Carabineros
    const imgData = await getBase64ImageFromURL('/SIPC/estaticos/img/carabineros.png');

    // Agregar el logo al PDF
    if (imgData) {
        doc.addImage(imgData, 'PNG', 10, 10, 30, 30);
    }

    // Título
    doc.setFontSize(18);
    doc.text("Reporte de Controles", 50, 20);

    // Espaciado para no tapar el logo
    doc.setFontSize(12);
    doc.text(`Fecha de generación: ${new Date().toLocaleDateString()}`, 140, 20);

    // Formato de tabla
    const headers = [
        ["ID", "Fecha", "Hora", "Lugar", "Tipo Control", "Resultado", "Observaciones", "Usuario", "Sector", "Delincuente", "Latitud", "Longitud"]
    ];

    const data = controles.map(control => [
        control.id_control,
        control.fecha,
        control.hora,
        control.lugar_control,
        control.tipo_control,
        control.resultado,
        control.observaciones,
        control.nombre_usuario,
        control.nombre_sector || 'No asignado',
        control.nombre_delincuente || 'No asignado',
        control.latitud,
        control.longitud
    ]);

    // Insertar la tabla
    doc.autoTable({
        startY: 50, // Empezar después del logo
        head: headers,
        body: data,
        styles: {
            fontSize: 8,
            cellPadding: 2,
            halign: 'center'
        },
        headStyles: {
            fillColor: [11, 102, 35] // Color verde institucional
        }
    });

    // Guardar el archivo
    doc.save("reporte_controles.pdf");
}

// Función para convertir la imagen en Base64
function getBase64ImageFromURL(url) {
    return new Promise((resolve, reject) => {
        const img = new Image();
        img.setAttribute('crossOrigin', 'anonymous');
        img.onload = function () {
            const canvas = document.createElement('canvas');
            canvas.width = img.width;
            canvas.height = img.height;
            const ctx = canvas.getContext('2d');
            ctx.drawImage(img, 0, 0);
            const dataURL = canvas.toDataURL('image/png');
            resolve(dataURL);
        };
        img.onerror = function (error) {
            reject(error);
        };
        img.src = url;
    });
}
</script>



</br></br></br></br>
<footer>
    &copy; 2025 Sistema Integrado de Prevención de Crímenes (SIPC) - Todos los derechos reservados.
</footer>

</body>
</html>