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
        $acceptPages = array("");
        $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
        if (!in_array($currentPage, $acceptPages)) {

            if (!isset($_SESSION['status_login'])) {

                header('Location: login');
                exit();
            }
        }

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
    public static function index() {
        require_once "./src/views/pages/index.php";
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

    /**
     * Shows forgotpassword
     */
    public static function forgotpassword() {
        require_once "./src/views/pages/forgotpassword.php";
    }

    /**
     * Shows recover password
     */
    public static function recoverpass() {
        $db = new QueryModel();
        $token = $_GET['token'];
        $tokens = $db->query("SELECT id_user,expiration_date FROM REG_TOKENS WHERE token = :token", [":token" => md5($token)]);

        if ($tokens && $tokens[0]['expiration_date'] >= date("Y-m-d H:i:s")) {
            require_once "./src/views/pages/recoverpass.php";
        } else {
            echo '<div class="main"><div class="white-box d-flex justify-content-center align-items-center"><p>El token es inválido o ya se ha utilizado.</p></div></div>';
        }
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
     * Shows settings page
     */
    public static function settings() {
        self::checkSession();
        $db = new QueryModel();
        if($_SESSION['userdata']['id']){
            $id = $_SESSION['userdata']['id'];
            $user = $db->query("SELECT * FROM SYS_USER WHERE id = :id",[":id"=>$id]);
            $user = $user[0];
            require_once "./src/views/pages/settings.php";
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
     * Shows exchange page
     */
    public static function exchange() {
        $db = new QueryModel();
        if(!isset($_GET['id'])){
            echo "Link inválido";
        }else{
            $id = $_GET['id'];
            $id_user = $_SESSION['userdata']['id'];
            $access = $db->query("SELECT role FROM REL_USER_EXCHANGE WHERE id_exchange = :id AND id_user = :id_user",[":id"=>$id,":id_user"=>$id_user]);
            if($access){
                $exchange = $db->query("SELECT e.*,u.username username_create,us.username username_admin FROM VIEW_EXCHANGES e LEFT JOIN SYS_USER u ON e.id_user = u.id LEFT JOIN SYS_USER us ON e.id_admin = us.id WHERE e.id = :id",[":id"=>$id])[0];
                $users = $db->query("SELECT e.*,u.username,u.img_profile FROM REL_USER_EXCHANGE e LEFT JOIN SYS_USER u ON e.id_user = u.id WHERE e.id_exchange = :id",[":id"=>$id]);
                $contacts = $db->query("SELECT * FROM REG_CONTACTS WHERE id_exchange = :id",[":id"=>$id]);
                $comments = $db->query("SELECT c.*, u.username, u.img_profile 
                            FROM REG_COMMENTS c 
                            LEFT JOIN SYS_USER u ON c.id_user = u.id 
                            WHERE c.id_exchange = :id_exchange
                            ORDER BY c.timestamp_create DESC",[":id_exchange"=>$id]);
                $wantGiftYou = $db->query("SELECT w.*,u.username,u.img_profile FROM REG_WISHGIFTS w LEFT JOIN SYS_USER u ON w.id_user = u.id WHERE w.id_user = :id_user AND w.id_exchange = :id",[":id_user"=>$id_user,":id"=>$id]);
                if($access[0]['role'] == 1 && $exchange['admin_participates'] == 0){
                    $wantGiftAll = $db->query("SELECT w.*,u.username,u.img_profile FROM REG_WISHGIFTS w LEFT JOIN SYS_USER u ON w.id_user = u.id WHERE w.id_exchange = :id",[":id"=>$id]);
                }else{
                    $wantGiftAll = 0;
                    $wantGiftNames = $db->query("SELECT u.username FROM REG_WISHGIFTS w LEFT JOIN SYS_USER u ON w.id_user = u.id WHERE w.id_exchange = :id GROUP BY u.username",[":id"=>$id]);
                }
                if ($exchange['drawn_on']) {
                    $resultRaffle = $db->query("SELECT r.id_result,r.type_result,
                                                    CASE 
                                                        WHEN r.type_result = 'USER' THEN u.username
                                                        WHEN r.type_result = 'CONTACT' THEN c.name
                                                    END AS result_name,
                                                    CASE 
                                                        WHEN r.type_result = 'USER' THEN u.img_profile
                                                        WHEN r.type_result = 'CONTACT' THEN NULL
                                                    END AS result_profile,
                                                    CASE 
                                                        WHEN r.type_result = 'USER' THEN NULL
                                                        WHEN r.type_result = 'CONTACT' THEN c.note
                                                    END AS result_note,
                                                    CASE 
                                                        WHEN r.type_result = 'USER' THEN w.comment
                                                        WHEN r.type_result = 'CONTACT' THEN c.wantgift
                                                    END AS result_comment
                                                FROM REL_RESULT_RAFFLE r
                                                LEFT JOIN SYS_USER u ON r.id_result = u.id AND r.type_result = 'USER'
                                                LEFT JOIN REG_CONTACTS c ON r.id_result = c.id AND r.type_result = 'CONTACT'
                                                LEFT JOIN REG_WISHGIFTS w ON r.id_result = w.id_user AND r.type_result = 'USER' AND w.id_exchange = :id_exchange
                                                WHERE r.type_user = 'USER' AND r.id_user = :id_user AND r.id_exchange = :id_exchange
                                    ",[":id_user"=>$id_user,':id_exchange'=>$id])[0];
                }
                require_once "./src/views/pages/exchange.php";
            }else{
                echo "No puedes ver esta página";
            }    
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
    public static function about() {
        require_once "./src/views/pages/about.php";
    }

    /**
     * Shows contact page
     */
    public static function contact() {
        require_once "./src/views/pages/contact.php";
    }

    /**
     * Muestra la página de error 404 (página no encontrada).
     */
    public static function error404() {
        require_once "./src/views/pages/error404.php";
    }
    
}
