<?php
require "00DDBBVariables.php";
require "04paymentValidation.php";
require "05userInformation.php";
require "06invoicingInformation.php";
//Leer el body tipo JSON que trae la consulta de mp
echo "<p>Aqui andamos</p>";
$entityBody = file_get_contents('php://input');
echo "<p>Pasamos el entity: " . $entityBody . "</p>";
$result = json_decode($entityBody, TRUE);
echo "<p>Pasamos el result: " . $result . "</p>";
$response["response"] .= "Lo que llego |";
$response["response"] .= $entityBody;
$response["response"] .= "|";

$response["response"] .= "El JSON |";
$response["response"] .= $result;
$response["response"] .= "|";

//Establecer uso horario para el envio de fecha y hora
function getDatetimeNow()
{
    $tz_object = new DateTimeZone('America/Mexico_City');
    $datetime = new DateTime();
    $datetime->setTimezone($tz_object);
    return $datetime->format('Y\-m\-d\ H:i:s');
}
$errorDetected = 0;
echo "<p>Pasamos funcionfecha</p>";
/*+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/
/*++++++++++++++++++++  VARIABLES PARA EL QUERY  ++++++++++++++++++++*/
/*+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/
try {
    $id_mp = $result["id"];
    echo "<p>Entramos al try result[id]= " . $id_mp . "</p>";
} catch (Exception $e) {
    $errorDetected = 1;
    $response["response"] .= "Error, id of market pay was not detected \n";
}

$id_mp = str_replace(" ", "", $id_mp);
if (!is_numeric($id_mp)) {
    $errorDetected = 1;
    $response["response"] .= "Error, id of market pay is not valid \n";
}

/*++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/
/*++++++++++++++++++++  1.- Obtener el mail de la persona y status de pago  ++++++++++++++++++++*/
/*++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/
if ($errorDetected == 0) {
    $bearerToken = "TEST-6020404437225723-102416-8ff6df5eba994e44818f40c514eb2c1a-653962800";
    $url = 'https://api.mercadopago.com/v1/payments/search?id=' . $id_mp;
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, [
        'Authorization: Bearer ' . $bearerToken,
        'Content-Type: application/x-www-form-urlencoded'
    ]);
    $response = curl_exec($curl);
    curl_close($curl);
    // echo $response . PHP_EOL;
    $result = json_decode($response, TRUE);
    try {
        //------------ MAIL CLIENTE ----------------
        $verdaderoCliente = $result["results"][0]["payer"]["email"];
        $verdaderoCliente = str_replace(" ", "", $verdaderoCliente);
        //------------ STATUS DE PAGO -------------
        $statusPago = $result["results"][0]["status"];
        $statusPago = str_replace(" ", "", $statusPago);
        //------------ ID ASIGNATURA --------------
        $idAsignaturaNombre = $result["results"][0]["description"];
        $idAsignaturaNombreArray = explode("@@", $idAsignaturaNombre);
        $idAsignatura = intval($idAsignaturaNombreArray[0]);
    } catch (Exception $e) {
        $response["response"] .= "Es prueba, se guarda como brjupo@gmail.com";
        $verdaderoCliente = "brjupo@gmail.com";
        $statusPago = "DESCONOCIDO";
        $idAsignatura = 1;
    }
}
if (is_null($result)) {
    $errorDetected = 1;
    $response["response"] .= 'Error. No information about this id \n';
}

echo "<p>Pasamos la lectura de las variables. Cliente " . $verdaderoCliente . "</p>";

/*++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/
/*++++++++++++++++++++++++++++++  2.- OBTENER EL ID DEL USUARIO  +++++++++++++++++++++++++++++++*/
/*++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/
//$verdaderoCliente
if ($errorDetected == 0) {
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stringQuery = "SELECT id_usuario FROM usuario_prueba WHERE mail = '" . $verdaderoCliente . "' LIMIT 1";
        $stmt = $conn->query($stringQuery);
        $entre = 0;
        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $idVerdaderoCliente = $row[0];
            $entre = 1;
        }
    } catch (PDOException $e) {
        $response["response"] .=  "Error getting user info: " . $e->getMessage() . "  " . $stringQuery . "\n";
        $errorDetected = 1;
    }
    $conn = null;
    if ($entre == 0) {
        //id_usuario del usuario de brandon
        $idVerdaderoCliente = 4;
    }
}

echo "<p>Pasamos la lectura de las variables. idCliente " . $idVerdaderoCliente . "</p>";
/*++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/
/*++++++++++++++++++++++++++++++  3.- OBTENER EL STATUS DE PAGO  +++++++++++++++++++++++++++++++*/
/*++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/
//$statusPago
if ($errorDetected == 0) {
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stringQuery = "SELECT id_payment_status FROM payment_status WHERE payment_status = '" . $statusPago . "' LIMIT 1";
        $stmt = $conn->query($stringQuery);
        $entre = 0;
        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $idStatusPago = $row[0];
            $entre = 1;
        }
    } catch (PDOException $e) {
        $response["response"] .=  "Error payment: " . $e->getMessage() . "  " . $stringQuery . "\n";
        $errorDetected = 1;
    }
    $conn = null;
    if ($entre == 0) {
        //idStatusPago DESCONOCIDO
        $idStatusPago = 0;
    }
}

echo "<p>Pasamos idStatusPago" . $idStatusPago . "</p>";
$tiempo = getDatetimeNow();
echo "<p>Pasamos getDatetimeNow</p>";
/* EL JSON COMPLETO ES $entityBody */

