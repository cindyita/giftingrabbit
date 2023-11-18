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
    case 'forgotPassword':
        forgotPassword();
    break;
    case 'recoverPass':
        recoverPass();
    break;
    /*--------------------*/
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
    case 'saveSettings':
        saveSettings();
    break;
    case 'deleteAccount':
        deleteAccount();
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
    case 'newWantGift':
        newWantGift();
    break;
    case 'deleteWantGift':
        deleteWantGift();
    break;
    case 'updateWantGift':
        updateWantGift();
    break;
    case 'newContact':
        newContact();
    break;
    case 'resultContact':
        resultContact();
    break;
    case 'makeRaffle':
        makeRaffle();
    break;
    case 'viewResultsRaffle':
        viewResultsRaffle();
    break;
    case 'sendResultsByEmail':
        sendResultsByEmail();
    break;
    case 'entranceLock':
        entranceLock();
    break;
    case 'entranceUnlock':
        entranceUnlock();
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
            
            $user = $db->query("SELECT u.*, r.name as rolname, r.status as rolstatus FROM SYS_USER u JOIN SYS_ROL r ON u.id_rol = r.id WHERE username = :username OR email = :username", [':username' => $username]);
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

    // Se ha comentado porque daba error con emails privados
    // list($user, $domain) = explode('@', $email);
    // if(!checkdnsrr($domain, 'MX')){
    //     echo 2;
    //     die();
    // }

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
                'name' => $data['name'],
                'password' => $pass,
                'timezone'=> $data['timezone'],
                'timestamp_create'=>date('Y-m-d H:i:s')
            ];

            $register = $db->insert('SYS_USER', $insertData);

            if($register){
                require_once("../resources/email.php");

                sendEmailSMTP('admin@giftingrabbit.theblux.com', 'Gifting Rabbit', $data['email'], $data['name'], "Gracias por tu registro en GiftingRabbit", "Ha habido un error", ["host" => HOST_EMAIL, "username" => CONTACT_EMAIL, "password" => PASSWORD_EMAIL, "port" => PORT_EMAIL], ['title' => 'Gracias por tu registro en GiftingRabbit', 'content' => $data['username'].', gracias por registrarte en la página, esperamos que la pases bien haciendo intercambios con tus seres queridos. Recuerda que aún estamos en fase de desarrollo y pruebas, así que, pásate de vez en cuando para ver las novedades de la página y si tienes algún problema con tu cuenta envíanos un correo electrónico.']);
            }
            echo json_encode($register);
            
        } else {
            echo 6;
        }


    } catch (Exception $e) {
        echo json_encode('error: '.$e->getMessage());
    }
}

