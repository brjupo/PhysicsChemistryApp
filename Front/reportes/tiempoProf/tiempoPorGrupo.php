<?php
require "../../../servicios/00DDBBVariables.php";
require "../../../servicios/isAdmin.php";
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
                <p>Tiempo total invertido por grupo en MINUTOS</p>
            </div>
        </div>
    </div>


    <?php
    //--------------------------------OBTENER TODOS LOS GRUPOS [ID Y NOMBRE]
    $grupos = array();
    $grupos["id"] = array();
    $grupos["nombre"] = array();
    $grupos["profe"] = array();

    //Crear la lectura en base de datos
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stringQuery = "SELECT g.id_grupo, g.nombre, u.mail 
        FROM grupo g JOIN profesor p JOIN usuario_prueba u 
        ON g.id_profesor = p.id_profesor AND p.id_usuario = u.id_usuario;";
        $stmt = $conn->query($stringQuery);
        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            array_push($grupos["id"], $row[0]);
            array_push($grupos["nombre"], $row[1]);
            array_push($grupos["profe"], $row[2]);
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    $conn = null;
    //SELECT a.id_alumno FROM alumno a JOIN alumno_grupo ag ON a.id_alumno = ag.id_alumno WHERE ag.id_grupo = 10 
    ?>

    <div class="container">
        <div class="row">
            <table class="table table-striped">
                <tbody>
                    <tr>
                        <td>Profesor</td>
                        <td>Grupo</td>
                        <td>Total tiempo</td>
                    </tr>
                    <?php
                    $size0 = count($grupos["id"]);
                    for ($m = 0; $m < $size0; ++$m) {
                        $total=0;
                        echo '<tr>';
                        echo '<td>' . $grupos["profe"][$m] . '</td>';
                        echo '<td>' . $grupos["nombre"][$m] . '</td>';
                        $id_grupos = $grupos["id"][$m];
                        //Crear la lectura en base de datos
                        try {
                            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                            $stringQuery = "SELECT a.id_alumno, ROUND(a.acmlrPP + a.acmlrSP + a.acmlrE + a.acmlrSS) as 'acumulado' 
                            FROM alumno a JOIN alumno_grupo ag 
                            ON a.id_alumno = ag.id_alumno 
                            WHERE ag.id_grupo = ".$id_grupos.";";
                            $stmt = $conn->query($stringQuery);
                            while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
                                $total = $total + $row[1];
                            }
                        } catch (PDOException $e) {
                            echo "Error: " . $e->getMessage();
                        }
                        $conn = null;

                        echo '<td>' . $total. '</td>';
                        echo '</tr>';
                    }

                    //SELECT a.id_alumno FROM alumno a JOIN alumno_grupo ag ON a.id_alumno = ag.id_alumno WHERE ag.id_grupo = 10 

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