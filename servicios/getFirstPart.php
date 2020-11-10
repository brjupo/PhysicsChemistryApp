<?php
require "DDBBVariables.php";

//Leer las variables del POST
$tokenHora = $_POST['tokenHora'];

$hexTokenHora = bin2hex($tokenHora);
if ($hexTokenHora == "6e6461303931336654593637336f38344b4a") {
    //Crear la lectura en base de datos
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stringQuery = "SELECT VALUEX FROM hash262 WHERE GPG = 'I';";
        $stmt = $conn->query($stringQuery);
        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $response["value"] = $row[0];
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    $conn = null;
    header("HTTP/1.1 200 OK");
}
else{
    $response["error"] = "User, session token and/or CST are not correct or up to date";
    header("HTTP/1.1 401 Unathorized");
}

////////////////

header('Content-Type: application/json');
echo json_encode($response);
