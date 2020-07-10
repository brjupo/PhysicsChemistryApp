<?php
    //Informacion de la BBDD
    $servername = "localhost";
    $username = "u526597556_dev";
    $password = "1BLeeAgwq1*isgm&jBJe";
    $dbname = "u526597556_kaanbal";

    //Leer las variables del POST
    $leccion = $_POST['leccion'];


    //Crear la lectura en base de datos
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stringQuery="SELECT  tiempo_sprint FROM leccion WHERE id_leccion = '".$leccion."' LIMIT 1;";
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

    ////////////////    
    echo json_encode($response); 
?>



