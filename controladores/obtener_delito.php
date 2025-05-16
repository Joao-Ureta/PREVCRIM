<?php
// Incluir el archivo de conexión a la base de datos
include_once '../config/config.php';



if (!isset($_GET['desde']) || !isset($_GET['hasta'])) {
    echo json_encode(["error" => "Faltan fechas"]);
    exit;
}

$desde = $_GET['desde'];
$hasta = $_GET['hasta'];

$sql = "
    SELECT 
        ? AS fecha_inicio,
        ? AS fecha_fin,
        s.nombre_sector,
        td.nombre_tipo AS tipo_delito,
        COUNT(d.id_delito) AS cantidad,
        s.latitud,
        s.longitud
    FROM delito d
    JOIN tipo_delito td ON d.id_tipo_delito = td.id_tipo_delito
    JOIN sector s ON d.id_sector = s.id_sector
    WHERE d.fecha BETWEEN ? AND ?
    GROUP BY s.nombre_sector, td.nombre_tipo, s.latitud, s.longitud
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ssss", $desde, $hasta, $desde, $hasta);
$stmt->execute();
$result = $stmt->get_result();

$delitos = [];
while ($row = $result->fetch_assoc()) {
    $delitos[] = $row;
}

echo json_encode($delitos);
?>





