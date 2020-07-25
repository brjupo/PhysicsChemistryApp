<?php
require "../../../Servicios/DDBBVariables.php";
require "../../../Servicios/isTeacher.php";
$teacherID = isTeacher();
if ($teacherID == "null") {
    header('Location: https://kaanbal.net/');
    exit;
} else {
    print1g1m();
}

function print1g1m()
{
    echo '
    <!DOCTYPE html>
    <html>';
    printHead();
    echo '<body>';
    printTitle();
    printCabecera();
    echo '
    </body>
    </html>';
}

function printHead()
{
    echo '
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link
      rel="shortcut icon"
      type="image/x-icon"
      href="../../CSSsJSs/icons/pyramid.svg"
    />
    <title>Kaanbal</title>
    <link rel="stylesheet" href="../../CSSsJSs/bootstrap441.css" />
    <link rel="stylesheet" href="../../CSSsJSs/kaanbalEssentials.css" />
  </head>
  ';
}
function printTitle()
{
    echo '
    <style>
        table {
            border-collapse: separate !important; white-space: nowrap !important;
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
  ';
}

function printCabecera(){
    echo '

    <!--+++++++++++++++++++++++++++++++++++ CABECERA [Asignatura, Profesor, Grupo y Modalidad] +++++++++++++++++++++++++++++++++++++-->
    <p> INPUTS: Id de grupo y Modalidad</p>
    ';
    global $servername, $username, $password, $dbname;
    //Crear la lectura en base de datos
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stringQuery = "SELECT DISTINCT a.nombre, u.mail, g.nombre, pu.tipo FROM asignatura a JOIN grupo g JOIN profesor prof JOIN usuario_prueba u JOIN puntuacion pu ON g.id_asignatura = a.id_asignatura AND g.id_profesor = prof.id_profesor AND prof.id_usuario = u.id_usuario WHERE g.id_grupo = ".$_GET["grupo"]." AND pu.tipo = '".$_GET["modo"]."';";
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
    echo'
    <div class="container">
        <div class="row">
            <div class="col-8 col-sm-8 col-md-8 col-lg-8 col-xl-8">
                <table style="width:100%">
                    <tbody>
                        <tr class="table-info">
                            <td>Asignatura</td>
                            <td>'. $materia. '</td>
                        </tr>
                        <tr class="table-light">
                            <td>Profesor</td>
                            <td>'. $correoProfesor. '</td>
                        </tr>
                        <tr class="table-info">
                            <td>Grupo</td>
                            <td>'. $grupo. '</td>
                        </tr>
                        <tr class="table-light">
                            <td>Modalidad</td>
                            <td>'. $modalidad. '</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-4 col-sm-4 col-md-4 col-lg-4 col-xl-4"></div>
        </div>
    </div>
    ';
}