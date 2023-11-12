<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta property="description" content="Intercambios de regalos con amigos y familia. Navideño, san valentin y todo tipo de ocasión" />
    <meta name="keywords" content="intercambio de regalos, Navidad, San Valentín, celebraciones, regalos, eventos">
    <meta name="author" content="Cindy ita">
    <meta property="locale" content="es_ES" />
	<meta property="title" content="Gifting Rabbit" />
    <meta property="site_name" content="Gifting Rabbit" />
    <title>Gifting Rabbit | Intercambio de regalos</title>
    <link rel="shortcut icon" href="./assets/img/system/favicon.png" type="image/PNG">

    <script src="./assets/library/jquery/jquery-3.7.0.min.js"></script>

     <!-- Dark/light theme -->
    <script>
        var themeDark = window.matchMedia("(prefers-color-scheme: dark)").matches;
    
        if (localStorage.getItem("theme") === 'dark') {
            themeDark = true;
        } else if (localStorage.getItem("theme") === 'light') {
            themeDark = false;
        }
        // DARK/LIGHT THEME
        function toggleMode() {
            if (themeDark) {
                localStorage.setItem('theme', 'dark');
                document.documentElement.setAttribute("data-theme", "dark");
                $("#imglogo").attr("src", "./assets/img/system/logo.png");
                themeDark = false;
            } else {
                localStorage.setItem('theme', 'light');
                document.documentElement.setAttribute("data-theme", "light");
                $("#imglogo").attr("src", "./assets/img/system/logov2.png");
                themeDark = true;
            }
        }
        toggleMode();
    </script>

    <!-------------required------------>

    <link href="./assets/library/fontawesome/css/fontawesome.min.css" rel="stylesheet">
    <link href="./assets/library/fontawesome/css/brands.min.css" rel="stylesheet">
    <link href="./assets/library/fontawesome/css/solid.min.css" rel="stylesheet">

    <link href="./assets/library/bootstrap5/bootstrap.min.css" rel="stylesheet">
    
    <link href="./assets/library/swiperjs/swiper-bundle.min.css" rel="stylesheet">

    <!-------------/required------------>

    <link href="./assets/css/app.css?version=<?php echo VERSION; ?>" rel="stylesheet">
    <link href="./assets/css/theme.css?version=<?php echo VERSION; ?>" rel="stylesheet">
    <link href="./assets/css/pages.css?version=<?php echo VERSION; ?>" rel="stylesheet">

    <!--------------------------------->
