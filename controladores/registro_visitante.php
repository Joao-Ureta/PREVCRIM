<?php
require_once('../config/config.php');
function validarRutChileno($rut) {
    $rut = preg_replace('/[^kK0-9]/', '', $rut);
    if (strlen($rut) < 2) return false;

    $numero = substr($rut, 0, -1);
    $verificador = strtoupper(substr($rut, -1));

    $suma = 0;
    $multiplo = 2;

    for ($i = strlen($numero) - 1; $i >= 0; $i--) {
        $suma += $numero[$i] * $multiplo;
        $multiplo = $multiplo == 7 ? 2 : $multiplo + 1;
    }

    $resto = $suma % 11;
    $dv = 11 - $resto;

    if ($dv == 11) $dv = '0';
    elseif ($dv == 10) $dv = 'K';
    else $dv = (string)$dv;

    return $dv === $verificador;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['nombre_usuario'], $_POST['rut'], $_POST['email'], $_POST['password'])) {
        $nombre_completo = trim($_POST['nombre_usuario']);
        $rut = strtoupper(trim($_POST['rut']));
        $correo = trim($_POST['email']);
        $clave = $_POST['password'];

        // Validar RUT
        if (!validarRutChileno($rut)) {
            echo "<script>alert('❌ El RUT ingresado no es válido.'); window.history.back();</script>";
            exit;
        }

        // Validar contraseña (opcional, puedes mejorar esta validación)
        if (strlen($clave) < 8) {
            echo "<script>alert('❌ La contraseña debe tener al menos 8 caracteres.'); window.history.back();</script>";
            exit;
        }

        // Hash de la contraseña
        $clave_hash = password_hash($clave, PASSWORD_BCRYPT);

        // Rol y institución fijos para visitantes
        $rol = 'Visitante';
        $id_institucion = 1;  // Cambia según corresponda

        // Verificar si correo o rut ya existen
        $existe = $conn->prepare("SELECT id_usuario FROM usuario WHERE correo = ? OR rut = ?");
        $existe->bind_param("ss", $correo, $rut);
        $existe->execute();
        $existe->store_result();
        if ($existe->num_rows > 0) {
            echo "<script>alert('❌ El correo o RUT ya están registrados.'); window.history.back();</script>";
            exit;
        }

        // Insertar usuario
        $sql = "INSERT INTO usuario (nombre_completo, rut, correo, contrasena, rol, id_institucion) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssi", $nombre_completo, $rut, $correo, $clave_hash, $rol, $id_institucion);

        if ($stmt->execute()) {
            echo "<script>alert('✔ Registro exitoso!'); window.location.href = '../public/index_visitante.php'</script>";
        } else {
            echo "<script>alert('❌ Error al registrar: " . $stmt->error . "'); window.history.back();</script>";
        }

    } else {
        echo "<script>alert('❌ Faltan datos del formulario.'); window.history.back();</script>";
    }
} else {
    echo "<script>alert('Acceso inválido'); window.location.href = 'index.php';</script>";
}
?>