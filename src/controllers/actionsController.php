<?php

require_once "../models/queryModel.php";
require_once("../../config.php");
session_start();

$action = $_GET['action'];
switch ($action) {
    case 'login':
        login();
    break;
    case 'checkusername':
        checkusername();
    break;
    case 'checkemail':
        checkemail();
    break;
    case 'signup':
        signup();
    break;
    case 'saveprofile':
        saveprofile();
    break;
    case 'updateProfile':
        updateProfile();
    break;
    case 'sendContactForm':
        sendContactForm();
    break;
    /*--------------------*/
    case 'createExchange':
        createExchange();
    break;
    case 'updateFeedExchanges':
        updateFeedExchanges();
    break;
    case 'joinExchange':
        joinExchange();
    break;
    case 'exitExchange':
        exitExchange();
    break;
    case 'deleteExchange':
        deleteExchange();
    break;
    /*---------------------*/
    case 'kickUserExchange':
        kickUserExchange();
    break;
    case 'newCommentPost':
        newCommentPost();
    break;
    case 'updateCommentPost':
        updateCommentPost();
    break;
    case 'deleteCommentPost':
        deleteCommentPost();
    break;
    case 'giveAdmin';
        giveAdmin();
    break;
    case 'editExchange':
        editExchange();
    break;
    /*---------------------*/
    default:
        echo json_encode("No action defined: ".$action);
    break;
}

function getData(){
    return isset($_POST) ? $_POST : '';
}

function login(){
    $data = getData();

    try{
        /*-ReCaptcha----------*/
        $recaptcha_url = 'https://www.google.com/recaptcha/api/siteverify'; 
        $recaptcha_secret = RECAPTCHA_SECRET; 
        $recaptcha_response = $data['g-recaptcha-response']; 
        $recaptcha = file_get_contents($recaptcha_url . '?secret=' . $recaptcha_secret . '&response=' . $recaptcha_response); 
        $recaptcha = json_decode($recaptcha); 

        if($recaptcha->success == true){

            $db = new QueryModel();
            $username = $data['username'];
            
            $user = $db->query("SELECT u.*, r.name as rolname, r.status as rolstatus FROM SYS_USER u JOIN SYS_ROL r ON u.id_rol = r.id WHERE username = :username", [':username' => $username]);
            $user = $user[0];

            if ($user && isset($user) && isset($user['password']) && $user['password'] == md5($data['pass'])) {

                foreach ($user as $key => $value) {
                    if($key != "password"){
                        $_SESSION['userdata'][$key] = $value;
                    }
                }
                $_SESSION['status_login'] = 1;

                echo 1;
            } else {
                echo 0;
            }
        /*-------*/
        } else {
            echo 2;
        }
        
    }catch(exception $e){
        echo json_encode('error: '.$e->getMessage());
    }
}

function checkusername(){
    $db = new QueryModel();
    $data = getData();
    $username = $data['input'];
    $value = $db->selectUnique("SYS_USER", "username = '".$username."'","username");
    if($value){
        echo 1;
    }else{
        echo 0;
    }
}

function checkemail(){
    $db = new QueryModel();
    $data = getData();
    $email = $data['input'];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo 2;
        die();
    }

    list($user, $domain) = explode('@', $email);
    if(!checkdnsrr($domain, 'MX')){
        echo 2;
        die();
    }

    $value = $db->selectUnique("SYS_USER", "email = '".$email."'","email");
    if($value){
        echo 1;
    }else{
        echo 0;
    }
}

