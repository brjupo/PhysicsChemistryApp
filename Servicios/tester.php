<?php
$con = mysqli_connect("localhost", "u526597556_dev", "1BLeeAgwq1*isgm&jBJe", "u526597556_kaanbal");
//////////////////////////////////////////////////////
    $sql = "INSERT into alumno_grupo (id_alumno,id_grupo,tiempo) values (10,9,(NOW()-5))";
    mysqli_query($con, $sql);

?>
