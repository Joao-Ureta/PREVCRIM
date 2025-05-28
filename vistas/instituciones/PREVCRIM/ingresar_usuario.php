<?php
include("../../../config/config.php");

$mensaje = "";

// Función para validar el RUT con el algoritmo del módulo 11
function validarRut($rut) {
    // Eliminar puntos y guion
    $rut = str_replace(['.', '-'], '', $rut);

    // Verificar si el RUT tiene al menos 2 caracteres
    if (strlen($rut) < 2) {
        return false;
    }

    // Obtener el dígito verificador
    $digito = substr($rut, -1);
    $numero = substr($rut, 0, -1);

    // Comprobar que el dígito verificador es un número o una letra 'k'
    if (!is_numeric($digito) && strtolower($digito) != 'k') {
        return false;
    }

    // Calcular el dígito verificador usando el módulo 11
    $suma = 0;
    $factor = 2;
    for ($i = strlen($numero) - 1; $i >= 0; $i--) {
        $suma += $numero[$i] * $factor;
        $factor = $factor == 7 ? 2 : $factor + 1;
    }

    $resto = $suma % 11;
    $dv = 11 - $resto;

    if ($dv == 11) {
        $dv = 0;
    } elseif ($dv == 10) {
        $dv = 'k';
    }

    // Comparar el dígito verificador calculado con el ingresado
    return strtolower($digito) == strtolower($dv);
}

// Obtener instituciones desde la base de datos
$sqlInstituciones = "SELECT id_institucion, nombre_institucion FROM institucion";
$resultadoInstituciones = $conn->query($sqlInstituciones);

// Procesar formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = trim($_POST["nombre_completo"]);
    $rut = trim($_POST["rut"]);
    $correo = trim($_POST["correo"]);
    $contrasena = $_POST["contrasena"];
    $confirmar_contrasena = $_POST["confirmar_contrasena"];
    $rol = $_POST["rol"];
    $institucion = $_POST["id_institucion"];

    // Validación de RUT
    if (!validarRut($rut)) {
        $mensaje = "<div class='alert alert-danger'>El RUT ingresado no es válido.</div>";
    }
    // Validación de contraseña segura
    elseif (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/", $contrasena)) {
        $mensaje = "<div class='alert alert-danger'>La contraseña debe tener al menos 8 caracteres, incluir una mayúscula, una minúscula, un número y un carácter especial.</div>";
    } elseif ($contrasena !== $confirmar_contrasena) {
        $mensaje = "<div class='alert alert-danger'>Las contraseñas no coinciden.</div>";
    } else {
        // Verificar RUT o correo duplicado
        $stmt = $conn->prepare("SELECT * FROM usuario WHERE rut = ? OR correo = ?");
        $stmt->bind_param("ss", $rut, $correo);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado->num_rows > 0) {
            $mensaje = "<div class='alert alert-danger'>El RUT o correo ya están registrados.</div>";
        } else {
            // Encriptar contraseña
            $contrasena_encriptada = password_hash($contrasena, PASSWORD_DEFAULT);

            // Insertar usuario
            $insert = $conn->prepare("INSERT INTO usuario (nombre_completo, rut, correo, contrasena, rol, id_institucion) VALUES (?, ?, ?, ?, ?, ?)");
            $insert->bind_param("sssssi", $nombre, $rut, $correo, $contrasena_encriptada, $rol, $institucion);
            if ($insert->execute()) {
                $mensaje = "<div class='alert alert-success'>Usuario registrado correctamente.</div>";
            } else {
                $mensaje = "<div class='alert alert-danger'>Error al registrar usuario.</div>";
            }
        }
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
<title>Registro de usuarios</title>
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
			width: 80%;
			max-width: 800px;
			padding: 80px;
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
    <h2>Ingresar Nuevo Usuario</h2>
    <?= $mensaje ?>
    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Nombre completo</label>
            <input type="text" name="nombre_completo" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">RUT</label>
            <input type="text" name="rut" class="form-control" required>
            <small class="form-text text-muted">Ejemplo: 12345678-9 (sin puntos)</small>
        </div>
        <div class="mb-3">
            <label class="form-label">Correo</label>
            <input type="email" name="correo" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Contraseña</label>
            <input type="password" name="contrasena" class="form-control" required>
            <small class="form-text text-muted">
                La contraseña debe tener al menos 8 caracteres, incluir una letra mayúscula, una letra minúscula, un número y un carácter especial.
            </small>
        </div>
        <div class="mb-3">
            <label class="form-label">Confirmar Contraseña</label>
            <input type="password" name="confirmar_contrasena" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Rol</label>
            <select name="rol" class="form-select" required>
                <option value="">Seleccione un rol</option>
                <option value="Administrador">Administrador</option>
                <option value="JefeZona">JefeZona</option>
                <option value="Operador">Operador</option>
                <option value="Visitante">Visitante</option>
                <option value="AdministradorGeneral">Administrador General</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Institución</label>
            <select name="id_institucion" class="form-select" required>
                <option value="">Seleccione una institución</option>
                <?php while($row = $resultadoInstituciones->fetch_assoc()): ?>
                    <option value="<?= $row['id_institucion'] ?>"><?= $row['nombre_institucion'] ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Registrar Usuario</button>
    </form>
</div>

</br></br>
<footer>
    &copy; 2025 Sistema Integrado de Prevención de Crímenes (SIPC) - Todos los derechos reservados.
</footer>

</body>
</html>