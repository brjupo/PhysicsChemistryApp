<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="shortcut icon" type="image/x-icon" href="../CSSsJSs/icons/pyramid.svg" />
    <title>Kaanbal</title>
    <link rel="stylesheet" href="../CSSsJSs/bootstrap441.css" />
    <link rel="stylesheet" href="../CSSsJSs/styleUploadOne.css" />
    <script src="../CSSsJSs/scriptUploadOne.js"></script>
    <script src="../CSSsJSs/minAJAX.js"></script>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="text-center col-1 col-sm-1 col-md-1 col-lg-1 col-xl-1"></div>
            <div class="textLeft col-5 col-sm-5 col-md-5 col-lg-5 col-xl-5">
                <p class="titulo" id="titulo">Kaanbal</p>
            </div>
            <div class="textRight col-5 col-sm-5 col-md-5 col-lg-5 col-xl-5"></div>
            <div class="text-center col-1 col-sm-1 col-md-1 col-lg-1 col-xl-1"></div>
        </div>
    </div>



    <div class="container">
        <div class="row">
            <div class="text-center col-1 col-sm-1 col-md-1 col-lg-1 col-xl-1"></div>
            <div class="text-center col-10 col-sm-10 col-md-10 col-lg-10 col-xl-10">
                <label for="correoNuevo">Matrícula a dar de alta. Ejemplo.- A01169493</label>
                <input type="text" id="matricula" name="matricula" maxlength="9" pattern="(A)(0)(?=.*\d).{7}" placeholder="A01169493" required/>
                
                <label for="psw">Por favor, confirme contraseña de super usuario de hoy <?php echo date("Y-m-d") ?></label>
                <input type="password" id="psw" name="psw" required />

            </div>
            <div class="text-center col-1 col-sm-1 col-md-1 col-lg-1 col-xl-1"></div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="text-center col-2 col-sm-2 col-md-5 col-lg-5 col-xl-5"></div>
            <div class="text-center col-8 col-sm-8 col-md-2 col-lg-2 col-xl-2">
                <button class="boton2" id="submit">
                    Subir matrícula
                </button>
            </div>
            <div class="text-center col-2 col-sm-2 col-md-5 col-lg-5 col-xl-5"></div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="text-center col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <p style="color:rgba(0,0,0,0)">.</p>
            </div>
        </div>
        <div class="row">
            <div class="text-center col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <p style="color:rgba(0,0,0,0)">.</p>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-4 col-sm-4 col-md-4 col-lg-4 col-xl-4 ">
                <p class="footSubject">Nosotros</p>
            </div>
            <div class="col-4 col-sm-4 col-md-4 col-lg-4 col-xl-4 ">
                <p class="footSubject">Ayuda</p>
            </div>
            <div class="col-4 col-sm-4 col-md-4 col-lg-4 col-xl-4 ">
                <p class="footSubject">Términos</p>
            </div>
        </div>
    </div>
</body>

</html>