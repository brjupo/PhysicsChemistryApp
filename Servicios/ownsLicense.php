<?php
require "DDBBVariables.php";
//---------------NO BORRAR
//SI LO BORRAN, MUCHAS VISTAS DEJARÁN DE FUNCIONAR
//////////////////////////////////////////////////////

$pila = array();

function ownsLicense()
{   
    global $servername, $username, $password, $dbname;


    //Crear la lectura en base de datos
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stringQuery="SELECT";
        $stmt = $conn->query($stringQuery);
        while ($row = $stmt->fetch(PDO::FETCH_NUM)){
            array_push($pila, $row[0]);
        }															
    }
    catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    $conn = null;

    return $pila;
}