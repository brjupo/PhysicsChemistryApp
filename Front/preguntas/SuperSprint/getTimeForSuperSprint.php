<?php
    //Informacion de la BBDD
    $servername = "localhost";
    $username = "u526597556_dev";
    $password = "1BLeeAgwq1*isgm&jBJe";
    $dbname = "u526597556_kaanbal";

    //Leer las variables del POST
    $subtema = $_POST['subtema'];


    //Crear la lectura en base de datos
    /*
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stringQuery="SELECT tiempo_sprint FROM subtema WHERE id_subtema = '".$subtema."' LIMIT 1;";
        $stmt = $conn->query($stringQuery);
        while ($row = $stmt->fetch(PDO::FETCH_NUM)){
            $response["response"] = 'true';
            $response["seconds"] = $row[0];
        }															
    }
    catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    $conn = null;
    */

    $response["response"] = 'true';
    $response["seconds"] = 30;
    ////////////////    
    echo json_encode($response); 
?>



