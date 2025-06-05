<!-- PESTAÑA UBICACION DELINCUENTES DE JEFE ZONA PAZ CIUDADANA -->
<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/SIPC/config/config.php');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ubicación de Delincuentes</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/leaflet.css" />
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js"></script>

    <style>
	
	body {
            font-family: Arial, sans-serif;
            background: #D0D0D0;
     
            text-align: center;
            margin-top: 0;
        }
		
		h2 {
            margin: 0;
            font-family: Arial, sans-serif;
            font-size: 48px;
			background-color: #C0C0C0;
        }
		
        #map {
            height: 600px;
            width: 100%;
        }
		
		.nav-links a:hover {
            text-decoration: underline;
        }

        .nav-links a {
            color: black;
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
			background-color: #C0C0C0 !important;
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

		  .dropdown-menu {
			background-color: #C0C0C0;
		  }

		  .dropdown-item:hover {
			background-color: #A9A9A9;
		  }
    </style>
</head>
<body>

<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/leaflet.js"></script>

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
    <h1>Ubicación de Delincuentes</h1>
	
    <div id="map" style="height: 600px;">
	<div style="padding: 10px; background: white; position: absolute; bottom: 20px; left: 20px; z-index: 1000; border-radius: 5px; box-shadow: 0 0 5px rgba(0,0,0,0.3);">
    <b>Leyenda:</b><br>
    <span style="color: red;">●</span> Alto<br>
    <span style="color: orange;">●</span> Medio<br>
    <span style="color: green;">●</span> Bajo
</div>
	</div>
	
<script>
    var map = L.map('map').setView([-33.45, -70.66], 12); // Santiago como centro

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    // Función para crear un ícono más visible (círculo con color)
    function createVisibleIcon(nivel) {
        const color = getIconColor(nivel);
        return L.divIcon({
            className: 'custom-icon',
            html: `<div style="width: 30px; height: 30px; background-color: ${color}; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold;">●</div>`,
            iconSize: [30, 30],
            iconAnchor: [15, 30], // Centro del ícono
            popupAnchor: [0, -30] // Ajusta la posición del popup
        });
    }

    // Función para asignar colores según el nivel
    function getIconColor(nivel) {
        switch(nivel.toLowerCase()) {
            case 'alto': return 'red';
            case 'medio': return 'orange';
            case 'bajo': return 'green';
            default: return 'blue';
        }
    }

    // Cargar los datos de delincuentes desde el servidor
    fetch('/SIPC/controladores/delincuentes_ubicaciones.php')
        .then(response => response.json())
        .then(data => {
            data.forEach(d => {
                const icon = createVisibleIcon(d.nivel_peligrosidad || 'medio'); // Usamos un ícono más visible basado en el nivel

                const popup = `
                    <strong>${d.nombre_completo} ${d.apodo ? '(' + d.apodo + ')' : ''}</strong><br>
                    <b>Delito:</b> ${d.tipo_delito}<br>
                    <b>Último incidente:</b> ${d.fecha_ultimo_incidente}<br>
                    <b>Peligrosidad:</b> ${d.nivel_peligrosidad}
                `;

                // Añadir el marcador al mapa
                L.marker([d.latitud, d.longitud], { icon: icon })
                    .addTo(map)
                    .bindPopup(popup);
            });
        })
        .catch(error => console.error('Error al cargar datos:', error));
</script>

	<div>
		<button id="btnZonasConflicto" style="position: absolute; top: 200px; right: 20px; z-index: 1000; padding: 10px; background: darkred; color: white; border: none; border-radius: 5px;">
    Zonas con Delitos
</button>
	</div>

<script>
    // Función para definir colores según cantidad de delitos
    function obtenerColorPorDelitos(totalDelitos) {
        if (totalDelitos >= 20) return 'darkred';      // Muy alto
        if (totalDelitos >= 10) return 'orangered';    // Alto
        if (totalDelitos >= 5) return 'orange';        // Medio
        return 'green';                                // Bajo
    }

    let zonasLayer = L.layerGroup();
    let zonasVisibles = false;

    document.getElementById("btnZonasConflicto").addEventListener("click", () => {
        if (!zonasVisibles) {
            fetch('/SIPC/controladores/zonas_conflicto.php')
                .then(res => res.json())
                .then(data => {
                    data.forEach(zona => {
                        const radioMetros = parseFloat(zona.radio_km) * 1000;
                        const color = obtenerColorPorDelitos(zona.total_delitos);

                        const circulo = L.circle([zona.latitud, zona.longitud], {
                            radius: radioMetros,
                            color: color,
                            fillColor: color,
                            fillOpacity: 0.4
                        }).bindPopup(`
                            <strong>Sector:</strong> ${zona.nombre_sector}<br>
                            <strong>Delitos registrados:</strong> ${zona.total_delitos}
                        `);

                        zonasLayer.addLayer(circulo);
                    });

                    zonasLayer.addTo(map);
                    zonasVisibles = true;
                })
                .catch(error => {
                    console.error("Error al obtener datos:", error);
                });
        } else {
            map.removeLayer(zonasLayer);
            zonasVisibles = false;
        }
    });
</script>

</body>
</html>