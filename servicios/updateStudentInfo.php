<?php
require "00DDBBVariables.php";

//Leer las variables del POST
$idUser = $_POST['idUser'];
//Old id group code
$idGroupCode = $_POST['idGroupCode'];
//New group code
$groupCode = $_POST['groupCode'];
$listNumber = $_POST['listNumber'];
$idFirstName = $_POST['idFirstName'];



//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++//
//+++++++++++++++++++++++++ Actualizar licencia ++++++++++++++++++++++++//
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++//

//Conocer la asignatura anterior
//Crear la lectura en base de datos
$idAsignaturaAnterior = NULL;
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stringQuery = 'SELECT id_asignatura FROM grupo WHERE id_grupo = ' . $idGroupCode . ' LIMIT 1;';
    $stmt = $conn->query($stringQuery);
    while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
        $idAsignaturaAnterior = $row[0];
    }
    if ($idAsignaturaAnterior == NULL) {
        $response["response"] = " Error. Invalid old group identifier";
    }
} catch (PDOException $e) {
    $response["response"] .=  " failed: " . $stringQuery . $e->getMessage();
    header("HTTP/1.0 400 Bad Request");
}
$conn = null;

//Conocer la nueva asignatura
//Crear la lectura en base de datos
$idAsignaturaNueva = NULL;
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stringQuery = 'SELECT id_asignatura FROM grupo WHERE codigo = ' . $groupCode . ' LIMIT 1;';
    $stmt = $conn->query($stringQuery);
    while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
        $idAsignaturaNueva = $row[0];
    }
    if ($idAsignaturaNueva == NULL) {
        $response["response"] .= " Error. Invalid new group identifier";
    }
} catch (PDOException $e) {
    $response["response"] .=  " failed: " . $stringQuery . $e->getMessage();
    header("HTTP/1.0 400 Bad Request");
}
$conn = null;

//¿Son diferentes?
//Si > Actualizar la tabla de licencias
//No > Todo OK
if ($idAsignaturaNueva != $idAsignaturaAnterior) {
    //Crear la escritura en base de datos
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        //INSERT INTO MyGuests (firstname, lastname, email) VALUES ('John', 'Doe', 'john@example.com')
        //UPDATE Customers SET ContactName = 'Alfred Schmidt', City= 'Frankfurt' WHERE CustomerID = 1
        $sql = 'UPDATE licencia SET id_asignatura = ' . $idAsignaturaNueva . ' WHERE id_usuario = ' . $idUser . ' AND id_asignatura = ' . $idAsignaturaAnterior . ' ;';
        // use exec() because no results are returned
        $conn->exec($sql);
    } catch (PDOException $e) {
        $response["response"] .= " failed: " . $sql . "<br>" . $e->getMessage();
        header("HTTP/1.0 599 Database error");
    }
    $conn = null;
}



//Actualizar la tabla de alumno_grupo

//Obtener el ID de grupo
//Crear la lectura en base de datos
$idGrupo = NULL;
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stringQuery = 'SELECT id_grupo FROM grupo WHERE codigo = ' . $groupCode . ' LIMIT 1;';
    $stmt = $conn->query($stringQuery);
    while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
        $idGrupo = $row[0];
    }
    if ($idGrupo == NULL) {
        $response["response"] .= " Error. Invalid new group code";
    }
} catch (PDOException $e) {
    $response["response"] .=  " failed: " . $stringQuery . $e->getMessage();
    header("HTTP/1.0 400 Bad Request");
}
$conn = null;

//Crear la escritura en base de datos
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //INSERT INTO MyGuests (firstname, lastname, email) VALUES ('John', 'Doe', 'john@example.com')
    //UPDATE Customers SET ContactName = 'Alfred Schmidt', City= 'Frankfurt' WHERE CustomerID = 1
    $sql = 'UPDATE alumno_grupo SET id_grupo = ' . $idGrupo . ' WHERE id_grupo = ' . $idGroupCode . ' AND id_alumno IN (SELECT id_alumno FROM alumno WHERE id_usuario = ' . $idUser . ' LIMIT 1);';
    // use exec() because no results are returned
    $conn->exec($sql);
} catch (PDOException $e) {
    $response["response"] .= " failed: " . $sql . "<br>" . $e->getMessage();
    header("HTTP/1.0 599 Database error");
}
$conn = null;





//Actualizar la tabla de alumno

//Crear la escritura en base de datos
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //INSERT INTO MyGuests (firstname, lastname, email) VALUES ('John', 'Doe', 'john@example.com')
    //UPDATE Customers SET ContactName = 'Alfred Schmidt', City= 'Frankfurt' WHERE CustomerID = 1
    $sql = 'UPDATE alumno SET id_nombre = ' . $idFirstName . ', numero_lista = ' . $listNumber . ' WHERE id_usuario = ' . $idUser . ' ;';
    // use exec() because no results are returned
    $conn->exec($sql);
} catch (PDOException $e) {
    $response["response"] .= " failed: " . $sql . "<br>" . $e->getMessage();
    header("HTTP/1.0 599 Database error");
}
$conn = null;



////////////////  
//header("HTTP/1.0 400 Bad Request");
echo json_encode($response);
