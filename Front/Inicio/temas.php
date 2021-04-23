<?php
require "../../servicios/00DDBBVariables.php";
require "../../servicios/03warrantyPublicity.php";
require "../CSSsJSs/mainCSSsJSs.php";
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="shortcut icon" type="image/x-icon" href="../CSSsJSs/icons/pyramid.svg" />
  <title>Temas Kaanbal</title>
  <link rel="stylesheet" href="../CSSsJSs/<?php echo $bootstrap341; ?>" />
  <link rel="stylesheet" href="../CSSsJSs/<?php echo $kaanbalEssentials; ?>" />
  <link rel="stylesheet" href="Temas01.css" />

  <!-- Global site tag (gtag.js) - Google Analytics -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=G-F7VGWM5LKB"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'G-F7VGWM5LKB');
  </script>
  
  <!-- Google AdSense -->
  <script
      data-ad-client="ca-pub-9977500171937835"
      async
      src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"
    ></script>
    
</head>

<body>
  <?php
  $con = mysqli_connect("localhost", "u526597556_dev", "1BLeeAgwq1*isgm&jBJe", "u526597556_kaanbal");
  //////////////////////////////////////////////////////
  session_start();
  $tokenValidar = array();
//ESTOE S UN OCMENTARIO
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
            </script>';  */


  if ($_SESSION["tokenSesion"] == $tokenValidar["tokenSesionp"] and $tokenValidar["tokenSesionp"] != "") {
    $arregloTemas = array();
    $arregloTemas = traerTemas();
    //$_SESSION["asignaturaNavegacion"] = $_GET['asignatura'];//091120 AQUI DEBE DE TRAER EL ID DE MATERIA ESTE ES EL CASO EN QUE SOLO HAY UNA SOLA LICENCIA ASIGNADA
    imprimirPagina($arregloTemas);
  } else {

    /* echo'<script type="text/javascript">
            alert("segundo caminio");
            </script>'; */
    ////////////////////////////////////////
    //$con = mysqli_connect("localhost", "u526597556_dev", "1BLeeAgwq1*isgm&jBJe", "u526597556_kaanbal");	
    //$con = mysqli_connect("localhost", "u526597556_dev", "1BLeeAgwq1*isgm&jBJe", "u526597556_kaanbal");
    $stringQuery = "SELECT mail FROM usuario_prueba WHERE mail = '" . $_SESSION["mail"] . "' AND pass_cifrado = '" . $_SESSION["pswd"] . "' AND tokenSesion = '" . $_SESSION["tokenSesion"] . "'";
    $result = mysqli_query($con, $stringQuery);
    $rowp = mysqli_fetch_array($result);

    //Validamos que los campos correo y password no lleguen vacios
    if ($rowp) {
      //Validar Pago de licencia para mostrar mensaje
      /* $statement = mysqli_prepare($con, "SELECT l.pagado FROM alumno a JOIN usuario_prueba u JOIN licencia l 
      ON a.id_usuario = u.id_usuario AND u.id_usuario = l.id_usuario 
      WHERE l.id_asignatura = 1 AND u.mail = ?"); //WHERE mail = ? AND pswd = ?
      mysqli_stmt_bind_param($statement, "s", $_SESSION["mail"]);
      mysqli_stmt_execute($statement);
      mysqli_stmt_store_result($statement);
      mysqli_stmt_bind_result($statement, $pagado);

      $arregloPagado = array();
      //Leemos datos del usuario
      while (mysqli_stmt_fetch($statement)) { //si si existe el usuario
        $arregloPagado["pagado"] = $pagado;
      } */

      ////////////

      $arregloTemas = array();
      $arregloTemas = traerTemas();
      //$_SESSION["asignaturaNavegacion"] = $_GET['asignatura'];
      imprimirPagina($arregloTemas);
    } else {

      echo '<script type="text/javascript">
        window.location.href="https://kaanbal.net";
        </script>';
    }
  }

  function traerTemas()
  {
    /*+++++++++++++++++++++++++++++++++++++++++++++++++++++++*/
    $idAsignatura = $_GET['asignatura']; //091120 ESTO LO RECIBE DIRECTO DE LA URL, AQUI RECIBIRA ID DE ASIGNATURA
    if($idAsignatura != ''){
    $_SESSION["idAsignatura"] = $idAsignatura;}
    else{
      $idAsignatura = $_SESSION["idAsignatura"];
    }
    /*echo '<script type="text/javascript">
            alert("'.$asignatura.'");
            </script>';
    
    /*+++++++++++++++++++++++++++++++++++++++++++++++++++++++*/
    $con = mysqli_connect("localhost", "u526597556_dev", "1BLeeAgwq1*isgm&jBJe", "u526597556_kaanbal");

    if ($_SESSION["idioma"] == 'i') {
      $query = "SELECT names FROM asignatura WHERE id_asignatura = $idAsignatura";
      $result = mysqli_query($con, $query);
      while ($row = mysqli_fetch_assoc($result)) {
        $arrayMateria[] = $row;
      }
      $materia =  $arrayMateria[0]["names"]; //De aqui se obtendra el nombre de asignatura
    } else {
      $query = "SELECT nombre FROM asignatura WHERE id_asignatura = $idAsignatura";
      $result = mysqli_query($con, $query);
      while ($row = mysqli_fetch_assoc($result)) {
        $arrayMateria[] = $row;
      }
      $materia =  $arrayMateria[0]["nombre"]; //De aqui se obtendra el nombre de asignatura
    }


    //id de asignatura usado en top.php
    if($idAsignatura != ''){
    $_SESSION["idAsignatura"] = $idAsignatura;}
    else{
      $idAsignatura = $_SESSION["idAsignatura"];
    }
    $_SESSION["asignaturaNavegacion"] = $materia;

    /*----Paso 2 Llamar a los temas de la asignatura-------*/
    //Verificamos el idioma//
    if ($_SESSION["idioma"] == 'i') {
      $statement = mysqli_prepare($con, "SELECT id_tema, id_asignatura, names FROM tema WHERE id_asignatura = ? ORDER BY orden ASC"); //WHERE mail = ? AND pswd = ?
    } else {
      $statement = mysqli_prepare($con, "SELECT id_tema, id_asignatura, nombre FROM tema WHERE id_asignatura = ? ORDER BY orden ASC"); //WHERE mail = ? AND pswd = ?
    }
    mysqli_stmt_bind_param($statement, "s", $idAsignatura);
    mysqli_stmt_execute($statement);
    mysqli_stmt_store_result($statement);
    mysqli_stmt_bind_result($statement, $id_tema, $id_asignatura, $nombre);

    $arregloTemas = array();
    $i = 0;
    //Leemos datos del usuario
    while (mysqli_stmt_fetch($statement)) { //si si existe el usuario
      $arregloTemas[$i]["id_tema"] = $id_tema;
      $arregloTemas[$i]["id_asignatura"] = $id_asignatura;
      $arregloTemas[$i]["nombre"] = $nombre;
      $i = $i + 1;
    }

    return ($arregloTemas);
  }

  $total = mysqli_fetch_row($result2);
  //$total = 10;
  //Recorrer el arreglo
  while ($row = mysqli_fetch_assoc($result)) {
    $array[] = $row;
    $arrayr[] = $row;
  }
  //////////////////////
  function imprimirPagina($arregloTemas)
  {
    imprimirTitulo();
    imprimirCita();
    imprimirTemas($arregloTemas);
    imprimirRelleno();
  }

  function imprimirTemas($arregloTemas)
  {
    $tamanho = count($arregloTemas);
    for ($i = 0; $i < $tamanho; $i++) {
      imprimirTema($i + 1, $arregloTemas[$i]["id_tema"], $arregloTemas[$i]["nombre"]);
    }
  }



  /* Recordatorio
  Recuerda que tienes 4 colores para cambiarlos
  <div class="temaPrincipal1 text-center col-xs-10 col-sm-10 col-md-8 col-lg-6 col-xl-6">
  temaPrincipal1, temaPrincipal2, temaPrincipal3, temaPrincipal4
  */

  function imprimirTitulo()
  {
    echo '
  <div class="top">
    <div class="container">
      <div class="row">
        <div class="text-center col-xs-2 col-sm-2 col-md-2 col-lg-1 col-xl-1">
          <img class="iconoPrincipal" src="../CSSsJSs/icons/physics.svg" />
        </div>
        <div class="text-center col-xs-10 col-sm-10 col-md-10 col-lg-11 col-xl-11">
          <p class="Ciencia fuenteTitulo" id="asignaturad">' . $_SESSION["asignaturaNavegacion"] . '</p>
          <p class="Ciencia fuenteTitulo" id="asignatura" style="display:none">' . $_SESSION["idAsignatura"] . '</p>
        </div>
      </div>
    </div>
  </div>
      <!------------------------------------------------FIN TITULO----------------------------------------------->
    ';
  }

  function imprimirCita()
  {
    global $servername, $dbname, $username, $password;
    //Leer el valor del id_usuario
    $correo = $_SESSION["mail"];
    $id_usuario = 0;
    try {
      $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $stringQuery = "SELECT id_usuario FROM usuario_prueba WHERE mail = '" . $correo . "' ";
      //echo $stringQuery ;
      $stmt = $conn->query($stringQuery);
      while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
        $id_usuario = $row[0];
      }
    } catch (PDOException $e) {
      echo $stringQuery . " Error: " . $e->getMessage();
    }
    $conn = null;

    //Leer el valor de pagado
    $pagado = 0;
    try {
      $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $stringQuery = "SELECT pagado FROM licencia WHERE id_usuario = " . $id_usuario . " AND id_asignatura = " . $_SESSION["idAsignatura"] . "";
      //echo $stringQuery ;
      $stmt = $conn->query($stringQuery);
      while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
        $pagado = $row[0];
      }
    } catch (PDOException $e) {
      echo $stringQuery . " Error: " . $e->getMessage();
    }
    $conn = null;
    //echo $pagado;
    echo '
      <!----------------------------------------------CITA--------------------------------------------->
      <div class="container">
          <div class="row">
            <div class="text-center col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
              <p style="color:rgba(0,0,0,0)">.</p>
              <p><strong>Bienvenido a Kaanbal</strong></p>
              <!--p>Hemos mejorado la experiencia para todos los dispositivos.</p-->
              <!--p>Ahora kaanbal se puede abrir desde cualquier dispositivo usando tu navegador</p-->
              <p style="color:rgba(0,0,0,0)">.</p>';
    if ($pagado == 0) {
      echo '
              <!--p>¡Sigue acumulando diamantes! Recuerda <a href="../../../contacto.html">adquirir</a> tu licencia antes del 4 de septiembre.  Seguiremos aquí cuando más nos necesites. </p-->
              <!--p>Por seguridad, cerraremos las cuentas que NO hayan cambiado el password</p>
              <p>Revisa si completaste correctamente el proceso en <a href="../../../contacto.html">pagos</a></p>
              <p style="color:rgba(0,0,0,0)">.</p-->';
    }
    echo '
            </div>
          </div>
        </div>
      <!------------------------------------------------FIN CITA----------------------------------------------->
    ';
  }

  function imprimirSiempreAparece()
  {
    echo '
        <div class="container">
        <div class="row">
          <div class="text-center col-xs-1 col-sm-1 col-md-2 col-lg-3 col-xl-3"></div>
          <a href="subtemas.php">
            <div class="temaPrincipal1 text-center col-xs-10 col-sm-10 col-md-8 col-lg-6 col-xl-6">
              <table class="table">
                <tbody>
                  <tr>
                    <td width="20%">
                      <img class="icons" src="../CSSsJSs/icons/1.svg" />
                    </td>
                    <td width="10%" class="separadorTemasPrincipales">|</td>
                    <td width="70%" class="tituloTemasPrincipales">
                      Siempre Aparece
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </a>
          <div class="text-center col-xs-1 col-sm-1 col-md-2 col-lg-3 col-xl-3"></div>
        </div>
      </div>

      <div class="container">
        <div class="row">
          <p></p>
        </div>
      </div>
    ';
  }


  function imprimirTema($numeroTema, $idTema, $nombreTema)
  {
    $numeroCSSTema = 1 + $numeroTema % 4;
    //Como decidiras que color elegir "temaPrincipal(1,2,3,4) "
    echo '
      <div class="container">
        <div class="row">
          <div class="text-center col-xs-1 col-sm-1 col-md-2 col-lg-3 col-xl-3"></div>
          <a href="subtemas.php?tema=' . $idTema . '">
            <div class="temaPrincipal' . $numeroCSSTema . ' text-center col-xs-10 col-sm-10 col-md-8 col-lg-6 col-xl-6">
              <table class="table">
                <tbody>
                  <tr>
                    <td width="20%">
                      <img class="icons" src="../CSSsJSs/icons/' . $numeroTema . '.svg" />
                    </td>
                    <td width="10%" class="separadorTemasPrincipales">|</td>
                    <td width="70%" class="tituloTemasPrincipales">' . $nombreTema . '</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </a>
          <div class="text-center col-xs-1 col-sm-1 col-md-2 col-lg-3 col-xl-3"></div>
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
      <div class="container">
        <div class="row">
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12"></div>
          <div class="col-xs-11 col-sm-11 col-md-11 col-lg-11 col-xl-11"></div>
          <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10 col-xl-10"></div>
          <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9 col-xl-9"></div>
          <div class="col-xs-8 col-sm-9 col-md-8 col-lg-8 col-xl-8"></div>
          <div class="col-xs-7 col-sm-7 col-md-7 col-lg-7 col-xl-7"></div>
          <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 col-xl-6"></div>
          <div class="col-xs-5 col-sm-5 col-md-5 col-lg-5 col-xl-5"></div>
          <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 col-xl-4"></div>
          <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 col-xl-3"></div>
          <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 col-xl-2"></div>
          <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1 col-xl-1"></div>
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