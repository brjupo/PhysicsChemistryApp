<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="shortcut icon" type="image/x-icon" href="../CSSsJSs/icons/pyramid.svg" />
  <title>Perfil</title>
  <link rel="stylesheet" href="../CSSsJSs/bootstrap341.css" />
  <link rel="stylesheet" href="../CSSsJSs/styleTemas.css" />
  <script src="../CSSsJSs/scriptPerfil3.js"></script>
  <script src="../CSSsJSs/minAJAX.js"></script>
</head>

<body>
  <!----------------------------------------------TITULO--------------------------------------------->

  <?php
  $matricula = "A01169493";
  $materia = "materia";
  $porcentajeAvance = "53.2%";
  $avatarActual = "avatar.jpg";
  $diamantes = "25,250";

  /////////////////////////////////////////////////////////////////////////////////

  $con = mysqli_connect("localhost", "u526597556_dev", "1BLeeAgwq1*isgm&jBJe", "u526597556_kaanbal");

  session_start();

  $iduser = $_SESSION["id_usuario"];

  $query = "SELECT mail FROM usuario_prueba WHERE id_usuario = $iduser"; 
  $result = mysqli_query($con, $query);
  while ($row = mysqli_fetch_assoc($result)) {
    $mailArray[] = $row;}
  $mail = $mailArray[0]["mail"];//De aqui se obtendra la matricula del usuario

  $matricula = substr($mail, 0, 9);

  //Obtener el porcentaje completado total de la asignatura de práctica general (PG) de la lección:
    $statement = mysqli_prepare($con, "SELECT ((SELECT COUNT(*) FROM puntuacion WHERE id_usuario = [ID DEL USUARIO QUE INICIO SESIÓN] AND id_leccion IN (SELECT id_leccion FROM leccion WHERE id_subtema IN (SELECT id_subtema FROM subtema WHERE id_tema IN (SELECT id_tema FROM tema WHERE id_asignatura = [ID DE LA ASIGNATURA ACTUAL]))) AND tipo = 'PG' * 100) / (SELECT COUNT(*) FROM leccion WHERE id_subtema IN (SELECT id_subtema FROM subtema WHERE id_tema IN (SELECT id_tema FROM tema WHERE id_asignatura = [ID DE LA ASIGNATURA ACTUAL]))))");
    //[ID DEL USUARIO QUE INICIO SESIÓN]
    //[ID DEL USUARIO QUE INICIO SESIÓN]
    //[ID DEL USUARIO QUE INICIO SESIÓN]
    mysqli_stmt_bind_param($statement, "iii", $iduser);
    mysqli_stmt_execute($statement);
    mysqli_stmt_store_result($statement);
    mysqli_stmt_bind_result($statement, $id_asignatura, $nombre, $nivel, $grado_academico, $idioma);

    $arregloAsignaturas = array();

    $i = 0;
    while (mysqli_stmt_fetch($statement)) {
      $arregloAsignaturas[$i]["id_asignatura"] = $id_asignatura;
      $arregloAsignaturas[$i]["nombre"] = $nombre;
      $arregloAsignaturas[$i]["nivel"] = $nivel;
      $arregloAsignaturas[$i]["grado_academico"] = $grado_academico;
      $arregloAsignaturas[$i]["idioma"] = $idioma;
      $i = $i + 1;
    }


