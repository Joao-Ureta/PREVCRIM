<?php
// Configuración de la base de datos
define('DB_HOST', 'localhost');
define('DB_NAME', 'Prevcrim');
define('DB_USER', 'root');

// Detectar el entorno para asignar la contraseña adecuada
if ($_SERVER['SERVER_NAME'] == 'localhost') {
    define('DB_PASS', '');  // Contraseña vacía para equipo local
} else {
    define('DB_PASS', 'Maju2223');  // Contraseña para equipo externo
}

// Crear la conexión
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Verificar si hay errores en la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
} else {
    //echo "Conexión exitosa";
}
?>

