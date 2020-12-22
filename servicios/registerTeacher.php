<?php
require "01readAndWriteDDBB.php";
require "02sendMail.php";


//Leer las variables del POST
$teacherMail = $_POST["teacherMail"];
$lowerTeacherMail = strtolower($teacherMail);

//Si contiene "palabra". ES IDENTICO A PREGUNTAR
//if (strpos($variable, 'palabra') !== false)


$response["response"] = "No quedamos en la línea 14a";
//if (strpos($lowerTeacherMail, '@itesm.mx') === false) {
if (false) {
    $response["response"] = "¿Quieres obtener tu acceso a Kaanbal? <a href='https://kaanbal.net/contacto.html'>Contáctanos!</a>. Podemos ofrecer a su institución un periodo de prueba GRATUITO.";
} else {
    $getTeacherMail = new queryToDDBB("SELECT mail FROM usuario_prueba WHERE mail = '" . $lowerTeacherMail . "' ;");
    $gettedMail = $getTeacherMail->read();
    $response["response"] = "No quedamos en la línea 20";
    if ($lowerTeacherMail == $gettedMail) {
        $response["response"] = "El usuario ya existe.";
    } else if (strpos($gettedMail, "failed") !== false) {
        $response["response"] = "Ha ocurrido un error inesperado. Por favor intenta más tarde.";
    } else {
        $response["response"] = "No quedamos en la línea 26";
        //enviar correo
        //function enviarMail($destinatario, $asunto, $cuerpo)
        $respuestaAlEnviarElMail =  enviarMail($lowerTeacherMail, "Registro profesor. Kaanbal", cuerpoCorreoNuevoProfesor());
        if (strpos($respuestaAlEnviarElMail, "failed") !== false) {
            $response["response"] = "Ha ocurrido un error al enviar el correo. Detalle: " . $respuestaAlEnviarElMail;
        } else {
            $response["response"] = "No quedamos en la línea 33";
            //agregarProfesor a usuario_prueba con password correoCorreo
            $addTeacher = new queryToDDBB("INSERT INTO usuario_prueba (mail, pswd) VALUES ('" . $lowerTeacherMail . "', '" . $lowerTeacherMail . $lowerTeacherMail . "');");
            if ($addTeacher->write() != "success") {
                $response["response"] = "Error al escribir el nuevo usuario";
            } else {
                $response["response"] = "No quedamos en la línea 39";
                //obtener el ID del usuario
                $getTeacherID = new queryToDDBB("SELECT id_usuario FROM usuario_prueba WHERE mail= '" . $lowerTeacherMail . "';");
                $gettedTeacherID = $getTeacherID->read();
                if (!is_numeric($gettedTeacherID)) {
                    $response["response"] = "Error en el ID del nuevo usuario.";
                } else {
                    $response["response"] = "No quedamos en la línea 47";
                    //agregar ID profesor a profesor
                    $addTeacherInTeacher = new queryToDDBB("INSERT INTO profesor (id_usuario) VALUES (" . intval($gettedTeacherID) . ") ;");
                    $addedTeacherInTeacher = $addTeacherInTeacher->write();
                    if ($addedTeacherInTeacher != "success") {
                        $response["response"] = "Error al escribir el profesor";
                    } else {
                        $response["response"] = "Te hemos enviado un correo desde <strong>licencias@kaanbal.net</strong> el cual indica el proceso a seguir. Por favor revisa tu carpeta de junk mail, spam o correo no deseado.";
                    }
                }
            }
        }
    }
}


////////////////
header('Content-Type: application/json');
echo json_encode($response);


function cuerpoCorreoNuevoProfesor()
{
    return '
<html>
  <meta charset="utf-8" />
  <body>
    <style>
      @font-face {
        font-family: "Monse";
        src: url("https://www.kaanbal.net/dev/Front/CSSsJSs/Fonts/montserrat/Montserrat-Regular.otf")
          format("opentype");
      }
      @font-face {
        font-family: "ubuntu";
        src: url("kaanbal.net/dev/Front/CSSsJSs/Fonts/ubuntu/ubuntu.ttf")
          format("truetype");
      }
      body {
        font-family: "Monse";
      }
    </style>
    <div style="background-color: rgb(35, 85, 145)" height="30px">
      <h4
        style="
          color: rgb(250, 250, 250);
          font-family: "ubuntu";
          font-size: xx-large;
          margin: 20px auto 20px 10px;
          padding: 20px 10px 20px 10px;
        "
      >
        Kaanbal
      </h4>
    </div>

    <h3>¡Bienvenida(o) a Kaanbal!</h3>
    <h4>
      Has hecho una excelente decisión al utilzar la
      <strong>Plataforma educativa Kaanbal</strong>
    </h4>
    <p>
      Ahora tus alumnos podrán practicar, reforzar y consolidar los conceptos vistos en
      clase de forma interactiva y lúdica
    </p>
    <p>Tu <strong>usuario</strong> es el correo:</p>
    <p>mail</p>
    <p>En la siguiente URL podrás crear tu <strong>contraseña</strong></p>
    <a href="">
      <p>link</p>
    </a>
    <p>
      Recuerda esta liga es instransferible y de un solo uso. No la compartas.
    </p>
    <p style="color: white">.</p>
    <p>
      Pasos a seguir:
    </p>
    <p>1.- Usando el link previo, crea tu contraseña e ingresa a <a href="https://kaanbal.net"> Kaanbal </a> con tu correo y contraseña</p>
    <p>2.- Da clic en la sección "Crear grupos".</p>
    <p>3.- Comparte con tus alumnos el código de grupo.</p>
    <p>Listo! en cuanto tus alumnos se registren podrás observar su avance en la sección de "Reportes"</p>
    <p style="color: white">.</p>
    <p>En caso de cualquier duda o comentario por favor envía un mensaje a</p>
    <img
      src="kaanbal.net/IMAGENES/email.svg"
      height="40px"
      style="display: block"
    />
    <p><a href="aclaraciones@kaanbal.net">aclaraciones@kaanbal.net</a></p>

    <img
      src="https://www.kaanbal.net/IMAGENES/whatsapp.svg"
      height="40px"
      style="display: block"
    />
    <p><strong>55 4871 4593</strong>.</p>
    <p style="color: white">.</p>
    <p>Agradecemos tu confianza,</p>
    <p>
      <strong>Equipo de Plataforma Educativa Kaanbal</strong> un producto de
      VEKS Solutions México S.A. de C.V.
    </p>
    <h4 style="background-color: rgb(35, 85, 145); color: rgb(35, 85, 145)">
      .
    </h4>
  </body>
</html>

    ';
}
