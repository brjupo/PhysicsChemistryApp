<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="shortcut icon" type="image/x-icon" href="../CSSsJSs/icons/pyramid.svg" />
    <title>Pregunta</title>
    <link rel="stylesheet" href="../CSSsJSs/bootstrap341.css" />
    <link rel="stylesheet" href="../CSSsJSs/stylePreguntas.css" />
    <script src="../CSSsJSs/scriptTipo2.js"></script>
</head>

<body>
<?php
  $con = mysqli_connect("localhost", "u526597556_dev", "1BLeeAgwq1*isgm&jBJe", "u526597556_kaanbal");
  //Traer todas las preguntas
  $query = "SELECT * FROM pregunta WHERE tipo = '2'"; //WHERE TEMA = 'TEMA' AND SUBTEMA = 'SUBTEMA' AND LECCION = 'LECCION'";     
  $result = mysqli_query($con, $query);
  //contar Numero de elementos
  $query2 = "SELECT count(*) FROM pregunta WHERE tipo = '2'"; // WHERE TEMA = 'TEMA' AND SUBTEMA = 'SUBTEMA' AND LECCION = 'LECCION'";
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
$arreglo = str_split($arrayr[$x]["pregunta"]);
// LEER CON BUCLE FOR EL ARREGLO HASTA ENCONTRAR GUION BAJO Y GUARDAR LA POSICION DONDE SE ENCUENTRE
$posicion = 0;
for ($i = 0; $i < strlen($arreglo); $i++){
    if ($arreglo[$i] == '_'){
    	$posicion = $i;
    	break;
    }
}
// PARTIR LA PREGUNTA EN 2 CADENAS, SI POSICION = 0, SIGNIFICA QUE LA PREGUNTA NO DEBE SER PARTIDA
if($posicion != 0){
	$preguntaParte1 = substr($arrayr[$x]["pregunta"], 0, $posicion - 1);
	$preguntaParte2 = substr($arrayr[$x]["pregunta"], $posicion + 1, strlen($arrayr[$x]["pregunta"]));
}
else{
	$preguntaParte1 = $arrayr[$x]["pregunta"];
    $preguntaParte2 = "";
	}
    $arrayr[$x]["preguntaParte1"] = $preguntaParte1; 
    $arrayr[$x]["preguntaParte2"] = $preguntaParte2;
}
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
  ?>

    <?php
    imprimirPreguntas($arrayr, $array, $total);
    ?>

    <?php
    function imprimirPreguntas($arrayr, $array, $total)
    {
        imprimirBarraProgresoCruz();
        imprimirContador();
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
        //Se imprime las siguientes preguntas INVISIBLES
        for ($x = 0; $x < $total[0]; $x++) {
            imprimirPregunta($x + 1, $arrayr[$x]["pregunta"]);
            imprimirImagenRespuestasTipo2($x + 1, $array[$x]["respuesta_correcta"],$array[$x]["id_pregunta"]);
        }
    }
    ?>


    <?php

    function imprimirBarraProgresoCruz()
    {
        echo '
            <div class="container">
                <div class="row topMargin">
                <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 col-xl-2">
                    <img src="../CSSsJSs/icons/clear.svg" id="cruzCerrar" class="cruz" />
                </div>
                <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10 col-xl-10">
                    <div class="progress progressMargin">
                    <!-- class="active"-->
                    <div class="progress-bar progress-bar-striped" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>
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
                    <p class="slide-bottom" id="previous">0m 10s</p>
                    <p class="slide-bottom" id="actual">0m 10s</p>
                    <p class="slide-bottom" id="later">0m 10s</p>
                    <p id="puntosBuenos"></p>
                </div>
                <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1 col-xl-1"></div>
                </div>
            </div>
            ';
    }

    function imprimirPregunta(int $preguntaNumero, $preguntaTexto)
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
    function imprimirImagenRespuestasTipo2(int $respuestas, $respCorrecta, $imagen)
    {      
        $IDTextoEscrito = 10 * $respuestas - 5;
        $IDBotonAceptar = 10 * $respuestas - 4;
        $respuestaNumero = 2000 + $respuestas;
        $IDvalorCorrecto = 3000 + $respuestas;
        $path="../imagenes/" . $imagen . ".jpg";
        //echo '<p>'.$path.'</p>';
        if(file_exists($path)){
            echo '
                <!--+++++++++++++++++++++++++++++++++++++++IMAGEN++++++++++++++++++++++++++++++++++++++++++++-->
                <div class="container" style="display:none" id ="' . $respuestaNumero . '">
                    <div class="row">
                        <!--div class="hidden-xs hidden-sm col-md-3 col-lg-3 col-xl-3"></div-->
                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                            <input type="text" id="' . $IDTextoEscrito . '"><br>
                            <button id="' . $IDBotonAceptar . '" class="miniBoton">Accept</button>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                            <img src="../imagenes/' . $imagen . '.jpg" class="imagenPregunta" />
                            <p id="' . $IDvalorCorrecto . '">
                            ' . $respCorrecta . '
                            </p>
                        </div>
                    </div>
                </div>
                ';
        }
        else{
            echo '
                <!--+++++++++++++++++++++++++++++++++++++++IMAGEN++++++++++++++++++++++++++++++++++++++++++++-->
                <div class="container" style="display:none" id ="' . $respuestaNumero . '">
                    <div class="row">
                        <!--div class="hidden-xs hidden-sm col-md-3 col-lg-3 col-xl-3"></div-->
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                            <input type="text" id="' . $IDTextoEscrito . '"><br>
                            <button id="' . $IDBotonAceptar . '" class="miniBoton">Accept</button>
                            <p id="' . $IDvalorCorrecto . '">
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
            <footer class="popUp animated bounceInUp" id="sprintNext" style="display: none;">
                <div class="container">
                <div class="row text-center">
                    <div class="hidden-xs hidden-sm col-md-4 col-lg-4 col-xl-4"></div>
                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                    <button class="botonContinuar fondoNeutro">Continuar</button>
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