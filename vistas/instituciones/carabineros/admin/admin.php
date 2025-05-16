<?php
session_start();
if ($_SESSION['rol'] != 'Administrador') {
    header("Location: login.php");
    exit;
}
include_once($_SERVER['DOCUMENT_ROOT'] . '/SIPC/config/config.php');


$sql = "SELECT id_delincuente, nombre_completo, rut, edad, genero, apodo, antecedentes, foto, nacionalidad, id_sector, estado_judicial FROM delincuente";
$result = $conn->query($sql);

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



    <title>Administrador Carabineros</title>
	
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #2E8B57;
            color: white;
            text-align: center;
            margin-top: 0;
        }
        header {
            background-color: #0b6623;
            color: white;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

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
			background-color: #0b6623;
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

		.card-columns {
			display: grid;
			grid-template-columns: repeat(4, 1fr);
			gap: 20px;
			padding: 20px;
		}


		.custom-card {
			background-color: #0b6623;
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

		.card-img-top {
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

		.card-text {
			font-size: 14px;
			margin-bottom: 5px;
		}

		.btn-solicitar {
			background-color: #2E8B57;
			color: white;
			font-weight: bold;
			transition: all 0.3s ease-in-out;
			text-align: center;
			width: 200px; /* Establece un ancho fijo */
			height: 50px; /* Establece una altura fija */
			display: flex;
			justify-content: center;
			align-items: center; /* Centra el texto dentro del botón */
			border-radius: 5px; /* Opcional, para bordes redondeados */
			font-size: 16px; /* Tamaño de la fuente */
		}
		
		.btn-solicitar:hover {
			background-color: #00FF7F;
		  }

		/* Adaptabilidad en pantallas más pequeñas */
		@media (max-width: 1200px) {
			.card-columns {
				grid-template-columns: repeat(3, 1fr); /* 3 tarjetas por fila */
			}
		}

		@media (max-width: 900px) {
			.card-columns {
				grid-template-columns: repeat(2, 1fr); /* 2 tarjetas por fila */
			}
		}

		@media (max-width: 600px) {
			.card-columns {
				grid-template-columns: repeat(1, 1fr); /* 1 tarjeta por fila */
			}
		}

        footer {
            background-color: #0b6623;
            color: white;
            padding: 10px;
            position: fixed;
            bottom: 0;
            width: 100%;
        }

        /* Estilos para la grilla de tarjetas */
        .card-columns {
            display: flex;
            flex-wrap: wrap; /* Permite que las tarjetas se acomoden en múltiples filas */
            justify-content: center; /* Centra las tarjetas */
            gap: 20px; /* Espacio entre las tarjetas */
        }

        @media (max-width: 768px) {
            .card {
                flex: 1 1 100%; /* En pantallas pequeñas, las tarjetas ocupan el 100% del ancho */
            }
        }
		
		.modal-body {
			color: black; /* Cambia el color del texto en el modal a negro */
		}

		.modal-title {
			color: black;
		}

		/* Estilos para nav links y busqueda */
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

		

		/* Estilos filas contenedoras */
.fila-contenedora {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
    flex-wrap: wrap; /* Para que se acomode en pantallas pequeñas */
    padding: 10px 15px;
    background-color: #0b6623;
    border-radius: 10px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    position: relative; /* Esto permite colocar el título encima de los filtros */
}

.fila-contenedora2 {
    display: flex;
    justify-content: center;
    align-items: center;
    margin-bottom: 20px;
    flex-wrap: wrap; /* Para que se acomode en pantallas pequeñas */
    padding: 10px 15px;
    background-color: #0b6623;
    border-radius: 10px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    position: relative; /* Esto permite colocar el título encima de los filtros */
}

.botones {
    display: flex;
    justify-content: center; /* Centra los botones horizontalmente */
    align-items: center; /* Alinea los botones verticalmente */
    gap: 10px; /* Espacio entre los botones */
    flex-direction: row; /* Asegura que los botones estén alineados en una fila */
}

/* Contenedor de los filtros */
.filtros {
    display: flex;
    flex-wrap: wrap;
    gap: 15px;
    justify-content: center; /* Centra los filtros */
    width: 100%;
    max-width: 900px;
    margin: 0 auto;
    padding-top: 30px; /* Da espacio para el título */
}

/* Botones de filtro */
.filtros form {
    display: inline-block;
    margin: 0;
}

.filtros select,
.filtros input[type="date"] {
    padding: 8px 12px;
    border-radius: 5px;
    border: 1px solid #ccc;
    font-size: 14px;
    margin: 5px 0;
}

.filtros label {
    font-size: 14px;
    margin-right: 8px;
}

/* Contenedor del buscador */
.buscador {
    display: flex;
    align-items: center;
    gap: 10px;
    justify-content: flex-start;
    flex: 1;
}

/* Buscador de texto */
.buscador input[type="text"] {
    padding: 6px 10px;
    border: 1px solid #ced4da;
    border-radius: 5px;
    font-size: 14px;
}

.buscador button {
    padding: 6px 12px;
    border: none;
    background-color: #2E8B57;
    color: white;
    border-radius: 5px;
    font-size: 14px;
    transition: background-color 0.3s;
}

.buscador button:hover {
    background-color: #00FF7F;
}


.botones a {
    text-decoration: none;
    padding: 8px 12px;
    border: 1px solid white;
    border-radius: 5px;
    background-color: #2E8B57;
    color: white;
    transition: background-color 0.3s, color 0.3s;
}

.botones a:hover {
    background-color: #00FF7F;
    color: white;
}

/* Estilos generales */
.fila-contenedora {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 20px;
    padding: 20px;
}



		
		/* Boton de actualizar */
		.boton {
			display: inline-block;
			padding: 10px 20px;
			background-color: #0b6623;
			color: white;
			text-decoration: none;
			border-radius: 5px;
			font-weight: bold;
		  }

		  .boton:hover {
			background-color: #00FF7F;
		  }
		  
		  /* Boton de reporte general */
		.boton-reporteGeneral {
			display: inline-block;
			padding: 10px 20px;
			background-color: #0b6623;
			color: white;
			text-decoration: none;
			border-radius: 5px;
			font-weight: bold;
		  }

		  .boton-reporteGeneral:hover {
			background-color: #00FF7F;
		  }


/* MODAL RANKING */
#modalDelitos {
    display: none; /* Oculto por defecto */
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.7); /* Fondo oscuro */
    z-index: 9999;
    overflow: auto; /* Para que si el contenido es largo, se pueda desplazar */
}

/* Contenedor del modal */
#modalDelitos > div {
    background: #fff; /* Fondo blanco */
    margin: 5% auto;
    padding: 20px;
    width: 80%;
    position: relative;
    border-radius: 10px; /* Bordes redondeados */
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1); /* Sombra sutil */
}

