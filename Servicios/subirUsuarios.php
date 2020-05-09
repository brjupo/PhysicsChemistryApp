<?php
use Phppot\DataSource;

require_once 'DataSource.php';
$db = new DataSource();
$conn = $db->getConnection();

if (isset($_POST["import"])) {
    $fileName = $_FILES["file"]["tmp_name"];
    if ($_FILES["file"]["size"] > 0) {
        
        $file = fopen($fileName, "r");
        
        while (($column = fgetcsv($file, 10000, ",")) !== FALSE) {    
            $mail = "";
            if (isset($column[0])) {
                $mail = mysqli_real_escape_string($conn, $column[0]);
            }
            $pswd = "";
            if (isset($column[1])) {
                $pswd = mysqli_real_escape_string($conn, $column[1]);
            }
            /*$password = "";
            if (isset($column[2])) {
                $password = mysqli_real_escape_string($conn, $column[2]);
            }
            $firstName = "";
            if (isset($column[3])) {
                $firstName = mysqli_real_escape_string($conn, $column[3]);
            }
            $lastName = "";
            if (isset($column[4])) {
                $lastName = mysqli_real_escape_string($conn, $column[4]);
            } */
            
            $sqlInsert = "INSERT into usuario_prueba (mail,pswd)
                   values (?,?)";
            $paramType = "ss";
            $paramArray = array(
                $mail,
                $pswd,
            );
            $insertId = $db->insert($sqlInsert, $paramType, $paramArray);
            
            if (! empty($insertId)) {
                $type = "success";
                $message = "CSV Data Imported into the Database";
            } else {
                $type = "error";
                $message = "Problem in Importing CSV Data";
            }
        }
    }
}
?>