<?php
require "../../Servicios/DDBBVariables.php";
require "../../Servicios/isTeacher.php";
$teacherID = isTeacher();
if ($teacherID == "null") {
    header('Location: https://kaanbal.net/');
    exit;
}
?>

<!DOCTYPE html>
<html>

    <head>
      <meta charset="UTF-8" />
      <meta name="viewport" content="width=device-width, initial-scale=1" />
      <link
        rel="shortcut icon"
        type="image/x-icon"
        href="../CSSsJSs/icons/pyramid.svg"
      />
      <title>Kaanbal</title>
      <link rel="stylesheet" href="../CSSsJSs/bootstrap441.css" />
      <link rel="stylesheet" href="../CSSsJSs/kaanbalEssentials10.css" />
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
            <h4>Calificaciones</h4>
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
          <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <a href="elegirTSL/elegirAsignatura.php">
              <button type="button" class="btn btn-info">
                En un periodo de tiempo
              </button>
            </a>
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
          <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <a href="todo/elegirGrupo.php">
              <button type="button" class="btn btn-secondary">
                De todas las lecciones
              </button>
            </a>
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
          <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <a href="diamantes/elegirGrupo2.php">
              <button type="button" class="btn btn-success">
                Solo diamantes
              </button>
            </a>
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

    </body>

</html>