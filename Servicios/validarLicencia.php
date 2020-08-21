<?php

function validarLicencia($idL)
{
    $con = mysqli_connect("localhost", "u526597556_dev", "1BLeeAgwq1*isgm&jBJe", "u526597556_kaanbal");
    /////////id_lecciones traer id asignaturas licencias
    $statement = mysqli_prepare($con, "SELECT id_asignatura FROM licencia WHERE id_usuario = ?");
    mysqli_stmt_bind_param($statement, "s", $_SESSION["id_usuario"]);
    mysqli_stmt_execute($statement);
    mysqli_stmt_store_result($statement);
    mysqli_stmt_bind_result($statement, $id_asignatura);

    $arregloAsignaturas = array();

    $i = 0;
    while (mysqli_stmt_fetch($statement)) {
    $arregloAsignaturas[$i]["id_asignatura"] = $id_asignatura;
    $i = $i + 1;
    }

    $tamanhoArray = count($arregloAsignaturas);

     /* echo'<script type="text/javascript">
    alert("'.$tamanhoArray.'");
    </script>';  */

/////////////////
    $query = "SELECT id_subtema FROM leccion WHERE id_leccion = $idL";
    $result = mysqli_query($con, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        $subtema[] = $row;
    }
    $idSubtema = $subtema[0]["id_subtema"]; 

    /////////id_subtema trae id_tema
    $query = "SELECT id_tema FROM subtema WHERE id_subtema = $idSubtema";
    $result = mysqli_query($con, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        $tema[] = $row;
    }
    $idTema = $tema[0]["id_tema"]; 

    /////////id_tema tra id_asignatura
    $query = "SELECT id_asignatura FROM tema WHERE id_tema = $idTema";
    $result = mysqli_query($con, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        $asignatura[] = $row;
    }
    $idAsignatura = $asignatura[0]["id_asignatura"];

    $flag = 0;

    //for ($j = 0; $j < $tamanhoArray; $j++){ 
        if(in_array($idAsignatura,array_column($arregloAsignaturas, 'id_asignatura')))
        {$flag = 1;} 
    //}

    return $flag;
}
