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
    <title>Inicio - PREVCRIM</title>
	
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
			width: -400px; /* agranda el logo cambiando el ancho */
			margin: 0 auto; /* lo centra horizontalmente */
			display: block; /* asegura que el margen auto funcione si es una imagen */
			position: relative;
			top: -100px;
			padding-top: -100px; /* un poco de espacio desde el borde superior (opcional) */
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
  <img src="/SIPC/estaticos/img/logo_prevcrim3.jpg" alt="Prevcrim">
  </div>


    <div class="main-container">
        <div class="container">
			<h1>Bienvenido al Sistema Integrado de prevención de crimines (SIPC)</h1>
            <p>Seleccione si es funcionario o visitante para continuar:</p>
			</br></br>
            <div class="logo-container">
                <a href="index.php">
                    <img src="/SIPC/estaticos/img/logo_funcionario.png" alt="Funcionario">
                </a>
                <a href="#">
                    <img src="/SIPC/estaticos/img/logo_visitante.png" alt="Visitante">
                </a>
            </div>
        </div>
    </div>
	
	<footer>
    &copy; 2025 PREVCRIM - Tecnología que previene, seguridad que protege.
	</footer>

</body>

</html>