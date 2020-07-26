<?php
require '../../../Servicios/DDBBVariables.php';
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="shortcut icon" type="image/x-icon" href="../CSSsJSs/icons/pyramid.svg" />
    <title>Kaanbal</title>
    <link rel="stylesheet" href="../CSSsJSs/bootstrap441.css" />
    <link rel="stylesheet" href="../CSSsJSs/kaanbalEssentials.css" />
</head>

<body>
    <?php
        //$id_grupo = $_POST["grupo"];
        
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

    <div class="container">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <p style="color:white">.</p>
            </div>
        </div>
    </div>

    <!--+++++++++++++++++++++++++++++++++++ Temas, Subtemas y Lecciones +++++++++++++++++++++++++++++++++++++-->
    <!--OBTENER EL ID DE ASIGNATURA DEL GRUPO 1-->
    <div class="container">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <p>INPUTS: id_grupo</p><br>
            <p>INPUTS: id_grupo</p><br>
            <?php
            $id_asignatura = "1";
            //Crear la lectura en base de datos
            try {
                $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $stringQuery = "SELECT id_asignatura FROM grupo WHERE id_grupo = 1 LIMIT 1";
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
    <!--OBTENER LA LISTA DE TEMAS EN ORDEN, DEL GRUPO 1-->
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
    <!--OBTENER LA LISTA DE SUBTEMAS EN ORDEN, DEL GRUPO 1-->
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

    <!--OBTENER LA LISTA DE LECCIONES EN ORDEN, DEL GRUPO 1-->
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

    <!--IMRPIMIR LA LISTA DE LECCIONES EN ORDEN, DEL GRUPO 1-->
    <div class="container">
        <div class="row">
            <table class="table table-striped">
                <tbody>
                    <tr>
                        <td>.</td>
                        <td>.</td>
                        <?php
                        //Recorreremos todos los subtemas, y guardaremos en leccion[nombre] el nombre de TODOS los subtemas por orden de usuario
                        for ($k = 0; $k < count($lecciones["id"]); $k++) {
                            echo '<td>' . $lecciones["tema"][$k] . '</td>';
                        } ?>
                    </tr>
                    <tr>
                        <td>.</td>
                        <td>.</td>
                        <?php
                        for ($k = 0; $k < count($lecciones["id"]); $k++) {
                            echo '<td>' . $lecciones["subtema"][$k] . '</td>';
                        }
                        ?>
                    </tr>
                    <tr>
                        <td>.</td>
                        <td>.</td>
                        <?php
                        //Este for lo aprovecharemos para obtener el total de preguntas de cada leccion
                        //Ademas de imprmir las lecciones en la tabla
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
                    $alumnos = array();
                    $alumnos["matricula"] = array();
                    $alumnos["id"] = array();
                    //Crear la lectura en base de datos
                    try {
                        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        $stringQuery = "SELECT DISTINCT alumno.matricula, alumno_grupo.id_alumno FROM alumno_grupo INNER JOIN alumno ON alumno.id_alumno = alumno_grupo.id_alumno WHERE alumno_grupo.id_grupo = 1 ";
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
                        for ($l = 0; $l < count($lecciones["id"]); $l++) {
                            $entre = 0;
                            //Crear la lectura en base de datos
                            try {
                                $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                                $stringQuery = "SELECT puntuacion FROM puntuacion WHERE tipo ='PP' AND id_leccion=" . $lecciones["id"][$l] . " AND id_usuario IN (SELECT id_usuario FROM alumno WHERE id_alumno=" . $alumnos["id"][$m] . ")";
                                $stmt = $conn->query($stringQuery);
                                while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
                                    $entre = 1;
                                    $calificacion = intval(100*$row[0]/$lecciones["totalPreguntas"][$l]);
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