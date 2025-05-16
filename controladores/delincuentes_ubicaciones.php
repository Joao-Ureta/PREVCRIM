<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/SIPC/config/config.php');

// Consulta SQL para obtener la información de los delincuentes, incluyendo la ruta de la foto
$sql = "
SELECT 
    d.id_delincuente,
    d.nombre_completo,
    d.apodo,
    d.nivel_peligrosidad,
    td.nombre_tipo AS tipo_delito,
    dl.fecha AS fecha_ultimo_incidente,
    dl.latitud,
    dl.longitud,
    d.foto  -- Agregamos la columna de la foto (ajustar si el nombre de la columna es diferente)
FROM delincuente d
JOIN delito_delincuente dd ON d.id_delincuente = dd.id_delincuente
JOIN delito dl ON dd.id_delito = dl.id_delito
JOIN tipo_delito td ON dd.id_tipo_delito = td.id_tipo_delito
WHERE dl.latitud IS NOT NULL AND dl.longitud IS NOT NULL
ORDER BY dl.fecha DESC
";

$result = $conn->query($sql);
$delincuentes = [];

if ($result->num_rows > 0) {
    // Agrupar por delincuente y tomar solo la última ubicación (más reciente)
    $seen = [];
    while ($row = $result->fetch_assoc()) {
        $id = $row['id_delincuente'];
        if (!isset($seen[$id])) {
            // Aquí agregamos la información de cada delincuente, incluyendo la foto
            $delincuentes[] = [
                'id_delincuente' => $row['id_delincuente'],
                'nombre_completo' => $row['nombre_completo'],
                'apodo' => $row['apodo'],
                'nivel_peligrosidad' => $row['nivel_peligrosidad'],
                'tipo_delito' => $row['tipo_delito'],
                'fecha_ultimo_incidente' => $row['fecha_ultimo_incidente'],
                'latitud' => $row['latitud'],
                'longitud' => $row['longitud'],
                'foto' => 'http://localhost/SIPC/estaticos/img/' . $row['foto'] // Construimos la URL completa de la foto
            ];
            $seen[$id] = true;
        }
    }
}

$conn->close();

// Enviamos los datos como respuesta JSON
echo json_encode($delincuentes);
?>



