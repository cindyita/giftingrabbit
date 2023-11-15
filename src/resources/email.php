<?php 

require '../../vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

/**
 * The function `sendEmailSMTP` sends an email using SMTP with the provided sender, recipient, subject,
 * body, and configuration parameters.
 * 
 * @param $sender The email address of the sender.
 * @param $senderName The name of the sender of the email.
 * @param $recipient The recipient parameter is the email address of the person who will receive the
 * email.
 * @param $recipientName The recipient's name.
 * @param $subject The subject of the email that will be sent.
 * @param $body The `` parameter is the content of the email that will be sent. It can be plain
 * text or HTML code. In the provided code, if a `` array is passed as an argument, the
 * `` variable will be overwritten with HTML code generated from the template array. Otherwise
 * @param $config The `` parameter is an array that contains the configuration settings for the
 * SMTP server. It includes the following keys:
 * @param $template The "template" parameter is an optional array that contains the title and content of
 * the email template. If provided, the function will use this template to generate the email body. If
 * not provided, the function will use the "body" parameter as the email body directly.
 */
function sendEmailSMTP($sender, $senderName, $recipient, $recipientName, $subject, $body, $config,$template = []) {

    $mail = new PHPMailer(true);
    try {

        if($template != []){
            $body = '<div>
                <table width="100%" height="auto" cellpadding="0" cellspacing="0" style="background-color:white; border:3px solid #FF8211;">
                <tr>
                    <td width="100%" height="auto" style="background:#CFEEDE;">
                        <h2 style="text-align:center;padding:48px 10px;color:#FF8211; font-size:25px;  font-weight:600; margin:0;">'.$template['title'].'</h2>
                    </td>
                </tr>
                <tr>
                    <td width="100%" style="color:#FF8211; font-size:15px; text-align:left; padding:40px 30px;">
                        <p style="color:#FF8211;">'.$template['content'].'</p>
                    </td>
                </tr>
                <tr>
                    <td width="100%" style="padding:48px 10px; background-color:#CFEEDE; font-family:Arial; font-size:12px; line-height:125%; text-align:center;">
                        <a href="'.MAINURL.'" style="text-decoration:none;"><p style="color:#FF8211">Ir a Gifting Rabbit</p></a>
                    </td>
                </tr>
                </table>
            </div>';
        }
        

        $mail->isSMTP();
        $mail->Host       = $config['host'];
        $mail->SMTPAuth   = true;
        $mail->Username   = $config['username'];
        $mail->Password   = $config['password'];
        $mail->SMTPSecure = 'ssl';
        $mail->Port       = $config['port'];

        $mail->setFrom($sender, $senderName);
        $mail->addAddress($recipient, $recipientName);

        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';
        $mail->Subject = $subject;
        $mail->Body    = $body;

        if($mail->send()){
            return 1;
        }else{
            return "email failed";
        }
        
    } catch (Exception $e) {
        return "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

?>