/* Botón de cerrar */
#closeModal {
    position: absolute;
    top: 10px;
    right: 20px;
    font-size: 30px;
    font-weight: bold;
    color: #333;
    cursor: pointer;
    background-color: #fff; /* Fondo blanco para el botón */
    border-radius: 50%; /* Hace que la "x" esté en un círculo */
    padding: 10px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2); /* Sombra sutil */
}

#closeModal:hover {
    color: #e74c3c; /* Rojo cuando pasa el mouse */
    background-color: #f1c40f; /* Amarillo en hover */
}

/* Título del modal */
#modalDelitos h2 {
    color: #fff; /* Texto blanco */
    font-family: 'Arial', sans-serif;
    font-size: 24px;
    margin-bottom: 15px;
    background-color: #2E8B57; /* Fondo verde oscuro */
    padding: 10px; /* Espaciado alrededor del texto */
    border-radius: 5px; /* Bordes redondeados para el fondo */
}

/* Resultado de delitos */
#resultadoDelitos {
    margin-top: 20px;
    color: #333;
    font-size: 16px;
    text-align: center;
}

/* Estilo de la tabla */
table {
    width: 100%;
    margin-top: 20px;
    border-collapse: collapse;
    background-color: #f9f9f9; /* Fondo gris claro */
}

