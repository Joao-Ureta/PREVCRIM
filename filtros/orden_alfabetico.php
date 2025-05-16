<?php
// Conexión a la base de datos
include('../config/config.php');

// Consultar los delincuentes ordenados por nombre completo en orden alfabético
$sql = "SELECT * FROM delincuente ORDER BY nombre_completo ASC";
$result = mysqli_query($conn, $sql);

if ($result) {
    // Mostrar los resultados en una tabla
    echo "<table>";
    echo "<tr><th>Nombre Completo</th><th>RUT</th><th>Edad</th><th>Género</th><th>Estado Judicial</th></tr>";

    // Recorrer los resultados y mostrar cada delincuente
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row['nombre_completo'] . "</td>";
        echo "<td>" . $row['rut'] . "</td>";
        echo "<td>" . $row['edad'] . "</td>";
        echo "<td>" . $row['genero'] . "</td>";
        echo "<td>" . $row['estado_judicial'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "Error en la consulta: " . mysqli_error($conn);
}
?>
