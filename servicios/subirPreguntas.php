<?php

if (isset($_POST["Import"])) {

  $con = mysqli_connect("localhost", "u526597556_dev", "1BLeeAgwq1*isgm&jBJe", "u526597556_kaanbal");

  $filename = $_FILES["file"]["tmp_name"];
  if ($_FILES["file"]["size"] > 0) {
    $file = fopen($filename, "r");
    while (($getData = fgetcsv($file, 10000, ",")) !== FALSE) {
      
      /* echo "<script type=\"text/javascript\">
              alert(\"".$mailr."\");
              </script>"; */
              //$idp = $getData[0];

              //Corroborar que no existe el id de pregunta en base de datos
      $sql = "SELECT pregunta FROM pregunta WHERE id_pregunta = '$idp'";
      $resultp = mysqli_query($con, $sql);
      $rowp = mysqli_fetch_array($resultp);
         
       if (!isset($rowp)) {
            $sql = "INSERT into pregunta (id_pregunta, id_autor, id_leccion, orden, pregunta, respuesta_correcta, respuesta2, respuesta3, respuesta4, tipo, estatus, tiene_imagen) 
            values ('" . $getData[0] ."','" . $getData[1] . "','" . $getData[2] ."','" . $getData[3] ."','" . $getData[4] ."','" . $getData[5] ."','" . $getData[6] ."','" . $getData[7] ."','" . $getData[8] ."','" . $getData[9] ."','" . $getData[10] ."','" . $getData[11] ."')";
            $result = mysqli_query($con, $sql);
            if (!isset($result)) {
            echo "<script type=\"text/javascript\">
              alert(\"Archivo no valido: Por favor carga un archivo CSV.\");
              window.location = \"../Front/errorInfoPages/uploadPreguntas.php\"
              </script>";
            } else {
            echo "<script type=\"text/javascript\">
            alert(\"Las preguntas se han cargado correctamente.\");
            window.location = \"../Front/errorInfoPages/uploadPreguntas.php\"
            </script>";
            }
      } 
    }

    fclose($file);
  }
}
