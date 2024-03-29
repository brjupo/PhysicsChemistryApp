<?php
require '../../servicios/00DDBBVariables.php';
require "../../servicios/isStaff.php";
//Necesario para los estilos nuevos desde Octubre 2020 
require "../CSSsJSs/mainCSSsJSs.php";
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="shortcut icon" type="image/x-icon" href="../CSSsJSs/icons/pyramid.svg" />
  <title>Asignaturas</title>
  <link rel="stylesheet" href="../CSSsJSs/<?= $bootstrap341 ?>" />
  <link rel="stylesheet" href="../CSSsJSs/<?= $kaanbalEssentials ?>" />
  <link rel="stylesheet" href="Asignaturas.css" />
  <script src="Asignaturas2.js"></script>

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
  <?php
  $con = mysqli_connect("localhost", "u526597556_dev", "1BLeeAgwq1*isgm&jBJe", "u526597556_kaanbal");
  //////////////////////////////////////////////////////
  session_start();

  $tokenValidar = array();

  //-------------------------------------------------//
  //-------------------------------------------------//
  //-------Consultar si existe token de usuario------//
  //-------------------------------------------------//
  //-------------------------------------------------//
  $statement = mysqli_prepare($con, "SELECT tokenSesion FROM usuario_prueba WHERE mail = ?");
  mysqli_stmt_bind_param($statement, "s", $_SESSION["mail"]);
  mysqli_stmt_execute($statement);

  mysqli_stmt_store_result($statement);
  mysqli_stmt_bind_result($statement, $tokenSesionp);

  while (mysqli_stmt_fetch($statement)) {
    $tokenValidar["tokenSesionp"] = $tokenSesionp;
  }

  if ($_SESSION["tokenSesion"] == $tokenValidar["tokenSesionp"] and $tokenValidar["tokenSesionp"] != "") {

    //Consultar si es profe 
    $mostrarMenuprofesor = $_SESSION["mostrarMenuprofesor"];
    $tieneGrupos = $_SESSION["tieneGrupos"];
    $staffID = $_SESSION["siStaff"];

    $arregloAsignaturas = array();
    $arregloAsignaturas = traerAsignaturas();
    imprimirPagina($arregloAsignaturas, $mostrarMenuprofesor, $staffID, $tieneGrupos); //0911 
  } else {
    /* echo'<script type="text/javascript">
            alert("segundo caminio");
            </script>'; */

    $correo = $_POST["validarUsuario"];
    $password = $_POST["validarPassword"];
    $idiomas = $_POST["idioma"];
    //Para evitar SQL injections
    $correo = str_replace(" ", "", $correo);
    $correo = strtolower($correo);
    $password = str_replace(" ", "", $password);
    $idiomas = str_replace(" ", "", $idiomas);


    //Validamos que los campos correo y password no lleguen vacios
    if ($correo == "" or $password == "") {
      echo '<script type="text/javascript">
            alert("Ingresa usuario y/o contraseña");
            window.location.href="https://kaanbal.net";
            </script>';
    } else {

      //Actualizar el idioma que se eligío 
      if ($idiomas == 'e' or $idiomas == 'i') {
        $sql = "UPDATE usuario_prueba SET idioma = '$idiomas' WHERE mail = '$correo'";
        mysqli_query($con, $sql);
      } else {
        $query = "SELECT idioma FROM usuario_prueba WHERE mail = '$correo'";
        $result = mysqli_query($con, $query);
        while ($row = mysqli_fetch_assoc($result)) {
          $idiomareg[] = $row;
        }
        $idiomas = $idiomareg[0]["idioma"];
      }


      //Consultar si existe usuario en tabla alumnos
      $statement = mysqli_prepare($con, "SELECT id_usuario, mail, pass_cifrado, tokenA, tokenSesion, idioma, inicios FROM usuario_prueba WHERE mail = ? AND pass_cifrado = ?");
      mysqli_stmt_bind_param($statement, "ss", $correo, MD5($password));
      mysqli_stmt_execute($statement);

      mysqli_stmt_store_result($statement);
      mysqli_stmt_bind_result($statement, $id_usuario, $mail, $pswd, $tokenA, $tokenSesion, $idioma, $inicios);

      //Leemos datos del usuario
      while (mysqli_stmt_fetch($statement)) { //si si existe el usuario
        $temp_inicios = $inicios;
        $temp_id_usuario = $id_usuario;
        $temp_mail = $mail;
        $temp_pswd = $pswd;
        $temp_tokenA = $tokenA;
        $temp_tokenSesion = $tokenSesion;
        $temp_idioma = $idioma;
      }

      //Si el usuario EXISTE despliega el menú de las asignaturas
      if ($temp_id_usuario) {

        //Consultar si es profesor
        $statement = mysqli_prepare($con, "SELECT id_profesor FROM profesor WHERE id_usuario = ?");
        mysqli_stmt_bind_param($statement, "s", $temp_id_usuario);
        mysqli_stmt_execute($statement);

        mysqli_stmt_store_result($statement);
        mysqli_stmt_bind_result($statement, $idProfe);

        while (mysqli_stmt_fetch($statement)) {
          $existeProfe["profe"] = $idProfe;
        }
        $mostrarMenuprofesor = $existeProfe["profe"];

        //Consultar si tiene grupos creados
        if ($mostrarMenuprofesor != '') {
          $statement = mysqli_prepare($con, "SELECT id_grupo FROM grupo WHERE id_profesor = ? LIMIT 1");
          mysqli_stmt_bind_param($statement, "s", $mostrarMenuprofesor);
          mysqli_stmt_execute($statement);

          mysqli_stmt_store_result($statement);
          mysqli_stmt_bind_result($statement, $idGrupo);

          while (mysqli_stmt_fetch($statement)) {
            $existeGrupo["profe"] = $idGrupo;
          }
          $tieneGrupos = $existeGrupo["profe"];
        }


        //Conteo de inicios de sesión y fecha
        $tiempo = getDatetimeNow();

        $temp_inicios = $temp_inicios + 1;
        $sql = "UPDATE usuario_prueba SET inicios = $temp_inicios, tiempo = '$tiempo' WHERE mail = '$correo'";
        mysqli_query($con, $sql);

        //Creamos token de sesión
        $rand = bin2hex(random_bytes(5));
        //Registrar token de sesion en BD
        $sql = "UPDATE usuario_prueba SET tokenSesion='$rand' WHERE mail = '$correo'";
        mysqli_query($con, $sql);
        //Aactualizamos variables de sesión
        //////IDIOMA
        $_SESSION["idioma"] = $idiomas;
        ////
        $_SESSION["id_usuario"] = $temp_id_usuario;
        $_SESSION["mail"] = $temp_mail;
        $_SESSION["pswd"] = $temp_pswd;
        $_SESSION["tokenA"] = $temp_tokenA;
        $_SESSION["tokenSesion"] = $rand;
        $_SESSION["mostrarMenuprofesor"] = $mostrarMenuprofesor;
        $_SESSION["tieneGrupos"] = $tieneGrupos;

        //consultar si es staff
        $statement = mysqli_prepare($con, "SELECT id_staff FROM staff WHERE id_usuario = ?");
        mysqli_stmt_bind_param($statement, "s", $_SESSION["id_usuario"]);
        mysqli_stmt_execute($statement);

        mysqli_stmt_store_result($statement);
        mysqli_stmt_bind_result($statement, $idstaff);

        while (mysqli_stmt_fetch($statement)) {
          $existestaff["staff"] = $idstaff;
        }

        if ($existestaff["staff"] == "") {
          $staffID = "null";
        } else {
          $staffID = $existestaff["staff"];
        }
        $_SESSION["siStaff"] = $staffID;


        $arregloAsignaturas = array();
        $arregloAsignaturas = traerAsignaturas();
        //todas las asignaturas

        //Comprobar que tiene más de una licencia para no mostrar pantalla de materias
        $query = "SELECT id_usuario FROM usuario_prueba WHERE mail = '$correo'";
        $result = mysqli_query($con, $query);
        while ($row = mysqli_fetch_assoc($result)) {
          $iduser[] = $row;
        }
        /*  echo '<script type="text/javascript">
                      alert("'.$iduser[0]["id_usuario"].'");
                      </script>'; */

        $iduser = $iduser[0]["id_usuario"];

        $query2 = "SELECT count(*) FROM licencia WHERE id_usuario = $iduser"; // WHERE TEMA = 'TEMA' AND SUBTEMA = 'SUBTEMA' AND LECCION = 'LECCION'";
        $result2 = mysqli_query($con, $query2);
        $total = mysqli_fetch_row($result2);

        /* echo '<script type="text/javascript">
                      alert("'.$total[0].'");
                      </script>'; */

        if ($total[0] > 1 or $mostrarMenuprofesor != '' or $staffID != 'null') {
          imprimirPagina($arregloAsignaturas, $mostrarMenuprofesor, $staffID, $tieneGrupos); //09111
        } else { //PARA SALTAR A LA PAGINA DE TEMAS CUANDO NO TIENE MAS DE DOS MATERIAS
          //Traeer asignatura
          $query = "SELECT id_asignatura FROM licencia WHERE id_usuario = '$iduser'";
          $result = mysqli_query($con, $query);
          while ($row = mysqli_fetch_assoc($result)) {
            $idasignatura[] = $row;
          }
          $idMateria = $idasignatura[0]["id_asignatura"];
          $_SESSION["idAsignatura"] = $idMateria;
          echo '<script type="text/javascript">
                          window.location.href="temas.php?asignatura=' . $idMateria . '"; 
                          </script>';
        }

        ///////////////////

      }

      //Si el usuario NO EXISTE mensaje de error y retorna a inicio
      else {
        echo '<script type="text/javascript">
            alert("Usuario y/o contraseña incorrectos\nTienes alguna pregunta consulta nuestras FAQs");
            window.location.href="https://kaanbal.net/FAQs.html";
            </script>';
      }
    }
  }

  //traer licencias disponibles
  function traerAsignaturas()
  {
    /*+++++++++++++++++++++++++++++++++++++++++++++++++++++++*/
    //$asignatura = $_GET['asignatura'];
    /*echo '<script type="text/javascript">
            alert("'.$asignatura.'");
            </script>';
    */
    /*+++++++++++++++++++++++++++++++++++++++++++++++++++++++PROBADO*/
    $con = mysqli_connect("localhost", "u526597556_dev", "1BLeeAgwq1*isgm&jBJe", "u526597556_kaanbal");
    /*----Paso 1 Obtener las asignaturas a las que se tienen permiso ----*/
    //////XXXX
    if ($_SESSION["idioma"] == 'i') {
      $statement = mysqli_prepare($con, "SELECT id_asignatura, names, nivel, grado_academico, idioma FROM asignatura WHERE id_asignatura IN (SELECT id_asignatura FROM licencia WHERE id_usuario = ? AND vigencia > NOW())");
    } else {
      $statement = mysqli_prepare($con, "SELECT id_asignatura, nombre, nivel, grado_academico, idioma FROM asignatura WHERE id_asignatura IN (SELECT id_asignatura FROM licencia WHERE id_usuario = ? AND vigencia > NOW())");
    }
    /////////xXXXX
    //$statement = mysqli_prepare($con, "SELECT * FROM asignatura WHERE id_asignatura IN (SELECT id_asignatura FROM licencia WHERE id_usuario = ?)");
    mysqli_stmt_bind_param($statement, "s", $_SESSION["id_usuario"]);
    mysqli_stmt_execute($statement);
    mysqli_stmt_store_result($statement);
    mysqli_stmt_bind_result($statement, $id_asignatura, $nombre, $nivel, $grado_academico, $idioma);

    $arregloAsignaturas = array();

    $i = 0;
    while (mysqli_stmt_fetch($statement)) {
      $arregloAsignaturas["id_asignatura"][$i] = $id_asignatura;
      $arregloAsignaturas["nombre"][$i] = $nombre;
      $arregloAsignaturas["nivel"][$i] = $nivel;
      $arregloAsignaturas["grado_academico"][$i] = $grado_academico;
      $arregloAsignaturas["idioma"][$i] = $idioma;
      $i = $i + 1;
    }
    /*+++++++++++++++++++++++++++++++++++++++++++++++++++++++*/
    //DETECTAR DONDE DA CLIC A LA ASIGNATURA PARA GUARDAR LA VARIABLE DE SESION DEL ID DE LA ASIGNATURA

    return ($arregloAsignaturas);
  }

  /////Establecer uso horario para el envio de fecha y hora
  function getDatetimeNow()
  {
    $tz_object = new DateTimeZone('America/Mexico_City');

    $datetime = new DateTime();
    $datetime->setTimezone($tz_object);
    return $datetime->format('Y\-m\-d\ H:i:s');
  }
  //////////////////////
  function imprimirPagina($arregloAsignaturas, $mostrarMenuprofesor, $staffID, $tieneGrupos)
  {

    imprimirTitulo();
    imprimirAsignaturas($arregloAsignaturas);
    imprimirRelleno();
    if ($mostrarMenuprofesor != '') {
      if ($tieneGrupos == "") {
        sinGrupos();
      }
    }
    if ($mostrarMenuprofesor != '' or $staffID != 'null') {
      imprimirEspaciosProfesor($mostrarMenuprofesor, $staffID);
    }
    imprimirRelleno();
    imprimirFooter();
  }




  function imprimirTitulo()
  {
    echo '
          <!----------------------------------------------TITULO--------------------------------------------->
          <div class="top">
            <div class="container">
              <div class="row">
                <div class="text-center col-xs-2 col-sm-2 col-md-2 col-lg-1 col-xl-1">
                  <img
                    class="iconoPrincipal"
                    src="../CSSsJSs/icons/quet.svg"
                  />
                </div>
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                  <p class="titulo">Kaanbal</p>
                </div>
              </div>
            </div>
          </div>
          <!------------------------------------------------FIN TITULO----------------------------------------------->

          <!------------------------------------------------RELLENO----------------------------------------------->
          <div class="container">
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
          <!------------------------------------------------FIN RELLENO----------------------------------------------->
    ';
  }

  function imprimirAsignaturas($arregloAsignaturas) //AQUI DEBO TRAER LOS ID EN LUGAR DE LOS NOBRES DE LAS MATERIAS
  {
    $tamanho = count($arregloAsignaturas["id_asignatura"]);

    $i = 0;

    while ($i < $tamanho) {
      $residuo = $i % 2;
      if ($residuo == 0) {
        imprimirAsignaturaPar($arregloAsignaturas["id_asignatura"][$i], $arregloAsignaturas["nombre"][$i]); //0911SE DEBERA PASAR ID DE ASIGNATURA EN LUGAR DE NOMBRE
        /* echo'<script type="text/javascript">
        alert("es par");
        </script>';  */
      } else {
        imprimirAsignaturaImpar($arregloAsignaturas["id_asignatura"][$i], $arregloAsignaturas["nombre"][$i]);
        /* echo'<script type="text/javascript">
        alert("no es par");
        </script>';  */
      }

      $i = $i + 1;
    }
  }

  function imprimirAsignaturaPar($idAsignatura, $nombreAsignatura) //091120 SE RECIBE AQUI ID DE ASIGNATURA
  {
    $link = "temas.php?asignatura=";
    $claseBloque = "asignaturaPrincipal";
    $link = $link . $idAsignatura;
    $imagen = "imagenAsignatura";


    echo '
        <div class="container">
          <div class="row">
            <div class="hidden-xs hidden-sm col-md-1 col-lg-1 col-xl-1"></div>   
              <a href="' . $link . '">     
                <div
                  class="' . $claseBloque . ' col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4"
                >
                  <div>
                    <img class="' . $imagen . '" src="../../../IMAGENES/quimica.svg" />
                  </div>
                  <div class="tituloAsignaturas">
                    ' . $nombreAsignatura . '
                  </div>
                </div>
              </a> 
              <div class="hidden-xs hidden-sm col-md-1 col-lg-1 col-xl-1"></div>
              <div class="hidden-xs hidden-sm col-md-1 col-lg-1 col-xl-1"></div>   
    ';
  }

  function imprimirAsignaturaImpar($idAsignatura, $nombreAsignatura)
  {
    $link = "temas.php?asignatura=";
    $claseBloque = "asignaturaPrincipal";
    $link = $link . $idAsignatura;
    $imagen = "imagenAsignatura";

    echo '
               
                <a href="' . $link . '">      
                  <div
                    class="' . $claseBloque . ' col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4"
                  >
                    <div>
                      <img class="' . $imagen . '" src="../CSSsJSs/icons/physics.svg" />
                    </div>
                    <div class="tituloAsignaturas">'
      . $nombreAsignatura .
      '</div>
                  </div>              
                </a>
              <div class="hidden-xs hidden-sm col-md-1 col-lg-1 col-xl-1"></div>
            </div>
          </div>
             

            <!------------------------------------------------RELLENO----------------------------------------------->
            <div class="container">
              <div class="row">
                <p class="relleno">.</p>
              </div>
              <div class="row">
                <p class="relleno">.</p>
              </div>
            </div>
            <!------------------------------------------------FIN RELLENO----------------------------------------------->
    ';
  }

  function sinGrupos()
  {

    echo '<script type="text/javascript">
            alert("Hemos detectado que no tienes grupos aún. Crea uno dando click en Crear Grupo");
            </script>';
    /* echo '
      <div class="container">
        <div class="row">
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <h1>Hemos detectado que no tienes grupos aún</h1>
            <h1>Para iniciar, da click en el boton crear grupo</h1>
          </div> 
        </div>
      </div>
    '; */
  }

  function imprimirEspaciosProfesor($mostrarMenuprofesor, $staffID)
  {
    echo '
      <div class="container">
        <div class="row">
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <h1>Profesores</h1>
          </div> 
        </div>
      </div>
    ';


    if ($mostrarMenuprofesor != '') {
      echo '
        <div class="container">
          <div class="row">
            <div class="hidden-xs hidden-sm col-md-1 col-lg-1 col-xl-1"></div>   
              <a href="../crearGrupos/crearGrupo.php">     
                <div
                  class="asignaturaPrincipal col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4"
                >
                  <div>
                    <img class="imagenAsignatura" src="../CSSsJSs/icons/grupo.svg" />
                  </div>
                  <div class="tituloAsignaturas">
                    Crear Grupo
                  </div>
                </div>
              </a>
              <div class="hidden-xs hidden-sm col-md-1 col-lg-1 col-xl-1"></div>
              <div class="hidden-xs hidden-sm col-md-1 col-lg-1 col-xl-1"></div>   
              <a href="../reportes/controlCalificaciones.php">    
                <div
                  class="asignaturaPrincipal col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4"
                >
                  <div>
                    <img class="imagenAsignatura" src="../CSSsJSs/icons/reportes.svg" />
                  </div>
                  <div class="tituloAsignaturas">
                    Reportes
                  </div>
                </div>
              </a>
              <div class="hidden-xs hidden-sm col-md-1 col-lg-1 col-xl-1"></div>
            </div>
          </div>

          <!------------------------------------------------RELLENO----------------------------------------------->
          <div class="container">
            <div class="row">
              <p class="relleno">.</p>
            </div>
            <div class="row">
              <p class="relleno">.</p>
            </div>
          </div>
          <!------------------------------------------------FIN RELLENO----------------------------------------------->
    ';
    }

    if ($staffID != 'null') {
      echo '
        <div class="container">
          <div class="row">
            <div class="hidden-xs hidden-sm col-md-1 col-lg-1 col-xl-1"></div>   
              <a href="../staff/controlStaff.php">     
                <div
                  class="asignaturaPrincipal col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4"
                >
                  <div>
                    <img class="imagenAsignatura" src="../CSSsJSs/icons/personal.svg" />
                  </div>
                  <div class="tituloAsignaturas">
                    Staff
                  </div>
                </div>
              </a>
              <div class="hidden-xs hidden-sm col-md-1 col-lg-1 col-xl-1"></div>
              <div class="hidden-xs hidden-sm col-md-1 col-lg-1 col-xl-1"></div>   
              <a href="../profesor/controlProfesor.php">    
                <div
                  class="asignaturaPrincipal col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4"
                >
                  <div>
                    <img class="imagenAsignatura" src="../CSSsJSs/icons/design.svg" />
                  </div>
                  <div class="tituloAsignaturas">
                    Editar
                  </div>
                </div>
              </a>
              <div class="hidden-xs hidden-sm col-md-1 col-lg-1 col-xl-1"></div>
            </div>
          </div>

          <!------------------------------------------------RELLENO----------------------------------------------->
          <div class="container">
            <div class="row">
              <p class="relleno">.</p>
            </div>
            <div class="row">
              <p class="relleno">.</p>
            </div>
          </div>
          <!------------------------------------------------FIN RELLENO----------------------------------------------->
    ';
    }
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

  function imprimirFooter()
  {
    echo '
          <div class="foot">
            <div class="container">
              <div class="row text-center">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                  <img
                    class="footIcon"
                    id="botonLogout"
                    src="../CSSsJSs/icons/logout.svg"
                  />
                </div>
              </div>
            </div>
          </div>
    ';
  }

  ?>

</body>

</html>