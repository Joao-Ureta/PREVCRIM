<?php
include_once '../config/config.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $nombre = $_POST["nombre_institucion"];
    $direccion = $_POST["direccion"];
    $telefono = $_POST["telefono"];
    $correo = $_POST["correo"];
    $comuna = $_POST["id_comuna"];

    $sql = "UPDATE institucion SET nombre_institucion = ?, direccion = ?, telefono = ?, correo = ?, id_comuna = ? WHERE id_institucion = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssii", $nombre, $direccion, $telefono, $correo, $comuna, $id);

    if ($stmt->execute()) {
        header("Location: ../vistas/instituciones/PREVCRIM/listar_instituciones.php");
        exit();
    } else {
        echo "Error al actualizar la institución.";
    }
}
?>