<?php
require "../../../servicios/DDBBVariables.php";
require "../../../servicios/isAdmin.php";
?>

<!DOCTYPE html>
<html>

<?php
printEditTopic();
function printEditTopic()
{
  printHead();
  echo '<body>';
  printTitle();
  printInstructions();
  printTopics();
  printNewTopic();
  printButtons();
  echo '</body>';  
}

function printTopics(){
  $idTema = $_GET['ID_Tema'];
  $con = mysqli_connect("localhost", "u526597556_dev", "1BLeeAgwq1*isgm&jBJe", "u526597556_kaanbal");
  $statement = mysqli_prepare($con, "SELECT id_subtema, nombre FROM subtema WHERE id_tema = ? ORDER BY orden");
  mysqli_stmt_bind_param($statement,"i", $idTema);
  mysqli_stmt_execute($statement);

  mysqli_stmt_store_result($statement);
  mysqli_stmt_bind_result($statement, $id_subtema, $nombre);

  $arregloTemas = array();
  $i = 0;
  //Leemos datos del la leccion habilitadas
  while (mysqli_stmt_fetch($statement)) { //si si existe la leccion
    $arregloTemas[$i]["id_subtema"] = $id_subtema;
    $arregloTemas[$i]["nombre"] = $nombre;
    $i = $i + 1;
  }

  $tamanho = count($arregloTemas);

  for ($i = 0; $i < $tamanho; $i++) {
    //print_r($arregloTemas[$i]["id_tema"]);
    //print_r($arregloTemas[$i]["nombre"]);
    printTopic($arregloTemas[$i]["id_subtema"],$arregloTemas[$i]["nombre"]);
  }
}

function printTopic($ID_Subtopic, $subtopicName){
  echo '
    <div class="container">
      <div class="row">
        <div class="input-group col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
          <div class="input-group-prepend">
            <span class="input-group-text">'.$ID_Subtopic.'</span>
          </div>
          <input type="text" class="form-control" id="'.$ID_Subtopic.'" value="'.$subtopicName.'" />
          <div class="input-group-append">
            <a href="buscarLeccion.php?ID_Subtema='.$ID_Subtopic.'">
              <button class="btn btn-outline-secondary" type="button">
                Buscar sus lecciones
              </button>
            </a>
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

function printNewTopic(){
  echo'
  <div class="container" style="border-top: 4px dotted #007bff;">
    <div class="row">
      <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
        <p style="color: rgba(0, 0, 0, 0);">.</p>
      </div>
    </div>
  </div>

  <div class="container">
    <div class="row">
      <div class="input-group col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
        <input
          id="nuevoSubtema"
          type="text"
          class="form-control"
          placeholder="Escribe AQUI el nombre del nuevo subtema"
        />
        <div class="input-group-append">
          <span class="input-group-text">ID Tema = </span>
          <span class="input-group-text" id="id_tema">'.$_GET['ID_Tema'].'</span>
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

function printHead(){
  echo'
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
  </head>
  ';
}
function printTitle(){
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

function printInstructions(){
  echo '
  <div class="container">
    <div class="row">
      <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
        <p>
          - Para crear un nuevo <strong>subtema</strong>, inserte el nombre en la última sección y de clic en
          "Guardar en base de datos"
        </p>
        <p>
          - Para crear lecciones o preguntas, ubique el <strong>subtema</strong>
          correspondiente y de clic en "Buscar sus lecciones"
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


?>

</html>