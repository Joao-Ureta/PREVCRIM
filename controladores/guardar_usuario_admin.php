<!-- CONTROLADOR INGRESAR USUARIO ADMIN CARABINEROS -->

<?php
// Incluir el archivo de conexión a la base de datos
include_once '../config/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['nombre_completo'], $_POST['rut'], $_POST['correo'], $_POST['contrasena'], $_POST['rol'])) {
        $nombre_completo = $_POST['nombre_completo'];
        $rut = $_POST['rut'];
        $correo = $_POST['correo'];
        $clave = $_POST['contrasena'];
        $rol = $_POST['rol']; // Ahora se obtiene del formulario

        // Validar que el rol sea uno permitido
        $roles_permitidos = ['Administrador', 'JefeZona', 'Operador', 'Visitante', 'AdministradorGeneral'];
        if (!in_array($rol, $roles_permitidos)) {
            echo "<script>alert('Rol inválido seleccionado.'); window.history.back();</script>";
            exit;
        }

        $clave_hash = password_hash($clave, PASSWORD_BCRYPT);

        // id_institucion fijo para Carabineros
        $id_institucion = 1;

        // Verificar si el RUT ya existe
        $verificar = $conn->prepare("SELECT rut FROM usuario WHERE rut = ?");
        $verificar->bind_param("s", $rut);
        $verificar->execute();
        $verificar->store_result();

        if ($verificar->num_rows > 0) {
            echo "<script>alert('Error: El RUT ingresado ya está registrado.'); window.history.back();</script>";
            exit;
        }

        // Insertar nuevo usuario
        $sql = "INSERT INTO usuario (nombre_completo, rut, correo, contrasena, rol, id_institucion)
                VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssi", $nombre_completo, $rut, $correo, $clave_hash, $rol, $id_institucion);

        if ($stmt->execute()) {
            echo "<script>alert('Usuario registrado exitosamente'); window.location.href='../vistas/instituciones/carabineros/admin/ingresar_usuario.php';</script>";
        } else {
            echo "<script>alert('Error al registrar usuario: " . $stmt->error . "'); window.history.back();</script>";
        }

    } else {
        echo "<script>alert('Faltan datos del formulario'); window.history.back();</script>";
    }

} else {
    echo "<script>alert('Acceso inválido'); window.location.href='../vistas/instituciones/carabineros/admin/ingresar_usuario.php';</script>";
}
?>
