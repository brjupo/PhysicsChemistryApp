<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="shortcut icon" type="image/x-icon" href="../CSSsJSs/icons/pyramid.svg" />
  <title>Subtemas</title>
  <link rel="stylesheet" href="../CSSsJSs/bootstrap341.css" />
    <link rel="stylesheet" href="../CSSsJSs/styleSubtemas.css" />
    <script src="../CSSsJSs/scriptSubtemas.js"></script>
</head>

<body>

  <?php
  ///////////////////////////////////////////
  $con = mysqli_connect("localhost", "u526597556_dev", "1BLeeAgwq1*isgm&jBJe", "u526597556_kaanbal");
  //////////////////////////////////////////////////////
  session_start();
  $tokenValidar = array();
  /* echo'<script type="text/javascript">
            alert("$_SESSION["mail"]");
            </script>'; */

  //Consultar si existe token de usuario
  $statement = mysqli_prepare($con, "SELECT tokenSesion FROM usuario_prueba WHERE mail = ?");
  mysqli_stmt_bind_param($statement, "s", $_SESSION["mail"]);
  mysqli_stmt_execute($statement);

  mysqli_stmt_store_result($statement);
  mysqli_stmt_bind_result($statement, $tokenSesionp);

  while (mysqli_stmt_fetch($statement)) {
    $tokenValidar["tokenSesionp"] = $tokenSesionp;
  }

  /*  echo'<script type="text/javascript">
            alert("'.$_SESSION["tokenSesion"]."____".$tokenValidar["tokenSesionp"] .'");
            </script>'; */


  if ($_SESSION["tokenSesion"] == $tokenValidar["tokenSesionp"] and $tokenValidar["tokenSesionp"] != "") {
    $arregloSubtemas = array();
    $arregloSubtemas = traerSubtemas();
    imprimirPaginaSubtemas($arregloSubtemas);
  } else {

    /* echo'<script type="text/javascript">
              alert("segundo caminio");
              </script>'; */

    ////////////////////////////////////

    /* echo'<script type="text/javascript">
      alert("'.$_SESSION["mail"].$_SESSION["pswd"].$_SESSION["tokenSesion"].'");
      </script>'; */

    //$con = mysqli_connect("localhost", "u526597556_dev", "1BLeeAgwq1*isgm&jBJe", "u526597556_kaanbal");
    $stringQuery = "SELECT mail FROM usuario_prueba WHERE mail = '" . $_SESSION["mail"] . "' AND pswd = '" . $_SESSION["pswd"] . "' AND tokenSesion = '" . $_SESSION["tokenSesion"] . "'";
    $result = mysqli_query($con, $stringQuery);
    $rowp = mysqli_fetch_array($result);

    if ($rowp) {
      $arregloSubtemas = array();
      $arregloSubtemas = traerSubtemas();
      imprimirPaginaSubtemas($arregloSubtemas);

    } else {
      echo '<script type="text/javascript">
        window.location.href="https://kaanbal.net";
        </script>';
    }
  }
  ?>

  <?php

function traerSubtemas(){
  $con = mysqli_connect("localhost", "u526597556_dev", "1BLeeAgwq1*isgm&jBJe", "u526597556_kaanbal");
  $statement = mysqli_prepare($con, "SELECT * FROM subtema");//WHERE mail = ? AND pswd = ?
  //mysqli_stmt_bind_param($statement, "ss", $correo, $password);
  mysqli_stmt_execute($statement);

  mysqli_stmt_store_result($statement);
  mysqli_stmt_bind_result($statement, $id_subtema, $id_tema, $nombre);

  $arregloSubtemas = array();
  $i=0;
  //Leemos datos del usuario
  while(mysqli_stmt_fetch($statement)){//si si existe el usuario
      $arregloSubtemas[$i]["id_subtema"] = $id_subtema;
      $arregloSubtemas[$i]["id_tema"]= $id_tema;            
      $arregloSubtemas[$i]["nombre"] = $nombre;  
      $i=$i+1;   
  }

  return($arregloSubtemas);
}

  function imprimirPaginaSubtemas($arregloSubtemas)
  {
    imprimirTitulo();
    imprimirSiempreAparece();
    imprimirSubtemas($arregloSubtemas);

    imprimirRelleno();
    imprimirFooter();
  }

  function imprimirSubtemas($arregloSubtemas)
  {
    $tamanho = count($arregloSubtemas);
    for ($i = 0; $i < $tamanho; $i++) { 
        imprimirSubtema($i+1,$arregloSubtemas[$i]["nombre"]);  
      }
  }


  function imprimirTitulo()
  {
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
  ';
  }


  function imprimirSiempreAparece()
  {
    echo '  
      <!----------------------------------------------SUBTEMAS--------------------------------------------->
      <div class="container">
        <div id="seccion0" class="row">
          <div class="textCenter col-xs-0 col-sm-0 col-md-1 col-lg-2 col-xl-2"></div>
          <div class="temaPrincipal1 textCenter col-xs-12 col-sm-12 col-md-10 col-lg-8 col-xl-8">
            <table class="table fixed">
              <tbody>
                <tr>
                  <td>
                    <img class="../CSSsJSs/iconsNumber" src="../CSSsJSs/icons/1.svg" />
                  </td>
                  <td class="tituloTemasPrincipales">
                    Identificar triángulos rectángulos
                  </td>
                  <td>
                    <a href="preguntas/preguntaSprint.html"><img class="iconsActive" src="../CSSsJSs/icons/lecciones.svg" /></a>
                  </td>
                  <td>
                    <img class="icons" src="../CSSsJSs/icons/run.svg" />
                  </td>
                  <td>
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
  ';
  }

  function imprimirSubtema($numeroSubtema, $nombreSubtema)
  {
    echo '
      <div class="container">
        <div id="seccion'.$numeroSubtema.'" class="row fade">
          <div class="textCenter col-xs-0 col-sm-0 col-md-1 col-lg-2 col-xl-2"></div>
          <div class="temaPrincipal1 textCenter col-xs-12 col-sm-12 col-md-10 col-lg-8 col-xl-8">
            <table class="table fixed">
              <tbody>
                <tr>
                  <td>
                    <img class="iconsNumber" src="../CSSsJSs/icons/'.$numeroSubtema.'.svg" />
                  </td>
                  <td class="tituloTemasPrincipales">
                  '.$nombreSubtema.'
                  </td>
                  <td>
                    <a href="../preguntas/preguntaGeneral.php"><img class="iconsActive" src="../CSSsJSs/icons/lecciones.svg"/></a>
                  </td>
                  <td>
                    <img class="icons" src="../CSSsJSs/icons/run.svg" />
                  </td>
                  <td>
                    <a href="lecciones.php"><img class="iconContinue" src="../CSSsJSs/icons/FlechaIzq.svg" /></a>                    
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
  ';
  }

  function imprimirRelleno()
  {
    echo '
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
    ';
  }

  ?>
</body>

</html>