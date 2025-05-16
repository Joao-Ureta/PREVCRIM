<?php
// Incluir el archivo de conexión a la base de datos
include_once '../config/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['nombre_completo'], $_POST['rut'], $_POST['correo'], $_POST['contrasena'])) {
        $nombre_completo = $_POST['nombre_completo'];
        $rut = $_POST['rut'];
        $correo = $_POST['correo'];
        $clave = $_POST['contrasena'];

        // Rol fijo
        $rol = 'Operador';

        $clave_hash = password_hash($clave, PASSWORD_BCRYPT);

        // id_institucion fijo para Carabineros
        $id_institucion = 1;

        $sql = "INSERT INTO usuario (nombre_completo, rut, correo, contrasena, rol, id_institucion)
                VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssi", $nombre_completo, $rut, $correo, $clave_hash, $rol, $id_institucion);

        if ($stmt->execute()) {
            echo "<script>alert('Operador registrado exitosamente'); window.location.href='../vistas/instituciones/carabineros/ingresar_usuario.php';</script>";
        } else {
            echo "<script>alert('Error al registrar operador: " . $stmt->error . "'); window.history.back();</script>";
        }

    } else {
        echo "<script>alert('Faltan datos del formulario'); window.history.back();</script>";
    }

} else {
    echo "<script>alert('Acceso inválido'); window.location.href='../vistas/instituciones/carabineros/ingresar_usuario.php';</script>";
}
?>
