<?php
require "../../../servicios/00DDBBVariables.php";
require "../../../servicios/isTeacher.php";
$teacherID = isTeacher();
require "../../CSSsJSs/mainCSSsJSs.php";
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="shortcut icon" type="image/x-icon" href="../../CSSsJSs/icons/pyramid.svg" />
  <title>Kaanbal</title>
  <link rel="stylesheet" href="../../CSSsJSs/<?= $bootstrap441 ?>" />
  <link rel="stylesheet" href="../../CSSsJSs/<?= $kaanbalEssentials ?>" />
</head>

<body>
  <div class="container">
    <div class="row">
      <div class="col-1 col-sm-1 col-md-1 col-lg-1 col-xl-1"></div>
      <div class="col-5 col-sm-5 col-md-5 col-lg-5 col-xl-5">
        <h1 class="titulo">Kaanbal</h1>
      </div>
      <div class="col-5 col-sm-5 col-md-5 col-lg-5 col-xl-5"></div>
      <div class="col-1 col-sm-1 col-md-1 col-lg-1 col-xl-1"></div>
    </div>
  </div>

  <div class="container">
    <div class="row">
      <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
        <p style="color: rgba(0, 0, 0, 0);">.</p>
      </div>
    </div>
  </div>
  <div class="container">
    <div class="row">
      <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
        <p>
          - De clic en el botón "Elegir grupo y modo"
        </p>
      </div>
    </div>
  </div>

  <div class="container">
    <div class="row">
      <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
        <p style="color: rgba(0, 0, 0, 0);">.</p>
      </div>
    </div>
  </div>


  <div class="container">
    <div class="row">
      <?php
      $idSubtema = $_GET['ID_Subtema'];
      $con = mysqli_connect($servername, $username, $password, $dbname);
      $statement = mysqli_prepare($con, "SELECT id_leccion, nombre FROM leccion WHERE id_subtema = ?");
      mysqli_stmt_bind_param($statement, "i", $idSubtema);
      mysqli_stmt_execute($statement);

      mysqli_stmt_store_result($statement);
      mysqli_stmt_bind_result($statement, $id_leccion, $nombre);

      //Leemos datos del la leccion habilitadas
      while (mysqli_stmt_fetch($statement)) {
        echo '
          <div class="input-group col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="input-group-prepend">
              <span class="input-group-text">' . $id_leccion . '</span>
            </div>
            <input type="text" class="form-control" id="' . $id_leccion . '" value="' . $nombre . '" />
            <div class="input-group-append">
              <a href="elegirMyG.php?ID_Leccion=' . $id_leccion . '">
                <button class="btn btn-outline-secondary" type="button">
                  Elegir grupo y modo
                </button>
              </a>
            </div>
          </div>
          <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <p style="color: rgba(0, 0, 0, 0);">.</p>
          </div>
        ';
      }
      ?>
    </div>
  </div>

  <div class="container">
    <div class="row">
      <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
        <p style="color: rgba(0, 0, 0, 0);">.</p>
      </div>
      <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
        <p style="color: rgba(0, 0, 0, 0);">.</p>
      </div>
      <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
        <p style="color: rgba(0, 0, 0, 0);">.</p>
      </div>
      <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
        <p style="color: rgba(0, 0, 0, 0);">.</p>
      </div>
      <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
        <p style="color: rgba(0, 0, 0, 0);">.</p>
      </div>
    </div>
  </div>

  <div class="foot">
    <div class="container">
      <div class="row text-center">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
          <a href="../controlCalificaciones.php">
            <img class="footIcon" id="botonHomeTeacher" src="../../CSSsJSs/icons/home.svg" /></a>
        </div>
      </div>
    </div>
  </div>

</body>

</html>