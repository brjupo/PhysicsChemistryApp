<?php

    $user = 'cristian@c';

    $con = mysqli_connect("localhost", "u526597556_dev", "1BLeeAgwq1*isgm&jBJe", "u526597556_kaanbal");

    $statement = mysqli_prepare($con, "SELECT l.pagado FROM alumno a JOIN usuario_prueba u JOIN licencia l 
      ON a.id_usuario = u.id_usuario AND u.id_usuario = l.id_usuario 
      WHERE l.id_asignatura = 2 AND u.mail = ?");
      mysqli_stmt_bind_param($statement, "s", $user);
      mysqli_stmt_execute($statement);
      mysqli_stmt_store_result($statement);
      mysqli_stmt_bind_result($statement, $pagado);

      $arregloPagado = array();
      while (mysqli_stmt_fetch($statement)) { 
        $arregloPagado["pagado"] = $pagado;
      }
      $aux = $arregloPagado["pagado"];

 
     print_r($aux);

?>
