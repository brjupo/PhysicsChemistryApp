<?php
require '../../Servicios/DDBBVariables.php';
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="shortcut icon" type="image/x-icon" href="../CSSsJSs/icons/pyramid.svg" />
    <title>Kaanbal</title>
    <link rel="stylesheet" href="../CSSsJSs/bootstrap441.css" />
    <link rel="stylesheet" href="../CSSsJSs/kaanbalEssentials2.css" />
</head>

<body>
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
    <p> INPUTS: Id de grupo y Modalidad</p>
    <?php
    //Crear la lectura en base de datos
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stringQuery = "SELECT DISTINCT a.nombre, u.mail, g.nombre, pu.tipo FROM asignatura a JOIN grupo g JOIN profesor prof JOIN usuario_prueba u JOIN puntuacion pu ON g.id_asignatura = a.id_asignatura AND g.id_profesor = prof.id_profesor AND prof.id_usuario = u.id_usuario WHERE g.id_grupo = 1 AND pu.tipo = 'SP';";
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
                            <td><?php echo $modalidad; ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-4 col-sm-4 col-md-4 col-lg-4 col-xl-4"></div>
        </div>
    </div>
    <!--+++++++++++++++++++++++++++++++++++ Temas, Subtemas y Lecciones +++++++++++++++++++++++++++++++++++++-->
    <p>.</p>
    <p>INPUTS: id grupo</p>
    <?php
    //Debemos trasponer el resultado, por ello necesitare un array
    $lectionsArray = array();
    $i = 0;
    //Crear la lectura en base de datos
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stringQuery = "SELECT t.nombre, s.nombre, l.nombre FROM leccion l JOIN subtema s JOIN tema t ON l.id_subtema = s.id_subtema AND s.id_tema = t.id_tema WHERE t.id_asignatura = (SELECT id_asignatura FROM grupo WHERE id_grupo = 1);";
        $stmt = $conn->query($stringQuery);
        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            //row [0] -> Tema, subtema, leccion
            $lectionsArray[$i] = array($row[0], $row[1], $row[2]);
            $i = $i + 1;
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    $conn = null;
    ?>
    <div class="container">
        <div class="row">
            <table>
                <tbody>
                    <tr class="table-success">
                        <td style="color:white;">.</td>
                        <td style="color:white;">.</td>
                        <?php
                        for ($j = 0; $j < count($lectionsArray); $j++) {
                            echo '<td>' . $lectionsArray[$j][0] . '</td>';
                        }
                        ?>
                    </tr>
                    <tr class="table-light">
                        <td style="color:white;">.</td>
                        <td style="color:white;">.</td>
                        <?php
                        for ($k = 0; $k < count($lectionsArray); $k++) {
                            echo '<td>' . $lectionsArray[$k][1] . '</td>';
                        }
                        ?>
                    </tr>
                    <tr class="table-success">
                        <td>Matricula</td>
                        <td>Diamantes</td>
                        <?php
                        for ($l = 0; $l < count($lectionsArray); $l++) {
                            echo '<td>' . $lectionsArray[$l][2] . '</td>';
                        }
                        ?>
                    </tr>
                    <!--+++++++++++++++++++++++++++++++++++ Matriculas y Diamantes +++++++++++++++++++++++++++++++++++++-->
                    <?php
                    //Crear la lectura en base de datos
                    try {
                        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        $stringQuery = "SELECT a.matricula, SUM(p.puntuacion) AS 'diamantes' FROM puntuacion p JOIN usuario_prueba u JOIN alumno a ON p.id_usuario = u.id_usuario AND u.id_usuario = a.id_usuario WHERE a.id_alumno IN (SELECT id_alumno FROM alumno_grupo WHERE id_grupo = 1) GROUP BY a.matricula ORDER BY matricula ASC;";
                        $stmt = $conn->query($stringQuery);
                        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
                            //row [0] -> matricula
                            //row [1] -> diamantes
                            echo '
	                            <tr class="table-light">
	                                <td>' . $row[0] . '</td>
                                    <td>' . $row[1] . '</td>';
                            try {
                                //Crear la lectura en base de datos
                                $conn2 = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                                $stringQuery2 = "SELECT a.matricula, l.id_leccion, p.puntuacion FROM alumno a JOIN leccion l JOIN puntuacion p ON p.id_leccion = l.id_leccion AND p.id_usuario = a.id_usuario WHERE p.tipo = 'SP' AND a.id_alumno IN (SELECT id_alumno FROM alumno_grupo WHERE id_grupo = 1) ORDER BY a.matricula ASC, l.id_leccion ASC;";
                                $stmt2 = $conn2->query($stringQuery2);
                                while ($row2 = $stmt2->fetch(PDO::FETCH_NUM)) {
                                    //$row[0] valor de la primera columna 
                                    if ($row[0] == $row2[0]) {
                                        echo '<td>' .  $row2[2] . '</td>';
                                    }
                                    else{
                                        echo '<td></td>';
                                    }
                                }
                            } catch (PDOException $e) {
                                echo "Error: " . $e->getMessage();
                            }
                            echo '</tr>';
                            //<td>' . obtenerPuntuacion($row[0]). '</td>
                        }
                    } catch (PDOException $e) {
                        echo "Error: " . $e->getMessage();
                    }
                    $conn = null;
                    $conn2 = null;
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>