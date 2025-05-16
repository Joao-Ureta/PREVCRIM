<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/SIPC/config/config.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "SELECT 
        d.id_delincuente,
        d.rut,
        d.nombre_completo AS nombre,
        d.apodo,
        d.antecedentes,
        d.foto,
        d.nacionalidad,
        d.estado_judicial,
        d.direccion_particular,
        com.nombre_comuna AS comuna,
        del.fecha AS fecha_delito,
        del.descripcion AS descripcion_delito,
        t.nombre_tipo AS tipo_delito
    FROM 
        delincuente d
    LEFT JOIN 
        comuna com ON d.id_comuna = com.id_comuna
    LEFT JOIN 
        delito_delincuente dd ON d.id_delincuente = dd.id_delincuente
    LEFT JOIN 
        delito del ON dd.id_delito = del.id_delito
    LEFT JOIN 
        tipo_delito t ON del.id_tipo_delito = t.id_tipo_delito
    WHERE 
        d.id_delincuente = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    $delitos = [];
    $datos = null;

    while ($row = $result->fetch_assoc()) {
        if (!$datos) {
            $datos = $row;
        }

        if (!empty($row['tipo_delito'])) {
            $delitos[] = [
                'tipo' => $row['tipo_delito'],
                'fecha' => $row['fecha_delito'],
                'descripcion' => $row['descripcion_delito']
            ];
        }
    }

    $foto = !empty($datos['foto']) ? $datos['foto'] : 'ruta/a/imagen/default.jpg';
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte Delincuente</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 40px;
            color: #000;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .header h1 {
            margin: 0;
        }

        .foto {
            float: right;
            width: 150px;
            height: 200px;
            object-fit: cover;
            border: 1px solid #999;
        }

        .section {
            margin-bottom: 30px;
        }

        .section h3 {
            border-bottom: 1px solid #aaa;
            padding-bottom: 5px;
        }

        .delito {
            margin-bottom: 15px;
        }

        .btn-imprimir {
            display: block;
            margin: 20px auto;
            padding: 10px 20px;
            font-size: 16px;
            background-color: #007BFF;
            color: white;
            border: none;
            cursor: pointer;
        }

        @media print {
            .btn-imprimir {
                display: none;
            }
        }
    </style>
</head>
<body>

<div class="header">
    <h1>Informe de Delincuente</h1>
    <p>Generado automáticamente por el sistema SIPC</p>
</div>

<?php if ($datos): ?>
    <div class="section">
        <h3>Datos Personales</h3>
        <img src="/SIPC/<?php echo $foto; ?>" alt="Foto" class="foto">
        <p><strong>Nombre:</strong> <?php echo $datos['nombre']; ?></p>
        <p><strong>Apodo:</strong> <?php echo $datos['apodo']; ?></p>
        <p><strong>RUT:</strong> <?php echo $datos['rut']; ?></p>
        <p><strong>Nacionalidad:</strong> <?php echo $datos['nacionalidad']; ?></p>
        <p><strong>Dirección:</strong> <?php echo $datos['direccion_particular']; ?></p>
        <p><strong>Comuna:</strong> <?php echo $datos['comuna']; ?></p>
        <p><strong>Estado Judicial:</strong> <?php echo $datos['estado_judicial']; ?></p>
    </div>

    <div class="section">
        <h3>Antecedentes</h3>
        <?php if (!empty($delitos)): ?>
            <?php foreach ($delitos as $d): ?>
                <div class="delito">
                    <p><strong>Tipo:</strong> <?php echo $d['tipo']; ?></p>
                    <p><strong>Fecha:</strong> <?php echo $d['fecha']; ?></p>
                    <p><strong>Descripción:</strong> <?php echo $d['descripcion']; ?></p>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No se encontraron delitos registrados.</p>
        <?php endif; ?>
    </div>

    <button class="btn-imprimir" onclick="window.print()">🖨️ Imprimir / Guardar como PDF</button>
<?php else: ?>
    <p>No se encontró información para este delincuente.</p>
<?php endif; ?>

</body>
</html>