th, td {
    padding: 10px;
    text-align: left;
    border-bottom: 1px solid #ddd;
}

/* Contenedor de los títulos de la tabla */
th {
    background-color: #0b6623; /* Verde oscuro */
    color: #fff; /* Texto blanco */
    font-size: 18px;
}

/* Estilo de las celdas de la tabla */
td {
    background-color: #9ACD32; /* Fondo verde claro */
    color: #333; /* Texto negro */
}

tr:hover {
    background-color: #f1c40f; /* Amarillo cuando pasa el mouse */
}

/* Estilo del mapa */
#mapa {
    height: 400px;
	width: 100%;
    margin-top: 20px;
    border-radius: 10px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
}

</style>
</head>
<body>
<nav class="navbar navbar-expand-lg" style="background-color: #0b6623;">
  <div class="container-fluid">
    <div class="logo-container" style="margin-right: 40px;">
        <img src="/SIPC/estaticos/img/carabineros.png" alt="Carabineros de Chile" width="120">
		<a class="navbar-brand" href="jefe_zona.php">Administrador</a>
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
    <!-- php de filtro por comuna -->
<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/SIPC/config/config.php');

// Obtener todas las comunas para el dropdown
$sql_comunas = "SELECT id_comuna, nombre_comuna FROM comuna";
$result_comunas = $conn->query($sql_comunas);

// Capturar filtro de comuna si existe
$comunaFilter = "";
$comunaId = "";
if (isset($_GET['comuna']) && !empty($_GET['comuna'])) {
    $comunaId = $_GET['comuna'];
    $comunaFilter = " AND d.id_comuna = $comunaId";
}
?>
<div class="container mt-5">
<div>
<h2>Listado de criminales</h2>
</div>

