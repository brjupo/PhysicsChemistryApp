<?php
$con = mysqli_connect("localhost", "u526597556_dev", "1BLeeAgwq1*isgm&jBJe", "u526597556_kaanbal");

$id_usuario = $_POST["id"];
$acumulador = $_POST["acmldr"];
$flagTipo = $_POST["flagTipo"];


//Lanzar consulta para tener el acumulador
$query2 = "SELECT acmlrPP FROM alumno WHERE id_usuario = $id_usuario"; // WHERE TEMA = 'TEMA' AND SUBTEMA = 'SUBTEMA' AND LECCION = 'LECCION'";
        $result2 = mysqli_query($con, $query2);
        $total = mysqli_fetch_row($result2);

        $acumulador = $acumulador/60;
        $acmlrPP = $total[0] + $acumulador;


//Tiempo practica particular
if($flagTipo == 'acmlrPP' ){
  $sql = "UPDATE alumno SET acmlrPP = $acmlrPP WHERE id_usuario = $id_usuario";
  mysqli_query($con, $sql);
  $response["response"] = 'exito';
}

echo json_encode($response);

?>