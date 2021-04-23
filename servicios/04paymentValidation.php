<?php
require "00DDBBVariables.php";

session_start();

function licenciaPagada()
{
	global $servername, $dbname, $username, $password;
	//Leer el valor del id_usuario
	$correo = $_SESSION["mail"];
	$correo = strval($correo);
	$id_usuario = 0;
	try {
		$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$stringQuery = "SELECT id_usuario FROM usuario_prueba WHERE mail = '" . $correo . "' LIMIT 1";
		//echo $stringQuery ;
		$stmt = $conn->query($stringQuery);
		while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$id_usuario = $row[0];
		}
	} catch (PDOException $e) {
		echo $stringQuery . " Error: " . $e->getMessage();
	}
	$conn = null;

	//Leer el valor de pagado
	$pagado = 0;
	try {
		$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$stringQuery = "SELECT pagado FROM licencia WHERE id_usuario = " . $id_usuario . " AND id_asignatura = " . $_SESSION["idAsignatura"] . "";
		//echo $stringQuery ;
		$stmt = $conn->query($stringQuery);
		while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$pagado = $row[0];
		}
	} catch (PDOException $e) {
		echo $stringQuery . " Error: " . $e->getMessage();
	}
	$conn = null;

	return intval($pagado);
}
