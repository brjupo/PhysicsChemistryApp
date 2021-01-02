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

/*+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/
/*++++++++++++++++++++  VARIABLES PARA EL QUERY  ++++++++++++++++++++*/
/*+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/
$id_mp = $result["data"]["id"];
//Si llega del boton "probar" de mercado pago, no exite data id, solo id
if(is_null($id_mp)){
    $id_mp = $result["id"];
}
/* FALTA OBTENER EL CORREO DEL COMPRADOR DE MP ["results"][0]["payer"]["email"] . CON EL CORREO OBTENER EL ID_USUARIO */
/* FALTA OBTENER EL ["results"][0]["status"]. CON EL STATUS OBTENER EL ID DE STATUS */
$tiempo = getDatetimeNow();
/* INFO es $entityBody */


/*+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/
/*++++++++++++++++++++++++  ESCRITURA A BBDD  +++++++++++++++++++++++*/
/*+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //INSERT INTO MyGuests (firstname, lastname, email) VALUES ('John', 'Doe', 'john@example.com')
    //UPDATE Customers SET ContactName = 'Alfred Schmidt', City= 'Frankfurt' WHERE CustomerID = 1
    $sql = "INSERT INTO marketPay (id_market_pay, id_usuario, id_payment_status, tiempo, info) VALUES (" . $id_mp . ", 99999, 1, '" . $tiempo . "', '" . $entityBody . "')";
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
