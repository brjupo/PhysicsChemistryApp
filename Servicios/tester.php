<?php
$con = mysqli_connect("localhost", "u526597556_dev", "1BLeeAgwq1*isgm&jBJe", "u526597556_kaanbal");
//////////////////////////////////////////////////////
session_start();
$tokenValidar = array();
$idValidarprofe = array();

//Consultar si existe token de usuario
$statement = mysqli_prepare($con, "SELECT tokenSesion, id_usuario FROM usuario_prueba WHERE mail = ?");
mysqli_stmt_bind_param($statement, "s", $_SESSION["mail"]);
mysqli_stmt_execute($statement);

mysqli_stmt_store_result($statement);
mysqli_stmt_bind_result($statement, $tokenSesionp, $iduser);

while (mysqli_stmt_fetch($statement)) {
  $idValidarprofe["profe"] = $iduser;
  $tokenValidar["tokenSesionp"] = $tokenSesionp;
}

//Consultar si es profe
$statement = mysqli_prepare($con, "SELECT id_profesor FROM profesor WHERE id_usuario = ?");
mysqli_stmt_bind_param($statement, "s", $idValidarprofe["profe"]);
mysqli_stmt_execute($statement);

mysqli_stmt_store_result($statement);
mysqli_stmt_bind_result($statement, $idProfe);

while (mysqli_stmt_fetch($statement)) {
  $existeProfe["profe"] = $idProfe;
}

  if ($_SESSION["tokenSesion"] == $tokenValidar["tokenSesionp"] and $existeProfe["profe"] != "" and $tokenValidar["tokenSesionp"] != "") {

    /////////////////////////////////////////////TRAER INFO DE TEMAS
    $idAsignatura = 1;//$_GET['idAsignatura'];

    $statement = mysqli_prepare($con, "SELECT id_tema, nombre, orden FROM tema WHERE id_asignatura = ?");
    mysqli_stmt_execute($statement,"i", $idAsignatura);
    mysqli_stmt_execute($statement);
    
    mysqli_stmt_store_result($statement);
    mysqli_stmt_bind_result($statement, $id_tema, $nombre, $orden);

    $arregloTemas = array();
    $i = 0;
    while (mysqli_stmt_fetch($statement)) { 
      $arregloTemas[$i]["id_tema"] = $id_tema;
      $arregloTemas[$i]["nombre"] = $nombre;
      $arregloTemas[$i]["orden"] = $orden;
      $i = $i + 1;
    }

    $tamanho = count($arregloTemas);

    for ($i = 0; $i < $tamanho; $i++) {
      print_r($arregloTemas[$i]["id_tema"]);
      print_r($arregloTemas[$i]["nombre"]);
      print_r($arregloTemas[$i]["orden"]);
    }
  
  ///////////////////////////////////////////////////////////////////////////////////////////////

   /////////////////////////////////////////////TRAER INFO DE SUBTEMAS
   $idTema = 1;//$_GET['idTema'];
    
   $statement = mysqli_prepare($con, "SELECT id_subtema, nombre, orden FROM subtema WHERE id_tema = ?");
   mysqli_stmt_execute($statement,"i", $idTema);
   mysqli_stmt_execute($statement);
   
   mysqli_stmt_store_result($statement);
   mysqli_stmt_bind_result($statement, $id_subtema, $nombre, $orden);

   $arregloSubtemas = array();
   $i = 0;
   while (mysqli_stmt_fetch($statement)) { 
     $arregloSubtemas[$i]["id_subtema"] = $id_subtema;
     $arregloSubtemas[$i]["nombre"] = $nombre;
     $arregloSubtemas[$i]["orden"] = $orden;
     $i = $i + 1;
   }

   $tamanho = count($arregloSubtemas);

   for ($i = 0; $i < $tamanho; $i++) {
     print_r($arregloSubtemas[$i]["id_subtema"]);
     print_r($arregloSubtemas[$i]["nombre"]);
     print_r($arregloSubtemas[$i]["orden"]);
   }
 
 ///////////////////////////////////////////////////////////////////////////////////////////////
 /////////////////////////////////////////////TRAER INFO DE LECCIONES
 $idSubtema = 1;//$_GET['idSubtema'];
    
 $statement = mysqli_prepare($con, "SELECT id_leccion, nombre, orden FROM leccion WHERE id_subtema = ?");
 mysqli_stmt_execute($statement,"i", $idSubtema);
 mysqli_stmt_execute($statement);
 
 mysqli_stmt_store_result($statement);
 mysqli_stmt_bind_result($statement, $id_leccion, $nombre, $orden);

 $arregloLecciones = array();
 $i = 0;
 while (mysqli_stmt_fetch($statement)) { 
   $arregloLecciones[$i]["id_leccion"] = $id_leccion;
   $arregloLecciones[$i]["nombre"] = $nombre;
   $arregloLecciones[$i]["orden"] = $orden;
   $i = $i + 1;
 }

 $tamanho = count($arregloSubtemas);

 for ($i = 0; $i < $tamanho; $i++) {
   print_r($arregloLecciones[$i]["id_leccion"]);
   print_r($arregloLecciones[$i]["nombre"]);
   print_r($arregloLecciones[$i]["orden"]);
 }

///////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////TRAER INFO DE PREGUNTAS
$idLeccion= 1;//$_GET['idLeccion'];
    
$statement = mysqli_prepare($con, "SELECT id_pregunta, pregunta, orden FROM pregunta WHERE id_leccion = ?");
mysqli_stmt_execute($statement,"i", $idLeccion);
mysqli_stmt_execute($statement);

mysqli_stmt_store_result($statement);
mysqli_stmt_bind_result($statement, $id_pregunta, $pregunta, $orden);

$arregloPreguntas = array();
$i = 0;
while (mysqli_stmt_fetch($statement)) { 
  $arregloPreguntas[$i]["id_pregunta"] = $id_pregunta;
  $arregloPreguntas[$i]["pregunta"] = $pregunta;
  $arregloPreguntas[$i]["orden"] = $orden;
  $i = $i + 1;
}

$tamanho = count($arregloSubtemas);

for ($i = 0; $i < $tamanho; $i++) {
  print_r($arregloPreguntas[$i]["id_pregunta"]);
  print_r($arregloPreguntas[$i]["pregunta"]);
  print_r($arregloPreguntas[$i]["orden"]);
}

///////////////////////////////////////////////////////////////////////////////////////////////

}else{
  echo '<script type="text/javascript">
  alert("Inicie sesión");
  window.location.href="https://kaanbal.net";
  </script>';
}

?>
