<?php
require "00DDBBVariables.php";
session_start();

/* ------------------------------------------------------------------- */
/* ------------------------------------------------------------------- */
/* ------------------------------------------------------------------- */
/* 
Tabla a la que impacta este archivo: LICENCIA

Funciones en este archivo
licenciaPagada() - INPUT > $_SESSION["mail"] + $_SESSION["idAsignatura"] - OUTPUT > status del pago
getFirstPartMarketPayAccessToken(): string
getSecondPartMarketPayAccessToken(): string
verifyUserSubjectExist(int $idUser, int $idSubject): int > OUTPUT ID de la licencia, 0 o -1 Error
updatePaymentStatus(int $idLicenseCustomer, string $validity, string $newStatus): int
createPaymentStatus(int $idUser, int $idSubject, string $validity, int $paymentId, string $status): int
*/

/* ------------------------------------------------------------------- */
/* ------------------------------------------------------------------- */
/* ------------------------------------------------------------------- */

/**
 * Regresa el string del status del pago de la licencia
 *
 * @param integer	$_SESSION["mail"]
 * @param integer	$_SESSION["idAsignatura"]
 * 
 * @author brjupo	facebook.com/brjupo
 * @return string	status del pago de la licencia (DESCONOCIDO, approved, pending, failure) 	
 */
function licenciaPagada(): string
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
		return "DESCONOCIDO";
	}
	$conn = null;

	//Leer el valor numerico del market_pay_status
	$marketPayStatusNumber = 0; //Colocarlo en cero significa DESCONOCIDO
	try {
		$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$stringQuery = "SELECT market_pay_status FROM licencia WHERE id_usuario = " . $id_usuario . " AND id_asignatura = " . $_SESSION["idAsignatura"] . "";
		//echo $stringQuery ;
		$stmt = $conn->query($stringQuery);
		while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$marketPayStatusNumber = $row[0];
		}
	} catch (PDOException $e) {
		return "DESCONOCIDO";
	}
	$conn = null;

	//Leer el valor string del market_pay_status
	$marketPayStatus = "DESCONOCIDO";
	try {
		$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$stringQuery = "SELECT payment_status FROM payment_status WHERE id_payment_status = " . $marketPayStatusNumber . " ";
		//echo $stringQuery ;
		$stmt = $conn->query($stringQuery);
		while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$marketPayStatus = $row[0];
		}
	} catch (PDOException $e) {
		return "DESCONOCIDO";
	}
	$conn = null;

	return strval($marketPayStatus);
}

/**
 * Regresa la primera parte del token de acceso de mercado pago.
 *
 * 
 * @author brjupo	facebook.com/brjupo
 * @return string	La primera parte del token de acceso de mercado pago.
 */
function getFirstPartMarketPayAccessToken(): string
{
	$url = 'https://kaanbal.net/dev/servicios/getFirstPart.php';
	$data = array('tokenHora' => 'nda0913fTY673o84KJ');
	// use key 'http' even if you send the request to https://...
	$options = array(
		'http' => array(
			'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
			'method'  => 'POST',
			'content' => http_build_query($data)
		)
	);
	$context  = stream_context_create($options);
	$json = file_get_contents($url, false, $context);
	return $json;
	//$result = json_decode($json, TRUE);
	//$firstPart = hex2bin($result["value"]);
}

/**
 * Regresa la segunda parte del token de acceso de mercado pago.
 *
 * 
 * @author brjupo	facebook.com/brjupo
 * @return string	La segunda parte del token de acceso de mercado pago.
 */
function getSecondPartMarketPayAccessToken(): string
{
	$url = 'https://kaanbal.net/dev/servicios/getSecondPart.php';
	$data = array('tokenHora' => 'Kn19aAe63rfSuvTy31f');
	// use key 'http' even if you send the request to https://...
	$options = array(
		'http' => array(
			'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
			'method'  => 'POST',
			'content' => http_build_query($data)
		)
	);
	$context  = stream_context_create($options);
	$json = file_get_contents($url, false, $context);

	return $json;
	//$result = json_decode($json, TRUE);
	//$secondPart = hex2bin($result["value"]);
}

