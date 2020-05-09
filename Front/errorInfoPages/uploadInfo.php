<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="shortcut icon" type="image/x-icon" href="../CSSsJSs/icons/pyramid.svg" />
  <title>Kaanbal</title>
  <link rel="stylesheet" href="../CSSsJSs/bootstrap441.css" />
  <link rel="stylesheet" href="../CSSsJSs/styleUploadInfo.css" />
  <!--script src="../CSSsJSs/scriptUploadOne.js"></script-->
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



  <div class="container">
    <div class="row">
      <form class="form-horizontal" action="../../Servicios/subirUsuarios.php" method="post" name="upload_excel" enctype="multipart/form-data">
        <fieldset>
          <!-- Form Name -->
          <legend>Form Name</legend>
          <!-- File Button -->
          <div class="form-group">
            <label class="col-md-12 control-label" for="filebutton">Select File</label>
            <div class="col-md-12">
              <input type="file" name="file" id="file" class="input-large">
            </div>
          </div>
          <!-- Button -->
          <div class="form-group">
            <label class="col-md-12 control-label" for="singlebutton">Import data</label>
            <div class="col-md-12">
              <button type="submit" id="submit" name="Import" class="btn btn-primary button-loading" data-loading-text="Loading...">Import</button>
            </div>
          </div>
        </fieldset>
      </form>
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


</body>

</html>