<?php
$con = mysqli_connect("localhost", "u526597556_dev", "1BLeeAgwq1*isgm&jBJe", "u526597556_kaanbal");

$id_usuario = $_POST["id"];
$leccion = $_POST["leccion"];
$puntosNuevos = $_POST["puntos"];
$flagTipo = $_POST["flagTipo"];

$tiempo = getDatetimeNow();

/////Establecer uso horario para el envio de fecha y hora
function getDatetimeNow() {
  $tz_object = new DateTimeZone('America/Mexico_City');

  $datetime = new DateTime();
  $datetime->setTimezone($tz_object);
  return $datetime->format('Y\-m\-d\ H:i:s');
}
//////////////////////

//Lanzar consulta para saber si existe calificacion y la trae
$statement = mysqli_prepare($con, "SELECT puntuacion FROM puntuacion WHERE id_leccion = ? AND id_usuario = ? AND tipo = ?");
mysqli_stmt_bind_param($statement, "sss", $leccion, $id_usuario, $flagTipo);
mysqli_stmt_execute($statement);
mysqli_stmt_store_result($statement);
mysqli_stmt_bind_result($statement, $puntuacion);

$puntosActuales = 'xxx';

$response["response"] = 'fail';
//Leemos la calificacion 
while (mysqli_stmt_fetch($statement)) { //si si existe 
  $puntosActuales = $puntuacion;
}

//print_r($puntosActuales);

if (1) { //$puntosNuevos > $puntosActuales validamos que exista una calificacion $puntosActuales != NULL or $puntosActuales == 0  $puntosActuales != 'xxx' OR $puntosActuales == NULL
  if (1) {
    //Lanzar consulta para actualizar calificacion solo si es mayor
    $sql = "UPDATE puntuacion SET puntuacion = $puntosNuevos, tiempo = $tiempo WHERE id_leccion = $leccion AND id_usuario = $id_usuario AND tipo = '$flagTipo'";
    mysqli_query($con, $sql);
  }
  $response["response"] = 'exito';
} else {
  $sql = "INSERT INTO puntuacion(id_usuario, id_leccion, puntuacion, tipo, tiempo) VALUES ('$id_usuario', '$leccion', '$puntosNuevos','$flagTipo','$tiempo')";
  mysqli_query($con, $sql);
  $response["response"] = 'exito';
}

echo json_encode($response);

?>