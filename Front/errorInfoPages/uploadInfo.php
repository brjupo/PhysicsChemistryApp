<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="shortcut icon" type="image/x-icon" href="../CSSsJSs/icons/pyramid.svg" />
  <title>Kaanbal</title>
  <link rel="stylesheet" href="../CSSsJSs/bootstrap441.css" />
  <link rel="stylesheet" href="../CSSsJSs/styleUploadInfo.css" />
  <script src="../CSSsJSs/scriptUploadOne.js"></script>
  <script src="../CSSsJSs/minAJAX.js"></script>
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
        <h3>Import CSV file into Mysql using PHP</h3>

        <form class="form-horizontal" action="" method="post" name="frmCSVImport" id="frmCSVImport" enctype="multipart/form-data">
          <div class="input-row">
            <label class="control-label">Choose CSV File</label>
            <input type="file" name="file" id="file" accept=".csv" />
            <button type="submit" id="submit" name="import" class="boton2">
              Import
            </button>
            <br />
          </div>
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
  <div class="foot">
    <div class="container">
      <div class="row">
        <div class="col-4 col-sm-4 col-md-4 col-lg-4 col-xl-4">
          <p class="footSubject">Nosotros</p>
        </div>
        <div class="col-4 col-sm-4 col-md-4 col-lg-4 col-xl-4">
          <p class="footSubject">Ayuda</p>
        </div>
        <div class="col-4 col-sm-4 col-md-4 col-lg-4 col-xl-4">
          <p class="footSubject">Términos</p>
        </div>
      </div>
    </div>
  </div>

  <script type="text/javascript">
    $(document).ready(function() {
      $("#frmCSVImport").on("submit", function() {
        $("#response").attr("class", "");
        $("#response").html("");
        var fileType = ".csv";
        var regex = new RegExp("([a-zA-Z0-9\s_\\.\-:])+(" + fileType + ")$");
        if (!regex.test($("#file").val().toLowerCase())) {
          $("#response").addClass("error");
          $("#response").addClass("display-block");
          $("#response").html(
            "Invalid File. Upload : <b>" + fileType + "</b> Files."
          );
          return false;
        }
        return true;
      });
    });
  </script>

  <?php

  use Phppot\DataSource;

  require_once 'DataSource.php';
  $db = new DataSource();
  $conn = $db->getConnection();

  if (isset($_POST["import"])) {
    $fileName = $_FILES["file"]["tmp_name"];
    if ($_FILES["file"]["size"] > 0) {

      $file = fopen($fileName, "r");

      while (($column = fgetcsv($file, 10000, ",")) !== FALSE) {
        $mail = "";
        if (isset($column[0])) {
          $mail = mysqli_real_escape_string($conn, $column[0]);
        }
        $pswd = "";
        if (isset($column[1])) {
          $pswd = mysqli_real_escape_string($conn, $column[1]);
        }
        /*$password = "";
            if (isset($column[2])) {
                $password = mysqli_real_escape_string($conn, $column[2]);
            }
            $firstName = "";
            if (isset($column[3])) {
                $firstName = mysqli_real_escape_string($conn, $column[3]);
            }
            $lastName = "";
            if (isset($column[4])) {
                $lastName = mysqli_real_escape_string($conn, $column[4]);
            } */

        $sqlInsert = "INSERT into usuario_prueba (mail,pswd)
                   values (?,?)";
        $paramType = "ss";
        $paramArray = array(
          $mail,
          $pswd,
        );
        $insertId = $db->insert($sqlInsert, $paramType, $paramArray);

        if (!empty($insertId)) {
          $type = "success";
          $message = "CSV Data Imported into the Database";
        } else {
          $type = "error";
          $message = "Problem in Importing CSV Data";
        }
      }
    }
  }
  ?>



</body>

</html>