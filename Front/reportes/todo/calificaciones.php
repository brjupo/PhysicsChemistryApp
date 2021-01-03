<?php
require "../../../servicios/00DDBBVariables.php";
require "../../../servicios/isTeacher.php";
$teacherID = isTeacher();
if (!isset($_POST["grupo"]) && !isset($_POST["modalidad"])) {
    echo '<p>';
    echo $_POST["grupo"];
    echo '<br>';
    echo $_POST["modalidad"];
    echo '</p>';
}
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
    <script src="../TableCSVExporter5.js"></script>
</head>

<body>
    <?php
    $id_grupo = $_POST["grupo"];
    $tipo = $_POST["modalidad"];
    ?>
    <style>
        table {
            border-collapse: separate !important;
            /*white-space: nowrap !important;*/
        }

        td {
            text-align: center;
        }
    </style>
    <div class="container">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12"></div>
            <div class="col-11 col-sm-11 col-md-11 col-lg-11 col-xl-11"></div>
            <div class="col-10 col-sm-10 col-md-10 col-lg-10 col-xl-10"></div>
            <div class="col-9 col-sm-9 col-md-9 col-lg-9 col-xl-9"></div>
            <div class="col-8 col-sm-8 col-md-8 col-lg-8 col-xl-8"></div>
            <div class="col-7 col-sm-7 col-md-7 col-lg-7 col-xl-7"></div>
            <div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6"></div>
            <div class="col-5 col-sm-5 col-md-5 col-lg-5 col-xl-5"></div>
            <div class="col-4 col-sm-4 col-md-4 col-lg-4 col-xl-4"></div>
            <div class="col-3 col-sm-3 col-md-3 col-lg-3 col-xl-3"></div>
            <div class="col-2 col-sm-2 col-md-2 col-lg-2 col-xl-2"></div>
            <div class="col-1 col-sm-1 col-md-1 col-lg-1 col-xl-1"></div>
        </div>
    </div>
    <!--+++++++++++++++++++++++++++++++++++ Logo Kaanbal ++++++++++++++++++++++++++++++++++++++++++++++++++++++-->
    <div class="container">
        <div class="row">
            <div class="textCenter col-1 col-sm-1 col-md-1 col-lg-1 col-xl-1"></div>
            <div class="textLeft col-5 col-sm-5 col-md-5 col-lg-5 col-xl-5">
                <p class="titulo">Kaanbal</p>
            </div>
            <div class="textCenter col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6"></div>
        </div>
    </div>

    <!--+++++++++++++++++++++++++++++++++++ CABECERA [Asignatura, Profesor, Grupo y Modalidad] +++++++++++++++++++++++++++++++++++++-->
    <?php
    //Crear la lectura en base de datos
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stringQuery = "SELECT DISTINCT a.nombre, u.mail, g.nombre, pu.tipo 
        FROM asignatura a JOIN grupo g JOIN profesor prof JOIN usuario_prueba u 
        JOIN puntuacion pu ON g.id_asignatura = a.id_asignatura AND g.id_profesor = prof.id_profesor 
        AND prof.id_usuario = u.id_usuario WHERE g.id_grupo = " . $id_grupo .
            " AND pu.tipo = '" . $tipo . "';";
        $stmt = $conn->query($stringQuery);
        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            //row [0] -> Materia, mail, grupo, modalidad
            $materia = $row[0];
            $correoProfesor = $row[1];
            $grupo = $row[2];
            $modalidad = $row[3];
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    $conn = null;
    ?>
    <div class="container">
        <div class="row">
            <div class="col-8 col-sm-8 col-md-8 col-lg-8 col-xl-8">
                <table style="width:100%">
                    <tbody>
                        <tr class="table-info">
                            <td>Asignatura</td>
                            <td><?php echo $materia; ?></td>
                        </tr>
                        <tr class="table-light">
                            <td>Profesor</td>
                            <td><?php echo $correoProfesor; ?></td>
                        </tr>
                        <tr class="table-info">
                            <td>Grupo</td>
                            <td><?php echo $grupo; ?></td>
                        </tr>
                        <tr class="table-light">
                            <td>Modalidad</td>
                            <td>
                                <?php
                                if ($modalidad == "PP") {
                                    $modalidad = "Práctica";
                                }
                                if ($modalidad == "SP") {
                                    $modalidad = "Sprint";
                                }
                                if ($modalidad == "SG") {
                                    $modalidad = "Super Sprint";
                                }
                                if ($modalidad == "E") {
                                    $modalidad = "Examen";
                                }
                                echo $modalidad;
                                ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-4 col-sm-4 col-md-4 col-lg-4 col-xl-4"></div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <p style="color:white">.</p>
            </div>
        </div>
    </div>

    <!--+++++++++++++++++++++++++++++++++++ Temas, Subtemas y Lecciones +++++++++++++++++++++++++++++++++++++-->
    <!--OBTENER EL ID DE ASIGNATURA DEL GRUPO -->
    <div class="container">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <?php
            $id_asignatura = "0";
            //Crear la lectura en base de datos
            try {
                $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $stringQuery = "SELECT id_asignatura FROM grupo WHERE id_grupo = " . $id_grupo . " LIMIT 1";
                $stmt = $conn->query($stringQuery);
                while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
                    $id_asignatura = $row[0];
                }
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
            $conn = null;
            ?>
        </div>
    </div>
    <!--OBTENER LA LISTA DE TEMAS EN ORDEN, DE LA ASIGNATURA-->
    <div class="container">
        <div class="row">
            <?php
            $temas = array();
            $temas["nombre"] = array();
            $temas["id"] = array();
            //Crear la lectura en base de datos
            try {
                $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $stringQuery = "SELECT nombre, id_tema FROM tema WHERE id_asignatura = " . $id_asignatura . " ORDER BY orden";
                $stmt = $conn->query($stringQuery);
                while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
                    array_push($temas["nombre"], $row[0]);
                    array_push($temas["id"], $row[1]);
                }
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
            $conn = null;
            ?>
        </div>
    </div>
    <!--OBTENER LA LISTA DE SUBTEMAS EN ORDEN, DE TODOS LOS TEMAS-->
    <div class="container">
        <div class="row">
            <?php
            $subtemas = array();
            $subtemas["nombre"] = array();
            $subtemas["id"] = array();
            $subtemas["tema"] = array();
            //Recorreremos todos los temas, y guardaremos en subtemas[nombre] el nombre de TODOS los subtemas por orden de usuario
            for ($i = 0; $i < count($temas["id"]); $i++) {
                //Crear la lectura en base de datos
                try {
                    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $stringQuery = "SELECT nombre, id_subtema FROM subtema WHERE id_tema = " . $temas["id"][$i] . " ORDER BY orden";
                    $stmt = $conn->query($stringQuery);
                    while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
                        array_push($subtemas["tema"], $temas["nombre"][$i]);
                        array_push($subtemas["nombre"], $row[0]);
                        array_push($subtemas["id"], $row[1]);
                    }
                } catch (PDOException $e) {
                    echo "Error: " . $e->getMessage();
                }
                $conn = null;
            }

            ?>
        </div>
    </div>

    <!--OBTENER LA LISTA DE LECCIONES EN ORDEN, DE TODOS LOS SUBTEMAS-->
    <div class="container">
        <div class="row">
            <?php
            $lecciones = array();
            $lecciones["nombre"] = array();
            $lecciones["id"] = array();
            $lecciones["totalPreguntas"] = array();
            $lecciones["tema"] = array();
            $lecciones["subtema"] = array();
            //Recorreremos todos los subtemas, y guardaremos en leccion[nombre] el nombre de TODOS los subtemas por orden de usuario
            for ($j = 0; $j < count($subtemas["id"]); $j++) {
                //Crear la lectura en base de datos
                try {
                    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $stringQuery = "SELECT nombre, id_leccion FROM leccion WHERE id_subtema = " . $subtemas["id"][$j] . " ORDER BY orden";
                    $stmt = $conn->query($stringQuery);
                    while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
                        array_push($lecciones["tema"], $subtemas["tema"][$j]);
                        array_push($lecciones["subtema"], $subtemas["nombre"][$j]);
                        array_push($lecciones["nombre"], $row[0]);
                        array_push($lecciones["id"], $row[1]);
                    }
                } catch (PDOException $e) {
                    echo "Error: " . $e->getMessage();
                }
                $conn = null;
            }
            //SELECT COUNT(id_leccion) FROM pregunta WHERE id_leccion = 1 
            ?>
        </div>
    </div>

    <!--++++++++++IMPRIMIR SECCION PARA DESCARGAR EL ARCHIVO+++++++++++++++-->
    <div class="container">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <p style="color:white">.</p>
            </div>
        </div>
        <div class="row">
            <div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                <p>Espera a que el reporte termine de crearse para descargarlo</p>
            </div>
            <div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                <button id="btnExportToCsv" type="button" class="btn btn-primary" disabled>Export to CSV</button>
            </div>
        </div>
        <div class="row">
            <div class="input-group input-group-sm col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <?php
                date_default_timezone_set("America/Mexico_City");
                $fileName = $modalidad . "_" . $materia . "_" . $grupo . "_" . date("l jS \of F Y");
                ?>
                <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-sm">File name:</span>
                </div>
                <input type="text" id="fileName" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" value="<?php echo $fileName; ?>">
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <p style="color:white">.</p>
            </div>
        </div>
    </div>



    <!--IMRPIMIR LA LISTA DE LECCIONES, SUBTEMA Y TEMAS-->
    <div class="container">
        <div class="row">
            <table id="dataTable" class="table table-striped">
                <tbody>
                    <tr>
                        <td style="color:rgba(50,50,255,1)">Grupo | Tipo</td>
                        <td style="color:rgba(50,50,255,1)"><?php echo $grupo . " | " ?></td>
                        <td style="color:rgba(50,50,255,1)"><?php echo $modalidad; ?></td>
                        <?php
                        //Recorreremos todos los subtemas, y guardaremos en leccion[nombre] el nombre de TODOS los subtemas por orden de usuario
                        for ($k = 0; $k < count($lecciones["id"]); $k++) {
                            echo '<td>' . $lecciones["tema"][$k] . '</td>';
                        } ?>
                    </tr>
                    <tr>
                        <td style="color:rgba(50,50,255,1)">Fecha y Hora</td>
                        <td style="color:rgba(50,50,255,1)"><?php echo date("l jS \of F Y"); ?></td>
                        <td style="color:rgba(50,50,255,1)"><?php echo date("H:m:s"); ?></td>
                        <?php
                        for ($k = 0; $k < count($lecciones["id"]); $k++) {
                            echo '<td>' . $lecciones["subtema"][$k] . '</td>';
                        }
                        ?>
                    </tr>
                    <tr>
                        <td style="font-weight:600">Número de lista</td>
                        <td style="font-weight:600">Primer nombre</td>
                        <td style="font-weight:600">Diamantes</td>
                        <?php
                        //Este for lo aprovecharemos para obtener el total de preguntas de cada leccion
                        //Ademas de imprimir las lecciones en la tabla
                        for ($k = 0; $k < count($lecciones["id"]); $k++) {
                            echo '<td>' . $lecciones["nombre"][$k] . '</td>';
                            //Crear la lectura en base de datos
                            try {
                                $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                                $stringQuery = "SELECT COUNT(id_leccion) FROM pregunta WHERE id_leccion = " . $lecciones["id"][$k];
                                $stmt = $conn->query($stringQuery);
                                while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
                                    array_push($lecciones["totalPreguntas"], $row[0]);
                                }
                            } catch (PDOException $e) {
                                echo "Error: " . $e->getMessage();
                            }
                            $conn = null;
                        }

                        ?>
                    </tr>

                    <?php
                    //--------------AQUI OBTIENES TODOS LOS ALUMNOS DEL GRUPO
                    $alumnos = array();
                    //$alumnos["matricula"] = array();
                    $alumnos["numeroLista"] = array();
                    $alumnos["primerNombre"] = array();
                    $alumnos["id"] = array();
                    $alumnos["diamantes"] = array();
                    //Crear la lectura en base de datos
                    try {
                        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        $stringQuery = "SELECT 
                        DISTINCT alumno.numero_lista, alumno.id_nombre, alumno_grupo.id_alumno 
                        FROM alumno_grupo INNER JOIN alumno ON alumno.id_alumno = alumno_grupo.id_alumno 
                        WHERE alumno_grupo.id_grupo = " . $id_grupo. ' ORDER BY alumno.numero_lista; ';
                        $stmt = $conn->query($stringQuery);
                        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
                            array_push($alumnos["numeroLista"], $row[0]);
                            array_push($alumnos["primerNombre"], $row[1]);
                            array_push($alumnos["id"], $row[2]);
                            array_push($alumnos["diamantes"], 0);
                        }
                    } catch (PDOException $e) {
                        echo "Error: " . $e->getMessage();
                    }
                    $conn = null;

                    //--------------AQUI obtienes los diamantes de los alumnos del grupo
                    //Crear la lectura en base de datos
                    try {
                        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        $stringQuery = "SELECT a.id_alumno, SUM(p.puntuacion) AS 'diamantes' FROM puntuacion p JOIN usuario_prueba u JOIN alumno a ON p.id_usuario = u.id_usuario AND u.id_usuario = a.id_usuario WHERE a.id_alumno IN (SELECT id_alumno FROM alumno_grupo WHERE id_grupo = " . $id_grupo . ") GROUP BY a.matricula ORDER BY matricula ASC;";
                        $stmt = $conn->query($stringQuery);
                        $cantidadAlumnos=count($alumnos["id"]);
                        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
                            for ($n = 0; $n < $cantidadAlumnos; $n++) {
                                if ($alumnos["id"][$n] == $row[0]) {
                                    $alumnos["diamantes"][$n] = $row[1];
                                }
                            }
                        }
                    } catch (PDOException $e) {
                        echo "Error: " . $e->getMessage();
                    }
                    $conn = null;

                    ?>
                    <?php
                    //-------------AQUI OBTIENES LA CALIFICACION DE LOS ALUMNOS, SI NO SE ENCUENTRA IMPRIME NP
                    for ($m = 0; $m < $cantidadAlumnos; $m++) {
                        echo '<tr>';
                        echo '<td>' . $alumnos["numeroLista"][$m] . '</td>';
                        echo '<td>' . $alumnos["primerNombre"][$m] . '</td>';
                        echo '<td>' . $alumnos["diamantes"][$m] . '</td>';
                        for ($l = 0; $l < count($lecciones["id"]); $l++) {
                            $entre = 0;
                            //Crear la lectura en base de datos
                            try {
                                $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                                $stringQuery = "SELECT puntuacion FROM puntuacion WHERE tipo ='" . $tipo . "' AND id_leccion=" . $lecciones["id"][$l] . " AND id_usuario IN (SELECT id_usuario FROM alumno WHERE id_alumno=" . $alumnos["id"][$m] . ")";
                                $stmt = $conn->query($stringQuery);
                                while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
                                    $entre = 1;
                                    $calificacion = intval(100 * $row[0] / $lecciones["totalPreguntas"][$l]);
                                    if ($tipo == "SP" || $tipo == "SG") {
                                        $calificacion = intval($calificacion / 3);
                                    }
                                    echo '<td>' . $calificacion . '</td>';
                                }
                                if ($entre == 0) {
                                    echo '<td style="color:red;">NP</td>';
                                }
                            } catch (PDOException $e) {
                                echo "Error: " . $e->getMessage();
                            }
                            $conn = null;
                        }
                        echo '</tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>



</body>

</html>