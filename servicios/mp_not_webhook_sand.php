<?php
require "00DDBBVariables.php";
//Leer el body tipo JSON que trae la consulta de mp
$entityBody = file_get_contents('php://input');
$result = json_decode($entityBody, TRUE);

//Establecer uso horario para el envio de fecha y hora
function getDatetimeNow()
{
    $tz_object = new DateTimeZone('America/Mexico_City');
    $datetime = new DateTime();
    $datetime->setTimezone($tz_object);
    return $datetime->format('Y\-m\-d\ H:i:s');
}
$errorDetected = 0;
/*+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/
/*++++++++++++++++++++  VARIABLES PARA EL QUERY  ++++++++++++++++++++*/
/*+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/
$id_mp = $result["data"]["id"];
//Si llega del boton "probar" de mercado pago, no exite data id, solo id
if (is_null($id_mp)) {
    $id_mp = $result["id"];
}
if (is_null($id_mp)) {
    $errorDetected = 1;
    $response["response"] .= "Error, id of market pay was not detected \n";
}
/* FALTA OBTENER EL CORREO DEL COMPRADOR DE MP ["results"][0]["payer"]["email"] . CON EL CORREO OBTENER EL ID_USUARIO */
$verdaderoCliente = $result["results"][0]["payer"]["email"];
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
        $response["response"] .=  "Error linea 37: " . $e->getMessage() . "  " . $stringQuery . "\n";
        $errorDetected = 1;
    }
    $conn = null;
    if ($entre == 0) {
        //id_usuario del usuario de brandon
        $idVerdaderoCliente = 4;
    }
}

/* FALTA OBTENER EL ["results"][0]["status"]. CON EL STATUS OBTENER EL ID DE STATUS */
$statusPago = $result["results"][0]["status"];
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
        $response["response"] .=  "Error linea 66: " . $e->getMessage() . "  " . $stringQuery . "\n";
        $errorDetected = 1;
    }
    $conn = null;
    if ($entre == 0) {
        //idStatusPago DESCONOCIDO
        $idStatusPago = 0;
    }
}

$tiempo = getDatetimeNow();
/* EL JSON COMPLETO ES $entityBody */
/*+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/
/*++++++++++++++++++++++++  ESCRITURA A BBDD  +++++++++++++++++++++++*/
/*+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/
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
        header("HTTP/1.2 201 CREATED");
    } catch (PDOException $e) {
        $response["response"] .= $sql . "<br>" . $e->getMessage() . "\n";
        $response["response"] .= "User, session token and/or CST are not correct or up to date\n";
        header("HTTP/1.2 401 Unathorized");
    }
    $conn = null;
}


////////////////  
header('Content-Type: application/json');
echo json_encode($response);
