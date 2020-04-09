<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="shortcut icon" type="image/x-icon" href="../CSSsJSs/icons/pyramid.svg" />
  <title>Pregunta</title>
  <link rel="stylesheet" href="../CSSsJSs/bootstrap341.css" />
  <link rel="stylesheet" href="../CSSsJSs/stylePreguntas.css" />
  <script src="../CSSsJSs/scriptSprint.js"></script>
</head>

<body>
<?php
  $con = mysqli_connect("localhost", "u526597556_dev", "1BLeeAgwq1*isgm&jBJe", "u526597556_kaanbal");
  //Traer todas las preguntas
  $query = "SELECT * FROM pregunta"; //WHERE TEMA = 'TEMA' AND SUBTEMA = 'SUBTEMA' AND LECCION = 'LECCION'";     
  $result = mysqli_query($con, $query);
  //contar Numero de elementos
  $query2 = "SELECT count(*) FROM pregunta"; // WHERE TEMA = 'TEMA' AND SUBTEMA = 'SUBTEMA' AND LECCION = 'LECCION'";
  $result2 = mysqli_query($con, $query2);
  $total = mysqli_fetch_row($result2);
  //$total = 10;
  //Recorrer el arreglo
  while ($row = mysqli_fetch_assoc($result)) {
    $array[] = $row;
    $arrayr[] = $row;
  }
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
      imprimirImagenRespuestas($x + 1, $arrayr[$x]["respuesta_correcta"],
       $arrayr[$x]["respuesta2"], $arrayr[$x]["respuesta3"],
       $arrayr[$x]["respuesta4"], $array[$x]["respuesta_correcta"]);
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
    $preguntaNumero = 100 + $preguntaNumero;
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
  function imprimirImagenRespuestas(int $respuestas, $r1, $r2, $r3, $r4, $respCorrecta)
  {
    $uno = 4 * $respuestas - 3;
    $dos = 4 * $respuestas - 2;
    $tres = 4 * $respuestas - 1;
    $cuatro = 4 * $respuestas;
    $respuestaNumero = 200 + $respuestas;
    $IDvalorCorrecto = 300 + $respuestas;
    echo '
    <!--+++++++++++++++++++++++++++++++++++++++IMAGEN++++++++++++++++++++++++++++++++++++++++++++-->
    <div class="container" style="display:none" id ="' . $respuestaNumero . '">
      <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
          <img src="../CSSsJSs/images/problemaFisica.jpg" class="imagenPregunta" />
          <p id="' . $IDvalorCorrecto . '">
            ' . $respCorrecta . '
          </p>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3 col-xl-3">
          <button class="Opcion1" id="' . $uno . '">
            ' . $r1 . '
          </button><br>
          <button class="Opcion3" id="' . $dos . '">
            ' . $r2 . '
          </button>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3 col-xl-3">
          <button class="Opcion2" id="' . $tres . '">
            ' . $r3 . '
          </button><br>
          <button class="Opcion4" id="' . $cuatro . '">
            ' . $r4 . '
          </button>
        </div>
      </div>
    </div>
  ';
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