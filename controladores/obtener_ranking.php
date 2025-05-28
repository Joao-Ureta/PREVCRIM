<?php
// Incluir el archivo de conexión a la base de datos
include_once($_SERVER['DOCUMENT_ROOT'] . '/SIPC/controladores/obtener_ranking.php');

// Verificar si las fechas fueron enviadas
if (isset($_POST['fechaInicio']) && isset($_POST['fechaFin'])) {
    $fecha_inicio = $_POST['fechaInicio'];
    $fecha_fin = $_POST['fechaFin'];

    // Sanitizar las fechas para prevenir SQL injection
    $fecha_inicio = $conn->real_escape_string($fecha_inicio);
    $fecha_fin = $conn->real_escape_string($fecha_fin);

    // Consulta SQL para obtener el ranking de delitos
    $sql = "
        SELECT
            s.nombre_sector,
            COUNT(d.id_delito) AS delitos,
            GROUP_CONCAT(td.nombre_tipo SEPARATOR ', ') AS tipo_delito,
            s.latitud,
            s.longitud
        FROM sector s
        LEFT JOIN delito d ON s.id_sector = d.id_sector
        LEFT JOIN tipo_delito td ON d.id_tipo_delito = td.id_tipo_delito
        WHERE d.fecha >= '$fecha_inicio' AND d.fecha <= '$fecha_fin'
        GROUP BY s.id_sector
        ORDER BY delitos DESC
    ";

    // Ejecutar la consulta
    $result = $conn->query($sql);

    // Comprobar si se obtuvieron resultados
    if ($result->num_rows > 0) {
        $ranking = [];
        while ($row = $result->fetch_assoc()) {
            $ranking[] = [
                'nombre_sector' => $row['nombre_sector'],
                'delitos' => $row['delitos'],
                'tipo_delito' => $row['tipo_delito'],
                'latitud' => $row['latitud'],
                'longitud' => $row['longitud']
            ];
        }
        echo json_encode($ranking); // Devolver los datos en formato JSON
    } else {
        echo json_encode([]); // No hay resultados
    }
} else {
    echo json_encode(['error' => 'Faltan fechas']);
}
?>






