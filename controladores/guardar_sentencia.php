<?php
// Conectar a la base de datos
require_once('../config/config.php');

// Verifica conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}


// Validar si llegaron los datos esperados
if (
    isset($_POST['id_delincuente']) &&
    isset($_POST['id_delito']) &&
    isset($_POST['id_tribunal']) &&  
    isset($_POST['fecha']) &&
    isset($_POST['condena'])
) {
    // Sanitizar entradas
    $id_delincuente = $conn->real_escape_string($_POST['id_delincuente']);
    $id_delito = $conn->real_escape_string($_POST['id_delito']);
    $id_tribunal = $conn->real_escape_string($_POST['id_tribunal']);
    $fecha_sentencia = $conn->real_escape_string($_POST['fecha']);
    $condena = $conn->real_escape_string($_POST['condena']);

    // Consulta SQL
    $sql = "INSERT INTO sentencia (id_delincuente, id_tribunal, fecha_sentencia, condena, id_delito)
            VALUES ('$id_delincuente', '$id_tribunal', '$fecha_sentencia', '$condena', '$id_delito')";

    // Ejecutar y verificar
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Sentencia registrada correctamente'); window.location.href='../vistas/instituciones/carabineros/operador/ver_sentencia.php';</script>";
    } else {
        echo "Error al guardar la sentencia: " . $conn->error;
    }
} else {
    echo "Faltan datos obligatorios del formulario.";
}


$conn->close();
?>

