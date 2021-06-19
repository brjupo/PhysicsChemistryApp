<?php
require "../../../servicios/00DDBBVariables.php";
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
  printButtons();
  printScriptTemporal();
  echo '</body>';
}

function printTopics()
{
  $idAsignatura = $_GET['ID_Asignatura'];
  $con = mysqli_connect("localhost", "u526597556_dev", "1BLeeAgwq1*isgm&jBJe", "u526597556_kaanbal");
  $statement = mysqli_prepare($con, "SELECT id_tema, nombre, orden FROM tema WHERE id_asignatura = ? ORDER BY orden");
  mysqli_stmt_bind_param($statement, "i", $idAsignatura);
  mysqli_stmt_execute($statement);

  mysqli_stmt_store_result($statement);
  mysqli_stmt_bind_result($statement, $id_tema, $nombre, $orden);

  $arregloTemas = array();
  $i = 0;
  //Leemos datos del la leccion habilitadas
  while (mysqli_stmt_fetch($statement)) { //si si existe la leccion
    $arregloTemas[$i]["id_tema"] = $id_tema;
    $arregloTemas[$i]["nombre"] = $nombre;
    $arregloTemas[$i]["orden"] = $orden;
    $i = $i + 1;
  }

  $tamanho = count($arregloTemas);

  echo '
      <div class="container">
        <div class="row">
          <ul id="sortable">
      ';

  for ($i = 0; $i < $tamanho; $i++) {
    //print_r($arregloTemas[$i]["id_tema"]);
    //print_r($arregloTemas[$i]["nombre"]);
    printTopic($arregloTemas[$i]["id_tema"], $arregloTemas[$i]["nombre"], $arregloTemas[$i]["orden"]);
  }

  echo '
          </ul>
        </div>
      </div>
  ';
}

function printTopic($ID_Topic, $topicName, $topicOrder)
{
  echo '
        <li id="' . $ID_Topic . '" class="input-group col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
          <input type="text" class="form-control" value="' . $topicName. '" />
          <div class="input-group-append">
            <span class="input-group-text">' . $ID_Topic . '</span>
            <a href="editarSubtema.php?ID_Tema=' . $ID_Topic . '">
              <button class="btn btn-outline-secondary" type="button">
                Buscar sus subtemas
              </button>
            </a>
          </div>
        </li>
  ';
}

function printScriptTemporal()
{
  echo '
  <button id="crearNuevoOrden">Enviar el nuevo orden</button>
  <p>En la app real, en lugar de imprimir, se enviaría por un servicio el nuevo orden nominal [1,2,3,4...] y el respectivo ID del tema</p>
  <p id="nuevoOrden"></p>
  <script>
    //--------------------------------------------------------------
    //---------------------------ON CLIC----------------------------
    //--------------------------------------------------------------
    document.addEventListener("click", function (evt) {
      var obtenerOrdenIds = document.getElementById("crearNuevoOrden");
      targetElement = evt.target; // clicked element

      do {
        if (targetElement == obtenerOrdenIds) {
          enviarElNuevoOrden();
          return;
        }
        // Go up the DOM
        targetElement = targetElement.parentNode;
      } while (targetElement);
    });
    function enviarElNuevoOrden(){
      var children = document.getElementById("sortable").children;
      var idArr = [];
      for (var i = 0; i < children.length; i++) {
        idArr.push(children[i].id);
        j=i+1;
        //En la app real, en lugar de imprimir, se enviaría por un servicio el nuevo orden nominal [1,2,3,4...] y el respectivo ID del tema
        document.getElementById("nuevoOrden").innerHTML = document.getElementById("nuevoOrden").innerHTML + j + ": " + children[i].id + " <br>";
      }
      console.log(idArr);
    }

  </script>
  ';
}


function printTopic2($ID_Topic, $topicName, $topicOrder)
{
  echo '
    <div class="container">
      <div class="row">
        <div class="input-group col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
          <input type="text" class="form-control" id="' . $ID_Topic . '" value="' . $topicOrder . '" />
          <div class="input-group-append">
            <span class="input-group-text">' . $topicName . '</span>
            <span class="input-group-text">' . $ID_Topic . '</span>
            <a href="editarSubtema.php?ID_Tema=' . $ID_Topic . '">
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
    <script src="../CSSsJSs/jquery-1.12.4.js"></script>
    <script src="../CSSsJSs/jquery-ui.js"></script>
    <script src="../CSSsJSs/ordenTema.js"></script>
    <script>
      $(function () {
        $("#sortable").sortable();
        $("#sortable").disableSelection();
      });
    </script>
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
        <h1 class="titulo">Kaanbal ordenar temas</h1>
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
            - Para cambiar de orden los <strong>temas</strong>, solo selecciona y arrastra el tema al orden deseado
          </p>
          <p style="font-size: smaller;">
            SIEMPRE revisar ANTES de guardar.
          </p>
          <p>.</p>
          <p>
            - Para editar orden de subtemas, lecciones o preguntas, seleccione
            el <strong>tema</strong>
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