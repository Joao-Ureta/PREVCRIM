<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/SIPC/config/config.php');
$conn->set_charset("utf8");

$id_tipo = intval($_GET['id_tipo']);

$sql = "
    SELECT d.fecha, d.descripcion, s.nombre_sector, i.nombre_institucion
    FROM delito d
    JOIN sector s ON d.id_sector = s.id_sector
    JOIN institucion i ON d.id_institucion = i.id_institucion
    WHERE d.id_tipo_delito = $id_tipo
    ORDER BY d.fecha DESC
";
$resultado = $conn->query($sql);

if ($resultado->num_rows > 0) {
    echo "<table><thead><tr>
    <th>Fecha</th><th>Descripción</th><th>Sector</th><th>Institución</th>
    </tr></thead><tbody>";
    while($row = $resultado->fetch_assoc()) {
        echo "<tr>
        <td>{$row['fecha']}</td>
        <td>{$row['descripcion']}</td>
        <td>{$row['nombre_sector']}</td>
        <td>{$row['nombre_institucion']}</td>
        </tr>";
    }
    echo "</tbody></table>";
} else {
    echo "No se encontraron delitos para este tipo.";
}
?>
