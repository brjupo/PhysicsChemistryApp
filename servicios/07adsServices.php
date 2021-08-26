<?php
require "00DDBBVariables.php";
session_start();

/* ------------------------------------------------------------------- */
/* ------------------------------------------------------------------- */
/* ------------------------------------------------------------------- */
/* 
Tabla a la que impacta este archivo: AMAZON_PRODUCTS

Funciones en este archivo
getRandomAd():array
*/

/* ------------------------------------------------------------------- */
/* ------------------------------------------------------------------- */
/* ------------------------------------------------------------------- */


/**
 * Regresa un arreglo que contiene la informacion del Ad. Esta Ad se obtuvo por un proceso aleatorio.
 * 
 * Regresa [id, link, image_url, title]
 *
 * 
 * @author brjupo	facebook.com/brjupo
 * @return array 	Regresa la informacion del Ad
 */
function getRandomAd(): array
{
	global $servername, $dbname, $username, $password;
	$arreglo = array();
	$arreglo["id"] = "Error";
	$arreglo["link"] = "https://kaanbal.net/prod/Front/Inicio/perfil.php";
	$arreglo["image_url"] = "https://kaanbal.net/prod/Front/CSSsJSs/icons/quet.svg";
	$arreglo["title"] = "Por una educación innovadora y gratuita para todos";
	$cantidad = 1;
	try {
		$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$stringQuery = "SELECT COUNT(id) FROM amazon_products";
		$stmt = $conn->query($stringQuery);
		while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$cantidad = $row[0];
		}
	} catch (PDOException $e) {
		return $arreglo;
	}
	$conn = null;

	$numero_aleatorio = rand(1, $cantidad);

	try {
		$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$stringQuery = "SELECT id, link, image_url, title FROM amazon_products WHERE id = " . $numero_aleatorio;
		$stmt = $conn->query($stringQuery);
		while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$arreglo["id"] = $row[0];
			$arreglo["link"] = $row[1];
			$arreglo["image_url"] = $row[2];
			$arreglo["title"] = $row[3];
		}
	} catch (PDOException $e) {
		return $arreglo;
	}
	$conn = null;
	
	return $arreglo;
}
