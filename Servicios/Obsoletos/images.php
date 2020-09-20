<?php
require "DDBBVariables.php";
echo "Hi";
//Leer las variables del POST
$inicio = $_POST['inicio'];
$fin = $_POST['fin'];

echo "Keep going";
//Crear la lectura en base de datos
//Leer los IDs de las preguntas [inicio a fin]
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stringQuery = "SELECT id_pregunta FROM pregunta WHERE id_pregunta > " . $inicio . " AND id_pregunta < " . $fin;
    $stmt = $conn->query($stringQuery);
    while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
        //$row[0];
        $idPregunta = $row[0];
        echo $idPregunta;
        findImage($idPregunta);
    }
} catch (PDOException $e) {
    echo "Error al " . $stringQuery . "<br>" . $e->getMessage();
}
$conn = null;


function findImage($IDPregunta)
{
    $pathjpg = "../../../../IMAGENES/" . $IDPregunta . ".jpg";
    $pathpng = "../../../../IMAGENES/" . $IDPregunta . ".png";
    $pathJPG = "../../../../IMAGENES/" . $IDPregunta . ".JPG";
    $pathPNG = "../../../../IMAGENES/" . $IDPregunta . ".PNG";
    $imageName = NULL;
    if (file_exists($pathjpg)) {
        $imageName = $IDPregunta . ".jpg";
    } else if (file_exists($pathJPG)) {
        $imageName = $IDPregunta . ".JPG";
    } else if (file_exists($pathpng)) {
        $imageName = $IDPregunta . ".png";
    } else if (file_exists($pathPNG)) {
        $imageName = $IDPregunta . ".PNG";
    }

    if(!is_null($imageName)){
        setIDinDDBB($imageName);
    }
}

function setIDinDDBB($imageName)
{
    global $servername, $username, $password, $dbname;
    //Crear la escritura en base de datos
    try {
        $conn2 = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        // set the PDO error mode to exception
        $conn2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        //INSERT INTO MyGuests (firstname, lastname, email) VALUES ('John', 'Doe', 'john@example.com')
        //UPDATE Customers SET ContactName = 'Alfred Schmidt', City= 'Frankfurt' WHERE CustomerID = 1
        $sql2 = "UPDATE pregunta SET idImagen = " . $imageName;
        // use exec() because no results are returned
        $conn2->exec($sql2);
        //$response["response"] = 'exito';
    } catch (PDOException $e) {
        echo "Error al " . $sql2 . "<br>" . $e->getMessage();
    }

    $conn2 = null;
}
