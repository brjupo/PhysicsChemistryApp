<?php
require "01readAndWriteDDBB.php";
require "02sendMail.php";


//Leer las variables del POST
$guestMail = $_POST["guestMail"];
$lowerguestMail = strtolower($guestMail);


$getguestMail = new queryToDDBB("SELECT mail FROM usuario_prueba WHERE mail = '" . $lowerguestMail . "' ;");
$gettedMail = $getguestMail->read();
if ($lowerguestMail == $gettedMail) {
  $respuesta["response"] = "El usuario ya existe. Si existe algún problema, con gusto te ayudamos, envianos un correo a <strong>aclaraciones@kaanbal.net</strong>";
} else if (strpos($gettedMail, "failed") !== false) {
  $respuesta["response"] = "Ha ocurrido un error inesperado. Por favor intenta más tarde.";
} else {
  //agregarInvitado a usuario_prueba con password correoCorreo
  $tempPas = MD5($lowerguestMail . $lowerguestMail);
  $addGuest = new queryToDDBB("INSERT INTO usuario_prueba (mail, pass_cifrado) VALUES ('" . $lowerguestMail . "', '" . $tempPas . "');");
  if ($addGuest->write() != "success") {
    $respuesta["response"] = "Error al escribir el nuevo usuario";
  } else {
    //crear token
    $token = crearTokenDDBB($lowerguestMail);
    if ($token == "error") {
      $respuesta["response"] = "Ha ocurrido un error al crear token ";
    } else {
      //enviar correo
      $respuestaAlEnviarElMail =  enviarMail($lowerguestMail, "Registro invitado. Kaanbal", cuerpoCorreoNuevoInvitado($lowerguestMail, $token));
      if (strpos($respuestaAlEnviarElMail, "failed") !== false) {
        $respuesta["response"] = "Ha ocurrido un error al enviar el correo. Detalle: " . $respuestaAlEnviarElMail;
      } else {
        //obtener el ID del usuario
        $getGuestID = new queryToDDBB("SELECT id_usuario FROM usuario_prueba WHERE mail= '" . $lowerguestMail . "';");
        $gettedGuestID = $getGuestID->read();
        if (!is_numeric($gettedGuestID)) {
          $respuesta["response"] = "Error en el ID del nuevo usuario.";
        } else {
          //agregar ID usuario INVITADO a licencias
          $addGuestInLicenses = new queryToDDBB("INSERT INTO licencia (id_usuario, id_asignatura, vigencia) VALUES (" . intval($gettedGuestID) . ", 1, '2021-12-31 23:59:59');INSERT INTO licencia (id_usuario, id_asignatura, vigencia) VALUES (" . intval($gettedGuestID) . ", 2, '2021-12-31 23:59:59');");
          $addedGuestInLicenses = $addGuestInLicenses->write();
          if ($addedGuestInLicenses != "success") {
            $respuesta["response"] = "Error al escribir el invitado en licencias";
          } else {
            $respuesta["response"] = "Te hemos enviado un correo desde <strong>licencias@kaanbal.net</strong> el cual indica el proceso a seguir. Por favor revisa tu carpeta de junk mail, spam o correo no deseado.";
          }
        }
      }
    }
  }
}


////////////////
header('Content-Type: application/json');
echo json_encode($respuesta);

function crearTokenDDBB($mail)
{
  //Es hora de cambiar el token   |  Creamos un token random
  $token = bin2hex(random_bytes(5));
  //Agregar a la base de datos
  $addGuestToken = new queryToDDBB("UPDATE usuario_prueba SET  tokenA = '" . $token . "' WHERE mail = '" . $mail . "';");
  if ($addGuestToken->write() != "success") {
    return "error";
  } else {
    return $token;
  }
}

function cuerpoCorreoNuevoInvitado($mail, $token)
{
  return '
<html>
  <body>
    <div style="background-color: rgb(35, 85, 145)" height="30px">
      <h4
        style="
          color: rgb(250, 250, 250);
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
      Ahora podrás practicar, reforzar y consolidar los conceptos vistos en
      clase de forma interactiva y lúdica
    </p>
    <p>Tu <strong>usuario</strong> es el correo:</p>
    <p>' . $mail . '</p>
    <p>En la siguiente URL podrás crear tu <strong>contraseña</strong></p>
    <a href="https://kaanbal.net/dev/Front/errorInfoPages/password.php?token=' . $token . '&correo=' . $mail . '">
      <p><strong>https://kaanbal.net/dev/Front/errorInfoPages/password.php?token=' . $token . '&correo=' . $mail . '</strong></p>
    </a>
    <p>
      Recuerda esta liga es instransferible y de un solo uso. No la compartas.
    </p>
    <p style="color: white">.</p>
    <p>
      Una vez dentro de tu cuenta, selecciona un nombre y personaliza tu
      avatar en:
    </p>
    <p>
      <a
        href="
      https://kaanbal.net/prod/Front/Inicio/perfil.php"
      ></a>
      https://kaanbal.net/prod/Front/Inicio/perfil.php
    </p>
    <p>Si no actualizas tu información no podrás aparecer en el TOP</p>
    <p style="color: white">.</p>
    <p>
      Algunos consejos que te pueden ayudar a sacar mejor provecho de la
      Plataforma Educativa Kaanbal, conoce las secciones de la plaforma y su
      objetivo:
    </p>
    <p>
      > Revisar la teoría te ayudará a reforzar tus conocimientos y tener
      mejores resultados.
    </p>
    <p>
      > Para reunir el mayor número de diamantes lo ideal es que utilices la
      menor cantidad de tiempo en responder.
    </p>
    <p style="color: white">.</p>
    <p>En caso de cualquier duda o comentario por favor envía un mensaje a</p>

    <p>Correo: <a href="mailto:aclaraciones@kaanbal.net">aclaraciones@kaanbal.net</a></p>

    <p>WhatsApp: <strong>55 4871 4593</strong>.</p>
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
