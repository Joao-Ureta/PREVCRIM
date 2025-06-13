<?php
require_once("../../../../config/config.php"); 

// Obtener tipos de delito
$tipos_delito = $conn->query("SELECT id_tipo_delito, nombre_tipo FROM tipo_delito");
$instituciones = $conn->query("SELECT id_institucion, nombre_institucion FROM institucion");
$sectores = $conn->query("SELECT id_sector, nombre_sector FROM sector");
$delincuentes = $conn->query("SELECT id_delincuente, nombre_completo FROM delincuente");
$victimas = $conn->query("SELECT id_victima, CONCAT(nombres, ' ', apellidos) AS nombre FROM victima");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <title>Registrar Delito</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
	
	<style>
	body {
            font-family: Arial, sans-serif;
            background: #D0D0D0;
            color: black;
            text-align: center;
            margin-top: 0;
        } 
		

		 input.form-control {
			border-radius: 6px;
		  }
	
		
		.dropdown-menu {
			background-color: #C0C0C0;
		  }

		  .dropdown-item:hover {
			background-color: #A9A9A9;
		  }
		
        
        .btn-buscar {
            background-color: #2E8B57;
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
		
		.btn-eliminar {
            background-color: #FF0000;
            color: white;
            border: none;
            padding: 10px 15px;
            margin-top: 20px;
            font-weight: bold;
            cursor: pointer;
            border-radius: 5px;
        }
        .btn-eliminar:hover {
            background-color: #00FF7F;
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
		
				footer {
            background-color: #C0C0C0;
            color: black;
            padding: 10px;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
		
		.container {
            background-color: #C0C0C0;
            padding: 20px;
			text-align: left;
            max-width: 700px;
            margin: auto;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }
		
		h2 { text-align: center; color: black; }
		
		.btn-secondary {
			background-color: #808080;
			color: white;
			font-weight: bold;
			border: none;
			display: block;
			margin: 0 auto;
			padding: 10px 20px;
		  }

		.btn-secondary:hover {
			background-color: #D3D3D3;
            color: black;
		  }
		
		.btn-success {
			background-color: #808080;
			color: white;
			font-weight: bold;
			border: none;
			display: block;
			margin: 0 auto;
			padding: 10px 20px;
		  }

		.btn-success:hover {
			background-color: #D3D3D3;
            color: black;
		  }
		</style>
</head>
<body>

<nav class="navbar navbar-expand-lg" style="background-color: #C0C0C0;;">
  <div class="container-fluid">
    <div class="logo-container" style="margin-right: 40px;">
        <img src="/SIPC/estaticos/img/paz_ciudadana.jpg" alt="Carabineros de Chile" width="120">
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

<div class="container">
    <h2 class="mb-4">Registrar Delito</h2>
    <form action="../../../../controladores/guardar_delito_pc_op.php" method="POST" enctype="multipart/form-data">
	
		<?php
		$hoy = date('Y-m-d');
		?>
        <div class="mb-3">
            <label for="fecha" class="form-label">Fecha del delito</label>
            <input type="date" name="fecha" class="form-control" max="<?= date('Y-m-d') ?>" required>
        </div>	
        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea class="form-control" name="descripcion" rows="3" required></textarea>
        </div>
        <div class="mb-3">
            <label for="id_tipo_delito" class="form-label">Tipo de delito</label>
            <select class="form-select" name="id_tipo_delito" required>
                <option value="">Seleccione</option>
                <?php while($row = $tipos_delito->fetch_assoc()): ?>
                    <option value="<?= $row['id_tipo_delito'] ?>"><?= $row['nombre_tipo'] ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="id_institucion" class="form-label">Institución</label>
            <select class="form-select" name="id_institucion" required>
                <option value="">Seleccione</option>
                <?php while($row = $instituciones->fetch_assoc()): ?>
                    <option value="<?= $row['id_institucion'] ?>"><?= $row['nombre_institucion'] ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="id_sector" class="form-label">Sector</label>
            <select class="form-select" name="id_sector" required>
                <option value="">Seleccione</option>
                <?php while($row = $sectores->fetch_assoc()): ?>
                    <option value="<?= $row['id_sector'] ?>"><?= $row['nombre_sector'] ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="direccion" class="form-label">Dirección del delito</label>
            <input type="text" id="direccion" class="form-control" name="direccion" placeholder="Escriba una dirección">
        </div>
        <div class="mb-3">
            <label class="form-label">Ubicación del delito</label>
            <div id="map" style="height: 300px; width: 100%; border: 1px solid #ccc;"></div>
        </div>
        <div class="row mb-3">
            <div class="col">
                <label class="form-label">Latitud</label>
                <input type="text" id="lat" name="latitud" class="form-control" readonly required>
            </div>
            <div class="col">
                <label class="form-label">Longitud</label>
                <input type="text" id="lng" name="longitud" class="form-control" readonly required>
            </div>
        </div>

        <!-- Delincuentes -->
        <div id="delincuentesContainer">
            <h5>Delincuentes involucrados</h5>
            <div class="row mb-2 delincuente-row">
                <div class="col-md-6">
                    <select name="delincuentes[]" class="form-select" required>
                        <option value="">Seleccione delincuente</option>
                        <?php while($row = $delincuentes->fetch_assoc()): ?>
                            <option value="<?= $row['id_delincuente'] ?>"><?= $row['nombre_completo'] ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <input type="text" name="roles[]" class="form-control" placeholder="Rol (Ej: Autor, Cómplice)" required>
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-danger remove-btn">X</button>
                </div>
            </div>
        </div>
        <br>
        <button type="button" id="addDelincuente" class="btn btn-secondary mb-3">Agregar otro delincuente</button>
        <br>
        <button type="submit" class="btn btn-success">Registrar Delito</button>
    </form>
</div>
</br></br>
<script>
// Clonación de campos para múltiples delincuentes
const addBtn = document.getElementById('addDelincuente');
const container = document.getElementById('delincuentesContainer');

addBtn.addEventListener('click', () => {
    const firstRow = container.querySelector('.delincuente-row');
    const clone = firstRow.cloneNode(true);
    clone.querySelectorAll('select, input').forEach(el => el.value = '');
    container.appendChild(clone);
});

container.addEventListener('click', e => {
    if (e.target.classList.contains('remove-btn') && container.querySelectorAll('.delincuente-row').length > 1) {
        e.target.closest('.delincuente-row').remove();
    }
});
</script>

<script>
  let map;
  let marker;

  function initMap() {
    const center = { lat: -33.4489, lng: -70.6693 }; // Santiago

    map = new google.maps.Map(document.getElementById("map"), {
      center: center,
      zoom: 12,
    });

    marker = new google.maps.Marker({
      map: map,
    });

    // Autocompletado de direcciones
    const input = document.getElementById("direccion");
    const autocomplete = new google.maps.places.Autocomplete(input);
    autocomplete.bindTo("bounds", map);

    autocomplete.addListener("place_changed", function () {
      const place = autocomplete.getPlace();

      if (!place.geometry) {
        alert("No se encontró la ubicación");
        return;
      }

      // Ajusta el mapa y marcador
      map.setCenter(place.geometry.location);
      map.setZoom(16);
      marker.setPosition(place.geometry.location);

      // Rellena lat/lng
      document.getElementById("lat").value = place.geometry.location.lat();
      document.getElementById("lng").value = place.geometry.location.lng();
    });

    // Click manual en el mapa
    map.addListener("click", function (e) {
      const lat = e.latLng.lat();
      const lng = e.latLng.lng();

      marker.setPosition(e.latLng);
      document.getElementById("lat").value = lat;
      document.getElementById("lng").value = lng;
    });
  }
</script>

<!-- API KEY google maps -->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA3wzdatwG0njMap89LqBnbWdGFfd73Vsk&libraries=places&callback=initMap" async defer></script>

</br></br>
<footer>
    &copy; 2025 Sistema Integrado de Prevención de Crímenes (SIPC) - Todos los derechos reservados.
</footer>

</body>
</html>