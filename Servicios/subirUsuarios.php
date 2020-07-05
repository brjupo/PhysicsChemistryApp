<?php

$con = mysqli_connect("localhost", "u526597556_dev", "1BLeeAgwq1*isgm&jBJe", "u526597556_kaanbal");
//traer el último id
 $query = "SELECT MAX(id_usuario) FROM usuario_prueba"; // WHERE TEMA = 'TEMA' AND SUBTEMA = 'SUBTEMA' AND LECCION = 'LECCION'";
        $result= mysqli_query($con, $query);
        $lastId = mysqli_fetch_row($result); 

        $ultimoId = $lastId[0];

if (isset($_POST["Import"])) {

  $filename = $_FILES["file"]["name"];

  $formatos_permitidos =  array('csv');
  //$archivo = $_FILES['doc_file']['name'];
  $extension = pathinfo($filename, PATHINFO_EXTENSION);
  if(!in_array($extension, $formatos_permitidos) ) {
      echo '<script type="text/javascript">
           alert("Formato de archivo no permitido");
           window.location = \"../Front/errorInfoPages/uploadInfo.php"
           </script>'; 
  }else{
 /*  echo '<script type="text/javascript">
           alert("'.$filename.'");
           </script>'; */
  
  $filename = $_FILES["file"]["tmp_name"];

  if ($_FILES["file"]["size"] > 0) {
    $file = fopen($filename, "r");
    while (($getData = fgetcsv($file, 10000, ",")) !== FALSE) {
      
      $mailr = $getData[0];
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

        $ultimoId += 1;

        //tabla usuario_prueba (mail, password, idioma)
      $sql = "INSERT into usuario_prueba (mail,pswd,idioma) 
                   values ('" . $getData[0] . "','" . $getData[1] . "','" . $getData[2] . "')";
      $result = mysqli_query($con, $sql);

        //tabla alumno (id_usuario,matricula(mail))
      $sql = "INSERT into alumno (id_usuario,matricula) 
                   values ($ultimoId,'" . $getData[0] . "')";
      $result = mysqli_query($con, $sql);

      //tabla licencia (id_usuario,id_asignatura,codigo,autorizacion,activacion,vigenvia,estatus)
      $sql = "INSERT into licencia (id_usuario,id_asignatura,codigo,autorizacion,activacion,vigencia,estatus) 
                   values ($ultimoId,'" . $getData[3] . "',$ultimoId,$ultimoId,$ultimoId,'2020-12-31 12:00:00',1)";
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

      // $sql = "INSERT into alumno (id_usuario,matricula) 
      //              values ('" . $getData[0] ."','" . $getData[1] . "')";
       /*             $sql = "INSERT into test (id_alumno,id_grupo) 
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
      } */
    }
    }

    fclose($file);
  }
}
}