/**
 * Valida si el usuario ya tiene algun registro en licencias. 
 *
 * @param integer	$idUser  	ID del usuario
 * @param integer	$idSubject  ID de la asignatura/materia
 * 
 * @author brjupo	facebook.com/brjupo
 * @return integer ID de la licencia que relaciona el usuario y la asignatura, CERO 0 si no lo encuentra, Menos UNO -1 en caso de error
 */
function verifyUserSubjectExist(int $idUser, int $idSubject): int
{
	global $servername, $dbname, $username, $password;
	$idLicenseCustomer = 0;
	try {
		$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$stringQuery = "SELECT id_licencia FROM licencia WHERE id_usuario = '" . $idUser . "' AND id_asignatura = '" . $idSubject . "' LIMIT 1";
		$stmt = $conn->query($stringQuery);
		while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$idLicenseCustomer = $row[0];
		}
	} catch (PDOException $e) {
		return -1;
	}
	$conn = null;
	return intval($idLicenseCustomer);
}


/**
 * Crea un nuevo registro en la tabla licencia
 *
 * @param integer	$idUser  	ID del usuario
 * @param integer	$idSubject  ID de la asignatura/materia
 * @param string	$validity  	Vigencia de la licencia
 * @param integer	$paymentId  ID de pago de marcado pago
 * @param string	$status  	String del nuevo status de pago (approved, pending, failure)
 * 
 * @author brjupo	facebook.com/brjupo
 * @return integer CERO 0 si la actualizacion fue correcta. MENOS UNO -1 si existio un error obteniendo el id_payment_status. MENOS DOS -2 si existio un error al crear
 */
function createPaymentStatus(int $idUser, int $idSubject, string $validity, int $paymentId, string $status): int
{
	global $servername, $dbname, $username, $password;
	//Leer el valor INTEGER del id_payment_status
	$id_payment_status = 0;
	try {
		$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$stringQuery = "SELECT id_payment_status FROM payment_status WHERE payment_status = '" . $status . "' ";
		//echo $stringQuery ;
		$stmt = $conn->query($stringQuery);
		while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$id_payment_status = $row[0];
		}
	} catch (PDOException $e) {
		return -1;
	}
	$conn = null;

	try {
		$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
		// set the PDO error mode to exception
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$stringQuery = 'INSERT 
      INTO licencia (id_usuario, id_asignatura, vigencia, id_market_pay, market_pay_status) 
      VALUES ( ' . $idUser . ', ' . $idSubject . ', "' . $validity . '", "' . $paymentId . '", "' . $id_payment_status . '" );';
		// echo '<p> El query enviado fue: ' . $stringQuery . '</p>';
		// use exec() because no results are returned
		$conn->exec($stringQuery);
	} catch (PDOException $e) {
		return -2;
	}
	$conn = null;
	return 0;
}

/**
 * Actualiza el estatus del pago 
 *
 * @param integer	$idLicenseCustomer  	ID de la licencia que relaciona el usuario y la asignatura
 * @param string	$validity  				Vigencia de la licencia
 * @param string	$newStatus  			String del nuevo status de pago (approved, pending, failure)
 * 
 * @author brjupo	facebook.com/brjupo
 * @return integer CERO 0 si la actualizacion fue correcta. MENOS UNO -1 si existio un error obteniendo el id_payment_status. MENOS DOS -2 si existio un error al actualizar
 */
function updatePaymentStatus(int $idLicenseCustomer, string $validity, string $newStatus): int
{
	global $servername, $dbname, $username, $password;
	//Leer el valor INTEGER del id_payment_status
	$id_payment_status = 0;
	try {
		$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$stringQuery = "SELECT id_payment_status FROM payment_status WHERE payment_status = '" . $newStatus . "' ";
		//echo $stringQuery ;
		$stmt = $conn->query($stringQuery);
		while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$id_payment_status = $row[0];
		}
	} catch (PDOException $e) {
		return -1;
	}
	$conn = null;

	try {
		$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
		// set the PDO error mode to exception
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$stringQuery = "UPDATE licencia SET market_pay_status = '" . $id_payment_status . "' , vigencia = '" . $validity . "' WHERE id_licencia = '" . $idLicenseCustomer . "' ";
		// use exec() because no results are returned
		$conn->exec($stringQuery);
	} catch (PDOException $e) {
		return -2;
	}
	$conn = null;
	return 0;
}
