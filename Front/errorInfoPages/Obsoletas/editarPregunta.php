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
            <link rel="stylesheet" href="../CSSsJSs/styleUploadInfo.css" />
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
                <p><a href="editAllQuestion.php">Renovamos la página, lee las instrucciones ANTES DE INICIAR</a></p>
            </div>
            </div>
            </div>
            </body>
            ';
  }else{
    echo '<script type="text/javascript">
    alert("Inicie sesión");
    window.location.href="https://kaanbal.net";
    </script>';
  }
    ?>

</html>