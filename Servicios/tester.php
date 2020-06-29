<?php
$con = mysqli_connect("localhost", "u526597556_dev", "1BLeeAgwq1*isgm&jBJe", "u526597556_kaanbal");
//////////////////////////////////////////////////////
    $sql = "SET time_zone = '-05:00'";
    mysqli_query($con, $sql);
    $sql = "INSERT into alumno_grupo (id_alumno,id_grupo,tiempo) values (11,9,NOW())";
    mysqli_query($con, $sql);

?>
