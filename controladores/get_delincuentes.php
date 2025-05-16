<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/SIPC/config/config.php');

if (isset($_POST['id_delincuente'])) {
    $idDelincuente = $_POST['id_delincuente'];

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
        d.id_sector AS sector_id,
        del.fecha AS fecha_delito,
        del.descripcion AS descripcion_delito,
        del.latitud AS latitud_delito,
        del.longitud AS longitud_delito,
        t.nombre_tipo AS tipo_delito,
        s.nombre_sector AS sector_nombre,
        comu.nombre_comuna AS comuna_delincuente
    FROM 
        delincuente d
    JOIN 
        delito_delincuente dd ON d.id_delincuente = dd.id_delincuente
    JOIN 
        delito del ON dd.id_delito = del.id_delito
    JOIN 
        tipo_delito t ON del.id_tipo_delito = t.id_tipo_delito
    JOIN 
        sector s ON d.id_sector = s.id_sector
    LEFT JOIN 
        comuna comu ON d.id_comuna = comu.id_comuna
    WHERE 
        d.id_delincuente = ?";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $idDelincuente);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $delitos = [];
            $datosPersonales = null;

            while ($row = $result->fetch_assoc()) {
                // Guardar los datos personales solo una vez
                if ($datosPersonales === null) {
                    $datosPersonales = $row;
                }

                $delitos[] = [
                    'tipo' => $row['tipo_delito'],
                    'fecha' => $row['fecha_delito'],
                    'descripcion' => $row['descripcion_delito'],
                    'latitud' => $row['latitud_delito'],
                    'longitud' => $row['longitud_delito'],
                    'sector' => $row['sector_nombre']
                ];
            }

            $foto = !empty($datosPersonales['foto']) ? $datosPersonales['foto'] : 'ruta/a/imagen/default.jpg';

            echo '
    <div>
        <h4>' . $datosPersonales['nombre'] . ' (' . $datosPersonales['apodo'] . ')</h4>
        <p><strong>RUT:</strong> ' . $datosPersonales['rut'] . '</p>
        <p><strong>Nacionalidad:</strong> ' . $datosPersonales['nacionalidad'] . '</p>
        <p><strong>Dirección Particular:</strong> ' . $datosPersonales['direccion_particular'] . '</p>
        <p><strong>Comuna de Residencia:</strong> ' . $datosPersonales['comuna_delincuente'] . '</p>

        <hr>
        <h5>Antecedentes</h5>';

foreach ($delitos as $delito) {
    echo '<p>- ' . $delito['tipo'] . '</p>';
}

echo '
        <p><strong>Estado Judicial:</strong> ' . $datosPersonales['estado_judicial'] . '</p>

        <h5>Delitos Asociados</h5>';

foreach ($delitos as $delito) {
    echo '
        <p>
            <strong>Tipo:</strong> ' . $delito['tipo'] . '<br>
            <strong>Fecha:</strong> ' . $delito['fecha'] . '<br>
            <strong>Descripción:</strong> <small>' . $delito['descripcion'] . '</small>
        </p>';
}

echo '
        <img src="/SIPC/' . $foto . '" class="img-fluid" alt="Foto de ' . $datosPersonales['nombre'] . '">
        <hr>
        <h5>Ubicación de Delitos</h5>
        <div id="mapa" style="height: 400px; width: 100%;"></div>
		
		<!-- Botón para generar reporte -->
        <div class="text-end mt-3">
            <button class="btn btn-primary" onclick="generarReporte(' . $datosPersonales['id_delincuente'] . ')">
                Generar Reporte
            </button>
        </div>
		
    </div>
	

    <script>
        function initMap() {
            var mapa = new google.maps.Map(document.getElementById("mapa"), {
                zoom: 10,
                center: { lat: ' . $delitos[0]['latitud'] . ', lng: ' . $delitos[0]['longitud'] . '}
            });';

foreach ($delitos as $delito) {
    echo '
            new google.maps.Marker({
                position: { lat: ' . $delito['latitud'] . ', lng: ' . $delito['longitud'] . ' },
                map: mapa,
                title: "' . addslashes($delito['tipo']) . '"
            });';
}

echo '
        }

        var script = document.createElement("script");
        script.src = "https://maps.googleapis.com/maps/api/js?key=AIzaSyA3wzdatwG0njMap89LqBnbWdGFfd73Vsk&callback=initMap";
        script.async = true;
        document.body.appendChild(script);
    </script>';

        } else {
            echo '<p>No se encontraron detalles para este delincuente.</p>';
        }
    }
}
?>









