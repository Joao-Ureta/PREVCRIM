<?php
include("../../../config/config.php");

if (!isset($_GET['id_usuario'])) {
    echo "ID no especificado.";
    exit;
}

$id_usuario = $_GET['id_usuario'];

// Obtener los datos actuales
$sql = "SELECT * FROM usuario WHERE id_usuario=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_usuario);
$stmt->execute();
$resultado = $stmt->get_result();
$usuario = $resultado->fetch_assoc();

if (!$usuario) {
    echo "Usuario no encontrado.";
    exit;
}

// Procesar el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre_completo'];
    $rut = $_POST['rut'];
    $correo = $_POST['correo'];
    $rol = $_POST['rol'];
    $nueva_contrasena = $_POST['contrasena'];

    // Verificar si el RUT o correo ya existen en otro usuario
    $verifica = $conn->prepare("SELECT id_usuario FROM usuario WHERE (rut = ? OR correo = ?) AND id_usuario != ?");
    $verifica->bind_param("ssi", $rut, $correo, $id_usuario);
    $verifica->execute();
    $verifica->store_result();

    if ($verifica->num_rows > 0) {
        $mensaje = "<div class='alert alert-danger'>El RUT o correo ya están registrados en otro usuario.</div>";
    } else {
        if (!empty($nueva_contrasena)) {
            $hash = password_hash($nueva_contrasena, PASSWORD_DEFAULT);
            $sql = "UPDATE usuario SET nombre_completo=?, rut=?, correo=?, rol=?, contrasena=? WHERE id_usuario=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssssi", $nombre, $rut, $correo, $rol, $hash, $id_usuario);
        } else {
            $sql = "UPDATE usuario SET nombre_completo=?, rut=?, correo=?, rol=? WHERE id_usuario=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssi", $nombre, $rut, $correo, $rol, $id_usuario);
        }

        if ($stmt->execute()) {
            $mensaje = "<div class='alert alert-success'>Usuario actualizado correctamente.</div>";
            // Refrescar los datos del usuario actualizado
            $sql = "SELECT * FROM usuario WHERE id_usuario=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $id_usuario);
            $stmt->execute();
            $usuario = $stmt->get_result()->fetch_assoc();
        } else {
            $mensaje = "<div class='alert alert-danger'>Error al actualizar: " . $conn->error . "</div>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Modificar Usuario</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  
  <style>
  
  body {
            font-family: Arial, sans-serif;
            background-color: #C0C0C0;
            color: white;
            text-align: center;
            margin-top: 0;
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
			background-color:#808080;
			border-radius: 10px;
			box-shadow: 0 10px 20px rgba(0, 0, 0, 0.90); /* Efecto de sombra con relieve */
			margin: 50px auto; /* Centra horizontalmente y añade margen superior/inferior */
			
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
		
		label.form-label {
    font-weight: bold;
    color: white;
    text-align: left;
    display: block;
  }

  small.form-text {
    color: white !important;
  }

  .btn btn-secondary {
    background-color: #2E8B57;
    color: white;
    font-weight: bold;
    border: none;
    display: block;
    margin: 0 auto;
    padding: 10px 20px;
  }

  .btn btn-secondary {
    background-color: #00FF7F;
  }

  input.form-control {
    border-radius: 6px;
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
        <img src="/SIPC/estaticos/img/logo_prevcrim6.png" alt="PREVCRIM" width="120">
		<a class="navbar-brand" href="admin_general.php">Administrador PREVCRIM</a>
    </div>
  </div>
</nav>


<div class="container mt-5">
  <h2>Modificar Usuario</h2>
  <?= isset($mensaje) ? $mensaje : "" ?>

</br></br>
  <form method="POST">
    <div class="mb-3">
      <label class="form-label">Nombre completo</label>
      <input type="text" name="nombre_completo" class="form-control" value="<?= htmlspecialchars($usuario['nombre_completo']) ?>" required>
    </div>

    <div class="mb-3">
      <label class="form-label">RUT</label>
      <input type="text" name="rut" class="form-control" value="<?= htmlspecialchars($usuario['rut']) ?>" required>
	  <small class="form-text text-muted">Ejemplo: 12345678-9 (sin puntos)</small>
    </div>

    <div class="mb-3">
      <label class="form-label">Correo</label>
      <input type="email" name="correo" class="form-control" value="<?= htmlspecialchars($usuario['correo']) ?>" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Rol</label>
      <select name="rol" class="form-select" required>
        <?php
        $roles = ['Administrador', 'JefeZona', 'Operador', 'Visitante', 'AdministradorGeneral'];
        foreach ($roles as $rol_opcion) {
          $selected = ($usuario['rol'] == $rol_opcion) ? 'selected' : '';
          echo "<option value='$rol_opcion' $selected>$rol_opcion</option>";
        }
        ?>
      </select>
    </div>

    <div class="mb-3">
      <label class="form-label">Nueva contraseña <small>(dejar en blanco si no desea cambiarla)</small></label>
      <input type="password" name="contrasena" class="form-control">
	  <small class="form-text text-muted">
      La contraseña debe tener al menos 8 caracteres, incluir una letra mayúscula, una letra minúscula, un número y un carácter especial.
    </small>
    </div>

    <button type="submit" class="btn btn-primary">Guardar cambios</button>
    <a href="listar_usuarios.php" class="btn btn-secondary">Volver</a>
  </form>
</div>
</br></br>
<footer>
    &copy; 2025 Sistema Integrado de Prevención de Crímenes (SIPC) - Todos los derechos reservados.
</footer>

</body>
</html>