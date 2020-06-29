<?php
$con = mysqli_connect("localhost", "u526597556_dev", "1BLeeAgwq1*isgm&jBJe", "u526597556_kaanbal");
//////////////////////////////////////////////////////
    date_default_timezone_set('-06:00');
    $sql = "INSERT into alumno_grupo (id_alumno,id_grupo,tiempo) values (13,9,NOW())";
    mysqli_multi_query($con, $sql);

?>
