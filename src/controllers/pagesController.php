<?php
require_once "./src/models/queryModel.php";
class PagesController
{
    private $queryModel;
    private $styles;
    private $scripts;

    /**
     * Constructor de la clase PagesController.
     * Crea una instancia del modelo QueryModel.
     */
    public function __construct() {
        $this->queryModel = new QueryModel();
        $this->styles = [];
        $this->scripts = [];
    }

    public function getStyles() {
        return $this->styles;
    }

    public function updateStyles($data) {
        $this->styles = $data;
    }

    public function getScripts() {
        return $this->scripts;
    }

    public function updateScripts($data) {
        $this->scripts = $data;
    }

    /**
     * Revisar si hay una sesión
     */
    public static function checkSession() {
        $acceptPages = array('');
        $currentPage = $_GET['page'];
        if (!in_array($currentPage, $acceptPages)) {

            if (!isset($_SESSION['status_login'])) {

                header('Location: login');
                exit();
            }
        }

    }

    /**
     * Check and shows login page
     */
    public static function login() {   
        if (isset($_SESSION['user_id'])) {

            header('Location: home');
            exit();
        }else{
            require_once "./src/views/pages/login.php";
        }
    }

    /**
     * Check and shows sign up page
     */
    public static function signup() {   
        if (isset($_SESSION['user_id'])) {

            header('Location: home');
            exit();
        }else{
            require_once "./src/views/pages/signup.php";
        }
    }

    /**
     * Logout session
     */
    public static function logout() {   
        echo "Signing out... Redirecting...";
        if (isset($_COOKIE[session_name()])) {
            setcookie(session_name(), '', time() - 42000, '/');
        }
        session_destroy();
        header('Location: login');
        exit();
    }


    public function topHTML() {
        $styles = $this->styles;
        require_once "./src/views/layouts/headerLayout.php";
    }

    public function bottomHTML() { 
        $scripts = $this->scripts;
        require_once "./src/views/layouts/footerLayout.php";
    }

    public static function menuHTML() {   
        require_once "./src/views/layouts/menuLayout.php";
    }

    /**
     * Shows home
     */
    public static function home() {
        self::checkSession();
        $db = new QueryModel();
        $exchanges_user = $db->query("SELECT e.*,r.* FROM REL_USER_EXCHANGE r JOIN VIEW_EXCHANGES e ON r.id_exchange = e.id WHERE r.id_user = :id_user",[":id_user"=>$_SESSION['userdata']['id']]);
        require_once "./src/views/pages/home.php";
    }
    
    /**
     * Shows profile page
     */
    public static function myprofile() {
        self::checkSession();
        $db = new QueryModel();
        if($_SESSION['userdata']['id']){
            $id = $_SESSION['userdata']['id'];
            $user = $db->query("SELECT u.* FROM SYS_USER u WHERE u.id = :id",[":id"=>$id]);
            $user = $user[0];
            require_once "./src/views/pages/myprofile.php";
        }else{
            header('Location: login');
        }

    }

    /**
     * Shows user page
     */
    public static function user() {
        self::checkSession();
        $db = new QueryModel();
        if($_GET['id']){
            $id = $_GET['id'];
            $user = $db->query("SELECT u.* FROM SYS_USER u WHERE u.id = :id",[":id"=>$id]);
            $user = $user[0];
            require_once "./src/views/pages/user.php";
        }else{
            header('Location: home');
        }

    }

    /**
     * Shows exchange
     */
    public static function exchange() {
        $db = new QueryModel();
        $id = $_GET['id'];
        $id_user = $_SESSION['userdata']['id'];
        $access = $db->query("SELECT id FROM REL_USER_EXCHANGE WHERE id_exchange = :id AND id_user = :id_user",[":id"=>$id,":id_user"=>$id_user]);
        if($access){
            $exchange = $db->query("SELECT e.*,u.username username_create,us.username username_admin FROM VIEW_EXCHANGES e LEFT JOIN SYS_USER u ON e.id_user = u.id LEFT JOIN SYS_USER us ON e.id_admin = us.id WHERE e.id = :id",[":id"=>$id])[0];
            $users = $db->query("SELECT e.*,u.username,u.img_profile FROM REL_USER_EXCHANGE e LEFT JOIN SYS_USER u ON e.id_user = u.id WHERE e.id_exchange = :id",[":id"=>$id]);
            $comments = $db->query("SELECT c.*, u.username, u.img_profile 
                        FROM REG_COMMENTS c 
                        LEFT JOIN SYS_USER u ON c.id_user = u.id 
                        WHERE c.id_exchange = :id_exchange
                        ORDER BY c.timestamp_create DESC",[":id_exchange"=>$id]);
            require_once "./src/views/pages/exchange.php";
        }else{
            echo "No puedes ver esta página";
        }
        
    }

    /**
     * CONDITIONS PAGES
     */
    public static function termsandconditions() {
        require_once "./src/views/pages/termsandconditions.php";
    }
    public static function privacypolicy() {
        require_once "./src/views/pages/privacypolicy.php";
    }
    public static function useofcookies() {
        require_once "./src/views/pages/useofcookies.php";
    }

    /**
     * Shows contact page
     */
    public static function contact() {
        self::checkSession();
        require_once "./src/views/pages/contact.php";
    }

    /**
     * Muestra la página de error 404 (página no encontrada).
     */
    public static function error404() {
        require_once "./src/views/pages/error404.php";
    }
    
}
