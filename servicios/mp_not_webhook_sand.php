<?php
require "00DDBBVariables.php";
require "04paymentValidation.php";
require "05userInformation.php";
require "06invoicingInformation.php";
//Leer el body tipo JSON que trae la consulta de mp
//echo "<p>Aqui andamos</p>";
$entityBody = file_get_contents('php://input');
//echo "<p>Pasamos el entity: " . $entityBody . "</p>";
$result = json_decode($entityBody, TRUE);
//echo "<p>Pasamos el result: " . $result . "</p>";

try {
    /*+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/
    /*++++++++++++++++++++  VARIABLES PARA EL QUERY  ++++++++++++++++++++*/
    /*+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/
    try {
        $id_mp = $result["data"]["id"]; //PROD
    } catch (Exception $e2) {
        $id_mp = $result["id"]; //DEV
    }
    $id_mp = str_replace(" ", "", $id_mp);
    //echo "0";

    /*++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/
    /*++++++++++++++++++++  1.- Obtener el mail de la persona y status de pago  ++++++++++++++++++++*/
    /*++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/
    $json = getFirstPartMarketPayAccessToken();
    $result = json_decode($json, TRUE);
    $firstPart = hex2bin($result["value"]);

    $json = getSecondPartMarketPayAccessToken();
    $result = json_decode($json, TRUE);
    $secondPart = hex2bin($result["value"]);

    $bearerToken = $firstPart . $secondPart;
    //$bearerToken = "TEST-6020404437225723-102416-8ff6df5eba994e44818f40c514eb2c1a-653962800";
    $url = 'https://api.mercadopago.com/v1/payments/search?id=' . $id_mp;
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, [
        'Authorization: Bearer ' . $bearerToken,
        'Content-Type: application/x-www-form-urlencoded'
    ]);
    $response = curl_exec($curl);
    curl_close($curl);
    // //echo $response . PHP_EOL;
    $result = json_decode($response, TRUE);
    //------------ MAIL CLIENTE ----------------
    $verdaderoCliente = $result["results"][0]["payer"]["email"];
    $verdaderoCliente = str_replace(" ", "", $verdaderoCliente);
    if ($verdaderoCliente == "" || $verdaderoCliente == NULL) {
        $verdaderoCliente = "no-reply@kaanbal.net";
    }
    //------------ STATUS DE PAGO -------------
    $statusPago = $result["results"][0]["status"];
    $statusPago = str_replace(" ", "", $statusPago);
    if ($statusPago == "" || $statusPago == NULL) {
        $statusPago = "DESCONOCIDO";
    }
    //------------ ID ASIGNATURA --------------
    $idAsignaturaNombre = $result["results"][0]["description"];
    $idAsignaturaNombreArray = explode("@@", $idAsignaturaNombre);
    $idAsignatura = intval($idAsignaturaNombreArray[0]);
    if ($idAsignatura == "" || $idAsignatura == NULL) {
        $idAsignatura = 0;
    }
    //echo "1";

    /*++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/
    /*++++++++++++++++++++++++++++++  2.- OBTENER EL ID DEL USUARIO  +++++++++++++++++++++++++++++++*/
    /*++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/
    //$verdaderoCliente
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
        echo "<p>Error getting user info: " . $e->getMessage() . "  " . $stringQuery . "</p>";
    }
    $conn = null;
    if ($entre == 0) {
        //id_usuario del usuario de no-reply@kaanbal.net
        $idVerdaderoCliente = 8272;
    }
    //echo "2";

    /*++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/
    /*++++++++++++++++++++++++++++++  3.- OBTENER EL STATUS DE PAGO  +++++++++++++++++++++++++++++++*/
    /*++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/
    //$statusPago
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
        echo "<p>Error payment: " . $e->getMessage() . "  " . $stringQuery . "</p>";
    }
    $conn = null;
    if ($entre == 0) {
        //idStatusPago DESCONOCIDO
        $idStatusPago = 0;
    }
    //echo "3";

    /*++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/
    /*+++++++++++++++++++++  4.- REGISTRAR LA INFORMACION DE MERCADO PAGO  +++++++++++++++++++++++++*/
    /*++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/
    /*+++++++++++++++  5.- RESPONDER A MERCADO PAGO QUE HEMOS GUARDADO LA INFO  ++++++++++++++++++++*/
    /*++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/
    $tiempo = getNowMexicoTime();
    try {
        //echo "entramos al try";
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        //INSERT INTO MyGuests (firstname, lastname, email) VALUES ('John', 'Doe', 'john@example.com')
        //UPDATE Customers SET ContactName = 'Alfred Schmidt', City= 'Frankfurt' WHERE CustomerID = 1
        $sql = "INSERT 
        INTO marketPay (id_market_pay, id_usuario, id_payment_status, tiempo, info) 
        VALUES (" . $id_mp . ", " . $idVerdaderoCliente . ", " . $idStatusPago . ", '" . $tiempo . "', '" . $entityBody . "')";
        // use exec() because no results are returned
        //echo "<p>ya se armo el query</p>";
        $conn->exec($sql);
        //echo "<p>Se ejecuto el sql</p>";
        //echo "segun yo anda chido, si se escribe";
    } catch (PDOException $e) {
        echo "<p>" . $sql . "<br>" . $e->getMessage() . "</p>";
    }
    $conn = null;
    //echo "45";


    /*++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/
    /*+++++++++  6.- ACTUALIZAR O CREAR LA INFORMACIÓN EN LA TABLA DE LICENCIAS CON STATUS +++++++++*/
    /*++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/
    //$id_mp
    //$idVerdaderoCliente
    //$idAsignatura
    //$statusPago

    $idLicenseCustomer = verifyUserSubjectExist($idVerdaderoCliente, $idAsignatura);
    $validity = getNowMexicoTimePlusSixMonths();
    if ($idLicenseCustomer > 0) {
        updatePaymentStatus($idLicenseCustomer, $validity, $id_mp, $statusPago);
    }
    if ($idLicenseCustomer == 0) {
        createPaymentStatus($idVerdaderoCliente, $idAsignatura, $validity, $id_mp, $statusPago);
    }
    //echo "6";

    header("HTTP/1.2 201 CREATED");
} catch (Exception $exception) {
    echo "<p>Error: " . $exception->getMessage() . "</p>";
    header("HTTP/1.2 401 Unathorized");
}
