<?php
    //Informacion de la BBDD
    $servername = "localhost";
    $username = "u526597556_dev";
    $password = "1BLeeAgwq1*isgm&jBJe";
    $dbname = "u526597556_kaanbal";

    //Leer las variables del POST
    $id_leccion = $_POST['id_leccion'];
    $nuevaPregunta = $_POST['nuevaPregunta'];

    //Crear la escritura en base de datos
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        //INSERT INTO MyGuests (firstname, lastname, email) VALUES ('John', 'Doe', 'john@example.com')
        //UPDATE Customers SET ContactName = 'Alfred Schmidt', City= 'Frankfurt' WHERE CustomerID = 1
        $sql = "INSERT INTO pregunta (id_leccion, pregunta) VALUES ('".$id_leccion."', '".$nuevaPregunta."')";
        // use exec() because no results are returned
        $conn->exec($sql);
        $response["response"] = 'exito';
        //$response["response"] = $sql;
      } catch(PDOException $e) {
        $response["response"] = $sql . "<br>" . $e->getMessage();
      }
      
      $conn = null;
    ////////////////    
    echo json_encode($response);
