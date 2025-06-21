<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Ingreso / Registro - Visitante</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      background: linear-gradient(to right, #2c3e50, #3498db);
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      height: 100vh;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
    }

    /* Contenedor principal (formulario) */
        .main {
            width: 350px;
            height: 550px;
            background-color: MediumBlue;
            overflow: hidden;
            border-radius: 10px;
            box-shadow: 5px 20px 50px #000;
            position: center;
            top: 200px;
            left: 500px;
        }

        #chk {
            display: none;
        }

        .signup {
            position: relative;
            width: 100%;
            height: 100%;
        }

        label {
            color: #fff;
            font-size: 2.3em;
            justify-content: center;
            display: flex;
            margin: 60px;
            font-weight: bold;
            cursor: pointer;
            transition: .5s ease-in-out;
        }

        input {
            width: 60%;
            height: 20px;
            background: #e0dede;
            justify-content: center;
            display: flex;
            margin: 20px auto;
            padding: 10px;
            border: none;
            outline: none;
            border-radius: 5px;
        }

        button {
            width: 60%;
            height: 40px;
            margin: 10px auto;
            justify-content: center;
            display: block;
            color: #fff;
            background: Blue;
            font-size: 1em;
            font-weight: bold;
            margin-top: 20px;
            outline: none;
            border: none;
            border-radius: 5px;
            transition: .2s ease-in;
            cursor: pointer;
        }

        button:hover {
            background: #6d44b8;
        }

        .login {
            height: 460px;
            background: RoyalBlue;
            border-radius: 60% / 10%;
            transform: translateY(-180px);
            transition: .8s ease-in-out;
        }

        .login label {
            color: Aqua;
            transform: scale(.6);
        }

        #chk:checked ~ .login {
            transform: translateY(-500px);
        }

        #chk:checked ~ .login label {
            transform: scale(1);
        }

        #chk:checked ~ .signup label {
            transform: scale(.6);
        }
        
        /* Asegura que el navbar esté fijo en la parte superior */
        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 999; /* Asegura que el navbar esté por encima de otros elementos */
        }

        /* Espaciado para el contenido debajo del navbar */
        body {
            padding-top: 100px; /* Ajusta el valor según el tamaño del navbar */
        }
  </style>
</head>
<body>


  <div class="container">
    <div class="main">
      <input type="checkbox" id="chk" aria-hidden="true">

      <div class="signup">
        <form action="../../../controladores/registro_visitante.php" method="POST" autocomplete="off">
            <label for="chk" aria-hidden="true">Registro</label>
            <input type="text" name="nombre_usuario" placeholder="Nombre completo" required>
            <input type="text" name="rut" id="rut" placeholder="RUT (ej: 12345678-9)" required>
                <small id="rutError" style="color:red; display:none;">❌ RUT no válido</small>
            <input type="email" name="email" placeholder="Correo electrónico" required>
            <div style="width: 60%; margin: 0 auto;">
                <input type="password" id="password" name="password" placeholder="Contraseña" required autocomplete="off" style="width: 100%;">
                <small id="passwordHelp" style="color: #eee; font-size: 0.75em; display: block; margin-top: 5px; text-align: center;">
                    La contraseña debe tener al menos 8 caracteres, incluir una letra mayúscula, una letra minúscula, un número y un carácter especial.
                </small>
            </div>
            <button type="submit" name="registro">Registrar</button>
        </form>
        </div>


      <div class="login">
        <form action="login_visitante.php" method="POST" autocomplete="off">
          <label for="chk" aria-hidden="true">Ingreso</label>
          <input type="email" name="email" placeholder="Correo electrónico" required>
          <input type="password" name="password" placeholder="Contraseña" required>
          <button type="submit" name="login">Ingresar</button>
        </form>
      </div>
    </div>
  </div>

  <script>
  const passwordInput = document.getElementById("password");

  passwordInput.addEventListener("input", () => {
    const value = passwordInput.value;
    document.getElementById("length").style.color = value.length >= 8 ? "green" : "red";
    document.getElementById("length").innerHTML = (value.length >= 8 ? "✅" : "❌") + " Al menos 8 caracteres";

    document.getElementById("uppercase").style.color = /[A-Z]/.test(value) ? "green" : "red";
    document.getElementById("uppercase").innerHTML = (/[A-Z]/.test(value) ? "✅" : "❌") + " Una letra mayúscula";

    document.getElementById("lowercase").style.color = /[a-z]/.test(value) ? "green" : "red";
    document.getElementById("lowercase").innerHTML = (/[a-z]/.test(value) ? "✅" : "❌") + " Una letra minúscula";

    document.getElementById("number").style.color = /\d/.test(value) ? "green" : "red";
    document.getElementById("number").innerHTML = (/\d/.test(value) ? "✅" : "❌") + " Un número";

    document.getElementById("special").style.color = /[^A-Za-z0-9]/.test(value) ? "green" : "red";
    document.getElementById("special").innerHTML = (/[^A-Za-z0-9]/.test(value) ? "✅" : "❌") + " Un carácter especial";
  });
</script>

<script>
function validarRut(rut) {
    rut = rut.replace(/\./g, '').replace(/-/g, '').toUpperCase();
    if (rut.length < 2) return false;

    const cuerpo = rut.slice(0, -1);
    let dv = rut.slice(-1);

    let suma = 0;
    let multiplo = 2;

    for (let i = cuerpo.length - 1; i >= 0; i--) {
        suma += parseInt(cuerpo.charAt(i)) * multiplo;
        multiplo = multiplo === 7 ? 2 : multiplo + 1;
    }

    const resto = suma % 11;
    let dvEsperado = 11 - resto;
    if (dvEsperado === 11) dvEsperado = '0';
    else if (dvEsperado === 10) dvEsperado = 'K';
    else dvEsperado = dvEsperado.toString();

    return dv === dvEsperado;
}

document.getElementById("rut").addEventListener("blur", function () {
    const rut = this.value;
    const error = document.getElementById("rutError");
    if (!validarRut(rut)) {
        error.style.display = "block";
    } else {
        error.style.display = "none";
    }
});
</script>


</body>
</html>


