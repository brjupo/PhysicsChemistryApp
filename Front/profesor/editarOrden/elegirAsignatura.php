<?php
require "../../../Servicios/DDBBVariables.php";
require "../../../Servicios/isAdmin.php";
$teacherID = isAdmin();
if ($teacherID == "null") {
  header('Location: https://kaanbal.net/');
  exit;
}
?>

<!DOCTYPE html>
<html>

<?php
printSubjects();
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
          <p>Elija la asignatura</p>
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
  printSubjectOptions();
  echo '
    <div class="container">
      <div class="row">
        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
          <p style="color: rgba(0, 0, 0, 0);">.</p>
        </div>
      </div>
    </div>
    ';
}

function printSubjectOptions()
{
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
    echo '
    <div class="container">
      <div class="row">
        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
          <a href="editarTema.php?ID_Asignatura=' . $arregloAsignaturas[$i]["id_asignatura"] . '">
            <button type="button" class="btn btn-outline-dark">
            ' . $arregloAsignaturas[$i]["nombre"] . '
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
    ';
  }
}
?>

</body>

</html>