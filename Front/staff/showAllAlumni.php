<?php
require "../../servicios/00DDBBVariables.php";
require "../../servicios/isStaff.php";
$staffID = isStaff();
if ($staffID == "null") {
    header('Location: https://kaanbal.net/');
    exit;
}
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
    <div class="container">
        <div class="row">
            <div class="text-center col-1 col-sm-1 col-md-1 col-lg-1 col-xl-1"></div>
            <div class="textLeft col-5 col-sm-5 col-md-5 col-lg-5 col-xl-5">
                <p class="titulo" id="titulo">Kaanbal</p>
            </div>
            <div class="textRight col-5 col-sm-5 col-md-5 col-lg-5 col-xl-5"></div>
            <div class="text-center col-1 col-sm-1 col-md-1 col-lg-1 col-xl-1"></div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="text-center col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <p style="color: rgba(0, 0, 0, 0);">.</p>
            </div>
        </div>
        <div class="row">
            <div class="text-center col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <p style="color: rgba(0, 0, 0, 0);">.</p>
            </div>
        </div>
    </div>


    <div class="container">
        <div class="row">
            <div class="text-center col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <p>Para buscar un alumno o grupo. Oprima Ctrl+F y aparecerá un buscador.</p><br>
                <p>En firefox aparece del lado inferior izquierdo</p><br>
                <p>En chrome aparece del lado superior derecho </p>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="text-center col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <p style="color: rgba(0, 0, 0, 0);">.</p>
            </div>
        </div>
        <div class="row">
            <div class="text-center col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <p style="color: rgba(0, 0, 0, 0);">.</p>
            </div>
        </div>
    </div>


    <div class="container">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <table class="table table-striped">
                    <tr>
                        <th>Alumno</th>
                        <th>Grupo</th>
                    </tr>
                    <?php
                    global $servername, $username, $password, $dbname;
                    //Crear la lectura en base de datos
                    try {
                        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        $stringQuery = 'SELECT u.mail, g.nombre 
                        FROM grupo g JOIN alumno_grupo ag JOIN alumno a JOIN usuario_prueba u 
                        ON g.id_grupo = ag.id_grupo AND ag.id_alumno = a.id_alumno AND a.id_usuario = u.id_usuario 
                        ORDER BY g.nombre ASC, u.mail ASC;';
                        $stmt = $conn->query($stringQuery);
                        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
                            echo '<tr>';
                            echo '<td>' . $row[0] . '</td>';
                            echo '<td>' . $row[1] . '</td>';
                            echo '</tr>';
                        }
                    } catch (PDOException $e) {
                        echo "Error: " . $e->getMessage();
                    }
                    $conn = null;
                    ?>
                </table>
            </div>
        </div>
    </div>


    <div class="container">
        <div class="row">
            <div class="text-center col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <p style="color: rgba(0, 0, 0, 0);">.</p>
            </div>
        </div>
        <div class="row">
            <div class="text-center col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <p style="color: rgba(0, 0, 0, 0);">.</p>
            </div>
        </div>
    </div>
</body>

</html>