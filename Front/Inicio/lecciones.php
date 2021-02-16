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
  <title>Lecciones</title>
  <link rel="stylesheet" href="../CSSsJSs/<?php echo $bootstrap341; ?>" />
  <link rel="stylesheet" href="lecciones01.css" />
  <script src="lecciones02.js"></script>
</head>

<body>
  <?php
  $GLOBALS['servername'] = "localhost";
  $GLOBALS['username'] = "u526597556_dev";
  $GLOBALS['password'] = "1BLeeAgwq1*isgm&jBJe";
  $GLOBALS['dbname'] = "u526597556_kaanbal";
  ?>
  <?php
  $con = mysqli_connect("localhost", "u526597556_dev", "1BLeeAgwq1*isgm&jBJe", "u526597556_kaanbal");
  //////////////////////////////////////////////////////
  session_start();

  //Globales

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

  /* echo'<script type="text/javascript">
          alert("'.$_SESSION["tokenSesion"]."____".$tokenValidar["tokenSesionp"] .'");
          </script>'; */


  if ($_SESSION["tokenSesion"] == $tokenValidar["tokenSesionp"] and $tokenValidar["tokenSesionp"] != "") {
    $arregloLecciones = array();
    $arregloLecciones = traerLecciones();
    $_SESSION["subtemaNavegacion"] = $_GET['subtema'];
    imprimirPaginaLecciones($arregloLecciones);
  } else {

    /* echo'<script type="text/javascript">
          alert("segundo caminio");
          </script>'; */
    ////////////////////////////////////////
    //$con = mysqli_connect("localhost", "u526597556_dev", "1BLeeAgwq1*isgm&jBJe", "u526597556_kaanbal");	

    $correo = $_POST["validarUsuario"];
    $password = $_POST["validarPassword"];

    //Validamos que los campos correo y password no lleguen vacios
    if ($correo == "" or $password == "") {
      echo '<script type="text/javascript">
          alert("Ingresa usuario y/o contraseña");
          window.location.href="https://kaanbal.net";
          </script>';
    } else {

      //Consultar si existe usuario en tabla alumnos
      $statement = mysqli_prepare($con, "SELECT * FROM usuario_prueba WHERE mail = ? AND pass_cifrado = ?");
      mysqli_stmt_bind_param($statement, "ss", $correo, $password);
      mysqli_stmt_execute($statement);

      mysqli_stmt_store_result($statement);
      mysqli_stmt_bind_result($statement, $id_usuario, $mail, $pswd, $tokenA, $tokenSesion, $idioma);



      //Leemos datos del usuario
      while (mysqli_stmt_fetch($statement)) { //si si existe el usuario
        $temp_id_usuario = $id_usuario;
        $temp_mail = $mail;
        $temp_pswd = $pswd;
        $temp_tokenA = $tokenA;
        $temp_tokenSesion = $tokenSesion;
        $temp_idioma = $idioma;
        //$response["token"] = $token;
        //$response["token_a"] = $token_a;
        //$response["tokenp"] = $tokenp;
        //$response["tokenpp"] = $tokenpp;
        //$response["flag"] = $flag;
      }

      /* echo'<script type="text/javascript">
      alert("'.$id_usuario.$mail.$pswd.$tokenA.$tokenSesion.$idioma.'");
      </script>'; */

      //Si el usuario EXISTE despliega el menú de los temas
      if ($temp_id_usuario) {
        //Se inicia sesión del usuario 
        //session_start();
        //Creamos token de sesión
        $rand = bin2hex(random_bytes(5));
        //Registrar token de sesion en BD
        $sql = "UPDATE usuario_prueba SET tokenSesion='$rand' WHERE mail = '$correo'";
        mysqli_query($con, $sql);
        //Aactualizamos variables de sesión
        $_SESSION["id_usuario"] = $temp_id_usuario;
        $_SESSION["mail"] = $temp_mail;
        $_SESSION["pswd"] = $temp_pswd;
        $_SESSION["tokenA"] = $temp_tokenA;
        $_SESSION["tokenSesion"] = $rand;
        $_SESSION["idioma"] = $temp_idioma;
        //Imprimimos pantalla de temas
        $arregloLecciones = array();
        $arregloLecciones = traerLecciones();
        imprimirPaginaLecciones($arregloLecciones);
      }

      //Si el usuario NO EXISTE mensaje de error y retorna a inicio
      else {
        echo '<script type="text/javascript">
          alert("Usuario y/o contraseña incorrectos");
          window.location.href="https://kaanbal.net";
          </script>';
      }
    }
  }


  function traerLecciones()
  {

    /*+++++++++++++++++++++++++++++++++++++++++++++++++++++++*/
    $subtema = $_GET['subtema'];
    /*echo '<script type="text/javascript">
            alert("'.$subtema.'");
            </script>';
    */
    /*+++++++++++++++++++++++++++++++++++++++++++++++++++++++*/
    //-------CAMBIADO POR EL BRANDON A LAS 15:30 EL 13 DE JUNIO
    /*
    $con = mysqli_connect("localhost", "u526597556_dev", "1BLeeAgwq1*isgm&jBJe", "u526597556_kaanbal");
    //----Paso 1 Obtener el ID del subtema----
    $statement = mysqli_prepare($con, "SELECT id_subtema FROM subtema WHERE nombre = ?");
    mysqli_stmt_bind_param($statement, "s", $subtema);
    mysqli_stmt_execute($statement);
    mysqli_stmt_store_result($statement);
    mysqli_stmt_bind_result($statement, $id_subtema);

    $arregloIdsubtema = array();
    //Leemos datos de leccion
    while (mysqli_stmt_fetch($statement)) { //si si existe la leccion
      $arregloIdsubtema["id_subtema"] = $id_subtema;
    }
    */
    $id_subtema = $subtema;
    $arregloIdsubtema["id_subtema"] = $id_subtema;

    /*----Paso 2 Llamar a las lecciones del subtema-------*/
    $con = mysqli_connect("localhost", "u526597556_dev", "1BLeeAgwq1*isgm&jBJe", "u526597556_kaanbal");
    ///Llamar a las habilitadas
    //Verificamos el idioma//
    if ($_SESSION["idioma"] == 'i') {
      //Debe de traer todas en la que puntiacion PP sea mayor a 70%, las que sea mayor al 70% deberan tener habilitado el sprint y la siguiente leccion
      $statement = mysqli_prepare($con, "SELECT l.id_leccion, l.id_subtema, l.names, l.orden, FLOOR(COUNT(p.id_leccion) * 0.7) as setenta, pu.puntuacion FROM leccion l JOIN pregunta p JOIN puntuacion pu ON p.id_leccion = l.id_leccion AND l.id_leccion = pu.id_leccion AND p.id_leccion = pu.id_leccion WHERE l.id_subtema = ? AND pu.id_usuario = ? AND pu.tipo = 'PP' GROUP BY p.id_leccion ORDER BY orden");
    } else {
      //Debe de traer todas en la que puntiacion PP sea mayor a 70%, las que sea mayor al 70% deberan tener habilitado el sprint y la siguiente leccion
      $statement = mysqli_prepare($con, "SELECT l.id_leccion, l.id_subtema, l.nombre, l.orden, FLOOR(COUNT(p.id_leccion) * 0.7) as setenta, pu.puntuacion FROM leccion l JOIN pregunta p JOIN puntuacion pu ON p.id_leccion = l.id_leccion AND l.id_leccion = pu.id_leccion AND p.id_leccion = pu.id_leccion WHERE l.id_subtema = ? AND pu.id_usuario = ? AND pu.tipo = 'PP' GROUP BY p.id_leccion ORDER BY orden");
    }
    mysqli_stmt_bind_param($statement, "ii", $id_subtema, $_SESSION["id_usuario"]);
    mysqli_stmt_execute($statement);

    mysqli_stmt_store_result($statement);
    mysqli_stmt_bind_result($statement, $id_leccionh, $id_subtemah, $nombreh, $orden, $setenta, $puntuacion);

    $arregloLeccionesh = array();
    $i = 0;
    //Leemos datos del la leccion habilitadas
    while (mysqli_stmt_fetch($statement)) { //si si existe la leccion
      $arregloLeccionesh[$i]["id_leccion"] = $id_leccionh;
      $arregloLeccionesh[$i]["id_subtema"] = $id_subtemah;
      $arregloLeccionesh[$i]["nombre"] = $nombreh;
      $arregloLeccionesh[$i]["setenta"] = $setenta;
      $arregloLeccionesh[$i]["puntuacion"] = $puntuacion;
      $arregloLeccionesh[$i]["orden"] = $orden; ////////280622020 se agrego lo del orden de las lecciones
      $i = $i + 1;
    }

    $tamanhoLeccionesh = count($arregloLeccionesh);

    $j = 0;
    for ($i = 0; $i < $tamanhoLeccionesh; $i++) {
      if ($arregloLeccionesh[$i]["setenta"] <= $arregloLeccionesh[$i]["puntuacion"]) {
        $j = $j + 1;
      }
    }

    //Llamar no habilitadas
    //Verificamos el idioma//
    if ($_SESSION["idioma"] == 'i') {
      $statement = mysqli_prepare($con, "SELECT id_leccion, id_subtema, names, orden FROM leccion WHERE id_subtema = ? ORDER BY orden");
    } else {
      $statement = mysqli_prepare($con, "SELECT id_leccion, id_subtema, nombre, orden FROM leccion WHERE id_subtema = ? ORDER BY orden");
    }
    mysqli_stmt_bind_param($statement, "i", $id_subtema);
    mysqli_stmt_execute($statement);

    mysqli_stmt_store_result($statement);
    mysqli_stmt_bind_result($statement, $id_leccion, $id_subtema, $nombre, $orden);

    $arregloLecciones = array();
    $i = 0;
    //Leemos datos del la leccion no habilitadas
    while (mysqli_stmt_fetch($statement)) { //si si existe la leccion
      $arregloLecciones[$i]["id_leccion"] = $id_leccion;
      $arregloLecciones[$i]["id_subtema"] = $id_subtema;
      $arregloLecciones[$i]["nombre"] = $nombre;
      $arregloLecciones[$i]["orden"] = $orden; ////////280622020 se agrego lo del orden de las lecciones
      $i = $i + 1;
    }

    //Contar lecciones a habilitar
    $tamanhoh = $j;
    $_SESSION["tamanhoh"] = $tamanhoh;
    $tamanho = count($arregloLecciones);

    //para siempre habilitar la primera lección es el if
    if ($tamanhoh == 0) {
      $arregloLecciones[0]["h"] = '1';
      $arregloLecciones[0]["hS"] = '0';
      $arregloLecciones[0]["hE"] = '0';
    } else {
      if ($tamanhoh == $tamanho) {
        //Para activar ya todas las lecciones
        for ($i = 0; $i < $tamanhoh; $i++) {
          $arregloLecciones[$i]["h"] = '1';
          $arregloLecciones[$i]["hS"] = '1';
          $arregloLecciones[0]["hE"] = '1';
        }
      } else {
        //Para activar solo la siguiente leccion
        for ($i = 0; $i <= $tamanhoh; $i++) {
          if ($i == $tamanhoh) {
            $arregloLecciones[$i]["h"] = '1';
            $arregloLecciones[$i]["hS"] = '0';
            $arregloLecciones[0]["hE"] = '0';
          } else {
            $arregloLecciones[$i]["h"] = '1';
            $arregloLecciones[$i]["hS"] = '1';
            $arregloLecciones[0]["hE"] = '1';
          }
        }
      }
    }
    //$arregloLeccionesTodas = array_merge($arregloLeccionesh, $arregloLecciones);
    ////////////
    /* $statement = mysqli_prepare($con, "SELECT * FROM leccion WHERE id_subtema = ?"); //WHERE mail = ? AND pswd = ?
    mysqli_stmt_bind_param($statement, "s", $arregloIdsubtema["id_subtema"]);
    mysqli_stmt_execute($statement);

    mysqli_stmt_store_result($statement);
    mysqli_stmt_bind_result($statement, $id_leccion, $id_subtema, $nombre);

    $arregloLecciones = array();
    $i = 0;
    //Leemos datos del la leccion
    while (mysqli_stmt_fetch($statement)) { //si si existe la leccion
      $arregloLecciones[$i]["id_leccion"] = $id_leccion;
      $arregloLecciones[$i]["id_subtema"] = $id_subtema;
      $arregloLecciones[$i]["nombre"] = $nombre;
      $i = $i + 1;
    } */
    ///////////////

    return ($arregloLecciones);
  }

  function imprimirPaginaLecciones($arregloLecciones)
  {
    imprimirTitulo();
    imprimirLecciones($arregloLecciones);
    imprimirRelleno();
  }

  function imprimirLecciones($arregloLecciones)
  {
    $tamanho = count($arregloLecciones);
    for ($i = 0; $i < $tamanho; $i++) {
      imprimirLeccion($i + 1, $arregloLecciones[$i]["id_leccion"],  $arregloLecciones[$i]["nombre"], $arregloLecciones[$i]["h"], $arregloLecciones[$i]["hS"], $arregloLecciones[0]["hE"]);
      //function imprimirLeccion($numeroLeccion, $idLeccion, $nombreLeccion, $habilitar, $habilitarS)
    }
  }


  function imprimirTitulo()
  {
    $temaNavegacion = $_SESSION["temaNavegacion"];
    try {
      $conn = new PDO("mysql:host=" . $GLOBALS['servername'] . ";dbname=" . $GLOBALS['dbname'] . "", $GLOBALS['username'], $GLOBALS['password']);
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $idSubtema = $_GET['subtema'];
      if ($_SESSION["idioma"] == 'i') {
        $stringQuery = "SELECT names FROM subtema WHERE id_subtema='" . $idSubtema . "' ;";
      } else {
        $stringQuery = "SELECT nombre FROM subtema WHERE id_subtema='" . $idSubtema . "' ;";
      }
      $stmt = $conn->query($stringQuery);
      while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
        $nombreSubtema = $row[0];
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
          <div class="textCenter col-xs-1 col-sm-1 col-md-1 col-lg-1 col-xl-1">
            <a href="subtemas.php?tema=' . $temaNavegacion . '"><img class="iconoBack" src="../CSSsJSs/icons/FlechaIzq.svg" /></a>
          </div>
          <div class="textCenter col-xs-11 col-sm-11 col-md-11 col-lg-11 col-xl-11">
            <p class="Materia fuenteTitulo">' . $nombreSubtema . '</p>
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

  function imprimirLeccion($numeroLeccion, $idLeccion, $nombreLeccion, $habilitar, $habilitarS, $habilitarE)
  {
    $habilitar = '1';
    $habilitarS = '1';
    $habilitarE = '1';
    if ($habilitar == '1' && $habilitarS == '1' && $habilitarE == '1') {
      //<a href="../preguntas/examen.php?leccion=' . $idLeccion . '"><img class="iconsActive" src="../CSSsJSs/icons/examen.svg" /></a>      
      echo '
      <div class="container">
        <div id="seccion' . $numeroLeccion . '" class="row fade" style="opacity:0.0">
          <div class="textCenter col-xs-0 col-sm-0 col-md-1 col-lg-2 col-xl-2"></div>
          <div class="temaPrincipal1 textCenter col-xs-12 col-sm-12 col-md-10 col-lg-8 col-xl-8">
            <table class="table fixed">
              <tbody>
                <tr>
                  <td>
                    <img class="iconsNumber" src="../CSSsJSs/icons/' . $numeroLeccion . '.svg" />
                  </td>
                  <td class="tituloTemasPrincipales">
                  ' . $nombreLeccion . '
                  </td>
                  <td>
                  <a href="../preguntas/Practica/practice.php?leccion=' . $idLeccion . '"><img class="iconsActive" src="../CSSsJSs/icons/book.svg" /></a>
                  </td>
                  <td>
                  <a href="../preguntas/Sprint/sprint.php?leccion=' . $idLeccion . '"><img class="iconsActive" src="../CSSsJSs/icons/jogging.svg" /></a>
                  </td>
                  <td>
                  <a href="../preguntas/Examen/examen.php?leccion=' . $idLeccion . '"><img class="iconsActive" src="../CSSsJSs/icons/examen.svg" />
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
    } elseif ($habilitar == '1') {
      echo '
      <div class="container">
        <div id="seccion' . $numeroLeccion . '" class="row fade" style="opacity:0.0">
          <div class="textCenter col-xs-0 col-sm-0 col-md-1 col-lg-2 col-xl-2"></div>
          <div class="temaPrincipal1 textCenter col-xs-12 col-sm-12 col-md-10 col-lg-8 col-xl-8">
            <table class="table fixed">
              <tbody>
                <tr>
                  <td>
                    <img class="iconsNumber" src="../CSSsJSs/icons/' . $numeroLeccion . '.svg" />
                  </td>
                  <td class="tituloTemasPrincipales">
                  ' . $nombreLeccion . '
                  </td>
                  <td>
                  <a href="../preguntas/Practica/practice.php?leccion=' . $idLeccion . '"><img class="iconsActive" src="../CSSsJSs/icons/book.svg" /></a>
                  </td>
                  <td>
                    <img class="icons" src="../CSSsJSs/icons/jogging.svg" /></a>
                  </td>
                  <td>
                    <img class="icons" src="../CSSsJSs/icons/examen.svg" />
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
    } else {
      echo '
              <div class="container">
                <div id="seccion' . $numeroLeccion . '" class="row fade" style="opacity:0.0">
                  <div class="textCenter col-xs-0 col-sm-0 col-md-1 col-lg-2 col-xl-2"></div>
                  <div class="temaPrincipal1 textCenter col-xs-12 col-sm-12 col-md-10 col-lg-8 col-xl-8">
                    <table class="table fixed">
                      <tbody>
                        <tr>
                          <td>
                            <img class="iconsNumber" src="../CSSsJSs/icons/' . $numeroLeccion . '.svg" />
                          </td>
                          <td class="tituloTemasPrincipales">
                          ' . $nombreLeccion . '
                          </td>
                          <td>
                          <img class="icons" src="../CSSsJSs/icons/book.svg" /></a>
                          </td>
                          <td>
                          <img class="icons" src="../CSSsJSs/icons/jogging.svg" /></a>
                          </td>
                          <td>
                            <img class="icons" src="../CSSsJSs/icons/examen.svg" />
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