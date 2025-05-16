<?php
include("../../../config/config.php");

// Paginación
$limit = 10; // registros por página
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;
$offset = ($page - 1) * $limit;

// Filtros
$fecha = $_GET['fecha'] ?? '';
$usuario = $_GET['usuario'] ?? '';
$usuario_param = "%$usuario%";

// Definir rango de fecha completo para el día seleccionado
if (!empty($fecha)) {
  $fecha_inicio = $fecha . " 00:00:00";
  $fecha_fin = $fecha . " 23:59:59";
} else {
  // Si no hay fecha, establecer un rango amplio que incluya todos los registros
  $fecha_inicio = '1900-01-01 00:00:00';
  $fecha_fin = '2100-12-31 23:59:59';
}


// Contar total para paginación
$count_sql = "
    SELECT COUNT(*) as total
    FROM bitacora_accesos b
    INNER JOIN usuario u ON b.id_usuario = u.id_usuario
    WHERE b.fecha_hora BETWEEN ? AND ?
      AND (u.nombre_completo LIKE ? OR ? = '')
";

$stmt = $conn->prepare($count_sql);
$stmt->bind_param("ssss", $fecha_inicio, $fecha_fin, $usuario_param, $usuario);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$total_registros = $row['total'];
$total_paginas = ceil($total_registros / $limit);

// Consulta principal con límite y offset
$sql = "
    SELECT b.id_acceso, b.fecha_hora, u.nombre_completo, b.actividad
    FROM bitacora_accesos b
    INNER JOIN usuario u ON b.id_usuario = u.id_usuario
    WHERE b.fecha_hora BETWEEN ? AND ?
      AND (u.nombre_completo LIKE ? OR ? = '')
    ORDER BY b.fecha_hora DESC
    LIMIT ? OFFSET ?
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssii", $fecha_inicio, $fecha_fin, $usuario_param, $usuario, $limit, $offset);
$stmt->execute();
$result = $stmt->get_result();
?>

<html lang="es">
  <head>
    <meta charset="UTF-8">
    <meta name="description" content="Ejemplo de HTML5">
    <meta name="keywords" content="HTML5, CSS3, JavaScript">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/SIPC/estaticos/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
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
      .container {
          display: flex;
          flex-direction: column;
          justify-content: center;
          align-items: center;
          text-align: left;
          width: 80%;
          max-width: 800px;
          padding: 80px;
          background-color:#0b6623;
          border-radius: 10px;
          box-shadow: 0 10px 20px rgba(0, 0, 0, 0.90);
          margin: 50px auto;
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
      .container {
          display: flex;
          flex-direction: column;
          justify-content: center;
          align-items: center;
          text-align: left;
          width: 50%;
          max-width: 800px;
          padding: 50px;
          background-color:#808080;
          border-radius: 10px;
          box-shadow: 0 10px 20px rgba(0, 0, 0, 0.90);
          margin: 50px auto;
      }
      label, p {
          font-weight: bold;
          margin-top: 10px;
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
        <img src="/SIPC/estaticos/img/logo_prevcrim6.png" alt="PREVCRIM" width="120">
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

<br><br>

<div class="container mt-4">
    <h2>Bitácora de Accesos</h2>

    <form method="GET" class="row g-3 mb-4">
        <div class="col-md-4">
            <label for="fecha" class="form-label">Fecha</label>
            <input type="date" class="form-control" id="fecha" name="fecha" value="<?= htmlspecialchars($fecha) ?>" required>
        </div>
        <div class="col-md-4">
            <label for="usuario" class="form-label">Nombre Usuario</label>
            <input type="text" class="form-control" id="usuario" name="usuario" placeholder="Buscar por nombre" value="<?= htmlspecialchars($usuario) ?>">
        </div>
        <div class="col-md-4 d-flex align-items-end">
            <button type="submit" class="btn btn-primary w-100">Filtrar</button>
        </div>
    </form>

    <table class="table table-bordered table-striped table-hover bg-light text-dark">
        <thead class="table-dark">
            <tr>
                <th>Fecha y Hora</th>
                <th>Usuario</th>
                <th>Actividad</th>
            </tr>
        </thead>
        <tbody>
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['fecha_hora']) ?></td>
                    <td><?= htmlspecialchars($row['nombre_completo']) ?></td>
                    <td><?= htmlspecialchars($row['actividad']) ?></td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="3" class="text-center">No se encontraron registros.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>

    <!-- Paginación -->
    <nav>
        <ul class="pagination justify-content-center">
            <?php if ($page > 1): ?>
                <li class="page-item">
                    <a class="page-link" href="?<?= http_build_query(array_merge($_GET, ['page' => $page-1])) ?>">Anterior</a>
                </li>
            <?php else: ?>
                <li class="page-item disabled"><span class="page-link">Anterior</span></li>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $total_paginas; $i++): ?>
                <li class="page-item <?= ($i === $page) ? 'active' : '' ?>">
                    <a class="page-link" href="?<?= http_build_query(array_merge($_GET, ['page' => $i])) ?>"><?= $i ?></a>
                </li>
            <?php endfor; ?>

            <?php if ($page < $total_paginas): ?>
                <li class="page-item">
                    <a class="page-link" href="?<?= http_build_query(array_merge($_GET, ['page' => $page+1])) ?>">Siguiente</a>
                </li>
            <?php else: ?>
                <li class="page-item disabled"><span class="page-link">Siguiente</span></li>
            <?php endif; ?>
        </ul>
    </nav>
</div>

<footer>
    &copy; 2025 Sistema Integrado de Prevención de Crímenes (SIPC) - Todos los derechos reservados.
</footer>

</body>
</html>