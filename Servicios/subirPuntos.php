<?php
    $con = mysqli_connect("localhost", "u526597556_dev", "1BLeeAgwq1*isgm&jBJe", "u526597556_kaanbal");

    $id = $_POST["id"];
    $leccion = $_POST["leccion"];
    $puntos = $_POST["puntos"];
    
    //Lanzar consulta para actualizar calificacion
    $sql = "UPDATE puntuacion SET puntuacion = '7 WHERE id_leccion = 1 AND id_licencia = 4";
    mysqli_query($con,$sql);
    
    $response["response"] = 'exito';
            
            echo json_encode($response);   

    
            
    //SELECT puntuacion FROM puntuacion WHERE id_leccion = 1 AND id_licencia = (SELECT id_licencia FROM licencia WHERE id_usuario = 4 and vigencia > NOW());

    //UPDATE puntuacion SET puntuacion = 78768 WHERE id_puntuacion = (SELECT id_puntuacion FROM puntuacion WHERE id_leccion = 1 AND id_licencia = (SELECT id_licencia FROM licencia WHERE id_usuario = 4 and vigencia > NOW()));
   
    /* $sql = "SELECT mail FROM usuario_prueba WHERE mail = '$correo'";
    $resultp = mysqli_query($con,$sql);
    $rowp = mysqli_fetch_array($resultp);
    
    if($rowp){
        

        //Si existe registrar contraseña en base de datos y responder true
        $sql = "UPDATE usuario_prueba SET pswd='$password' WHERE mail = '$correo'";
        mysqli_query($con,$sql); */

?>