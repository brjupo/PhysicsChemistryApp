<?php
require "../../CSSsJSs/mainCSSsJSs.php";
if (empty($_GET)) {
  header("Location: https://kaanbal.net");
}
$subtema = $_GET['subtema'];
$puntos = $_GET['puntos'];
$totalPreguntas = $_GET['totalPreguntas'];
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="shortcut icon" type="image/x-icon" href="../../CSSsJSs/icons/pyramid.svg" />
  <title>Sprint Completado</title>
  <link rel="stylesheet" href="../../CSSsJSs/<?php echo $bootstrap341; ?>" />
  <link rel="stylesheet" href="../../CSSsJSs/<?php echo $kaanbalEssentials; ?>" />
  <link rel="stylesheet" href="../../CSSsJSs/<?php echo $stylePreguntas; ?>" />
  <link rel="stylesheet" href="../../CSSsJSs/styleNivelCompletado.css" />
  <script src="../../CSSsJSs/scriptNivelCompletado.js"></script>

  <!-- Global site tag (gtag.js) - Google Analytics -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=G-F7VGWM5LKB"></script>
  <script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
      dataLayer.push(arguments);
    }
    gtag('js', new Date());

    gtag('config', 'G-F7VGWM5LKB');
  </script>

</head>

<body>

  <div class="container">
    <div class="row topMargin">
      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
        <div class="progress progressMargin">
          <!-- class="active"-->
          <div class="progress-bar progress-bar-striped" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" <?php echo 'style="width:' . floor(100 * intval($puntos / 3) / intval($totalPreguntas)) . '%"'; ?>>
            <?php echo '' . floor(100 * intval($puntos / 3) / intval($totalPreguntas)) . '%'; ?>
          </div>
        </div>
      </div>
      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
        <p style="color: rgba(0, 0, 0, 0);">.</p>
      </div>
    </div>
  </div>
  <!--+++++++++++++++++++++++++++++++++++++++PREGUNTA++++++++++++++++++++++++++++++++++++++++++++-->
  <div class="container">
    <div class="row">
      <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1 col-xl-1"></div>
      <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10 col-xl-10"></div>
      <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1 col-xl-1"></div>
    </div>
  </div>
  <!--+++++++++++++++++++++++++++++++++++++++IMAGEN++++++++++++++++++++++++++++++++++++++++++++-->
  <div class="container">
    <div class="row">
      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
        <p style="color: rgba(0, 0, 0, 0);">.</p>
      </div>
    </div>
  </div>
  <div class="container">
    <div class="row">
      <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
        <h3>You have completed this sprint!</h3>
        <p id="numeroDiamantes" class="numeroDiamantes">
          <?php echo intval($puntos); ?>
        </p>
        <img class="diamanteIcon" src="../../CSSsJSs/icons/diamante.svg" />
      </div>
      <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
        <img src="../../CSSsJSs/icons/star.svg" class="spin animated star" style="width: 60%;" />
      </div>
    </div>
  </div>

  <div class="popUp animated bounceInUp" id="botonSiguientePregunta">
    <div class="container">
      <div class="row text-center">
        <div class="hidden-xs hidden-sm col-md-4 col-lg-4 col-xl-4"></div>
        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
          <a href="<?php echo '../../Inicio/lecciones.php?subtema=' . $subtema; ?>">
            <button class="botonContinuar">Continue</button>
          </a>
        </div>
        <div class="hidden-xs hidden-sm col-md-4 col-lg-4 col-xl-4"></div>
      </div>
    </div>
  </div>
</body>

</html>