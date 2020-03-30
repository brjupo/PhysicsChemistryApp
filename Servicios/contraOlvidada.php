<?php
$con = mysqli_connect("localhost", "u526597556_dev", "1BLeeAgwq1*isgm&jBJe", "u526597556_kaanbal");


$correo_e = $_POST["correo_e"];


$sql = "SELECT mail FROM usuario_prueba WHERE mail = '$correo_e'";
$resultp = mysqli_query($con, $sql);
$rowp = mysqli_fetch_array($resultp);

if ($correo_e == "" or $correo_e == NULL) {
    $response = array();
    $response['response'] = 'Ingresa un correo!';
    echo json_encode($response);
} else {
    if ($rowp) {
        //Es hora de cambiar el token   |  Creamos un token random
        $rand = bin2hex(random_bytes(5));
        //Agregar a la base de datos
        $sql = "INSERT INTO usuario_prueba(mail, tokenA) VALUES ('$correo_e', '$rand')";
        mysqli_query($con, $sql);
        //Enviar correo a usuario para que genere su contrasenia
        //mail(correo,asunto,cuerpo);
        $cuerpo = "Hola! En la siguiente liga podrás cambiar tu contraseña.\n 
                    https://kaanbal.net/Front/errorInfoPages/password.php?token=" .
            $rand . "&correo=" . $correo_e . " \n" .
            "Recuerda, esta liga es de un solo uso e instransferible. \n
                    Si vuelves a olvidarla. Ingresa a https://kaanbal.net y 
                    elige la opción olvidé mi contraseña.";
        mail($correo_e, "Kaanbal - Password", $cuerpo);
        //Si no existe, regresar true
        $response = array();
        $response['response'] = 'true';
        echo json_encode($response);
    } else {
        //Si ya existe, regresar que ya existe.
        $response = array();
        $response['response'] = 'Usuario NO existe';
        echo json_encode($response);
    }
}
