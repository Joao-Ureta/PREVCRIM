<?php
require_once('../config/config.php');

// Obtener los datos del formulario
$fecha = $_POST['fecha'];
$descripcion = $_POST['descripcion'];
$id_tipo_delito = $_POST['id_tipo_delito'];
$id_institucion = $_POST['id_institucion'];
$id_sector = $_POST['id_sector'];

// Obtener latitud y longitud (pueden ser opcionales)
$latitud = isset($_POST['latitud']) && $_POST['latitud'] !== '' ? $_POST['latitud'] : NULL;
$longitud = isset($_POST['longitud']) && $_POST['longitud'] !== '' ? $_POST['longitud'] : NULL;

// Inserción del delito en la base de datos 
$query = "INSERT INTO delito (fecha, descripcion, id_tipo_delito, id_institucion, id_sector, latitud, longitud) 
          VALUES (?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($query);
$stmt->bind_param("ssiiidd", $fecha, $descripcion, $id_tipo_delito, $id_institucion, $id_sector, $latitud, $longitud);

// Ejecutar la consulta
if ($stmt->execute()) {
    // Obtener el ID del delito recién insertado
    $delito_id = $stmt->insert_id;

    // Guardar delincuentes involucrados
    if (isset($_POST['delincuentes']) && isset($_POST['roles'])) {
        $delincuentes = $_POST['delincuentes'];
        $roles = $_POST['roles'];

        // Preparar la consulta para insertar los delincuentes con id_tipo_delito
        $query_delincuentes = "INSERT INTO delito_delincuente (id_delito, id_delincuente, id_tipo_delito, rol_en_el_delito) 
                               VALUES (?, ?, ?, ?)";
        $stmt_delincuentes = $conn->prepare($query_delincuentes);

        // Insertar cada delincuente y su rol
        for ($i = 0; $i < count($delincuentes); $i++) {
            $id_delincuente = $delincuentes[$i];
            $rol = $roles[$i];
            $stmt_delincuentes->bind_param("iiis", $delito_id, $id_delincuente, $id_tipo_delito, $rol);
            $stmt_delincuentes->execute();
        }

        // Cerrar el statement de delincuentes
        $stmt_delincuentes->close();
    }

    // Redirigir con mensaje de éxito
    echo "<script>alert('Delito registrado exitosamente'); window.location.href='../vistas/instituciones/paz_ciudadana/operador/form_registrar_delito.php';</script>";
    exit;
} else {
    // En caso de error, redirigir con mensaje de error
    echo "<script>alert('Error al registrar el delito'); window.location.href='../vistas/instituciones/paz_ciudadana/operador/form_registrar_delito.php';</script>";
    exit;
}

// Cerrar el statement y la conexión
$stmt->close();
$conn->close();
?>





