<?php
session_start();

require "../../servicios/00DDBBVariables.php";
if (!isset($_POST["mail"])) {
    header('Location: perfil.php');
    exit;
}


if ($_SESSION["mail"] != $_POST["mail"]) {
    //echo '<p> Sesion'.$_SESSION["mail"].'  mail ='.$_POST["mail"].'</p>';
    header('Location: perfil.php');
    exit;
}
$mailUsuario = $_SESSION["mail"];
$idAsignatura = $_SESSION["idAsignatura"];

require "../CSSsJSs/mainCSSsJSs.php";
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="shortcut icon" type="image/x-icon" href="../CSSsJSs/icons/pyramid.svg" />
    <title>Kaanbal</title>
    <link rel="stylesheet" href="../CSSsJSs/<?=$bootstrap441?>" />
    <link rel="stylesheet" href="../CSSsJSs/<?=$kaanbalEssentials?>" />
</head>

<body>
    <?php
    $mailAlumno = $_POST["mail"];
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
                <!--p>
                    <? echo $idAsignatura;?>
                </p-->
            </div>
            <div class="textCenter col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6"></div>
        </div>
    </div>



    <!--+++++++++++++++++++++++++++++++++++ Temas, Subtemas y Lecciones +++++++++++++++++++++++++++++++++++++-->
    <!--OBTENER EL ID DE ASIGNATURA DEL ALUMNO [MAIL]-->
    <div class="container">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            </div>
        </div>
    </div>



    <div class="container">
        <div class="row">
            <table class="table table-striped">
                <tbody>
                    <tr>
                        <td>Tema</td>
                        <td>Subtema</td>
                        <td>Lección</td>
                        <!--td>ID Lección</td-->
                        <td>Práctica</td>
                        <td>Sprint</td>
                        <td>Examen</td>
                    </tr>
                    <?php
                    //Crear la lectura en base de datos, de temas, subtemas, lecciones y ID Lección
                    try {
                        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        $stringQuery = "SELECT t.nombre, s.nombre, l.nombre, l.id_leccion 
                        FROM leccion l JOIN subtema s JOIN tema t 
                        ON l.id_subtema = s.id_subtema AND s.id_tema = t.id_tema 
                        WHERE t.id_asignatura = " . $idAsignatura . " ORDER BY t.orden, s.orden, l.orden;";
                        $stmt = $conn->query($stringQuery);
                        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
                            echo "<tr>
                                    <td>" . $row[0] . "</td>
                                    <td>" . $row[1] . "</td>
                                    <td>" . $row[2] . "</td>
                                    <!--td>" . $row[3] . "</td-->";
                            //Crear la lectura en base de datos, para obtener calificación de práctica, sprint y examen
                            try {
                                $tempIdLeccion = $row[3];
                                $entre = 0;
                                $conn2 = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                                $conn2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                                $stringQuery2 = "SELECT ((SELECT p.puntuacion FROM puntuacion p JOIN usuario_prueba u ON p.id_usuario = u.id_usuario WHERE p.id_leccion = " . $tempIdLeccion . " AND u.mail = '" . $mailUsuario . "' AND p.tipo = 'PP') * 100/(SELECT COUNT(*) FROM pregunta WHERE id_leccion = " . $tempIdLeccion . ")) AS sprint_particular, ((SELECT p.puntuacion FROM puntuacion p JOIN usuario_prueba u ON p.id_usuario = u.id_usuario WHERE p.id_leccion = " . $tempIdLeccion . " AND u.mail = '" . $mailUsuario . "' AND p.tipo = 'SP') * 100/3/(SELECT COUNT(*) FROM pregunta WHERE id_leccion = " . $tempIdLeccion . ")) AS practica_particular, ((SELECT p.puntuacion FROM puntuacion p JOIN usuario_prueba u ON p.id_usuario = u.id_usuario WHERE p.id_leccion = " . $tempIdLeccion . " AND u.mail = '" . $mailUsuario . "' AND p.tipo = 'E') * 100/(SELECT COUNT(*) FROM pregunta WHERE id_leccion = " . $tempIdLeccion . ")) AS examen;";
                                $stmt2 = $conn2->query($stringQuery2);
                                while ($row2 = $stmt2->fetch(PDO::FETCH_NUM)) {
                                    $entre = 1;
                                    echo "<td>" . intval($row2[0]) . "</td>";
                                    echo "<td>" . intval($row2[1]) . "</td>";
                                    echo "<td>" . intval($row2[2]) . "</td>";
                                }
                                
                            } catch (PDOException $e2) {
                                echo "Error: " . $e2->getMessage();
                            }
                            $conn2 = null;
                            echo "</tr>";
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

</body>

</html>