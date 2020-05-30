<?php
  $con = mysqli_connect("localhost", "u526597556_dev", "1BLeeAgwq1*isgm&jBJe", "u526597556_kaanbal");

  session_start();

  $iduser = $_SESSION["id_usuario"];

  //Obtener el top 5 de alumnos con mayor puntuación
    $statement = mysqli_prepare($con, "SELECT * FROM alumno a INNER JOIN (SELECT id_usuario, SUM(puntuacion) AS suma FROM puntuacion WHERE id_leccion IN (SELECT id_leccion FROM leccion WHERE id_subtema IN (SELECT id_subtema FROM subtema WHERE id_tema IN (SELECT id_tema FROM tema WHERE id_asignatura = ?))) GROUP BY id_usuario ORDER BY suma DESC LIMIT 5) p ON a.id_usuario = p.id_usuario WHERE a.id_usuario IN (SELECT id_usuario FROM licencia WHERE vigencia >= NOW() AND estatus = 1)");
    //[ID DE LA ASIGNATURA ACTUAL]
    mysqli_stmt_bind_param($statement, "i", $_SESSION["id_usuario"]);
    mysqli_stmt_execute($statement);
    mysqli_stmt_store_result($statement);
    mysqli_stmt_bind_result($statement, $id_alumno, $id_usuario, $matricula, $avatar);

    $arregloTopUsuarios = array();

    $i = 0;
    while (mysqli_stmt_fetch($statement)) {
      $arregloAsignaturas[$i]["id_alumno"] = $id_alumno;
      $arregloAsignaturas[$i]["id_usuario"] = $id_usuario;
      $arregloAsignaturas[$i]["matricula"] = $matricula;
      $arregloAsignaturas[$i]["avatar"] = $avatar;
      $i = $i + 1;
    }

?>