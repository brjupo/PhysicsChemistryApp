<!DOCTYPE html>
<html>
<?php
$con = mysqli_connect("localhost", "u526597556_dev", "1BLeeAgwq1*isgm&jBJe", "u526597556_kaanbal");
//////////////////////////////////////////////////////
session_start();
$tokenValidar = array();
$idValidarprofe = array();

//Consultar si existe token de usuario
$statement = mysqli_prepare($con, "SELECT tokenSesion, id_usuario FROM usuario_prueba WHERE mail = ?");
mysqli_stmt_bind_param($statement, "s", $_SESSION["mail"]);
mysqli_stmt_execute($statement);

mysqli_stmt_store_result($statement);
mysqli_stmt_bind_result($statement, $tokenSesionp, $iduser);

while (mysqli_stmt_fetch($statement)) {
  $idValidarprofe["profe"] = $iduser;
  $tokenValidar["tokenSesionp"] = $tokenSesionp;
}

//Consultar si es profe
$statement = mysqli_prepare($con, "SELECT id_profesor FROM profesor WHERE id_usuario = ?");
mysqli_stmt_bind_param($statement, "s", $idValidarprofe["profe"]);
mysqli_stmt_execute($statement);

mysqli_stmt_store_result($statement);
mysqli_stmt_bind_result($statement, $idProfe);

while (mysqli_stmt_fetch($statement)) {
  $existeProfe["profe"] = $idProfe;
}

if ($_SESSION["tokenSesion"] == $tokenValidar["tokenSesionp"] and $existeProfe["profe"] != "" and $tokenValidar["tokenSesionp"] != "") {
  printTeacherControlPanel();
} else {
  echo '<script type="text/javascript">
  alert("Inicie sesión");
  window.location.href="https://kaanbal.net";
  </script>';
}
?>

<?php

function printTeacherControlPanel()
{
  echo '
    <head>
      <meta charset="UTF-8" />
      <meta name="viewport" content="width=device-width, initial-scale=1" />
      <link
        rel="shortcut icon"
        type="image/x-icon"
        href="../CSSsJSs/icons/pyramid.svg"
      />
      <title>Kaanbal</title>
      <link rel="stylesheet" href="CSSsJSs/bootstrap441.css" />
      <link rel="stylesheet" href="CSSsJSs/kaanbalEsentials.css" />
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
            <h4>Panel de Profesores</h4>
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
            <a href="editarPreguntas/editAllQuestionByID.php">
              <button type="button" class="btn btn-info">
                Editar preguntas por ID. Con boton de "siguiente"
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
            <a href="editarPreguntas/editAllQuestion.php">
              <button type="button" class="btn btn-info">
                Editar preguntas por leccion y número de pregunta"
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
            <a href="editarNombre/elegirAsignatura.php">
              <button type="button" class="btn btn-success">
                Cambiar títulos de temas, subtemas y/o lecciones
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
            <a href="editarOrden/elegirAsignatura.php">
              <button type="button" class="btn btn-success">
                Editar Orden de temas, subtemas y/o lecciones
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
            <a href="crearNuevo/elegirAsignatura.php">
              <button type="button" class="btn btn-secondary">
                Crear nuevo tema, subtema, lección y/o pregunta
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
            <a href="tiempoSprintExamen/elegirAsignatura.php">
              <button type="button" class="btn btn-secondary">
                Modificar el tiempo para los sprints y los examenes
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
            <a href="linksGenially/elegirAsignatura.php">
              <button type="button" class="btn btn-danger">
                Agregar links de Genially [En Español]
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
            <a href="traducirTSL/elegirAsignatura.php">
              <button type="button" class="btn btn-danger">
                Traducir temas, subtemas y lecciones
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
    ';
}
?>


</html>