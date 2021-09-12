<?php
require "../../../servicios/00DDBBVariables.php";
require "../../../servicios/isTeacher.php";
$teacherID = isTeacher();
require "../../CSSsJSs/mainCSSsJSs.php";
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="shortcut icon" type="image/x-icon" href="../../CSSsJSs/icons/pyramid.svg" />
    <title>Kaanbal</title>
    <link rel="stylesheet" href="../../CSSsJSs/<?= $bootstrap441 ?>" />
    <link rel="stylesheet" href="../../CSSsJSs/<?= $kaanbalEssentials ?>" />
</head>

<body>
    <!--KAANBAL TITULO-->
    <div class="container">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <h1 class="titulo">Kaanbal</h1>
            </div>
        </div>
    </div>

    <!-- -->
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
                <?php
                global $servername, $username, $password, $dbname;
                $arregloIdsAsignaturas = array();
                //Crear la lectura en base de datos
                try {
                    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $stringQuery = 'SELECT id_asignatura FROM asignatura WHERE visible = 1';
                    $stmt = $conn->query($stringQuery);
                    while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
                        array_push($arregloIdsAsignaturas, $row[0]);
                    }
                } catch (PDOException $e) {
                    echo "Error: " . $e->getMessage();
                }
                $conn = null;
                ?>

            </div>
        </div>
    </div>

    <?php
    foreach ($arregloIdsAsignaturas as $idAsignatura) :
    ?>

        <form action="calificaciones.php" id="groupForm" method="POST">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                        <p style="font-size:xx-large;">
                            <?php
                            global $servername, $username, $password, $dbname;
                            //Crear la lectura en base de datos
                            try {
                                $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                                $stringQuery = 'SELECT nombre FROM asignatura WHERE id_asignatura = ' . $idAsignatura . ' ;';
                                $stmt = $conn->query($stringQuery);
                                while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
                                    echo $row[0];
                                }
                            } catch (PDOException $e) {
                                echo "Error: " . $e->getMessage();
                            }
                            $conn = null;
                            ?>
                        </p>
                    </div>
                </div>
                <div class="row">
                    <div class="input-group col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                        <div class="input-group-prepend">
                            <label class="input-group-text" for="grupo">Grupo</label>
                        </div>
                        <label for="grupo" style="display:none;">grupo</label>
                        <select class="custom-select" id="grupo" name="grupo">
                            <option selected disabled value="0">Elegir</option>
                            <?php
                            global $servername, $username, $password, $dbname;
                            //Crear la lectura en base de datos
                            try {
                                $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                                $stringQuery = 'SELECT id_grupo, nombre FROM grupo WHERE id_profesor = ' . $teacherID . ' AND id_asignatura = ' . $idAsignatura . ' ;';
                                $stmt = $conn->query($stringQuery);
                                while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
                                    echo '<option value="' . $row[0] . '">' . $row[1] . '</option>';
                                }
                            } catch (PDOException $e) {
                                echo "Error: " . $e->getMessage();
                            }
                            $conn = null;
                            ?>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="input-group col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                        <div class="input-group-prepend">
                            <label class="input-group-text" for="modalidad">Modalidad</label>
                        </div>
                        <select class="custom-select" id="modalidad" name="modalidad">
                            <option selected disabled value="0">Elegir</option>
                            <option value="PP">Práctica</option>
                            <option value="SP">Sprint</option>
                            <option value="E">Examen</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="input-group col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                        <div class="input-group-prepend">
                            <label class="input-group-text" for="tema">Tema</label>
                        </div>
                        <label for="tema" style="display:none;">Tema</label>
                        <select class="custom-select" id="tema" name="tema">
                            <option selected disabled value="0">Elegir</option>
                            <?php
                            global $servername, $username, $password, $dbname;
                            //Crear la lectura en base de datos
                            try {
                                $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                                $stringQuery = 'SELECT id_tema, nombre FROM tema WHERE id_asignatura = ' . $idAsignatura . ' ORDER BY orden;';
                                $stmt = $conn->query($stringQuery);
                                while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
                                    echo '<option value="' . $row[0] . '">' . $row[1] . '</option>';
                                }
                            } catch (PDOException $e) {
                                echo "Error: " . $e->getMessage();
                            }
                            $conn = null;
                            ?>
                        </select>
                    </div>
                </div>
                <!-- -->
                <div class="row">
                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                        <p style="color: rgba(0, 0, 0, 0);">.</p>
                    </div>
                </div>

                <div class="row">
                    <div class="input-group col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                        <input type="submit" class="btn btn-primary btn-sm" value="Generar reporte">
                    </div>
                </div>
                <!-- -->
                <div class="row">
                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                        <p style="color: rgba(0, 0, 0, 0);">.</p>
                    </div>
                </div>
                <!-- -->
                <div class="row">
                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                        <p style="color: rgba(0, 0, 0, 0);">.</p>
                    </div>
                </div>
                <!-- -->
                <div class="row">
                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                        <p style="color: rgba(0, 0, 0, 0);">.</p>
                    </div>
                </div>
            </div>
        </form>
    <?php endforeach; ?>

    <!-- -->
    <div class="container">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <p style="color: rgba(0, 0, 0, 0);">.</p>
            </div>
        </div>
    </div>

    <!-- -->
    <div class="container">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <p style="color: rgba(0, 0, 0, 0);">.</p>
            </div>
        </div>
    </div>
</body>

</html>