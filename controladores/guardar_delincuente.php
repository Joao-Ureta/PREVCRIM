<?php
require_once('../config/config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = trim($_POST["nombre_completo"]);
    $rut = trim($_POST["rut"]);
    $edad = intval($_POST["edad"]);
    $genero = $_POST["genero"];
    $apodo = trim($_POST["apodo"]);
    $antecedentes = trim($_POST["antecedentes"]);
    $nacionalidad = trim($_POST["nacionalidad"]);
    $estado_judicial = trim($_POST["estado_judicial"]);
    $id_comuna = $_POST["id_comuna"] !== "" ? intval($_POST["id_comuna"]) : null;
    $direccion = trim($_POST["direccion_particular"]);
    $nivel_peligrosidad = $_POST["nivel_peligrosidad"];
    $id_sector = intval($_POST["id_sector"]);

    // Validación del estado_judicial para evitar errores en ENUM
    $valores_validos = ['Preso', 'Libre', 'Orden de arresto'];
    if (!in_array($estado_judicial, $valores_validos)) {
        die("Error: valor inválido para estado_judicial");
    }

    // Subida de foto
    $ruta_foto = null;
    if (!empty($_FILES["foto"]["name"])) {
        $carpeta_destino = "../estaticos/fotos_delincuentes/";

        if (!file_exists($carpeta_destino)) {
            mkdir($carpeta_destino, 0777, true);
        }

        $tmp = $_FILES["foto"]["tmp_name"];
        $nombre_archivo = basename($_FILES["foto"]["name"]);
        $nombre_final = uniqid() . "_" . $nombre_archivo;

        $ruta_foto_servidor = $carpeta_destino . $nombre_final; // Para guardar físicamente
        $ruta_foto = "estaticos/fotos_delincuentes/" . $nombre_final; // Para guardar en la BD

        if (strpos(mime_content_type($tmp), "image") === false) {
            echo "Archivo no es una imagen válida.";
            exit;
        }

        if (!move_uploaded_file($tmp, $ruta_foto_servidor)) {
            echo "Error al subir la imagen.";
            exit;
        }
    }

    // Insertar delincuente
    $stmt = $conn->prepare("INSERT INTO delincuente 
        (nombre_completo, rut, edad, genero, apodo, antecedentes, foto, nacionalidad, id_sector, estado_judicial, id_comuna, direccion_particular, nivel_peligrosidad) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    $stmt->bind_param("ssisssssissss",  
        $nombre, $rut, $edad, $genero, $apodo, $antecedentes, $ruta_foto,
        $nacionalidad, $id_sector, $estado_judicial, $id_comuna, $direccion, $nivel_peligrosidad
    );

    if ($stmt->execute()) {
        echo "<script>
			alert('Delincuente guardado correctamente');
			window.location.href='../vistas/instituciones/carabineros/operador/form_ingresar_delincuente.php';
		</script>";
    } else {
        echo "Error al guardar delincuente: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Acceso denegado.";
}
?>




