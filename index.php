<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="shortcut icon" type="image/x-icon" href="Front/CSSsJSs/icons/pyramid.svg" />
    <title>Kaanbal</title>
    <link rel="stylesheet" href="Front/CSSsJSs/bootstrap441.css" />
    <link rel="stylesheet" href="styleIndex.css" />
    <script src="Front/CSSsJSs/minAJAX.js"></script>
    <script src="Front/CSSsJSs/scriptIndex.js"></script>
</head>

<body>
    <?php
    session_start();
    session_destroy();

    imprimirIndex();

    function imprimirIndex()
    {
        imprimirTitulo();
        //imprimirRelleno();
        imprimirForma();
        imprimirRelleno();
        imprimirRelleno();
        imprimirFooter();
    }


    function imprimirTitulo()
    {
        echo '
        <!----------------------------------------------TITULO--------------------------------------------->
        <div class="top">
          <div class="container">
            <div class="row">
              <div class="textCenter col-1 col-sm-1 col-md-1 col-lg-1 col-xl-1"></div>
              <div class="textLeft col-5 col-sm-5 col-md-5 col-lg-5 col-xl-5">
                <p class="titulo">Kaanbal</p>
              </div>
              <div class="textRight col-5 col-sm-5 col-md-5 col-lg-5 col-xl-5">
                <p class="masInfo"></p>
              </div>
              <div class="textCenter col-1 col-sm-1 col-md-1 col-lg-1 col-xl-1"></div>
            </div>
          </div>
        </div>
        <!------------------------------------------------FIN TITULO----------------------------------------------->
        ';
    }

    function imprimirRelleno()
    {
        echo '
        <div class="container">
            <div class="row">
                <div class="textCenter col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                    <p style="color:rgba(0,0,0,0)">.</p>
                </div>
            </div>
        </div>
        ';
    }

    function imprimirForma()
    {
        echo '
        <!----------------------------------------------PORTADA Y BOTONES--------------------------------------------->
        <div class="container">
            <div class="row">
            <div class="textCenter col-2 col-md-2 col-md-1 col-lg-1 col-xl-1"></div>
            <div class="col-8 col-sm-8 col-md-4 col-lg-4 col-xl-4">
                <img class="iconoPrincipal" src="Front/CSSsJSs/icons/quet.svg" />
            </div>
            <div class="textCenter col-2 col-sm-2 col-md-2 col-lg-2 col-xl-2"></div>
            <div class="textCenter col-2 col-sm-2 d-md-none"></div>
            <div id="forma" class="textCenter col-8 col-sm-8 col-md-4 col-lg-4 col-xl-4">
                <p class="slogan">¡Diviértete aprendiendo!</p>
                <p style="color:rgba(0,0,0,0);">.</p>
                <form action="Front/Inicio/asignaturas.php" method="POST">
                <label class="fuenteForma" for="validarUsuario">Usuario</label>
                <input type="email" name="validarUsuario" id="validarUsuario" placeholder="A01169493@itesm.mx" required /><br>

                <label class="fuenteForma" for="validarPassword" id="contrasena">Contraseña</label>
                <input type="password" name="validarPassword" id="validarPassword" required /><br>

                <label class="olvidada" id="contraOlvidada">¿Olvidaste tu contraseña?</label><br>
                <input type="submit" value="Log In" class="boton2">
                <button class="g-recaptcha" data-sitekey="6LdnLvEUAAAAADFTp-wwjA8nP0vkPfusUfbPPja3" data-callback="onSubmit" data-size="invisible" style="display:none"></button>
                </form>
            </div>
            <div id="emailSent" class="textCenter col-8 col-sm-8 col-md-4 col-lg-4 col-xl-4" style="display:none;">
                <p class="fuenteForma" id="emailMessage">
                </p>
            </div>
            <div class="textCenter col-2 col-sm-2 col-md-1 col-lg-1 col-xl-1"></div>
            </div>
        </div>
        ';
    }

    function imprimirFooter()
    {
        echo '
        <div class="foot">
            <div class=" container ">
                <div class=" row text-center">
                    <div class="hidden-xs hidden-sm col-md-3 col-lg-3 col-xl-3 "></div>
                    <div class="textCenter col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <a href="contacto.html"><p class="footSubject"><strong>Contáctanos</strong></p></a>
                    </div>
                    <div class="hidden-xs hidden-sm col-md-3 col-lg-3 col-xl-3"></div>
                </div>
            </div>
        </div>
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
        <script>
            function onSubmit(token) {
                document.getElementById("demo-form").submit();
            }
        </script>
        ';
    }
    ?>



</body>

</html>