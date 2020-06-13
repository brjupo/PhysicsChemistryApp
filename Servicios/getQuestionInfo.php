<?php
    //Informacion de la BBDD
    $servername = "localhost";
    $username = "u526597556_dev";
    $password = "1BLeeAgwq1*isgm&jBJe";
    $dbname = "u526597556_kaanbal";

    //Iniciar variables del POST
    /*
    $serviceID = "";
    $ioe = "";
    $nombreIOE = "";
    $tipoIOE = "";
    $descripcionIOE = "";
    */
    //Leer las variables del POST
    $leccion = $_POST['leccion'];
    $numeroPregunta = $_POST['numeroPregunta'];


    //Crear la lectura en base de datos
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stringQuery="SELECT pregunta, respuesta_correcta, respuesta2, respuesta3, respuesta4, tipo FROM pregunta WHERE id_leccion = '".$leccion."' AND orden = '".$numeroPregunta."' LIMIT 1;";
        $stmt = $conn->query($stringQuery);
        while ($row = $stmt->fetch(PDO::FETCH_NUM)){
            $response["response"] = 'exito';
            $response["pregunta"] = $row[0];
            $response["respuesta_correcta"] = $row[1];
            $response["respuesta2"] = $row[2];
            $response["respuesta3"] = $row[3];
            $response["respuesta4"] = $row[4];
            $response["tipo"] = $row[5];
        }															
    }
    catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    $conn = null;

    ////////////////    
    echo json_encode($response); 
?>



