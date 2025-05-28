<?php
session_start();

// Destruir todas las variables de sesión
session_unset();

// Destruir la sesión
session_destroy();

// Redirigir al inicio de sesión con URL absoluta
header("Location: http://localhost/SIPC/public/index.php");
exit;



