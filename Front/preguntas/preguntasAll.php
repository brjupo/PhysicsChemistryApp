<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="shortcut icon" type="image/x-icon" href="../CSSsJSs/icons/pyramid.svg" />
    <title>Pregunta</title>
    <link rel="stylesheet" href="../CSSsJSs/bootstrap341.css" />
    <link rel="stylesheet" href="../CSSsJSs/stylePreguntas2.css" />
    <script src="../CSSsJSs/scriptNuevasPreguntas.js"></script>
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

    } else {
        //Si NO existe un token de sesion activo se redireccionara a pagina de inicio
        echo '<script type="text/javascript">
          alert("Ingresa usuario y/o contraseña");
          window.location.href="https://kaanbal.net";
          </script>';
    }


    ?>

    <?php
    function imprimirPreguntas()
    {
        imprimirBarraProgresoCruz();
        imprimirContador();
        imprimirPreguntasRespuestas();
        imprimirFooter();
    }
    ?>







    <?php
    function imprimirFooter()
    {
        echo '
            <footer class="popUp animated bounceInUp" id="sprintNext" style="display: none;">
                <div class="container">
                <div class="row text-center">
                    <div class="hidden-xs hidden-sm col-md-4 col-lg-4 col-xl-4"></div>
                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                    <button class="botonContinuar">Continuar</button>
                    </div>
                    <div class="hidden-xs hidden-sm col-md-4 col-lg-4 col-xl-4"></div>
                </div>
                </div>
            </footer>
            ';
    }
    ?>


</body>

</html>