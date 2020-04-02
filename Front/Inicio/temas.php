<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="shortcut icon" type="image/x-icon" href="../CSSsJSs/icons/pyramid.svg" />
  <title>Temas</title>
  <link rel="stylesheet" href="../CSSsJSs/bootstrap341.css" />
  <link rel="stylesheet" href="../CSSsJSs/styleTemas.css" />
  <script src="../CSSsJSs/scriptTemas.js"></script>
</head>

<body>

  <?php

  $correo = $_POST["validarUsuario"];
  $password = $_POST["validarPassword"];

  if ($correo == "" or $password == "") {
    echo "<p>ERROR</p>";
  } else {
    echo "<p>MOSTRARE LA PANTALLA</p>";
  }
  ?>




  <!----------------------------------------------TITULO--------------------------------------------->
  <div class="top">
    <div class="container">
      <div class="row titulo">
        <div class="textCenter col-xs-2 col-sm-2 col-md-2 col-lg-1 col-xl-1">
          <img class="iconoPrincipal" src="../CSSsJSs/icons/physics.svg" />
        </div>
        <div class="textCenter col-xs-4 col-sm-4 col-md-4 col-lg-4 col-xl-4">
          <p class="Ciencia fuenteTitulo">Energía y transformación</p>
        </div>
        <div class="textCenter col-xs-2 col-sm-2 col-md-2 col-lg-3 col-xl-3">
          <table class="table">
            <tbody>
              <tr>
                <td width="60%">
                  <img class="iconoDiamantes imgRight" src="../CSSsJSs/icons/diamante.svg" />
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

  <div id="lections">
    <!----------------------------------------------CITA--------------------------------------------->
    <div class="container">
      <div class="row">
        <div class="textCenter col-xs-1 col-sm-2 col-md-3 col-lg-4 col-xl-4"></div>
        <div class="textCenter col-xs-10 col-sm-8 col-md-6 col-lg-4 col-xl-4">
          <p class="cita">
          </p>
          <?php
          $valor = $_POST["tokenA"];
          echo $valor;
          ?>
        </div>
        <div class="textCenter col-xs-1 col-sm-2 col-md-3 col-lg-4 col-xl-4"></div>
      </div>
    </div>
    <!------------------------------------------------FIN CITA----------------------------------------------->

    <!----------------------------------------------TEMAS PRINCIPALES--------------------------------------------->

    <div class="container">
      <div class="row">
        <div class="textCenter col-xs-1 col-sm-1 col-md-2 col-lg-3 col-xl-3"></div>
        <a href="subtemas.html">
          <div class="temaPrincipal1 textCenter col-xs-10 col-sm-10 col-md-8 col-lg-6 col-xl-6">
            <table class="table">
              <tbody>
                <tr>
                  <td width="20%">
                    <img class="icons" src="../CSSsJSs/icons/one.svg" />
                  </td>
                  <td width="10%" class="separadorTemasPrincipales">|</td>
                  <td width="70%" class="tituloTemasPrincipales">
                    Herramientas previas
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </a>
        <div class="textCenter col-xs-1 col-sm-1 col-md-2 col-lg-3 col-xl-3"></div>
      </div>
    </div>

    <div class="container">
      <div class="row">
        <p></p>
      </div>
    </div>

    <div class="container">
      <div class="row">
        <div class="textCenter col-xs-1 col-sm-1 col-md-2 col-lg-3 col-xl-3"></div>
        <a href="subtemas.html">
          <div class="temaPrincipal2 textCenter col-xs-10 col-sm-10 col-md-8 col-lg-6 col-xl-6">
            <table class="table">
              <tbody>
                <tr>
                  <td width="20%">
                    <img class="icons" src="../CSSsJSs/icons/two.svg" />
                  </td>
                  <td width="10%" class="separadorTemasPrincipales">|</td>
                  <td width="70%" class="tituloTemasPrincipales">Vectores</td>
                </tr>
              </tbody>
            </table>
          </div>
        </a>
        <div class="textCenter col-xs-1 col-sm-1 col-md-2 col-lg-3 col-xl-3"></div>
      </div>
    </div>

    <div class="container">
      <div class="row">
        <p></p>
      </div>
    </div>

    <div class="container">
      <div class="row">
        <div class="textCenter col-xs-1 col-sm-1 col-md-2 col-lg-3 col-xl-3"></div>
        <a href="subtemas.html">
          <div class="temaPrincipal3 textCenter col-xs-10 col-sm-10 col-md-8 col-lg-6 col-xl-6">
            <table class="table">
              <tbody>
                <tr>
                  <td width="20%">
                    <img class="icons" src="../CSSsJSs/icons/three.svg" />
                  </td>
                  <td width="10%" class="separadorTemasPrincipales">|</td>
                  <td width="70%" class="tituloTemasPrincipales">
                    Cinemática 1D
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </a>
        <div class="textCenter col-xs-1 col-sm-1 col-md-2 col-lg-3 col-xl-3"></div>
      </div>
    </div>

    <div class="container">
      <div class="row">
        <p></p>
      </div>
    </div>

    <div class="container">
      <div class="row">
        <div class="textCenter col-xs-1 col-sm-1 col-md-2 col-lg-3 col-xl-3"></div>
        <a href="subtemas.html">
          <div class="temaPrincipal4 textCenter col-xs-10 col-sm-10 col-md-8 col-lg-6 col-xl-6">
            <table class="table">
              <tbody>
                <tr>
                  <td width="20%">
                    <img class="icons" src="../CSSsJSs/icons/four.svg" />
                  </td>
                  <td width="10%" class="separadorTemasPrincipales">|</td>
                  <td width="70%" class="tituloTemasPrincipales">
                    Movimiento en 2D
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </a>
        <div class="textCenter col-xs-1 col-sm-1 col-md-2 col-lg-3 col-xl-3"></div>
      </div>
    </div>

    <div class="container">
      <div class="row">
        <p></p>
      </div>
    </div>

    <div class="container">
      <div class="row">
        <div class="textCenter col-xs-1 col-sm-1 col-md-2 col-lg-3 col-xl-3"></div>
        <a href="subtemas.html">
          <div class="temaPrincipal1 textCenter col-xs-10 col-sm-10 col-md-8 col-lg-6 col-xl-6">
            <table class="table">
              <tbody>
                <tr>
                  <td width="20%">
                    <img class="icons" src="../CSSsJSs/icons/five.svg" />
                  </td>
                  <td width="10%" class="separadorTemasPrincipales">|</td>
                  <td width="70%" class="tituloTemasPrincipales">
                    Dinámica y equilibrio traslacional
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </a>
        <div class="textCenter col-xs-1 col-sm-1 col-md-2 col-lg-3 col-xl-3"></div>
      </div>
    </div>

    <div class="container">
      <div class="row">
        <p></p>
      </div>
    </div>

    <div class="container">
      <div class="row">
        <div class="textCenter col-xs-1 col-sm-1 col-md-2 col-lg-3 col-xl-3"></div>
        <a href="subtemas.html">
          <div class="temaPrincipal2 textCenter col-xs-10 col-sm-10 col-md-8 col-lg-6 col-xl-6">
            <table class="table">
              <tbody>
                <tr>
                  <td width="20%">
                    <img class="icons" src="../CSSsJSs/icons/optica.svg" />
                  </td>
                  <td width="10%" class="separadorTemasPrincipales">|</td>
                  <td width="70%" class="tituloTemasPrincipales">
                    Trabajo, energía y potencia
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </a>
        <div class="textCenter col-xs-1 col-sm-1 col-md-2 col-lg-3 col-xl-3"></div>
      </div>
    </div>

    <div class="container">
      <div class="row">
        <p></p>
      </div>
    </div>

    <div class="container">
      <div class="row">
        <div class="textCenter col-xs-1 col-sm-1 col-md-2 col-lg-3 col-xl-3"></div>
        <a href="subtemas.html">
          <div class="temaPrincipal5 textCenter col-xs-10 col-sm-10 col-md-8 col-lg-6 col-xl-6">
            <table class="table">
              <tbody>
                <tr>
                  <td width="20%">
                    <img class="icons" src="../CSSsJSs/icons/nuclear.svg" />
                  </td>
                  <td width="10%" class="separadorTemasPrincipales">|</td>
                  <td width="70%" class="tituloTemasPrincipales">
                    Nuclear
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </a>
        <div class="textCenter col-xs-1 col-sm-1 col-md-2 col-lg-3 col-xl-3"></div>
      </div>
    </div>
  </div>

  <!----------------------------------------------FIN TEMAS PRINCIPALES--------------------------------------------->


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
    <div class="row">
      <p class="relleno">.</p>
    </div>
  </div>
</body>
<footer class="foot">
  <div class=" container ">
    <div class=" row text-center ">
      <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 col-xl-3 ">
        <img class="footIcon" id="botonLecciones" src="../CSSsJSs/icons/lecciones.svg" />
      </div>
      <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 col-xl-2">
        <img class="footIcon" id="botonPerfil" src="../CSSsJSs/icons/usuario.svg" />
      </div>
      <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 col-xl-3 ">
        <img class="footIcon" id="botonAyuda" src="../CSSsJSs/icons/ayuda.svg" />
      </div>
      <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 col-xl-3 ">
        <img class="footIcon" id="botonLogout" src="../CSSsJSs/icons/logout.svg" />
      </div>
    </div>
  </div>
</footer>

</html>