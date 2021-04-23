<?php
// $_SESSION["leccionModoAnuncio"] = $leccion . "-" . "practica";
function validateOrigin($leccion, $modo)
{
  if (isset($_SESSION["leccionModoAnuncio"])) {
    $leccionModoAnuncio = $_SESSION["leccionModoAnuncio"];
    if (is_null($leccionModoAnuncio) || $leccionModoAnuncio == "") {
      regresarVerAnuncio($leccion, $modo);
    }
    try {
      $arreglo = explode("-", $leccionModoAnuncio);
      $leccionVarSesionActual =  $arreglo[0];
      $modoVarSesionActual = $arreglo[1];
      if ($leccionVarSesionActual != $leccion || $modoVarSesionActual != $modo) {
        regresarVerAnuncio($leccion, $modo);
      }
    } catch (Exception $e) {
      //echo '<p>Caught exception: ' .  $e->getMessage() . "</p>";
      //regresarVerAnuncio($leccion, "practica");
      echo '<script type="text/javascript">
              window.location.href="https://kaanbal.net";
            </script>';
    }
  } else {
    regresarVerAnuncio($leccion, $modo);
  }
}

function regresarVerAnuncio($leccion, $modo)
{
  echo '<script type="text/javascript">
      window.location.href="pre-' . $modo . '.php?leccion=' . $leccion . '";
  </script>';
}

//Variable para garantizar que vean la publicidad
//$_SESSION["leccionModoAnuncio"] = "";
