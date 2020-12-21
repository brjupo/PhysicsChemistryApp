<?php
require "01readAndWriteDDBB.php";


//Leer las variables del POST
$teacherMail = $_POST["teacherMail"];
$lowerTeacherMail = strtolower($teacherMail);

if (strpos($lowerTeacherMail, '@itesm.mx') === false) {
    $response["response"] = "¿Quieres obtener tu acceso a Kaanbal? <a href='https://kaanbal.net/contacto.html'>Contáctanos!</a>. Podemos ofrecer a su institución un periodo de prueba GRATUITO.";
} else {
    $getTeacherMail = new queryToDDBB("SELECT mail FROM usuario_prueba WHERE mail = '" . $teacherMail . "' ;");
    $gettedMail = $getTeacherMail->read();
    if ($teacherMail == $gettedMail) {
        $response["response"] = "El usuario ya existe.";
    } else if (strpos($gettedMail, "failed") !== false) {
        $response["response"] = "Ha ocurrido un error inesperado. Por favor intenta más tarde.";
    } else {
        //agregarProfesor a usuario_prueba con password correoCorreo
        $addTeacher = new queryToDDBB("INSERT INTO usuario_prueba (mail, pswd) VALUES ('" . $lowerTeacherMail . "', '" . $lowerTeacherMail . $lowerTeacherMail . "');");
        if ($addTeacher->write() != "success") {
            $response["response"] = "Error al escribir el nuevo usuario";
        } else {
            //obtener el ID del usuario
            $getTeacherID = new queryToDDBB("SELECT id_usuario FROM usuario_prueba WHERE mail= '" . $lowerTeacherMail . "';");
            $gettedTeacherID = $getTeacherID->read();
            if (!is_numeric($gettedTeacherID)) {
                $response["response"] = "Error en el ID del nuevo usuario.";
            } else {
                //agregar ID profesor a profesor
                $addTeacherInTeacher = new queryToDDBB("INSERT INTO profesor (id_usuario) VALUES (" . intval($gettedTeacherID) . ") ;");
                if ($addTeacherInTeacher->write() != "success") {
                    $response["response"] = "Error al escribir el profesor";
                } else {
                    //enviar correo
                    $response["response"] = "Te hemos enviado un correo desde <strong>licencias@kaanbal.net</strong> el cual indica el proceso a seguir. Por favor revisa tu carpeta de junk mail, spam o correo no deseado.";
                }
            }
        }
    }
}


////////////////
header('Content-Type: application/json');
echo json_encode($response);
