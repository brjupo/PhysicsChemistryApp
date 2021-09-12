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
      <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
        <h1 class="titulo">Kaanbal</h1>
      </div>
    </div>
  </div>

  <!-- -->
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
        <p style="font-size:xx-large">Reportes</p>
      </div>
    </div>
    <div class="row">
      <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
        <p style="font-size:large" id="botonInstrucciones">Da clic aquí para mostrar las instrucciones</p>
      </div>
    </div>
    <div class="row" id="instrucciones" style="display:none;">
      <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
        <p><strong>RECUERDA:</strong></p>
        <p>Kaanbal trabaja con el siguiente árbol:</p>
        <p>- Cada MATERIA tiene varios TEMAS</p>
        <p>- Cada TEMA tiene varios SUBTEMAS</p>
        <p>- Cada SUBTEMA tiene varias LECCIONES</p>
        <p>.</p>
        <p>Kaanbal tiene 3 modos de juego:</p>
        <p><strong>Práctica:</strong> Se muestran las preguntas en un orden que permiten al alumno aprender de manera escalonada, paso a paso.</p>
        <p><strong>Sprint:</strong> Son las mismas preguntas que la modalidad práctica, pero ordenadas de manera aleatoria y con un límite de tiempo para cada pregunta. Si se equivoca en 1, o el tiempo vence, ese juego termina y muestra su calificación obtenida.</p>
        <p><strong>Examen:</strong> Son las mismas preguntas que la modalidad práctica, pero ordenadas de manera aleatoria y con un límite de tiempo para TODO el juego. Si el tiempo vence, ese juego termina y muestra su calificación obtenida.</p>
        <p>.</p>
        <p>Kaanbal trabaja con un sistema de diamantes. </p>
        <p>Para el caso de la modalidad práctica y examen se otorga 1 diamante por cada respuesta contestada de manera correcta. Si el alumno repite el juego NO obtendrá diamantes adicionales, a menos que, supere su calificación anterior.</p>
        <p>Para el caso de sprint, se otorgan 3 diamantes si el alumno contestó en la primera tercera parte del tiempo, se otorgan 2 diamantes si el alumno contestó en la segunda tercera parte del tiempo, se otorga 1 diamante si el alumno contestó en la última tercera parte del tiempo. Si el alumno repite el juego NO obtendrá diamantes adicionales, a menos que, supere su calificación anterior.</p>
      </div>
    </div>
  </div>

  <!-- -->
  <div class="container">
    <div class="row">
      <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
        <p style="color: rgba(0, 0, 0, 0);">.</p>
      </div>
    </div>
  </div>

  <!-- -->
  <div class="container">
    <div class="row">
      <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
        <p style="color: rgba(0, 0, 0, 0);">.</p>
      </div>
    </div>
  </div>

  <!-- -->
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
        <p>El más completo, incluye TODAS las calificaciones todas las lecciones, de las tres modalidades [práctica, sprint, examen], de todos los alumnos de UN grupo.</p>
        <p>Te será muy útil al cierre del semestre, ya que contiene TODA la información necesaria.</p>
      </div>
      <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
        <a href="alumno/elegirGrupo.php">
          <button type="button" class="btn btn-warning">
            Detalle alumno
          </button>
        </a>
      </div>
    </div>
  </div>

  <!-- -->
  <div class="container">
    <div class="row">
      <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
        <p style="color: rgba(0, 0, 0, 0);">.</p>
      </div>
    </div>
  </div>

  <!-- -->
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
        <p>SOLO incluye las calificaciones de UN tema [incluyendo todos los subtemas y todas las lecciones] y SOLO UNA modalidad [práctica, sprint o examen]</p>
        <p>Te será muy útil para subir calificaciones cada que acabes de ver un tema.</p>
      </div>
      <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
        <a href="unTemaUnaModalidad/elegirGrupo.php">
          <button type="button" class="btn btn-secondary">
            1 Tema 1 Modalidad
          </button>
        </a>
      </div>
    </div>
  </div>

<!--REPORTE TODOS LOS TEMAS 1 MODALIDAD-->
<div class="container">
  <div class="row">
    <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
      <p>SOLO incluye las calificaciones de UN tema [incluyendo todos los subtemas y todas las lecciones] y SOLO UNA modalidad [práctica, sprint o examen]</p>
      <p>Te será muy útil para subir calificaciones cada que acabes de ver un tema.</p>
    </div>
    <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
      <a href="todo/elegirGrupo.php">
        <button type="button" class="btn btn-secondary">
          Todos los Temas 1 Modalidad
        </button>
      </a>
    </div>
  </div>
</div>

  <!-- -->
  <div class="container">
    <div class="row">
      <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
        <p style="color: rgba(0, 0, 0, 0);">.</p>
      </div>
    </div>
  </div>

  <!-- -->
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
        <p>SOLO incluye la suma de los diamantes obtenidos en un periodo de tiempo.</p>
        <p>Te será muy útil para fijar a tus alumnos una meta y valides que han usado la aplicación web.</p>
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

  <!-- -->
  <div class="container">
    <div class="row">
      <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
        <p style="color: rgba(0, 0, 0, 0);">.</p>
      </div>
    </div>
  </div>

  <!-- -->
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
        <p>SOLO incluye las calificaciones que el alumno obtuvo en un periodo de tiempo específico. UNA lección, UNA modalidad.</p>
        <p>Te será muy útil a la hora de hacer algún examen en clase o ejercicio en clase</p>
        <p style="font-size:small">Imprime la calificación MÁS alta del alumno obtenido ÚNICAMENTE en ese lapso de tiempo. El tiempo se determina al momento que el alumno FINALIZA su ejercicio.</p>
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

  <!-- -->
  <div class="container">
    <div class="row">
      <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
        <p style="color: rgba(0, 0, 0, 0);">.</p>
      </div>
    </div>
  </div>

  <!-- -->
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
        <p>SOLO incluye el tiempo en minutos que el alumno ha jugado en Kaanbal</p>
        <p>Te será muy útil para controlar el uso de dispositivos electrónicos de tus alumnos</p>
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

  <!-- -->
  <div class="container">
    <div class="row">
      <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
        <p style="color: rgba(0, 0, 0, 0);">.</p>
      </div>
    </div>
  </div>

  <!-- -->
  <div class="container">
    <div class="row">
      <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
        <p style="color: rgba(0, 0, 0, 0);">.</p>
      </div>
    </div>
  </div>


</body>
<script>
  document.getElementById("botonInstrucciones").addEventListener("click", myFunction);

  function myFunction() {
    if (document.getElementById("instrucciones").style.display == "block") {
      document.getElementById("instrucciones").style.display = "none";

    } else {
      document.getElementById("instrucciones").style.display = "block";
    }
  }
</script>

</html>