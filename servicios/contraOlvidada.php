<?php
require "00DDBBVariables.php";
require "02sendMail.php";

$con = mysqli_connect($servername, $username, $password, $dbname);

$correo_e = $_POST["correo_e"];


$sql = "SELECT mail FROM usuario_prueba WHERE mail = '$correo_e'";
$resultp = mysqli_query($con, $sql);
$rowp = mysqli_fetch_array($resultp);

$findme   = '@';
$pos = strpos($correo_e, $findme);

$respuesta = array();
$respuesta['response'] = 'Error desconocido';

if ($correo_e == "" or $correo_e == NULL) {
    $respuesta['response'] = 'Ingresa un correo!';
} else if ($pos === false) {
    //NO TIENE ARROBA - es alumno
    $respuesta['response'] = 'Usa la liga que te enviamos cuando realizaste el pago, sino funciona escribenos un correo adjuntando tu pago a <strong>aclaraciones@kaanbal.net</strong>';
} else {
    if ($rowp) {
        //Es hora de cambiar el token   |  Creamos un token random
        $rand = bin2hex(random_bytes(5));
        //Agregar a la base de datos
        //UPDATE table_name SET column1 = value1, column2 = value2 WHERE id=100;
        $sql = "UPDATE usuario_prueba SET  tokenA = '$rand' WHERE mail = '$correo_e'";
        mysqli_query($con, $sql);
        //Enviar correo a usuario para que genere su contrasenia
        enviarMail($correo_e, "Registro alumno. Kaanbal", cuerpoCorreoNuevoStudent($correo_e, $rand));
        //Si no existe, regresar true
        $respuesta['response'] = 'true';
    } else {
        //Si ya existe, regresar que ya existe.
        $respuesta['response'] = 'Usuario NO existe';
    }
}

echo json_encode($respuesta);


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

    <p>En la siguiente URL podrás cambiar tu <strong>contraseña</strong></p>
    <a href="https://kaanbal.net/dev/Front/errorInfoPages/password.php?token=' . $token . '&correo=' . $mail . '">
      <p><strong>https://kaanbal.net/dev/Front/errorInfoPages/password.php?token=' . $token . '&correo=' . $mail . '</strong></p>
    </a>
    <p>
      Recuerda esta liga es instransferible y de un solo uso. No la compartas.
    </p>
    <p style="color: white">.</p>
    <p>
    Si vuelves a olvidarla. Ingresa a https://kaanbal.net y elige la opción olvidé mi contraseña.
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
