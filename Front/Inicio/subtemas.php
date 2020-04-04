<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="shortcut icon" type="image/x-icon" href="../CSSsJSs/icons/pyramid.svg" />
  <title>Subtemas</title>
  <link rel="stylesheet" href="../CSSsJSs/bootstrap341.css" />
  <link rel="stylesheet" href="../CSSsJSs/styleLecciones.css" />
  <script src="../CSSsJSs/scriptLecciones.js"></script>
</head>

<body>

<?php
    $servername = "localhost";
    $username = "u526597556_dev";
    $password = "1BLeeAgwq1*isgm&jBJe";
    $dbname = "u526597556_kaanbal";
?>

<?php
session_start();
echo'<script type="text/javascript">
alert("'.$_SESSION["mail"].$_SESSION["pswd"].$_SESSION["tokenSesion"].'");
</script>';
//$con = mysqli_connect("localhost", "u526597556_dev", "1BLeeAgwq1*isgm&jBJe", "u526597556_kaanbal");
$stringQuery = "SELECT mail FROM usuario_prueba WHERE mail = '" . $_SESSION["mail"] . "' AND pswd = '" . $_SESSION["pswd"] . "' AND tokenSesion = '" . $_SESSION["tokenSesion"] . "'";
//$result = mysqli_query($con,$stringQuery);
//$rowp = mysqli_fetch_array($result);
  
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $conn->query($stringQuery);
    while ($row = $stmt->fetch(PDO::FETCH_NUM)){
      print "<p>$row[0]</p>\n";
    }
}
catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
$conn = null;
                
if($rowp){
  echo'<script type="text/javascript">
  alert("'.$_SESSION["mail"].$_SESSION["pswd"].$_SESSION["tokenSesion"].'");
  </script>';
  imprimirSubtemas();

}
else{
  echo'<script type="text/javascript">
  alert("Nel");
  window.location.href="https://kaanbal.net";
  </script>';
}

?>

