<!-- PESTAÑA VER DELINCUENTE ADMIN PDI -->

<?php
require_once("../../../../config/config.php"); 

// Consultar todos los delincuentes
$query = "SELECT * FROM delincuente";
$result = $conn->query($query);

if ($result->num_rows > 0):
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <title>Ver Delincuentes</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
	body {
            font-family: Arial, sans-serif;
            background-color: #dcdcdc;
            color: black;
            text-align: center;
            margin-top: 0;
        } 
		

		 input.form-control {
			border-radius: 6px;
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
		
				footer {
            background-color: #FFCC00;
            color: black;
            padding: 10px;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
		
        /* Estilo para las tarjetas */
        .card-columns {
			display: grid;
			grid-template-columns: repeat(4, 1fr);
			gap: 20px;
			padding: 20px;
		}

        .card {
            background-color: #0033A0;
			color: white;
			display: flex;
			flex-direction: column;
			justify-content: space-between;
			align-items: center;
			box-shadow: 0 4px 10px rgba(0, 0, 0, 0.5);
			border-radius: 10px;
			transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
			min-height: 450px; /* Asegurar que todas las tarjetas tengan la misma altura */
			padding: 20px;
			width: 20%; /* Que ocupe el ancho de su columna */
        }

        .card img {
            width: 100%;
			height: 300px; /* Altura fija para las imágenes */
			object-fit: cover; /* Ajustar sin distorsión */
			border-top-left-radius: 10px;
			border-top-right-radius: 10px;
        }
		
		.card-body {
			flex-grow: 1; /* Hace que el contenido se expanda uniformemente */
			display: flex;
			flex-direction: column;
			justify-content: space-between;
			text-align: center;
			min-height: 200px; /* Asegurar que todas las tarjetas tengan la misma altura */
		}
		
		.card-title {
			font-size: 20px;
			font-weight: bold;
			margin-bottom: 10px;
		}

        .card-header {
            font-weight: bold;
            background-color: #FFCC00;
            padding: 10px;
            text-align: center;
        }

        .card-text {
            margin-bottom: 5px;
        }

        .card-footer {
            background-color: #FFCC00;
            color: black;
            font-size: 0.9rem;
            text-align: center;
            padding: 10px;
        }

        /* Ajuste para la disposición de las tarjetas */
        .card-columns {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 1.5rem;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg" style="background-color: #0033A0;">
  <div class="container-fluid">
    <div class="logo-container" style="margin-right: 40px;">
        <img src="/SIPC/estaticos/img/pdi.jpg" alt="Paz Ciudadana" width="120">
		<a class="navbar-brand" href="admin_pdi.php">Administrador</a>
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
    <h2 class="text-center mb-4">Listado de Delincuentes</h2>

    <div class="card-columns">
        <?php while($row = $result->fetch_assoc()): ?>
            <div class="card">
                <img src="/SIPC/<?= htmlspecialchars($row['foto']) ?>" class="card-img-top" alt="Foto de <?= htmlspecialchars($row['nombre_completo']) ?>">


                <div class="card-body">
                    <h5 class="card-title"><?= htmlspecialchars($row['nombre_completo']) ?></h5>
                    <p class="card-text"><strong>RUT:</strong> <?= htmlspecialchars($row['rut']) ?></p>
                    <p class="card-text"><strong>Edad:</strong> <?= htmlspecialchars($row['edad']) ?></p>
                    <p class="card-text"><strong>Género:</strong> <?= htmlspecialchars($row['genero']) ?></p>
                    <p class="card-text"><strong>Apodo:</strong> <?= htmlspecialchars($row['apodo']) ?></p>
                    <p class="card-text"><strong>Antecedentes:</strong> <?= htmlspecialchars($row['antecedentes']) ?></p>
                    <p class="card-text"><strong>Nacionalidad:</strong> <?= htmlspecialchars($row['nacionalidad']) ?></p>
                    <p class="card-text"><strong>Estado Judicial:</strong> <?= htmlspecialchars($row['estado_judicial']) ?></p>
                    <p class="card-text"><strong>Dirección:</strong> <?= htmlspecialchars($row['direccion_particular']) ?></p>
                    <p class="card-text"><strong>Nivel de Peligrosidad:</strong> <?= htmlspecialchars($row['nivel_peligrosidad']) ?></p>
                </div>
                <div class="card-footer">
                    <small>Sector: 
                        <?php
                        // Obtener el nombre del sector
                        $sector_id = $row['id_sector'];
                        $sector_result = $conn->query("SELECT nombre_sector FROM sector WHERE id_sector = $sector_id");
                        $sector = $sector_result->fetch_assoc();
                        echo htmlspecialchars($sector['nombre_sector']);
                        ?>
                    </small>
                    <br>
                    <small>Comuna: 
                        <?php
                        // Obtener el nombre de la comuna
                        $comuna_id = $row['id_comuna'];
                        $comuna_result = $conn->query("SELECT nombre_comuna FROM comuna WHERE id_comuna = $comuna_id");
                        $comuna = $comuna_result->fetch_assoc();
                        echo htmlspecialchars($comuna['nombre_comuna']);
                        ?>
                    </small>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</div>

<!-- Bootstrap JS y dependencias (si usas algún componente de JS) -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</br></br>
<footer>
    &copy; 2025 Sistema Integrado de Prevención de Crímenes (SIPC) - Todos los derechos reservados.
</footer>

</body>
</html>

<?php
else:
    echo "No hay delincuentes registrados.";
endif;

$conn->close();
?>


