<?php
include_once '../../../config/config.php';

// Obtener el término de búsqueda
$search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';

$sql = "SELECT id_delincuente, nombre_completo, rut, edad, genero, apodo, antecedentes, foto, nacionalidad, id_sector, estado_judicial 
        FROM delincuente";

if (!empty($search)) {
    $sql .= " WHERE nombre_completo LIKE '%$search%' OR rut LIKE '%$search%'";
}

$result = $conn->query($sql);

$delincuentes = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $delincuentes[] = $row;
    }
}

// Establecer el tipo de contenido como JSON
header('Content-Type: application/json');
echo json_encode($delincuentes);
?>

