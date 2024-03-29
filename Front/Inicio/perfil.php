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
  <title>Perfil</title>
  <link rel="stylesheet" href="../CSSsJSs/<?php echo $bootstrap441; ?>" />
  <link rel="stylesheet" href="../CSSsJSs/<?php echo $kaanbalEssentials; ?>" />
  <link rel="stylesheet" href="perfil05.css" />
  <script src="perfil.js"></script>
  <script src="../CSSsJSs/<?php echo $minAJAX; ?>"></script>

  <!-- Global site tag (gtag.js) - Google Analytics -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=G-F7VGWM5LKB"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'G-F7VGWM5LKB');
  </script>
  
</head>

<body>
  <!----------------------------------------------TITULO--------------------------------------------->

  <?php
  //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++//
  //+++++++++++++++++++++++++ Variables de sesion ++++++++++++++++++++++++//
  //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++//
  session_start();

  $iduser = $_SESSION["id_usuario"];
  $usuarioCorreo = $_SESSION["mail"];
  $materia = $_SESSION["asignaturaNavegacion"];
  ?>

  <?php
  $con = mysqli_connect("localhost", "u526597556_dev", "1BLeeAgwq1*isgm&jBJe", "u526597556_kaanbal");
  $query = "SELECT id_asignatura FROM asignatura WHERE nombre = '$materia'";
  $result = mysqli_query($con, $query);
  while ($row = mysqli_fetch_assoc($result)) {
    $arrayidMateria[] = $row;
  }
  $idMateria =  $arrayidMateria[0]["id_asignatura"]; //De aqui se obtendra el id de asignatura

  if (is_null($idMateria)) {
    $query = "SELECT id_asignatura FROM asignatura WHERE names = '$materia'";
    $result = mysqli_query($con, $query);
    while ($row = mysqli_fetch_assoc($result)) {
      $arrayidMateria[] = $row;
    }
    $idMateria =  $arrayidMateria[0]["id_asignatura"]; //De aqui se obtendra el id de asignatura
  }
  $_SESSION["idAsignatura"] = $idMateria;
  /* echo '<script type="text/javascript">
                      alert("'.$idMateria.'");
                      </script>';  */

  $query = "SELECT matricula FROM alumno WHERE id_usuario = $iduser";
  $result = mysqli_query($con, $query);
  while ($row = mysqli_fetch_assoc($result)) {
    $mailArray[] = $row;
  }
  $mail = $mailArray[0]["matricula"]; //De aqui se obtendra la matricula del usuario

  $matricula = $mail;

  $query = "SELECT avatar FROM alumno WHERE id_usuario = $iduser";
  $result = mysqli_query($con, $query);
  while ($row = mysqli_fetch_assoc($result)) {
    $avatarArray[] = $row;
  }
  $avatarActual = $avatarArray[0]["avatar"]; //De aqui se obtendra el avatar del usuario



  $porcentajeAvance = "";
  echo "<!--" . $iduser . " y " . $idMateria . "-->";
  //Total de lecciones de la asignatura = 100%
  try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stringQuery = "SELECT COUNT(*) FROM leccion WHERE id_subtema IN (SELECT id_subtema FROM subtema WHERE id_tema IN (SELECT id_tema FROM tema WHERE id_asignatura = " . $idMateria . "))";
    $stmt = $conn->query($stringQuery);
    while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
      $totalLeccionesAsignatura = $row[0];
    }
  } catch (PDOException $e) {
    echo "Error en total lecciones: " . $e->getMessage();
  }
  $conn = null;

  //Todos los registros de puntuacion donde el alumno tenga algo
  try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stringQuery = "SELECT COUNT(*) FROM leccion WHERE id_leccion IN (SELECT id_leccion FROM puntuacion WHERE tipo = 'PP' AND id_usuario = " . $iduser . " AND id_leccion IN (SELECT id_leccion FROM leccion WHERE id_subtema IN (SELECT id_subtema FROM subtema WHERE id_tema IN (SELECT id_tema FROM tema WHERE id_asignatura = " . $idMateria . "))))";
    $stmt = $conn->query($stringQuery);
    while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
      $totalLeccionesJugadas = $row[0];
    }
  } catch (PDOException $e) {
    echo "Error en lecciones jugadas: " . $e->getMessage();
  }
  $conn = null;

  $porcentaje = (int)$totalLeccionesJugadas / (int)$totalLeccionesAsignatura;
  $porcentaje = 100 * (float)$porcentaje;
  $porcentaje = round($porcentaje);
  if ($porcentaje > 100) {
    $porcentaje = 100;
  }
  $porcentajeAvance = strval($porcentaje) . "%";

  ////////////////////////////////////////////////////////////////////////////////////
  $statement = mysqli_prepare($con, "SELECT SUM(puntuacion) FROM puntuacion WHERE id_usuario = ?");
  mysqli_stmt_bind_param($statement, "i", $iduser);
  mysqli_stmt_execute($statement);
  mysqli_stmt_store_result($statement);
  mysqli_stmt_bind_result($statement, $points);

  $arregloPoints = array();

  while (mysqli_stmt_fetch($statement)) {
    $arregloPoints[0]["diamantes"] = $points;
  }
  if ($arregloPoints[0]["diamantes"]) {
    $diamantes = $arregloPoints[0]["diamantes"];
  } else {
    $diamantes = 0;
  }

  //////////////////////////////////////

  imprimirVistaPerfil($matricula, $materia, $porcentajeAvance, $avatarActual, $diamantes);

  ?>

  <?php
  function imprimirVistaPerfil($matricula, $materia, $porcentajeAvance, $avatarActual, $diamantes)
  {
    imprimirTop();
    imprimirMatricula($matricula);
    imprimirAvanceMateria($materia, $porcentajeAvance);
    imprimirAvatarActual($avatarActual);
    imprimirComboAvatars();
    imprimirDiamantes($diamantes);
    if ($_SESSION["mostrarMenuprofesor"] == '') {
      imprimirInfoEstudiante();
      imprimirCalificacion($matricula);
    }
    imprimirPagos();
    imprimirFooter();
  }
  ?>

  <?php
  function imprimirTop()
  {
    echo '
  <div class="top">
    <div class="container">
      <div class="row">
        <div class="text-center col-2 col-sm-2 col-md-2 col-lg-1 col-xl-1">
          <img class="iconoPrincipal" src="../CSSsJSs/icons/physics.svg" />
        </div>
        <div class="text-center col-10 col-sm-10 col-md-10 col-lg-11 col-xl-11">
          <p class="Ciencia fuenteTitulo" id="asignaturad">' . $_SESSION["asignaturaNavegacion"] . '</p>
          <p class="Ciencia fuenteTitulo" id="asignatura" style="display:none">' . $_SESSION["idAsignatura"] . '</p>
        </div>
      </div>
    </div>
  </div>
  <!------------------------------------------------FIN TITULO----------------------------------------------->
        ';

    imprimirRelleno();
  }

  function imprimirMatricula($matricula)
  {
    echo '
          <div class="container">
            <div class="row">
              <div class="col-1 col-sm-1 col-md-2 col-lg-3 col-xl-3"></div>
              <div class="col-10 col-sm-10 col-md-8 col-lg-6 col-xl-6">
                <p class="text-center" id="matricula">' . $matricula . '</p>
              </div>
              <div class="col-1 col-sm-1 col-md-2 col-lg-3 col-xl-3"></div>
            </div>
          </div>
    ';
  }

  function imprimirAvanceMateria($materia, $porcentajeAvance)
  {
    echo '
          <div class="container">
            <div class="row">
              <div class="col-1 col-sm-1 col-md-2 col-lg-3 col-xl-3"></div>
              <div class="col-10 col-sm-10 col-md-8 col-lg-6 col-xl-6">
                <h2 class="text-center">
                  ' . $materia . '   ' . $porcentajeAvance . '
                </h2>
              </div>
              <div class="col-1 col-sm-1 col-md-2 col-lg-3 col-xl-3"></div>
            </div>
          </div>
    ';
    imprimirRelleno();
  }


  function imprimirAvatarActual($avatarActual)
  {
    if (empty($avatarActual) || $avatarActual == null) {
      $avatarActual = "avatar.jpg";
      echo '
          <div class="container" id="avatarActual">
            <div class="row">
              <div class="col-1 col-sm-1 col-md-2 col-lg-3 col-xl-3"></div>
              <div class="col-10 col-sm-10 col-md-8 col-lg-6 col-xl-6">
                <img src="../CSSsJSs/images/' . $avatarActual . '" class="avatarImg" id="editarAvatar" />
              </div>
              <div class="col-1 col-sm-1 col-md-2 col-lg-3 col-xl-3"></div>
            </div>
          </div>
      ';
    } else if (file_exists("../CSSsJSs/images/" . $avatarActual)) {
      echo '
          <div class="container" id="avatarActual">
            <div class="row">
              <div class="col-1 col-sm-1 col-md-2 col-lg-3 col-xl-3"></div>
              <div class="col-10 col-sm-10 col-md-8 col-lg-6 col-xl-6">
                <img src="../CSSsJSs/images/' . $avatarActual . '" class="avatarImg" id="editarAvatar" />
              </div>
              <div class="col-1 col-sm-1 col-md-2 col-lg-3 col-xl-3"></div>
            </div>
          </div>
      ';
    } else {
      echo "<p>Error al intentar buscar ../CSSsJSs/images/" . $avatarActual . "</p>";
    }
  }

  function imprimirComboAvatars()
  {
    echo '
            <div class="container ocultarOpciones" id="avatarElegir">
              <div class="row">
                <div class="col-4 col-sm-4 col-md-2 col-lg-2 col-xl-2">
                  <img src="../CSSsJSs/images/avatar.jpg" class="avatarOpciones" id="avatar1" />
                </div>
                <div class="col-4 col-sm-4 col-md-2 col-lg-2 col-xl-2">
                  <img src="../CSSsJSs/images/avatar2.jpg" class="avatarOpciones" id="avatar2" />
                </div>
                <div class="col-4 col-sm-4 col-md-2 col-lg-2 col-xl-2">
                  <img src="../CSSsJSs/images/avatar3.jpg" class="avatarOpciones" id="avatar3" />
                </div>
                <div class="col-4 col-sm-4 col-md-2 col-lg-2 col-xl-2">
                  <img src="../CSSsJSs/images/avatar4.jpg" class="avatarOpciones" id="avatar4" />
                </div>
                <div class="col-4 col-sm-4 col-md-2 col-lg-2 col-xl-2">
                  <img src="../CSSsJSs/images/avatar5.png" class="avatarOpciones" id="avatar5" />
                </div>
                <div class="col-4 col-sm-4 col-md-2 col-lg-2 col-xl-2">
                  <img src="../CSSsJSs/images/avatar6.png" class="avatarOpciones" id="avatar6" />
                </div>
              </div>
              <div class="row">
                <div class="col-4 col-sm-4 col-md-2 col-lg-2 col-xl-2">
                  <img src="../CSSsJSs/images/avatar7.jpg" class="avatarOpciones" id="avatar7" />
                </div>
                <div class="col-4 col-sm-4 col-md-2 col-lg-2 col-xl-2">
                  <img src="../CSSsJSs/images/avatar8.jpg" class="avatarOpciones" id="avatar8" />
                </div>
                <div class="col-4 col-sm-4 col-md-2 col-lg-2 col-xl-2">
                  <img src="../CSSsJSs/images/avatar9.jpg" class="avatarOpciones" id="avatar9" />
                </div>
                <div class="col-4 col-sm-4 col-md-2 col-lg-2 col-xl-2">
                  <img src="../CSSsJSs/images/avatar10.jpg" class="avatarOpciones" id="avatar10" />
                </div>
                <div class="col-4 col-sm-4 col-md-2 col-lg-2 col-xl-2">
                  <img src="../CSSsJSs/images/avatar11.jpg" class="avatarOpciones" id="avatar11" />
                </div>
                <div class="col-4 col-sm-4 col-md-2 col-lg-2 col-xl-2">
                  <img src="../CSSsJSs/images/avatar12.png" class="avatarOpciones" id="avatar12" />
                </div>
              </div>
              <div class="row">
                <div class="col-4 col-sm-4 col-md-2 col-lg-2 col-xl-2">
                  <img src="../CSSsJSs/images/avatar13.jpg" class="avatarOpciones" id="avatar13" />
                </div>
                <div class="col-4 col-sm-4 col-md-2 col-lg-2 col-xl-2">
                  <img src="../CSSsJSs/images/avatar14.jpg" class="avatarOpciones" id="avatar14" />
                </div>
                <div class="col-4 col-sm-4 col-md-2 col-lg-2 col-xl-2">
                  <img src="../CSSsJSs/images/avatar15.jpg" class="avatarOpciones" id="avatar15" />
                </div>
                <div class="col-4 col-sm-4 col-md-2 col-lg-2 col-xl-2">
                  <img src="../CSSsJSs/images/avatar16.jpg" class="avatarOpciones" id="avatar16" />
                </div>
                <div class="col-4 col-sm-4 col-md-2 col-lg-2 col-xl-2">
                  <img src="../CSSsJSs/images/avatar17.jpg" class="avatarOpciones" id="avatar17" />
                </div>
                <div class="col-4 col-sm-4 col-md-2 col-lg-2 col-xl-2">
                  <img src="../CSSsJSs/images/avatar18.jpg" class="avatarOpciones" id="avatar18" />
                </div>
              </div>
              <div class="row">
                <div class="col-4 col-sm-4 col-md-2 col-lg-2 col-xl-2">
                  <img src="../CSSsJSs/images/avatar19.jpg" class="avatarOpciones" id="avatar19" />
                </div>
                <div class="col-4 col-sm-4 col-md-2 col-lg-2 col-xl-2">
                  <img src="../CSSsJSs/images/avatar20.jpg" class="avatarOpciones" id="avatar20" />
                </div>
                <div class="col-4 col-sm-4 col-md-2 col-lg-2 col-xl-2">
                  <img src="../CSSsJSs/images/avatar21.png" class="avatarOpciones" id="avatar21" />
                </div>
                <div class="col-4 col-sm-4 col-md-2 col-lg-2 col-xl-2">
                  <img src="../CSSsJSs/images/avatar22.jpg" class="avatarOpciones" id="avatar22" />
                </div>
                <div class="col-4 col-sm-4 col-md-2 col-lg-2 col-xl-2">
                  <img src="../CSSsJSs/images/avatar23.jpg" class="avatarOpciones" id="avatar23" />
                </div>
                <div class="col-4 col-sm-4 col-md-2 col-lg-2 col-xl-2">
                  <img src="../CSSsJSs/images/avatar24.jpg" class="avatarOpciones" id="avatar24" />
                </div>
              </div>
              <div class="row">
                <div class="col-4 col-sm-4 col-md-2 col-lg-2 col-xl-2">
                  <img src="../CSSsJSs/images/avatar25.jpg" class="avatarOpciones" id="avatar25" />
                </div>
                <div class="col-4 col-sm-4 col-md-2 col-lg-2 col-xl-2">
                  <img src="../CSSsJSs/images/avatar26.jpg" class="avatarOpciones" id="avatar26" />
                </div>
                <div class="col-4 col-sm-4 col-md-2 col-lg-2 col-xl-2">
                  <img src="../CSSsJSs/images/avatar27.jpg" class="avatarOpciones" id="avatar27" />
                </div>
                <div class="col-4 col-sm-4 col-md-2 col-lg-2 col-xl-2">
                  <img src="../CSSsJSs/images/avatar28.jpg" class="avatarOpciones" id="avatar28" />
                </div>
                <div class="col-4 col-sm-4 col-md-2 col-lg-2 col-xl-2">
                  <img src="../CSSsJSs/images/avatar29.jpg" class="avatarOpciones" id="avatar29" />
                </div>
                <div class="col-4 col-sm-4 col-md-2 col-lg-2 col-xl-2">
                  <img src="../CSSsJSs/images/avatar30.jpg" class="avatarOpciones" id="avatar30" />
                </div>
              </div>
              <div class="row">
                <div class="col-4 col-sm-4 col-md-2 col-lg-2 col-xl-2">
                  <img src="../CSSsJSs/images/avatar31.jpg" class="avatarOpciones" id="avatar31" />
                </div>
                <div class="col-4 col-sm-4 col-md-2 col-lg-2 col-xl-2">
                  <img src="../CSSsJSs/images/avatar32.png" class="avatarOpciones" id="avatar32" />
                </div>
                <div class="col-4 col-sm-4 col-md-2 col-lg-2 col-xl-2">
                  <img src="../CSSsJSs/images/avatar33.png" class="avatarOpciones" id="avatar33" />
                </div>
                <div class="col-4 col-sm-4 col-md-2 col-lg-2 col-xl-2">
                  <img src="../CSSsJSs/images/avatar34.jpg" class="avatarOpciones" id="avatar34" />
                </div>
                <div class="col-4 col-sm-4 col-md-2 col-lg-2 col-xl-2">
                  <img src="../CSSsJSs/images/avatar35.jpg" class="avatarOpciones" id="avatar35" />
                </div>
                <div class="col-4 col-sm-4 col-md-2 col-lg-2 col-xl-2">
                  <img src="../CSSsJSs/images/avatar36.jpg" class="avatarOpciones" id="avatar36" />
                </div>
              </div>
              <div class="row">
                <button type="button" class="btn btn-success" id="guardarAvatar">
                  Guardar
                </button>
              </div>
            </div>    
    ';
    imprimirRelleno();
  }

  function imprimirDiamantes($diamantes)
  {
    echo '
          <div class="container">
            <div class="row">
              <div class="col-2 col-sm-2 col-md-2 col-lg-2 col-xl-2"></div>
              <div class="col-4 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                <img class="icons imgRight" src="../CSSsJSs/icons/diamante.svg" />
              </div>
              <div class="col-4 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                <h2 class="textLeft" style="display:block;margin:auto;">' . $diamantes . '</h2>
              </div>
              <div class="col-2 col-sm-2 col-md-2 col-lg-2 col-xl-2"></div>
            </div>
          </div>
    ';
    imprimirRelleno();
  }

  function imprimirCalificacion($matricula)
  {
    echo '
          <div class="container">
            <div class="row">
              <div class="centrarObjeto col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <h2 style="text-align:center;">Calificaciones</h2>
              </div>
            </div>
          </div>
    ';
    echo '<div class="container">
            <div class="row">
                <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                    <form action="calificaciones.php" id="groupForm" method="POST">
                      <label for="mail" style="display:none;">Mail</label>
                      <input type="text" id="mail" name="mail" value="' . $matricula . '" style="display:none;"><br><br>

                      <input type="submit" class="btn btn-primary" value="Práctica, Sprint y Examen" style="display:block; margin:0px auto; word-wrap: break-word;"><br>
                    </form>
                </div>
            </div>
          </div>';
    imprimirRelleno();
  }



  function imprimirRelleno()
  {
    echo '
          <div class="container">
            <div class="row">
              <p class="relleno">.</p>
            </div>
            <div class="row">
              <p class="relleno">.</p>
            </div>
          </div>
    ';
  }

  function imprimirPagos()
  {
    //1.- Conocer el status de market_pay_status del usuario
    //2.- Si el alumno tiene un pago exitoso NO mostrar los metodos de pago
    //3.- Si el alumno tiene un pago pendiente mostrar Pago pendiente
    //3.1.- Mostrar mensaje de pago pendiente y las opciones de pago
    //4.- ELSE Mostrar opciones de pago

    //1.- Conocer el status de market_pay_status del usuario
    global $servername, $dbname, $username, $password;
    $paymentStatus = NULL;
    $vigencia = NULL;
    try {
      $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $stringQuery = 'SELECT vigencia, payment_status FROM licencia JOIN payment_status ON payment_status.id_payment_status = licencia.market_pay_status WHERE id_usuario = ' . $_SESSION["id_usuario"] . ' AND id_asignatura = ' . $_SESSION["idAsignatura"] . ' ORDER BY vigencia DESC LIMIT 1';
      $stmt = $conn->query($stringQuery);
      while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
        $vigencia = $row[0];
        $paymentStatus = $row[1];
      }
    } catch (PDOException $e) {
      echo "Error: " .  $e->getMessage() . " en Query " . $stringQuery;
    }
    $conn = null;

    //2.-Si el alumno tiene un pago exitoso, NO mostrar los metodos de pago
    if ($paymentStatus == "approved") {
      echo '
      <div class="container" style="
        background-color: rgba(35, 85, 145, 0.9);
        color: white;
        border-radius: 1vw;
      ">
        <div class="row">
          <div class="col-3 col-sm-3 col-md-3 col-lg-3 col-xl-3">
            <p class="text-center estatusPago" style="margin:auto;">Pagado</p>
          </div>
          <div class="col-9 col-sm-9 col-md-9 col-lg-9 col-xl-9">
            <p class="text-center estatusPago">Vigencia: ' . $vigencia . '</p>
          </div>
        </div>
      </div>
      ';
    }
    //3.- Si el alumno tiene un pago pendiente mostrar Pago pendiente
    //3.1.- Mostrar mensaje de pago pendiente y las opciones de pago
    else if ($paymentStatus == "pending") {
      echo '
      <div class="container" style="
        background-color: rgba(225, 115, 0, 0.9);
        color: white;
        border-radius: 1vw;
      ">
        <div class="row">
          <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <p class="text-center estatusPago">Pago pendiente</p>
          </div>
        </div>
      </div>
      ';
      imprimirOpcionesDePago();
    }
    //4.- ELSE Mostrar opciones de pago
    else {
      imprimirOpcionesDePago();
    }

    imprimirRelleno();
    imprimirRelleno();
  }

  function imprimirOpcionesDePago()
  {
    imprimirRelleno();
    echo '
    <div class="container">
      <div class="row">
        <div class="centrarObjeto col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
          <h2 class="comprar" style="text-align:center;">Vuélvete premium</h2>
        </div>
      </div>
      <div class="row">
        <div class=" col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
          <p style="color:rgba(0,0,0,0);">./p>
        </div>
      </div>
    </div>
    ';
    //imprimirConFactura();
    imprimirSinFactura();
    imprimirRelleno();
  }

  function imprimirConFactura()
  {
    echo '
    <!--++++++++++++++++++++++++++++++++++++++CON FACTURA++++++++++++++++++++++++++++++++++++++-->
    <div class="container">
      <div class="row">
        <div class="col-2 col-sm-2 col-md-3 col-lg-3 col-xl-3"></div>
        <div
          class="col-6 col-sm-6 col-md-5 col-lg-5 col-xl-5"
          id="conFactura1"
          style="border-bottom: 2px solid rgba(200, 200, 200, 0.8)"
        >
          <p class="comprarf">Pago - con factura</p>
        </div>
        <div
          class="col-2 col-sm-2 col-md-1 col-lg-1 col-xl-1"
          id="conFactura2"
          style="border-bottom: 2px solid rgba(200, 200, 200, 0.8)"
        >
          <img
            src="../CSSsJSs/icons/FlechaIzq.svg"
            width="20px"
            style="
              transform: rotate(270deg);
              display: block;
              margin: 1vw 0px;
            "
          />
        </div>
        <div class="col-2 col-sm-2 col-md-3 col-lg-3 col-xl-3"></div>
      </div>
    </div>
  
    <div id="conFactura" class="ocultarOpciones">
      <!--Relleno-->
      <div class="container">
        <div class="row">
          <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <p class="transparente">.</p>
          </div>
        </div>
      </div>
      <!--RFC y Razon Social-->
      <div class="container">
        <div class="row">
          <div class="d-none d-lg-block col-lg-1 col-xl-1"></div>
          <div class="input-group col-12 col-sm-12 col-md-12 col-lg-5 col-xl-5">
            <div class="input-group-prepend">
              <span class="input-group-text">RFC</span>
            </div>
            <label for="rfc" style="font-size: 0px; line-height: 0px; margin: 0px"
              >RFC</label
            >
            <input
              id="rfc"
              name="rfc"
              type="text"
              class="form-control"
              style="text-transform: uppercase;"
              placeholder="XXXX900101ABC"
              form="datosConFactura"
              required
            />
          </div>
  
          <div class="col-12 col-sm-12 col-md-12 d-lg-none">
            <p class="transparente">.</p>
          </div>
  
          <div class="input-group col-12 col-sm-12 col-md-12 col-lg-5 col-xl-5">
            <div class="input-group-prepend">
              <span class="input-group-text">Razón Social</span>
            </div>
            <label
              for="razonSocial"
              style="font-size: 0px; line-height: 0px; margin: 0px"
              >Razón Social</label
            >
            <input
              id="razonSocial"
              name="razonSocial"
              type="text"
              class="form-control"
              style="text-transform: uppercase;"
              placeholder="JUAN GARCIA RODRIGUEZ"
              form="datosConFactura"
              required
            />
          </div>
          <div class="d-none d-lg-block col-lg-1 col-xl-1"></div>
        </div>
      </div>
  
      <!--Relleno-->
      <div class="container">
        <div class="row">
          <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <p class="transparente">.</p>
          </div>
        </div>
      </div>
      <!--Correo-->
      <div class="container">
        <div class="row">
          <div class="d-none d-lg-block col-lg-1 col-xl-1"></div>
          <div class="input-group col-12 col-sm-12 col-md-12 col-lg-5 col-xl-5">
            <div class="input-group-prepend">
              <span class="input-group-text">Correo</span>
            </div>
            <label
              for="userMailWithInvoice"
              style="font-size: 0px; line-height: 0px; margin: 0px"
              >Correo</label
            >
            <input
              id="userMailWithInvoice"
              name="userMailWithInvoice"
              type="text"
              class="form-control"
              style="text-transform: lowercase;"
              value="' . $_SESSION["mail"] . '"
              form="datosConFactura"
            />
          </div>
  
          <div class="col-12 col-sm-12 col-md-12 d-lg-none">
            <p class="transparente">.</p>
          </div>
  
          <div class="input-group col-12 col-sm-12 col-md-12 col-lg-5 col-xl-5">
            <p
              style="
                font-size: x-small;
                text-align: center;
                display: block;
                margin: auto auto 0px auto;
              "
            >
              Este es el correo que usas como usuario en Kaanbal. Si el correo NO
              es el correcto, ingresa a Kaanbal nuevamente, con el correo que
              deseas volver premium
            </p>
          </div>
          <div class="d-none d-lg-block col-lg-1 col-xl-1"></div>
        </div>
      </div>
  
      <!--Relleno-->
      <div class="container">
        <div class="row">
          <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <p class="transparente">.</p>
          </div>
        </div>
      </div>
  
      <!--Mensaje sobre la factura-->
      <div class="container">
        <div class="row">
          <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <p
              style="
                font-size: small;
                text-align: center;
                display: block;
                margin: auto auto 0px auto;
              "
            >
              La factura la encontrarás en el portal del SAT, en 10 días hábiles.
              Cualquier duda o aclaración estamos a tus órdenes
              aclaraciones@kaanbal.net
            </p>
          </div>
        </div>
      </div>
  
      <!--Relleno-->
      <div class="container">
        <div class="row">
          <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <p class="transparente">.</p>
          </div>
          <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <p class="transparente">.</p>
          </div>
        </div>
      </div>
      <!--Boton Donar-->
      <div class="container">
        <div class="row">
          <div class="col-4 col-sm-4 col-md-4 col-lg-4 col-xl-4">
            <img
              src="../CSSsJSs/images/mercadoPagoLogo.png"
              class="logoPagos"
              style="margin: auto 0px auto auto"
            />
          </div>
          <div class="col-4 col-sm-4 col-md-4 col-lg-4 col-xl-4">
            <form
              id="datosConFactura"
              action="../pagoSeguro/mpcf.php"
              method="POST"
              enctype="application/x-www-form-urlencoded"
            >
              <button type="submit" class="btn btn-primary centrarObjeto">
                Donar
              </button>
            </form>
          </div>
          <div class="col-4 col-sm-4 col-md-4 col-lg-4 col-xl-4">
            <img
              src="../CSSsJSs/images/paypalLogo.png"
              class="logoPagos"
              style="margin: auto auto auto 0px"
            />
          </div>
        </div>
      </div>
    </div>
    <!--Relleno-->
    <div class="container">
      <div class="row">
        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
          <p class="transparente">.</p>
        </div>
      </div>
    </div>
    ';
  }


  function imprimirSinFactura()
  {
    echo '
    <!--++++++++++++++++++++++++++++++++++++++SIN FACTURA++++++++++++++++++++++++++++++++++++++-->
    <div class="container">
      <div class="row">
        <div class="col-2 col-sm-2 col-md-3 col-lg-3 col-xl-3"></div>
        <div
          class="col-6 col-sm-6 col-md-5 col-lg-5 col-xl-5"
          id="sinFactura1"
          style="border-bottom: 2px solid rgba(200, 200, 200, 0.8)"
        >
          <p class="comprarf">Dona aquí</p>
        </div>
        <div
          class="col-2 col-sm-2 col-md-1 col-lg-1 col-xl-1"
          id="sinFactura2"
          style="border-bottom: 2px solid rgba(200, 200, 200, 0.8)"
        >
          <img
            src="../CSSsJSs/icons/FlechaIzq.svg"
            width="20px"
            style="
              transform: rotate(270deg);
              display: block;
              margin: 1vw 0px;
            "
          />
        </div>
        <div class="col-2 col-sm-2 col-md-3 col-lg-3 col-xl-3"></div>
      </div>
    </div>
  
    <div id="sinFactura" class="ocultarOpciones">
      <div class="container">
        <div class="row">
          <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <p class="transparente">.</p>
          </div>
        </div>
      </div>
      <!--Relleno-->
      <div class="container">
        <div class="row">
          <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <p class="transparente">.</p>
          </div>
        </div>
      </div>
      <!--Correo-->
      <div class="container">
        <div class="row">
          <div class="d-none d-lg-block col-lg-1 col-xl-1"></div>
          <div class="input-group col-12 col-sm-12 col-md-12 col-lg-5 col-xl-5">
            <div class="input-group-prepend">
              <span class="input-group-text">Correo</span>
            </div>
            <label
              for="userMailNoInvoice"
              style="font-size: 0px; line-height: 0px; margin: 0px"
              >Correo</label
            >
            <input
              id="userMailNoInvoice"
              name="userMailNoInvoice"
              type="text"
              class="form-control"
              style="text-transform: lowercase;"
              value="' . $_SESSION["mail"] . '"
              form="datosSinFactura"
            />
          </div>
  
          <div class="col-12 col-sm-12 col-md-12 d-lg-none">
            <p class="transparente">.</p>
          </div>

          <div class="input-group col-12 col-sm-12 col-md-12 col-lg-5 col-xl-5">
            <p
              style="
                font-size: x-small;
                text-align: center;
                display: block;
                margin: auto auto 0px auto;
              "
            >
              Este es el correo que usas como usuario en Kaanbal. Si el correo no
              es el correcto, ingresa a Kaanbal nuevamente, con el correo que
              deseas volver premium
            </p>
          </div>
          <div class="d-none d-lg-block col-lg-1 col-xl-1"></div>
        </div>
      </div>
  
      <div class="container">
        <div class="row">
          <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <p class="transparente">.</p>
          </div>
          <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <p class="transparente">.</p>
          </div>
          <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <p class="transparente">.</p>
          </div>
        </div>
      </div>
  
      <div class="container">
        <div class="row">
          <div class="col-4 col-sm-4 col-md-4 col-lg-4 col-xl-4">
            <img
              src="../CSSsJSs/images/mercadoPagoLogo.png"
              class="logoPagos"
              style="margin: auto 0px auto auto"
            />
          </div>
          <div class="col-4 col-sm-4 col-md-4 col-lg-4 col-xl-4">
            <form
              id="datosSinFactura"
              action="../pagoSeguro/mpsf.php"
              method="POST"
              enctype="application/x-www-form-urlencoded"
            >
              <button type="submit" class="btn btn-primary centrarObjeto">
                Donar
              </button>
            </form>
          </div>
          <div class="col-4 col-sm-4 col-md-4 col-lg-4 col-xl-4">
            <img
              src="../CSSsJSs/images/paypalLogo.png"
              class="logoPagos"
              style="margin: auto auto auto 0px"
            />
          </div>
        </div>
      </div>
      <!--Relleno-->
      <div class="container">
        <div class="row">
          <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <p class="transparente">.</p>
          </div>
        </div>
      </div>
    </div>
    <!--Relleno-->
    <div class="container">
      <div class="row">
        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
          <p class="transparente">.</p>
        </div>
      </div>
    </div>
    
    ';
  }

  function imprimirInfoEstudiante()
  {
    global $iduser, $idMateria;
    global $servername, $dbname, $username, $password;
    //$iduser = $_SESSION["id_usuario"];
    echo '
      <div class="container">
        <div class="row">
          <div class="d-none d-md-block col-md-2 col-lg-2 col-xl-2">
          </div>
          <div class="col-12 col-sm-12 col-md-8 col-lg-8 col-xl-8">
            <div class="input-group" style="display:none;">
              <div class="input-group-prepend">
                <span class="input-group-text">User ID</span>
              </div>
              <input type="text" class="form-control" id="idUser" value="' . $iduser . '" >
            </div>
    ';
    //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++//
    //+++++++++++++++++++++++++++ Codigo de grupo ++++++++++++++++++++++++++//
    //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++//
    //Crear la lectura en base de datos
    try {
      $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $stringQuery = 'SELECT id_grupo, codigo FROM grupo WHERE id_asignatura = ' . $idMateria . ' AND id_grupo IN (SELECT id_grupo FROM alumno_grupo WHERE id_alumno IN (SELECT id_alumno FROM alumno WHERE id_usuario = ' . $iduser . ') ) LIMIT 1';
      $stmt = $conn->query($stringQuery);
      while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
        echo '
            <p style="color:rgba(0,0,0,0)">.</p>
            <div class="input-group" style="display:none;">
              <div class="input-group-prepend">
                <span class="input-group-text">Group code</span>
                <span class="input-group-text" id="idGroupCode">' . $row[0] . '</span>
              </div>
              <input type="text" class="form-control" id="groupCode" value="' . $row[1] . '" >
            </div>
            ';
      }
    } catch (PDOException $e) {
      echo "failed: " . $stringQuery . $e->getMessage();
    }
    $conn = null;


    //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++//
    //+++++++++++++++++++++++++++ Numero de lista ++++++++++++++++++++++++++//
    //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++//
    echo '  <p style="color:rgba(0,0,0,0)">.</p>
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text">Número de lista</span>
              </div>
              <select class="custom-select" id="listNumber">';
    //Crear la lectura en base de datos
    try {
      $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $stringQuery = 'SELECT numero_lista FROM alumno WHERE id_usuario = ' . $iduser . ' LIMIT 1;';
      $stmt = $conn->query($stringQuery);
      while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
        echo '<option value="' . $row[0] . '" selected>' . $row[0] . '</option>';
      }
    } catch (PDOException $e) {
      echo "failed: " . $stringQuery . $e->getMessage();
    }
    $conn = null;
    for ($i = 0; $i < 50; $i++) {
      echo '<option value="' . $i . '">' . $i . '</option>';
    }

    echo '    </select>
            </div>';


    //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++//
    //+++++++++++++++++++++++++++ Primer nombre ++++++++++++++++++++++++++++//
    //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++//
    //Crear la lectura en base de datos
    echo '  <p style="color:rgba(0,0,0,0)">.</p>
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text">Primer nombre</span>
              </div>
              <select class="custom-select" id="idFirstName">';
    try {
      $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $stringQuery = 'SELECT id_nombre, nombre FROM nombre WHERE id_nombre IN (SELECT id_nombre FROM alumno WHERE id_usuario = ' . $iduser . ') LIMIT 1;';
      $stmt = $conn->query($stringQuery);
      while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
        echo '<option value="' . $row[0] . '" selected>' . $row[1] . '</option>';
      }
    } catch (PDOException $e) {
      echo "failed: " . $stringQuery . $e->getMessage();
    }
    $conn = null;
    try {
      $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $stringQuery = 'SELECT id_nombre, nombre FROM nombre WHERE nombre NOT LIKE "% %" ORDER BY nombre ASC;';
      $stmt = $conn->query($stringQuery);
      while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
        echo '<option value="' . $row[0] . '">' . $row[1] . '</option>';
      }
    } catch (PDOException $e) {
      echo "failed: " . $stringQuery . $e->getMessage();
    }
    $conn = null;

    echo '    </select>
            </div>
            <!--p style="font-size:x-small; text-align:center ">If your first name is not listed here, send us an email to: <a href="mailto:aclaraciones@kaanbal.net">aclaraciones@kaanbal.net</a></p-->
            <p style="font-size:x-small; text-align:center ">¿Tu primer nombre NO esta en la lista?, envíanos un correo a: <a href="mailto:aclaraciones@kaanbal.net">aclaraciones@kaanbal.net</a>. En menos de 72 horas hábiles tu nombre aparecerá en la lista. </p>
          ';
    echo '  <p style="color:rgba(0,0,0,0)">.</p>
            <div class="input-group input-group-sm">
              <button id="updateStudentInfoButton" type="button" class="btn btn-primary btn-sm" style="display:block;margin:auto;">
                  Actualizar información
              </button>
            </div>
          ';
    echo '
          </div>
          <div class="d-none d-md-block col-md-2 col-lg-2 col-xl-2">
          </div>
        </div>
      </div>
    ';
    imprimirRelleno();
    imprimirRelleno();
  }

  function imprimirFooter()
  {
    echo '
        <div class="foot">
          <div class="container">
            <div class="row text-center">
              <div class="col-3 col-sm-3 col-md-3 col-lg-3 col-xl-3">
                <img class="footIcon" id="botonLecciones" src="../CSSsJSs/icons/business.svg" />
              </div>
              <div class="col-3 col-sm-3 col-md-3 col-lg-3 col-xl-3 ">
                <img class="footIcon" id="botonPerfil" src="../CSSsJSs/icons/identification.svg" />
              </div>
              <div class="col-3 col-sm-3 col-md-3 col-lg-3 col-xl-3">
                <img class="footIcon" id="botonTop" src="../CSSsJSs/icons/top.svg" />
              </div>
              <div class="col-3 col-sm-3 col-md-3 col-lg-3 col-xl-3">
                <img class="footIcon" id="botonLogout" src="../CSSsJSs/icons/logout.svg" />
              </div>
            </div>
          </div>
        </div>
    ';
  }
  ?>





  <!----------------------------------------------FIN PERFIL--------------------------------------------->

  <div class="container">
    <div class="row">
      <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12"></div>
      <div class="col-11 col-sm-11 col-md-11 col-lg-11 col-xl-11"></div>
      <div class="col-10 col-sm-10 col-md-10 col-lg-10 col-xl-10"></div>
      <div class="col-9 col-sm-9 col-md-9 col-lg-9 col-xl-9"></div>
      <div class="col-8 col-sm-9 col-md-8 col-lg-8 col-xl-8"></div>
      <div class="col-7 col-sm-7 col-md-7 col-lg-7 col-xl-7"></div>
      <div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6"></div>
      <div class="col-5 col-sm-5 col-md-5 col-lg-5 col-xl-5"></div>
      <div class="col-4 col-sm-4 col-md-4 col-lg-4 col-xl-4"></div>
      <div class="col-3 col-sm-3 col-md-3 col-lg-3 col-xl-3"></div>
      <div class="col-2 col-sm-2 col-md-2 col-lg-2 col-xl-2"></div>
      <div class="col-1 col-sm-1 col-md-1 col-lg-1 col-xl-1"></div>
    </div>
  </div>

</body>


</html>