</head>
<body>

    <div class="page-overlay">
        <div class="content">
            <div role="status">
                <div class="spinner-border"></div>
            </div>
        </div>
    </div>

    <header>
        <div class="menu d-flex justify-content-between align-items-center">
            <a href="/">
                <div class="logo">
                    <img src="./assets/img/system/logov2.png" alt="logo" id="imglogo">
                </div>
            </a>
            <div class="menu-right d-flex gap-3 align-items-center">
                <div>
                    <a href="home"><button class="button-display"><span>Entrar</span></button></a>
                </div>
            </div>
        </div>
    </header>

    <div class="main">

        <div class="swiper-content mb-5">
            <div class="swiper mySwiper">
                <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <img src="assets/img/system/slider/6.jpg" />
                    <div class="swiper-text">
                        <h1>Crea intercambios de regalos fácilmente <br>y comparte con tus seres queridos.</h1>
                        <a href="signup"><button class="button-display mt-3"><span>Registrate</span></button></a>
                    </div>
                </div>
                <div class="swiper-slide">
                    <img src="assets/img/system/slider/2.jpg" />
                    <div class="swiper-text">
                        <h1>¡Realiza un intercambio de regalos esta navidad!</h1>
                        <a href="signup"><button class="button-display mt-3"><span>Registrate</span></button></a>
                    </div>
                </div>
                <div class="swiper-slide">
                    <img src="assets/img/system/slider/3.jpg" />
                    <div class="swiper-text">
                        <h1>La felicidad está en dar ¡Y también en recibir!</h1>
                        <a href="signup"><button class="button-display mt-3"><span>Registrate</span></button></a>
                    </div>
                </div>
                </div>
                <div class="swiper-pagination"></div>
            </div>
        </div>

        <br><br><br>

        <section id="features">
            <div class="container px-5">
                <div class="row gx-5 align-items-center">
                    <div class="col-lg-8 order-lg-1 mb-5 mb-lg-0">
                        <div class="container-fluid px-5">
                            <div class="row gx-5">
                                <div class="col-md-6 mb-5">
                                    <!-- Feature item-->
                                    <div class="text-center">
                                        <i class="bi-phone icon-feature text-gradient d-block mb-3"></i>
                                        <h2 class="font-alt">Fácil de usar</h2>
                                        <p class="mb-0">No necesitas estar horas aprendiendo a usar el programa ¡Es muy fácil!</p>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-5">
                                    <!-- Feature item-->
                                    <div class="text-center">
                                        <i class="bi-camera icon-feature text-gradient d-block mb-3"></i>
                                        <h2 class="font-alt">Completo</h2>
                                        <p class="mb-0">Todo lo que necesitas para intercambios en un solo lugar ¡Y más!</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-5 mb-md-0">
                                    <!-- Feature item-->
                                    <div class="text-center">
                                        <i class="bi-gift icon-feature text-gradient d-block mb-3"></i>
                                        <h2 class="font-alt">Registro gratis</h2>
                                        <p class="mb-0">Usarlo y registrarlo es gratis ¡Sin pagos iniciales!</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <!-- Feature item-->
                                    <div class="text-center">
                                        <i class="bi-patch-check icon-feature text-gradient d-block mb-3"></i>
                                        <h2 class="font-alt">Avanzado</h2>
                                        <p class="mb-0">Nuestro avanzado algorítmo permite una experiencia agradable</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 order-lg-0">
                        <div class="features-device-mockup">
                            <div class="device-wrapper">
                                <img src="assets/img/system/gift1.png" width="100%">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <br><br><br>

        <div class="white-box">
            <section class="page-section mt-5" id="services">
                <div class="container">
                    <div class="text-center mb-4">
                        <h2 class="section-heading text-uppercase">¿Cómo funciona?</h2>
                        <h3 class="section-subheading text-muted">Pasos para crear un intercambio de regalos.</h3>
                    </div>
                    <div class="row text-center">
                        <div class="col-md-4">
                            <span class="fa-stack fa-4x">
                                <i class="fas fa-circle fa-stack-2x text-secondary"></i>
                                <i class="fas fa-user fa-stack-1x fa-inverse text-primary"></i>
                            </span>
                            <h4 class="my-3">Crea una cuenta</h4>
                            <p>Crea una cuenta o inicia sesión para entrar al dashboard y poder ver tus intercambios activos.</p>
                        </div>
                        <div class="col-md-4">
                            <span class="fa-stack fa-4x">
                                <i class="fas fa-circle fa-stack-2x text-secondary"></i>
                                <i class="fas fa-gift fa-stack-1x fa-inverse text-primary"></i>
                            </span>
                            <h4 class="my-3">Crea/únete a un intercambio</h4>
                            <p>Crea un nuevo intercambio o únete a uno ingresando el código. Da click en los botones en el dashboard.</p>
                        </div>
                        <div class="col-md-4">
                            <span class="fa-stack fa-4x">
                                <i class="fas fa-circle fa-stack-2x text-secondary"></i>
                                <i class="fas fa-dice fa-stack-1x fa-inverse text-primary"></i>
                            </span>
                            <h4 class="my-3">¡Haz el sorteo!</h4>
                            <p>Cuándo todos los miembros estén en el intercambio, haz el sorteo para saber quien le regalará a quien.</p>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <br><br><br>

        <div class="white-box d-flex flex-column flex-lg-row gap-3">
            <div class="w25 d-flex align-items-center">
                <img src="assets/img/system/gift_green.png" alt="regalos intercambio" width="100%">
            </div>
            <div>
                <section>
                    <h1>Bienvenid@ a Gifting Rabbit</h1>
                    <p>Donde la magia de los regalos se encuentra con la tecnología.</p>
                </section>

                <section>
                    <h2>Versatilidad para Todas las Celebraciones</h2>
                    <p>Ya sea una fiesta de navidad en casa, una fiesta navideña en la oficina, un intercambio de regalos entre amigos o una celebración romántica en San Valentín, nuestro programa se adapta a cualquier ocasión. ¡La diversión está garantizada!</p>
                </section>

                <section>
                    <h2>Fácil de Usar, Increíblemente Divertido</h2>
                    <p>Olvídate de las complicaciones. Con solo unos clics, estarás listo para organizar un intercambio de regalos que todos recordarán. Nuestra interfaz intuitiva y amigable hace que la planificación sea tan emocionante como el evento en sí.</p>
                </section>

                <section>
                    <h2>Conecta con Seres Queridos en Todo el Mundo</h2>
                    <p>¿Tienes amigos o familiares dispersos por el mundo? No hay problema. Nuestro programa permite la participación global, haciendo que cada intercambio de regalos sea una experiencia única, sin importar la distancia.</p>
                </section>

                <section>
                    <h2>Personalización sin Límites</h2>
                    <p>Desde temas festivos hasta reglas personalizadas, tú defines las reglas del juego. ¿Quieres añadir un toque especial? Puedes hacerlo. ¡La creatividad es tu única limitación!</p>
                </section>

                <section>
                    <h2>Garantía de Alegría</h2>
                    <p>En Gifting Rabbit, nos comprometemos a hacer que cada intercambio de regalos sea un éxito. La felicidad de nuestros usuarios es nuestra prioridad número uno.</p>
                </section>

                <section>
                    <p>¿Estás listo para transformar tus celebraciones en momentos inolvidables? <a href="signup">Regístrate ahora</a> en Gifting Rabbit y comienza a planificar tu próximo intercambio de regalos. ¡La magia está a solo un clic de distancia!</p>
                </section>
            </div>
            
        </div>

        <br><br><br>

        <div class="my-5 text-center">
            <a href="home"><button class="button-display"><span>Entrar ahora</button></span></a>
        </div>

    </div>

    <script src="./assets/library/swiperjs/swiper-bundle.min.js"></script>
    <script src="./assets/js/pages/index.js"></script>