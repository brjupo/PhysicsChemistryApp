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



/**
 * Regresa el tiempo de la zona DateTimeZone('America/Mexico_City') actual MAS SEIS MESES
 *
 * 
 * @author brjupo	facebook.com/brjupo
 * @return string		Tiempo actual de Mexico mas seis meses	
 */
function getNowMexicoTimePlusSixMonths(): string
{
	$timeZone = new DateTimeZone('America/Mexico_City');
	$nowTimePlusSixMonths = new DateTime();
	$nowTimePlusSixMonths->modify('+6 month');
	$nowTimePlusSixMonths->setTimezone($timeZone);
	$vigencia = $nowTimePlusSixMonths->format('Y-m-d H:i:s');
	return $vigencia;
}

/**
 * Regresa el tiempo de la zona DateTimeZone('America/Mexico_City') actual 
 *
 * 
 * @author brjupo	facebook.com/brjupo
 * @return string	Tiempo actual de Mexico 	
 */
function getNowMexicoTime(): string
{
	$timeZone = new DateTimeZone('America/Mexico_City');
	$nowTime = new DateTime();
	$nowTime->setTimezone($timeZone);
	$now = $nowTime->format('Y-m-d H:i:s');
	return $now;
}