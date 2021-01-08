<?php
//Necesario para los estilos nuevos desde Octubre 2020
require "../CSSsJSs/mainCSSsJSs.php";
require "../../servicios/00DDBBVariables.php";
require "../../servicios/isTeacher.php";
$teacherID = isTeacher();
if ($teacherID == "null") {
    header('Location: https://kaanbal.net/');
    exit;
}

$teacherUserID = $_SESSION["id_usuario"];
?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="shortcut icon" type="image/x-icon" href="../CSSsJSs/icons/pyramid.svg" />
    <title>Kaanbal</title>
    <link rel="stylesheet" href="../CSSsJSs/<?= $bootstrap441 ?>" />
    <link rel="stylesheet" href="../CSSsJSs/<?= $kaanbalEssentials ?>" />
    <script src="../CSSsJSs/<?= $minAJAX ?>"></script>
    <script src="CSSsJSs/crearGrupo04.js"></script>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <h1 class="titulo">Kaanbal</h1>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <p style="color: rgba(0, 0, 0, 0)">.</p>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <p>Para crear un nuevo <strong>grupo</strong>:</p>
                <p>- Elija la materia</p>
                <p>- Escriba el nombre que deseé darle a su grupo</p>
                <p>
                    > De clic en "crear grupo". Su grupo se creará y se añadirá a la
                    lista inferior.
                </p>
                <p>
                    - Comparta el identificador de grupo a sus alumnos para que puedan unirse.
                </p>
                <p style="font-size: small">
                    Cualquier duda estamos para ayudarte
                    <a href="https://kaanbal.net/contacto.html">contáctanos</a>
                </p>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <p style="color: rgba(0, 0, 0, 0)">.</p>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="input-group col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <div class="input-group-prepend">
                    <div class="input-group-text">Elija la materia:</div>
                </div>
                <select class="custom-select" id="id_asignatura">
                    <option value="0" selected disabled>Elige...</option>
                    <?php
                    try {
                        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        $stringQuery = "SELECT id_asignatura, nombre FROM asignatura;";
                        $stmt = $conn->query($stringQuery);
                        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
                            echo '
                                <option value="' . $row[0] . '">' . $row[1] . '</option>
                            ';
                        }
                    } catch (PDOException $e) {
                        echo "failed: " . $stringQuery . $e->getMessage();
                    }
                    $conn = null;
                    ?>
                </select>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <p style="color: rgba(0, 0, 0, 0)">.</p>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="input-group col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12" style="display:none">
                <div class="input-group-prepend">
                    <div class="input-group-text">ID usuario prof</div>
                </div>
                <input id="id_usuario" type="text" class="form-control" value="<?= $teacherUserID ?>" />
            </div>
            <div class="input-group col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <div class="input-group-prepend">
                    <div class="input-group-text">Nombre del grupo:</div>
                </div>
                <input id="nombre_grupo" type="text" class="form-control" placeholder="Escribe AQUI el nombre del grupo" />
            </div>
            <?php
            //Crear un código de grupo único
            $existe = 1;
            while ($existe == 1) {
                //Crearlo
                $rand = bin2hex(random_bytes(5));
                $rand2 = bin2hex(random_bytes(5));
                $codigoTemp = $rand . "-" . $rand2;
                //Consulta en BBDD si ya existe
                try {
                    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $stringQuery = 'SELECT codigo FROM grupo WHERE codigo = "' . $codigoTemp . '";';
                    $stmt = $conn->query($stringQuery);
                    $existe = 0;
                    while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
                        $existe = 1;
                    }
                } catch (PDOException $e) {
                    echo "failed: " . $stringQuery . $e->getMessage();
                    $existe = 0;
                }
                $conn = null;
                //  Si existe regresa a crearlo
            }
            ?>
            <div class="input-group col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12" style="display:none">
                <div class="input-group-prepend">
                    <div class="input-group-text">Código grupo</div>
                </div>
                <input id="codigo_grupo" type="text" class="form-control" value="<?= $codigoTemp ?>" />
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <p style="color: rgba(0, 0, 0, 0)">.</p>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="input-group input-group-sm col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                <button id="guardarEnBBDD" type="button" class="btn btn-primary btn-sm">
                    Crear nuevo grupo
                </button>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <p style="color: rgba(0, 0, 0, 0)">.</p>
            </div>
        </div>
    </div>
    <div class="container" style="border-top: 4px dotted #007bff">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <p style="color: rgba(0, 0, 0, 0)">.</p>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <p><strong>Listado de grupos creados</strong>:</p>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <p style="color: rgba(0, 0, 0, 0)">.</p>
            </div>
        </div>
    </div>

    <?php

        try {
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stringQuery = 'SELECT g.id_grupo, a.nombre, g.nombre, g.codigo  FROM grupo g JOIN asignatura a  ON g.id_asignatura = a.id_asignatura  WHERE g.id_profesor = (SELECT id_profesor FROM profesor WHERE id_usuario = "' . $teacherUserID . '");';
            $stmt = $conn->query($stringQuery);
            while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
                echo '
                        <div class="container">
                            <div class="row">
                                <div class="input-group col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" style="display:none">ID: ' . $row[0] . '</span>
                                        <span class="input-group-text">Materia: ' . $row[1] . '</span>
                                    </div>
                                    <input type="text" class="form-control" value="' . $row[2] . '" />
                                    <div class="input-group-append">
                                        <span class="input-group-text">Identificador de Grupo: ' . $row[3] . '</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    ';
            }
            $_SESSION["tieneGrupos"] = '1';
        } catch (PDOException $e) {
            echo "failed: " . $stringQuery . $e->getMessage();
        }
        $conn = null;
    ?>
    <div class="container">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <p style="color: rgba(0, 0, 0, 0)">.</p>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <p style="color: rgba(0, 0, 0, 0)">.</p>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <p style="color: rgba(0, 0, 0, 0)">.</p>
            </div>
        </div>
    </div>
</body>

</html>