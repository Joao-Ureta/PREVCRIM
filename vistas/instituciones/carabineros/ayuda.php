<?php
// Incluir PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once 'C:/xampp/htdocs/SIPC/vendor/autoload.php';



// Procesar el formulario de ayuda
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = trim($_POST['nombre']);
    $correo = trim($_POST['correo']);
    $mensaje = trim($_POST['mensaje']);

    // Validación de campos
    if (empty($nombre) || empty($correo) || empty($mensaje)) {
        $error = "⚠️ Todos los campos son obligatorios.";
    } else {
        // Configuración de PHPMailer
        $mail = new PHPMailer(true);

        try {
            // Configuración del servidor SMTP
            $mail->isSMTP();
			$mail->Host = 'smtp.office365.com'; // Servidor SMTP de Outlook
			$mail->SMTPAuth = true;
			$mail->Username = 'joao.ureta24065@edu.ipchile.cl'; // Tu dirección de correo Outlook
			$mail->Password = 'tu-contraseña'; // Tu contraseña
			$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
			$mail->Port = 587;


            // Remitente y destinatario
            $mail->setFrom($correo, $nombre);  // Dirección de correo del usuario que envía
            $mail->addAddress('joao.ureta@gmail.com');  // Correo del administrador

            // Contenido del correo
            $mail->isHTML(false); // No usar formato HTML
            $mail->Subject = "Solicitud de ayuda de $nombre";
            $mail->Body    = "Nombre: $nombre\nCorreo: $correo\n\nMensaje:\n$mensaje";

            // Enviar correo
            $mail->send();
            $success = "✔️ Tu solicitud de ayuda ha sido enviada correctamente.";
        } catch (Exception $e) {
            $error = "❌ Ocurrió un error al enviar tu mensaje. Error: {$mail->ErrorInfo}";
        }
    }
}
?>

<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="Formulario de ayuda">
    <meta name="keywords" content="Formulario, Ayuda">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.bundle.min.js"></script> 
    <title>Ayuda - Carabineros de Chile</title>
    
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f2f2f2;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .help-container {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 600px;
            text-align: center;
        }

        h2 {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin: 10px 0 5px;
        }

        input, textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 2px solid #ccc;
            border-radius: 4px;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #2575fc;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background-color: #6a11cb;
        }

        .message {
            margin-top: 20px;
        }

        .error {
            color: red;
        }

        .success {
            color: green;
        }
    </style>
</head>

<body>
    <div class="help-container">
        <h2>Formulario de Ayuda</h2>
        
        <?php
        if (!empty($error)) {
            echo "<div class='message error'>$error</div>";
        }
        if (!empty($success)) {
            echo "<div class='message success'>$success</div>";
        }
        ?>

        <form method="POST" action="">
            <label for="nombre">Nombre</label>
            <input type="text" name="nombre" required>

            <label for="correo">Correo electrónico</label>
            <input type="email" name="correo" required>

            <label for="mensaje">Mensaje</label>
            <textarea name="mensaje" rows="5" required></textarea>

            <button type="submit">Enviar Solicitud de Ayuda</button>
			</br></br>
			<a href="/SIPC/public/logout.php">Volver a inicio de sesión</a>
        </form>
    </div>
</body>
</html>