<?php
function imprimirSubtemas(){
  echo '
  <!----------------------------------------------TITULO--------------------------------------------->
  <div class="top">
    <div class="container">
      <div class="row titulo">
        <div class="textCenter col-xs-1 col-sm-1 col-md-1 col-lg-1 col-xl-1">
          <a href="temas.php"><img class="iconoBack" src="../CSSsJSs/icons/FlechaIzq.svg" /></a>
        </div>
        <div class="textCenter col-xs-11 col-sm-11 col-md-11 col-lg-11 col-xl-11">
          <p class="Materia fuenteTitulo">Notación científica</p>
        </div>
      </div>
    </div>
  </div>
  <!------------------------------------------------FIN TITULO----------------------------------------------->

  <div class="container ">
    <div class="row">
      <p class="relleno">.</p>
    </div>
    <div class="row">
      <p class="relleno">.</p>
    </div>
  </div>
  <!----------------------------------------------SUBTEMAS--------------------------------------------->
  <div class="container">
    <div id="seccion0" class="row">
      <div class="textCenter col-xs-0 col-sm-0 col-md-1 col-lg-2 col-xl-2"></div>

      <div class="temaPrincipal1 textCenter col-xs-12 col-sm-12 col-md-10 col-lg-8 col-xl-8">
        <table class="table">
          <tbody>
            <tr>
              <td width="6%">
                <img class="../CSSsJSs/iconsNumber" src="../CSSsJSs/icons/one.svg" />
              </td>
              <td width="58%" class="tituloTemasPrincipales">
                Identificar triángulos rectángulos
              </td>
              <!--td width="5%" rowspan="2" class="separadorTemasPrincipales">|</td-->

              <td width="12%">
                <a href="preguntas/preguntaSprint.html"><img class="iconsActive" src="../CSSsJSs/icons/lecciones.svg" /></a>
              </td>
              <td width="12%">
                <img class="icons" src="../CSSsJSs/icons/run.svg" />
              </td>
              <td width="12%">
                <img class="icons" src="../CSSsJSs/icons/FlechaIzq.svg" />
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <div class="textCenter col-xs-0 col-sm-0 col-md-1 col-lg-2 col-xl-2"></div>
    </div>
  </div>

  <div class="container">
    <div class="row">
      <p></p>
    </div>
  </div>

  <div class="container">
    <div id="seccion1" class="row">
      <div class="textCenter col-xs-0 col-sm-0 col-md-1 col-lg-2 col-xl-2"></div>

      <div class="temaPrincipal1 textCenter col-xs-12 col-sm-12 col-md-10 col-lg-8 col-xl-8">
        <table class="table">
          <tbody>
            <tr>
              <td width="6%">
                <img class="../CSSsJSs/iconsNumber" src="../CSSsJSs/icons/one.svg" />
              </td>
              <td width="58%" class="tituloTemasPrincipales">
                Identificar triángulos rectángulos
              </td>
              <!--td width="5%" rowspan="2" class="separadorTemasPrincipales">|</td-->

              <td width="12%">
                <a href="preguntas/preguntaSprint.html"><img class="iconsActive" src="../CSSsJSs/icons/lecciones.svg" /></a>
              </td>
              <td width="12%">
                <a href="preguntas/preguntaSprint.html"><img class="iconsActive" src="../CSSsJSs/icons/run.svg" /></a>
              </td>
              <td width="12%">
                <img class="icons" src="../CSSsJSs/icons/FlechaIzq.svg" />
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <div class="textCenter col-xs-0 col-sm-0 col-md-1 col-lg-2 col-xl-2"></div>
    </div>
  </div>

  <div class="container">
    <div class="row">
      <p></p>
    </div>
  </div>

  <div class="container">
    <div id="seccion3" class="row">
      <div class="textCenter col-xs-0 col-sm-0 col-md-1 col-lg-2 col-xl-2"></div>

      <div class="temaBloqueado textCenter col-xs-12 col-sm-12 col-md-10 col-lg-8 col-xl-8">
        <table class="table">
          <tbody>
            <tr>
              <td width="6%">
                <img class="../CSSsJSs/iconsNumber" src="../CSSsJSs/icons/one.svg" />
              </td>
              <td width="58%" class="tituloTemasPrincipales">
                Identificar triángulos rectángulos
              </td>
              <!--td width="5%" rowspan="2" class="separadorTemasPrincipales">|</td-->

              <td width="12%">
                <img class="icons" src="../CSSsJSs/icons/lecciones.svg" />
              </td>
              <td width="12%">
                <img class="icons" src="../CSSsJSs/icons/run.svg" />
              </td>
              <td width="12%">
                <img class="icons" src="../CSSsJSs/icons/FlechaIzq.svg" />
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <div class="textCenter col-xs-0 col-sm-0 col-md-1 col-lg-2 col-xl-2"></div>
    </div>
  </div>

  <div class="container">
    <div class="row">
      <p></p>
    </div>
  </div>

  <div class="container ">
    <div class="row">
      <p class="relleno">.</p>
    </div>
    <div class="row">
      <p class="relleno">.</p>
    </div>
    <div class="row">
      <p class="relleno">.</p>
    </div>
  </div>

  <!----------------------------------------------SUBTEMAS--------------------------------------------->

  <!---->
  <!--
    <div class="container">
      <div class="row">
        <div class="textCenter hidden-xs col-sm-4 col-md-4 col-lg-4 col-xl-4">
          <h3>Column 1</h3>
          <p>Lorem ipsum dolor..</p>
        </div>
        <div class="textCenter col-xs-10 col-sm-4 col-md-4 col-lg-4 col-xl-4">
          <h3>Column 2</h3>
          <p>Lorem ipsum dolor..</p>
        </div>
        <div class="textCenter hidden-xs col-sm-4 col-md-4 col-lg-4 col-xl-4">
          <h3>Column 3</h3>
          <p>Lorem ipsum dolor..</p>
        </div>
      </div>
    </div>
    -->
  <!---->
  <!--+++++++++++++++++++++++++++++++++++++++  SCRIPTS   ++++++++++++++++++++++++++++++++++-->
  ';
}
  ?>
</body>

</html>