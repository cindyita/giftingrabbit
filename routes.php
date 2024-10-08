<?php
session_start();
ob_start();

require_once("./config.php");
require_once("./info.php");
require_once("./src/controllers/pagesController.php");
require_once("./src/controllers/routingController.php");
require_once("./src/resources/html.php");
date_default_timezone_set('UTC');
setlocale(LC_TIME, 'es_ES.UTF-8');

$pages = new PagesController();
$router = new Router('PagesController@error404');

/*-------------------------------------*/

$pages->topHTML();

/*-------------------------------------*/

if(isset($_GET['page'])){

    switch ($_GET['page']) {
        case 'home':
            $pages->updateScripts(["./assets/js/pages/home.js"]);
            $pages->menuHTML();
        break;
        case 'login':
            $pages->updateScripts(["./assets/js/pages/login.js"]);
        break;
        case 'signup':
            $pages->updateScripts(["./assets/js/pages/signup.js"]);
        break;
        case 'forgotpassword':
            $pages->updateScripts(["./assets/js/pages/forgotpassword.js"]);
        break;
        case 'recoverpass':
            $pages->updateScripts(["./assets/js/pages/recoverpass.js"]);
        break;
        case 'myprofile':
            $pages->updateScripts(["./assets/js/pages/myprofile.js"]);
            $pages->menuHTML();
        break;
        case 'settings':
            $pages->updateScripts(["./assets/js/pages/settings.js"]);
            $pages->menuHTML();
        break;
        case 'user':
            $pages->updateScripts(["./assets/js/pages/user.js"]);
            $pages->menuHTML();
        break;
        case 'termsandconditions':
            $pages->menuHTML();
        break;
        case 'privacypolicy':
            $pages->menuHTML();
        break;
        case 'about':
            $pages->menuHTML();
        break;
        case 'cookies':
            $pages->menuHTML();
        break;
        case 'contact':
            $pages->updateScripts(["./assets/js/pages/contact.js"]);
            $pages->menuHTML();
        break;
        case 'exchange':
            $pages->updateScripts(["./assets/js/pages/exchange.js"]);
            $pages->menuHTML();
        break;
        case 'tutorials':
            $pages->menuHTML();
        break;
    }

}

/*-------------------------------------*/

$router->add('/', 'PagesController@index');

$router->add('/home', 'PagesController@home');

$router->add('/login', 'PagesController@login');

$router->add('/signup', 'PagesController@signup');

$router->add('/logout','PagesController@logout');

$router->add('/forgotpassword', 'PagesController@forgotpassword');

$router->add('/recoverpass', 'PagesController@recoverpass');

$router->add('/myprofile', 'PagesController@myprofile');

$router->add('/settings', 'PagesController@settings');

$router->add('/user', 'PagesController@user');

$router->add('/termsandconditions', 'PagesController@termsandconditions');

$router->add('/privacypolicy', 'PagesController@privacypolicy');

$router->add('/about', 'PagesController@about');

$router->add('/cookies', 'PagesController@useofcookies');

$router->add('/contact', 'PagesController@contact');

$router->add('/exchange', 'PagesController@exchange');

$router->add('/tutorials', 'PagesController@tutorials');

$router->run();

/*-------------------------------------*/
/*-------------------------------------*/

$pages->bottomHTML();

/*-------------------------------------*/