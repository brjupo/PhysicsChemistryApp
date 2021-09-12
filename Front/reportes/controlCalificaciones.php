<?php
require "../../servicios/00DDBBVariables.php";
require "../../servicios/isTeacher.php";
require "../CSSsJSs/mainCSSsJSs.php";
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="shortcut icon" type="image/x-icon" href="../CSSsJSs/icons/pyramid.svg" />
  <title>Kaanbal</title>
  <link rel="stylesheet" href="../CSSsJSs/<?= $bootstrap441 ?>" />
  <link rel="stylesheet" href="../CSSsJSs/<?= $kaanbalEssentials ?>" />
</head>

<body>
  <!--KAANBAL TITULO-->
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

  <!--ESPACIO VACIO-->
  <div class="container">
    <div class="row">
      <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
        <p style="color: rgba(0, 0, 0, 0);">.</p>
      </div>
    </div>
  </div>

  <!--TITULO REPORTE-->
  <div class="container">
    <div class="row">
      <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
        <h4>Reportes</h4>
      </div>
    </div>
  </div>

  <!--ESPACIO VACIO-->
  <div class="container">
    <div class="row">
      <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
        <p style="color: rgba(0, 0, 0, 0);">.</p>
      </div>
    </div>
  </div>

  <!--ESPACIO VACIO-->
  <div class="container">
    <div class="row">
      <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
        <p style="color: rgba(0, 0, 0, 0);">.</p>
      </div>
    </div>
  </div>

  <!--ESPACIO VACIO-->
  <div class="container">
    <div class="row">
      <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
        <p style="color: rgba(0, 0, 0, 0);">.</p>
      </div>
    </div>
  </div>


  <!--REPORTE DETALLE ALUMNO-->
  <div class="container">
    <div class="row">
      <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
        <p>El reporte más completo que te incluye TODAS las calificaciones todas las lecciones, de las tres modalidades [práctica, sprint, examen], de todos los alumnos de UN grupo.</p>
        <p>Este reporte te será muy útil al cierre del semestre, ya que contiene TODA la información necesaria.</p>
      </div>
      <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
        <a href="alumno/elegirGrupo.php">
          <button type="button" class="btn btn-warning">
            Reporte detalle alumno
          </button>
        </a>
      </div>
    </div>
  </div>

  <!--ESPACIO VACIO-->
  <div class="container">
    <div class="row">
      <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
        <p style="color: rgba(0, 0, 0, 0);">.</p>
      </div>
    </div>
  </div>

  <!--ESPACIO VACIO-->
  <div class="container">
    <div class="row">
      <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
        <p style="color: rgba(0, 0, 0, 0);">.</p>
      </div>
    </div>
  </div>

  <!--REPORTE 1 TEMA 1 MODALIDAD-->
  <div class="container">
    <div class="row">
      <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
        <p>Este reporte SOLO incluye las calificaciones de UN tema [incluyendo todos los subtemas y todas las lecciones] y SOLO UNA modalidad [práctica, sprint o examen]</p>
        <p>Este reporte te será muy útil para subir calificaciones cada que acabes de ver un tema.</p>
      </div>
      <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
        <a href="todo/elegirGrupo.php">
          <button type="button" class="btn btn-secondary">
            1 Tema 1 Modalidad
          </button>
        </a>
      </div>
    </div>
  </div>

  <!--ESPACIO VACIO-->
  <div class="container">
    <div class="row">
      <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
        <p style="color: rgba(0, 0, 0, 0);">.</p>
      </div>
    </div>
  </div>

  <!--ESPACIO VACIO-->
  <div class="container">
    <div class="row">
      <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
        <p style="color: rgba(0, 0, 0, 0);">.</p>
      </div>
    </div>
  </div>

  <!--DIAMANTES-->
  <div class="container">
    <div class="row">
      <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
        <p>Este reporte SOLO incluye la suma de los diamantes obtenidos en un periodo de tiempo.</p>
        <p>Este reporte te será muy útil para fijar a tus alumnos una meta y valides que han usado la aplicación web.</p>
        <p style="font-size:small">El tiempo se determina al momento que el alumno FINALIZA su ejercicio.</p>
      </div>
      <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
        <a href="diamantes/elegirGrupo2.php">
          <button type="button" class="btn btn-success">
            Diamantes
          </button>
        </a>
      </div>
    </div>
  </div>

  <!--ESPACIO VACIO-->
  <div class="container">
    <div class="row">
      <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
        <p style="color: rgba(0, 0, 0, 0);">.</p>
      </div>
    </div>
  </div>

  <!--ESPACIO VACIO-->
  <div class="container">
    <div class="row">
      <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
        <p style="color: rgba(0, 0, 0, 0);">.</p>
      </div>
    </div>
  </div>

  <!--PERIODO DE TIEMPO-->
  <div class="container">
    <div class="row">
      <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
        <p>Este reporte SOLO incluye las calificaciones que el alumno obtuvo en un periodo de tiempo específico. UNA lección, UNA modalidad.</p>
        <p>Este reporte te será muy útil a la hora de hacer algún examen en clase o ejercicio en clase</p>
        <p style="font-size:small">Imprime la calificación MÁS alta del alumno obtenido UNICAMENTE en ese lapso de tiempo. El tiempo se determina al momento que el alumno FINALIZA su ejercicio.</p>
      </div>
      <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
        <a href="elegirTSL/elegirAsignatura.php">
          <button type="button" class="btn btn-info">
            Periodo de tiempo
          </button>
        </a>
      </div>
    </div>
  </div>

  <!--ESPACIO VACIO-->
  <div class="container">
    <div class="row">
      <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
        <p style="color: rgba(0, 0, 0, 0);">.</p>
      </div>
    </div>
  </div>

  <!--TIEMPO INVERTIDO POR ALUMNO-->
  <div class="container">
    <div class="row">
      <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
        <p>Este reporte SOLO incluye el tiempo en minutos que el alumno ha jugado en Kaanbal</p>
        <p>Este reporte te será muy útil para controlar el uso de dispositivos electrónicos de tus alumnos</p>
      </div>
      <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
        <a href="tiempo/elegirGrupo.php">
          <button type="button" class="btn btn-danger">
            Tiempo invertido por los alumnos de un grupo
          </button>
        </a>
      </div>
    </div>
  </div>

  <!--ESPACIO VACIO-->
  <div class="container">
    <div class="row">
      <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
        <p style="color: rgba(0, 0, 0, 0);">.</p>
      </div>
    </div>
  </div>


</body>

</html>