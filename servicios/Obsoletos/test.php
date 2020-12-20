<?php
require "../01readAndWriteDDBB.php";


//Leer las variables del POST
$teacherMail = $_POST["teacherMail"];
$lowerTeacherMail = strtolower($teacherMail);

if (strpos($lowerTeacherMail, '@tec.mx') === false) {
    $response["response"] = "¿Quieres obtener tu acceso a Kaanbal? <a href='https://kaanbal.net/contacto.html'>Contáctanos!</a>. Podemos ofrecer a su institución un periodo de prueba GRATUITO.";
} else {
    $getTeacherMail = new queryToDDBB("SELECT mail FROM usuario_prueba WHERE mail = '" . $teacherMail . "' ;");
    $gettedMail = $getTeacherMail->read();
    if ($teacherMail == $gettedMail) {
        $response["response"] = "El usuario ya existe.";
    } else if (strpos($gettedMail, "failed") !== false) {
        $response["response"] = "Ha ocurrido un error inesperado. Por favor intenta más tarde.";
    } else {
        //enviar correo
        $response["response"] = "Te hemos enviado un correo desde <strong>licencias@kaanbal.net</strong> el cual indica el proceso a seguir. Por favor revisa tu carpeta de junk mail, spam o correo no deseado.";
    }
}


////////////////
header('Content-Type: application/json');
echo json_encode($response);
