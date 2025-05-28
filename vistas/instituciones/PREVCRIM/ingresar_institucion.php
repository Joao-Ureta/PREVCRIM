<?php
include("../../../config/config.php");

$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST["nombre"];
    $direccion = $_POST["direccion"];
    $telefono = $_POST["telefono"];
    $correo = $_POST["correo"];
    $latitud = $_POST["latitud"];
    $longitud = $_POST["longitud"];
    $id_comuna = $_POST["id_comuna"];

    $sql = "INSERT INTO institucion (nombre_institucion, direccion, telefono, correo, latitud, longitud, id_comuna)
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssddi", $nombre, $direccion, $telefono, $correo, $latitud, $longitud, $id_comuna);

    if ($stmt->execute()) {
        $mensaje = "<div class='alert alert-success'>Institución registrada correctamente.</div>";
    } else {
        $mensaje = "<div class='alert alert-danger'>Error al registrar la Institución.</div>";
    }
}
?>

<html lang="es">
  <head>
    <meta charset="UTF-8">
    <meta name="description" content="Ejemplo de HRML5">
    <meta name="keywords" content="HTML5, CSS3, JavaScript">
    <meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="/SIPC/estaticos/css/bootstrap.min.css">
	
<!-- Incluye los archivos de Bootstrap (si no lo has hecho aún) -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<!-- Asegúrate de que jQuery también esté incluido -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA3wzdatwG0njMap89LqBnbWdGFfd73Vsk&libraries=places"></script>
<title>Registro de institución</title>
	<style>
        body {
            font-family: Arial, sans-serif;
            background-color: #C0C0C0;
            color: white;
            text-align: center;
            margin-top: 0;
        } 
		
        .dropdown-menu {
          background-color: #A9A9A9;
          }

        .dropdown-item:hover {
          background-color: #808080;
          }
          
        .container {
          display: flex;
          flex-direction: column; /* Asegura que los elementos dentro estén en columna */
          justify-content: center;
          align-items: center;
          text-align: left;
          width: 50%;
          max-width: 500px;
          padding: 20px;
          background-color:#808080;
          border-radius: 10px;
          box-shadow: 0 10px 20px rgba(0, 0, 0, 0.90); /* Efecto de sombra con relieve */
          margin: 50px auto; /* Centra horizontalmente y añade margen superior/inferior */
            }
        
        small.form-text {
          color: white !important;
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
      
        footer {
          background-color: #808080;
          color: white;
          padding: 10px;
          position: fixed;
          bottom: 0;
          width: 100%;
        }
        </style>
</head>
<body>

<nav class="navbar navbar-expand-lg" style="background-color: #808080;">
  <div class="container-fluid">
    <div class="logo-container" style="margin-right: 40px;">
        <img src="/SIPC/estaticos/img/logo_prevcrim4.jpg" alt="PREVCRIM" width="120">
		<a class="navbar-brand" href="admin_general.php">Administrador PREVCRIM</a>
    </div>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
	  
		<li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Administracion de usuarios
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="listar_usuarios.php">Lista de usuarios / Modificar</a></li>
            <li><a class="dropdown-item" href="ingresar_usuario.php">Ingresar nuevo usuario</a></li>
            <li><a class="dropdown-item" href="eliminar_usuario.php">Eliminar usuario</a></li>
          </ul>
        </li>
		
				<li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Administracion de instituciones
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="ingresar_institucion.php">Ingresar nueva institucion</a></li>
			      <li><a class="dropdown-item" href="listar_instituciones.php">Listado de instituciones / Modificar-Eliminar</a></li>
          </ul>
        </li>
		
        <li class="nav-item dropdown">
		  <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
			Bitacora de accesos
		  </a>
		  <ul class="dropdown-menu">
			<li><a class="dropdown-item" href="reporte_accesos.php">Registro de accesos</a></li>
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
<h2 class="mb-4">Ingresar Institución</h2>
      </br>
    <?= $mensaje ?>
      </br>
      <form method="POST" class="w-100">
  <div class="mb-3 w-100">
    <label class="form-label">Nombre institución:</label>
    <input type="text" name="nombre" class="form-control" required>
  </div>

  <div class="mb-3 w-100">
    <label class="form-label">Dirección:</label>
    <input id="direccion" type="text" name="direccion" class="form-control" placeholder="Ingrese dirección" required>
  </div>

  <div class="mb-3 w-100">
    <label class="form-label">Teléfono:</label>
    <input type="text" name="telefono" class="form-control">
  </div>

  <div class="mb-3 w-100">
    <label class="form-label">Correo:</label>
    <input type="email" name="correo" class="form-control">
  </div>

  <div class="mb-3 w-100">
    <label class="form-label">Latitud:</label>
    <input id="latitud" name="latitud" type="text" class="form-control" readonly>
  </div>

  <div class="mb-3 w-100">
    <label class="form-label">Longitud:</label>
    <input id="longitud" name="longitud" type="text" class="form-control" readonly>
  </div>

  <div class="mb-3 w-100">
    <label class="form-label">Comuna:</label>
    <select name="id_comuna" class="form-select" required>
      <option value="">Seleccione una comuna</option>
      <?php
      $resultado = $conn->query("SELECT id_comuna, nombre_comuna FROM comuna");
      while ($row = $resultado->fetch_assoc()) {
          echo "<option value='{$row['id_comuna']}'>{$row['nombre_comuna']}</option>";
      }
      ?>
    </select>
  </div>

  <div class="text-center">
    <input type="submit" value="Guardar institución" class="btn btn-primary">
  </div>
</form>

</div>

<script>
        let autocomplete;

        function initAutocomplete() {
            const input = document.getElementById('direccion');
            autocomplete = new google.maps.places.Autocomplete(input, {
                types: ['geocode'],
                componentRestrictions: { country: "cl" } // Cambia "cl" por tu país si es necesario
            });

            autocomplete.addListener('place_changed', function () {
                const place = autocomplete.getPlace();

                if (place.geometry) {
                    const lat = place.geometry.location.lat();
                    const lng = place.geometry.location.lng();
                    document.getElementById('latitud').value = lat;
                    document.getElementById('longitud').value = lng;
                } else {
                    alert("No se encontró ubicación para la dirección ingresada.");
                }
            });
        }

        window.onload = initAutocomplete;
    </script>

</br></br>
<footer>
    &copy; 2025 Sistema Integrado de Prevención de Crímenes (SIPC) - Todos los derechos reservados.
</footer>

</body>
</html>