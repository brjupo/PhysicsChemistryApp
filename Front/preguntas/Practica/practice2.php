<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="shortcut icon" type="image/x-icon" href="../../CSSsJSs/icons/pyramid.svg" />
    <title>Pregunta</title>
    <link rel="stylesheet" href="../../CSSsJSs/bootstrap341.css" />
    <link rel="stylesheet" href="../../CSSsJSs/stylePreguntas.css" />
    <script src="scriptPractice22.js"></script>
    <script src="../../CSSsJSs/minAJAX.js"></script>
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
                </script>';*/
        /*+++++++++++++++++++++++++++++++++++++++++++++++++++++++*/

        $con = mysqli_connect("localhost", "u526597556_dev", "1BLeeAgwq1*isgm&jBJe", "u526597556_kaanbal");
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
        /////////id_lecciones traer id subtema
        $statement = mysqli_prepare($con, "SELECT id_asignatura FROM licencia WHERE id_usuario = ?");
        mysqli_stmt_bind_param($statement, "s", $_SESSION["id_usuario"]);
        mysqli_stmt_execute($statement);
        mysqli_stmt_store_result($statement);
        mysqli_stmt_bind_result($statement, $id_asignatura);

        $arregloAsignaturas = array();

        $i = 0;
        while (mysqli_stmt_fetch($statement)) {
        $arregloAsignaturas[$i]["id_asignatura"] = $id_asignatura;
        $i = $i + 1;
        }

        $tamanhoArray = count($arregloAsignaturas);

         /* echo'<script type="text/javascript">
        alert("'.$tamanhoArray.'");
        </script>';  */

    /////////////////
        $query = "SELECT id_subtema FROM leccion WHERE id_leccion = $idL";
        $result = mysqli_query($con, $query);
        while ($row = mysqli_fetch_assoc($result)) {
            $subtema[] = $row;
        }
        $idSubtema = $subtema[0]["id_subtema"]; 

        /////////id_subtema trae id_tema
        $query = "SELECT id_tema FROM subtema WHERE id_subtema = $idSubtema";
        $result = mysqli_query($con, $query);
        while ($row = mysqli_fetch_assoc($result)) {
            $tema[] = $row;
        }
        $idTema = $tema[0]["id_tema"]; 

        /////////id_tema tra id_asignatura
        $query = "SELECT id_asignatura FROM tema WHERE id_tema = $idTema";
        $result = mysqli_query($con, $query);
        while ($row = mysqli_fetch_assoc($result)) {
            $asignatura[] = $row;
        }
        $idAsignatura = $asignatura[0]["id_asignatura"];

        $flag = 0;

        for ($j = 0; $j < $tamanhoArray; $j++){ 
            if(in_array($arregloAsignaturas[$j]["id_asignatura"], $idAsignatura))
            {$flag = 1;} 
        }

        if($flag == 0){
            echo'<script type="text/javascript">
                alert("Sin licencia");
                </script>';
        }
         

        

        //////////////////////
        //Traer todas las preguntas
        $query = "SELECT * FROM pregunta WHERE id_leccion = $idL"; //AND id_pregunta <= 5221WHERE TEMA = 'TEMA' AND SUBTEMA = 'SUBTEMA' AND LECCION = 'LECCION'";     
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
        ///VALIDAMOS EL IDIOMA PARA HACER CAMBIO EN EL NOMBRE DE LOS CAMPOS Y MOSTRAR LAS PREGUNTAS EN INGLES
        if($_SESSION["idioma"] == 'i'){
            for ($j = 0; $j < $total[0]; $j++) {
            $array[$j]["pregunta"] = $array[$j]["question"];
            $array[$j]["respuesta_correcta"] = $array[$j]["correct_answer"];
            $array[$j]["respuesta2"] = $array[$j]["answer2"];
            $array[$j]["respuesta3"] = $array[$j]["answer3"];
            $array[$j]["respuesta4"] = $array[$j]["answer4"];

            $arrayr[$j]["pregunta"] = $arrayr[$j]["question"];
            $arrayr[$j]["respuesta_correcta"] = $arrayr[$j]["correct_answer"];
            $arrayr[$j]["respuesta2"] = $arrayr[$j]["answer2"];
            $arrayr[$j]["respuesta3"] = $arrayr[$j]["answer3"];
            $arrayr[$j]["respuesta4"] = $arrayr[$j]["answer4"];
            }
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


    imprimirPreguntas($arrayr, $array, $total, $idL);
    ?>

    <?php
    function imprimirPreguntas($arrayr, $array, $total, $idL)
    {
        imprimirBarraProgresoCruz($total[0], $idL);
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
                    <img src="../../CSSsJSs/icons/clear.svg" id="cruzCerrar" class="cruz" />
                </div>
                <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10 col-xl-10">
                    <p id="idioma" style="display:none"/>'.$_SESSION["idioma"].'</p>
                    <p id="subtemaPrevio" style="display:none">' . $subtemaNavegacion . '</p>
                    <p id="totalPreguntas" style="display:none">' . $totalPreguntas . '</p>
                    <p id="userID" style="display:none">' . $_SESSION["id_usuario"] . '</p>
                    <p id="leccionID">' . $idL . '</p>
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

    /*
    Mis nacadas
    ID Pregunta = 1000 + Número de pregunta         Ejemplo: Pregunta1 id="1001"
    ID Respuesta = 2000 + Número de pregunta        Ejemplo: Respuesta1 id="2001"
    ID Respuesta correcta = 3000 + Número de pregunta   Ejemplo: ResCorrecta1 id="3001"

    Opción 4 = 10 * Número de pregunta              Ejemplo: class="Opcion4"id="10"
    Opción 3 = 10 * Número de pregunta - 1          Ejemplo: class="Opcion3"id="9"
    Opción 2 = 10 * Número de pregunta - 2          Ejemplo: class="Opcion2"id="8"
    Opción 1 = 10 * Número de pregunta - 3          Ejemplo: class="Opcion1"id="7"
    ID Boton aceptar = 10 * Número de pregunta - 4  Ejemplo: id="6"
    Texto Escrito = 10 * Número de pregunta - 5     Ejempo: id="5"

    */
    function imprimirPreguntaTipo1(int $preguntaNumero, $preguntaTexto)
    {
        $preguntaNumero = 1000 + $preguntaNumero;
        echo '
            <!--+++++++++++++++++++++++++++++++++++++++PREGUNTA++++++++++++++++++++++++++++++++++++++++++++-->
            <div class="container" style="display:none" id="' . $preguntaNumero . '">
            <div class="row">
                <div class="hidden-xs hidden-sm col-md-1 col-lg-1 col-xl-1"></div>
                <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 col-xl-10">
                <p id="preguntaNumero">' . $preguntaNumero . '</p>
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
        $pathjpg = "../../../../IMAGENES/" . $imgjpg;
        $imgJPG = $imagen . ".JPG";
        $pathJPG = "../../../../IMAGENES/" . $imgJPG;
        $imgpng = $imagen . ".png";
        $pathpng = "../../../../IMAGENES/" . $imgpng;
        $imgPNG = $imagen . ".PNG";
        $pathPNG = "../../../../IMAGENES/" . $imgPNG;
        //echo '<p>'.$path.'</p>';
        $ext=NULL;
        if (file_exists($pathjpg)) {
            $ext = ".jpg";
        }
        else if (file_exists($pathJPG)) {
            $ext = ".JPG";
        }
        else if (file_exists($pathpng)) {
            $ext = ".png";
        }
        else if (file_exists($pathPNG)) {
            $ext = ".PNG";
        }

        if ($ext!=NULL) {
            echo '
            <!--+++++++++++++++++++++++++++++++++++++++IMAGEN++++++++++++++++++++++++++++++++++++++++++++-->
            <div class="container" style="display:none" id ="' . $respuestaNumero . '">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                <img src="../../../../IMAGENES/' . $imagen . $ext .'" class="imagenPregunta" />
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
    /*
    Mis nacadas
    ID Pregunta = 1000 + Número de pregunta
    ID Respuesta = 2000 + Número de pregunta
    ID Respuesta correcta = 3000 + Número de pregunta

    Opción 4 = 10 * Número de pregunta
    Opción 3 = 10 * Número de pregunta - 1
    Opción 2 = 10 * Número de pregunta - 2
    Opción 1 = 10 * Número de pregunta - 3
    ID Boton aceptar = 10 * Número de pregunta - 4
    Texto Escrito = 10 * Número de pregunta - 5

    */
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
                    <p id="preguntaNumero">' . $preguntaNumero . '</p>
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
        $pathjpg = "../../../../IMAGENES/" . $imgjpg;
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
                            <img src="../../../../IMAGENES/' . $imagen . '.jpg" class="imagenPregunta" />
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
                            <button id="' . $IDBotonAceptar . '" class="miniBoton">Ok</button>
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