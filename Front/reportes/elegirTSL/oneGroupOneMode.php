<?php
require "../../../servicios/00DDBBVariables.php";
require "../../../servicios/isTeacher.php";
$teacherID = isTeacher();
if ($teacherID == "null") {
    header('Location: https://kaanbal.net/');
    exit;
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="shortcut icon" type="image/x-icon" href="../../CSSsJSs/icons/pyramid.svg" />
    <title>Kaanbal</title>
    <link rel="stylesheet" href="../../CSSsJSs/bootstrap441.css" />
    <link rel="stylesheet" href="../../CSSsJSs/kaanbalEssentials10.css" />
    <script src="../TableCSVExporter5.js"></script>
</head>

<body>
    <?php
    $id_grupo = $_POST["grupo"];
    $tipo = $_POST["modalidad"];
    $id_leccion = $_POST["id_leccion"];
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
    <!--+++++++++++++++++++++++++++++++++++ CABECERA [Asignatura, Profesor, Grupo y Modalidad] +++++++++++++++++++++++++++++++++++++-->
    <?php
    global $servername, $username, $password, $dbname;
    //Crear la lectura en base de datos
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stringQuery = "SELECT DISTINCT a.nombre, u.mail, g.nombre, pu.tipo FROM asignatura a JOIN grupo g JOIN profesor prof JOIN usuario_prueba u JOIN puntuacion_historico pu ON g.id_asignatura = a.id_asignatura AND g.id_profesor = prof.id_profesor AND prof.id_usuario = u.id_usuario WHERE g.id_grupo = " . $id_grupo . " AND pu.tipo = '" . $tipo . "';";
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
    // (Condition)?(thing's to do if condition true):(thing's to do if condition false);
    if ($modalidad == "PP") $modalidad = "Práctica";
    if ($modalidad == "SP") $modalidad = "Sprint";
    if ($modalidad == "E") $modalidad = "Examen";
    if ($modalidad == "SS") $modalidad = "Super Sprint";
    ?>
    <div class="container">
        <div class="row">
            <div class="col-8 col-sm-8 col-md-8 col-lg-8 col-xl-8">
                <table style="width:100%" class="table table-striped">
                    <tbody>
                        <tr>
                            <td>Asignatura</td>
                            <td><?php echo $materia; ?></td>
                        </tr>
                        <tr class="table-light">
                            <td>Profesor</td>
                            <td><?php echo $correoProfesor; ?></td>
                        </tr>
                        <tr>
                            <td>Grupo</td>
                            <td><?php echo $grupo; ?></td>
                        </tr>
                        <tr class="table-light">
                            <td>Modalidad</td>
                            <td><?php echo $modalidad; ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-4 col-sm-4 col-md-4 col-lg-4 col-xl-4"></div>
        </div>
    </div>
    <?php
    global $servername, $username, $password, $dbname;
    //Crear la lectura en base de datos
    //SELECT nombre FROM tema WHERE id_tema IN (SELECT id_tema FROM subtema WHERE id_subtema IN (SELECT id_subtema FROM leccion WHERE id_leccion = 151)) 
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stringQuery = "SELECT nombre FROM tema WHERE id_tema IN (SELECT id_tema FROM subtema WHERE id_subtema IN (SELECT id_subtema FROM leccion WHERE id_leccion = " . $id_leccion . "))";
        $stmt = $conn->query($stringQuery);
        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $tema = $row[0];
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    $conn = null;
    //SELECT nombre FROM subtema WHERE id_subtema IN (SELECT id_subtema FROM leccion WHERE id_leccion = 151) 
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stringQuery = "SELECT nombre FROM subtema WHERE id_subtema IN (SELECT id_subtema FROM leccion WHERE id_leccion = " . $id_leccion . ")";
        $stmt = $conn->query($stringQuery);
        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $subtema = $row[0];
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    $conn = null;
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stringQuery = "SELECT nombre FROM leccion WHERE id_leccion = " . $id_leccion . ";";
        $stmt = $conn->query($stringQuery);
        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $leccion = $row[0];
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    $conn = null;
    ?>
    <!--+++++++++++++++++++++++++++++++++++ IMPRIMIR PARA DESCARGAR ARCHIVO ++++++++++++-->
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
                $fileName = "periodo_" . $materia . "_" . $grupo . "_" . $desde_fecha . "_" . $desde_tiempo;
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

    <!--+++++++++++++++++++++++++++++++++++ IMPRIMIR TABLA | UN MODO | UN GRUPO | ++++++++++++-->
    <div class="container">
        <div class="row">
            <table id="dataTable" style="width:100%">
                <tbody>
                    <tr class="table-info">
                        <td style="color:rgba(50,50,255,1)">Materia</td>
                        <td style="color:rgba(50,50,255,1)"><?php echo $materia; ?></td>
                        <td><?php echo $tema; ?></td>
                    </tr>
                    <tr class="table-light">
                        <td style="color:rgba(50,50,255,1)">Grupo</td>
                        <td style="color:rgba(50,50,255,1)"><?php echo $grupo; ?></td>
                        <td><?php echo $subtema; ?></td>
                    </tr>
                    <tr class="table-info">
                        <td style="color:rgba(50,50,255,1)">Fecha y Hora del periodo</td>
                        <td style="color:rgba(50,50,255,1)"><?php echo $desde_fecha . "_" . $desde_tiempo . " a " . $hasta_fecha . "_" . $hasta_tiempo; ?></td>
                        <td><?php echo $leccion; ?></td>
                    </tr>
                    <?php
                    //--------------AQUI OBTIENES TODOS LOS ALUMNOS DEL GRUPO
                    $alumnos = array();
                    $alumnos["matricula"] = array();
                    $alumnos["id"] = array();
                    //Crear la lectura en base de datos
                    try {
                        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        $stringQuery = "SELECT DISTINCT alumno.matricula, alumno_grupo.id_alumno FROM alumno_grupo INNER JOIN alumno ON alumno.id_alumno = alumno_grupo.id_alumno WHERE alumno_grupo.id_grupo = " . $id_grupo;
                        $stmt = $conn->query($stringQuery);
                        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
                            array_push($alumnos["matricula"], $row[0]);
                            array_push($alumnos["id"], $row[1]);
                        }
                    } catch (PDOException $e) {
                        echo "Error: " . $e->getMessage();
                    }
                    $conn = null;

                    ?>
                    <?php
                    //--------NECESITASMOS SABER EL NUMERO DE PREGUNTAS DE LA LECCION PARA OBTENER LA CALILIFACION
                    $totalPreguntas = 0;
                    try {
                        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        $stringQuery = "SELECT COUNT(id_leccion) FROM pregunta WHERE id_leccion = " . $id_leccion;
                        $stmt = $conn->query($stringQuery);
                        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
                            $totalPreguntas = $row[0];
                            echo '<p> Total de preguntas de esta lección = ' . $totalPreguntas . '</p>';
                        }
                    } catch (PDOException $e) {
                        echo "Error: " . $e->getMessage();
                    }
                    $conn = null;
                    ?>
                    <?php
                    //---------IMPRIME MATRICULA Y ASOCIA EL ID ALUMNO CON LAS PUNTUACIONES EN PUNTUACION
                    //---------ASI APARECE LA PUNUTACION DEL ALUMNO DE LA LECCION
                    for ($m = 0; $m < count($alumnos["id"]); $m++) {
                        echo '<tr>';
                        echo '<td>' . $alumnos["matricula"][$m] . '</td>';
                        echo '<td>' . $alumnos["id"][$m] . '</td>';
                        //Crear la lectura en base de datos
                        $entre = 0;
                        try {
                            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                            $stringQuery = "SELECT alumno.id_alumno, puntuacion_historico.puntuacion FROM puntuacion_historico 
                                INNER JOIN alumno ON alumno.id_usuario = puntuacion_historico.id_usuario 
                                WHERE id_leccion = " . $id_leccion . " AND tipo = '" . $tipo . "' AND tiempo 
                                BETWEEN '" . $desde_fecha . " " . $desde_tiempo . ":00'  
                                AND '" . $hasta_fecha . " " . $hasta_tiempo . ":00'";
                            $stmt = $conn->query($stringQuery);
                            echo '<p style="display:none">' . $stringQuery . "</p>";
                            while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
                                if ($alumnos["id"][$m] == $row[0]) {
                                    $entre = 1;
                                    $calificacion = intval(100 * $row[1] / $totalPreguntas);
                                    //----Si se quieren tomar las N calificaciones, descomentar la sigueinte linea, pero la tabla NO será uniforma
                                    //echo '<td>' . $calificacion . '</td>';
                                }
                                //echo '<td> id=' . $row[0] . ' alum= '.$alumnos["id"][$m].' pts= '.$row[1].' </td>';
                            }
                            if ($entre == 0) {
                                echo '<td style="color:red;">NP</td>';
                            } else {
                                echo '<td>' . $calificacion . '</td>';
                            }
                        } catch (PDOException $e) {
                            echo "Error: " . $e->getMessage();
                        }
                        echo '</tr>';
                    }
                    $conn = null;
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>