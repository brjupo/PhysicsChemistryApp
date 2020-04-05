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
  imprimirPreguntas();

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
  function imprimirPreguntasRespuestas(){
    imprimirPregunta(1,1);
    imprimirImagenRespuestas(1,1);
    for ($x = 2; $x <= 10; $x++) {
      imprimirPregunta($x,0);
      imprimirImagenRespuestas($x,0);
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
          </div>
          <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1 col-xl-1"></div>
        </div>
      </div>
    ';
  }

  function imprimirPregunta(int $pregunta, int $mostrar)
  {
    if($mostrar==0){
      $display = "none";
    }
    else{
      $display = "block";
    }
    echo '
      <!--+++++++++++++++++++++++++++++++++++++++PREGUNTA++++++++++++++++++++++++++++++++++++++++++++-->
      <div class="container" style="display:'.$display.'">
        <div class="row">
          <div class="hidden-xs hidden-sm col-md-1 col-lg-1 col-xl-1"></div>
          <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 col-xl-10">
            <p class="formatoPreguntas">
              ¿Cuál es la equivalencia correcta para la expresion
              10^6?
            </p>
          </div>
          <div class="hidden-xs hidden-sm col-md-1 col-lg-1 col-xl-1"></div>
        </div>
      </div>
    ';
  }
  function imprimirImagenRespuestas(int $respuestas, int $mostrar)
  {
    if($mostrar==0){
      $display = "none";
    }
    else{
      $display = "block";
    }
    echo '
      <!--+++++++++++++++++++++++++++++++++++++++IMAGEN++++++++++++++++++++++++++++++++++++++++++++-->
      <div class="container" style="display:'.$display.'">
        <div class="row">
          <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
            <img src="../CSSsJSs/images/problemaFisica.jpg" class="imagenPregunta" />
          </div>
          <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3 col-xl-3">
            <button class="Opcion1" id="Opcion1">
              <table style="width: 100%;">
                <tr>
                  <td>10,000</td>
                </tr>
              </table>
            </button><br />
            <button class="Opcion3" id="Opcion3">
              <table style="width: 100%;">
                <tr>
                  <td>1,000,000</td>
                </tr>
              </table>
            </button>
          </div>
          <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3 col-xl-3">
            <button class="Opcion2" id="Opcion2">
              <table style="width: 100%;">
                <tr>
                  <td>100,000</td>
                </tr>
              </table>
            </button><br />
            <button class="Opcion4" id="Opcion4">
              <table style="width: 100%;">
                <tr>
                  <td>10,000,000</td>
                </tr>
              </table>
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