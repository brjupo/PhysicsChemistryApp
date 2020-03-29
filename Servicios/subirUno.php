<?php
$con = mysqli_connect("localhost", "u526597556_dev", "1BLeeAgwq1*isgm&jBJe", "u526597556_kaanbal");


$studentID = $_POST["studentID"];
$password = $_POST["password"];

//Corroborar que no existe el correo en base de datos
$correo_e = $studentID . "@itesm.mx";

$sql = "SELECT mail FROM usuario_prueba WHERE mail = '$correo_e'";
$resultp = mysqli_query($con, $sql);
$rowp = mysqli_fetch_array($resultp);

$sql = "SELECT pswd FROM usuario_prueba WHERE mail = 'superUsuario'";
$resultadoSuper = mysqli_query($con, $sql);
$arraySuper = mysqli_fetch_array($resultadoSuper);
if ($arraySuper[0] != $password) {
    $response = array();
    $response['response'] = $arraySuper[0];
    echo json_encode($response);
} else {
    if ($rowp) {
        //Si ya existe, regresar que ya existe.
        $response = array();
        $response['response'] = 'Error! Este correo ya existe';
        echo json_encode($response);
    } else {
        //Es hora de cambiar el token   |  Creamos un token random
        $rand = bin2hex(random_bytes(5));
        //Agregar a la base de datos
        $sql = "INSERT INTO usuario_prueba(mail, pswd, tokenA) VALUES ('$correo_e', NULL, '$rand')";
        mysqli_query($con, $sql);

        //Si no existe, regresar true
        $response = array();
        $response['response'] = 'true';
        echo json_encode($response);
    }
}
