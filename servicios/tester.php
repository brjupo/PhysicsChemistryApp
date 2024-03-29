<?php
require "00DDBBVariables.php";
require "02sendMail.php";

class queryToDDBB2
{

    function __construct($stringQuery)
    {
        $this->stringQuery = $stringQuery;
    }
    function read()
    {
        $this->response = "failed";
        //Crear la lectura en base de datos
        global $servername, $dbname, $username, $password;
        try {
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $conn->query($this->stringQuery);
            $this->response = "null";
            while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
                $this->response = $row[0];
            }
        } catch (PDOException $e) {
            $this->response = "failed: " . $this->stringQuery . $e->getMessage();
        }
        $conn = null;
        return $this->response;
    }
    function write()
    {
        $this->response = "failed";
        //Crear la escritura en base de datos
        global $servername, $dbname, $username, $password;
        try {
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // use exec() because no results are returned
            $this->response = "failed: algo se rompió al ejecutar la escritura";
            $conn->exec($this->stringQuery);
            $this->response = "success";
        } catch (PDOException $e) {
            $this->response =  "failed:" . $this->stringQuery . "<br>" . $e->getMessage();
        }
        $conn = null;
        return $this->response;
    }
}




//Leer las variables del POST
$teacherMail = $_POST["teacherMail"];
$lowerTeacherMail = strtolower($teacherMail);

//Si contiene "palabra". ES IDENTICO A PREGUNTAR
//if (strpos($variable, 'palabra') !== false)


//if (strpos($lowerTeacherMail, '@itesm.mx') === false) {
if (false) {
  $response["response"] = "¿Quieres obtener tu acceso a Kaanbal? <a href='https://kaanbal.net/contacto.html'>Contáctanos!</a>. Podemos ofrecer a su institución un periodo de prueba GRATUITO.";
} else {
  $getTeacherMail = new queryToDDBB2("SELECT mail FROM usuario_prueba WHERE mail = '" . $lowerTeacherMail . "' ;");
  $gettedMail = $getTeacherMail->read();
  if ($lowerTeacherMail == $gettedMail) {
    $response["response"] = "El usuario ya existe.";
  } else if (strpos($gettedMail, "failed") !== false) {
    $response["response"] = "Ha ocurrido un error inesperado. Por favor intenta más tarde.";
  } else {
    //enviar correo
    //function enviarMail($destinatario, $asunto, $cuerpo)
    
    //$respuestaAlEnviarElMail =  enviarMail($lowerTeacherMail, "Registro profesor. Kaanbal", cuerpoCorreoNuevoProfesor());
    $respuestaAlEnviarElMail = "Message sent";
    if (strpos($respuestaAlEnviarElMail, "failed") !== false) {
      $response["response"] = "Ha ocurrido un error al enviar el correo. Detalle: " . $respuestaAlEnviarElMail;
    } else {
      //agregarProfesor a usuario_prueba con password correoCorreo
      $addTeacher = new queryToDDBB2("INSERT INTO usuario_prueba (mail, pass_cifrado) VALUES ('" . $lowerTeacherMail . "', '" . $lowerTeacherMail . $lowerTeacherMail . "');");
      if ($addTeacher->write() != "success") {
        $response["response"] = "Error al escribir el nuevo usuario";
      } else {
        //obtener el ID del usuario
        $getTeacherID = new queryToDDBB2("SELECT id_usuario FROM usuario_prueba WHERE mail= '" . $lowerTeacherMail . "';");
        $gettedTeacherID = $getTeacherID->read();
        if (!is_numeric($gettedTeacherID)) {
          $response["response"] = "Error en el ID del nuevo usuario.";
        } else {
          //agregar ID profesor a profesor
          $addTeacherInTeacher = new queryToDDBB2("INSERT INTO profesor (id_usuario) VALUES (" . intval($gettedTeacherID) . ") ;");
          $addedTeacherInTeacher = $addTeacherInTeacher->write();
          if ($addedTeacherInTeacher != "success") {
            $response["response"] = "Error al escribir el profesor";
          } else {
            //agregar ID profesor a licencias
            $addTeacherInLicenses = new queryToDDBB2("INSERT INTO profesor (id_usuario) VALUES (" . intval($gettedTeacherID) . ") ;");
            $addedTeacherInLicenses = $addTeacherInLicenses->write();
            if ($addedTeacherInLicenses != "success") {
              $response["response"] = "Error al escribir el profesor en licencias";
            } else {
              $response["response"] = "Te hemos enviado un correo desde <strong>licencias@kaanbal.net</strong> el cual indica el proceso a seguir. Por favor revisa tu carpeta de junk mail, spam o correo no deseado.";
            }
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
        src: url("https://www.kaanbal.net/dev/Front/CSSsJSs/Fonts/ubuntu/ubuntu.ttf")
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
    <p>1.- Usando el link previo, crea tu contraseña e ingresa a <a href="https://www.kaanbal.net"> Kaanbal </a> con tu correo y contraseña</p>
    <p>2.- Da clic en la sección "Crear grupos".</p>
    <p>3.- Comparte con tus alumnos el código de grupo.</p>
    <p>Listo! en cuanto tus alumnos se registren podrás observar su avance en la sección de "Reportes"</p>
    <p style="color: white">.</p>
    <p>En caso de cualquier duda o comentario por favor envía un mensaje a</p>
    <img
      src="https://www.kaanbal.net/IMAGENES/email.svg"
      height="40px"
      style="display: block"
    />
    <p><a href="aclaraciones@kaanbal.net">aclaraciones@kaanbal.net</a></p>
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
