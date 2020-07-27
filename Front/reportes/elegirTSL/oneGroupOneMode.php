<?php
require "../../../Servicios/DDBBVariables.php";
require "../../../Servicios/isTeacher.php";
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
        $stringQuery = "SELECT DISTINCT a.nombre, u.mail, g.nombre, pu.tipo FROM asignatura a JOIN grupo g JOIN profesor prof JOIN usuario_prueba u JOIN puntuacion pu ON g.id_asignatura = a.id_asignatura AND g.id_profesor = prof.id_profesor AND prof.id_usuario = u.id_usuario WHERE g.id_grupo = " . $id_grupo . " AND pu.tipo = '" . $tipo . "';";
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
    <div class="container">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <table style="width:100%">
                    <tbody>
                        <tr class="table-info">
                            <td>.</td>
                            <td>.</td>
                            <td><?php echo $tema; ?></td>
                        </tr>
                        <tr class="table-light">
                            <td>.</td>
                            <td>.</td>
                            <td><?php echo $subtema; ?></td>
                        </tr>
                        <tr class="table-info">
                            <td>.</td>
                            <td>.</td>
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
                        for ($m = 0; $m < count($alumnos["id"]); $m++) {
                            echo '<tr>';
                            echo '<td>' . $alumnos["matricula"][$m] . '</td>';
                            echo '<td>' . $alumnos["id"][$m] . '</td>';
                            //Crear la lectura en base de datos
                            $entre=0;
                            try {
                                $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                                $stringQuery = "SELECT alumno.id_alumno, puntuacion.puntuacion FROM puntuacion 
                                INNER JOIN alumno ON alumno.id_usuario = puntuacion.id_usuario 
                                WHERE id_leccion = " . $id_leccion . " AND tipo = '" . $tipo . "' AND tiempo 
                                BETWEEN '" . $desde_fecha . " " . $desde_tiempo . ":00'  
                                AND '" . $hasta_fecha . " " . $hasta_tiempo . ":00'";
                                $stmt = $conn->query($stringQuery);
                                echo "<p>" . $stringQuery . "</p>";
                                while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
                                    $entre=1;
                                    if($alumnos["id"][$m]==$row[0]){
                                        echo '<td>' . $row[1] . '</td>';
                                    }
                                }
                                if ($entre == 0) {
                                    echo '<td style="color:red;">NP</td>';
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
    </div>
</body>

</html>