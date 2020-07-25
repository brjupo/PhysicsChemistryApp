<?php
$con = mysqli_connect("localhost", "u526597556_dev", "1BLeeAgwq1*isgm&jBJe", "u526597556_kaanbal");
//////////////////////////////////////////////////////

    $tiempo = getDatetimeNow();
    $sql = "INSERT into alumno_grupo (id_alumno,id_grupo,tiempo) values (24,9,'$tiempo')";
    mysqli_multi_query($con, $sql);

    function getDatetimeNow() {
        $tz_object = new DateTimeZone('America/Mexico_City');
    
        $datetime = new DateTime();
        $datetime->setTimezone($tz_object);
        return $datetime->format('Y\-m\-d\ H:i:s');
    }

?>
