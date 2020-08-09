<?php
require "../../Servicios/DDBBVariables.php";
require "../../Servicios/isStaff.php";
$staffID = isStaff();
if ($staffID == "null") {
    header('Location: https://kaanbal.net/');
    exit;
}
?>



<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="shortcut icon" type="image/x-icon" href="../CSSsJSs/icons/pyramid.svg" />
    <title>Kaanbal</title>
    <link rel="stylesheet" href="../CSSsJSs/bootstrap441.css" />
    <link rel="stylesheet" href="../CSSsJSs/kaanbalEssentials10.css" />
</head>

<body>

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

    <div class="container">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <p>
                    - Elija el campus, profesor y asignatura correcta.
                    - Escriba el código del grupo. [Sin espacios ANTES, ni DESPUES]
                </p>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <p style="color: rgba(0, 0, 0, 0);">.</p>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <p style="color: rgba(0, 0, 0, 0);">.</p>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="input-group col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                <div class="input-group-prepend">
                    <label class="input-group-text" for="campus">Campus</label>
                </div>
                <label for="campus" style="display:none;">campus</label>
                <select class="custom-select" id="campus" name="campus" form="groupForm">
                    <option selected disabled value="0">Elegir</option>
                    <?php
                    global $servername, $username, $password, $dbname;
                    //Crear la lectura en base de datos
                    try {
                        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        $stringQuery = 'SELECT id_campus, nombre FROM campus';
                        $stmt = $conn->query($stringQuery);
                        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
                            echo '<option value="' . $row[0] . '">' . $row[1] . '</option>';
                        }
                    } catch (PDOException $e) {
                        echo "Error: " . $e->getMessage();
                    }
                    $conn = null;
                    ?>
                </select>
            </div>
            <div class="input-group col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                <div class="input-group-prepend">
                    <label class="input-group-text" for="profesor">Profesor</label>
                </div>
                <label for="profesor" style="display:none;">profesor</label>
                <select class="custom-select" id="profesor" name="profesor" form="groupForm">
                    <option selected disabled value="0">Elegir</option>
                    <?php
                    global $servername, $username, $password, $dbname;
                    //Crear la lectura en base de datos
                    //De aqui obtenemos el id del profesor y el mail
                    try {
                        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        $stringQuery = 'SELECT A.id_profesor, B.mail FROM profesor A INNER JOIN usuario_prueba B WHERE A.id_usuario = B.id_usuario';
                        $stmt = $conn->query($stringQuery);
                        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
                            echo '<option value="' . $row[0] . '">' . $row[1] . '</option>';
                        }
                    } catch (PDOException $e) {
                        echo "Error: " . $e->getMessage();
                    }
                    $conn = null;
                    ?>
                </select><br>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <p style="color: rgba(0, 0, 0, 0);">.</p>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="input-group col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                <div class="input-group-prepend">
                    <label class="input-group-text" for="grupo">Grupo</label>
                </div>
                <label for="grupo" style="display:none;">grupo</label>
                <input type="text" id="grupo" name="grupo" class="form-control" form="groupForm"><br>
            </div>
            <div class="input-group col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                <div class="input-group-prepend">
                    <label class="input-group-text" for="asignatura">Asignatura</label>
                </div>
                <label for="asignatura" style="display:none;">asignatura</label>
                <select class="custom-select" id="asignatura" name="asignatura" form="groupForm">
                    <option selected disabled value="0">Elegir</option>
                    <?php
                    global $servername, $username, $password, $dbname;
                    //Crear la lectura en base de datos
                    try {
                        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        $stringQuery = 'SELECT id_asignatura, nombre, names FROM asignatura';
                        $stmt = $conn->query($stringQuery);
                        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
                            echo '<option value="' . $row[0] . '">' . $row[1] . ' / ' . $row[2] . '</option>';
                        }
                    } catch (PDOException $e) {
                        echo "Error: " . $e->getMessage();
                    }
                    $conn = null;
                    ?>
                </select><br>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <p style="color: rgba(0, 0, 0, 0);">.</p>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="input-group col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <form action="writeGroupOnDDBB.php" id="groupForm" method="POST">
                    <input type="submit" class="btn btn-primary btn-sm" value="Crear grupo"><br>
                </form>
            </div>
        </div>
    </div>


    <div class="container">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <p style="color: rgba(0, 0, 0, 0);">.</p>
            </div>
        </div>
    </div>
    <div class="container" style="border-top: 4px dotted #007bff;">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <h3>Grupos creados</h3>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <table class="table table-striped">
                    <tr>
                        <th>Grupo</th>
                        <th>Profesor</th>
                        <th>Asginatura</th>
                        <th>Campus</th>
                    </tr>
                    <?php
                    global $servername, $username, $password, $dbname;
                    //Crear la lectura en base de datos
                    try {
                        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        $stringQuery = 'SELECT g.nombre, u.mail, a.nombre, c.nombre 
                    FROM grupo g JOIN profesor p JOIN usuario_prueba u JOIN asignatura a JOIN campus c 
                    ON g.id_profesor = p.id_profesor AND p.id_usuario = u.id_usuario AND g.id_asignatura = a.id_asignatura AND g.id_campus = c.id_campus 
                    ORDER BY u.mail ASC, g.nombre ASC;';
                        $stmt = $conn->query($stringQuery);
                        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
                            echo '<tr>';
                            echo '<td>' . $row[0] . '</td>';
                            echo '<td>' . $row[1] . '</td>';
                            echo '<td>' . $row[2] . '</td>';
                            echo '<td>' . $row[3] . '</td>';
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
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <p style="color: rgba(0, 0, 0, 0);">.</p>
            </div>
        </div>
    </div>
</body>

</html>