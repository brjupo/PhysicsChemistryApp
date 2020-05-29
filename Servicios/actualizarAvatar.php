<?php
  $con = mysqli_connect("localhost", "u526597556_dev", "1BLeeAgwq1*isgm&jBJe", "u526597556_kaanbal");

  $matricula = $_POST["matricula"];
  $avatar = $_POST["avatar"];

  $sql = "UPDATE alumno SET avatar=$avatar WHERE matricula = $matricula";
  mysqli_query($con, $sql);

  $response = array();
  $response['response'] = 'exito';
  echo json_encode($response);

?>