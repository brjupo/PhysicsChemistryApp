<?php
require "DDBBVariables.php";

$usuario = $_POST["usuario"];
$color = $_POST["color"];
$kaanbalUser = $_POST["kaanbalUser"];
$emailCliente = $_POST["emailCliente"];

$cuerpo = "";

//Crear la lectura en base de datos
$id_usuario = 0;
$response["response"] = 'Error desconocido';
//Leemos el id de usuario
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stringQuery = "SELECT id_usuario FROM usuario_prueba WHERE mail = '" . $usuario . "' AND pswd = '" . $color . "'  LIMIT 1;";
    $stmt = $conn->query($stringQuery);
    while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
        $id_usuario = intval($row[0]);
    }
} catch (PDOException $e) {
    $response["response"] = "Error: " . $e->getMessage();
}
$conn = null;

if ($id_usuario === 0) {
    $response["response"] = 'El usuario NO existe';
} else {
    //Leemos si esta en la tabla de staff
    $id_staff = 0;
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stringQuery = "SELECT id_staff FROM staff WHERE id_usuario = '" . $id_usuario . "' LIMIT 1;";
        $stmt = $conn->query($stringQuery);
        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $id_staff = intval($row[0]);
        }
    } catch (PDOException $e) {
        $response["response"] = "Error: " . $e->getMessage();
    }
    $conn = null;
    if ($id_staff === 0) {
        $response["response"] = 'El usuario NO existe en staff';
    } else {
        //Leemos si tiene un tokenA de contrasenia
        $token = "0";
        try {
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stringQuery = "SELECT tokenA FROM usuario_prueba WHERE mail = '" . $kaanbalUser . "' LIMIT 1;";
            $stmt = $conn->query($stringQuery);
            while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
                $token = $row[0];
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
        $conn = null;
        //------------------Si tiene tokenA, solo renviale el correo
        if ($token != "") {
            $response["response"] = "En la siguiente liga, el usuario podrá crear su contraseña
            https://kaanbal.net/PROD/Front/errorInfoPages/password.php?token=" . $token . "&correo=" . $kaanbalUser;
            //Enviar correo a usuario para que genere su contrasenia
            //mail(correo,asunto,cuerpo);
            $from = "no-reply@kaanbal.net";
            $to = $emailCliente;
            $subject = "Kaanbal - Password";
            $cuerpo = getCuerpo($token, $kaanbalUser);

            // Para enviar un correo HTML, debe establecerse la cabecera Content-type
            $headers  = 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";

            $headers .= "From:" . $from;
            mail($to, $subject, $cuerpo, $headers);
            $response["mail"] = "Correo enviado al usuario";
            //-----------------------Si no tiene tokenA crealo y enviale el correo
        } else {
            //Escribe en la base de datos un token aleatorio
            $rand = bin2hex(random_bytes(5));
            //Agregar a la base de datos
            //Crear la escritura en base de datos
            try {
                $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                // set the PDO error mode to exception
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $sql = "UPDATE usuario_prueba SET  tokenA = '$rand' WHERE mail = '$kaanbalUser'";
                // use exec() because no results are returned
                $conn->exec($sql);
                $response["response"] = "En la siguiente liga, el usuario podrá crear su contraseña
                 https://kaanbal.net/PROD/Front/errorInfoPages/password.php?token=" . $rand . "&correo=" . $kaanbalUser;
            } catch (PDOException $e) {
                $response["response"] = "<br>" . $e->getMessage();
            }

            $conn = null;

            //Enviar correo a usuario para que genere su contrasenia
            //mail(correo,asunto,cuerpo);
            $from = "no-reply@kaanbal.net";
            $to = $emailCliente;
            $subject = "Kaanbal - Password";
            $cuerpo = getCuerpo($rand, $kaanbalUser);

            // Para enviar un correo HTML, debe establecerse la cabecera Content-type
            $headers  = 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";

            $headers .= "From:" . $from;
            mail($to, $subject, $cuerpo, $headers);
            $response["mail"] = "Correo enviado al usuario";
        }
        //Leer id usuario de kaanbal user
        $id_kaanbalUser = 0;
        try {
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stringQuery = "SELECT id_usuario FROM usuario_prueba WHERE mail = '" . $kaanbalUser . "'  LIMIT 1;";
            $stmt = $conn->query($stringQuery);
            while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
                $id_kaanbalUser = intval($row[0]);
            }
        } catch (PDOException $e) {
            $response["response"] = "Error: " . $e->getMessage();
        }
        $conn = null;

        //Escribir 1 en la BBDD de que ya pagó
        try {
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "UPDATE licencia SET  pagado = 1 WHERE id_usuario = '$id_kaanbalUser'";
            // use exec() because no results are returned
            $conn->exec($sql);
            $response["usuario"] = "Al usuario " . $kaanbalUser . " se le ha marcada como PAGADA la licencia ";
        } catch (PDOException $e) {
            $response["response"] = "<br>" . $e->getMessage();
        }

        $conn = null;
    }
}


