<?php
include("../../../config/config.php");

// Verificar si hay ID recibido por GET
if (!isset($_GET['id'])) {
    echo "ID no proporcionado";
    exit;
}

$id = $_GET['id'];

// Obtener datos actuales
$sql = "SELECT * FROM institucion WHERE id_institucion = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows == 0) {
    echo "Institución no encontrada";
    exit;
}

$institucion = $resultado->fetch_assoc();

// Obtener comunas para el select
$comunas = $conn->query("SELECT * FROM comuna");

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

<title>Listado de instituciones</title>
	
	        <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #C0C0C0;
            color: white;
            text-align: center;
            margin-top: 0;
        } 
        .container {
            display: flex;
			flex-direction: column; /* Asegura que los elementos dentro estén en columna */
			justify-content: center;
			align-items: center;
			text-align: left;
			width: 80%;
			max-width: 800px;
			padding: 80px;
			background-color:#0b6623;
			border-radius: 10px;
			box-shadow: 0 10px 20px rgba(0, 0, 0, 0.90); /* Efecto de sombra con relieve */
			margin: 50px auto; /* Centra horizontalmente y añade margen superior/inferior */
        }
		
		  input.form-control {
    border-radius: 6px;
  }
	
		
		.dropdown-menu {
			background-color: #A9A9A9;
		  }

		  .dropdown-item:hover {
			background-color: #808080;
		  }
		
        label, p {
            font-weight: bold;
            margin-top: 10px;
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
            background-color: #1E90FF;
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
		
		.contenido {
            padding: 20px;
        }

        .bienvenida {
            background: white;
			color: black;
            padding: 20px;
            border-radius: 6px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }	
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg" style="background-color: #808080;">
  <div class="container-fluid">
    <div class="logo-container" style="margin-right: 40px;">
        <img src="/SIPC/estaticos/img/logo_prevcrim6.png" alt="PREVCRIM" width="120">
		<a class="navbar-brand" href="admin_general.php">Administrador PREVCRIM</a>
    </div>
  </div>
</nav>

</br></br>

<div class="container mt-5" style="background-color: #808080;">
    <h2 class="text-center mb-4">Modificar Institución</h2>
    <form action="../../../controladores/actualizar_institucion.php" method="post">
      <input type="hidden" name="id" value="<?php echo $institucion['id_institucion']; ?>">

      <div class="mb-3">
        <label for="nombre_institucion" class="form-label">Nombre:</label>
        <input type="text" class="form-control" name="nombre_institucion" required value="<?php echo $institucion['nombre_institucion']; ?>">
      </div>

      <div class="mb-3">
        <label for="direccion" class="form-label">Dirección:</label>
        <input type="text" class="form-control" name="direccion" required value="<?php echo $institucion['direccion']; ?>">
      </div>

      <div class="mb-3">
        <label for="telefono" class="form-label">Teléfono:</label>
        <input type="text" class="form-control" name="telefono" required value="<?php echo $institucion['telefono']; ?>">
      </div>

      <div class="mb-3">
        <label for="correo" class="form-label">Correo:</label>
        <input type="email" class="form-control" name="correo" required value="<?php echo $institucion['correo']; ?>">
      </div>

      <div class="mb-3">
        <label for="id_comuna" class="form-label">Comuna:</label>
        <select name="id_comuna" class="form-select" required>
          <option value="">Seleccione una comuna</option>
          <?php while ($comuna = $comunas->fetch_assoc()) {
              $selected = ($comuna['id_comuna'] == $institucion['id_comuna']) ? 'selected' : '';
              echo "<option value='{$comuna['id_comuna']}' $selected>{$comuna['nombre_comuna']}</option>";
          } ?>
        </select>
      </div>

      <button type="submit" class="btn btn-success">Actualizar</button>
      <a href="listar_instituciones.php" class="btn btn-secondary">Volver</a>
    </form>
  </div>
  </br></br>
  <footer>
    &copy; 2025 Sistema Integrado de Prevención de Crímenes (SIPC) - Todos los derechos reservados.
</footer>

</body>
</html>