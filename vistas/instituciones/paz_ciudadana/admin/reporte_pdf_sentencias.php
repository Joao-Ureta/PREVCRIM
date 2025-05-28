<!-- PESTAÑA REPORTE PDF ADMIN PAZ CIUDADANA -->
<?php
// Evitar que cualquier warning o notice interfiera con el PDF
error_reporting(0);
ini_set('display_errors', 0);

require __DIR__ . '/../../../../vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;

// Conexión a la base de datos
include_once($_SERVER['DOCUMENT_ROOT'] . '/SIPC/config/config.php');

// Parámetros del formulario con escape para seguridad
$fecha_sentencia = $conn->real_escape_string($_POST['fecha_sentencia'] ?? '');
$delincuente = $conn->real_escape_string($_POST['delincuente'] ?? '');
$tribunal = $conn->real_escape_string($_POST['tribunal'] ?? '');

// Construcción de la consulta
$sql = "
    SELECT 
        s.id_sentencia, 
        s.fecha_sentencia, 
        s.condena, 
        d.fecha AS fecha_delito, 
        td.nombre_tipo AS tipo_delito, 
        CONCAT(d1.nombre_completo, ' (', d1.rut, ')') AS delincuente,
        t.nombre AS tribunal
    FROM sentencia s
    JOIN delincuente d1 ON s.id_delincuente = d1.id_delincuente
    JOIN delito d ON s.id_delito = d.id_delito
    JOIN tipo_delito td ON d.id_tipo_delito = td.id_tipo_delito
    JOIN tribunales t ON s.id_tribunal = t.id_tribunal
    WHERE 1=1
";

if ($fecha_sentencia) {
    $sql .= " AND s.fecha_sentencia = '$fecha_sentencia'";
}
if ($delincuente) {
    $sql .= " AND CONCAT(d1.nombre_completo, ' ', d1.rut) LIKE '%$delincuente%'";
}
if ($tribunal) {
    $sql .= " AND t.id_tribunal = '$tribunal'";
}

$result = $conn->query($sql);
if (!$result) {
    // Mejor no hacer die, sino mostrar tabla vacía en PDF
    $sentencias = [];
} else {
    $sentencias = [];
    while ($row = $result->fetch_assoc()) {
        $sentencias[] = $row;
    }
}

// Limpiar buffers previos y empezar captura limpia
if (ob_get_length()) ob_end_clean();
ob_start();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        .logo {
            text-align: center;
            margin-bottom: 20px;
        }
        .logo img {
            width: 100px;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            page-break-inside: auto;
        }
        thead {
            background-color: #2c3e50;
            color: white;
            display: table-header-group; /* Que el encabezado se repita si hay salto de página */
        }
        th, td {
            border: 1px solid #333;
            padding: 6px;
            text-align: center;
            vertical-align: middle;
        }
        tbody tr {
            page-break-inside: avoid;
            page-break-after: auto;
        }
    </style>
</head>
<body>

    <h2>Reporte de Sentencias</h2>
    <table>
        <thead>
            <tr>
                <th>ID Sentencia</th>
                <th>Fecha Sentencia</th>
                <th>Condena</th>
                <th>Fecha Delito</th>
                <th>Tipo Delito</th>
                <th>Delincuente</th>
                <th>Tribunal</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($sentencias) > 0): ?>
                <?php foreach ($sentencias as $row): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['id_sentencia']) ?></td>
                        <td><?= htmlspecialchars($row['fecha_sentencia']) ?></td>
                        <td><?= htmlspecialchars($row['condena']) ?></td>
                        <td><?= htmlspecialchars($row['fecha_delito']) ?></td>
                        <td><?= htmlspecialchars($row['tipo_delito']) ?></td>
                        <td><?= htmlspecialchars($row['delincuente']) ?></td>
                        <td><?= htmlspecialchars($row['tribunal']) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="7">No se encontraron sentencias.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>

<?php
$html = ob_get_clean();

// Opciones Dompdf
$options = new Options();
$options->set('isRemoteEnabled', true); // Permite cargar imágenes remotas (si hay)

// Inicializar Dompdf
$dompdf = new Dompdf($options);
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'landscape');

// Renderizar PDF
$dompdf->render();

// Forzar descarga
$nombreArchivo = "reporte_sentencias_" . date('Y-m-d') . ".pdf";
$dompdf->stream($nombreArchivo, ["Attachment" => true]);
exit; // Muy importante para evitar salida extra
