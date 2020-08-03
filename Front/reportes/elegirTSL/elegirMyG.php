<?php
require "../../../Servicios/DDBBVariables.php";
require "../../../Servicios/isTeacher.php";
$teacherID = isTeacher();
if ($teacherID == "null") {
  header('Location: https://kaanbal.net/');
  exit;
}
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="shortcut icon" type="image/x-icon" href="../../CSSsJSs/icons/pyramid.svg" />
  <title>Kaanbal</title>
  <link rel="stylesheet" href="../../CSSsJSs/bootstrap441.css" />
  <link rel="stylesheet" href="../../CSSsJSs/kaanbalEssentials.css" />
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
  <div class="container">
    <div class="row">
      <div class="input-group col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
        <div class="input-group-prepend">
          <label class="input-group-text" for="grupo">Grupo</label>
        </div>
        <select class="custom-select" id="grupo" name="grupo" form="groupForm">
          <option selected disabled value="0">Elegir</option>';
          <?php
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

          ?>
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
      <div class="input-group col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
        <div class="input-group-prepend">
          <label class="input-group-text" for="modalidad">Modalidad</label>
        </div>
        <select class="custom-select" id="modalidad" name="modalidad" form="groupForm">
          <option selected disabled value="0">Elegir</option>
          <option value="PP">Práctica</option>
          <option value="SP">Sprint</option>
          <option value="E">Examen</option>
          <!--option value="SS">Super Sprint</option-->
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

      <div class="textCenter col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
        <label for="id_leccion">ID Lección</label>
        <input type="text" id="id_leccion" name="id_leccion" class="form-control" form="groupForm" value="<?php echo $_GET["ID_Leccion"];?>" />
      </div>
      <div class="textCenter col-12 col-sm-6 col-md-3 col-lg-3 col-xl-3">
        <label for="desde">Desde [Exclusivo]</label>
        <input type="date" id="desde" name="desde" class="form-control" form="groupForm" />
      </div>
      <div class="textCenter col-12 col-sm-4 col-md-2 col-lg-2 col-xl-2">
        <label for="desde_tiempo">Hora</label>
        <input type="time" value="07:00" id="desde_tiempo" name="desde_tiempo" class="form-control" form="groupForm" />
      </div>
      <div class="textCenter col-12 col-sm-2 col-md-1 col-lg-1 col-xl-1"></div>
      <div class="textCenter col-12 col-sm-6 col-md-3 col-lg-3 col-xl-3">
        <label for="hasta">Hasta [Exclusivo]</label>
        <input type="date" id="hasta" name="hasta" class="form-control" form="groupForm" />
      </div>
      <div class="textCenter col-12 col-sm-4 col-md-2 col-lg-2 col-xl-2">
        <label for="hasta_tiempo">Hora</label>
        <input type="time" value="07:00" id="hasta_tiempo" name="hasta_tiempo" class="form-control" form="groupForm" />
      </div>
      <div class="textCenter col-12 col-sm-2 col-md-1 col-lg-1 col-xl-1"></div>
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
        <form action="oneGroupOneMode.php" id="groupForm" method="POST">
          <input type="submit" class="btn btn-primary btn-sm" value="Generar reporte"><br>
        </form>
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