</br></br>
<!-- Fila contenedora -->
<div class="fila-contenedora">
   
    <!-- Buscador -->
    <form method="get" action="" class="buscador">
        <input type="text" name="search" placeholder="Buscar por nombre o RUT" value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
        <button type="submit">Buscar</button>
    </form>
    
    <!-- Filtros -->
    <div class="filtros">

        <!-- Filtro por comuna integrado como dropdown -->
        <form method="GET">
            <label for="comuna">Filtrar por comuna:</label>
            <select name="comuna" onchange="this.form.submit()">
                <option value="">Todas</option>
                <?php
                while ($comuna = $result_comunas->fetch_assoc()) {
                    $selected = ($comunaId == $comuna['id_comuna']) ? 'selected' : '';
                    echo '<option value="' . $comuna['id_comuna'] . '" ' . $selected . '>' . $comuna['nombre_comuna'] . '</option>';
                }
                ?>
            </select>
            <?php
            if (isset($_GET['search'])) echo '<input type="hidden" name="search" value="' . $_GET['search'] . '">';
            if (isset($_GET['orden'])) echo '<input type="hidden" name="orden" value="' . $_GET['orden'] . '">';
            ?>
        </form>
        
        <!-- Filtro por delito -->
        <form method="GET">
            <label for="delito">Filtrar por delito:</label>
            <select name="delito" id="delito" onchange="this.form.submit()">
                <option value="">Todos</option>
                <?php
                $delitosQuery = "SELECT DISTINCT nombre_tipo FROM tipo_delito ORDER BY nombre_tipo ASC";
                $delitosResult = $conn->query($delitosQuery);
                if ($delitosResult && $delitosResult->num_rows > 0) {
                    while ($delito = $delitosResult->fetch_assoc()) {
                        $selected = (isset($_GET['delito']) && $_GET['delito'] == $delito['nombre_tipo']) ? 'selected' : '';
                        echo "<option value='{$delito['nombre_tipo']}' $selected>{$delito['nombre_tipo']}</option>";
                    }
                }
                ?>
            </select>
        </form>

        <!-- Filtro por sector -->
        <form method="GET">
            <label for="sector">Filtrar por sector:</label>
            <select name="sector" id="sector" onchange="this.form.submit()">
                <option value="">Todos</option>
                <?php
                $sectoresQuery = "SELECT id_sector, nombre_sector FROM sector ORDER BY nombre_sector ASC";
                $sectoresResult = $conn->query($sectoresQuery);
                if ($sectoresResult && $sectoresResult->num_rows > 0) {
                    while ($sector = $sectoresResult->fetch_assoc()) {
                        $selected = (isset($_GET['sector']) && $_GET['sector'] == $sector['id_sector']) ? 'selected' : '';
                        echo "<option value='{$sector['id_sector']}' $selected>{$sector['nombre_sector']}</option>";
                    }
                }
                ?>
            </select>
        </form>

        <!-- Filtro por estado judicial -->
        <form method="GET">
            <label for="estado_judicial">Filtrar Estado Judicial:</label>
            <select name="estado_judicial" id="estado_judicial" onchange="this.form.submit()">
                <option value="">Todos</option>
                <?php
                $estadoJudicialQuery = "SELECT DISTINCT estado_judicial FROM delincuente ORDER BY estado_judicial ASC";
                $estadoJudicialResult = $conn->query($estadoJudicialQuery);
                if ($estadoJudicialResult && $estadoJudicialResult->num_rows > 0) {
                    while ($estado = $estadoJudicialResult->fetch_assoc()) {
                        $selected = (isset($_GET['estado_judicial']) && $_GET['estado_judicial'] == $estado['estado_judicial']) ? 'selected' : '';
                        echo "<option value='{$estado['estado_judicial']}' $selected>{$estado['estado_judicial']}</option>";
                    }
                }
                ?>
            </select>
        </form>

        <!-- Filtro por fecha -->
        <form method="GET">
            <label for="fecha">Filtrar por fecha:</label>
            <input type="date" name="fecha" id="fecha" value="<?php echo isset($_GET['fecha']) ? $_GET['fecha'] : ''; ?>" onchange="this.form.submit()">
        </form>
        
    </div>
    
   

</div>

<div class="fila-contenedora2">
 <!-- Botones al extremo derecho -->
    <div class="botones">
        <a href="?orden=alfabetico">Orden alfabético</a>
        <a href="#" id="openModal">Ranking de delitos por sector</a>
    </div>
	</div>
	
<a href="jefe_zona.php" class="boton">Actualizar</a>

</div>

</br>
    <div class="card-columns">
	<!-- php de los filtros -->
    <?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/SIPC/config/config.php');

// Inicializamos la variable de filtro
$delitoFilter = '';
$sectorFilter = '';
$estadoJudicialFilter = '';
$fechaFilter = '';

// Verificamos si se ha seleccionado un tipo de delito
if (isset($_GET['delito']) && !empty($_GET['delito'])) {
    $delitoSeleccionado = $conn->real_escape_string($_GET['delito']);
    $delitoFilter = " AND td.nombre_tipo = '$delitoSeleccionado'";
}

// Verificamos si se ha seleccionado un sector
    if (isset($_GET['sector']) && !empty($_GET['sector'])) {
        $sectorSeleccionado = $conn->real_escape_string($_GET['sector']);
        $sectorFilter = " AND d.id_sector = '$sectorSeleccionado'";
    }
	
// Verificamos si se ha seleccionado un estado judicial
    if (isset($_GET['estado_judicial']) && !empty($_GET['estado_judicial'])) {
        $estadoJudicialSeleccionado = $conn->real_escape_string($_GET['estado_judicial']);
        $estadoJudicialFilter = " AND d.estado_judicial = '$estadoJudicialSeleccionado'";
    }
	