function signup() {
    $data = getData();
    try {
        /*-ReCaptcha----------*/
        $recaptcha_url = 'https://www.google.com/recaptcha/api/siteverify'; 
        $recaptcha_secret = RECAPTCHA_SECRET; 
        $recaptcha_response = $data['g-recaptcha-response']; 
        $recaptcha = file_get_contents($recaptcha_url . '?secret=' . $recaptcha_secret . '&response=' . $recaptcha_response); 
        $recaptcha = json_decode($recaptcha); 

        if($recaptcha->success == true){

            date_default_timezone_set('UTC');


            $db = new QueryModel();
            $pass = md5($data['pass']);
            $insertData = [
                'email' => $data['email'],
                'username' => $data['username'],
                'password' => $pass,
                'timestamp_create'=>date('Y-m-d H:i:s')
            ];

            $register = $db->insert('SYS_USER', $insertData);

            // if($register){
            //     sendEmailSMTP("contact@pricture.theblux.com", $data['name'], $data['email'], $data['username'],"Thank you for registering on Pricture", '', ["host"=>"ngx341.inmotionhosting.com","username"=>"contact@pricture.theblux.com","password"=>"-K7prPb9#8=}","port"=>"465"],["title"=>"Thank you for registering on the page","content"=>"We hope that your stay is to your liking, remember that we are still in the development and testing phase. Stop by from time to time to see what's new on the page and if you have any problems with your account, send us an email."]);
            // }
            echo json_encode($register);
            
        } else {
            echo 6;
        }


    } catch (Exception $e) {
        echo json_encode('error: '.$e->getMessage());
    }
}

function saveprofile(){
    $data = getData();
    $db = new QueryModel();

    // Profile image
    $newimgprofile = null;
    if (isset($_FILES['img-profile'])) {
        $uploadDirectory = '../../assets/img/user/img-profile/';
        $profileFileName = $_SESSION['userdata']['id'] . '.' . strtolower(pathinfo($_FILES['img-profile']['name'], PATHINFO_EXTENSION));

        if (file_exists($uploadDirectory . $profileFileName)) {
            unlink($uploadDirectory . $profileFileName);
        }

        $newimgprofile = uploadFile($_FILES['img-profile'], $uploadDirectory, $profileFileName);
        $_SESSION['userdata']['img_profile'] = $profileFileName;
    }

    // Update data
    $updateData = [
        'biography' => $data['biography']
    ];

    if ($data['username'] != $data['actual_username']) {
        $updateData['username'] = $data['username'];
    }
    if ($data['likes']) {
        $updateData['likes'] = $data['likes'];
    }
    if ($data['dislikes']) {
        $updateData['dislikes'] = $data['dislikes'];
    }
    if ($data['birthday']) {
        $updateData['birthday'] = $data['birthday'];
    }
    if ($newimgprofile) {
        $updateData['img_profile'] = $profileFileName;
    }

    try {
        $register = $db->update('SYS_USER', $updateData, 'id =' . $_SESSION['userdata']['id']);
        echo json_encode($register);
    } catch (Exception $e) {
        echo json_encode('error: ' . $e->getMessage());
    }
}



