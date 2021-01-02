<?php
require "01readAndWriteDDBB.php";
require "02sendMail.php";


//OJO ¬¬ FATA METER LA ASOCIACION DEL CODIGO DE GRUPO EN LA TABLA ALUMNO

//Leer las variables del POST
$studentMail = $_POST["studentMail"];
$studentCode = $_POST["studentCode"];
$lowerStudentMail = strtolower($studentMail);

//Si contiene "palabra". ES IDENTICO A PREGUNTAR
//if (strpos($variable, 'palabra') !== false)


//if (strpos($lowerStudentMail, '@itesm.mx') === false) {
if (false) {
  $response["response"] = "¿Quieres obtener tu acceso a Kaanbal? <a href='https://kaanbal.net/contacto.html'>Contáctanos!</a>. Podemos ofrecer a su institución un periodo de prueba GRATUITO.";
} else {
  $getStudentMail = new queryToDDBB("SELECT mail FROM usuario_prueba WHERE mail = '" . $lowerStudentMail . "' ;");
  $gettedMail = $getStudentMail->read();
  //Validar que exista GRUPO
  $getGrupoCode = new queryToDDBB("SELECT id_grupo FROM grupo WHERE codigo = '" . $studentCode . "' ;");
  $gettedGroup = $getGrupoCode->read();
  if($gettedGroup != "null"){
        //Validar que no exusta Mail
        if ($lowerStudentMail == $gettedMail) {
          $response["response"] = "El usuario ya existe.";
        } else if (strpos($gettedMail, "failed") !== false) {
          $response["response"] = "Ha ocurrido un error inesperado. Por favor intenta más tarde.";
        } else {
          //agregarStudent a usuario_prueba con password correoCorreo
          $addStudent = new queryToDDBB("INSERT INTO usuario_prueba (mail, pswd) VALUES ('" . $lowerStudentMail . "', '" . $lowerStudentMail . $lowerStudentMail . "');");
          if ($addStudent->write() != "success") {
            $response["response"] = "Error al escribir el nuevo usuario";
          } else {
            //crear token
            $token = crearTokenDDBB($lowerStudentMail);
            if ($token == "error") {
              $response["response"] = "Ha ocurrido un error al crear token ";
            } else {
              //enviar correo
              $respuestaAlEnviarElMail =  enviarMail($lowerStudentMail, "Registro alumno. Kaanbal", cuerpoCorreoNuevoStudent($lowerStudentMail, $token, $studentCode));
              if (strpos($respuestaAlEnviarElMail, "failed") !== false) {
                $response["response"] = "Ha ocurrido un error al enviar el correo. Detalle: " . $respuestaAlEnviarElMail;
              } else {
                //obtener el ID del usuario
                $getStudentID = new queryToDDBB("SELECT id_usuario FROM usuario_prueba WHERE mail= '" . $lowerStudentMail . "';");
                $gettedStudentID = $getStudentID->read();
                if (!is_numeric($gettedStudentID)) {
                  $response["response"] = "Error en el ID del nuevo usuario.";
                } else {
                  //agregar ID usuario a alumno
                  $addStudentInStudent = new queryToDDBB("INSERT INTO alumno (id_usuario, matricula) VALUES (".intval($gettedStudentID).",'99et12cem');");
                  $addedStudentInStudent = $addStudentInStudent->write();
                  if ($addedStudentInStudent != "success") {
                    $response["response"] = "Error al escribir el alumno";
                  } else {
                    //obtener el ID del alumno y id de grupo
                    $getAlumnoID = new queryToDDBB("SELECT id_alumno FROM alumno WHERE id_usuario= '" . $gettedStudentID . "';");
                    $gettedAlumnoID = $getAlumnoID->read();
                    if (!is_numeric($gettedAlumnoID)) {
                      $response["response"] = "Error en el ID del grupo.";
                    } else {
                      //agregar ID de grupo y de alumno a alumno_grupo
                      $addAlumnogrupo = new queryToDDBB("INSERT INTO alumno_grupo (id_alumno, id_grupo) VALUES (".intval($getAlumnoID).",".intval($gettedGroup).");");
                      $addedAlumnoGrupo = $addAlumnogrupo->write();
                      if ($addedAlumnoGrupot != "success") {
                        $response["response"] = "Error al asociar grupo";
                      } else {
                    //agregar ID alumno a licencias
                    $addStudentInLicenses = new queryToDDBB("INSERT INTO licencia (id_usuario, id_asignatura, vigencia) VALUES (" . intval($gettedStudentID) . ", 1, '2021-12-31 23:59:59');INSERT INTO licencia (id_usuario, id_asignatura, vigencia) VALUES (" . intval($gettedStudentID) . ", 2, '2021-12-31 23:59:59');");
                    $addedStudentInLicenses = $addStudentInLicenses->write();
                    if ($addedStudentInLicenses != "success") {
                      $response["response"] = "Error al escribir el alumno en licencias";
                    } else {
                      $response["response"] = "Te hemos enviado un correo desde <strong>licencias@kaanbal.net</strong> el cual indica el proceso a seguir. Por favor revisa tu carpeta de junk mail, spam o correo no deseado.";
                    }
                  }
                }
              }
            }
          }
        }
      }
    }
  }else{
    $response["response"] = "Código de grupo inválido";
  }
}
////////////////
header('Content-Type: application/json');
echo json_encode($response);

function crearTokenDDBB($mail)
{
  //Es hora de cambiar el token   |  Creamos un token random
  $token = bin2hex(random_bytes(5));
  //Agregar a la base de datos
  $addStudentToken = new queryToDDBB("UPDATE usuario_prueba SET  tokenA = '" . $token . "' WHERE mail = '" . $mail . "';");
  if ($addStudentToken->write() != "success") {
    return "error";
  } else {
    return $token;
  }
}

function cuerpoCorreoNuevoStudent($mail, $token, $studentCode)
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
      Ahora tus alumnos podrán practicar, reforzar y consolidar los conceptos vistos en
      clase de forma interactiva y lúdica
    </p>
    <p>Tu <strong>usuario</strong> es el correo:</p>
    <p>' . $mail . '</p>
    <p>En la siguiente URL podrás crear tu <strong>contraseña</strong></p>
    <a href="https://kaanbal.net/dev/Front/errorInfoPages/password.php?token=' . $token . '&correo=' . $mail . '&grupo=' . $studentCode .'">
      <p>https://kaanbal.net/dev/Front/errorInfoPages/password.php?token=' . $token . '&correo=' . $mail . '&grupo=' . $studentCode .'</p>
    </a>
    
    <p>En caso de cualquier duda o comentario por favor envía un mensaje a</p>
    <img
      src="https://www.kaanbal.net/IMAGENES/email.svg"
      height="40px"
      style="display: block"
    />
    <p><a href="mailto:aclaraciones@kaanbal.net">aclaraciones@kaanbal.net</a></p>

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
