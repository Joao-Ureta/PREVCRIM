<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8">
    <meta name="description" content="Ejemplo de HRML5">
    <meta name="keywords" content="HTML5, CSS3, JavaScript">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/docs.css" rel="stylesheet"> 
    <script src="js/bootstrap.bundle.min.js"></script> 
    <title>Inicio SIPC</title>
	
	<style>
	/* Estilos generales */
		body {
			
			background: #C0C0C0;
			display: flex;
			justify-content: center;
			align-items: center;
			min-height: 100vh;
			margin: 0;
			font-family: Arial, sans-serif;
			flex-direction: column; /* Asegura que los elementos se apilen verticalmente */
		}

		/* Contenedor principal */
		.main-container {
			display: flex;
			flex-direction: column; /* Hace que los elementos hijos se apilen verticalmente */
			align-items: center; /* Centra los elementos horizontalmente */
		}

		/* Contenedor del título */
		.header-container {
			background: #D3D3D3;
			padding: 20px;
			border-radius: 10px;
			box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
			text-align: center;
			width: 100%;
			max-width: 600px;
			margin-bottom: 20px; /* Espacio entre el título y el siguiente contenedor */
		}

		/* Contenedor de selección */
		.container {
			background: #D3D3D3;
			padding: 30px;
			border-radius: 10px;
			box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
			width: 100%;
			max-width: 600px;
			text-align: center;
		}

		/* Título */
		h1 {
			font-size: 24px;
			color: #333;
			margin-bottom: 20px;
		}

		/* Contenedor de logos */
		.logo-container {
			display: flex;
			justify-content: space-around;
			align-items: center;
			margin-top: 20px;
		}

		/* Estilos para los logos */
		.logo-container a {
			text-decoration: none;
			transition: transform 0.3s ease;
		}

		.logo-container a:hover {
			transform: scale(1.1);
		}

		.logo-container img {
			width: 120px;
			height: auto;
			border-radius: 10px;
			box-shadow: 0 5px 15px rgba(0, 0, 0, 0.5);
		}
		
		.logo-logo {
			position: absolute;
			top: 25px;
			right: 25px;
		}

		.logo-logo img {
			width: 300px; /* Puedes ajustar el tamaño si es necesario */
			height: auto;
		}
		
		.boton-volver {
			margin-top: 30px;
			text-align: center;
		}

		.boton-volver a {
			background-color: #808080;
			color: white;
			padding: 12px 25px;
			text-decoration: none;
			border-radius: 5px;
			font-weight: bold;
			transition: background-color 0.3s ease;
		}

		.boton-volver a:hover {
			background-color: #C0C0C0;
		}

        footer {
            background-color: #F5F5F5;
			text-align: center;
            color: black;
            padding: 10px;
            position: fixed;
            bottom: 0;
            width: 100%;
        }

	</style>
  </head>
  
  <body>
  
  <div class="logo-logo">
  <img src="/SIPC/estaticos/img/logo_prevcrim3.jpg" alt="Paz Ciudadana">
  </div>


    <div class="main-container">
        <div class="header-container">
            <h1>Bienvenido al Sistema Integrado de prevención de crimines (SIPC)</h1> 
			<p>Sección administrador:</p>			
			<div class="logo-container">
				<a href="login_admin.php?institucion=carabineros">
                    <img src="/SIPC/estaticos/img/logo_admin.jpg" alt="Carabineros de Chile">
                </a>
			</div>
        </div>
        <div class="container">
			<p><strong>Sección Jefe de zona y Operador</strong></p>
            <p>Seleccione su institución para continuar:</p>
			</br></br>
            <div class="logo-container">
                <a href="login.php?institucion=carabineros">
                    <img src="/SIPC/estaticos/img/carabineros.png" alt="Carabineros de Chile">
                </a>
                <a href="login_pc.php?institucion=pazciudadana">
                    <img src="/SIPC/estaticos/img/paz_ciudadana.jpg" alt="Paz Ciudadana">
                </a>
				<a href="login_pdi.php?institucion=pdi">
                    <img src="/SIPC/estaticos/img/pdi.jpg" alt="PDI">
                </a>
            </div>
        </div>
    </div>

	<div class="boton-volver">
		<a href="index_prevcrim.php">Volver a la pestaña principal</a>
	</div>

</br></br></br></br>
	
	<footer>
    &copy; 2025 PREVCRIM - Tecnología que previene, seguridad que protege.
	</footer>

</body>

</html>
