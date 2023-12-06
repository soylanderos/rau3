<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

function limpiar($dato, $conexion) {
    return $conexion->real_escape_string($dato);
}

// Configuración de la base de datos
$host = "localhost";
$usuario = "root";
$contrasena = "";
$bd = "consultoria";

// Conexión a la base de datos utilizando new mysqli
$conexion = new mysqli($host, $usuario, $contrasena, $bd);

if ($conexion->connect_error) {
    die("Error en la conexión a la base de datos: " . $conexion->connect_error);
}

// Verificar si el usuario ha superado el límite de intentos
if (isset($_SESSION['intentos']) && $_SESSION['intentos'] >= 3) {
    // Comprobar si ha pasado suficiente tiempo para desbloquear
    $tiempoDeEspera = 1 * 5; // 5 segundos (ajusta esto según tus necesidades)
    if (isset($_SESSION['bloqueado_hasta']) && $_SESSION['bloqueado_hasta'] > time()) {
        $tiempoRestante = $_SESSION['bloqueado_hasta'] - time();
        echo "Su cuenta está bloqueada. Espere " . $tiempoRestante . " segundos antes de intentar nuevamente.";
        exit;
    } else {
        // No se ha bloqueado la cuenta; restablecer el contador de intentos
        unset($_SESSION['intentos']);
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['registrar'])) {
        // ... (código de registro como antes)
    }

    if (isset($_POST['iniciar_sesion'])) {
        // Incrementar el contador de intentos de inicio de sesión
        if (!isset($_SESSION['intentos'])) {
            $_SESSION['intentos'] = 1;
        } else {
            $_SESSION['intentos']++;
        }

        // Comprobar si el usuario ha superado el límite de intentos
        if ($_SESSION['intentos'] >= 3) {
            // Bloquear la cuenta y establecer el tiempo de desbloqueo
            $_SESSION['bloqueado_hasta'] = time() + $tiempoDeEspera;
            echo "Ha excedido el límite de intentos de inicio de sesión. Su cuenta está bloqueada por " . $tiempoDeEspera . " segundos.";
        } else {
        // Inicio de sesión
        $email = limpiar($_POST['email'], $conexion);
        $contrasena = $_POST['contrasena'];

        // Preparar la consulta SQL para buscar el usuario en la base de datos
        $query = "SELECT * FROM usuarios WHERE email='$email'";
        $resultado = $conexion->query($query);

        if ($resultado->num_rows == 1) {
            $usuario = $resultado->fetch_assoc();
            if (password_verify($contrasena, $usuario['contrasena'])) {
                $_SESSION['id'] = $usuario['id'];
                // Restablecer el contador de intentos al iniciar sesión
                unset($_SESSION['intentos']);
                header('Location: index.html');
            } else {
                echo "Contraseña incorrecta.";
            }
        } else {
            echo "Usuario no encontrado.";
        }
        }
    }
}

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Inicio de sesion</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- owl carousel -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css"
        integrity="sha512-tS3S5qG0BlhnQROyJXvNjeEM4UpMXHrQfTGmbQ1gKmelCxlSEBUaxhRBj/EFTzpbP4RVSrpEikbmdJobCvhE3g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css"
        integrity="sha512-sMXtMNL1zRzolHYKEujM2AqCLUR9F2C4/05cdbxjjLSRvMQIciEPCQZo++nk7go3BtSuK9kfa/s+a4f4i5pLkw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- custom css -->
    <link rel="stylesheet" href="css/main1.css" />
    <link rel="stylesheet" href="css/utilities.css" />
    <link rel="stylesheet" href="css/login.css" />
    <!-- normalize.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css"
        integrity="sha512-NhSC1YmyruXifcj/KFRWoC561YpHpc5Jtzgvbuzx5VozKpWvQ+4nXhPdFgmx8xqexRcpAglTj9sIBWINXa8x5w=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>

    <div class="page-wrapper">
        <!-- header -->
        <header class="header">
            <nav class="navbar">
                <div class="container">
                    <div class="navbar-content d-flex justify-content-between align-items-center">
                        <div class="brand-and-toggler d-flex align-items-center justify-content-between">
                            <a href="index.html" class="navbar-brand d-flex align-items-center">
                                <span class="brand-shape d-inline-block text-white">CA</span>
                                <span class="brand-text fw-7">Consultoria Ayala </span>
                            </a>
                            <button type="button" class="d-none navbar-show-btn">
                                <i class="fas fa-bars"></i>
                            </button>
                        </div>

                        <div class="navbar-box">
                            <button type="button" class="navbar-hide-btn">
                                <i class="fas fa-times"></i>
                            </button>

                            <ul class="navbar-nav d-flex align-items-center">
                                <li class="nav-item">
                                    <a href="index.html" class="nav-link text-white text-nowrap">Inicio</a>
                                </li>
                                <li class="nav-item">
                                    <a href="doctores.html" class="nav-link text-white text-nowrap">Doctores</a>
                                </li>
                                <li class="nav-item">
                                    <a href="Citas.html" class="nav-link text-white text-nowrap">Citas</a>
                                </li>
                                <li class="nav-item">
                                    <a href="aviso.html" class="nav-link text-white nav-active text-nowrap">Aviso de
                                        privacidad</a>
                                </li>
                                <li class="nav-item">
                                    <a href="nosostros.html" class="nav-link text-white text-nowrap">Nosotros</a>
                                </li>
                                <li class="nav-item">
                                    <?php if (isset($_SESSION['id'])) { ?>
                                        <a href="cerrar_sesion.php">Cerrar Sesión</a>
                                </li>

                                <li class="nav-item">
                                    <?php } else { ?>
                                        <a href="iniciosesion.php">Iniciar Sesión</a>
                                    <?php } ?>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </nav>

            <div class="element-one">
                <img src="assets/images/element-img-1.png" alt="">
            </div>

           

        <!-- Inicio del login -->

  
        <div class="cajafuera">
    <div class="formulariocaja">
        <div class="botondeintercambiar">
            <div id="btnvai"></div>
             <button type="button" class="botoncambiarcaja" onclick="loginvai()" id="vaibtnlogin">Login</button>
             <button type="button" class="botoncambiarcaja" onclick="registrarvai()" id="vaibtnregistrar">Registrar</button>
		</div>
		<!--Formulario para el login -->
        <form id="frmlogin" class="grupo-entradas" method="POST" action="login.php">
		<div class="logovai"><img src="images/service-icon-4.png"></div>
		<b>&#128231; Correo</b>
        <input type="email" class="cajaentradatexto" name="txtcorreo" required>
		<b>&#128274; Contraseña</b>
        <input type="password" class="cajaentradatexto" name="txtpassword" required>
        <button type="submit" class="botonenviar" name="btnloginx">Iniciar sesión</button>
        <div class="col s12 m6 offset-m3 center-align">
        <a class="oauth-container btn darken-4 white black-text" href="google.php" style="text-transform:none">
        <div class="left">
        <img width="20px" style="margin-top:7px; margin-right:8px" alt="Google sign-in" src="images/google.png" />
        </div>
        Iniciar con Google
        </a>
        <a href="face.php" id="login" class="btn btn-primary">Facebook</a>