// Verificamos si se ha seleccionado una Fecha	
	$fechaFilter = '';
	if (isset($_GET['fecha']) && !empty($_GET['fecha'])) {
		$fechaSeleccionada = $conn->real_escape_string($_GET['fecha']);
		$fechaFilter = " AND DATE(del.fecha) = '$fechaSeleccionada'";
	}


// Determina si se está ordenando alfabéticamente
if (isset($_GET['orden']) && $_GET['orden'] == 'alfabetico') {
    $sql = "SELECT d.id_delincuente, d.nombre_completo, d.rut, d.edad, d.genero, d.apodo, d.antecedentes, 
                   d.foto, d.nacionalidad, d.id_sector, d.estado_judicial, d.direccion_particular, c.nombre_comuna,
                   td.nombre_tipo AS tipo_delito, td.descripcion AS descripcion_tipo_delito,
                   del.fecha AS fecha_delito, del.descripcion AS descripcion_delito, 
                   del.latitud AS latitud_delito, del.longitud AS longitud_delito
            FROM delincuente d 
            LEFT JOIN comuna c ON d.id_comuna = c.id_comuna
            LEFT JOIN delito_delincuente dd ON d.id_delincuente = dd.id_delincuente
            LEFT JOIN delito del ON dd.id_delito = del.id_delito
            LEFT JOIN tipo_delito td ON del.id_tipo_delito = td.id_tipo_delito
            WHERE 1=1 $comunaFilter $delitoFilter
            ORDER BY d.nombre_completo ASC";
} else {
    // Si no se seleccionó un orden específico, usar búsqueda o default
    if (isset($_GET['search']) && !empty($_GET['search'])) {
        $searchTerm = $_GET['search'];
        $sql = "SELECT d.id_delincuente, d.nombre_completo, d.rut, d.edad, d.genero, d.apodo, d.antecedentes, 
                       d.foto, d.nacionalidad, d.id_sector, d.estado_judicial, d.direccion_particular, c.nombre_comuna,
                       td.nombre_tipo AS tipo_delito, td.descripcion AS descripcion_tipo_delito,
                       del.fecha AS fecha_delito, del.descripcion AS descripcion_delito, 
                       del.latitud AS latitud_delito, del.longitud AS longitud_delito
                FROM delincuente d 
                LEFT JOIN comuna c ON d.id_comuna = c.id_comuna
                LEFT JOIN delito_delincuente dd ON d.id_delincuente = dd.id_delincuente
                LEFT JOIN delito del ON dd.id_delito = del.id_delito
                LEFT JOIN tipo_delito td ON del.id_tipo_delito = td.id_tipo_delito
                WHERE (d.nombre_completo LIKE '%$searchTerm%' OR d.rut LIKE '%$searchTerm%') 
                $comunaFilter $delitoFilter $estadoJudicialFilter";
    } else {
        $sql = "SELECT d.id_delincuente, d.nombre_completo, d.rut, d.edad, d.genero, d.apodo, d.antecedentes, 
                       d.foto, d.nacionalidad, d.id_sector, d.estado_judicial, d.direccion_particular, c.nombre_comuna,
                       td.nombre_tipo AS tipo_delito, td.descripcion AS descripcion_tipo_delito,
                       del.fecha AS fecha_delito, del.descripcion AS descripcion_delito, 
                       del.latitud AS latitud_delito, del.longitud AS longitud_delito
                FROM delincuente d 
                LEFT JOIN comuna c ON d.id_comuna = c.id_comuna
                LEFT JOIN delito_delincuente dd ON d.id_delincuente = dd.id_delincuente
                LEFT JOIN delito del ON dd.id_delito = del.id_delito
                LEFT JOIN tipo_delito td ON del.id_tipo_delito = td.id_tipo_delito
                WHERE 1=1 $comunaFilter $sectorFilter $delitoFilter $estadoJudicialFilter $fechaFilter";
    }
}

