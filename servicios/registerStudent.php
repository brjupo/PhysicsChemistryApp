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
  $respuesta["response"] = "¿Quieres obtener tu acceso a Kaanbal? <a href='https://kaanbal.net/contacto.html'>Contáctanos!</a>. Podemos ofrecer a su institución un periodo de prueba GRATUITO.";
} else {
  $getStudentMail = new queryToDDBB("SELECT mail FROM usuario_prueba WHERE mail = '" . $lowerStudentMail . "' ;");
  $gettedMail = $getStudentMail->read();
  //Validar que exista GRUPO
  $getGrupoCode = new queryToDDBB("SELECT id_grupo FROM grupo WHERE codigo = '" . $studentCode . "' ;");
  $gettedGroup = $getGrupoCode->read();
  if ($gettedGroup != "null") {
    //Validar que no exusta Mail
    if ($lowerStudentMail == $gettedMail) {
      $respuesta["response"] = "El usuario ya existe.";
    } else if (strpos($gettedMail, "failed") !== false) {
      $respuesta["response"] = "Ha ocurrido un error inesperado. Por favor intenta más tarde.";
    } else {
      //agregarStudent a usuario_prueba con password correoCorreo
      $tempPas = MD5($lowerStudentMail . $lowerStudentMail);
      $addStudent = new queryToDDBB("INSERT INTO usuario_prueba (mail, pass_cifrado) VALUES ('" . $lowerStudentMail . "', '" . $tempPas . "');");
      if ($addStudent->write() != "success") {
        $respuesta["response"] = "Error al escribir el nuevo usuario";
      } else {
        //crear token
        $token = crearTokenDDBB($lowerStudentMail);
        if ($token == "error") {
          $respuesta["response"] = "Ha ocurrido un error al crear token ";
        } else {
          //enviar correo
          $respuestaAlEnviarElMail =  enviarMail($lowerStudentMail, "Registro alumno. Kaanbal", cuerpoCorreoNuevoStudent($lowerStudentMail, $token));
          if (strpos($respuestaAlEnviarElMail, "failed") !== false) {
            $respuesta["response"] = "Ha ocurrido un error al enviar el correo. Detalle: " . $respuestaAlEnviarElMail;
          } else {
            //obtener el ID del usuario
            $getStudentID = new queryToDDBB("SELECT id_usuario FROM usuario_prueba WHERE mail= '" . $lowerStudentMail . "';");
            $gettedStudentID = $getStudentID->read();
            if (!is_numeric($gettedStudentID)) {
              $respuesta["response"] = "Error en el ID del nuevo usuario.";
            } else {
              //agregar ID usuario a alumno
              $addStudentInStudent = new queryToDDBB("INSERT INTO alumno (id_usuario, matricula) VALUES (" . intval($gettedStudentID) . ",'" . $lowerStudentMail . "');");
              $addedStudentInStudent = $addStudentInStudent->write();
              if ($addedStudentInStudent != "success") {
                $respuesta["response"] = "Error al escribir el alumno";
              } else {
                //obtener el ID del alumno y id de grupo
                $getAlumnoID = new queryToDDBB("SELECT id_alumno FROM alumno WHERE id_usuario= '" . $gettedStudentID . "';");
                $gettedAlumnoID = $getAlumnoID->read();
                if (!is_numeric($gettedAlumnoID)) {
                  $respuesta["response"] = "Error en el ID del grupo.";
                } else {
                  //agregar ID de grupo y de alumno a alumno_grupo
                  $addAlumnogrupo = new queryToDDBB("INSERT INTO alumno_grupo (id_alumno, id_grupo) VALUES (" . intval($gettedAlumnoID) . "," . intval($gettedGroup) . ");");
                  $addedAlumnoGrupo = $addAlumnogrupo->write();

                  //Traer materia de acuerdo al grupo
                  $getAsignaturaID = new queryToDDBB("SELECT id_asignatura FROM grupo WHERE id_grupo= '" . $gettedGroup . "';");
                  $gettedAsignaturaID = $getAsignaturaID->read();
                  if ($addedAlumnoGrupo != "success") {
                    $respuesta["response"] = "Error al asociar grupo";
                  } else {
                    //agregar ID alumno a licencias
                    $addStudentInLicenses = new queryToDDBB("INSERT INTO licencia (id_usuario, id_asignatura, vigencia, pagado, estatus) VALUES (" . intval($gettedStudentID) . "," . intval($gettedAsignaturaID) . " , '2021-12-31 23:59:59',1,1);");
                    $addedStudentInLicenses = $addStudentInLicenses->write();
                    if ($addedStudentInLicenses != "success") {
                      $respuesta["response"] = "Error al escribir el alumno en licencias";
                    } else {
                      $respuesta["response"] = "Te hemos enviado un correo desde <strong>licencias@kaanbal.net</strong> el cual indica el proceso a seguir. Por favor revisa tu carpeta de junk mail, spam o correo no deseado.";
                    }
                  }
                }
              }
            }
          }
        }
      }
    }
  } else {
    $respuesta["response"] = "Código de grupo inválido";
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
  $addStudentToken = new queryToDDBB("UPDATE usuario_prueba SET  tokenA = '" . $token . "' WHERE mail = '" . $mail . "';");
  if ($addStudentToken->write() != "success") {
    return "error";
  } else {
    return $token;
  }
}

function cuerpoCorreoNuevoStudent($mail, $token)
{
  return '
<html>
<head>
  <meta charset="ISO-8859-1">
</head>
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
      Has hecho una excelente decisión al utilizar la
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
      Una vez dentro de tu cuenta, actualiza tu número de lista, nombre y personaliza tu
      avatar en:
    </p>
    <p>
      <a
        href="
      https://kaanbal.net/dev/Front/Inicio/perfil.php"
      ></a>
      https://kaanbal.net/dev/Front/Inicio/perfil.php
    </p>
    <p>Si no actualizas tu información el profesor NO observará tus calificaciones</p>
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
    <p style="color: white">.</p>
    <p>Agradecemos tu confianza,</p>
    <p>
      <strong>Equipo de Plataforma Educativa Kaanbal</strong>
    </p>
    <h4 style="background-color: rgb(35, 85, 145); color: rgb(35, 85, 145)">
      .
    </h4>
  </body>
</html>
    ';
}
