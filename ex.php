<?php

//Include Configuration File
include('confing.php');

$login_button = '';

if (isset($_GET["code"])) {

    $token = $google_client->fetchAccessTokenWithAuthCode($_GET["code"]);
    if (!isset($token['error'])) {

        $google_client->setAccessToken($token['access_token']);

        $_SESSION['access_token'] = $token['access_token'];

        $google_service = new Google_Service_Oauth2($google_client);

        $data = $google_service->userinfo->get();

        if (!empty($data['given_name'])) {
            $_SESSION['user_first_name'] = $data['given_name'];
        }

        if (!empty($data['family_name'])) {
            $_SESSION['user_last_name'] = $data['family_name'];
        }

        if (!empty($data['email'])) {
            $_SESSION['user_email_address'] = $data['email'];
        }

        if (!empty($data['gender'])) {
            $_SESSION['user_gender'] = $data['gender'];
        }

        if (!empty($data['picture'])) {
            $_SESSION['user_image'] = $data['picture'];
        }
    }
}

//Ancla para iniciar sesión
if (!isset($_SESSION['access_token'])) {
    $login_button = '<a href="' . $google_client->createAuthUrl() . '" style=" background: #dd4b39; border-radius: 5px; color: white; display: block; font-weight: bold; padding: 20px; text-align: center; text-decoration: none; width: 200px;">Google</a>';
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Consultoria Ayala</title>
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
    <link rel="stylesheet" href="css/clima.css" />
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
                                <li class="nav-item"></li>
                                <?php if (isset($_SESSION['id'])) { ?>
                                </li>
                                    <a href="perfil.php">Mi Perfil</a>
                                <?php } ?>
                                <li class="nav-item">
                                    <a href="#" class="nav-link text-white nav-active text-nowrap">Inicio</a>
                                </li>
                                <li class="nav-item">
                                    <a href="doctores.html" class="nav-link text-white text-nowrap">Doctores</a>
                                </li>
                                <li class="nav-item">
                                    <a href="Citas.html" class="nav-link text-white text-nowrap">Citas</a>
                                </li>
                                <li class="nav-item">
                                    <a href="aviso.html" class="nav-link text-white text-nowrap">Aviso de privacidad</a>
                                </li>
                                <li class="nav-item">
                                    <a href="nosostros.html" class="nav-link text-white text-nowrap">Nosotros</a>
                                </li>
                                <li class="nav-item">
                                    <a href="google.php" class="nav-link text-white text-nowrap">Google</a>
                                </li>
                                <li class="nav-item">
                                    <?php if (isset($_SESSION['id']))  ?>
                                        <a href="logout.php">Cerrar Sesión</a>
                                </li>

                             

<!-- Agrega un enlace para cerrar sesión si el usuario ha iniciado sesión -->


</li>

                            </ul>
                            
                        </div>
                    </div>
                </div>
            </nav>

            <div class="element-one">
                <img src="images/element-img-1.png" alt="">
            </div>

            <div class="banner">
                <div class="container">
                    <div class="banner-content">
                        <div class="banner-left">
                            <div class="content-wrapper">
                                <h1 class="banner-title">Servicios virtuales <br>para ti</h1>
                                <p class="text text-white">Consultoria Ayala proporciona asistencia sanitaria progresiva
                                    y asequible,
                                    accesible desde en línea para todos.</p>
                                <a href="Citas.html" class="btn btn-secondary">Consulta</a>
                            </div>
                        </div>

                        <div class="banner-right d-flex align-items-center justify-content-end">
                            <img src="images/banner-image.png" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <!-- end of header -->

        <main>
            <section class="sc-services">
                <div class="services-shape">
                    <img src="/images/curve-shape-1.png" alt="">
                </div>
                <div class="container">
                    <div class="services-content">
                        <div class="title-box text-center">
                            <div class="content-wrapper">
                                <h3 class="title-box-name">Nuestros Servicios</h3>
                                <div class="title-separator mx-auto"></div>
                                <p class="text title-box-text">Ofrecemos las mejores opciones para usted. Adáptandose a
                                    sus necesidades de salud y asegúrese de someterse a un tratamiento con nuestros
                                    médicos puede consultar con nosotros qué tipo de servicio se adapta a su salud.
                                </p>
                            </div>
                        </div>

                        <div class="services-list">
                            <div class="services-item">
                                <div class="item-icon">
                                    <img src="images/service-icon-1.png" alt="service icon">
                                </div>
                                <h5 class="item-title fw-7">Buscar un doctor</h5>
                                <p class="text">Puedes ver los doctores que tenemos disponibles y sus especialidades.</p>
                            </div>

                            <div class="services-item">
                                <div class="item-icon">
                                    <img src="images/service-icon-4.png" alt="service icon">
                                </div>
                                <h5 class="item-title fw-7">informacion</h5>
                                <p class="text">Ponemos a tu disposición nuestro contacto para aclarar dudad o solucionar problemas.</p>
                            </div>

                            <div class="services-item">
                                <div class="item-icon">
                                    <img src="images/service-icon-5.png" alt="service icon">
                                </div>
                                <h5 class="item-title fw-7">Asistencia</h5>
                                <p class="text">Usted puede obtener 24/7 atención urgente para usted o sus hijos y su
                                    encantadora familia.</p>
                            </div>


                        </div>
                    </div>
            </section>

            <section class="sc-grid sc-grid-one">
                <div class="container">
                    <div class="grid-content d-grid align-items-center">
                        <div class="grid-img">
                            <img src="/images/health-care-img.png" alt="">
                        </div>
                        <div class="grid-text">
                            <div class="content-wrapper text-start">
                                <div class="title-box">
                                    <h3 class="title-box-name text-white">Aviso de privacidad</h3>
                                    <div class="title-separator mx-auto"></div>
                                </div>

                                <p class="text title-box-text text-white">Estamos orgullosos de las soluciones que
                                    ofrecemos</p>
                                <a href="aviso.html"><button type="button" class="btn btn-white-outline">Más información</button></a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <section class="sc-feedback">
                <div class="container">
                    <div class="feedback-content">
                        <div class="feedback-element">
                            <img src="images/element-img-3.png">
                        </div>
                        <div class="feedback-element-2">
                            <img src="images/element-img-5.png">
                        </div>
                        <div class="title-box text-center">
                            <div class="content-wrapper">
                                <h3 class="title-box-name text-white">¿Qué dicen nuestros clientes?</h3>
                                <div class="title-separator mx-auto"></div>
                            </div>
                        </div>

                        <div class="feedback-list feedback-slider owl-carousel owl-theme">
                            <div class="feedback-item d-grid">
                                <div class="item-left d-flex align-items-center">
                                    <div class="item-img">
                                        <img src="images/bob.jpg" alt="">
                                    </div>
                                    <div class="item-info text-white">
                                        <p class="fw-7 name">Samuel Betancurt</p>
                                        <span class="designation fw-4">Founder Circle</span>
                                    </div>
                                </div>
                                <div class="item-right">
                                    <p class="text text-white">"Aplicación dedicada a la participación del
                                        paciente"</p>
                                </div>
                            </div>

                            <div class="feedback-item d-grid">
                                <div class="item-left d-flex align-items-center">
                                    <div class="item-img">
                                        <img src="images/pipi.jpg" alt="">
                                    </div>
                                    <div class="item-info text-white">
                                        <p class="fw-7 name">Sebastian Portillo</p>
                                        <span class="designation fw-4">Founder Circle</span>
                                    </div>
                                </div>
                                <div class="item-right">
                                    <p class="text text-white">"El portal web
                                        le permiten acceder a la información al instante (sin formularios tediosos,
                                        largas llamadas ni
                                        administrativas)"</p>
                                </div>
                            </div>

                            <div class="feedback-item d-grid">
                                <div class="item-left d-flex align-items-center">
                                    <div class="item-img">
                                        <img src="images/gay.jpg" alt="">
                                    </div>
                                    <div class="item-info text-white">
                                        <p class="fw-7 name">Andy Roblero</p>
                                        <span class="designation fw-4">Founder Circle</span>
                                    </div>
                                </div>
                                <div class="item-right">
                                    <p class="text text-white">"Es una plataforma responsiva"</p>
                                </div>
                            </div>

                            <div class="feedback-item d-grid">
                                <div class="item-left d-flex align-items-center">
                                    <div class="item-img">
                                        <img src="images/fierro.jpg" alt="">
                                    </div>
                                    <div class="item-info text-white">
                                        <p class="fw-7 name">Alejandro Ayala</p>
                                        <span class="designation fw-4">Founder Circle</span>
                                    </div>
                                </div>
                                <div class="item-right">
                                    <p class="text text-white">"Es una plataforma segura</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="weather-content">
                <h1>Buscador del clima</h1>
                <div class="result">
                    <p>Agrege cuidad y pais</p>
                    <!-- <h5>Clima en Bogota</h5>
                    <img src="" alt="">
                    <h2>28°C</h2>
                    <p>Max: 29°C</p>
                    <p>Min: 27°C</p> -->
                </div>
                <form action="" method="POST" class="get-weather">
                    <select name="" id="country">
                        <option disabled selected value="">Select the country</option>
                        <option value="AR">Argentina</option>
                        <option value="CO">Colombia</option>
                        <option value="CR">Costa Rica</option>
                        <option value="ES">España</option>
                        <option value="US">Estados Unidos</option>
                        <option value="MX">México</option>
                        <option value="PE">Perú</option>
                    </select>
                    <input type="text" name="city" id="city" placeholder="Write your city...">
                    <input type="submit" name="" id="" value="Get Weather">
                </form>
            </section>


        </main>

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
                <img src="images/element-img-4.png" alt="">
            </div>
            <div class="footer-element-2">
                <img src="images/element-img-5.png" alt="">
            </div>
        </footer>
    </div>

    <!-- jquery cdn -->
    <script src="https://code.jquery.com/jquery-3.6.4.js"
        integrity="sha256-a9jBBRygX1Bh5lt8GZjXDzyOB+bWve9EiO7tROUtj/E=" crossorigin="anonymous"></script>
    <!-- owl carousel -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"
        integrity="sha512-bPs7Ae6pVvhOSiIcyUClR7/q2OAsRiovw4vAkX+zJbw3ShAeeqezq50RIIcIURq7Oa20rW2n2q+fyXBNcU9lrw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- custom js -->
    <script src="assets/js/script.js"></script>
    <script src="./custom.js" defer></script>
</body>

</html>