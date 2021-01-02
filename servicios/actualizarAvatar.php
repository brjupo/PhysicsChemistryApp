<?php
require "00DDBBVariables.php";

$con = mysqli_connect($servername, $username, $password, $dbname);
  $matricula = $_POST["matricula"];
  $avatar = $_POST["avatar"];

  //$matricula .= "@itesm.mx";//se completa matricula con correo

  $sql = "UPDATE alumno SET avatar = '$avatar' WHERE matricula = '$matricula'";
  mysqli_query($con, $sql);

  $response = array();
  $response['response'] = 'exito';
  echo json_encode($response);

?>