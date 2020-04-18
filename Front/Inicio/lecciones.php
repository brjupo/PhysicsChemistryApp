<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="shortcut icon" type="image/x-icon" href="../CSSsJSs/icons/pyramid.svg" />
  <title>Lecciones</title>
  <link rel="stylesheet" href="../CSSsJSs/bootstrap341.css" />
  <link rel="stylesheet" href="../CSSsJSs/styleLecciones.css" />
  <script src="../CSSsJSs/scriptLecciones.js"></script>
</head>

<body>
  <?php








  function imprimirPaginaLecciones($arregloLecciones)
  {
    imprimirTitulo();
    imprimirSiempreAparece();
    imprimirSubtemas($arregloLecciones);

    imprimirRelleno();
    imprimirFooter();
  }

  function imprimirLecciones($arregloLecciones)
  {
    $tamanho = count($arregloLecciones);
    for ($i = 0; $i < $tamanho; $i++) {
      imprimirLeccion($i + 1, $arregloLecciones[$i]["nombre"]);
    }
  }


  function imprimirTitulo()
  {
    echo '
    <!----------------------------------------------TITULO--------------------------------------------->
    <div class="top">
      <div class="container">
        <div class="row titulo">
          <div class="textCenter col-xs-1 col-sm-1 col-md-1 col-lg-1 col-xl-1">
            <a href="temas.php"><img class="iconoBack" src="../CSSsJSs/icons/FlechaIzq.svg" /></a>
          </div>
          <div class="textCenter col-xs-11 col-sm-11 col-md-11 col-lg-11 col-xl-11">
            <p class="Materia fuenteTitulo">Notación científica</p>
          </div>
        </div>
      </div>
    </div>
    <!------------------------------------------------FIN TITULO----------------------------------------------->

    <div class="container ">
      <div class="row">
        <p class="relleno">.</p>
      </div>
      <div class="row">
        <p class="relleno">.</p>
      </div>
    </div>
  ';
  }


  function imprimirSiempreAparece()
  {
    echo '  
      <!----------------------------------------------SUBTEMAS--------------------------------------------->
      <div class="container">
        <div id="seccion0" class="row">
          <div class="textCenter col-xs-0 col-sm-0 col-md-1 col-lg-2 col-xl-2"></div>
          <div class="temaPrincipal1 textCenter col-xs-12 col-sm-12 col-md-10 col-lg-8 col-xl-8">
            <table class="table">
              <tbody>
                <tr>
                  <td width="6%">
                    <img class="../CSSsJSs/iconsNumber" src="../CSSsJSs/icons/one.svg" />
                  </td>
                  <td width="58%" class="tituloTemasPrincipales">
                    Identificar triángulos rectángulos
                  </td>
                  <!--td width="5%" rowspan="2" class="separadorTemasPrincipales">|</td-->

                  <td width="12%">
                    <a href="preguntas/preguntaSprint.html"><img class="iconsActive" src="../CSSsJSs/icons/lecciones.svg" /></a>
                  </td>
                  <td width="12%">
                    <img class="icons" src="../CSSsJSs/icons/run.svg" />
                  </td>
                  <td width="12%">
                    <img class="icons" src="../CSSsJSs/icons/FlechaIzq.svg" />
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="textCenter col-xs-0 col-sm-0 col-md-1 col-lg-2 col-xl-2"></div>
        </div>
      </div>

      <div class="container">
        <div class="row">
          <p></p>
        </div>
      </div>
  ';
  }

  function imprimirLeccion($numeroLeccion, $nombreLeccion)
  {
    echo '
      <div class="container">
        <div id="seccion' . $numeroLeccion . '" class="row">
          <div class="textCenter col-xs-0 col-sm-0 col-md-1 col-lg-2 col-xl-2"></div>
          <div class="temaPrincipal1 textCenter col-xs-12 col-sm-12 col-md-10 col-lg-8 col-xl-8">
            <table class="table">
              <tbody>
                <tr>
                  <td width="6%">
                    <img class="../CSSsJSs/iconsNumber" src="../CSSsJSs/icons/' . $numeroLeccion . '.svg" />
                  </td>
                  <td width="58%" class="tituloTemasPrincipales">
                  ' . $nombreLeccion . '
                  </td>
                  <!--td width="5%" rowspan="2" class="separadorTemasPrincipales">|</td-->

                  <td width="12%">
                    <a href="preguntas/preguntaSprint.html"><img class="iconsActive" src="../CSSsJSs/icons/lecciones.svg" /></a>
                  </td>
                  <td width="12%">
                    <img class="icons" src="../CSSsJSs/icons/run.svg" />
                  </td>
                  <td width="12%">
                    <img class="icons" src="../CSSsJSs/icons/FlechaIzq.svg" />
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="textCenter col-xs-0 col-sm-0 col-md-1 col-lg-2 col-xl-2"></div>
        </div>
      </div>

      <div class="container">
        <div class="row">
          <p></p>
        </div>
      </div>
  ';
  }

  function imprimirRelleno()
  {
    echo '
      <div class="container ">
        <div class="row">
          <p class="relleno">.</p>
        </div>
        <div class="row">
          <p class="relleno">.</p>
        </div>
        <div class="row">
          <p class="relleno">.</p>
        </div>
      </div>
    ';
  }

  ?>
</body>

</html>