$result = $conn->query($sql);

$delincuentesMostrados = [];

while ($row = $result->fetch_assoc()) {
    $idDelincuente = $row["id_delincuente"];
    
    // Si ya se mostró este delincuente, saltar a la siguiente iteración
    if (in_array($idDelincuente, $delincuentesMostrados)) {
        continue;
    }

    $delincuentesMostrados[] = $idDelincuente;

    echo '<div class="custom-card">';
    echo '<img src="/SIPC/' . $row["foto"] . '" class="card-img-top" alt="Foto de ' . $row["nombre_completo"] . '">';
    echo '<div class="card-body">';
    echo '    <h3 class="card-title"><strong>' . $row["nombre_completo"] . '</strong></h3>';
    echo '    <p class="card-text"><strong>Apodo:</strong> ' . $row["apodo"] . '</p>';
    echo '    <p class="card-text"><strong>Edad:</strong> ' . $row["edad"] . '</p>';
    echo '    <p class="card-text"><strong>Género:</strong> ' . $row["genero"] . '</p>';
    echo '    <p class="card-text"><strong>Estado Judicial:</strong> ' . $row["estado_judicial"] . '</p>';
    echo '    <p class="card-text"><strong>Domicilio particular:</strong> ' . $row["direccion_particular"] . '</p>';
    echo '    <p class="card-text"><strong>Comuna residencia:</strong> ' . $row["nombre_comuna"] . '</p>';
    echo '    <br><br>';
    echo '    <button class="btn btn-solicitar w-100" data-id="' . $row["id_delincuente"] . '" data-bs-toggle="modal" data-bs-target="#modalDelincuente">Ver Detalles</button>';
    echo '</div>';
    echo '</div>';
}

?>
    </div>
	
</div>

<!-- Modal -->
<div class="modal fade" id="modalDetalles" tabindex="-1" aria-labelledby="modalDetallesLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalDetallesLabel">Detalles del Delincuente</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body" id="delincuenteDetalles">
                <!-- Los detalles del delincuente se cargarán aquí -->
            </div>
			<div id="mapa" style="height: 400px; width: 100%;"></div>

        </div>
    </div>
</div>

<!-- Funcion de detalles de tarjeta -->
<script>
    // Al hacer clic en el botón "Ver Detalles"
$(document).ready(function() {
    $('.btn-solicitar').on('click', function() {
        var delincuenteId = $(this).data('id'); // Obtén el ID del delincuente

        $.ajax({
            url: 'http://localhost/SIPC/controladores/get_delincuentes.php',
            type: 'POST',
            data: { id_delincuente: delincuenteId },
            beforeSend: function() {
                $('#delincuenteDetalles').html('<div class="text-center"><img src="loading.gif" alt="Cargando..."></div>');
            },
            success: function(response) {
                $('#delincuenteDetalles').html(response);
                $('#modalDetalles').modal('show');
            }
        });
    });
});
</script>
<!-- Funcion de boton generar reporte en el modal -->
<script>
function generarReporte(id) {
    window.open("reporte_delincuente.php?id=" + id, "_blank");
}
</script>

<!-- Funcion de busqueda por nombre y rut de tarjeta -->
<script>
    // Función que se ejecuta cuando el usuario escribe en el campo de búsqueda
    function buscarDelincuentes() {
        var input, filter, table, rows, td, i, txtValue;
        input = document.getElementById("searchInput"); // ID del campo de búsqueda
        filter = input.value.toUpperCase(); // Convierte a mayúsculas para hacer la búsqueda insensible a mayúsculas/minúsculas
        table = document.getElementById("delincuenteTable"); // ID de la tabla que contiene los delincuentes
        rows = table.getElementsByTagName("tr");

        // Recorremos todas las filas de la tabla (empezando desde la fila 1 para omitir la cabecera)
        for (i = 1; i < rows.length; i++) {
            td = rows[i].getElementsByTagName("td")[1]; // La columna "Nombre Completo" está en la segunda columna (índice 1)
            if (td) {
                txtValue = td.textContent || td.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    rows[i].style.display = ""; // Muestra la fila si coincide con la búsqueda
                } else {
                    rows[i].style.display = "none"; // Oculta la fila si no coincide con la búsqueda
                }
            }
        }
    }
