<?php
//Informacion de la BBDD
$servername = "localhost";
$username = "u526597556_dev";
$password = "1BLeeAgwq1*isgm&jBJe";
$dbname = "u526597556_kaanbal";

//Leer las variables del POST
$IDPregunta = $_POST['IDPregunta'];


//Crear la lectura en base de datos
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stringQuery = "SELECT pregunta, respuesta_correcta, respuesta2, respuesta3, respuesta4, question, correct_answer, answer2, answer3, answer4, tipo FROM pregunta WHERE id_pregunta = '" . $IDPregunta . "' LIMIT 1;";
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
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
$conn = null;

$pathjpg = "../../../../IMAGENES/" . $IDPregunta.".jpg";
$pathpng = "../../../../IMAGENES/" . $IDPregunta.".png";
$pathJPG = "../../../../IMAGENES/" . $IDPregunta.".JPG";
$pathPNG = "../../../../IMAGENES/" . $IDPregunta.".PNG";
$response["image"] = NULL;
if (file_exists($pathjpg)) {
    $response["image"] = $IDPregunta.".jpg";
} else if (file_exists($pathJPG)) {
    $response["image"] = $IDPregunta.".JPG";
} else if (file_exists($pathpng)) {
    $response["image"] = $IDPregunta.".png";
} else if (file_exists($pathPNG)) {
    $response["image"] = $IDPregunta.".PNG";
}

////////////////    
echo json_encode($response);
