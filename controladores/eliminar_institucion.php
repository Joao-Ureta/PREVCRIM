<?php
include_once '../config/config.php'; // Ajusta según tu estructura

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM institucion WHERE id_institucion = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: ../vistas/instituciones/PREVCRIM/listar_instituciones.php"); // Redirige después de eliminar
        exit();
    } else {
        echo "Error al eliminar la institución.";
    }
} else {
    echo "ID no proporcionado.";
}
?>
