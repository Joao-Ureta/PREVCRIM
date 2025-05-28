<!-- PESTAÑA INGRESAR USUARIO DE ADMIN CARABINEROS -->

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Nuevo Usuario</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
  

  
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
			background-color: #0e7d2d;
		  }
		
		/* Estilos para el formulario */
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
		
		label.form-label {
    font-weight: bold;
    color: white;
    text-align: left;
    display: block;
  }

  small.form-text {
    color: white !important;
  }

  .btn-success {
    background-color: #2E8B57;
    color: white;
    font-weight: bold;
    border: none;
    display: block;
    margin: 0 auto;
    padding: 10px 20px;
  }

  .btn-success:hover {
    background-color: #00FF7F;
  }

  input.form-control {
    border-radius: 6px;
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
            background-color: #0b6623;
            color: white;
            padding: 10px;
            position: fixed;
            bottom: 0;
            width: 100%;
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

  <div class="container">
    <h2>Ingresar Nuevo Usuario</h2>
	</br></br>
    <form action="../../../../controladores/guardar_usuario_admin.php" method="POST" id="formNuevoUsuario">
  <div class="mb-3">
    <label for="nombre_completo" class="form-label">Nombre completo</label>
    <input type="text" class="form-control" id="nombre_completo" name="nombre_completo" required>
  </div>

  <div class="mb-3">
    <label for="rut" class="form-label">RUT</label>
    <input type="text" class="form-control" id="rut" name="rut" required>
    <small class="form-text text-muted">Ejemplo: 12345678-9 (sin puntos)</small>
  </div>

  <div class="mb-3">
    <label for="correo" class="form-label">Correo</label>
    <input type="email" class="form-control" id="correo" name="correo" required>
  </div>

  <div class="mb-3">
    <label for="contrasena" class="form-label">Contraseña:</label>
    <input type="password" class="form-control" id="contrasena" name="contrasena" required>
    <small class="form-text text-muted">
      La contraseña debe tener al menos 8 caracteres, incluir una letra mayúscula, una letra minúscula, un número y un carácter especial.
    </small>
  </div>

  <div class="mb-3">
      <label for="rol" class="form-label">Rol</label>
      <select class="form-select" id="rol" name="rol" required>
        <option value="">Seleccione un rol</option>
        <option value="JefeZona">Jefe de Zona</option>
        <option value="Operador">Operador</option>
      </select>
    </div>
      </br></br>
  <input type="hidden" name="rol" value="Operador">

  <button type="submit" class="btn btn-success">Registrar operador</button>
</form>
  </div>

<!-- Funcion de validacion de rut Modulo 11 -->
  <script>
  // Validar RUT con Módulo 11
  function validarRUT(rut) {
    rut = rut.replace(/\./g, "").replace("-", "");
    let cuerpo = rut.slice(0, -1);
    let dv = rut.slice(-1).toUpperCase();

    let suma = 0;
    let multiplo = 2;

    for (let i = cuerpo.length - 1; i >= 0; i--) {
      suma += parseInt(cuerpo.charAt(i)) * multiplo;
      multiplo = multiplo < 7 ? multiplo + 1 : 2;
    }

    let dvEsperado = 11 - (suma % 11);
    dvEsperado = dvEsperado === 11 ? "0" : dvEsperado === 10 ? "K" : dvEsperado.toString();

    return dv === dvEsperado;
  }

  document.getElementById("formNuevoUsuario").addEventListener("submit", function(e) {
    const rut = document.getElementById("rut").value;
    const clave = document.getElementById("contrasena").value;

    if (!validarRUT(rut)) {
      e.preventDefault();
      Swal.fire("Error", "El RUT ingresado no es válido.", "error");
      return;
    }

    const regexPassword = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/;
    if (!regexPassword.test(clave)) {
      e.preventDefault();
      Swal.fire("Error", "La contraseña debe tener al menos 8 caracteres, una mayúscula, una minúscula, un número y un carácter especial.", "error");
    }
  });
</script>

</br></br></br>

<footer>
    &copy; 2025 Sistema Integrado de Prevención de Crímenes (SIPC) - Todos los derechos reservados.
</footer>

</body>
</html>