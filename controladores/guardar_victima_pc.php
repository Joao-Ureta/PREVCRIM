<!-- CONTROLADOR GUARDAR VICTIMA ADMIN PAZ CIUDADANA -->

<?php
require_once('../config/config.php');

// Función para validar RUT (módulo 11)
function validarRUT($rutCompleto) {
    $rut = preg_replace('/[^0-9kK]/', '', $rutCompleto);
    $rut = strtoupper($rut);
    $dv = substr($rut, -1);
    $numero = substr($rut, 0, -1);

    $suma = 0;
    $multiplo = 2;

    for ($i = strlen($numero) - 1; $i >= 0; $i--) {
        $suma += $numero[$i] * $multiplo;
        $multiplo = $multiplo == 7 ? 2 : $multiplo + 1;
    }

    $resto = $suma % 11;
    $digitoEsperado = 11 - $resto;

    if ($digitoEsperado == 11) $digitoEsperado = '0';
    elseif ($digitoEsperado == 10) $digitoEsperado = 'K';

    return $dv == $digitoEsperado;
}

// Recibir datos del formulario
$rut = $_POST['rut'] ?? null;
$nombres = $_POST['nombres'] ?? null;
$apellidos = $_POST['apellidos'] ?? null;
$edad = $_POST['edad'] ?? null;
$sexo = $_POST['sexo'] ?? null;
$nacionalidad = $_POST['nacionalidad'] ?? null;
$direccion = $_POST['direccion'] ?? null;
$telefono = $_POST['telefono'] ?? null;
$id_delito = isset($_POST['id_delito']) && !empty($_POST['id_delito']) ? intval($_POST['id_delito']) : null;

try {
    if (!$rut || !$nombres || !$apellidos) {
        throw new Exception("Faltan datos obligatorios.");
    }

    if (!validarRUT($rut)) {
        throw new Exception("El RUT ingresado no es válido.");
    }

    // Verificar si la víctima ya existe por RUT
    $stmt = $conn->prepare("SELECT id_victima FROM victima WHERE rut = ?");
    $stmt->bind_param("s", $rut);
    $stmt->execute();
    $stmt->bind_result($id_victima);

    if ($stmt->fetch()) {
        $stmt->close();
    } else {
        $stmt->close();
        $stmt_insert = $conn->prepare("INSERT INTO victima (rut, nombres, apellidos, edad, sexo, nacionalidad, direccion, telefono) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt_insert->bind_param("sssissss", $rut, $nombres, $apellidos, $edad, $sexo, $nacionalidad, $direccion, $telefono);
        if ($stmt_insert->execute()) {
            $id_victima = $stmt_insert->insert_id;
        } else {
            throw new Exception("Error al insertar víctima: " . $stmt_insert->error);
        }
        $stmt_insert->close();
    }

    // Si hay delito asociado, insertamos la relación en delito_victima
    if ($id_delito !== null) {
        $stmt_check = $conn->prepare("SELECT 1 FROM delito_victima WHERE id_delito = ? AND id_victima = ?");
        $stmt_check->bind_param("ii", $id_delito, $id_victima);
        $stmt_check->execute();
        $stmt_check->store_result();
        if ($stmt_check->num_rows === 0) {
            $stmt_check->close();
            $stmt_dv = $conn->prepare("INSERT INTO delito_victima (id_delito, id_victima) VALUES (?, ?)");
            $stmt_dv->bind_param("ii", $id_delito, $id_victima);
            if (!$stmt_dv->execute()) {
                throw new Exception("Error al asociar víctima con delito: " . $stmt_dv->error);
            }
            $stmt_dv->close();
        } else {
            $stmt_check->close();
        }
    }

    echo "<script>
        alert('✅ Víctima guardada exitosamente');
        window.location.href='../vistas/instituciones/paz_ciudadana/admin/form_registrar_victima.php';
    </script>";
} catch (Exception $e) {
    echo "<script>
        alert('❌ Error: " . addslashes($e->getMessage()) . "');
        window.location.href='../vistas/instituciones/paz_ciudadana/admin/form_registrar_victima.php';
    </script>";
}

$conn->close();
?>




