<?php

/**
 * Regresa el id del usuario 
 *
 * @param string	$mail	Correo del usuario
 * 
 * @author brjupo	facebook.com/brjupo
 * @return int		id del usuario o MENOS UNO -1 si no lo encuentra o existe un error	
 */
function getUserIdFromMail($mail): int
{
	global $servername, $dbname, $username, $password;
	//Leer el valor del mail
	//$bodytag = str_replace("%body%", "black", "<body text='%body%'>");
	$mail = str_replace(" ", "", $mail);
	$mail = strval($mail);
	$id_usuario = -1;
	try {
		$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$stringQuery = "SELECT id_usuario FROM usuario_prueba WHERE mail = '" . $mail . "' LIMIT 1";
		//echo $stringQuery ;
		$stmt = $conn->query($stringQuery);
		while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$id_usuario = $row[0];
		}
	} catch (PDOException $e) {
		return -1;
	}
	$conn = null;
	return intval($id_usuario);
}
