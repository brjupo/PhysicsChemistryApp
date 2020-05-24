<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="shortcut icon" type="image/x-icon" href="../CSSsJSs/icons/pyramid.svg" />
  <title>Lecciones</title>
  <link rel="stylesheet" href="../CSSsJSs/bootstrap341.css" />
  <link rel="stylesheet" href="../CSSsJSs/styleLecciones2.css" />
  <script src="../CSSsJSs/scriptLecciones.js"></script>
</head>

<body>
  <?php
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

  /* echo'<script type="text/javascript">
          alert("'.$_SESSION["tokenSesion"]."____".$tokenValidar["tokenSesionp"] .'");
          </script>'; */


  if ($_SESSION["tokenSesion"] == $tokenValidar["tokenSesionp"] and $tokenValidar["tokenSesionp"] != "") {
    $arregloLecciones = array();
    $arregloLecciones = traerLecciones();
    $_SESSION["subtemaNavegacion"]=$_GET['subtema'];
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
      $statement = mysqli_prepare($con, "SELECT * FROM usuario_prueba WHERE mail = ? AND pswd = ?");
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
    $con = mysqli_connect("localhost", "u526597556_dev", "1BLeeAgwq1*isgm&jBJe", "u526597556_kaanbal");
    /*----Paso 1 Obtener el ID del subtema----*/
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

    /*----Paso 2 Llamar a las lecciones del subtema-------*/
    $statement = mysqli_prepare($con, "SELECT * FROM leccion WHERE id_subtema = ?"); //WHERE mail = ? AND pswd = ?
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
    }

    return ($arregloLecciones);
  }

  function imprimirPaginaLecciones($arregloLecciones)
  {
    imprimirTitulo();
    //imprimirSiempreAparece();
    imprimirLecciones($arregloLecciones);

    imprimirRelleno();
    imprimirFooter();
  }

  function imprimirLecciones($arregloLecciones)
  {
    $tamanho = count($arregloLecciones);
    for ($i = 0; $i < $tamanho; $i++) {
      imprimirLeccion($i + 1, $arregloLecciones[$i]["nombre"]);
    }
  }


  function imprimirTitulo()
  {
    $temaNavegacion = $_SESSION["temaNavegacion"];
    echo '
    <!----------------------------------------------TITULO--------------------------------------------->
    <div class="top">
      <div class="container">
        <div class="row titulo">
          <div class="textCenter col-xs-1 col-sm-1 col-md-1 col-lg-1 col-xl-1">
            <a href="subtemas.php?tema='.$temaNavegacion.'"><img class="iconoBack" src="../CSSsJSs/icons/FlechaIzq.svg" /></a>
          </div>
          <div class="textCenter col-xs-11 col-sm-11 col-md-11 col-lg-11 col-xl-11">
            <p class="Materia fuenteTitulo">'.$_GET['subtema'].'</p>
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
                    <img class="iconsNumber" src="../CSSsJSs/icons/1.svg" />
                  </td>
                  <td class="tituloTemasPrincipales">
                    Identificar triángulos rectángulos
                  </td>
                  <td>
                    <a href="preguntas/practice.php"><img class="iconsActive" src="../CSSsJSs/icons/lecciones.svg" /></a>
                  </td>
                  <td>
                    <img class="icons" src="../CSSsJSs/icons/run.svg" />
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

  function imprimirLeccion($numeroLeccion, $nombreLeccion)
  {
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
                  <a href="../preguntas/sprint.php?leccion='.$nombreLeccion.'"><img class="iconsActive" src="../CSSsJSs/icons/jogging.svg" /></a>
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