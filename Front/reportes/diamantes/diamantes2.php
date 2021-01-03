<?php
require "../../../servicios/00DDBBVariables.php";
require "../../../servicios/isTeacher.php";
$teacherID=isTeacher();
if (!isset($_POST["grupo"])) {
    header('Location: https://kaanbal.net/');
    exit;
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
    <link rel="stylesheet" href="../../CSSsJSs/<?=$bootstrap441?>" />
    <link rel="stylesheet" href="../../CSSsJSs/<?=$kaanbalEssentials?>" />
    <script src="../TableCSVExporter5.js"></script>
</head>

<body>
    <?php
    $id_grupo = $_POST["grupo"];
    $desde_fecha = $_POST["desde"];
    $desde_tiempo = $_POST["desde_tiempo"];
    $hasta_fecha = $_POST["hasta"];
    $hasta_tiempo = $_POST["hasta_tiempo"];
    ?>
    <style>
        table {
            border-collapse: separate !important;
            white-space: nowrap !important;
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

    <?php
    //OBTENER TODOS LOS ALUMNOS
    $alumnos = array();
    $alumnos["matricula"] = array();
    $alumnos["id"] = array();
    $alumnos["diamantes"] = array();
    //Crear la lectura en base de datos
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stringQuery = "SELECT DISTINCT alumno.matricula, alumno_grupo.id_alumno FROM alumno_grupo INNER JOIN alumno ON alumno.id_alumno = alumno_grupo.id_alumno WHERE alumno_grupo.id_grupo = " . $id_grupo;
        $stmt = $conn->query($stringQuery);
        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            array_push($alumnos["matricula"], $row[0]);
            array_push($alumnos["id"], $row[1]);
            array_push($alumnos["diamantes"], 0);
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    $conn = null;

    ?>
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
                $fileName = "diamantes_" . $materia . "_" . $grupo . "_" . date("Y/m/d");
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

    <div class="container">
        <div class="row">
            <table id="dataTable" class="table table-striped">
                <tbody>
                    <tr>
                        <td style="color:rgba(50,50,255,1)">Materia</td>
                        <td style="color:rgba(50,50,255,1)"><?php echo $materia; ?></td>
                    </tr>
                    <tr>
                        <td style="color:rgba(50,50,255,1)">Grupo</td>
                        <td style="color:rgba(50,50,255,1)"><?php echo $grupo; ?></td>
                    </tr>
                    <tr>
                        <td style="color:rgba(50,50,255,1)">Fecha y Hora</td>
                        <td style="color:rgba(50,50,255,1)"><?php echo date("Y/m/d H:m:s"); ?></td>
                    </tr>
                    <tr>
                        <td>Matricula</td>
                        <td>Diamantes</td>
                    </tr>
                    <?php
                    //
                    //Crear la lectura en base de datos
                    try {
                        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        $stringQuery = "SELECT a.matricula, SUM(p.puntuacion) AS 'diamantes' 
                        FROM puntuacion p JOIN usuario_prueba u JOIN alumno a ON p.id_usuario = u.id_usuario 
                        AND u.id_usuario = a.id_usuario WHERE p.tiempo BETWEEN '".$desde_fecha." ".$desde_tiempo.":00' 
                        AND '".$hasta_fecha." ".$hasta_tiempo.":00' AND a.id_alumno IN (SELECT id_alumno FROM alumno_grupo 
                        WHERE id_grupo = ".$id_grupo.") GROUP BY a.matricula ORDER BY matricula ASC";
                        $stmt = $conn->query($stringQuery);
                        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
                            for ($n = 0; $n < count($alumnos["matricula"]); $n++) {
                                if ($alumnos["matricula"][$n] == $row[0]) {
                                    $alumnos["diamantes"][$n] = $row[1];
                                }
                            }
                        }
                    } catch (PDOException $e) {
                        echo "Error: " . $e->getMessage();
                    }
                    $conn = null;

                    for ($o = 0; $o < count($alumnos["matricula"]); $o++) {
                        echo '
                            <tr>
                                <td>' . $alumnos["matricula"][$o] . '</td>
                                <td>' . $alumnos["diamantes"][$o] . '</td>
                            </tr>
                        ';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <p style="color:white">.</p>
            </div>
        </div>
    </div>



</body>

</html>