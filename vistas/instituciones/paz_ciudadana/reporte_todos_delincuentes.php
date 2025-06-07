<!-- PESTAÑA REPORTE TODOS LOS DELINCUENTES DE JEFE ZONA PAZ CIUDADANA -->
 <?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/SIPC/config/config.php');

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
ORDER BY 
    d.nombre_completo";

$result = $conn->query($sql);

$delincuentes = [];

while ($row = $result->fetch_assoc()) {
    $id = $row['id_delincuente'];

    if (!isset($delincuentes[$id])) {
        $delincuentes[$id] = [
            'nombre' => $row['nombre'],
            'rut' => $row['rut'],
            'apodo' => $row['apodo'],
            'nacionalidad' => $row['nacionalidad'],
            'estado_judicial' => $row['estado_judicial'],
            'direccion' => $row['direccion_particular'],
            'comuna' => $row['comuna'],
            'foto' => !empty($row['foto']) ? $row['foto'] : 'ruta/a/imagen/default.jpg',
            'delitos' => []
        ];
    }

    if (!empty($row['tipo_delito'])) {
        $delincuentes[$id]['delitos'][] = [
            'tipo' => $row['tipo_delito'],
            'fecha' => $row['fecha_delito'],
            'descripcion' => $row['descripcion_delito']
        ];
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte General de Delincuentes</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 40px;
            color: #000;
        }

        .header {
            text-align: center;
            margin-bottom: 40px;
        }

        .header h1 {
            margin: 0;
        }

        .delincuente {
            page-break-after: always;
            margin-bottom: 40px;
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
            clear: both;
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
    <h1>Informe General de Delincuentes</h1>
    <p>Generado automáticamente por el sistema SIPC</p>
</div>

<?php if (!empty($delincuentes)): ?>
    <?php foreach ($delincuentes as $d): ?>
        <div class="delincuente">
            <div class="section">
                <h3>Datos Personales</h3>
                <img src="/SIPC/<?php echo $d['foto']; ?>" alt="Foto" class="foto">
                <p><strong>Nombre:</strong> <?php echo $d['nombre']; ?></p>
                <p><strong>Apodo:</strong> <?php echo $d['apodo']; ?></p>
                <p><strong>RUT:</strong> <?php echo $d['rut']; ?></p>
                <p><strong>Nacionalidad:</strong> <?php echo $d['nacionalidad']; ?></p>
                <p><strong>Dirección:</strong> <?php echo $d['direccion']; ?></p>
                <p><strong>Comuna:</strong> <?php echo $d['comuna']; ?></p>
                <p><strong>Estado Judicial:</strong> <?php echo $d['estado_judicial']; ?></p>
            </div>

            <div class="section">
                <h3>Antecedentes</h3>
                <?php if (!empty($d['delitos'])): ?>
                    <?php foreach ($d['delitos'] as $delito): ?>
                        <div class="delito">
                            <p><strong>Tipo:</strong> <?php echo $delito['tipo']; ?></p>
                            <p><strong>Fecha:</strong> <?php echo $delito['fecha']; ?></p>
                            <p><strong>Descripción:</strong> <?php echo $delito['descripcion']; ?></p>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No se encontraron delitos registrados.</p>
                <?php endif; ?>
            </div>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <p>No hay delincuentes registrados en el sistema.</p>
<?php endif; ?>

<button class="btn-imprimir" onclick="window.print()">🖨️ Imprimir / Guardar como PDF</button>

</body>
</html>

