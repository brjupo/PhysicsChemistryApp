<?php
require "../../../servicios/00DDBBVariables.php";

//Leer las variables del POST
$IDPregunta = $_POST['IDPregunta'];


//Crear la lectura en base de datos
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stringQuery = "SELECT pregunta, respuesta_correcta, respuesta2, respuesta3, respuesta4, question, correct_answer, answer2, answer3, answer4, tipo, idImagen FROM pregunta WHERE id_pregunta = '" . $IDPregunta . "' LIMIT 1;";
    $stmt = $conn->query($stringQuery);
    while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
        $response["response"] = 'exito';
        $response["pregunta"] = $row[0];
        $response["respuesta_correcta"] = $row[1];
        $response["respuesta2"] = $row[2];
        $response["respuesta3"] = $row[3];
        $response["respuesta4"] = $row[4];
        $response["question"] = $row[5];
        $response["correct_answer"] = $row[6];
        $response["answer2"] = $row[7];
        $response["answer3"] = $row[8];
        $response["answer4"] = $row[9];
        $response["tipo"] = $row[10];
        $response["idImagen"] = $row[11];
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
$conn = null;

////////////////    
echo json_encode($response);
