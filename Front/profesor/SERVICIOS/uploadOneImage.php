<?php
require "../../../servicios/DDBBVariables.php";


function get_extension($file) {
    $tmp =explode(".", $file);
    $extension = end($tmp);
    return $extension ? $extension : false;
}
if(empty($_POST['path']) || empty($_POST['idPregunta']) ){
    $response["response"] = 'Algo esta vacio';
}
else{
    //----Path where we want to save it
    $target_dir = $_POST['path'];
    //----Name of the DataBase Field/Column
    $idPregunta = $_POST['idPregunta'];

    if(is_dir($target_dir)==false){
        $response["response"] = 'El directorio NO existe. Revisa la variable path del JS';
    }
    //----Add datetime to the name of the new image
    $fecha = getdate();
    $target_name = $idPregunta . "_" . $fecha[0] . "." . get_extension(basename($_FILES["fileToUpload"]["name"]));
    //$target_name = $idPregunta . "_" . $fecha[0] . ".jpg";

    //----Verify if the idPregunta exist in DDBB, if not exist, ERROR
    $exist=0;
    try {
		$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$stringQuery="SELECT id_pregunta FROM pregunta WHERE id_pregunta = " . $idPregunta;
		$stmt = $conn->query($stringQuery);
		while ($row = $stmt->fetch(PDO::FETCH_NUM)){
            $exist=1;
		}
	}
	catch(PDOException $e) {
		echo "Error: " . $e->getMessage();
	}
    $conn = null;

    //----Get previous image. Delete it.
    $fileToDelete = NULL;
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stringQuery="SELECT idImagen FROM pregunta WHERE id_pregunta = " . $idPregunta;
        $stmt = $conn->query($stringQuery);
        while ($row = $stmt->fetch(PDO::FETCH_NUM)){
            $fileToDelete=$row[0];
        }
    }
    catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    $conn = null;

    if(!is_null($fileToDelete)){
        // Check if file exists, if exist then delete it
        $target_fileToDelete = $target_dir . $fileToDelete;
        $response["targetFile"] = $target_fileToDelete;
        $response["borrado"] = "no";
        if (file_exists($target_fileToDelete) && $target_dir!=$target_fileToDelete) {
            $response["borrado"] = "deberia";
            unlink($target_fileToDelete);
        }
    }
    

    //------Save the image, if saved then set the name in DDBB    
    $target_file = $target_dir . $target_name;
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        //----Write to DDBB the name of the new image
        try {
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            //INSERT INTO MyGuests (firstname, lastname, email) VALUES ('John', 'Doe', 'john@example.com')
            //UPDATE Customers SET ContactName = 'Alfred Schmidt', City= 'Frankfurt' WHERE CustomerID = 1
            $sql = "UPDATE pregunta SET idImagen = '".$target_name."' WHERE id_pregunta = " . $idPregunta;
            // use exec() because no results are returned
            $conn->exec($sql);
            $response["response"] = 'exito';
            //$response["response"] = $sql;
        } catch(PDOException $e) {
            $response["response"] = $sql . "<br>" . $e->getMessage();
        }
        
        $conn = null;
    } else {
        $response["response"] = 'Error al copiar a la carpeta del servidor';
    }
    
}
////////////////    
echo json_encode($response); 
?>