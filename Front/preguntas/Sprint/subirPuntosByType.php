<?php
//Informacion de la BBDD
$servername = "localhost";
$username = "u526597556_dev";
$password = "1BLeeAgwq1*isgm&jBJe";
$dbname = "u526597556_kaanbal";

$id_usuario = $_POST["id"];
$leccion = $_POST["leccion"];
$puntosNuevos = $_POST["puntos"];
$flagTipo = $_POST["flagTipo"];

//Lanzar consulta para saber si existe calificacion y la trae
try {
  $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $stringQuery = "SELECT puntuacion FROM puntuacion WHERE id_leccion = '" . $leccion . "' AND id_usuario = '" . $id_usuario . "' AND tipo = '" . $flagTipo . "' LIMIT 1;";
  $stmt = $conn->query($stringQuery);
  while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
    //Leemos la calificacion 
    echo  $row[0];
    $puntosActuales = $row[0];
  }
} catch (PDOException $e) {
  echo "Error: " . $e->getMessage();
}
$conn = null;

//echo $puntosActuales;
//echo $puntosNuevos;
$response["response"] = 'failed';
if (is_null($puntosActuales)) {
  $sql = "INSERT INTO puntuacion(id_usuario, id_leccion, puntuacion, tipo) VALUES ($id_usuario, $leccion, $puntosNuevos,'$flagTipo')";
  mysqli_query($con, $sql);
  //$response["response"] = 'exito';
} 
else if ($puntosNuevos > $puntosActuales) {
    //Lanzar consulta para actualizar calificacion solo si es mayor
    $sql = "UPDATE puntuacion SET puntuacion = $puntosNuevos WHERE id_leccion = $leccion AND id_usuario = $id_usuario AND tipo = '$flagTipo'";
    mysqli_query($con, $sql);
    //$response["response"] = 'exito'; 
}
else if($puntosNuevos <= $puntosActuales){
  //$response["response"] = 'exito'; 
}
echo json_encode($response);
