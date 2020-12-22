<?php

use PHPMailer\PHPMailer\PHPMailer;
require '../../vendor/autoload.php';
    
$destinatario = 'brjupo@gmail.com';
$asunto = 'Esta es una prueba de mail con función';
$cuerpo = 'htmlContraOlvidada.html';

function enviarMail($destinatario, $asunto, $cuerpo)
{
    
    $mail = new PHPMailer;
    $mail->isSMTP();
    $mail->IsHTML(true);
    $mail->SMTPDebug = 2;
    $mail->Host = 'smtp.hostinger.com';
    $mail->Port = 587;
    $mail->SMTPAuth = true;
    $mail->Username = 'licencias@kaanbal.net';
    $mail->Password = 'BraEduCri567';
    $mail->setFrom('licencias@kaanbal.net');
    $mail->addAddress($destinatario);
    $mail->Subject = $asunto;
    $mail->msgHTML(file_get_contents($cuerpo));
    //$mail->Body = 'This is a plain text message body';
    //$mail->addAttachment('test.txt');
    if (!$mail->send()) {
        echo 'Mailer Error: ' . $mail->ErrorInfo;
    } else {
        echo 'The email message was sent.';
    }
}


enviarMail($destinatario, $asunto, $cuerpo);

?>