function updateProfile() {
    $response = array();

    $db = new QueryModel();
    $id = $_SESSION['userdata']['id'];
    $user = $db->query("SELECT u.*, r.name AS rol FROM SYS_USER u 
    LEFT JOIN SYS_ROL r ON u.id_rol = r.id WHERE u.id = :id", [":id" => $id]);
    $user = $user[0];

    $response['user'] = $user;

    echo json_encode($response);
}



function sendContactForm(){
    $data = getData();

    /*-ReCaptcha----------*/
    $recaptcha_url = 'https://www.google.com/recaptcha/api/siteverify'; 
    $recaptcha_secret = RECAPTCHA_SECRET; 
    $recaptcha_response = $data['g-recaptcha-response']; 
    $recaptcha = file_get_contents($recaptcha_url . '?secret=' . $recaptcha_secret . '&response=' . $recaptcha_response); 
    $recaptcha = json_decode($recaptcha);

    if ($recaptcha->success == true) {

        $db = new QueryModel();

        require("../resources/email.php");

        $para = CONTACT_EMAIL;
        $asunto = "New " . $data['subject'] . " From: " . $data['name'];
        $user = "";

        if (isset($_SESSION['status_login_pricture'])) {
            $user = $_SESSION['userdata']['id'];
        }
        $mensaje = "<strong>New contact form message</strong><br><br> User id: " . $user . "<br> Email: " . $data['email'] . "<br> Message:<br> " . $data['comment'];

        sendEmailSMTP($para, $data['name'], $para, "pricture admin", $data['subject'], $mensaje, ["host" => HOST_EMAIL, "username" => CONTACT_EMAIL, "password" => PASSWORD_EMAIL, "port" => PORT_EMAIL]);
    }else{
        echo 6;
    }

}

function createExchange(){
    $data = getData();
    $id_user = $_SESSION['userdata']['id'];

    $newFileName = null;
    if (isset($_FILES['img']) && $_FILES['img']['name']) {
        $uploadDirectory = '../../assets/img/exchanges/';
        $newFileName = "gr" . $id_user . datetime() . '.' . strtolower(pathinfo($_FILES['img']['name'], PATHINFO_EXTENSION));

        if (file_exists($uploadDirectory . $newFileName)) {
            unlink($uploadDirectory . $newFileName);
        }

        $img = uploadFile($_FILES['img'], $uploadDirectory, $newFileName);
    }

    $db = new QueryModel();
    $insertData = [
        'name' => $data['name'],
        'about' => $data['about'],
        'rules' => $data['rules'],
        'type_gift' => $data['type_gift'],
        'min_price' => $data['min_price'],
        'max_price' => $data['max_price'],
        'img' => $newFileName,
        'id_user'=>$id_user,
        'event_date' => $data['event_date'],
        'timestamp_create'=>timestamp()
    ];

    $res1 = $db->insert('REG_EXCHANGES', $insertData);
    $lastid = $db->lastid('REG_EXCHANGES');

    $code = generateShortCode($lastid);

    $res2 = $db->update('REG_EXCHANGES', ['code' => $code], 'id = ' . $lastid);

    if($res1 && $res2){
        $res = $db->insert('REL_USER_EXCHANGE', ['id_exchange'=>$lastid,'id_user'=>$id_user,'role'=>1]);
        echo json_encode($res);
    }else{
        echo json_encode("Error");
    }
    
}

function joinExchange(){
    $data = getData();
    $db = new QueryModel();
    $id_user = $_SESSION['userdata']['id'];

    $query = $db->query('SELECT id FROM REG_EXCHANGES WHERE code = :code', ['code' =>$data['code']]);
    if($query){
        $res = $db->insert('REL_USER_EXCHANGE', ['id_exchange'=>$query[0]['id'],'id_user'=>$id_user,'role'=>0]);
        echo json_encode($res);
    }else{
        echo 3;
    }
    
}

function updateFeedExchanges(){
    $db = new QueryModel();
    $exchanges_user = $db->query("SELECT e.*,r.* FROM REL_USER_EXCHANGE r JOIN REG_EXCHANGES e ON r.id_exchange = e.id WHERE r.id_user = :id_user",[":id_user"=>$_SESSION['userdata']['id']]);
    $html = "";
    foreach ($exchanges_user as $key => $value) {
        $html .= '<div class="green-card">
            <div class="head">
                <div class="img">
                    <a href="exchange?id='.$value['id'].'">
                        <img src="./assets/img/exchanges/'.$value['img'].'" alt="img intercambio" onerror="this.src = \'./assets/img/system/defaultimg.jpg\'">
                    </a>
                </div>
                <div class="info">
                    <strong><a href="exchange?id='.$value['id'].'">'.$value['name'].'</a></strong>
                    <span>Código: '.$value['code'].'</span>
                    <span>Miembros: '.$value['num_members'].'</span>
                    <span>Fecha del evento: <span class="dateFormat">'.$value['event_date'].'</span></span>
                </div>
            </div>
            <div class="options">
                <div class="dropdown">
                    <a class="btn button-options" data-bs-toggle="dropdown">
                        <i class="fa-solid fa-ellipsis-vertical"></i>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" onclick="copyToClipboard(\''.$value['code'].'\')">Copiar código <i class="fa-solid fa-clipboard"></i></a></li>
                        <li><a class="dropdown-item" href="exchange?id='.$value['id'].'">Ver intercambio <i class="fa-solid fa-eye"></i></a></li>';
                        if ($value['role'] != 1) {
                            $html .= '<li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#exitExchange" onclick="exitExchangeForm('.$value['id'] . ',\'' . $value['name'].'\')">Salir del intercambio <i class="fa-solid fa-right-from-bracket"></i></a></li>';
                        } 
                        if ($value['role'] == 1) {
                            $html .= '<li><a class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#deleteExchange" onclick="deleteExchangeForm(' . $value['id'] . ',\'' . $value['name'] . '\')">Borrar intercambio <i class="fa-solid fa-trash"></i></a></li>';
                         } 
                    $html .= '</ul>
                </div>
            </div>
        </div>';
    }
    echo json_encode($html);
}

function exitExchange(){
    $data = getData();
    $db = new QueryModel();
    $id_user = $_SESSION['userdata']['id'];
    $query = $db->delete('REL_USER_EXCHANGE', 'id_exchange = '.$data['id'].' AND id_user = '.$id_user);
    echo json_encode($query);
}

function deleteExchange(){
    $data = getData();
    $db = new QueryModel();
    $query = $db->delete('REL_USER_EXCHANGE', 'id_exchange = '.$data['id']);
    $query = $db->delete('REG_EXCHANGES', 'id = '.$data['id']);
    echo json_encode($query);
}

function kickUserExchange(){
    $data = getData();
    $db = new QueryModel();
    $query = $db->delete('REL_USER_EXCHANGE', 'id_exchange = '.$data['id_exchange'].'AND id_user = '.$data['id_user']);
    echo json_encode($query);
}

function newCommentPost(){
    $data = getData();
    if (isset($_SESSION['status_login'])) {
        $id_user = $_SESSION['userdata']['id'];
        $id_exchange = $data['id_exchange'];
        $db = new QueryModel();
        date_default_timezone_set('UTC');
        try {
            $data = [
                'id_user'=> $id_user,
                'id_exchange' => $id_exchange,
                'comment' => $data['comment'],
                'timestamp_create'=>date('Y-m-d H:i:s')
            ];
            $register = $db->insert('REG_COMMENTS', $data);
            echo json_encode($register);

        } catch (Exception $e) {
            echo json_encode('error: '.$e->getMessage());
        }
    }else{
        echo 5;
    }
    
}

function updateCommentPost(){
    $data = getData();
    $id = $data['id_exchange'];
    $db = new QueryModel();
    try {
        $id_user = $_SESSION['userdata']['id'];
        $comments = $db->query("SELECT c.*, u.username, u.img_profile 
                        FROM REG_COMMENTS c 
                        LEFT JOIN SYS_USER u ON c.id_user = u.id 
                        WHERE c.id_exchange = :id_exchange
                        ORDER BY c.timestamp_create DESC",[":id_exchange"=>$id]);
        $exchange = $db->query("SELECT id_admin FROM VIEW_EXCHANGES WHERE id = :id",[":id"=>$id])[0];
        $html = "";

        foreach ($comments as $value) {
            $html .= '<div class="w-100">
                    <div class="d-flex gap-2">
                        <div>
                            <div class="img-user">
                                <a href="user?id='.$value['id_user'].'"><img src="./assets/img/'.($value['img_profile'] ? 'user/img-profile/'.$value['img_profile'] : 'system/defaultprofile.jpg').'" alt="image profile" onerror="this.src = \'./assets/img/system/defaultimgsq.jpg\'"></a>
                            </div>
                        </div>
                        <div class="d-flex flex-column w-100">
                            <div class="d-flex justify-content-between">
                                <span class="user-name d-flex gap-1 flex-column flex-md-row">
                                    <a href="user?id=1">'.$value['username'];
                                    if($value['id_user'] == $exchange['id_admin']){
                                        $html .= ' <span class="text-warning"><i class="fa-solid fa-crown"></i></span>';
                                    }
                                    $html .= '</a> <span class="ms-0 ms-md-2 text-secondary relativedate">'.$value['timestamp_create'].'</span>
                                </span>
                                <span>';
                                    if (isset($_SESSION['status_login'])) {
                                        if ($id_user == $value['id_user'] || $_SESSION['userdata']['id_rol'] <= 2 || $id_user == $exchange['id_admin']) {
                                            $html .= '<a class="text-danger cursor-pointer" data-bs-toggle="modal" data-bs-target="#confirmDeleteComment" onclick="deleteComment('.$value['id_user'] . ',' . $value['id'] . ',' . $id.')"><i class="fa-solid fa-trash"></i></a>';
                                        }
                                    }
                                $html .= '</span>
                            </div>
                            <span class="py-2 p-md-2">'.$value['comment'].'</span>
                        </div>
                    </div>

                </div>';
        }
        echo json_encode($html);

    } catch (Exception $e) {
        echo json_encode('error: '.$e->getMessage());
    }
}


function deleteCommentPost(){
    $data = getData();
    $id_comm = $data['id_comm'];
    //$id_usercomm = $data['id_user'];
    if (isset($_SESSION['status_login'])) {

            $db = new QueryModel();
            try {
                $register = $db->delete('REG_COMMENTS', 'id = ' . $id_comm);
                echo json_encode($register);

            } catch (Exception $e) {
                echo json_encode('error: ' . $e->getMessage());
            }

    }else{
        echo 5;
    }
    
}

function giveAdmin(){
    $data = getData();
    $db = new QueryModel();
    $id_user = $_SESSION['userdata']['id'];
    try {
        $register = $db->update('REG_COMMENTS', ["role"=>0],"id_exchange = ".$data['id_exchange']." AND id_user = ".$id_user);
        $register = $db->update('REG_COMMENTS', ["role"=>1],"id_exchange = ".$data['id_exchange']." AND id_user = ".$data['id_user']);
        echo json_encode($register);

    } catch (Exception $e) {
        echo json_encode('error: ' . $e->getMessage());
    }
}

function editExchange(){
    $data = getData();
    $db = new QueryModel();
    $id_user = $_SESSION['userdata']['id'];

    $insertData = [
        'name' => $data['name'],
        'about' => $data['about'],
        'rules' => $data['rules'],
        'type_gift' => $data['type_gift'],
        'min_price' => $data['min_price'],
        'max_price' => $data['max_price'],
        'event_date' => $data['event_date'],
        'timestamp_update'=>timestamp()
    ];

    if (isset($_FILES['img']) && $_FILES['img']['name']) {
        $uploadDirectory = '../../assets/img/exchanges/';
        $newFileName = "gr" . $id_user . datetime() . '.' . strtolower(pathinfo($_FILES['img']['name'], PATHINFO_EXTENSION));

        if (file_exists($uploadDirectory . $newFileName)) {
            unlink($uploadDirectory . $newFileName);
        }

        $existimg = $db->query('SELECT img FROM REG_EXCHANGES WHERE id = :id', [':id' => $data['id_exchange']])[0];

        if (file_exists('../../assets/img/exchanges/'.$existimg['img'])) {
            unlink('../../assets/img/exchanges/'.$existimg['img']);
        }

        $img = uploadFile($_FILES['img'], $uploadDirectory, $newFileName);
        $insertData['img'] = $newFileName;
    }

    $res = $db->update('REG_EXCHANGES', $insertData, 'id = ' . $data['id_exchange']);

    if($res){
        echo json_encode($res);
    }else{
        echo json_encode("Error");
    }
}

/*------------------------------------*/
function timestamp(){
    date_default_timezone_set('UTC');
    return date('Y-m-d H:i:s');
}

function datetime(){
    date_default_timezone_set('UTC');
    return date('YmdHis');
}


function generateShortCode($groupId) {
    $salt = 'STAR1PINKSUPER99';
    $input = $groupId . $salt . microtime(true);
    $hashCode = sha1($input);
    $shortCode = substr($hashCode, 0, 8);
    return $shortCode;
}

function uploadFile($file, $directory, $fileName) {
    $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    if ($file['error'] === UPLOAD_ERR_OK) {
        $fileExtension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if (in_array($fileExtension, $allowedExtensions)) {
            $destination = $directory . $fileName;
            if (move_uploaded_file($file['tmp_name'], $destination)) {
                return 1;
            } else {
                return 0;
            }
        } else {
            return 'The file is not a valid image. Only JPG, JPEG, PNG, and GIF are allowed.';
        }
    }
    return null;
}

function reducirTexto($texto, $longitudMaxima) {
    $texto = strip_tags($texto);
    if (strlen($texto) > $longitudMaxima) {
        $textoReducido = substr($texto, 0, $longitudMaxima) . "[...]";
    } else {
        $textoReducido = $texto;
    }

    return $textoReducido;
}