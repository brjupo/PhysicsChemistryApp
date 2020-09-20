<?php
require "../../../Servicios/DDBBVariables.php";
require "../../../Servicios/isAdmin.php";
$adminID = isAdmin();
if ($adminID == "null") {
    header('Location: https://kaanbal.net/');
    exit;
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="shortcut icon" type="image/x-icon" href="../CSSsJSs/icons/pyramid.svg" />
    <title>Kaanbal</title>
    <link rel="stylesheet" href="../CSSsJSs/bootstrap441.css" />
    <link rel="stylesheet" href="../CSSsJSs/styleUploadInfo.css" />
    <script src="scriptEditarPreguntaPorIDByGET.js"></script>
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

    <!--div class="container">
        <div class="row">
            <div class="textCenter col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <p><a href="instrucciones.html">Instrucciones</a></p>
            </div>
        </div>
    </div-->

    <div class="container">
        <div class="row">
            <div class="textCenter col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <p style="color: rgba(0, 0, 0, 0);">.</p>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="textCenter col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                <p>El ID de las preguntas lo puedes observar en la sección de "crear temas, subtemas, lecciones y preguntas" </p>
            </div>
            <div class="input-group input-group-sm col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                <button id="siguientePregunta" type="button" class="btn btn-primary btn-sm">
                    Siguiente pregunta
                </button>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="textCenter col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <p style="color: rgba(0, 0, 0, 0);">.</p>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="input-group input-group-sm col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-sm">
                        ID pregunta
                    </span>
                </div>
                <input id="IDPregunta" type="text" pattern="[0-9.]+" class="form-control" value="<?php echo $_GET["ID_Pregunta"];?>"/>
            </div>
            <div class="input-group input-group-sm col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                <button id="cargarInformacion" type="button" class="btn btn-primary btn-sm">
                    Cargar información
                </button>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="textCenter col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <p style="color: rgba(0, 0, 0, 0);">.</p>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="input-group input-group-sm col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <label for="pregunta">Pregunta</label>
                <div class="input-group mb-3">
                    <textarea id="pregunta" rows="4" cols="150" wrap="soft">
                    </textarea>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="textCenter col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <p style="color: rgba(0, 0, 0, 0);">.</p>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="input-group input-group-sm col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-sm">
                        Respuesta correcta
                    </span>
                </div>
                <input id="respuesta_correcta" type="text" class="form-control" />
            </div>
            <div class="input-group input-group-sm col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-sm">
                        Opción 2
                    </span>
                </div>
                <input id="respuesta2" type="text" class="form-control" />
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="textCenter col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <p style="color: rgba(0, 0, 0, 0);">.</p>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="input-group input-group-sm col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-sm">
                        Opción 3
                    </span>
                </div>
                <input id="respuesta3" type="text" class="form-control" />
            </div>
            <div class="input-group input-group-sm col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-sm">
                        Opción 4
                    </span>
                </div>
                <input id="respuesta4" type="text" class="form-control" />
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="textCenter col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <p style="color: rgba(0, 0, 0, 0);">.</p>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="input-group input-group-sm col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                <div class="input-group-prepend">
                    <label class="input-group-text" for="inputGroupSelect01">Tipo de pregunta</label>
                </div>
                <select class="custom-select" id="tipo">
                    <option selected disabled>Choose...</option>
                    <option value="2">Abierta</option>
                    <option value="1">Opción Múltiple</option>
                </select>
            </div>
            <div class="input-group input-group-sm col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                <button id="guardarEnBBDD" type="button" class="btn btn-primary btn-sm">
                    Guardar en base de datos
                </button>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="textCenter col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <p style="color: rgba(0, 0, 0, 0);">.</p>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="input-group input-group-sm col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <label for="question">Question</label>
                <div class="input-group mb-3">
                    <textarea id="question" rows="4" cols="150" wrap="soft">
                    </textarea>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="textCenter col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <p style="color: rgba(0, 0, 0, 0);">.</p>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="input-group input-group-sm col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-sm">
                        Correct Answer
                    </span>
                </div>
                <input id="correct_answer" type="text" class="form-control" />
            </div>
            <div class="input-group input-group-sm col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-sm">
                        Answer 2
                    </span>
                </div>
                <input id="answer2" type="text" class="form-control" />
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="textCenter col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <p style="color: rgba(0, 0, 0, 0);">.</p>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="input-group input-group-sm col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-sm">
                        Answer 3
                    </span>
                </div>
                <input id="answer3" type="text" class="form-control" />
            </div>
            <div class="input-group input-group-sm col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-sm">
                        Option 4
                    </span>
                </div>
                <input id="answer4" type="text" class="form-control" />
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="textCenter col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <p style="color: rgba(0, 0, 0, 0);">.</p>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="textCenter col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <p>Insertar/actualizar imagen</p>
                <p style="font-size: small;">
                    Solo se permiten imágenes <strong>jpg</strong>
                </p>
                <p style="font-size: small;">
                    <strong>Puede tomar hasta 30 minutos actualizarse la imagen</strong>
                </p>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="textCenter col-12 col-sm-12 col-md-5 col-lg-5 col-xl-5">
                <input id="nuevaImagen" type="file" name="myImage" accept=".jpg" />
            </div>
            <div class="textCenter col-12 col-sm-12 col-md-7 col-lg-7 col-xl-7">
                <img id="imagenPregunta" src="../../../../IMAGENES/sinImagen.jpg" width="100%" />
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
</body>

</html>