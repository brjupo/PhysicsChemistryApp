
<?php
require "DDBBVariables.php";
//---------------NO BORRAR
//SI LO BORRAN, MUCHAS VISTAS DEJARÁN DE FUNCIONAR
//////////////////////////////////////////////////////
session_start();
$tokenValidar = array();
$idValidarprofe = array();

function isAdmin()
{   
    global $servername, $username, $password, $dbname;
    $con = mysqli_connect($servername, $username, $password, $dbname);
    

    //Consultar si existe token de usuario
    $statement = mysqli_prepare($con, "SELECT tokenSesion, id_usuario FROM usuario_prueba WHERE mail = ?");
    mysqli_stmt_bind_param($statement, "s", $_SESSION["mail"]);
    mysqli_stmt_execute($statement);

    mysqli_stmt_store_result($statement);
    mysqli_stmt_bind_result($statement, $tokenSesionp, $iduser);

    while (mysqli_stmt_fetch($statement)) {
        $idValidarprofe["profe"] = $iduser;
        $tokenValidar["tokenSesionp"] = $tokenSesionp;
    }

    //Consultar si es profe
    $statement = mysqli_prepare($con, "SELECT id_administrador FROM administrador WHERE id_usuario = ?");
    mysqli_stmt_bind_param($statement, "s", $idValidarprofe["profe"]);
    mysqli_stmt_execute($statement);

    mysqli_stmt_store_result($statement);
    mysqli_stmt_bind_result($statement, $idProfe);

    while (mysqli_stmt_fetch($statement)) {
        $existeProfe["profe"] = $idProfe;
    }

    if ($_SESSION["tokenSesion"] == $tokenValidar["tokenSesionp"] and $existeProfe["profe"] != "" and $tokenValidar["tokenSesionp"] != "") {
        return $existeProfe["profe"];
    } else {
        return "null";
    }
}


?>