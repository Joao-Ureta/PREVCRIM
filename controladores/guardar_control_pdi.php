<!-- CONTROLADOR GUARDAR CONTROL ADMIN PDI -->

<?php
require_once('../config/config.php');

// Capturar los datos del formulario
$fecha = $_POST['fecha'];
$hora = $_POST['hora'];
$lugar_control = $_POST['lugar_control'];
$tipo_control = $_POST['tipo_control'];
$resultado = $_POST['resultado'];
$observaciones = !empty($_POST['observaciones']) ? $_POST['observaciones'] : null;
$id_delincuente = !empty($_POST['id_delincuente']) ? $_POST['id_delincuente'] : null;
$id_usuario = $_POST['id_usuario'];
$id_institucion = $_POST['id_institucion']; // Nuevo campo obligatorio
$id_sector = !empty($_POST['id_sector']) ? $_POST['id_sector'] : null;
$latitud = !empty($_POST['latitud']) ? $_POST['latitud'] : null;
$longitud = !empty($_POST['longitud']) ? $_POST['longitud'] : null;

// Preparar la consulta SQL con el campo id_institucion agregado
$sql = "INSERT INTO control 
    (fecha, hora, lugar_control, tipo_control, resultado, observaciones, id_delincuente, id_usuario, id_institucion, id_sector, latitud, longitud)
VALUES 
    (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);

if ($stmt === false) {
    die("Error en la preparación de la consulta: " . $conn->error);
}

// Enlazar los parámetros (12 en total ahora)
$stmt->bind_param(
    "ssssssiiiidd", 
    $fecha,
    $hora,
    $lugar_control,
    $tipo_control,
    $resultado,
    $observaciones,
    $id_delincuente,
    $id_usuario,
    $id_institucion,
    $id_sector,
    $latitud,
    $longitud
);

if ($stmt->execute()) {
    echo "<script>
            alert('¡Control registrado exitosamente!');
            window.location.href = '../vistas/instituciones/pdi/admin/ver_controles.php';
          </script>";
} else {
    echo "Error al registrar el control: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>


