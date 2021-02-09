<?php
$con = mysqli_connect("localhost", "u526597556_dev", "1BLeeAgwq1*isgm&jBJe", "u526597556_kaanbal");


$token = $_POST["tokenA"];
$correo = $_POST["correo"];
$password = $_POST["password"];
$token = str_replace(" ", "", $token);
$correo = str_replace(" ", "", $correo);
$password = MD5($password);
$password = str_replace(" ", "", $password);

//Corroborar que no existe el correo en base de datos
$sql = "SELECT mail FROM usuario_prueba WHERE tokenA = '$token' AND mail = '$correo'";
$resultp = mysqli_query($con, $sql);
$rowp = mysqli_fetch_array($resultp);

if ($rowp) {
    //Si existe [mail y token] registrar contraseña en base de datos y responder true
    $sql = "UPDATE usuario_prueba SET pswd='$password' WHERE tokenA = '$token' AND mail = '$correo'";
    mysqli_query($con, $sql);

    //Es hora de cambiar el token   |  Creamos un token random
    //-------$rand = bin2hex(random_bytes(5));
    //Cambiamos el token
    //-------$sql = "UPDATE usuario_prueba SET tokenA='$rand' WHERE mail = '$correo'";
    //-------mysqli_query($con, $sql);

    $response = array();
    $response['response'] = 'true';

    echo json_encode($response);
} else {

    //Si no existe regresar false
    $response = array();
    $response['response'] = 'El usuario no existe';

    echo json_encode($response);
}
