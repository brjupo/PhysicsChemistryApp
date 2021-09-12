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
    $i = 0; //contador por temas del POST, form y HTML. Para enviar de manera correcta la info.
    foreach ($arregloIdsAsignaturas as $idAsignatura) :
        $i++;
    ?>

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
                        <label class="input-group-text" for="grupo<?= $i ?>">Grupo</label>
                    </div>
                    <label for="grupo<?= $i ?>" style="display:none;">grupo</label>
                    <select class="custom-select" id="grupo<?= $i ?>" name="grupo<?= $i ?>" form="groupForm<?= $i ?>">
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
                        <label class="input-group-text" for="modalidad<?= $i ?>">Modalidad</label>
                    </div>
                    <select class="custom-select" id="modalidad<?= $i ?>" name="modalidad<?= $i ?>" form="groupForm<?= $i ?>">
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
                        <label class="input-group-text" for="tema<?= $i ?>">Tema</label>
                    </div>
                    <label for="tema<?= $i ?>" style="display:none;">Tema</label>
                    <select class="custom-select" id="tema<?= $i ?>" name="tema<?= $i ?>" form="groupForm<?= $i ?>">
                        <option selected disabled value="0">Elegir</option>
                        <?php
                        global $servername, $username, $password, $dbname;
                        //Crear la lectura en base de datos
                        try {
                            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                            $stringQuery = 'SELECT id_tema, nombre FROM tema WHERE id_asignatura = ' . $idAsignatura . ' ;';
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
                    <form action="calificaciones.php" id="groupForm<?= $i ?>" method="POST">
                        <input type="submit" class="btn btn-primary btn-sm" value="Generar reporte">
                    </form>
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