<?php
require "00DDBBVariables.php";
//---------------NO BORRAR
//SI LO BORRAN, MUCHAS VISTAS DEJARÁN DE FUNCIONAR
//////////////////////////////////////////////////////

$pila = array();
//$idAsignatura = $_SESSION["idAsignatura"];


function ownsLicense()
{
    global $servername, $username, $password, $dbname;

    $mail = $_SESSION["mail"];
    //Crear la lectura en base de datos
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stringQuery = "SELECT licencia.id_asignatura 
        FROM licencia 
        INNER JOIN usuario_prueba ON licencia.id_usuario = usuario_prueba.id_usuario 
        WHERE usuario_prueba.mail = '" . $mail . "' ";
        $stmt = $conn->query($stringQuery);
        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            array_push($pila, $row[0]);
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    $conn = null;

    return $pila;
}