/*++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/
/*+++++++++++++++++++++  4.- REGISTRAR LA INFORMACION DE MERCADO PAGO  +++++++++++++++++++++++++*/
/*++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/
/*+++++++++++++++  5.- RESPONDER A MERCADO PAGO QUE HEMOS GUARDADO LA INFO  ++++++++++++++++++++*/
/*++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/
if ($errorDetected == 0) {
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        //INSERT INTO MyGuests (firstname, lastname, email) VALUES ('John', 'Doe', 'john@example.com')
        //UPDATE Customers SET ContactName = 'Alfred Schmidt', City= 'Frankfurt' WHERE CustomerID = 1
        $sql = "INSERT 
        INTO marketPay (id_market_pay, id_usuario, id_payment_status, tiempo, info) 
        VALUES (" . $id_mp . ", " . $idVerdaderoCliente . ", " . $idStatusPago . ", '" . $tiempo . "', '" . $entityBody . "')";
        // use exec() because no results are returned
        $conn->exec($sql);
        $response["response"] .= "Exito\n";
    } catch (PDOException $e) {
        $response["response"] .= $sql . "<br>" . $e->getMessage() . "\n";
        $response["response"] .= "User, session token and/or CST are not correct or up to date\n";
        echo $sql . "<br>" . $e->getMessage() . "\n";;
    }
    $conn = null;
}
echo "<p>Pasamos guardar info, entityBody: " . $entityBody . "</p>";

if ($errorDetected == 1) {
    header("HTTP/1.2 401 Unathorized");
} else {
    header("HTTP/1.2 201 CREATED");
}


echo "<p>Pasamos headers</p>";
////////////////  
header('Content-Type: application/json');
echo json_encode($response);
//Si se deja después de enviar los headers. FALLA
/*++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/
/*+++++++++  6.- ACTUALIZAR O CREAR LA INFORMACIÓN EN LA TABLA DE LICENCIAS CON STATUS +++++++++*/
/*++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/
//$id_mp
//$idVerdaderoCliente
//$idAsignatura
//$idStatusPago
/*
if ($errorDetected == 0) {
    $idLicenseCustomer = verifyUserSubjectExist($idVerdaderoCliente, $idAsignatura);
    $validity = getNowMexicoTimePlusSixMonths();
    if ($idLicenseCustomer > 0) {
        updatePaymentStatus($idLicenseCustomer, $validity, $idStatusPago);
    }
    if ($idLicenseCustomer == 0) {
        createPaymentStatus($idVerdaderoCliente, $idAsignatura, $validity, $id_mp, $idStatusPago);
    }
}
*/
