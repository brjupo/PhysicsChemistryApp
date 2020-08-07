<?php
require "../../Servicios/DDBBVariables.php";
require "../../Servicios/isAdmin.php";
$adminID = isAdmin();
if ($adminID == "null") {
  header('Location: https://kaanbal.net/');
  exit;
}
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="shortcut icon" type="image/x-icon" href="../CSSsJSs/icons/pyramid.svg" />
  <title>Kaanbal</title>
  <link rel="stylesheet" href="../CSSsJSs/bootstrap441.css" />
  <link rel="stylesheet" href="../CSSsJSs/kaanbalEssentials.css" />
</head>

<body>
  <div class="container">
    <div class="row">
      <div class="textCenter col-1 col-sm-1 col-md-1 col-lg-1 col-xl-1"></div>
      <div class="textLeft col-5 col-sm-5 col-md-5 col-lg-5 col-xl-5">
        <p class="titulo" id="titulo">Kaanbal</p>
      </div>
      <div class="textRight col-5 col-sm-5 col-md-5 col-lg-5 col-xl-5"></div>
      <div class="textCenter col-1 col-sm-1 col-md-1 col-lg-1 col-xl-1"></div>
    </div>
  </div>
  <div class="container">
    <div class="row">
      <div class="textCenter col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
        <p style="color: rgba(0, 0, 0, 0);">.</p>
      </div>
    </div>
    <div class="row">
      <div class="textCenter col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
        <p style="color: rgba(0, 0, 0, 0);">.</p>
      </div>
    </div>
  </div>

  <div class="container">
    <div class="row">
      <div class="textCenter col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
        <h3>Instrucciones</h3>
        <p>0.- <strong>Verifica que el grupo exista en la sección <a href="createGroup.php">"Crear grupos"</a></strong></p>
        <p>1.- Descarga la plantilla</p>
        <a href="usuario_prueba_grupo.csv"><img width="50px" src="../CSSsJSs/icons/csv.svg"></a>
        <p>2.- Te encontrarás con algo similar a lo siguiente</p>
        <table class="table">
          <tr>
            <td>Correo</td>
            <td>Password</td>
            <td>Asignatura</td>
            <td>Profesor</td>
            <td>Grupo</td>
          </tr>
          <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
        </table>
        <p>.</p>
        <p>3.- Deberás llenarlo de manera cuidadosa.
          Un espacio antes o después de algún dato, causará un error</p>
        <p style="font-size:small">3.1.- En el caso de Asignatura.
          En lugar del nombre deberás colocar el número 1,
          para aquellos que se inscriban en Materia y el entorno. Y 2 en lugar de Energía y transformación I</p>
        <p style="font-size:small">1 - Materia y el entorno</p>
        <p style="font-size:small">2 - Energía y transformación I</p>
        <p>.</p>
        <p>4.- A continuación se muestra un ejemplo</p>
        <table class="table">
          <tr>
            <td>Correo</td>
            <td>Password</td>
            <td>Asignatura</td>
            <td>Profesor</td>
            <td>Grupo</td>
          </tr>
          <tr>
            <td>A01169493@itesm.mx</td>
            <td>A01169493@itesm.mx</td>
            <td>1</td>
            <td>jehoyos@tec.mx</td>
            <td>HCS001.11M</td>
          </tr>
          <tr>
            <td>A01379493@itesm.mx</td>
            <td>A01379493@itesm.mx</td>
            <td>2</td>
            <td>asdf@tec.mx</td>
            <td>JDGH01.M02</td>
          </tr>
        </table>
        <p>5.- Recuerda guardarlo en CSV, de lo contrario no se subirá</p>
        <p>6.- Da clic en el botón "browse...", selecciona tu archivo</p>
        <p>7.- Da clic en "subir"</p>
        <p>8.- Consulta en la sección <a href="showAllAlumni.php">"Ver todos los alumnos y su grupo"</a>, 
          para validar que los alumnos hayan sido registrados</p>
        <p>9.- Si en la sección "Ver todos los alumnos y su grupo", NO ESTÁN, reintenta siguiendo estos pasos</p>
      </div>
    </div>
  </div>

  <div class="container">
    <div class="row">
      <div class="textCenter col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
        <p style="color: rgba(0, 0, 0, 0);">.</p>
      </div>
    </div>
    <div class="row">
      <div class="textCenter col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
        <p style="color: rgba(0, 0, 0, 0);">.</p>
      </div>
    </div>
  </div>

  <div class="container">
    <div class="row">
      <div class="textCenter col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
        <form class="form-horizontal" action="../../Servicios/subirUsuarios.php" method="post" name="upload_excel" enctype="multipart/form-data">
          <fieldset>
            <!-- Form Name -->
            <legend>Subir Información de Alumnos</legend>
            <!-- File Button -->
            <div class="form-group">
              <label class="control-label" for="filebutton">Seleccionar archivo .csv</label>
              <div class="">
                <input type="file" name="file" id="file" class="input-large">
              </div>
            </div>
            <!-- Button -->
            <div class="form-group">
              <div class="">
                <button type="submit" id="submit" name="Import" class="btn btn-primary button-loading boton2" data-loading-text="Loading...">Subir</button>
              </div>
            </div>
          </fieldset>
        </form>
      </div>
    </div>
  </div>

  <div class="container">
    <div class="row">
      <div class="textCenter col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
        <p style="color: rgba(0, 0, 0, 0);">.</p>
      </div>
    </div>
    <div class="row">
      <div class="textCenter col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
        <p style="color: rgba(0, 0, 0, 0);">.</p>
      </div>
    </div>
  </div>
</body>

</html>