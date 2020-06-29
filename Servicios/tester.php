<?php
$con = mysqli_connect("localhost", "u526597556_dev", "1BLeeAgwq1*isgm&jBJe", "u526597556_kaanbal");
//////////////////////////////////////////////////////
    $sql = "INSERT into alumno_grupo (id_alumno,id_grupo,tiempo) values (15,9,(NOW()+8))";
    mysqli_multi_query($con, $sql);

?>
