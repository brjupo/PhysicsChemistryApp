<?php
require "../../../servicios/00DDBBVariables.php";

//Leer las variables del POST
$id_asignatura = $_POST['id_asignatura'];
$id_usuario = $_POST['id_usuario'];
$nombre_grupo = $_POST['nombre_grupo'];
$codigo_grupo = $_POST['codigo_grupo'];
//id_asignatura, id_profesor, nombre, codigo

//Crear la escritura en base de datos
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //INSERT INTO MyGuests (firstname, lastname, email) VALUES ('John', 'Doe', 'john@example.com')
    //UPDATE Customers SET ContactName = 'Alfred Schmidt', City= 'Frankfurt' WHERE CustomerID = 1
    $sql = "";
    $sql='INSERT INTO grupo (id_campus, id_periodo_escolar, id_asignatura, id_profesor, nombre, codigo) SELECT "4", "0", "' . $id_asignatura . '", id_profesor, "' . $nombre_grupo . '", "' . $codigo_grupo . '" FROM profesor WHERE id_usuario = ' . $id_usuario . ';';
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
