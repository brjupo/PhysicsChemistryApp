<?php
require "../../Servicios/DDBBVariables.php";
require "../../Servicios/isAdmin.php";
$adminID = isAdmin();
if ($adminID == "null") {
    header('Location: https://kaanbal.net/');
    exit;
}
if (
    empty($_POST['campus']) || empty($_POST['profesor'])
    || empty($_POST['grupo']) || empty($_POST['asignatura'])
) {
    echo '<p> Algo llegó vacio</p><br>';
}

echo '<p>' . $_POST['campus'] . '</p><br>';
echo '<p>' . $_POST['profesor'] . '</p><br>';
echo '<p>' . $_POST['grupo'] . '</p><br>';
echo '<p>' . $_POST['asignatura'] . '</p><br>';

//Crear la escritura en base de datos
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //INSERT INTO MyGuests (firstname, lastname, email) VALUES ('John', 'Doe', 'john@example.com')
    //UPDATE Customers SET ContactName = 'Alfred Schmidt', City= 'Frankfurt' WHERE CustomerID = 1
    $sql = "INSERT INTO grupo (nombre, id_campus, id_profesor, id_asignatura) 
    VALUES ('" . $_POST['grupo'] . "', '" . $_POST['campus'] . "', 
    '" . $_POST['profesor'] . "', '" . $_POST['asignatura'] . "')";
    // use exec() because no results are returned
    $conn->exec($sql);
    header('Location: createGroup.php');
    //$response["response"] = $sql;
} catch (PDOException $e) {
    echo  $sql . "<br>" . $e->getMessage();
}

$conn = null;
