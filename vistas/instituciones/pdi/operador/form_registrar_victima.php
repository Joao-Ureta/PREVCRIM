<?php
// Conexión a la base de datos
require_once("../../../../config/config.php"); 
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <title>Registrar Víctima</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
	
	<style>
	body {
            font-family: Arial, sans-serif;
            background-color: #dcdcdc;
            color: white;
            text-align: center;
            margin-top: 0;
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
		  
		  .container {
            background-color: #0033A0;
            padding: 20px;
			text-align: left;
            max-width: 700px;
            margin: auto;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }
		
		h2 { text-align: center; color: white; }
		
		small.form-text {
			color: white !important;
		}

		.btn {
			background-color: #FFCC00;
			color: black;
			font-weight: bold;
			border: none;
			display: block;
			margin: 0 auto;
			padding: 10px 20px;
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

<div class="container mt-5">
    <h2>Registrar Nueva Víctima</h2>
    <form action="../../../../controladores/guardar_victima_pdi_op.php" method="POST">

        <div class="mb-3">
			<label for="rut">RUT</label>
			<input type="text" id="rut" name="rut" class="form-control" required>
			<small class="form-text text-muted">Ejemplo: 12345678-9 (sin puntos)</small>
		</div>

        <div class="mb-3">
            <label>Nombres</label>
            <input type="text" name="nombres" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Apellidos</label>
            <input type="text" name="apellidos" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Edad</label>
            <input type="number" name="edad" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Sexo</label>
            <select name="sexo" class="form-select" required>
                <option value="">Seleccione</option>
                <option value="Masculino">Masculino</option>
                <option value="Femenino">Femenino</option>
                <option value="Otro">Otro</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Nacionalidad</label>
            <input type="text" name="nacionalidad" class="form-control">
        </div>

        <div class="mb-3">
            <label>Dirección</label>
            <input type="text" name="direccion" class="form-control">
        </div>

        <div class="mb-3">
            <label>Teléfono</label>
            <input type="text" name="telefono" class="form-control">
        </div>

        <!-- Delito asociado (opcional) -->
        <div class="mb-3">
            <label>Delito Asociado (opcional)</label>
            <select class="form-select" name="id_delito">
                <option value="">No vincular aún</option>
                <?php
                $query = "
                    SELECT d.id_delito, d.fecha, d.descripcion, td.nombre_tipo 
                    FROM delito d
                    JOIN tipo_delito td ON d.id_tipo_delito = td.id_tipo_delito
                    ORDER BY d.fecha DESC
                ";
                $resultado = mysqli_query($conn, $query);
                while($fila = mysqli_fetch_assoc($resultado)) {
                    $desc_corta = substr($fila['descripcion'], 0, 50);
                    echo "<option value='{$fila['id_delito']}'>[{$fila['nombre_tipo']}] {$fila['fecha']} - {$desc_corta}...</option>";
                }
                ?>
            </select>
        </div>
</br></br>
        <button type="submit" class="btn btn-primary">Registrar</button>
    </form>
</div>

<script>
function validarRut($rut) {
    // Eliminar puntos y guion
    $rut = str_replace([".", "-"], "", $rut);
    
    // Verificar que el RUT tenga la longitud correcta
    if (strlen($rut) < 8 || strlen($rut) > 9) {
        return false;
    }

    // Obtener el dígito verificador (último caracter)
    $dv = strtoupper(substr($rut, -1));

    // Obtener el RUT sin el dígito verificador
    $rutNumerico = substr($rut, 0, -1);

    // Calcular el dígito verificador usando el algoritmo Módulo 11
    $suma = 0;
    $multiplicador = 2;

    for ($i = strlen($rutNumerico) - 1; $i >= 0; $i--) {
        $suma += intval($rut[$i]) * $multiplicador;
        $multiplicador = $multiplicador == 7 ? 2 : $multiplicador + 1;
    }

    $resto = $suma % 11;
    $dvCalculado = 11 - $resto;

    if ($dvCalculado == 11) $dvCalculado = '0';
    elseif ($dvCalculado == 10) $dvCalculado = 'K';

    return $dv == $dvCalculado;
}
</script>

</br></br></br></br>
<footer>
    &copy; 2025 Sistema Integrado de Prevención de Crímenes (SIPC) - Todos los derechos reservados.
</footer>

</body>
</html>
