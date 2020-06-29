<?php
$con = mysqli_connect("localhost", "u526597556_dev", "1BLeeAgwq1*isgm&jBJe", "u526597556_kaanbal");
//////////////////////////////////////////////////////
    $date = date('Y-m-j H:i:s');
    $newDate = strtotime('-5 hour', strtotime($date));
    $sql = "INSERT into alumno_grupo (id_alumno,id_grupo,tiempo) values (22,9,'$newDate')";
    mysqli_multi_query($con, $sql);

?>
