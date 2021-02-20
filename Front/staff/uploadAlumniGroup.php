<?php
require "../../servicios/00DDBBVariables.php";
require "../../servicios/isStaff.php";
$staffID = isStaff();
if ($staffID == "null") {
    header('Location: https://kaanbal.net/');
    exit;
}
require "../CSSsJSs/mainCSSsJSs.php";
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="shortcut icon" type="image/x-icon" href="../CSSsJSs/icons/pyramid.svg" />
    <title>Kaanbal</title>
    <link rel="stylesheet" href="../CSSsJSs/<?=$bootstrap441?>" />
    <link rel="stylesheet" href="../CSSsJSs/<?=$kaanbalEssentials?>" />
</head>

<body>
  <div class="container">
    <div class="row">
      <div class="text-center col-1 col-sm-1 col-md-1 col-lg-1 col-xl-1"></div>
      <div class="textLeft col-5 col-sm-5 col-md-5 col-lg-5 col-xl-5">
        <p class="titulo" id="titulo">Kaanbal</p>
      </div>
      <div class="textRight col-5 col-sm-5 col-md-5 col-lg-5 col-xl-5"></div>
      <div class="text-center col-1 col-sm-1 col-md-1 col-lg-1 col-xl-1"></div>
    </div>
  </div>
  <div class="container">
    <div class="row">
      <div class="text-center col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
        <p style="color: rgba(0, 0, 0, 0);">.</p>
      </div>
    </div>
    <div class="row">
      <div class="text-center col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
        <p style="color: rgba(0, 0, 0, 0);">.</p>
      </div>
    </div>
  </div>

  <div class="container">
    <div class="row">
      <div class="text-center col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
        <h3>Instrucciones</h3>
        <p>0.- Para subir a los alumnos <strong>verifica que el grupo exista en la sección <a href="createGroup.php">"Crear grupos"</a></strong></p>
        <p>1.- Descarga la plantilla y abrelo en Excel</p>
        <a href="usuario_prueba_grupo.csv" download="usuario_prueba_grupo.csv"><img width="50px" src="../CSSsJSs/icons/csv.svg"></a>
        <p>2.- Te encontrarás con algo similar a lo siguiente</p>
        <table class="table">
          <tr>
            <td>Correo</td>
            <td>Password</td>
            <td>Asignatura</td>
            <td>¿Es profesor?</td>
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
        <p style="font-size:small">3.2.- Para dar de alta a los alumnos, el campo profesor va vacio. </p>
        <p style="font-size:small">3.3.- Para crear un profesor el campo profesor deberá contener una "p" y el campo grupo deberá ir vacio.</p>
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
            <td>05EMM25@kaanbal.net</td>
            <td>05EMM25@kaanbal.net</td>
            <td>1</td>
            <td></td>
            <td>25</td>
          </tr>
          <tr>
            <td>15SFE04@kaanbal.net</td>
            <td>15SFE04@kaanbal.net</td>
            <td>2</td>
            <td></td>
            <td>04</td>
          </tr>
          <tr>
            <td>SFM08@kaanbal.net</td>
            <td>SFM08@kaanbal.net</td>
            <td>1</td>
            <td>p</td>
            <td></td>
          </tr>
          <tr>
            <td>15SFM08@kaanbal.net</td>
            <td>15SFM08@kaanbal.net</td>
            <td>1</td>
            <td></td>
            <td>08</td>
          </tr>
          <tr>
            <td>ESE08@kaanbal.net</td>
            <td>ESE08@kaanbal.net</td>
            <td>2</td>
            <td>p</td>
            <td></td>
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
      <div class="text-center col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
        <p style="color: rgba(0, 0, 0, 0);">.</p>
      </div>
    </div>
    <div class="row">
      <div class="text-center col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
        <p style="color: rgba(0, 0, 0, 0);">.</p>
      </div>
    </div>
  </div>

  <div class="container">
    <div class="row">
      <div class="text-center col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
        <form class="form-horizontal" action="../../servicios/subirUsuarios.php" method="post" name="upload_excel" enctype="multipart/form-data">
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
      <div class="text-center col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
        <p style="color: rgba(0, 0, 0, 0);">.</p>
      </div>
    </div>
    <div class="row">
      <div class="text-center col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
        <p style="color: rgba(0, 0, 0, 0);">.</p>
      </div>
    </div>
  </div>
</body>

</html>