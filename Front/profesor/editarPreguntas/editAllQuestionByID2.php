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
    echo '
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
            <script src="scriptEditarPreguntaPorID_8.js"></script>
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
                <p><a href="instrucciones.html">Instrucciones</a></p>
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
                <div class="textCenter col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                <p>El ID de las preguntas es:</p>
                <p>Química > Del 1 al 1731</p>
                <p>Física > Del 4601 al 5824</p>
                </div>
                <div
                class="input-group input-group-sm col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6"
                >
                <button
                    id="siguientePregunta"
                    type="button"
                    class="btn btn-primary btn-sm"
                >
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
                <div
                class="input-group input-group-sm col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6"
                >
                <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-sm">
                    ID pregunta
                    </span>
                </div>
                <input
                    id="IDPregunta"
                    type="text"
                    pattern="[0-9.]+"
                    class="form-control"
                />
                </div>
                <div
                class="input-group input-group-sm col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6"
                >
                <button
                    id="cargarInformacion"
                    type="button"
                    class="btn btn-primary btn-sm"
                >
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
                <div
                    class="input-group input-group-sm col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12"
                >
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
                <div
                    class="input-group input-group-sm col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6"
                >
                    <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-sm">
                        Respuesta correcta
                    </span>
                    </div>
                    <input id="respuesta_correcta" type="text" class="form-control"/>
                </div>
                <div
                    class="input-group input-group-sm col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6"
                >
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
                <div
                    class="input-group input-group-sm col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6"
                >
                    <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-sm">
                        Opción 3 
                    </span>
                    </div>
                    <input id="respuesta3" type="text" class="form-control" />
                </div>
                <div
                    class="input-group input-group-sm col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6"
                >
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
                <div
                    class="input-group input-group-sm col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6"
                >
                    <div class="input-group-prepend">
                    <label class="input-group-text" for="inputGroupSelect01"
                        >Tipo de pregunta</label
                    >
                    </div>
                    <select class="custom-select" id="tipo">
                    <option selected disabled>Choose...</option>
                    <option value="2">Abierta</option>
                    <option value="1">Opción Múltiple</option>
                    </select>
                </div>
                <div
                    class="input-group input-group-sm col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6"
                >
                    <button
                    id="guardarEnBBDD"
                    type="button"
                    class="btn btn-primary btn-sm"
                    >
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
                <div
                    class="input-group input-group-sm col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12"
                >
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
                <div
                    class="input-group input-group-sm col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6"
                >
                    <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-sm">
                        Correct Answer
                    </span>
                    </div>
                    <input id="correct_answer" type="text" class="form-control" />
                </div>
                <div
                    class="input-group input-group-sm col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6"
                >
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
                <div
                    class="input-group input-group-sm col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6"
                >
                    <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-sm">
                        Answer 3
                    </span>
                    </div>
                    <input id="answer3" type="text" class="form-control" />
                </div>
                <div
                    class="input-group input-group-sm col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6"
                >
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
                    </div>
                </div>
            </div>

            <div class="container">
                <div class="row">
                    <div class="textCenter col-12 col-sm-12 col-md-5 col-lg-5 col-xl-5">
                        <input id="nuevaImagen" type="file" name="myImage" accept=".jpg" />
                    </div>
                    <div class="textCenter col-12 col-sm-12 col-md-7 col-lg-7 col-xl-7">
                        <img id="imagenPregunta" src="../../imagenes/sinImagen.jpg" width="100%" />
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

            ';
} else {
    echo '<script type="text/javascript">
    alert("Inicie sesión");
    window.location.href="https://kaanbal.net";
    </script>';
}
?>

</html>