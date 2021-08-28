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
	//0.- Colocar variables de prueba, en caso de error mostrar anuncion Kaanbal
	//1.- Contar, cuantos anuncios tenemos que venzan despues de AHORA, expired_date > Date()
	//2.- Numeo aleatorio = rand(1,total)
	//3.- Seleccionar la informacion del registro en la posicion LIMIT(random, 1)
	//4.- Recuerda transformar la fecha de vencimiento de UTC a America/Mexico_City
	$arreglo = array();
	$arreglo["id"] = "Error";
	$arreglo["link"] = "https://kaanbal.net/prod/Front/Inicio/perfil.php";
	$arreglo["image_url"] = "https://kaanbal.net/prod/Front/CSSsJSs/icons/quet.svg";
	$arreglo["title"] = "Por una educación innovadora y gratuita para todos";
	$arreglo["expired_date"] = "";
	$cantidad = 1;

	//1.- Contar, cuantos anuncios tenemos que venzan despues de AHORA, expired_date > Date()
	$nowDate = new DateTime();
	$nowDate->setTimezone(new DateTimeZone('UTC'));

	try {
		$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$stringQuery = "SELECT COUNT(*) FROM amazon_products WHERE expired_date > '" . $nowDate->format('Y-m-d H:i:s') . "'; ";
		$stmt = $conn->query($stringQuery);
		while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$cantidad = $row[0];
		}
	} catch (PDOException $e) {
		return $arreglo;
	}
	$conn = null;

	//2.- Numeo aleatorio = rand(1,total)
	$numero_aleatorio = rand(1, $cantidad);

	//3.- Seleccionar la informacion del registro en la posicion LIMIT(random, 1)
	try {
		$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$stringQuery = "SELECT id, link, image_url, title FROM amazon_products WHERE expired_date > '" . $nowDate->format('Y-m-d H:i:s') . "' LIMIT " . $numero_aleatorio . ",1 ; ";
		$stmt = $conn->query($stringQuery);
		while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$arreglo["id"] = $row[0];
			$arreglo["link"] = $row[1];
			$arreglo["image_url"] = $row[2];
			$arreglo["title"] = $row[3];
			//4.- Recuerda transformar la fecha de vencimiento de UTC a America/Mexico_City
			$arreglo["expired_date"] = utcToMexicoDate($row[3]);
		}
	} catch (PDOException $e) {
		return $arreglo;
	}
	$conn = null;

	return $arreglo;
}
/**
 * Transforma un string de fecha UTC "yyyy-mm-dd hh:mm:ss" a America/Mexico_City "yyyy-mm-dd hh:mm:ss"
 *
 * 
 * @author brjupo	facebook.com/brjupo
 * @return string 	Regresa la fecha convertida a America/Mexico_City
 */
function utcToMexicoDate($fechaBBDD): string
{
	try {
		if ($fechaBBDD == "0000-00-00 00:00:00") {
			return "En curso";
		} else {
			$fechaBBDDMexico = new DateTime($fechaBBDD, new DateTimeZone('UTC'));
			$fechaBBDDMexico->setTimezone(new DateTimeZone('America/Mexico_City'));
			return $fechaBBDDMexico->format('d M, Y, h:i:s A');
		}
	} catch (Exception $e) {
		return "";
	}
}
