<?php
  $con = mysqli_connect("localhost", "u526597556_dev", "1BLeeAgwq1*isgm&jBJe", "u526597556_kaanbal");

  session_start();

  $iduser = $_SESSION["id_usuario"];

  $sql = "UPDATE alumno SET avatar='$avatar' WHERE id_usuario = $iduser";
  mysqli_query($con, $sql);


  $query = "SELECT mail FROM usuario_prueba WHERE id_usuario = $iduser"; 
  $result = mysqli_query($con, $query);
  while ($row = mysqli_fetch_assoc($result)) {
    $mailArray[] = $row;}
  $mail = $mailArray[0]["mail"];//De aqui se obtendra la matricula del usuario

  //Obtener el porcentaje completado total de la asignatura de práctica general (PG) de la lección:
    $statement = mysqli_prepare($con, "SELECT ((SELECT COUNT(*) FROM puntuacion WHERE id_usuario = [ID DEL USUARIO QUE INICIO SESIÓN] AND id_leccion IN (SELECT id_leccion FROM leccion WHERE id_subtema IN (SELECT id_subtema FROM subtema WHERE id_tema IN (SELECT id_tema FROM tema WHERE id_asignatura = [ID DE LA ASIGNATURA ACTUAL]))) AND tipo = 'PG' * 100) / (SELECT COUNT(*) FROM leccion WHERE id_subtema IN (SELECT id_subtema FROM subtema WHERE id_tema IN (SELECT id_tema FROM tema WHERE id_asignatura = [ID DE LA ASIGNATURA ACTUAL]))))");
    //[ID DEL USUARIO QUE INICIO SESIÓN]
    //[ID DEL USUARIO QUE INICIO SESIÓN]
    //[ID DEL USUARIO QUE INICIO SESIÓN]
    mysqli_stmt_bind_param($statement, "iii", $_SESSION["id_usuario"]);
    mysqli_stmt_execute($statement);
    mysqli_stmt_store_result($statement);
    mysqli_stmt_bind_result($statement, $id_asignatura, $nombre, $nivel, $grado_academico, $idioma);

    $arregloAsignaturas = array();

    $i = 0;
    while (mysqli_stmt_fetch($statement)) {
      $arregloAsignaturas[$i]["id_asignatura"] = $id_asignatura;
      $arregloAsignaturas[$i]["nombre"] = $nombre;
      $arregloAsignaturas[$i]["nivel"] = $nivel;
      $arregloAsignaturas[$i]["grado_academico"] = $grado_academico;
      $arregloAsignaturas[$i]["idioma"] = $idioma;
      $i = $i + 1;
    }


  

?>