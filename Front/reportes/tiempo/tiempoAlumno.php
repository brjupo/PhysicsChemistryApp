<?php
require "../../../servicios/00DDBBVariables.php";
require "../../../servicios/isTeacher.php";
$teacherID=isTeacher();
if (!isset($_POST["grupo"])) {
    header('Location: ../controlCalificaciones.php');
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
</head>

<body>
    <?php
    $id_grupo = $_POST["grupo"];
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
            <div class="text-center col-1 col-sm-1 col-md-1 col-lg-1 col-xl-1"></div>
            <div class="textLeft col-5 col-sm-5 col-md-5 col-lg-5 col-xl-5">
                <p class="titulo">Kaanbal</p>
            </div>
            <div class="text-center col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6"></div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <p>Tiempo total invertido por el alumno en MINUTOS</p>
            </div>
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

    <div class="container">
        <div class="row">
            <table class="table table-striped">
                <tbody>
                    <tr>
                        <td>Número de lista</td>
                        <td>Primer nombre</td>
                        <td>Total</td>
                        <td>Práctica</td>
                        <td>Sprint</td>
                        <td>Examen</td>
                    </tr>
                        <?php
                        //Crear la lectura en base de datos
                        try {
                            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                            $stringQuery = "SELECT alumno.numero_lista, alumno.id_nombre, alumno.acmlrPP, alumno.acmlrSP, 
                            alumno.acmlrE FROM alumno INNER JOIN alumno_grupo 
                            ON alumno.id_alumno = alumno_grupo.id_alumno WHERE alumno_grupo.id_grupo = '".$id_grupo."' 
                            ORDER BY alumno.numero_lista ASC ";
                            $stmt = $conn->query($stringQuery);
                            while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
                                echo '<tr>';
                                echo '<td>'.$row[0].'</td>';
                                echo '<td>'.$row[1].'</td>';
                                $sum = intval($row[2]+$row[3]+$row[4]+$row[5]);
                                echo '<td>'.$sum.'</td>';
                                echo '<td>'.intval($row[2]).'</td>';
                                echo '<td>'.intval($row[3]).'</td>';
                                echo '<td>'.intval($row[4]).'</td>';
                                echo '</tr>';
                            }
                        } catch (PDOException $e) {
                            echo "Error: " . $e->getMessage();
                        }
                        $conn = null;
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