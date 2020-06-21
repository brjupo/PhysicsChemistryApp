<?php


if (isset($_POST["Import"])) {

  $con = mysqli_connect("localhost", "u526597556_dev", "1BLeeAgwq1*isgm&jBJe", "u526597556_kaanbal");

  $filename = $_FILES["file"]["tmp_name"];
  $tipo = filetype($filename);
  echo '<script type="text/javascript">
           alert("'.$tipo.'");
           </script>';
  
  if ($_FILES["file"]["size"] > 0) {
    $file = fopen($filename, "r");
    while (($getData = fgetcsv($file, 10000, ",")) !== FALSE) {
      
      $mailr = $getData[0]."@itesm.mx";
      /* echo "<script type=\"text/javascript\">
              alert(\"".$mailr."\");
              </script>"; */

      //Corroborar que no existe el correo en base de datos
      $sql = "SELECT mail FROM usuario_prueba WHERE mail = '$mailr'";
      $resultp = mysqli_query($con, $sql);
      $rowp = mysqli_fetch_array($resultp);
         //$rowp
      if (FALSE) {

        if (!isset($rowp)) {
          echo "<script type=\"text/javascript\">
                alert(\"Invalid File:Please Upload CSV File.\");
                window.location = \"../Front/errorInfoPages/uploadInfo.php\"
                </script>";
        } else {
          echo "<script type=\"text/javascript\">
              alert(\"CSV File has been successfully Imported.\");
              window.location = \"../Front/errorInfoPages/uploadInfo.php\"
            </script>";
        }

      }else{

      /* $sql = "INSERT into usuario_prueba (mail,pswd) 
                   values ('" . $getData[0] . "@itesm.mx','" . $getData[1] . "')";
      $result = mysqli_query($con, $sql);
      if (!isset($result)) {
        echo "<script type=\"text/javascript\">
              alert(\"Invalid File:Please Upload CSV File.\");
              window.location = \"../Front/errorInfoPages/uploadInfo.php\"
              </script>";
      } else {
        echo "<script type=\"text/javascript\">
            alert(\"CSV File has been successfully Imported.\");
            window.location = \"../Front/errorInfoPages/uploadInfo.php\"
          </script>";
      } */

      // $sql = "INSERT into alumno (id_usuario,matricula) 
      //              values ('" . $getData[0] ."','" . $getData[1] . "')";
                   $sql = "INSERT into test (id_alumno,id_grupo) 
                   values ('" . $getData[0] ."','" . $getData[1] . "')";
      $result = mysqli_query($con, $sql);
      if (!isset($result)) {
        echo "<script type=\"text/javascript\">
              alert(\"Invalid File:Please Upload CSV File.\");
              window.location = \"../Front/errorInfoPages/uploadInfo.php\"
              </script>";
      } else {
        echo "<script type=\"text/javascript\">
            alert(\"CSV File has been successfully Imported.\");
            window.location = \"../Front/errorInfoPages/uploadInfo.php\"
          </script>";
      }
    }
    }

    fclose($file);
  }
}
