<?php

/**
 * Valida si el usuario ya tiene algun registro en invoicing
 *
 * @param integer	$idUser  	ID del usuario
 * @param integer	$idSubject  ID de la asignatura/materia
 * 
 * @author brjupo	facebook.com/brjupo
 * @return integer ID INVOICING que relaciona el usuario y la asignatura, CERO 0 si no lo encuentra, Menos UNO -1 en caso de error
 */
function verifyInvoicingUserSubjectExist(int $idUser, int $idSubject): int
{
	global $servername, $dbname, $username, $password;
	$idInvoicingCustomer = 0;
	try {
		$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$stringQuery = "SELECT id FROM invoicing WHERE id_usuario = '" . $idUser . "' AND id_asignatura = '" . $idSubject . "' LIMIT 1";
		$stmt = $conn->query($stringQuery);
		while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$idInvoicingCustomer = $row[0];
		}
	} catch (PDOException $e) {
		return -1;
	}
	$conn = null;
	return intval($idInvoicingCustomer);
}

/**
 * Crea un nuevo registro en la tabla invoicing
 *
 * @param integer	$idUser  		ID del usuario
 * @param integer	$idSubject  	ID de la asignatura/materia
 * @param string	$rfc  			Vigencia de la licencia
 * @param string	$razonSocial	ID de pago de marcado pago
 * @param string	$status  		String del nuevo status de invoice (no_pagado, pagado_pendiente_por_facturar)
 * 
 * @author brjupo	facebook.com/brjupo
 * @return integer CERO 0 si la actualizacion fue correcta. MENOS UNO -1 Error id_invoicing_status. MENOS DOS -2 Error al crear
 */
function createInvoicingRegister(int $idUser, int $idSubject, string $rfc, string $razonSocial, string $status): int
{
	global $servername, $dbname, $username, $password;
	//Leer el valor INTEGER del status invoicing
	$idInvoicingStatus = 0;
	try {
		$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$stringQuery = "SELECT id FROM invoicing_status WHERE status = '" . $status . "' ";
		//echo $stringQuery ;
		$stmt = $conn->query($stringQuery);
		while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$idInvoicingStatus = $row[0];
		}
	} catch (PDOException $e) {
		return -1;
	}
	$conn = null;

	$cyphRfc = bin2hex($rfc);
	$cyphRazonSocial = bin2hex($razonSocial);
	try {
		$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
		// set the PDO error mode to exception
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$stringQuery = 'INSERT 
      INTO inoicing (id_usuario, id_asignatura, rfc, razon_social, id_status) 
      VALUES ( ' . $idUser . ', ' . $idSubject . ', "' . $cyphRfc . '", "' . $cyphRazonSocial . '", "' . $idInvoicingStatus . '" );';
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
 * Actualiza los datos del cliente, rfc y razon social
 *
 * @param integer	$idInvoicingCustomer  	ID INVOICING que relaciona el usuario y la asignatura
 * @param string	$rfc  					RFC del cliente
 * @param string	$razonSocial  			Razon social del cliente
 * 
 * @author brjupo	facebook.com/brjupo
 * @return integer CERO 0 si la actualizacion fue correcta. MENOS UNO -1 si existio un error al actualizar
 */
function updateInvoicingRfcRazonSocial(int $idInvoicingCustomer, string $rfc, string $razonSocial): int
{
	global $servername, $dbname, $username, $password;

	$cyphRfc = bin2hex($rfc);
	$cyphRazonSocial = bin2hex($razonSocial);
	try {
		$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
		// set the PDO error mode to exception
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$stringQuery = "UPDATE invoicing SET rfc = '" . $cyphRfc . "' , razon_social = '" . $cyphRazonSocial . "' WHERE id = '" . $idInvoicingCustomer . "' ";
		// use exec() because no results are returned
		$conn->exec($stringQuery);
	} catch (PDOException $e) {
		return -1;
	}
	$conn = null;
	return 0;
}

/**
 * Actualiza el estatus de la factura
 *
 * @param integer	$idInvoicingCustomer  	ID INVOICING que relaciona el usuario y la asignatura
 * @param string	$newStatus  			String del nuevo status de invoice (no_pagado, pagado_pendiente_por_facturar)
 * 
 * @author brjupo	facebook.com/brjupo
 * @return integer CERO 0 si la actualizacion fue correcta. MENOS UNO -1 si existio un error obteniendo el id del status. MENOS DOS -2 si existio un error al actualizar
 */
function updateInvoicingStatus(int $idInvoicingCustomer, string $newStatus): int
{
	global $servername, $dbname, $username, $password;
	//Leer el valor INTEGER del status invoicing
	$idInvoicingStatus = 0;
	try {
		$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$stringQuery = "SELECT id FROM invoicing_status WHERE status = '" . $newStatus . "' ";
		//echo $stringQuery ;
		$stmt = $conn->query($stringQuery);
		while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$idInvoicingStatus = $row[0];
		}
	} catch (PDOException $e) {
		return -1;
	}
	$conn = null;

	try {
		$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
		// set the PDO error mode to exception
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$stringQuery = "UPDATE invoicing SET id_status = '" . $idInvoicingStatus . "' WHERE id = '" . $idInvoicingCustomer . "' ";
		// use exec() because no results are returned
		$conn->exec($stringQuery);
	} catch (PDOException $e) {
		return -2;
	}
	$conn = null;
	return 0;
}
