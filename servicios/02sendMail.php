<?php

use PHPMailer\PHPMailer\PHPMailer;

require '../../vendor/autoload.php';

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
    //$mail->msgHTML(file_get_contents($cuerpo));

    // Para enviar un correo HTML, debe establecerse la cabecera Content-type
    //$headers  = 'MIME-Version: 1.0' . "\r\n";
    //$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
    //$MIMEHeader : string
    //$mail->MIMEHeader='1.0';
    //$CharSet : string
    //$mail->Charset = 'utf-8';
    //$ContentType : string
    //$mail->ContentType = 'text/html';
    $mail->addCustomHeader('MIME-Version', '1.0');
    $mail->addCustomHeader('Content-Type: text/html; charset=utf-8');

    $mail->Body = $cuerpo;
    //$mail->addAttachment('test.txt');
    if (!$mail->send()) {
        return 'failed: ' . $mail->ErrorInfo;
    } else {
        return 'The email message was sent.';
    }
}
