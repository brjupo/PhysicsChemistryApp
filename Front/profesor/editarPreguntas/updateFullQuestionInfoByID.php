<?php
    //Informacion de la BBDD
    $servername = "localhost";
    $username = "u526597556_dev";
    $password = "1BLeeAgwq1*isgm&jBJe";
    $dbname = "u526597556_kaanbal";

    //Leer las variables del POST
    $IDPregunta = $_POST['IDPregunta'];
    $pregunta = $_POST['pregunta'];
    $respuesta_correcta = $_POST['respuesta_correcta'];
    $respuesta2 = $_POST['respuesta2'];
    $respuesta3 = $_POST['respuesta3'];
    $respuesta4 = $_POST['respuesta4'];
    $question = $_POST['question'];
    $correct_answer = $_POST['correct_answer'];
    $answer2 = $_POST['answer2'];
    $answer3 = $_POST['answer3'];
    $answer4 = $_POST['answer4'];
    $tipo = $_POST['tipo'];

    //Crear la escritura en base de datos
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        //INSERT INTO MyGuests (firstname, lastname, email) VALUES ('John', 'Doe', 'john@example.com')
        //UPDATE Customers SET ContactName = 'Alfred Schmidt', City= 'Frankfurt' WHERE CustomerID = 1
        $sql = "UPDATE pregunta SET pregunta = '".$pregunta."', respuesta_correcta = '".$respuesta_correcta."', respuesta2 = '".$respuesta2."', respuesta3 = '".$respuesta3."', respuesta4 = '".$respuesta4."', question = '".$question."', correct_answer = '".$correct_answer."', answer2 = '".$answer2."', answer3 = '".$answer3."', answer4 = '".$answer4."', tipo = '".$tipo."' WHERE id_pregunta = '".$IDPregunta."'";
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
?>



