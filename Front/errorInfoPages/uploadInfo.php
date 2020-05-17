<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="shortcut icon" type="image/x-icon" href="../CSSsJSs/icons/pyramid.svg" />
  <title>Kaanbal</title>
  <link rel="stylesheet" href="../CSSsJSs/bootstrap441.css" />
  <link rel="stylesheet" href="../CSSsJSs/styleUploadInfo.css" />
  <!--script src="../CSSsJSs/scriptUploadOne.js"></script-->
  <script src="../CSSsJSs/minAJAX.js"></script>
</head>

<body>
  <!---CRISTIAN-->
  <!--AGREGAR VALDIACIÓN DE USUARIO TIPO STAFF, POR LO MIENTRAS QUE TENGA USER Y PASS VALIDO-->
  <!--AL FINAL DE LA PÁGINA, ANTES DEL FOOTER AGREGAR UN CODIGO PHP PARA QUE DIBUJE UNA TABLA CON TODOS LOS USUARIOS EN LA BBDD ok--> 
  <!--AGREGAR VALIDACION PARA QUE NO SE SUBAN CORREOS QUE YA EXISTEN OK--> 

  <!--BRANDON-->
  <!--AGREGAR UN BOTON DE LAYOUT PARA DESCARGAR UN EJEMPLO, ACLARAR EN UNA NOTA-->
  <!--AGREGAR CAMPO PARA INGRESAR LA CONTRASEÑA, LIMPIAR ESE VALOR CADA .ONLOAD()--->
  <!--AGREGAR UN FORMATO A LA TABLA PARA QUE SE VEA DESCENTE-->
  <!--AGREGAR BOTON REGRESO Y CREAR UNA VISTA PARA QUE EL STAFF DECIDA SI SUBIR ALUMNOS, PROFESORES O CREAR GRUPOS-->
  <div class="container">
    <div class="row">
      <div class="textCenter col-1 col-sm-1 col-md-1 col-lg-1 col-xl-1"></div>
      <div class="textLeft col-5 col-sm-5 col-md-5 col-lg-5 col-xl-5">
        <p class="titulo" id="titulo">Kaanbal</p>
      </div>
      <div class="textRight col-5 col-sm-5 col-md-5 col-lg-5 col-xl-5"></div>
      <div class="textCenter col-1 col-sm-1 col-md-1 col-lg-1 col-xl-1"></div>
    </div>
  </div>
  <div class="container">
    <div class="row">
      <div class="textCenter col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
        <p style="color: rgba(0, 0, 0, 0);">.</p>
      </div>
    </div>
    <div class="row">
      <div class="textCenter col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
        <p style="color: rgba(0, 0, 0, 0);">.</p>
      </div>
    </div>
  </div>

  <div class="container">
    <div class="row">
      <div class="textCenter col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
        <form class="form-horizontal" action="../../Servicios/subirUsuarios.php" method="post" name="upload_excel" enctype="multipart/form-data">
          <fieldset>
            <!-- Form Name -->
            <legend>Student information upload</legend>
            <!-- File Button -->
            <div class="form-group">
              <label class="control-label" for="filebutton">Select CSV File</label>
              <div class="">
                <input type="file" name="file" id="file" class="input-large">
              </div>
            </div>
            <!-- Button -->
            <div class="form-group">
              <div class="">
                <button type="submit" id="submit" name="Import" class="btn btn-primary button-loading boton2" data-loading-text="Loading...">Import</button>
              </div>
            </div>
          </fieldset>
        </form>
      </div>
    </div>
  </div>

  <div class="container">
    <div class="row">
      <div class="textCenter col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
        <p style="color: rgba(0, 0, 0, 0);">.</p>
      </div>
    </div>
    <div class="row">
      <div class="textCenter col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
        <p style="color: rgba(0, 0, 0, 0);">.</p>
      </div>
    </div>
  </div>

  <?php
///////////////////////////////////////////////MOSTRAR LISTADO DE ALUMOS REGISTRADOS
$con = mysqli_connect("localhost", "u526597556_dev", "1BLeeAgwq1*isgm&jBJe", "u526597556_kaanbal");
//Traer todos los usuarios
$query = "SELECT id_usuario, mail FROM usuario_prueba"; //AND id_pregunta <= 5221WHERE TEMA = 'TEMA' AND SUBTEMA = 'SUBTEMA' AND LECCION = 'LECCION'";     
$result = mysqli_query($con, $query);
//Recorrer el arreglo
while ($row = mysqli_fetch_assoc($result)) {
    $array[] = $row;
}

$tamanho = count($array);

for ($j = 0; $j < $tamanho; $j++) {
//print_r($array[0]["id_usuario"]);
$id = $array[$j]["id_usuario"];
$mails = $array[$j]["mail"];
echo"<table border='1' bordercolor='#3351FF' bgcolor='#3351FF' align='center'>
            <tr>
 	            <td width='50'><input type='text' value='$id' name='nroapto' readonly='true'></td>
				      <td><input type='text' value='$mails' name='cedula' readonly='true'></td>
				   </tr>
                </table><br>";
                $i = $i+1;
}
///////////////////////////////////////////////MOSTRAR LISTADO DE ALUMOS REGISTRADOS
?>


  <div class="foot">
    <div class="container">
      <div class="row">
        <div class="col-4 col-sm-4 col-md-4 col-lg-4 col-xl-4">
          <p class="footSubject">Nosotros</p>
        </div>
        <div class="col-4 col-sm-4 col-md-4 col-lg-4 col-xl-4">
          <p class="footSubject">Ayuda</p>
        </div>
        <div class="col-4 col-sm-4 col-md-4 col-lg-4 col-xl-4">
          <p class="footSubject">Términos</p>
        </div>
      </div>
    </div>
  </div>


</body>

</html>