<!-- PESTAÑA INGRESAR DELINCUENTE ADMIN PAZ CIUDADANA -->

<?php
require_once("../../../../config/config.php"); 


// Obtener comunas y sectores para el formulario
$comunas = $conn->query("SELECT id_comuna, nombre_comuna FROM comuna");
$sectores = $conn->query("SELECT id_sector, nombre_sector FROM sector");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="Ejemplo de HRML5">
    <meta name="keywords" content="HTML5, CSS3, JavaScript">
    <meta name="viewport" content="width=device-width, initial-scale=1">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <title>Ingresar Delincuente</title>
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
			background: #C0C0C0;
		  }

		  .dropdown-item:hover {
			background-color: #A9A9A9;
		  }
		
        
        .btn-buscar {
            background-color: #808080;
            color: white;
            border: none;
            padding: 10px 15px;
            margin-top: 20px;
            font-weight: bold;
            cursor: pointer;
            border-radius: 5px;
        }
        .btn:hover {
            background-color: #D3D3D3;
            color: black;
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
            background: #C0C0C0;
            color: black;
            padding: 10px;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
        .formulario {
            background: #C0C0C0;
            padding: 20px;
			text-align: left;
            max-width: 700px;
            margin: auto;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }
        h2 { text-align: center; color: black; }
        label { font-weight: bold; margin-top: 10px; display: block; }
        input, select, textarea {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
		small.form-text {
			color: black !important;
		}
        .boton {
			background-color: #808080;
			color: white;
			font-weight: bold;
			border: none;
			display: block;
			margin: 0 auto;
			padding: 10px 20px;
		  }

		.boton:hover {
			background-color: #D3D3D3;
            color: black;
		  }

    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg" style="background-color: #C0C0C0;">
  <div class="container-fluid">
    <div class="logo-container" style="margin-right: 40px;">
        <img src="/SIPC/estaticos/img/paz_ciudadana.jpg" alt="Paz Ciudadana" width="120">
		<a class="navbar-brand" href="admin_pc.php">Administrador</a>
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
<div class="formulario">
    <h2>Formulario de Ingreso de Delincuente</h2>
	</br></br>
    <form action="../../../../controladores/guardar_delincuente_pc.php" method="POST" enctype="multipart/form-data">
	
        <label>Nombre Completo:</label>
        <input type="text" name="nombre_completo" required>

         <label>RUT:</label>
		 <input type="text" name="rut" required pattern="\d{7,8}-[kK\d]{1}" title="Ejemplo: 12345678-9" />
		 <small class="form-text text-muted">Ejemplo: 12345678-9 (sin puntos)</small>

        <label>Edad:</label>
        <input type="number" name="edad" min="10" max="120" required>

        <label>Género:</label>
        <select name="genero" required>
            <option value="">Seleccione</option>
            <option>Masculino</option>
            <option>Femenino</option>
            <option>Otro</option>
        </select>

        <label>Apodo:</label>
        <input type="text" name="apodo">

        <label>Antecedentes:</label>
        <textarea name="antecedentes" rows="3"></textarea>

        <label>Nacionalidad:</label>
        <input type="text" name="nacionalidad" required>

        <label>Estado Judicial:</label>
        <select name="estado_judicial" required>
			<option value="Libre">Libre</option>
			<option value="Preso">Preso</option>
			<option value="Orden de arresto">Orden de arresto</option>
		</select>

        <label>Comuna:</label>
        <select name="id_comuna" required>
            <option value="">Seleccione comuna</option>
            <?php while($row = $comunas->fetch_assoc()): ?>
                <option value="<?= $row['id_comuna'] ?>"><?= $row['nombre_comuna'] ?></option>
            <?php endwhile; ?>
        </select>

        <label>Dirección Particular:</label>
        <input type="text" name="direccion_particular" required>

        <label>Nivel de Peligrosidad:</label>
        <select name="nivel_peligrosidad" required>
            <option value="Bajo">Bajo</option>
            <option value="Medio" selected>Medio</option>
            <option value="Alto">Alto</option>
        </select>

        <label>Sector:</label>
        <select name="id_sector" required>
            <option value="">Seleccione sector</option>
            <?php while($row = $sectores->fetch_assoc()): ?>
                <option value="<?= $row['id_sector'] ?>"><?= $row['nombre_sector'] ?></option>
            <?php endwhile; ?>
        </select>

        <label>Foto del delincuente:</label>
        <input type="file" name="foto" accept="image/*">
</br></br>
        <button type="submit" class="boton">Guardar delincuente</button>
    </form>
</div>

</br></br></br></br>

<script>
    function validarRUT(rut) {
        // Eliminar espacios y convertir a mayúsculas
        rut = rut.replace(/\s/g, '').toUpperCase();

        // Validación básica: verificar que tenga el formato correcto
        var expReg = /^\d{7,8}-[0-9Kk]{1}$/;
        if (!expReg.test(rut)) {
            alert("RUT no tiene un formato válido.");
            return false;
        }

        // Separar el RUT y el dígito verificador
        var [numero, dv] = rut.split('-');
        var suma = 0;
        var multiplo = 2;

        // Recorrer los números del RUT de atrás hacia adelante
        for (var i = numero.length - 1; i >= 0; i--) {
            suma += parseInt(numero.charAt(i)) * multiplo;
            multiplo = (multiplo == 7) ? 2 : multiplo + 1;
        }

        // Calcular el dígito verificador
        var dvCalculado = 11 - (suma % 11);
        if (dvCalculado == 11) {
            dvCalculado = '0';
        } else if (dvCalculado == 10) {
            dvCalculado = 'K';
        }

        // Comparar el dígito verificador calculado con el proporcionado
        if (dvCalculado != dv.toUpperCase()) {
            alert("El dígito verificador del RUT no es válido.");
            return false;
        }

        return true;
    }

    // Validar antes de enviar el formulario
    document.querySelector("form").addEventListener("submit", function(event) {
        var rut = document.querySelector("input[name='rut']").value;
        if (!validarRUT(rut)) {
            event.preventDefault(); // Evitar que el formulario se envíe si el RUT es inválido
        }
    });
</script>



<footer>
    &copy; 2025 Sistema Integrado de Prevención de Crímenes (SIPC) - Todos los derechos reservados.
</footer>

</body>
</html>

