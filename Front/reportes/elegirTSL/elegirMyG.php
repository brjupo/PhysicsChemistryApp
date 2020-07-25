<?php
require "../../../Servicios/DDBBVariables.php";
require "../../../Servicios/isTeacher.php";
$teacherID = isTeacher();
if ($teacherID=="null") {
    header('Location: https://kaanbal.net/');
    exit;
} else {
    printMYG($teacherID);
}


function printMyG($teacherID)
{
    echo '
        <!DOCTYPE html>
        <html>';
    printHead();
    echo '<body>';
    printTitle();
    printInstructions();
    printCombos($teacherID);
    echo '
        </body>
        </html>';
}


function printHead()
{
    echo '
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link
      rel="shortcut icon"
      type="image/x-icon"
      href="../../CSSsJSs/icons/pyramid.svg"
    />
    <title>Kaanbal</title>
    <link rel="stylesheet" href="../../CSSsJSs/bootstrap441.css" />
    <link rel="stylesheet" href="../../CSSsJSs/kaanbalEssentials.css" />
  </head>
  ';
}
function printTitle()
{
    echo '
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
  ';
}

function printInstructions()
{
    echo '
  <div class="container">
    <div class="row">
      <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
        <p>
          - Elija el grupo y la modalidad, y de clic en "generar reporte".
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
  ';
}

function printCombos($teacherID)
{
    echo '
  <div class="container">
    <div class="row">
      <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
        <div class="input-group-prepend">
            <label class="input-group-text" for="grupo">Grupo</label>
            <p>'.$teacherID.'</p>
        </div>
            <select class="custom-select" id="grupo">
                <option selected disabled value="0">Elegir</option>';

    global $servername, $username, $password, $dbname;
    //Crear la lectura en base de datos
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stringQuery = 'SELECT id_grupo, nombre FROM grupo WHERE id_profesor = ' . $teacherID . ';';
        $stmt = $conn->query($stringQuery);
        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            echo '<option value="' . $row[0] . '">' . $row[1] . '</option>';
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    $conn = null;

    echo '
            </select>
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
  ';

    echo '
  <div class="container">
    <div class="row">
      <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
        <div class="input-group-prepend">
            <label class="input-group-text" for="modalidad">Modalidad</label>
        </div>
            <select class="custom-select" id="modalidad">
                <option selected disabled value="0">Elegir</option>
                <option value="PP">Práctica</option>
                <option value="SP">Sprint</option>
                <option value="E">Examen</option>
                <option value="SS">Super Sprint</option>
            </select>
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
  ';
}
