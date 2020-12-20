<?php

//Leer las variables del POST
$teacherMail = $_POST['teacherMail'];
$lowerTeacherMail = strtolower($teacherMail);

if (strpos($lowerTeacherMail, '@tec.mx') === false) {
    $response["response"] = "¿Quieres obtener tu acceso a Kaanbal? <a href='https://kaanbal.net/contacto.html'>Contáctanos!</a>. Podemos ofrecer a su institución un periodo de prueba GRATUITO.";
} else {
    $teacherMail = new queryToDDBB("SELECT mail FROM usuario_prueba WHERE mail = " . $teacherMail . " ;");
    if (
        $teacherMail ==
        $teacherMail->read()
    ) {
        $response["response"] = "El usuario ya existe.";
    } else if (strpos($teacherMail->read(), "failed") !== false) {
        $response["response"] = "Ha ocurrido un error inesperado. Por favor intenta más tarde.";
    } else {
        //enviar correo
        $response["response"] = "Te hemos enviado un correo desde <strong>licencias@kaanbal.net</strong> el cual indica el proceso a seguir. Por favor revisa tu carpeta de junk mail, spam o correo no deseado.";
    }
}


////////////////
header('Content-Type: application/json');
echo json_encode($response);
