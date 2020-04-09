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
  //////////////////////////////////////////////////////
  session_start();
  session_create_id($id_session);
  echo'<script type="text/javascript">
        alert("'.$_SESSION["mail"].'");
        </script>';
  if($_SESSION["mail"] =! "1")
  {imprimirTemas();
  }
  else{
  ////////////////////
  $con = mysqli_connect("localhost", "u526597556_dev", "1BLeeAgwq1*isgm&jBJe", "u526597556_kaanbal");	
    
    $correo = $_POST["validarUsuario"];
    $password = $_POST["validarPassword"];
    
    //Validamos que los campos correo y password no lleguen vacios
    if($correo == "" OR $password == ""){
        echo'<script type="text/javascript">
            alert("Ingresa usuario y/o contraseña");
            window.location.href="https://kaanbal.net";
            </script>';
    }
    else{
    
        //Consultar si existe usuario en tabla alumnos
        $statement = mysqli_prepare($con, "SELECT * FROM usuario_prueba WHERE mail = ? AND pswd = ?");
        mysqli_stmt_bind_param($statement, "ss", $correo, $password);
        mysqli_stmt_execute($statement);
    
        mysqli_stmt_store_result($statement);
        mysqli_stmt_bind_result($statement, $id_usuario, $mail, $pswd, $tokenA, $tokenSesion, $idioma);
    
        
      
        //Leemos datos del usuario
        while(mysqli_stmt_fetch($statement)){//si si existe el usuario
            $temp_id_usuario = $id_usuario;
            $temp_mail= $mail;            
            $temp_pswd = $pswd;
            $temp_tokenA = $tokenA;
            $temp_tokenSesion = $tokenSesion;
            $temp_idioma= $idioma;            
            //$response["token"] = $token;
            //$response["token_a"] = $token_a;
            //$response["tokenp"] = $tokenp;
            //$response["tokenpp"] = $tokenpp;
            //$response["flag"] = $flag;
        }

        echo'<script type="text/javascript">
        alert("'.$id_usuario.$mail.$pswd.$tokenA.$tokenSesion.$idioma.'");
        </script>';
    
        //Si el usuario EXISTE despliega el menú de los temas
        if($temp_id_usuario){
            //Se inicia sesión del usuario 
            //session_start();
            //Creamos token de sesión
            $rand = bin2hex(random_bytes(5));
            //Registrar token de sesion en BD
            $sql = "UPDATE usuario_prueba SET tokenSesion='$rand' WHERE mail = '$correo'";
            mysqli_query($con,$sql);
            //Aactualizamos variables de sesión
            $_SESSION["id_usuario"] = $temp_id_usuario;
            $_SESSION["mail"] = $temp_mail;
            $_SESSION["pswd"] = $temp_pswd;
            $_SESSION["tokenA"] = $temp_tokenA;
            $_SESSION["tokenSesion"] = $rand;
            $_SESSION["idioma"] = $temp_idioma;
            //Imprimimos pantalla de temas
            imprimirTemas();
        }

        //Si el usuario NO EXISTE mensaje de error y retorna a inicio
        else{
        echo'<script type="text/javascript">
            alert("Usuario y/o contraseña incorrectos");
            window.location.href="https://kaanbal.net";
            </script>';
        }
    }
  }

  function imprimirTemas()
  {
    echo '
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
        </div>
        <div class="textCenter col-xs-1 col-sm-2 col-md-3 col-lg-4 col-xl-4"></div>
      </div>
    </div>
    <!------------------------------------------------FIN CITA----------------------------------------------->

    <!----------------------------------------------TEMAS PRINCIPALES--------------------------------------------->

    <div class="container">
      <div class="row">
        <div class="textCenter col-xs-1 col-sm-1 col-md-2 col-lg-3 col-xl-3"></div>
        <a href="subtemas.php">
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
        <a href="subtemas.php">
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
        <a href="subtemas.php">
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
        <a href="subtemas.php">
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
        <a href="subtemas.php">
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
        <a href="subtemas.php">
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
        <a href="subtemas.php">
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
  ';
  }
  ?>
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