</script>

<!-- Modal Ranking -->
<div id="modalDelitos" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:9999;">
    <div style="background:white; margin:5% auto; padding:20px; width:80%; position:relative;">
        <span id="closeModal" style="position:absolute; top:10px; right:20px; cursor:pointer;">&times;</span>
        <h2>Ranking de delitos por sector</h2>

        <label>Desde: <input type="date" id="fechaInicio"></label>
        <label>Hasta: <input type="date" id="fechaFin"></label>
        <button id="btnBuscar">Buscar</button>

        <div id="resultadoDelitos" style="margin-top:20px;">
            <p>Selecciona un rango de fechas para ver los resultados.</p>
        </div>
    </div>
</div>

<!-- JavaScript para abrir y cerrar el modal ranking -->
<script>
document.addEventListener("DOMContentLoaded", function () {
    const openModalBtn = document.getElementById("openModal");
    const closeModalBtn = document.getElementById("closeModal");
    const modal = document.getElementById("modalDelitos");

    openModalBtn.addEventListener("click", function (e) {
        e.preventDefault();
        modal.style.display = "block";
    });

    closeModalBtn.addEventListener("click", function () {
        modal.style.display = "none";
    });

    document.getElementById("btnBuscar").addEventListener("click", function () {
        let desde = document.getElementById("fechaInicio").value;
        let hasta = document.getElementById("fechaFin").value;

        if (!desde || !hasta) {
            alert("Por favor selecciona ambas fechas.");
            return;
        }

        fetch('/SIPC/controladores/obtener_delito.php?desde=' + encodeURIComponent(desde) + '&hasta=' + encodeURIComponent(hasta))
        .then(res => res.json())
        .then(data => {
            let contenedor = document.getElementById("resultadoDelitos");
            contenedor.innerHTML = "";

            if (data.length === 0) {
                contenedor.innerHTML = "<p>No hay registro de delitos en el rango de fecha seleccionado.</p>";
                return;
            }

            let tabla = "<table border='1'><tr><th>Fechas</th><th>Sector</th><th>Tipo Delito</th><th>Cantidad</th></tr>";

            data.forEach(d => {
                tabla += "<tr>" +
                    "<td>" + d.fecha_inicio + " - " + d.fecha_fin + "</td>" +
                    "<td>" + d.nombre_sector + "</td>" +
                    "<td>" + d.tipo_delito + "</td>" +
                    "<td>" + d.cantidad + "</td>" +
                    "</tr>";
            });

            tabla += "</table>";
            contenedor.innerHTML = tabla;
            document.getElementById("resultadoDelitos").scrollIntoView({ behavior: "smooth" });
        });
    });
});
</script>


<!-- Cargar Google Maps API -->
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA3wzdatwG0njMap89LqBnbWdGFfd73Vsk=initMap"></script>

</br></br></br>

<div>
    <button class="boton-reporteGeneral" onclick="window.location.href='/SIPC/vistas/instituciones/carabineros/reporte_todos_delincuentes.php'">Generar reporte</button>
</div>

<!-- boton de generar reporte general -->
<script>
    function generarReporteGeneral() {
        // Redirige a la página de reporte de todos los delincuentes
        window.location.href = '/SIPC/reporte_todos_delincuentes.php';
    }
</script>


</br></br></br>

<footer>
    &copy; 2025 Sistema Integrado de Prevención de Crímenes (SIPC) - Todos los derechos reservados.
</footer>
</body>
</html>