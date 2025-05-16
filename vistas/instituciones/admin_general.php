<?php
session_start();
if ($_SESSION['rol'] != 'AdministradorGeneral') {
    header("Location: login.php");
    exit;
}
include_once '../../config/config.php';


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



    <title>Administrador PREVCRIM</title>
	
	        <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #C0C0C0;
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
    grid-template-columns: repeat(4, 1fr); /* 4 tarjetas por fila */
    gap: 20px; /* Espaciado uniforme */
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
	width: 25%; /* Que ocupe el ancho de su columna */
}

.card-img-top {
    width: 100%;
    height: 280px; /* Altura fija para las imágenes */
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

/* Botón */
.btn-solicitar {
    background-color: #ffffff;
    color: #2E8B57;
    font-weight: bold;
    border: none;
    padding: 10px 20px;
    cursor: pointer;
    border-radius: 5px;
    transition: background-color 0.3s, color 0.3s;
}

.btn-solicitar:hover {
    background-color: #2E8B57;
    color: white;
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
  .search-bar input,
  .search-bar button {
    color: white !important;
  }

  .dropdown-menu {
    background-color: #0b6623;
  }

  .dropdown-item:hover {
    background-color: #0e7d2d;
  }


		
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg" style="background-color: #0b6623;">
  <div class="container-fluid">
    <div class="logo-container" style="margin-right: 40px;">
        <img src="/SIPC/estaticos/img/carabineros.png" alt="Carabineros de Chile" width="120">
    </div>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Administracion de usuarios
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="mayorQue.html">Ingresar nuevo usuario</a></li>
            <li><a class="dropdown-item" href="almacen.html">Modificar usuario</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#">Something else here</a></li>
          </ul>
        </li>
		
		<li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Administracion de usuarios
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="mayorQue.html">Ingresar nuevo usuario</a></li>
            <li><a class="dropdown-item" href="almacen.html">Modificar usuario</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#">Something else here</a></li>
          </ul>
        </li>

      </ul>
      <div class="return-link">
	        <div class="search-bar">
            <input type="text" id="searchInput" placeholder="Buscar...">
			<button style="background-color: #2E8B57; color: white; border: none; padding: 6px 12px; border-radius: 4px;">Buscar</button>
        </div>
        <a href="/SIPC/public/logout.php" style="color: white;">Cerrar sesión</a>

    </div>
    </div>
  </div>
</nav>

</br></br>

<div class="container mt-5">
<div>
<h2>Listado de delincuentes</h2>
</div>
    <div class="card-columns">
        <?php
        include_once '../../config/config.php';
        $sql = "SELECT id_delincuente, nombre_completo, rut, edad, genero, apodo, antecedentes, foto, nacionalidad, id_sector, estado_judicial FROM delincuente";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<div class="custom-card">';
                echo '<img src="/SIPC/' . $row["foto"] . '" class="card-img-top" alt="Foto de ' . $row["nombre_completo"] . '">';

				echo '    <div class="card-body">';
				echo '        <h3 class="card-title"><strong>' . $row["nombre_completo"] . '</strong></h3>';
				echo '        <p class="card-text"><strong>Apodo:</strong> ' . $row["apodo"] . '</p>';
				echo '        <p class="card-text"><strong>Edad:</strong> ' . $row["edad"] . '</p>';
				echo '        <p class="card-text"><strong>Género:</strong> ' . $row["genero"] . '</p>';
				echo '        <p class="card-text"><strong>Estado Judicial:</strong> ' . $row["estado_judicial"] . '</p>';
                echo '        <br><br>'; // Salto de línea para dar espacio
                echo '        <button class="btn btn-solicitar" data-id="' . $row["id_delincuente"] . '" data-bs-toggle="modal" data-bs-target="#modalDelincuente">Ver Detalles</button>';
                echo '    </div>';
                echo '</div>';
            }
        } else {
            echo '<p>No hay delincuentes registrados.</p>';
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
<script>
success: function(response) {
    $('#delincuenteDetalles').html(response);
    $('#modalDetalles').modal('show');
},
beforeSend: function() {
    $('#delincuenteDetalles').html('<div class="text-center"><img src="loading.gif" alt="Cargando..."></div>');
}
</script>


<footer>
    &copy; 2025 Sistema Integrado de Prevención de Crímenes (SIPC) - Todos los derechos reservados.
</footer>


</body>
</html>