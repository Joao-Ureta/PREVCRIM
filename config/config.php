<?php
// Configuración de la base de datos
define('DB_HOST', 'localhost');
define('DB_NAME', 'Prevcrim');
define('DB_USER', 'root');
define('DB_PASS', 'Maju2223');

// Crear la conexión
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Verificar si hay errores en la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
} else {
    // Si la conexión es exitosa, puedes seguir trabajando con la base de datos
    //echo "Conexión exitosa"; // Esto puedes descomentarlo para comprobar si la conexión funciona.
}
?>
