<?php
require "DDBBVariables.php";

require '../../../../../vendor/autoload.php';
MercadoPago\SDK::setAccessToken("TEST-6020404437225723-102416-8ff6df5eba994e44818f40c514eb2c1a-653962800");


//Leer las variables del POST
switch ($_POST["type"]) {
    case "payment":
        $payment = MercadoPago\Payment . find_by_id($_POST["id"]);
        break;
    case "plan":
        $plan = MercadoPago\Plan . find_by_id($_POST["id"]);
        break;
    case "subscription":
        $plan = MercadoPago\Subscription . find_by_id($_POST["id"]);
        break;
    case "invoice":
        $plan = MercadoPago\Invoice . find_by_id($_POST["id"]);
        break;
}

$entityBody = stream_get_contents(STDIN);
$result = json_decode($entityBody, TRUE);
//Establecer uso horario para el envio de fecha y hora
function getDatetimeNow()
{
    $tz_object = new DateTimeZone('America/Mexico_City');
    $datetime = new DateTime();
    $datetime->setTimezone($tz_object);
    return $datetime->format('Y\-m\-d\ H:i:s');
}
$tiempo = getDatetimeNow();
//$id_mp = $_POST["id"];
$id_mp = $result["data"]["id"];
//Crear la escritura en base de datos
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //INSERT INTO MyGuests (firstname, lastname, email) VALUES ('John', 'Doe', 'john@example.com')
    //UPDATE Customers SET ContactName = 'Alfred Schmidt', City= 'Frankfurt' WHERE CustomerID = 1
    $sql = "INSERT INTO marketPay (id_market_pay, id_usuario, id_payment_status, tiempo) VALUES (" . $id_mp . ", 99999, 1, '" . $tiempo . "')";
    // use exec() because no results are returned
    $conn->exec($sql);
    $response["response"] = 'exito';
    //$response["response"] = $sql;
    header("HTTP/1.2 201 CREATED");
} catch (PDOException $e) {
    $response["response"] = $sql . "<br>" . $e->getMessage();
    $response["error"] = "User, session token and/or CST are not correct or up to date";
    header("HTTP/1.2 401 Unathorized");
}

$conn = null;

////////////////  
header('Content-Type: application/json');
echo json_encode($response);
