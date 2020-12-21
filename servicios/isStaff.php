<?php
require "00DDBBVariables.php";
//---------------NO BORRAR
//SI LO BORRAN, MUCHAS VISTAS DEJARÁN DE FUNCIONAR
//////////////////////////////////////////////////////
session_start();
$tokenValidar = array();
$idValidarstaff = array();
$existestaff = array();

function isStaff()
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
        $idValidarstaff["staff"] = $iduser;
        $tokenValidar["tokenSesionp"] = $tokenSesionp;
    }

    //Consultar si es staff
    $statement = mysqli_prepare($con, "SELECT id_staff FROM staff WHERE id_usuario = ?");
    mysqli_stmt_bind_param($statement, "s", $idValidarstaff["staff"]);
    mysqli_stmt_execute($statement);

    mysqli_stmt_store_result($statement);
    mysqli_stmt_bind_result($statement, $idstaff);

    while (mysqli_stmt_fetch($statement)) {
        $existestaff["staff"] = $idstaff;
    }


    //if ($_SESSION["tokenSesion"] == $tokenValidar["tokenSesionp"] and $existestaff["staff"] != "" and $tokenValidar["tokenSesionp"] != "") {
    if ($existestaff["staff"] != "") {
        return $existestaff["staff"];
    } else {
        return "null";
    }
}


?>