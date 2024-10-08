<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-5204471202830622"
     crossorigin="anonymous"></script>

    <meta property="description" content="Intercambios de regalos con amigos y familia. Navideño, san valentin y todo tipo de ocasión" />
    <meta property="locale" content="es_ES" />
	<meta property="title" content="Gifting Rabbit" />
    <meta property="site_name" content="Gifting Rabbit" />
    <title>Gifting Rabbit | Intercambio de regalos</title>
    <link rel="shortcut icon" href="./assets/img/system/favicon.png" type="image/PNG">

    <script src="./assets/library/jquery/jquery-3.7.0.min.js"></script>

     <!-- Dark/light theme -->
    <script defer>
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
                $("#imglogo").attr("src", "./assets/img/system/logo.webp");
                themeDark = false;
            } else {
                localStorage.setItem('theme', 'light');
                document.documentElement.setAttribute("data-theme", "light");
                $("#imglogo").attr("src", "./assets/img/system/logov2.webp");
                themeDark = true;
            }
        }
        toggleMode();
    </script>

    <!-------------required------------>

    <!-- <link href="./assets/library/fontawesome/css/fontawesome.min.css" rel="stylesheet">
    <link href="./assets/library/fontawesome/css/brands.min.css" rel="stylesheet">
    <link href="./assets/library/fontawesome/css/solid.min.css" rel="stylesheet"> -->
    <script async src="https://kit.fontawesome.com/e0df5df9e9.js" crossorigin="anonymous"></script>

    <link href="./assets/library/bootstrap5/bootstrap.min.css" rel="stylesheet">

    <script src="./assets/library/momentjs/momentjs-locales.js"></script>
    <script src="./assets/library/momentjs/momentjs-timezone.js"></script>

    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <script async src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

    <!-----------ReCaptcha------------>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <!-----------/ReCaptcha------------>

    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.9.0/dist/confetti.browser.min.js"></script>

    <!-------------/required------------>

    <link href="./assets/css/app.css?version=<?php echo VERSION; ?>" rel="stylesheet">
    <link href="./assets/css/theme.css?version=<?php echo VERSION; ?>" rel="stylesheet">
    <link href="./assets/css/pages.css?version=<?php echo VERSION; ?>" rel="stylesheet">

    <?php 
        if($styles){
            foreach ($styles as $value) {
                echo '<link href="'.$value.'?version='.VERSION.'" rel="stylesheet">';
            }
        }
    ?>
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

<div id="superiorBanner">
    <div class="superior-banner d-flex justify-content-between">
        <span></span>
        <span>Al utilizar nuestro sitio, aceptas nuestras <a href="privacypolicy">Políticas de Privacidad y Política de Cookies</a>. Esto incluye el uso de cookies para mejorar tu experiencia.</span>
        <a class="cursor-pointer ms-2" id="closeSuperiorBanner">Aceptar</a>
    </div>
</div>

<div class="body">
