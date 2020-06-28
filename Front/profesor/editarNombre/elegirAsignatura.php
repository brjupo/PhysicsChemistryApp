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
  printSubjects();
} else {
  echo '<script type="text/javascript">
  alert("Inicie sesión");
  window.location.href="https://kaanbal.net";
  </script>';
}
?>

<?php

function printSubjects()
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
    <script src="../CSSsJSs/elegirAsignatura2.js"></script>
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
          <p>Elija la asignatura a la que desea cambiar los títulos</p>
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
        <div class="input-group col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
          <div class="input-group-prepend">
            <label class="input-group-text" for="topics"
              >Asignaturas</label
            >
          </div>
          <select class="custom-select" id="topics">
            <option selected disabled>Choose...</option>
            ';
  printSubjectOptions();
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

    <div class="container">
      <div class="row">
        <div
          class="input-group input-group-sm col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6"
        >
          <button id="buscarTemas" type="button" class="btn btn-primary btn-sm">
            Buscar temas
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

function printSubjectOptions(){
  $con = mysqli_connect("localhost", "u526597556_dev", "1BLeeAgwq1*isgm&jBJe", "u526597556_kaanbal");
  $statement = mysqli_prepare($con, "SELECT id_asignatura, nombre FROM asignatura");
  mysqli_stmt_execute($statement);
  mysqli_stmt_store_result($statement);
  mysqli_stmt_bind_result($statement, $id_asignatura, $nombre);

  $arregloAsignaturas = array();
  $i = 0;
  //Leemos datos del la leccion habilitadas
  while (mysqli_stmt_fetch($statement)) { //si si existe la leccion
    $arregloAsignaturas[$i]["id_asignatura"] = $id_asignatura;
    $arregloAsignaturas[$i]["nombre"] = $nombre;
    $i = $i + 1;
  }

  $tamanho = count($arregloAsignaturas);

  for ($i = 0; $i < $tamanho; $i++) {
    //print_r($arregloAsignaturas[$i]["id_asignatura"]);
    //print_r($arregloAsignaturas[$i]["nombre"]);
    echo '<option value="'.$arregloAsignaturas[$i]["id_asignatura"].'">'.$arregloAsignaturas[$i]["nombre"].'</option>';
    //<option value="1">Quimica</option>
    //<option value="2">Fisica</option>
  }
}
?>

</body>

</html>