</div>

</button>
</script>
        </form>
		<!--Formulario para registrar -->
        <form id="frmregistrar" class="grupo-entradas" method="POST" action="registrar.php">
			<b>&#128231; Correo</b>
        <input type="email" class="cajaentradatexto" required 
		name="txtcorreo">
			<b>&#128274; Contraseña</b>
        <input type="password" class="cajaentradatexto" required name="txtpassword">
			</i>&#128100;<b> Nombre</b>
			 <input type="text" class="cajaentradatexto" required name="txtnombre">
        <div class="checkboxvai"><input type="checkbox"> Acepto los términos y condiciones de uso.</div>
        <button type="submit" class="botonenviar" name="btnregistrarx">Registrar</button>
        </form>
        </div>
    </div>

    <script>
    var x = document.getElementById("frmlogin");
    var y = document.getElementById("frmregistrar");
    var z = document.getElementById("btnvai");
	var textcolor1=document.getElementById("vaibtnlogin");
	var textcolor2=document.getElementById("vaibtnregistrar");
	textcolor1.style.color="white";
	textcolor2.style.color="black";

        function registrarvai()
		{
			
            x.style.left = "-400px";
            y.style.left = "50px";
            z.style.left = "110px";
			textcolor1.style.color="black";
			textcolor2.style.color="white";
	
        }
            function loginvai()
		{
			
            x.style.left = "50px";
            y.style.left = "450px";
            z.style.left = "0";
			textcolor1.style.color="white";
			textcolor2.style.color="black";

        }
		
		function abrirform() {
  document.getElementById("formrecuperar").style.display = "block";
  
}

function cancelarform() {
  document.getElementById("formrecuperar").style.display = "none";
}
    </script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/js/materialize.min.js"></script>

<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
	<script src="main.js"></script>
    
    <script>
	// Load the SDK asynchronously
	  (function(d, s, id) {
	    var js, fjs = d.getElementsByTagName(s)[0];
	    if (d.getElementById(id)) return;
	    js = d.createElement(s); js.id = id;
	    js.src = "//connect.facebook.net/en_US/sdk.js";
	    fjs.parentNode.insertBefore(js, fjs);
	  }(document, 'script', 'facebook-jssdk'));
	 </script>
        

        <footer class="footer">
            <div class="container">
                <div class="footer-content">
                    <div class="footer-list d-grid text-white">
                        <div class="footer-item">
                            <a href="#" class="navbar-brand d-flex align-items-center">
                                <span class="brand-shape d-inline-block text-white">CA</span>
                                <span class="brand-text fw-7">Consultoria Ayala</span>
                            </a>
                            <p class="text-white">Consultoria Ayala proporciona asistencia sanitaria progresiva y
                                accesible
                                en línea para todos.</p>
                            <p class="text-white copyright-text">&copy; Consultoria Ayala 2023. All rights reserved.</p>
                        </div>

                        <div class="footer-item">
                            <h3 class="footer-item-title">Sevicios</h3>
                            <ul class="footer-links">
                                <li><a href="nosostros.html">Acerca de </a></li>
                                <li><a href="doctores.html">Encuentra un doctor</a></li>
                                <li><a href="Citas.html">Citas</a></li>
                                <li><a href="aviso.html">Aviso de privasidad</a></li>
                            </ul>
                        </div>

                    </div>
                </div>
            </div>

            <div class="footer-element-1">
                <img src="assets/images/element-img-4.png" alt="">
            </div>
            <div class="footer-element-2">
                <img src="assets/images/element-img-5.png" alt="">
            </div>

        </footer>

    <!-- jquery cdn -->
    <script src="https://code.jquery.com/jquery-3.6.4.js"
        integrity="sha256-a9jBBRygX1Bh5lt8GZjXDzyOB+bWve9EiO7tROUtj/E=" crossorigin="anonymous"></script>
    <!-- owl carousel -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"
        integrity="sha512-bPs7Ae6pVvhOSiIcyUClR7/q2OAsRiovw4vAkX+zJbw3ShAeeqezq50RIIcIURq7Oa20rW2n2q+fyXBNcU9lrw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- custom js -->
    <script src="assets/js/script.js"></script>
</body>

</html>