////////////////////////////////////////////////////////////////////////////////////

  imprimirVistaPerfil($matricula, $materia, $porcentajeAvance, $avatarActual, $diamantes);

  ?>

  <?php
  function imprimirVistaPerfil($matricula, $materia, $porcentajeAvance, $avatarActual, $diamantes)
  {
    imprimirTop();
    imprimirRelleno();
    imprimirMatricula($matricula);
    imprimirAvanceMateria($materia, $porcentajeAvance);
    imprimirAvatarActual($avatarActual);
    imprimirComboAvatars();
    imprimirDiamantes($diamantes);
    imprimirFooter();
  }
  ?>

  <?php
  function imprimirTop()
  {
    echo '
          <div class="top">
            <div class="container">
              <div class="row titulo">
                <div class="textCenter col-xs-2 col-sm-2 col-md-2 col-lg-1 col-xl-1">
                  <img class="iconoPrincipal" src="../CSSsJSs/icons/physics.svg" />
                </div>
                <div class="textCenter col-xs-4 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                  <p class="Ciencia fuenteTitulo" id="asignatura">' . $_GET['asignatura'] . '</p>
                </div>
                <div class="textCenter col-xs-2 col-sm-2 col-md-2 col-lg-3 col-xl-3">
                  <table class="table">
                    <tbody>
                      <tr>
                        <td width="60%">
                          <img
                            class="iconoDiamantes imgRight"
                            src="../CSSsJSs/icons/diamante.svg"
                          />
                        </td>
                        <td width="40%">
                          <p class="diamantes textLeft">112</p>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                <div class="textCenter col-xs-4 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                  <p class="Materia fuenteTitulo"></p>
                </div>
              </div>
            </div>
          </div>
          <!------------------------------------------------FIN TITULO----------------------------------------------->
          ';
  }

  function imprimirMatricula($matricula)
  {
    echo '
          <div class="container">
            <div class="row">
              <div class="col-xs-1 col-sm-1 col-md-2 col-lg-3 col-xl-3"></div>
              <div class="col-xs-10 col-sm-10 col-md-8 col-lg-6 col-xl-6">
                <p class="tituloTemasPrincipales textCenter" id="matricula">' . $matricula . '</p>
              </div>
              <div class="col-xs-1 col-sm-1 col-md-2 col-lg-3 col-xl-3"></div>
            </div>
          </div>
    ';
  }

  function imprimirAvanceMateria($materia, $porcentajeAvance)
  {
    echo '
          <div class="container">
            <div class="row">
              <div class="col-xs-1 col-sm-1 col-md-2 col-lg-3 col-xl-3"></div>
              <div class="col-xs-10 col-sm-10 col-md-8 col-lg-6 col-xl-6">
                <p class="tituloTemasPrincipales textCenter">
                  ' . $materia . '   ' . $porcentajeAvance . '
                </p>
              </div>
              <div class="col-xs-1 col-sm-1 col-md-2 col-lg-3 col-xl-3"></div>
            </div>
          </div>
    ';
  }


  function imprimirAvatarActual($avatarActual)
  {
    if (empty($avatarActual) || $avatarActual == null) {
      $avatarActual = "avatar.jpg";
    } else if (file_exists("../CSSsJSs/images/" . $avatarActual)) {
      echo '
          <div class="container" id="avatarActual">
            <div class="row">
              <div class="col-xs-1 col-sm-1 col-md-2 col-lg-3 col-xl-3"></div>
              <div class="col-xs-10 col-sm-10 col-md-8 col-lg-6 col-xl-6">
                <img src="../CSSsJSs/images/' . $avatarActual . '" class="avatarImg" id="editarAvatar" />
              </div>
              <div class="col-xs-1 col-sm-1 col-md-2 col-lg-3 col-xl-3"></div>
            </div>
          </div>
      ';
    } else {
      echo "<p>Error al intentar buscar ../CSSsJSs/images/" . $avatarActual . "</p>";
    }
  }

  function imprimirComboAvatars()
  {
    echo '
            <div class="container ocultarOpciones" id="avatarElegir">
              <div class="row">
                <div class="col-xs-4 col-sm-4 col-md-2 col-lg-2 col-xl-2">
                  <img src="../CSSsJSs/images/avatar.jpg" class="avatarOpciones" id="avatar1" />
                </div>
                <div class="col-xs-4 col-sm-4 col-md-2 col-lg-2 col-xl-2">
                  <img src="../CSSsJSs/images/avatar2.jpg" class="avatarOpciones" id="avatar2" />
                </div>
                <div class="col-xs-4 col-sm-4 col-md-2 col-lg-2 col-xl-2">
                  <img src="../CSSsJSs/images/avatar3.jpg" class="avatarOpciones" id="avatar3" />
                </div>
                <div class="col-xs-4 col-sm-4 col-md-2 col-lg-2 col-xl-2">
                  <img src="../CSSsJSs/images/avatar4.jpg" class="avatarOpciones" id="avatar4" />
                </div>
                <div class="col-xs-4 col-sm-4 col-md-2 col-lg-2 col-xl-2">
                  <img src="../CSSsJSs/images/avatar5.png" class="avatarOpciones" id="avatar5" />
                </div>
                <div class="col-xs-4 col-sm-4 col-md-2 col-lg-2 col-xl-2">
                  <img src="../CSSsJSs/images/avatar6.png" class="avatarOpciones" id="avatar6" />
                </div>
              </div>
              <div class="row">
                <div class="col-xs-4 col-sm-4 col-md-2 col-lg-2 col-xl-2">
                  <img src="../CSSsJSs/images/avatar7.jpg" class="avatarOpciones" id="avatar7" />
                </div>
                <div class="col-xs-4 col-sm-4 col-md-2 col-lg-2 col-xl-2">
                  <img src="../CSSsJSs/images/avatar8.jpg" class="avatarOpciones" id="avatar8" />
                </div>
                <div class="col-xs-4 col-sm-4 col-md-2 col-lg-2 col-xl-2">
                  <img src="../CSSsJSs/images/avatar9.jpg" class="avatarOpciones" id="avatar9" />
                </div>
                <div class="col-xs-4 col-sm-4 col-md-2 col-lg-2 col-xl-2">
                  <img src="../CSSsJSs/images/avatar10.jpg" class="avatarOpciones" id="avatar10" />
                </div>
                <div class="col-xs-4 col-sm-4 col-md-2 col-lg-2 col-xl-2">
                  <img src="../CSSsJSs/images/avatar11.jpg" class="avatarOpciones" id="avatar11" />
                </div>
                <div class="col-xs-4 col-sm-4 col-md-2 col-lg-2 col-xl-2">
                  <img src="../CSSsJSs/images/avatar12.png" class="avatarOpciones" id="avatar12" />
                </div>
              </div>
              <div class="row">
                <button type="button" class="btn btn-success" id="guardarAvatar">
                  Guardar
                </button>
              </div>
            </div>    
    ';
  }

  function imprimirDiamantes($diamantes)
  {
    echo '
          <div class="container">
            <div class="row">
              <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 col-xl-2"></div>
              <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                <img class="icons imgRight" src="../CSSsJSs/icons/diamante.svg" />
              </div>
              <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                <p class="tituloTemasPrincipales textLeft">' . $diamantes . '</p>
              </div>
              <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 col-xl-2"></div>
            </div>
          </div>
    ';
  }

  function imprimirRelleno()
  {
    echo '
          <div class="container">
            <div class="row">
              <p class="relleno">.</p>
            </div>
            <div class="row">
              <p class="relleno">.</p>
            </div>
          </div>
    ';
  }
  function imprimirFooter()
  {
    echo '
        <div class="foot">
          <div class="container">
            <div class="row text-center">
              <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 col-xl-3">
                <img class="footIcon" id="botonLecciones" src="../CSSsJSs/icons/lecciones.svg" />
              </div>
              <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 col-xl-3 ">
                <img class="footIcon" id="botonPerfil" src="../CSSsJSs/icons/usuario.svg" />
              </div>
              <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 col-xl-3">
                <img class="footIcon" id="botonAyuda" src="../CSSsJSs/icons/ayuda.svg" />
              </div>
              <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 col-xl-3">
                <img class="footIcon" id="botonLogout" src="../CSSsJSs/icons/logout.svg" />
              </div>
            </div>
          </div>
        </div>
    ';
  }

  ?>



  <!----------------------------------------------FIN PERFIL--------------------------------------------->

  <div class="container">
    <div class="row">
      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12"></div>
      <div class="col-xs-11 col-sm-11 col-md-11 col-lg-11 col-xl-11"></div>
      <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10 col-xl-10"></div>
      <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9 col-xl-9"></div>
      <div class="col-xs-8 col-sm-9 col-md-8 col-lg-8 col-xl-8"></div>
      <div class="col-xs-7 col-sm-7 col-md-7 col-lg-7 col-xl-7"></div>
      <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 col-xl-6"></div>
      <div class="col-xs-5 col-sm-5 col-md-5 col-lg-5 col-xl-5"></div>
      <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 col-xl-4"></div>
      <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 col-xl-3"></div>
      <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 col-xl-2"></div>
      <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1 col-xl-1"></div>
    </div>
  </div>

</body>


</html>