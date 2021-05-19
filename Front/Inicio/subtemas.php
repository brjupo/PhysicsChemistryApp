<?php
require "../../servicios/00DDBBVariables.php";
require "../CSSsJSs/mainCSSsJSs.php";
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="shortcut icon" type="image/x-icon" href="../CSSsJSs/icons/pyramid.svg" />
  <title>Subtemas</title>
  <link rel="stylesheet" href="../CSSsJSs/<?php echo $bootstrap341; ?>" />
  <link rel="stylesheet" href="subtemas01.css" />
  <script src="subtemas02.js"></script>
</head>

<body>
  <?php
  $GLOBALS['servername'] = "localhost";
  $GLOBALS['username'] = "u526597556_dev";
  $GLOBALS['password'] = "1BLeeAgwq1*isgm&jBJe";
  $GLOBALS['dbname'] = "u526597556_kaanbal";
  ?>
  <?php
  ///////////////////////////////////////////
  $con = mysqli_connect("localhost", "u526597556_dev", "1BLeeAgwq1*isgm&jBJe", "u526597556_kaanbal");
  //////////////////////////////////////////////////////
  session_start();
  $tokenValidar = array();

  //Consultar si existe token de usuario
  $statement = mysqli_prepare($con, "SELECT tokenSesion FROM usuario_prueba WHERE mail = ?");
  mysqli_stmt_bind_param($statement, "s", $_SESSION["mail"]);
  mysqli_stmt_execute($statement);

  mysqli_stmt_store_result($statement);
  mysqli_stmt_bind_result($statement, $tokenSesionp);

  while (mysqli_stmt_fetch($statement)) {
    $tokenValidar["tokenSesionp"] = $tokenSesionp;
  }

  if ($_SESSION["tokenSesion"] == $tokenValidar["tokenSesionp"] and $tokenValidar["tokenSesionp"] != "") {
    $arregloSubtemas = array();
    $arregloSubtemas = traerSubtemas();
    $_SESSION["temaNavegacion"] = $_GET['tema'];
    imprimirPaginaSubtemas($arregloSubtemas);
  } else {
    $stringQuery = "SELECT mail FROM usuario_prueba WHERE mail = '" . $_SESSION["mail"] . "' AND pass_cifrado = '" . $_SESSION["pswd"] . "' AND tokenSesion = '" . $_SESSION["tokenSesion"] . "'";
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

  function traerSubtemas()
  {
    //-------CAMBIADO POR EL BRANDON A LAS 16:00 EL 13 DE JUNIO
    /*+++++++++++++++++++++++++++++++++++++++++++++++++++++++*/
    $id_tema = $_GET['tema'];
    $arregloIdtema["id_tema"] = $id_tema;
    /*----Paso 2 Llamar a los subtemas de los temas-------*/
    //Verificamos el idioma//
    $con = mysqli_connect("localhost", "u526597556_dev", "1BLeeAgwq1*isgm&jBJe", "u526597556_kaanbal");
    if ($_SESSION["idioma"] == 'i') {
      $statement = mysqli_prepare($con, "SELECT id_subtema, id_tema, names, englishLink, orden FROM subtema WHERE id_tema = ? ORDER BY orden"); //WHERE mail = ? AND pswd = ?
    } else {
      $statement = mysqli_prepare($con, "SELECT id_subtema, id_tema, nombre, link, orden FROM subtema WHERE id_tema = ? ORDER BY orden"); //WHERE mail = ? AND pswd = ?
    }
    mysqli_stmt_bind_param($statement, "s", $arregloIdtema["id_tema"]);
    mysqli_stmt_execute($statement);

    mysqli_stmt_store_result($statement);
    mysqli_stmt_bind_result($statement, $id_subtema, $id_tema, $nombre, $link, $orden);

    $arregloSubtemas = array();
    $i = 0;
    //Leemos datos del usuario
    while (mysqli_stmt_fetch($statement)) { //si si existe el usuario
      $arregloSubtemas[$i]["id_subtema"] = $id_subtema;
      $arregloSubtemas[$i]["id_tema"] = $id_tema;
      $arregloSubtemas[$i]["nombre"] = $nombre;
      $arregloSubtemas[$i]["link"] = $link;
      $arregloSubtemas[$i]["orden"] = $orden; ////////280622020 se agrego lo del orden
      $i = $i + 1;
    }

    return ($arregloSubtemas);
  }

  function imprimirPaginaSubtemas($arregloSubtemas)
  {
    imprimirTitulo();
    imprimirSubtemas($arregloSubtemas);
    imprimirRelleno();
  }

  function imprimirSubtemas($arregloSubtemas)
  {
    $tamanho = count($arregloSubtemas);
    for ($i = 0; $i < $tamanho; $i++) {
      imprimirSubtema($i + 1, $arregloSubtemas[$i]["id_subtema"], $arregloSubtemas[$i]["nombre"], $arregloSubtemas[$i]["link"]);
    }
  }


  function imprimirTitulo()
  {
    try {
      $conn = new PDO("mysql:host=" . $GLOBALS['servername'] . ";dbname=" . $GLOBALS['dbname'] . "", $GLOBALS['username'], $GLOBALS['password']);
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $idTema = $_GET['tema'];
      if ($_SESSION["idioma"] == 'i') {
        $stringQuery = "SELECT names FROM tema WHERE id_tema='" . $idTema . "' ;";
      } else {
        $stringQuery = "SELECT nombre FROM tema WHERE id_tema='" . $idTema . "' ;";
      }
      $stmt = $conn->query($stringQuery);
      while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
        $nombreTema = $row[0];
      }
    } catch (PDOException $e) {
      echo "Error: " . $e->getMessage();
    }
    $conn = null;
    echo '
    <!----------------------------------------------TITULO--------------------------------------------->
    <div class="top">
      <div class="container">
        <div class="row titulo">
          <div class="text-center col-xs-1 col-sm-1 col-md-1 col-lg-1 col-xl-1">
            <a href="temas.php?asignatura=' . $_SESSION["idAsignatura"] . '"><img class="iconoBack" src="../CSSsJSs/icons/FlechaIzq.svg" /></a>
          </div>
          <div class="text-center col-xs-11 col-sm-11 col-md-11 col-lg-11 col-xl-11">
            <p class="Materia fuenteTitulo">' . $nombreTema . '</p>
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

  function imprimirSubtema($numeroSubtema, $id_subtema, $nombreSubtema, $link)
  {
    if ($link == Null) {
      echo '
      <div class="container">
        <div id="seccion' . $numeroSubtema . '" class="row fade">
          <div class="text-center col-xs-0 col-sm-0 col-md-1 col-lg-2 col-xl-2"></div>
          <div class="temaPrincipal1 text-center col-xs-12 col-sm-12 col-md-10 col-lg-8 col-xl-8">
            <table class="table fixed">
              <tbody>
                <tr>
                  <td>
                    <img class="iconsNumber" src="../CSSsJSs/icons/' . $numeroSubtema . '.svg" />
                  </td>
                  <td class="tituloTemasPrincipales">
                  ' . $nombreSubtema . '
                  </td>
                  <td>
                    <img class="icons" src="../CSSsJSs/icons/fullBook.svg"/>
                  </td>
                  <td>
                  <a href=""><img class="icons" src="../CSSsJSs/icons/runner.svg" /></a>
                  </td>
                  <td>
                    <a href="lecciones.php?subtema=' . $id_subtema . '"><img class="iconContinueActive" src="../CSSsJSs/icons/FlechaIzq.svg" /></a>                    
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="text-center col-xs-0 col-sm-0 col-md-1 col-lg-2 col-xl-2"></div>
        </div>
      </div>

      <div class="container">
        <div class="row">
          <p></p>
        </div>
      </div>
  ';
    } else {
      echo '
      <div class="container">
        <div id="seccion' . $numeroSubtema . '" class="row fade">
          <div class="text-center col-xs-0 col-sm-0 col-md-1 col-lg-2 col-xl-2"></div>
          <div class="temaPrincipal1 text-center col-xs-12 col-sm-12 col-md-10 col-lg-8 col-xl-8">
            <table class="table fixed">
              <tbody>
                <tr>
                  <td>
                    <img class="iconsNumber" src="../CSSsJSs/icons/' . $numeroSubtema . '.svg" />
                  </td>
                  <td class="tituloTemasPrincipales">
                  ' . $nombreSubtema . '
                  </td>
                  <td>
                    <a href="' . $link . '"><img class="iconsActive" src="../CSSsJSs/icons/fullBook.svg"/></a>
                  </td>
                  <td>
                    <a href="../preguntas/SuperSprint/superSprint.php?subtema=' . $id_subtema . '"><img class="iconsActive" src="../CSSsJSs/icons/runner.svg" /></a>
                  </td>
                  <td>
                    <a href="lecciones.php?subtema=' . $id_subtema . '"><img class="iconContinueActive" src="../CSSsJSs/icons/FlechaIzq.svg" /></a>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="text-center col-xs-0 col-sm-0 col-md-1 col-lg-2 col-xl-2"></div>
        </div>
      </div>

      <div class="container">
        <div class="row">
          <p></p>
        </div>
      </div>
  ';
    }
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

  <div class="foot">
    <div class="container">
      <div class="row text-center">
        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 col-xl-3">
          <a href="temas.php">
            <img class="footIcon" id="botonLecciones" src="../CSSsJSs/icons/business.svg" />
          </a>
        </div>
        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 col-xl-3 ">
          <a href="perfil.php">
            <img class="footIcon" id="botonPerfil" src="../CSSsJSs/icons/identification.svg" />
          </a>
        </div>
        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 col-xl-3">
          <a href="topS.php">
            <img class="footIcon" id="botonTop" src="../CSSsJSs/icons/top.svg" />
          </a>
        </div>
        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 col-xl-3">
          <a href="../../../index.php">
            <img class="footIcon" id="botonLogout" src="../CSSsJSs/icons/logout.svg" />
          </a>
        </div>
      </div>
    </div>
  </div>

</body>

</html>