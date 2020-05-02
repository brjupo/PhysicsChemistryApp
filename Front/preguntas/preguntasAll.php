<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="shortcut icon" type="image/x-icon" href="../CSSsJSs/icons/pyramid.svg" />
    <title>Pregunta</title>
    <link rel="stylesheet" href="../CSSsJSs/bootstrap341.css" />
    <link rel="stylesheet" href="../CSSsJSs/stylePreguntas2.css" />
    <script src="../CSSsJSs/scriptNuevasPreguntas3.js"></script>
    <script src="../CSSsJSs/minAJAX.js"></script>
    <script src="https://polyfill.io/v3/polyfill.min.js?features=es6"></script>
    <script id="MathJax-script" async src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.js"></script>
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
        //Si existe un token de sesion activo se mostraran las preguntas 

        /*+++++++++++++++++++++++++++++++++++++++++++++++++++++++*/
        $leccion = $_GET['leccion'];
        /*echo '<script type="text/javascript">
                alert("'.$leccion.'");
                </script>';
        */
        /*+++++++++++++++++++++++++++++++++++++++++++++++++++++++*/

        $con = mysqli_connect("localhost", "u526597556_dev", "1BLeeAgwq1*isgm&jBJe", "u526597556_kaanbal");
        /*----Paso 1 Obtener el ID del subtema----*/
        $statement = mysqli_prepare($con, "SELECT id_leccion FROM leccion WHERE nombre = ?");
        mysqli_stmt_bind_param($statement, "s", $leccion);
        mysqli_stmt_execute($statement);
        mysqli_stmt_store_result($statement);
        mysqli_stmt_bind_result($statement, $id_leccion);

        $arregloIdleccion = array();
        //Leemos datos ID de leccion
        while (mysqli_stmt_fetch($statement)) { //si si existe la leccion
            $arregloIdleccion["id_leccion"] = $id_leccion;
        }

        $idL = $arregloIdleccion["id_leccion"];
        //Traer todas las preguntas del servicio
        imprimirPreguntas($idL);
    } else {
        //Si NO existe un token de sesion activo se redireccionara a pagina de inicio
        echo '<script type="text/javascript">
          alert("Ingresa usuario y/o contraseña");
          window.location.href="https://kaanbal.net";
          </script>';
    }


    ?>

    <?php
    function imprimirPreguntas($idL)
    {
        imprimirBarraProgresoCruz($idL); //subtema, userid, leccionid
        imprimirContador();
        imprimirPreguntasRespuestas();
        imprimirFooter();
    }
    ?>

    <?php
    function imprimirBarraProgresoCruz($idL)
    {
        echo '
            <div class="container">
                <div class="row topMargin">
                <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 col-xl-2">
                    <img src="../CSSsJSs/icons/clear.svg" id="cruzCerrar" class="cruz" />
                </div>
                <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10 col-xl-10">
                    <p id="subtemaPrevio" style="display:none">' . $_SESSION["subtemaNavegacion"] . '</p>
                    <p id="userID" style="display:none">' . $_SESSION["id_usuario"] . '</p>
                    <p id="leccionID" style="display:none">' .$idL. '</p>
                    <div class="progress progressMargin">
                    <!-- class="active"-->
                    <div    id="barraAvance"
                            class="progress-bar progress-bar-striped" 
                            role="progressbar" 
                            aria-valuenow="40" 
                            aria-valuemin="0" 
                            aria-valuemax="100" 
                            style="width: 0%;"></div>
                    </div>
                </div>
                </div>
            </div>
            ';
    }
    ?>

    <?php
    function imprimirContador()
    {
        echo '
            <div class="container">
                <div class="row">
                <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1 col-xl-1"></div>
                <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10 col-xl-10">
                    <p style="display:none" class="slide-bottom" id="previous">0m 10s</p>
                    <p style="display:none" class="slide-bottom" id="actual">0m 10s</p>
                    <p style="display:none" class="slide-bottom" id="later">0m 10s</p>
                    <p id="puntosBuenos"></p>
                </div>
                <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1 col-xl-1"></div>
                </div>
            </div>
            ';
    }
    ?>
    <?php
    function imprimirPreguntasRespuestas()
    {
        echo '
        <!--+++++++++++++++++++++++++++++++++++++++PREGUNTA TIPO 1++++++++++++++++++++++++++++++++++++++++++++-->
        <div class="container" id="PreguntaTipo1" style="display: none;">
          <div class="row">
            <div class="hidden-xs hidden-sm col-md-1 col-lg-1 col-xl-1"></div>
            <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 col-xl-10">
              <p class="formatoPreguntas" id="textoPreguntaTipo1">
                ¿Cuál es la equivalencia correcta para la expresion
                <strong>10<sup>6</sup></strong
                >?
              </p>
            </div>
            <div class="hidden-xs hidden-sm col-md-1 col-lg-1 col-xl-1"></div>
          </div>
        </div>
        <!--+++++++++++++++++++++++++++++++++++++++TIPO 1 IMAGEN++++++++++++++++++++++++++++++++++++++++++++-->
        <div class="container" id="RespuestasTipo1ConImagen" style="display: none;">
          <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
              <img id="imagenPreguntaTipo1"
                src="../CSSsJSs/images/problemaFisica.jpg"
                class="imagenPregunta"
              />
            </div>
            <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3 col-xl-3">
              <button class="Opcion1" id="Opcion1ConImagen">
                10,000
              </button>
              <br />
              <button class="Opcion3" id="Opcion3ConImagen">
                1,000,000
              </button>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3 col-xl-3">
              <button class="Opcion2" id="Opcion2ConImagen">
                100,000
              </button>
              <br />
              <button class="Opcion4" id="Opcion4ConImagen">
                10,000,000
              </button>
            </div>
          </div>
        </div>
        <!--+++++++++++++++++++++++++++++++++++++++TIPO 1 SIN IMAGEN++++++++++++++++++++++++++++++++++++++++++++-->
        <div class="container" id="RespuestasTipo1SinImagen" style="display: none;">
          <div class="row">
            <div class="hidden-xs hidden-sm col-md-3 col-lg-3 col-xl-3">
            </div>
            <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3 col-xl-3">
              <button class="Opcion1" id="Opcion1SinImagen">
                10,000
              </button>
              <br />
              <button class="Opcion3" id="Opcion3SinImagen">
                1,000,000
              </button>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3 col-xl-3">
              <button class="Opcion2" id="Opcion2SinImagen">
                100,000
              </button>
              <br />
              <button class="Opcion4" id="Opcion4SinImagen">
                10,000,000
              </button>
            </div>
            <div class="hidden-xs hidden-sm col-md-3 col-lg-3 col-xl-3">
            </div>
          </div>
        </div>
        <!--+++++++++++++++++++++++++++++++++++++++PREGUNTA TIPO 2++++++++++++++++++++++++++++++++++++++++++++-->
        <div class="container" id="PreguntaTipo2" style="display: none;">
          <div class="row">
            <div class="hidden-xs hidden-sm col-md-1 col-lg-1 col-xl-1"></div>
            <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 col-xl-10">
              <p class="formatoPreguntas"  id="textoPreguntaTipo2">
                En tu clase de biología se mencionó que en las hojas de las plantas
                hay varios pigmentos tales como
                <input type="text" id="lname" />
                ¿Con qué método podrías separar estos pigmentos tras extraer el
                líquido verde de una espinaca?
              </p>
            </div>
            <div class="hidden-xs hidden-sm col-md-1 col-lg-1 col-xl-1"></div>
          </div>
        </div>
        <!--+++++++++++++++++++++++++++++++++++++++TIPO 2 IMAGEN++++++++++++++++++++++++++++++++++++++++++++-->
        <div class="container" id="RespuestasTipo2ConImagen" style="display: none;">
          <div class="row">
            <!--div class="hidden-xs hidden-sm col-md-3 col-lg-3 col-xl-3"></div-->
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
              <button id="acceptConImagen" class="miniBoton">Accept</button>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
              <img id="imagenPreguntaTipo2"
                src="../CSSsJSs/images/problemaFisica.jpg"
                class="imagenPregunta"
              />
            </div>
          </div>
        </div>
        <!--+++++++++++++++++++++++++++++++++++++++TIPO 2 SIN IMAGEN++++++++++++++++++++++++++++++++++++++++++++-->
        <div class="container" id="RespuestasTipo2SinImagen" style="display: none;">
          <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
              <button id="acceptSinImagen" class="miniBoton">Accept</button>
            </div>
          </div>
        </div>
        ';
    }
    ?>


    <?php
    function imprimirFooter()
    {
        echo '
        <div
        class="popUp animated bounceInUp"
        id="botonSiguientePregunta"
        style="display: none;"
        >
            <div class="container">
            <div class="row text-center">
                <div class="hidden-xs hidden-sm col-md-4 col-lg-4 col-xl-4"></div>
                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                <button class="botonContinuar fondoNeutro">Continuar</button>
                </div>
                <div class="hidden-xs hidden-sm col-md-4 col-lg-4 col-xl-4"></div>
            </div>
            </div>
        </div>
        ';
    }
    ?>


</body>

</html>