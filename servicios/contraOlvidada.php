<?php
require "00DDBBVariables.php";

$con = mysqli_connect($servername, $username, $password, $dbname);

$correo_e = $_POST["correo_e"];


$sql = "SELECT mail FROM usuario_prueba WHERE mail = '$correo_e'";
$resultp = mysqli_query($con, $sql);
$rowp = mysqli_fetch_array($resultp);

$findme   = '@';
$pos = strpos($correo_e, $findme);

$response = array();
$response['response'] = 'Error desconocido';

if ($correo_e == "" or $correo_e == NULL) {
    $response['response'] = 'Ingresa un correo!';
} 
else if ($pos === false) {
    //NO TIENE ARROBA - es alumno
    $response['response'] = 'Usa la liga que te enviamos cuando realizaste el pago, sino funciona escribenos un correo adjuntando tu pago a kaanbal@veks.mx';
}
else {
    if ($rowp) {
        //Es hora de cambiar el token   |  Creamos un token random
        $rand = bin2hex(random_bytes(5));
        //Agregar a la base de datos
        //UPDATE table_name SET column1 = value1, column2 = value2 WHERE id=100;
        $sql = "UPDATE usuario_prueba SET  tokenA = '$rand' WHERE mail = '$correo_e'";
        mysqli_query($con, $sql);
        //Enviar correo a usuario para que genere su contrasenia
        //mail(correo,asunto,cuerpo);
        $from = "no-reply@kaanbal.net";
        $to = $correo_e;
        $subject = "Kaanbal - Password";
        $cuerpo = "Hola! En la siguiente liga podrás cambiar tu contraseña. 
        https://kaanbal.net/dev/Front/errorInfoPages/password.php?token=" . $rand . "&correo=" . $correo_e . " \n 
        Recuerda esta liga es de un solo uso e instransferible. 
        Si vuelves a olvidarla. Ingresa a https://kaanbal.net y elige la opción olvidé mi contraseña.";
        $headers = "From:" . $from;
        mail($to,$subject,$cuerpo,$headers);
        //Si no existe, regresar true
        $response['response'] = 'true';
    } else {
        //Si ya existe, regresar que ya existe.
        $response['response'] = 'Usuario NO existe';
    }
}

echo json_encode($response);