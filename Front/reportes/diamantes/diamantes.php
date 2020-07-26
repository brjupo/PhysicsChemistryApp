<?php
require "../../../Servicios/DDBBVariables.php";
require "../../../Servicios/isTeacher.php";
$teacherID = isTeacher();
if ($teacherID == "null") {
    header('Location: https://kaanbal.net/');
    exit;
} else {
    printDiamonds($teacherID);
}
function printDiamonds($teacherID)
{
    echo '
    <!DOCTYPE html>
    <html>';
    //printHead();
    echo '<body>';
    echo '<p>'.$_POST["grupo"].'</p>';
    //printTitle();
    //printInstructions();
    //printCombos($teacherID);
    //printButtons();
    echo '
    </body>
    </html>';
}