function forgotPassword(){
    $data = getData();
    try {
        /*-ReCaptcha----------*/
        $recaptcha_url = 'https://www.google.com/recaptcha/api/siteverify'; 
        $recaptcha_secret = RECAPTCHA_SECRET; 
        $recaptcha_response = $data['g-recaptcha-response']; 
        $recaptcha = file_get_contents($recaptcha_url . '?secret=' . $recaptcha_secret . '&response=' . $recaptcha_response); 
        $recaptcha = json_decode($recaptcha); 

        if($recaptcha->success == true){

            $db = new QueryModel();
            $usernamemail = $data['usernamemail'];

            $account = $db->query("SELECT id,username,email 
                FROM SYS_USER 
                WHERE username = :usernamemail OR email = :usernamemail", [":usernamemail" => $usernamemail]);

            if (!empty($account)) {

                $token = bin2hex(random_bytes(32)) . md5($account[0]['email'].date("Y-m-d H:i:s"));
                $hashedToken = md5($token);

                $expFormat = mktime(date("H"), date("i"), date("s"), date("m") ,date("d")+1, date("Y"));
                
                $reg = $db->insert('REG_TOKENS', ['token' => $hashedToken,'id_user'=>$account[0]['id'],'timestamp_create'=>date('Y-m-d H:i:s'),'expiration_date'=>date("Y-m-d H:i:s",$expFormat)]);

                if($reg){
                    require_once("../resources/email.php");

                    $content = "<strong>Haz click aquí para recuperar tu contraseña:</strong><br>
                    <form method='get' action='".MAINURL."/recoverpass'>
                    <input type='hidden' name='token' value='".$token."'>
                    <button style='background-color: #fff5eb;border-radius: 1.5rem;padding: 10px 15px;border:2px solid #FF8211;z-index: 0;font-weight: 600;font-size: 14pt;color: #FF8211;transition: 0.3s ease;cursor: pointer;' type='submit'>Recuperar contraseña</button>
                    </form>";

                    $send = sendEmailSMTP('admin@giftingrabbit.theblux.com', 'Gifting Rabbit', $account[0]['email'], $account[0]['username'], "Recuperación de contraseña", "Ha habido un error", ["host" => HOST_EMAIL, "username" => CONTACT_EMAIL, "password" => PASSWORD_EMAIL, "port" => PORT_EMAIL], ['title' => 'Recuperar contraseña de la cuenta: ' . $account[0]['username'], 'content' => $content]);

                }

                echo json_encode($send);
            } else {
                echo 9;
            }

        } else {
            echo 6;
        }


    } catch (Exception $e) {
        echo json_encode('error: '.$e->getMessage());
    }
}

function recoverPass(){
    $data = getData();
    try {
        /*-ReCaptcha----------*/
        $recaptcha_url = 'https://www.google.com/recaptcha/api/siteverify'; 
        $recaptcha_secret = RECAPTCHA_SECRET; 
        $recaptcha_response = $data['g-recaptcha-response']; 
        $recaptcha = file_get_contents($recaptcha_url . '?secret=' . $recaptcha_secret . '&response=' . $recaptcha_response); 
        $recaptcha = json_decode($recaptcha); 

        if($recaptcha->success == true){

            $db = new QueryModel();
            $newpass = $data['pass'];
            $id_user = $data['id_user'];

            $reg = $db->update('SYS_USER', ['password' => md5($newpass)],"id = ". $id_user);
            $del = $db->query("DELETE FROM REG_TOKENS WHERE token = :token", [":token"=>md5($data['token'])]);

            echo json_encode($reg);

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
    echo json_encode($_FILES['img-profile']['name']);
    // Update data
    $updateData = [
        'biography' => $data['biography']
    ];

    if ($data['name']) {
        $updateData['name'] = $data['name'];
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

function saveSettings(){
    $data = getData();
    $db = new QueryModel();

    if ($data['email']) {
        $updateData['email'] = $data['email'];
    }

    if ($data['pass']) {
        $updateData['password'] = md5($data['pass']);
    }

    try {
        $register = $db->update('SYS_USER', $updateData, 'id =' . $_SESSION['userdata']['id']);
        echo json_encode($register);
    } catch (Exception $e) {
        echo json_encode('error: ' . $e->getMessage());
    }
}

function deleteAccount(){
    $data = getData();

    /*-ReCaptcha----------*/
    $recaptcha_url = 'https://www.google.com/recaptcha/api/siteverify'; 
    $recaptcha_secret = RECAPTCHA_SECRET; 
    $recaptcha_response = $data['g-recaptcha-response']; 
    $recaptcha = file_get_contents($recaptcha_url . '?secret=' . $recaptcha_secret . '&response=' . $recaptcha_response); 
    $recaptcha = json_decode($recaptcha);

    if ($recaptcha->success == true) {

        $db = new QueryModel();

        $id_user = $_SESSION['userdata']['id'];

        $query = $db->query('SELECT role FROM REL_USER_EXCHANGE WHERE id_user = :id_user AND role = 1', [':id_user'=>$id_user]);

        if(!$query){

            $delete = $db->query('DELETE FROM REG_COMMENTS WHERE id_user = :id_user', [':id_user'=>$id_user]);
            $delete = $db->query('DELETE FROM REG_TOKENS WHERE id_user = :id_user', [':id_user'=>$id_user]);
            $delete = $db->query('DELETE FROM REG_WISHGIFTS WHERE id_user = :id_user', [':id_user'=>$id_user]);
            $delete = $db->query('DELETE FROM REL_USER_EXCHANGE WHERE id_user = :id_user', [':id_user'=>$id_user]);
            $delete = $db->query('DELETE FROM SYS_USER WHERE id = :id_user', [':id_user'=>$id_user]);

            echo json_encode($delete);
            
        }else{
            echo 10;
        }

    }else{
        echo 6;
    }
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
        'main_question' => $data['main_question'],
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

    $query = $db->query('SELECT id,drawn_on,entrance_lock FROM REG_EXCHANGES WHERE code = :code', ['code' =>$data['code']]);
    if($query){
        if(!$query[0]['drawn_on']){

            if (!$query[0]['entrance_lock']) {
                $reg = $db->select('REL_USER_EXCHANGE', 'id_exchange = ' . $query[0]['id'] . ' AND id_user = ' . $id_user);
                if (!$reg) {
                    $res = $db->insert('REL_USER_EXCHANGE', ['id_exchange' => $query[0]['id'], 'id_user' => $id_user, 'role' => 0]);
                    echo json_encode($res);
                } else {
                    echo 4;
                }
            }else{
                echo 11;
            }

        }else{
            echo 9;
        }
        
        
    }else{
        echo 3;
    }
    
}

function updateFeedExchanges(){
    $db = new QueryModel();
    $exchanges_user = $db->query("SELECT e.*,r.* FROM REL_USER_EXCHANGE r JOIN VIEW_EXCHANGES e ON r.id_exchange = e.id WHERE r.id_user = :id_user",[":id_user"=>$_SESSION['userdata']['id']]);
    $html = "";
    foreach ($exchanges_user as $value) {
        $crown = '';
        $drawn = '';
        $event_past = '';
        if ($value['role'] == 1) {
            $crown = ' <span class="text-warning"><i class="fa-solid fa-crown"></i></span>';
        }

        if ($value['drawn_on']) {
            $drawn = " <span class='text-info'>[Ya sorteado]</span>";
        }

        if (strtotime($value['event_date']) < strtotime(date('Y-m-d'))) {
            $event_past = " <span class='text-danger'>[El evento ya pasó]</span>";
        }


        $html .= '<div class="green-card">
            <div class="head">
                <div class="img">
                    <a href="exchange?id='.$value['id'].'">
                        <img src="./assets/img/exchanges/'.$value['img'].'" alt="img intercambio" onerror="this.src = \'./assets/img/system/defaultimg.webp\'">
                    </a>
                </div>
                <div class="info">
                    <strong><a href="exchange?id='.$value['id'].'">'.$value['name'].$crown.$drawn.'</a></strong>
                    <span>Código: '.$value['code'].'</span>
                    <span class="d-flex gap-2"><span>Usuarios: '.$value['num_members'].'</span><span>Contactos: '.$value['num_contacts'].'</span></span>
                    <span>Fecha del evento: <span class="dateFormat">'.$value['event_date'].'</span>'.$event_past.'</span>
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

    $query = $db->query('SELECT img FROM REG_EXCHANGES WHERE id = :id', [':id'=>$data['id']]);
    if($query[0]['img']){
        $filePath = '../../assets/img/exchanges/'.$query[0]['img'];
        deleteFile($filePath);
    }

    $query = $db->delete('REL_RESULT_RAFFLE', 'id_exchange = '.$data['id']);
    $query = $db->delete('REG_WISHGIFTS', 'id_exchange = '.$data['id']);
    $query = $db->delete('REL_USER_EXCHANGE', 'id_exchange = '.$data['id']);
    $query = $db->delete('REG_CONTACTS', 'id_exchange = '.$data['id']);
    $query = $db->delete('REG_COMMENTS', 'id_exchange = '.$data['id']);
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
                                <a href="user?id='.$value['id_user'].'"><img src="./assets/img/'.($value['img_profile'] ? 'user/img-profile/'.$value['img_profile'] : 'system/defaultprofile.webp').'" alt="image profile" onerror="this.src = \'./assets/img/system/defaultimgsq.webp\'"></a>
                            </div>
                        </div>
                        <div class="d-flex flex-column w-100">
                            <div class="d-flex justify-content-between">
                                <span class="user-name d-flex gap-1 flex-column flex-md-row">
                                    <a href="user?id='.$value['id_user'].'">'.$value['username'];
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
        $register = $db->update('REL_USER_EXCHANGE', ["role"=>0],"id_exchange = ".$data['id_exchange']." AND id_user = ".$id_user);
        $register = $db->update('REL_USER_EXCHANGE', ["role"=>1],"id_exchange = ".$data['id_exchange']." AND id_user = ".$data['id_user']);
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

    if(isset($data['main_question'])){
        $insertData['main_question'] = $data['main_question'];
    }

    // 'admin_participates' => $data['admin_participates'],
    //     'admin_view_raffle' => $data['admin_view_raffle'],

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

function newWantGift(){
    $data = getData();
    $db = new QueryModel();
    $id_user = $_SESSION['userdata']['id'];

    $insertData = [
        'id_exchange' => $data['id_exchange'],
        'id_user' => $id_user,
        'comment' => $data['comment'],
        'timestamp_create'=>timestamp()
    ];

    $res = $db->select('REG_WISHGIFTS', 'id_exchange = '. $data['id_exchange'].' AND id_user = '.$id_user);
    if ($res) {
        $res = $db->update('REG_WISHGIFTS', $insertData,'id = '.$res[0]['id']);
    }else{
        $res = $db->insert('REG_WISHGIFTS', $insertData);
    }

    echo json_encode($res);
}

function deleteWantGift(){
    $data = getData();
    $id_comm = $data['id_comm'];
    $id_user = $_SESSION['userdata']['id'];
    if (isset($_SESSION['status_login'])) {

            $db = new QueryModel();
            try {
                $register = $db->select('REG_WISHGIFTS', 'id = ' . $id_comm);
                if(isset($register) && $register[0]['id_user'] == $id_user){
                    $register = $db->delete('REG_WISHGIFTS', 'id = ' . $id_comm);
                    echo json_encode($register);
                }else{
                    echo json_encode('Acción no permitida');
                }

            } catch (Exception $e) {
                echo json_encode('error: ' . $e->getMessage());
            }

    }else{
        echo 5;
    }
}

function updateWantGift(){
    $data = getData();
    $db = new QueryModel();
    $id_user = $_SESSION['userdata']['id'];
    $id = $data['id_exchange'];
    if (isset($_SESSION['status_login'])) {
        $wantGiftYou = $db->query("SELECT w.*,u.username,u.img_profile FROM REG_WISHGIFTS w LEFT JOIN SYS_USER u ON w.id_user = u.id WHERE w.id_user = :id_user AND w.id_exchange = :id",[":id_user"=>$id_user,":id"=>$id]);

        $html = "";

        if ($wantGiftYou) {
                $html .= '<div class="w-100">
                    <div class="d-flex gap-2">
                        <div>
                            <div class="img-user">
                                <a href="user?id='.$wantGiftYou[0]['id_user'].'"><img src="./assets/img/'.($wantGiftYou[0]['img_profile'] ? 'user/img-profile/' . $wantGiftYou[0]['img_profile'] : 'system/defaultimgsq.webp').'" alt="image profile" onerror="this.src = \'./assets/img/system/defaultimgsq.webp\'"></a>
                            </div>
                        </div>
                        <div class="d-flex flex-column w-100">
                            <div class="d-flex justify-content-between">
                                <span class="user-name d-flex gap-1 flex-column flex-md-row">
                                    <a href="user?id=1">'.$wantGiftYou[0]['username'].'</a> <span class="ms-0 ms-md-2 text-secondary relativedate">'.$wantGiftYou[0]['timestamp_create'].'</span>
                                </span>
                                <span>
                                    <a class="text-danger cursor-pointer" data-bs-toggle="modal" data-bs-target="#confirmDeleteWantGift" onclick="deleteWantGift('.$wantGiftYou[0]['id'].')"><i class="fa-solid fa-trash"></i></a>
                                </span>
                            </div>
                            <span class="py-2 p-md-2">'.$wantGiftYou[0]['comment'].'</span>
                        </div>
                    </div>
                </div>';
        }else{
                $html .= '<p>Aún no has agregado ninguna respuesta</p>';
        }
        echo json_encode($html);
    }
}

function newContact(){
    $data = getData();
    $db = new QueryModel();
    $id_user = $_SESSION['userdata']['id'];

    $insertData = [
        'name' => $data['name'],
        'email' => $data['email'],
        'note' => $data['note'],
        'wantgift' => $data['wantgift'],
        'id_exchange'=> $data['id_exchange'],
        'id_user' => $id_user,
        'timestamp_create'=>timestamp()
    ];

    $res = $db->insert('REG_CONTACTS', $insertData);

    echo json_encode($res);
}

function resultContact(){
    $data = getData();
    $db = new QueryModel();
    $id = $data['id'];
    $id_exchange = $data['id_exchange'];

    $res = $db->query('SELECT r.type_result,
        CASE 
            WHEN r.type_result = "USER" THEN u.username
            WHEN r.type_result = "CONTACT" THEN c.name
        END AS result_name,
        CASE 
            WHEN r.type_result = "USER" THEN NULL
            WHEN r.type_result = "CONTACT" THEN c.note
        END AS result_note,
        CASE 
            WHEN r.type_result = "USER" THEN w.comment
            WHEN r.type_result = "CONTACT" THEN c.wantgift
        END AS result_comment
     FROM REL_RESULT_RAFFLE r 
     LEFT JOIN SYS_USER u ON r.id_result = u.id AND r.type_result = "USER" 
     LEFT JOIN REG_CONTACTS c ON r.id_result = c.id AND r.type_result = "CONTACT" 
     LEFT JOIN REG_WISHGIFTS w ON r.id_result = w.id_user AND r.type_result = "USER" AND w.id_exchange = :id_exchange
     WHERE r.id_user = :id AND r.type_user = "CONTACT" AND r.id_exchange = :id_exchange',[':id'=>$id,':id_exchange'=> $id_exchange]);

    echo json_encode($res);
}

function deleteContact(){
    $data = getData();
    $id_contact = $data['id_contact'];
    if (isset($_SESSION['status_login'])) {

            $db = new QueryModel();
            try {
                $register = $db->delete('REG_CONTACTS', 'id = ' . $id_contact);
                echo json_encode($register);

            } catch (Exception $e) {
                echo json_encode('error: ' . $e->getMessage());
            }

    }else{
        echo 5;
    }
}

function makeRaffle(){
    $data = getData();
    
    if (isset($_SESSION['status_login'])) {

        $id_user = $_SESSION['userdata']['id'];
        $id_exchange = $data['id_exchange'];
        $db = new QueryModel();
        $access = $db->query("SELECT role FROM REL_USER_EXCHANGE WHERE id_exchange = :id_exchange AND id_user = :id_user",[":id_exchange"=>$id_exchange,":id_user"=>$id_user]);

        if ($access[0]['role'] == 1) {

            $exchange = $db->select('REG_EXCHANGES', 'id = ' . $id_exchange);
            $admin_participates = $exchange[0]['admin_participates'];

            if ($admin_participates == 1) {
                $users = $db->query('SELECT id_user AS id,"USER" AS type FROM REL_USER_EXCHANGE WHERE id_exchange = :id_exchange', [':id_exchange' => $id_exchange]);
            } else {
                $users = $db->query('SELECT id_user AS id,"USER" AS type FROM REL_USER_EXCHANGE WHERE id_exchange = :id_exchange AND role = 0', [':id_exchange' => $id_exchange]);
            }

            $contacts = $db->query('SELECT id,"CONTACT" AS type FROM REG_CONTACTS WHERE id_exchange = :id_exchange', [':id_exchange' => $id_exchange]);

            if ($contacts) {
                $participantes = array_merge($users, $contacts);
            } else {
                $participantes = $users;
            }

            if (count($participantes) > 2) {

                $resultRaffle = doRaffle($participantes);

                try {
                    foreach ($resultRaffle as $key => $value) {
                        $insertData = [
                            'id_exchange'=> $id_exchange,
                            'id_user' => $value['id'],
                            'type_user' => $value['type'],
                            'id_result' => $value['result'],
                            'type_result' => $value['result_type'],
                            'timestamp_create' => timestamp()
                        ];

                        $db->insert('REL_RESULT_RAFFLE', $insertData);
                    }

                    $update = $db->update('REG_EXCHANGES', ['drawn_on' => timestamp()], 'id = ' . $id_exchange);

                    echo json_encode($update);

                } catch (Exception $e) {
                    echo json_encode('error: ' . $e->getMessage());
                }

            } else {
                echo 7;
            }
        }else{
            echo 6;
        }

    }else{
        echo 5;
    }
}

function viewResultsRaffle(){
    $data = getData();
    $id_exchange = $data['id_exchange'];
    $db = new QueryModel();
    $resultRaffle = $db->query("SELECT r.id_user,r.id_result,r.type_user,r.type_result,
                                CASE 
                                    WHEN r.type_user = 'USER' THEN us.username
                                    WHEN r.type_user = 'CONTACT' THEN co.name
                                END AS user_name,
                                CASE 
                                    WHEN r.type_result = 'USER' THEN u.username
                                    WHEN r.type_result = 'CONTACT' THEN c.name
                                END AS result_name
                                FROM REL_RESULT_RAFFLE r
                                LEFT JOIN SYS_USER u ON r.id_result = u.id AND r.type_result = 'USER'
                                LEFT JOIN REG_CONTACTS c ON r.id_result = c.id AND r.type_result = 'CONTACT'
                                LEFT JOIN SYS_USER us ON r.id_user = us.id AND r.type_user = 'USER'
                                LEFT JOIN REG_CONTACTS co ON r.id_user = co.id AND r.type_user = 'CONTACT'
                                WHERE r.id_exchange = :id_exchange
                                ",[':id_exchange'=>$id_exchange]);
    echo json_encode($resultRaffle);

}

function sendResultsByEmail(){
    $data = getData();
    $id_exchange = $data['id_exchange'];
    $db = new QueryModel();

    $id_user = $_SESSION['userdata']['id'];
    $access = $db->query("SELECT role FROM REL_USER_EXCHANGE WHERE id_exchange = :id AND id_user = :id_user",[":id"=>$id_exchange,":id_user"=>$id_user]);

    if ($access[0]['role'] == 1) {
        try {
            $exchange = $db->query('SELECT name,main_question FROM REG_EXCHANGES WHERE id = :id_exchange', [':id_exchange' => $id_exchange]);

            $dataRaffle = $db->query("SELECT r.id_result,r.type_result,
                                            CASE 
                                                WHEN r.type_result = 'USER' THEN u.username
                                                WHEN r.type_result = 'CONTACT' THEN c.name
                                            END AS result_name,
                                            CASE 
                                                WHEN r.type_result = 'USER' THEN NULL
                                                WHEN r.type_result = 'CONTACT' THEN c.note
                                            END AS result_note,
                                            CASE 
                                                WHEN r.type_result = 'USER' THEN w.comment
                                                WHEN r.type_result = 'CONTACT' THEN c.wantgift
                                            END AS result_comment,
                                            CASE 
                                                WHEN r.type_user = 'USER' THEN us.email
                                                WHEN r.type_user = 'CONTACT' THEN cs.email
                                            END AS user_email,
                                            CASE 
                                                WHEN r.type_user = 'USER' THEN us.username
                                                WHEN r.type_user = 'CONTACT' THEN cs.name
                                            END AS user_name
                                        FROM REL_RESULT_RAFFLE r
                                        LEFT JOIN SYS_USER u ON r.id_result = u.id AND r.type_result = 'USER'
                                        LEFT JOIN SYS_USER us ON r.id_user = us.id AND r.type_user = 'USER'
                                        LEFT JOIN REG_CONTACTS c ON r.id_result = c.id AND r.type_result = 'CONTACT'
                                        LEFT JOIN REG_CONTACTS cs ON r.id_user = cs.id AND r.type_user = 'CONTACT'
                                        LEFT JOIN REG_WISHGIFTS w ON r.id_result = w.id_user AND r.type_result = 'USER' AND w.id_exchange = :id_exchange
                                        WHERE r.id_exchange = :id_exchange
                                        ", [':id_exchange'=>$id_exchange]);        

            require_once("../resources/email.php");
            foreach ($dataRaffle as $value) {
                $content = "<strong>Te ha tocado regalar a:</strong> " . $value['result_name'] . '<br> <strong>y su respuesta a "' . $exchange[0]['main_question'] . '"<br>fue:</strong> ' . $value['result_comment'] . '<br><br><strong>Notas:</strong> ' . $value['result_note'];

                if ($value['user_email']) {
                    $sendemail = sendEmailSMTP('admin@giftingrabbit.theblux.com', 'Gifting Rabbit', $value['user_email'], $value['user_name'], "Resultados del intercambio: " . $exchange[0]['name'], "Ha habido un error", ["host" => HOST_EMAIL, "username" => CONTACT_EMAIL, "password" => PASSWORD_EMAIL, "port" => PORT_EMAIL], ['title' => 'Resultados del intercambio: ' . $exchange[0]['name'], 'content' => $content]);
                }
            }
            

            $update = $db->update('REG_EXCHANGES', ['send_emails' => timestamp()], 'id = ' . $id_exchange);

            if($update){
                echo 1;
            }else{
                echo 0;
            }

        } catch (Exception $e) {
            echo json_encode("Error: " . $e->getMessage());
        }
    }else{
        echo 6;
    }
    
}

function entranceLock(){
    $data = getData();
    $id_exchange = $data['id_exchange'];
    $db = new QueryModel();

    if (isset($_SESSION['status_login'])) {

        $id_user = $_SESSION['userdata']['id'];
        $access = $db->query("SELECT role FROM REL_USER_EXCHANGE WHERE id_exchange = :id AND id_user = :id_user",[":id"=>$id_exchange,":id_user"=>$id_user]);

        if ($access[0]['role'] == 1) {
            try {
                $update = $db->update('REG_EXCHANGES', ['entrance_lock' => 1], 'id = ' . $id_exchange);
                echo $update;

            } catch (Exception $e) {
                echo json_encode("Error: " . $e->getMessage());
            }
        }else{
            echo 6;
        }

    }else{
        echo 5;
    }
}

function entranceUnlock(){
    $data = getData();
    $id_exchange = $data['id_exchange'];
    $db = new QueryModel();

    $id_user = $_SESSION['userdata']['id'];
    $access = $db->query("SELECT role FROM REL_USER_EXCHANGE WHERE id_exchange = :id AND id_user = :id_user",[":id"=>$id_exchange,":id_user"=>$id_user]);

    if ($access[0]['role'] == 1) {
        try {
            $update = $db->update('REG_EXCHANGES', ['entrance_lock' => 0], 'id = ' . $id_exchange);
            echo $update;

        } catch (Exception $e) {
            echo json_encode("Error: " . $e->getMessage());
        }
    }else{
        echo 6;
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

function deleteFile($filePath) {
    if (file_exists($filePath)) {
        if (unlink($filePath)) {
            return true;
        } else {
            return 'Error eliminando la imagen';
        }
    }
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


function doRaffle($users){
    $randomKeys = array_keys($users);
    shuffle($randomKeys);
    $resultRaffle = $users;

    foreach ($users as $key => $value) {

        while ($randomKeys[$key] == $key) {
            shuffle($randomKeys);
        }

        if(isset($resultRaffle[$randomKeys[$key]])){
            $resultRaffle[$key]['result'] = $resultRaffle[$randomKeys[$key]]['id'];
            $resultRaffle[$key]['result_type'] = $resultRaffle[$randomKeys[$key]]['type'];
            $randomKeys[$key] = null;
        }else{
            return doRaffle($users);
        }

    }
    
    return $resultRaffle;
}



