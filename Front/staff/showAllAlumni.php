<?php
require "../../Servicios/DDBBVariables.php";
require "../../Servicios/isAdmin.php";
$adminID = isAdmin();
if ($adminID == "null") {
  header('Location: https://kaanbal.net/');
  exit;
}
?>
