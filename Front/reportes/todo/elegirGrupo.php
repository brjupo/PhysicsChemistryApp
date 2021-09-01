<?php
require "../../../servicios/00DDBBVariables.php";
require "../../../servicios/isTeacher.php";
$teacherID=isTeacher();
require "../../CSSsJSs/mainCSSsJSs.php";
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="shortcut icon" type="image/x-icon" href="../../CSSsJSs/icons/pyramid.svg" />
    <title>Kaanbal</title>
    <link rel="stylesheet" href="../../CSSsJSs/<?=$bootstrap441?>" />
    <link rel="stylesheet" href="../../CSSsJSs/<?=$kaanbalEssentials?>" />
</head>

<body>

    <div class="container">
        <div class="row">
            <div class="col-1 col-sm-1 col-md-1 col-lg-1 col-xl-1"></div>
            <div class="col-5 col-sm-5 col-md-5 col-lg-5 col-xl-5">
                <h1 class="titulo">Kaanbal</h1>
            </div>
            <div class="col-5 col-sm-5 col-md-5 col-lg-5 col-xl-5"></div>
            <div class="col-1 col-sm-1 col-md-1 col-lg-1 col-xl-1"></div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <p style="color: rgba(0, 0, 0, 0);">.</p>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <h3>Examen, Sprint o Práctica</h3>
                <p>
                    - Elija un grupo, la modalidad y el tema. 
                </p>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <p style="color: rgba(0, 0, 0, 0);">.</p>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">

            <div class="input-group col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <div class="input-group-prepend">
                    <label class="input-group-text" for="grupo">Grupo</label>
                </div>
                <label for="grupo" style="display:none;">grupo</label>
                <select class="custom-select" id="grupo" name="grupo" form="groupForm">
                    <option selected disabled value="0">Elegir</option>
                    <?php
                    global $servername, $username, $password, $dbname;
                    //Crear la lectura en base de datos
                    try {
                        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        $stringQuery = 'SELECT id_grupo, nombre FROM grupo WHERE id_profesor = ' . $teacherID . ';';
                        $stmt = $conn->query($stringQuery);
                        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
                            echo '<option value="' . $row[0] . '">' . $row[1] . '</option>';
                        }
                    } catch (PDOException $e) {
                        echo "Error: " . $e->getMessage();
                    }
                    $conn = null;
                    ?>
                </select><br>
            </div>

            <div class="input-group col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <div class="input-group-prepend">
                    <label class="input-group-text" for="modalidad">Modalidad</label>
                </div>
                <select class="custom-select" id="modalidad" name="modalidad" form="groupForm">
                    <option selected disabled value="0">Elegir</option>
                    <option value="PP">Práctica</option>
                    <option value="SP">Sprint</option>
                    <option value="E">Examen</option>
                    <!--option value="SG">Super Sprint</option-->
                    <!--El superint no se rige por cada leccion, se debe hacer otra logica por cada subtema-->
                </select>
            </div>

            <div class="input-group col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <div class="input-group-prepend">
                    <label class="input-group-text" for="tema">Tema</label>
                </div>
                <select class="custom-select" id="tema" name="tema" form="groupForm">
                    <option selected disabled value="0">Elegir</option>
                    <!-- ZONA EN CONSTRUCCION -->
                    <!-- mostrar todos los temas de la asignatura -->
                    <?php
                    global $servername, $username, $password, $dbname;
                    //Crear la lectura en base de datos
                    try {
                        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        $stringQuery = 'SELECT id_tema, nombre FROM tema ORDER BY id_asignatura ASC, nombre ASC;';
                        $stmt = $conn->query($stringQuery);
                        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
                            echo '<option value="' . $row[0] . '">' . $row[1] . '</option>';
                        }
                    } catch (PDOException $e) {
                        echo "Error: " . $e->getMessage();
                    }
                    $conn = null;
                    ?>
                    <!-- TERMINA ZONA EN CONSTRUCCION -->
                </select><br>
            </div>

            <div class="input-group col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <form action="calificaciones.php" id="groupForm" method="POST">
                    <input type="submit" class="btn btn-primary btn-sm" value="Generar reporte"><br>
                </form>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <p style="color: rgba(0, 0, 0, 0);">.</p>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <p style="color: rgba(0, 0, 0, 0); border-top-style:solid;">.</p>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <p style="color: rgba(0, 0, 0, 0);">.</p>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <p style="color: rgba(0, 0, 0, 0);">.</p>
            </div>
        </div>
    </div>
</body>

</html>