<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/SIPC/config/config.php');

$sql = "
SELECT 
    s.id_sector, s.nombre_sector, s.latitud, s.longitud, s.radio_km,
    COUNT(d.id_delito) AS total_delitos
FROM 
    sector s
JOIN 
    delito d ON s.id_sector = d.id_sector
GROUP BY 
    s.id_sector
";

$resultado = $conn->query($sql);
$zonas = [];

while ($row = $resultado->fetch_assoc()) {
    $zonas[] = $row;
}

header('Content-Type: application/json');
echo json_encode($zonas);
?>