function getCuerpo($token, $kaanbalUser)
{
    $cuerpo = "
            <html>
              <body>
                <h4 style='background-color:rgb(35, 85, 145); color:rgb(35, 85, 145);'>.</h4>
                <h3>¡Bienvenida(o) a Kaanbal!</h3>
                <h4>
                  Has hecho una excelente decisión al adquirir la licencia semestral de la
                  <strong>Plataforma educativa Kaanbal</strong>
                </h4>
                <p>
                  Ahora podrás practicar, reforzar y consolidar los conceptos vistos en
                  clase de forma interactiva y lúdica
                </p>
                <p>Tu <strong>usuario</strong> es el mismo que has utlizado hasta ahora:</p>
                <p>" . $kaanbalUser . "</p>
                <p>
                  En la siguiente URL podrás cambiar tu <strong>contraseña</strong> a la que
                  tu desees
                </p>
                <a href='https://kaanbal.net/PROD/Front/errorInfoPages/password.php?token=" . $token . "&correo=" . $kaanbalUser . "'>
                    <p>https://kaanbal.net/PROD/Front/errorInfoPages/password.php?token=" . $token . "&correo=" . $kaanbalUser . "</p>
                </a>
                <p>Recuerda esta liga es instransferible. No la compartas.</p>
                <p style='color:white;'>.</p>
                <p>
                  Algunos consejos que te pueden ayudar a sacar mejor provecho de la
                  Plataforma Educativa Kaanbal, conoce las secciones de la plaforma y su
                  objetivo:
                </p>
                <p>
                   > Revisar la teoría te ayudará a reforzar tus conocimientos y tener mejores
                  resultados.
                </p>
                <p>
                   > Para reunir el mayor número de diamantes lo ideal es que utilices la menor
                  cantidad de tiempo en responder.
                </p>
                <p>
                   > Si requieres estudiar para un examen, esta sección te permitirá revisar
                  los temas y subtemas de la lección.
                </p>
                <p style='color:white;'>.</p>
                <p>
                  En caso de cualquier duda o comentario por favor envía un correo a la
                  dirección: <strong>kaanbal@veks.mx</strong> en donde un miembro del equipo
                  te estará apoyando con lo que requieras. Ponemos también a tu disposición
                  las siguientes opciones de contacto, donde con gusto los atenderemos vía
                  Whatsapp bussines: <strong>55 7923 5241</strong>.
                </p>
                <p style='color:white;'>.</p>
                <p>Agradecemos tu confianza,</p>
                <p>
                  <strong>Equipo de Plataforma Educativa Kaanbal</strong> un producto de
                  VEKS Solutions México S.A. de C.V.
                </p>
                <h1 style='background-color:rgb(35, 85, 145); color:rgb(35, 85, 145);'>.</h1>
              </body>
            </html>
            ";
    return $cuerpo;
}

////////////////    
echo json_encode($response);
