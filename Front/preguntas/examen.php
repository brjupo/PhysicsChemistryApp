<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="shortcut icon" type="image/x-icon" href="../CSSsJSs/icons/pyramid.svg" />
    <title>Pregunta</title>
    <link rel="stylesheet" href="../CSSsJSs/bootstrap341.css" />
    <link rel="stylesheet" href="../CSSsJSs/styleExamen1.css" />
    <script src="../CSSsJSs/scriptExamen1.js"></script>
    <script src="../CSSsJSs/minAJAX.js"></script>
    <script src="https://polyfill.io/v3/polyfill.min.js?features=es6"></script>
    <script id="MathJax-script" async src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.js"></script>
</head>


<body>
    <script>
        document.addEventListener("contextmenu", (event) => event.preventDefault());
        $(document).keydown(function(event) {
            if (event.keyCode == 123) {
                // Prevent F12
                return false;
            } else if (event.ctrlKey && event.shiftKey && event.keyCode == 73) {
                // Prevent Ctrl+Shift+I
                return false;
            } else if (event.ctrlKey && event.keyCode == 85) {
                // Prevent Ctrl+U
                return false;
            } else if (event.ctrlKey && event.keyCode == 67) {
                // Prevent Ctrl+C
                return false;
            }
        });
    </script>

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

        //Traer tiempo para el examen
        $query2 = "SELECT tiempo_examen FROM leccion WHERE id_leccion = $leccion"; 
        $result2 = mysqli_query($con, $query2);
        $tiempoa = mysqli_fetch_row($result2);
        $tiempo = $tiempoa[0];
           
        
        
        /*----Paso 1 Obtener el ID del subtema----*/
        /*
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
        $idL = $arregloIdleccion["id_leccion"];-------CAMBIADO POR EL BRANDON A LAS 18:00 EL 2 DE JUNIO
        */
        $idL = $leccion;
        //Traer todas las preguntas
        $query = "SELECT * FROM pregunta WHERE id_leccion = $idL ORDER BY RAND()"; //Revolviendo preguntas, solo para sprint y examen se usa la siguiente linea antes de llamar a imprimir preguntas
        $result = mysqli_query($con, $query);
        //contar Numero de elementos
        $query2 = "SELECT count(*) FROM pregunta WHERE id_leccion = $idL"; // WHERE TEMA = 'TEMA' AND SUBTEMA = 'SUBTEMA' AND LECCION = 'LECCION'";
        $result2 = mysqli_query($con, $query2);
        $total = mysqli_fetch_row($result2);
        //$total = 10;
        //Recorrer el arreglo
        while ($row = mysqli_fetch_assoc($result)) {
            $array[] = $row;
            $arrayr[] = $row;
        }
        ///////////////////////////////SEPARANDO PREGUNTAS/////////////////////////////////////////
        ///////////////////////////////NO TOCAR PRROS/////////////////////////////////////////
        for ($j = 0; $j < $total[0]; $j++) {
            // CONVERTIR LA CADENA DE TEXTO EN UN ARRAY
            $arreglo = str_split($arrayr[$j]["pregunta"]);
            //print_r ($arreglo);
            // LEER CON BUCLE FOR EL ARREGLO HASTA ENCONTRAR GUION BAJO Y GUARDAR LA POSICION DONDE SE ENCUENTRE
            $posicion = 0;
            $tamanho = count($arreglo);
            for ($i = 0; $i < $tamanho - 2; $i++) {
                if ($arreglo[$i] == '_' && $arreglo[$i + 1] == '_' && $arreglo[$i + 2] == '_') {
                    $posicion = $i;
                    break;
                }
            }
            // PARTIR LA PREGUNTA EN 2 CADENAS, SI POSICION = 0, SIGNIFICA QUE LA PREGUNTA NO DEBE SER PARTIDA
            if ($posicion != 0) {
                $preguntaParte1 = substr($arrayr[$j]["pregunta"], 0, $posicion - 1);
                $preguntaParte2 = substr($arrayr[$j]["pregunta"], $posicion + 4, strlen($arrayr[$j]["pregunta"]));
            } else {
                $preguntaParte1 = $arrayr[$j]["pregunta"];
                $preguntaParte2 = "";
            }
            $arrayr[$j]["preguntaParte1"] = $preguntaParte1;
            $arrayr[$j]["preguntaParte2"] = $preguntaParte2;
        }
        //print_r ($arrayr);
        ////////////////////////////////////////////////////////////////////////////////////////////

        $respuestas = array('respuesta_correcta', 'respuesta2', 'respuesta3', 'respuesta4');
        $respuestasr = array('respuesta_correcta', 'respuesta2', 'respuesta3', 'respuesta4');
        for ($j = 0; $j < $total[0]; $j++) {
            $i = 0;
            shuffle($respuestas);
            foreach ($respuestas as $val) {
                //print_r ($val);
                $arrayr[$j][$respuestasr[$i]] = $array[$j][$val];
                //print_r ($i);
                $i = $i + 1;
            }
        }
        //print_r($arrayr);
    } else {
        //Si NO existe un token de sesion activo se redireccionara a pagina de inicio
        echo '<script type="text/javascript">
          alert("Ingresa usuario y/o contraseña");
          window.location.href="https://kaanbal.net";
          </script>';
    }


    imprimirPreguntas($arrayr, $array, $total, $idL, $tiempo);
    ?>

    <?php
    function imprimirPreguntas($arrayr, $array, $total, $idL, $tiempo)
    {
        imprimirBarraProgresoCruz($total[0], $idL);
        imprimirTiempoexamen($tiempo);
        imprimirContador();
        imprimirMotivador();
        imprimirPreguntasRespuestas($arrayr, $array, $total);
        imprimirFooter();
    }
    ?>

    <?php
    function imprimirPreguntasRespuestas($arrayr, $array, $total)
    {
        $p1 = "¿Cuál es la equivalencia correcta para la expresion
    10^6?";
        $r1 = "100,000";
        $r2 = "10,000,000";
        $r3 = "1,000,000";
        $r4 = "10,000";
        $rc = "10,000,000";
        $imagen = 1;



        //Se imprime las siguientes preguntas INVISIBLES
        for ($x = 0; $x < $total[0]; $x++) {
            if ($arrayr[$x]["tipo"] == "1") {
                //encontrar id´s de las respuestas correctas
                $rcorrecta = $array[$x]["respuesta_correcta"];

                $arraytemp = array();
                $arraytemp[0] = $arrayr[$x]["respuesta_correcta"];
                $arraytemp[1] = $arrayr[$x]["respuesta2"];
                $arraytemp[2] = $arrayr[$x]["respuesta3"];
                $arraytemp[3] = $arrayr[$x]["respuesta4"];

                $posicion = array_search($rcorrecta, $arraytemp);


                //////////////
                imprimirPreguntaTipo1($x + 1, $arrayr[$x]["pregunta"]);
                imprimirImagenRespuestasTipo1(
                    $x + 1,
                    $arrayr[$x]["respuesta_correcta"],
                    $arrayr[$x]["respuesta2"],
                    $arrayr[$x]["respuesta3"],
                    $arrayr[$x]["respuesta4"],
                    $posicion, //aqui mandar posicion de respuesta correcta
                    $array[$x]["id_pregunta"]
                );
            } else {
                imprimirPreguntaTipo2(
                    $x + 1,
                    $arrayr[$x]["preguntaParte1"],
                    $arrayr[$x]["preguntaParte2"]
                );
                imprimirImagenRespuestasTipo2(
                    $x + 1,
                    $array[$x]["respuesta_correcta"],
                    $array[$x]["id_pregunta"]
                );
            }
        }
    }
    ?>


    <?php

    function imprimirBarraProgresoCruz($totalPreguntas, $idL)
    {
        $subtemaNavegacion = $_SESSION["subtemaNavegacion"];
        echo '
            <div class="container">
                <div class="row topMargin">
                <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 col-xl-2">
                    <img src="../CSSsJSs/icons/clear.svg" id="cruzCerrar" class="cruz" />
                </div>
                <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10 col-xl-10">
                    <p id="subtemaPrevio" style="display:none">' . $subtemaNavegacion . '</p>
                    <p id="totalPreguntas" style="display:none">' . $totalPreguntas . '</p>
                    <p id="userID" style="display:none">' . $_SESSION["id_usuario"] . '</p>
                    <p id="leccionID" style="display:none">' . $idL . '</p>
                    <div class="progress progressMargin">
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

    function imprimirTiempoexamen($tiempo)
    {//border="4px" color="black" 
        echo '
                <div class="container">
                <div class="row">
                <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1 col-xl-1"></div>
                <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10 col-xl-10">
                <input type="text" id="tiempo" name="tiempo" value='.$tiempo.' style="display:none"/>
                <table class="table fixed">
                <tbody>
                  <tr>
                    <td style="text-align: left" width="50%">
                      <p id="number">00:00</p>
                    </td>
                    <td style="text-align: right" width="50%">
                      <img class="icons" width="50" height="30" src="../CSSsJSs/icons/relojExa.svg" onClick="ocultarTiempo()" />
                    </td>
                  </tr>
                </tbody>
              </table>
                </div>
                <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1 col-xl-1"></div>
                </div>
            </div>
            ';
    }

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
                    <p style="display:none" id="puntosBuenos"></p>
                </div>
                <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1 col-xl-1"></div>
                </div>
            </div>
            ';
    }

    function imprimirMotivador()
    {
        echo '
                <div id="motivationMessage" class="container noPaddingMargin" style="display: none;">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 noPaddingMargin">
                            <!--div class="imagenEdu">
                                <p id="dialogo" class="dialogoInsp">Aunque falles, sigues aprendiendo!</p>
                            </div-->
                            <div>
                                <p id="dialogo" class="dialogoNoInsp">Aunque falles, sigues aprendiendo!</p>
                            </div>
                        </div>
                        <div class="hidden-xs hidden-sm col-md-6 col-lg-6 col-xl-6">
                            <p  style="color:rgba(0,0,0,0);">.</p>
                        </div>
                    </div>
                </div>
        ';
    }

    function imprimirPreguntaTipo1(int $preguntaNumero, $preguntaTexto)
    {
        $preguntaNumero = 1000 + $preguntaNumero;
        echo '
            <!--+++++++++++++++++++++++++++++++++++++++PREGUNTA++++++++++++++++++++++++++++++++++++++++++++-->
            <div class="container" style="display:none" id="' . $preguntaNumero . '">
            <div class="row">
                <div class="hidden-xs hidden-sm col-md-1 col-lg-1 col-xl-1"></div>
                <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 col-xl-10">
                <p id="preguntaNumero" style="display:none">' . $preguntaNumero . '</p>
                <p class="formatoPreguntas">'
            . $preguntaTexto .
            '  
                </p>
                </div>
                <div class="hidden-xs hidden-sm col-md-1 col-lg-1 col-xl-1"></div>
            </div>
            </div>
        ';
    }
    function imprimirImagenRespuestasTipo1(int $respuestas, $r1, $r2, $r3, $r4, $respCorrecta, $imagen)
    {
        $uno = 10 * $respuestas - 3;
        $dos = 10 * $respuestas - 2;
        $tres = 10 * $respuestas - 1;
        $cuatro = 10 * $respuestas;
        $respuestaNumero = 2000 + $respuestas;
        $IDvalorCorrecto = 3000 + $respuestas;
        $imgjpg = $imagen . ".jpg";
        $pathjpg = "../imagenes/" . $imgjpg;

        $imgJPG = $imagen . ".JPG";
        $pathJPG = "../imagenes/" . $imgJPG;
        if (file_exists($pathjpg)) {
            echo '
            <!--+++++++++++++++++++++++++++++++++++++++IMAGEN++++++++++++++++++++++++++++++++++++++++++++-->
            <div class="container" style="display:none" id ="' . $respuestaNumero . '">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                <img src="../imagenes/' . $imagen . '.jpg" class="imagenPregunta" />
                <p id="' . $IDvalorCorrecto . '" style="display:none">
                    ' . $respCorrecta . '
                </p>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3 col-xl-3">
                <button class="Opcion1" id="' . $uno . '">
                    ' . $r1 . '
                </button><br>
                <button class="Opcion3" id="' . $tres . '">
                    ' . $r3 . '
                </button>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3 col-xl-3">
                <button class="Opcion2" id="' . $dos . '">
                    ' . $r2 . '
                </button><br>
                <button class="Opcion4" id="' . $cuatro . '">
                    ' . $r4 . '
                </button>
                </div>
            </div>
            </div>
        ';
        } else if (file_exists($pathJPG)) {
            echo '
            <!--+++++++++++++++++++++++++++++++++++++++IMAGEN++++++++++++++++++++++++++++++++++++++++++++-->
            <div class="container" style="display:none" id ="' . $respuestaNumero . '">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                <img src="../imagenes/' . $imagen . '.JPG" class="imagenPregunta" />
                <p id="' . $IDvalorCorrecto . '" style="display:none">
                    ' . $respCorrecta . '
                </p>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3 col-xl-3">
                <button class="Opcion1" id="' . $uno . '">
                    ' . $r1 . '
                </button><br>
                <button class="Opcion3" id="' . $tres . '">
                    ' . $r3 . '
                </button>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3 col-xl-3">
                <button class="Opcion2" id="' . $dos . '">
                    ' . $r2 . '
                </button><br>
                <button class="Opcion4" id="' . $cuatro . '">
                    ' . $r4 . '
                </button>
                </div>
            </div>
            </div>
        ';
        } else {
            echo '
            <!--+++++++++++++++++++++++++++++++++++++++IMAGEN++++++++++++++++++++++++++++++++++++++++++++-->
            <div class="container" style="display:none" id ="' . $respuestaNumero . '">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <p id="' . $IDvalorCorrecto . '" style="display:none">
                    ' . $respCorrecta . '
                </p>
                </div>
                <div class="hidden-xs hidden-sm col-md-3 col-lg-3 col-xl-3">
                </div>
                <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3 col-xl-3">
                    <button class="Opcion1" id="' . $uno . '">
                        ' . $r1 . '
                    </button><br>
                    <button class="Opcion3" id="' . $tres . '">
                        ' . $r3 . '
                    </button>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3 col-xl-3">
                    <button class="Opcion2" id="' . $dos . '">
                        ' . $r2 . '
                    </button><br>
                    <button class="Opcion4" id="' . $cuatro . '">
                        ' . $r4 . '
                    </button>
                </div>
                <div class="hidden-xs hidden-sm col-md-3 col-lg-3 col-xl-3">
                </div>
            </div>
            </div>
        ';
        }
    }
    
    function imprimirPreguntaTipo2(int $preguntaNumero, $preguntaTexto, $preguntaTexto2)
    {
        $IDTextoEscrito = 10 * $preguntaNumero - 5;
        $preguntaNumero = 1000 + $preguntaNumero;
        echo '
            <!--+++++++++++++++++++++++++++++++++++++++PREGUNTA++++++++++++++++++++++++++++++++++++++++++++-->
            <div class="container" style="display:none" id="' . $preguntaNumero . '">
                <div class="row">
                <div class="hidden-xs hidden-sm col-md-1 col-lg-1 col-xl-1"></div>
                <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 col-xl-10">
                    <p id="preguntaNumero" style="display:none">' . $preguntaNumero . '</p>
                    <p class="formatoPreguntas">'
            . $preguntaTexto .
            ' 
                    <input type="text" id="' . $IDTextoEscrito . '">
                    '
            . $preguntaTexto2 .
            '  
                    </p>
                </div>
                <div class="hidden-xs hidden-sm col-md-1 col-lg-1 col-xl-1"></div>
                </div>
            </div>
            ';
    }
    function imprimirImagenRespuestasTipo2(int $respuestas, $respCorrecta, $imagen)
    {

        $IDBotonAceptar = 10 * $respuestas - 4;
        $respuestaNumero = 2000 + $respuestas;
        $IDvalorCorrecto = 3000 + $respuestas;
        $imgjpg = $imagen . ".jpg";
        $pathjpg = "../imagenes/" . $imgjpg;
        //echo '<p>'.$path.'</p>';
        if (file_exists($pathjpg)) {
            echo '
                <!--+++++++++++++++++++++++++++++++++++++++IMAGEN++++++++++++++++++++++++++++++++++++++++++++-->
                <div class="container" style="display:none" id ="' . $respuestaNumero . '">
                    <div class="row">
                        <!--div class="hidden-xs hidden-sm col-md-3 col-lg-3 col-xl-3"></div-->
                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                            <button id="' . $IDBotonAceptar . '" class="miniBoton">Ok</button>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                            <img src="../imagenes/' . $imagen . '.jpg" class="imagenPregunta" />
                            <p id="' . $IDvalorCorrecto . '" style="display:none">
                            ' . $respCorrecta . '
                            </p>
                        </div>
                    </div>
                </div>
                ';
        } else {
            echo '
                <!--+++++++++++++++++++++++++++++++++++++++IMAGEN++++++++++++++++++++++++++++++++++++++++++++-->
                <div class="container" style="display:none" id ="' . $respuestaNumero . '">
                    <div class="row">
                        <!--div class="hidden-xs hidden-sm col-md-3 col-lg-3 col-xl-3"></div-->
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                            <button id="' . $IDBotonAceptar . '" class="miniBoton">Acepto</button>
                            <p id="' . $IDvalorCorrecto . '" style="display:none">
                            ' . $respCorrecta . '
                            </p>
                        </div>
                    </div>
                </div>
                ';
        }
    }
    function imprimirFooter()
    {
        echo '
            <div class="popUp animated bounceInUp" id="botonSiguientePregunta" style="display: none;">
                <div class="container">
                <div class="row text-center">
                    <div class="hidden-xs hidden-sm col-md-4 col-lg-4 col-xl-4"></div>
                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                    <button class="botonContinuar">Continue</button>
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