<?php
require "00DDBBVariables.php";

//Leer las variables del POST
$idUser = $_POST['idUser'];
$idGroupCode = $_POST['idGroupCode'];
$listNumber = $_POST['listNumber'];
$idFirstName = $_POST['idFirstName'];

//Crear la escritura en base de datos
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //INSERT INTO MyGuests (firstname, lastname, email) VALUES ('John', 'Doe', 'john@example.com')
    //UPDATE Customers SET ContactName = 'Alfred Schmidt', City= 'Frankfurt' WHERE CustomerID = 1
    $sql = 'UPDATE alumno SET id_nombre = ' . $idFirstName . ', numero_lista = ' . $listNumber . ' WHERE id_usuario = ' . $idUser . ' ;';
    // use exec() because no results are returned
    $conn->exec($sql);
    $response["response"] = 'exito';
    //$response["response"] = $sql;
} catch (PDOException $e) {
    $response["response"] = $sql . "<br>" . $e->getMessage();
}

$conn = null;



////////////////    
echo json_encode($response);
