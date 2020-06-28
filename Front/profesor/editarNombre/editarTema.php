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
  printEditTopic();
} else {
  echo '<script type="text/javascript">
  alert("Inicie sesión");
  window.location.href="https://kaanbal.net";
  </script>';
}
?>



<?php

function printEditTopic()
{
  printHead();
  echo '<body>';
  printTitle();
  printInstructions();
  printTopics();
  printButtons();
  echo '</body>';  
}

function printTopics(){
  $idAsignatura = $_GET['ID_Asignatura'];;
  $con = mysqli_connect("localhost", "u526597556_dev", "1BLeeAgwq1*isgm&jBJe", "u526597556_kaanbal");
  $statement = mysqli_prepare($con, "SELECT id_tema, nombre FROM tema WHERE id_asignatura = ?");
  mysqli_stmt_bind_param($statement,"i", $idAsignatura);
  mysqli_stmt_execute($statement);

  mysqli_stmt_store_result($statement);
  mysqli_stmt_bind_result($statement, $id_tema, $nombre);

  $arregloTemas = array();
  $i = 0;
  //Leemos datos del la leccion habilitadas
  while (mysqli_stmt_fetch($statement)) { //si si existe la leccion
    $arregloTemas[$i]["id_tema"] = $id_tema;
    $arregloTemas[$i]["nombre"] = $nombre;
    $i = $i + 1;
  }

  $tamanho = count($arregloTemas);

  for ($i = 0; $i < $tamanho; $i++) {
    //print_r($arregloTemas[$i]["id_tema"]);
    //print_r($arregloTemas[$i]["nombre"]);
    printTopic($arregloTemas[$i]["id_tema"],$arregloTemas[$i]["nombre"]);
  }
}

function printTopic($ID_Topic, $topicName){
  echo '
    <div class="container">
      <div class="row">
        <div class="input-group col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
          <div class="input-group-prepend">
            <span class="input-group-text">'.$ID_Topic.'</span>
          </div>
          <input type="text" class="form-control" id="'.$ID_Topic.'" value="'.$topicName.'" />
          <div class="input-group-append">
            <a href="editarSubtema.php?ID_Tema='.$ID_Topic.'">
              <button class="btn btn-outline-secondary" type="button">
                Buscar sus subtemas
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
    <script src="../CSSsJSs/nombreTema3.js"></script>
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
          - Para cambiar el nombre de los <strong>temas</strong>, edite el nombre y de clic en
          "Guardar en base de datos"
        </p>
        <p>
          - Para editar subtemas o lecciones, ubique el <strong>tema</strong>
          correspondiente y de clic en "Buscar sus subtemas"
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

function printButtons(){
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