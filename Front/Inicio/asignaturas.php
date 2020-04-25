<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="shortcut icon" type="image/x-icon" href="../CSSsJSs/icons/pyramid.svg" />
  <title>Temas</title>
  <link rel="stylesheet" href="../CSSsJSs/bootstrap341.css" />
  <link rel="stylesheet" href="../CSSsJSs/styleTemas.css" />
  <script src="../CSSsJSs/scriptTemas.js"></script>
</head>

<body>
  <?php
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
    $arregloAsignaturas = array();
    $arregloAsignaturas = traerAsignaturas();
    $_SESSION["asignaturaNavegacion"]=$_GET['asignatura'];
    imprimirPagina($arregloAsignaturas);
  } else {

    /* echo'<script type="text/javascript">
            alert("segundo caminio");
            </script>'; */

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

      //Si el usuario EXISTE despliega el menú de las asignaturas
      if ($temp_id_usuario) {
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
        //Imprimimos pantalla de asignaturas
        $arregloAsignaturas = array();
        $arregloAsignaturas = traerAsignaturas();
        $_SESSION["asignaturaNavegacion"]=$_GET['asignatura'];
        imprimirPagina($arregloAsignaturas);
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

  //traer licencias disponibles
  function traerAsignaturas()
  {
    /*+++++++++++++++++++++++++++++++++++++++++++++++++++++++*/
    $asignatura = $_GET['asignatura'];
    /*echo '<script type="text/javascript">
            alert("'.$asignatura.'");
            </script>';
    */
    /*+++++++++++++++++++++++++++++++++++++++++++++++++++++++PROBADO*/
    $con = mysqli_connect("localhost", "u526597556_dev", "1BLeeAgwq1*isgm&jBJe", "u526597556_kaanbal");
    /*----Paso 1 Obtener todas las asignaturas----*/
    $statement = mysqli_prepare($con, "SELECT * FROM asignatura WHERE id_asignatura IN (SELECT id_asignatura FROM licencia WHERE id_usuario = ? AND vigencia > NOW())");
    mysqli_stmt_bind_param($statement, "s", $_SESSION["id_usuario"]);
    mysqli_stmt_execute($statement);
    mysqli_stmt_store_result($statement);
    mysqli_stmt_bind_result($statement, $id_asignatura, $nombre, $nivel, $grado_academico, $idioma);

    $arregloAsignaturas = array();
   
    $i = 0;
    while (mysqli_stmt_fetch($statement)) { 
      $arregloAsignaturas[$i]["id_asignatura"] = $id_asignatura;
      $arregloAsignaturas[$i]["nombre"] = $nombre;
      $arregloAsignaturas[$i]["nivel"] = $nivel;
      $arregloAsignaturas[$i]["grado_academico"] = $grado_academico;
      $arregloAsignaturas[$i]["idioma"] = $idioma;
      $i = $i + 1;
    }
/*+++++++++++++++++++++++++++++++++++++++++++++++++++++++*/
//DETECTAR DONDE DA CLIC A LA ASIGNATURA PARA GUARDAR LA VARIABLE DE SESION DEL ID DE LA ASIGNATURA
    
    return ($arregloAsignaturas);
  }

 
  //////////////////////
  function imprimirPagina($arregloAsignaturas)
  {
    imprimirTitulo();
    imprimirAsignaturas($arregloAsignaturas);
    imprimirRelleno();
    imprimirFooter();
  }

  function imprimirAsignaturas($arregloAsignaturas)
  {
    $tamanho = count($arregloAsignaturas);
    for ($i = 0; $i < $tamanho; $i++) {
      $permiso=1;
      imprimirAsignatura($i + 1, $arregloAsignaturas[$i]["nombre"], $permiso);//SE ESTARIAN IMPRIMIENDO ASIGNATURAS POR EL ID
    }
  }


  function imprimirTitulo()
  {
    echo '
          <!----------------------------------------------TITULO--------------------------------------------->
          <div class="top">
            <div class="container">
              <div class="row">
                <div class="textCenter col-xs-2 col-sm-2 col-md-2 col-lg-1 col-xl-1">
                  <img
                    class="iconoPrincipal"
                    src="../CSSsJSs/icons/quetzalcoatl.svg"
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
          </div>
          <!------------------------------------------------FIN RELLENO----------------------------------------------->
    ';
  }



  function imprimirAsignatura($numeroAsignatura, $nombreAsignatura, $siTienePermiso)
  {
    
    echo '
        <div class="container">
          <div class="row">
            <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1 col-xl-1"></div>
            <a href="temas.php?asignatura=Materia y el entorno">
              <div
                class="asignaturaPrincipal col-xs-10 col-sm-10 col-md-4 col-lg-4 col-xl-4"
              >
                <div>
                  <img
                    class="imagenAsignatura"
                    src="../CSSsJSs/icons/nuclear.svg"
                  />
                </div>
                <div class="tituloAsignaturas">
                  Materia y el entorno
                </div>
              </div>
            </a>
            <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1 col-xl-1"></div>
            <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1 col-xl-1"></div>
            <a href="temas.php?asignatura=Fisica">
              <div
                class="asignaturaPrincipal col-xs-10 col-sm-10 col-md-4 col-lg-4 col-xl-4"
              >
                <div>
                  <img
                    class="imagenAsignatura"
                    src="../CSSsJSs/icons/physics.svg"
                  />
                </div>
                <div class="tituloAsignaturas">
                  Física
                </div>
              </div>
            </a>
            <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1 col-xl-1"></div>
          </div>
        </div>

        <div class="container">
          <div class="row">
            <p style="color: rgba(0, 0, 0, 0);">.</p>
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