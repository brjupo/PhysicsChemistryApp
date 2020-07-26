<?php
$con = mysqli_connect("localhost", "u526597556_dev", "1BLeeAgwq1*isgm&jBJe", "u526597556_kaanbal");

$id_usuario = $_POST["id"];
$acumulador = $_POST["acmldr"];
$flagTipo = $_POST["flagTipo"];


//Tiempo practica particular
if($flagTipo == 'acmlrPP' ){
    //Lanzar consulta para tener el acumulador
  $query2 = "SELECT acmlrPP FROM alumno WHERE id_usuario = $id_usuario"; // WHERE TEMA = 'TEMA' AND SUBTEMA = 'SUBTEMA' AND LECCION = 'LECCION'";
  $result2 = mysqli_query($con, $query2);
  $total = mysqli_fetch_row($result2);

  $acumulador = $acumulador/60;
  $acmlrGral = $total[0] + $acumulador;

  $sql = "UPDATE alumno SET acmlrPP = $acmlrGral WHERE id_usuario = $id_usuario";
  mysqli_query($con, $sql);
  $response["response"] = 'exito';
}

//Tiempo sprint particular
if($flagTipo == 'acmlrSP' ){
  //Lanzar consulta para tener el acumulador SP
  $query2 = "SELECT acmlrSP FROM alumno WHERE id_usuario = $id_usuario"; // WHERE TEMA = 'TEMA' AND SUBTEMA = 'SUBTEMA' AND LECCION = 'LECCION'";
  $result2 = mysqli_query($con, $query2);
  $total = mysqli_fetch_row($result2);
    
  $acumulador = $acumulador/60;
  $acmlrGral = $total[0] + $acumulador;

  $sql = "UPDATE alumno SET acmlrSP = $acmlrGral WHERE id_usuario = $id_usuario";
  mysqli_query($con, $sql);
  $response["response"] = 'exito';
}

//Tiempo examen
if($flagTipo == 'acmlrE' ){
  //Lanzar consulta para tener el acumulador E
  $query2 = "SELECT acmlrE FROM alumno WHERE id_usuario = $id_usuario"; // WHERE TEMA = 'TEMA' AND SUBTEMA = 'SUBTEMA' AND LECCION = 'LECCION'";
  $result2 = mysqli_query($con, $query2);
  $total = mysqli_fetch_row($result2);
    
  $acumulador = $acumulador/60;
  $acmlrGral = $total[0] + $acumulador;

  $sql = "UPDATE alumno SET acmlrE = $acmlrGral WHERE id_usuario = $id_usuario";
  mysqli_query($con, $sql);
  $response["response"] = 'exito';
}

echo json_encode($response);

?>