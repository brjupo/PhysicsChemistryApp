<?php
require "../../../servicios/DDBBVariables.php";
require "../../../servicios/isAdmin.php";
$adminID = isAdmin();
if ($adminID == "null") {
  header('Location: https://kaanbal.net/');
  exit;
}
?>

<!DOCTYPE html>
<html>
<?php
printEditSubtopic();
function printEditSubtopic()
{
  printHead();
  echo '<body>';
  printTitle();
  printInstructions();
  printSubtopics();
  printButtons();
  echo '</body>';
}

function printSubtopics()
{
  $idTema = $_GET['ID_Tema'];
  $con = mysqli_connect("localhost", "u526597556_dev", "1BLeeAgwq1*isgm&jBJe", "u526597556_kaanbal");
  $statement = mysqli_prepare($con, "SELECT id_subtema, nombre, tiempo_super_sprint FROM subtema WHERE id_tema = ? ORDER BY orden");
  mysqli_stmt_bind_param($statement, "i", $idTema);
  mysqli_stmt_execute($statement);

  mysqli_stmt_store_result($statement);
  mysqli_stmt_bind_result($statement, $id_subtema, $nombre, $tiempo_super_sprint);

  $arregloTemas = array();
  $i = 0;
  //Leemos datos del la leccion habilitadas
  while (mysqli_stmt_fetch($statement)) { //si si existe la leccion
    $arregloTemas[$i]["id_subtema"] = $id_subtema;
    $arregloTemas[$i]["nombre"] = $nombre;
    $arregloTemas[$i]["tiempo_super_sprint"] = $tiempo_super_sprint;
    $i = $i + 1;
  }

  $tamanho = count($arregloTemas);

  for ($i = 0; $i < $tamanho; $i++) {
    //print_r($arregloTemas[$i]["id_tema"]);
    //print_r($arregloTemas[$i]["nombre"]);
    printLections($arregloTemas[$i]["id_subtema"], $arregloTemas[$i]["nombre"], $arregloTemas[$i]["tiempo_super_sprint"]);
  }
}

function printLections($ID_Lection, $LectionName, $sprintTime)
{
  echo '
    <div class="container">
      <div class="row">
        <div class="input-group col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
          <input type="text" class="form-control" id="' . $ID_Lection . '" value="' . $sprintTime . '" />
          <div class="input-group-append">
            <span class="input-group-text">' . $LectionName . '</span>
            <span class="input-group-text">' . $ID_Lection . '</span>
          </div>
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

function printHead()
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
    <link rel="stylesheet" href="../CSSsJSs/bootstrap441.css" />
    <link rel="stylesheet" href="../CSSsJSs/kaanbalEsentials.css" />
    <script src="../CSSsJSs/minAJAX.js"></script>
    <script src="tiempoSuperSprintSubtema2.js"></script>
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
          - Para cambiar el tiempo de <strong>cada pregunta del SUPER sprint</strong>, ubique el <strong>subtema</strong> correspondiente,
           edite el valor y de clic en "Guardar en base de datos".
        </p>
        <p>
          - Recuerde el valor deberá estar en <strong>SEGUNDOS</strong>
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

function printButtons()
{
  echo '
  <div class="container">
    <div class="row">
      <div
        class="input-group input-group-sm col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6"
      >
        <button
          id="guardarEnBBDD"
          type="button"
          class="btn btn-primary btn-sm"
        >
          Guardar en base de datos
        </button>
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

?>

</html>