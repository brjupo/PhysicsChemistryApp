<?php
function get_extension($file) {
    $tmp =explode(".", $file);
    $extension = end($tmp);
    return $extension ? $extension : false;
}


$target_dir = $_POST['path'];
$target_name = $_POST['name'];

$target_file = $target_dir . $target_name . "." . get_extension(basename($_FILES["fileToUpload"]["name"]));

if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
    //echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
    $response["response"] = 'exito';
} else {
    //echo "Sorry, there was an error uploading your file.";
    $response["response"] = 'Error al copiar a la carpeta del servidor';
}

////////////////    
echo json_encode($response); 


?>