<?php

$destinatario = 'cmendez222@gmail.com';
$asunto = 'Este es un mail de prueba';

    use PHPMailer\PHPMailer\PHPMailer;
    require '../../vendor/autoload.php';
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
    $mail->msgHTML(file_get_contents('htmlContraOlvidada.html'));
    //$mail->Body = 'This is a plain text message body';
    //$mail->addAttachment('test.txt');
    if (!$mail->send()) {
        echo 'Mailer Error: ' . $mail->ErrorInfo;
    } else {
        echo 'The email message was sent.';
    }

?>