<?php
// Contraseña en texto plano
$plain_password = 'admin123';

// Cifrar la contraseña con bcrypt
$hashed_password = password_hash($plain_password, PASSWORD_BCRYPT);

// Mostrar la contraseña cifrada
echo $hashed_password;
?>
