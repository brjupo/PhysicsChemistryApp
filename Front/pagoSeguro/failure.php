<?php
require "../CSSsJSs/mainCSSsJSs.php";
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link
      rel="shortcut icon"
      type="image/x-icon"
      href="../CSSsJSs/icons/pyramid.svg"
    />
    <title>Kaanbal</title>
    <link rel="stylesheet" href="../CSSsJSs/<?php echo $bootstrap441;?>" />
    <link rel="stylesheet" href="ml.css" />
  </head>

  <body>
  <?php
  /*
  En caso de
  APRO: Pago aprobado.    Todo bien.
  CONT: Pago pendiente.   Informa que notificarán por correo si fue o no aprobado el pago
  OTHE: Rechazado por error general.                        "Tu tarjeta rechazo el pago" y te solicita reintentar con otro medio de pago
  CALL: Rechazado con validación para autorizar.            "Tu tarjeta no autorizó el pago" y te da la opción de autorizar el pago [llamando a tu banco] y itnentar con otro medio de pago
  FUND: Rechazado por monto insuficiente.                   "Fondos insuficientes" y te solicita reintentar con otro medio de pago
  SECU: Rechazado por código de seguridad inválido.         "Código de seguridad inválido" y te pide el código correcto
  EXPI: Rechazado por problema con la fecha de expiración.  "Fecha de expiración incorrecta" y te pide la fecha y el código al reverso
  FORM: Rechazado por error en formulario                   "Algún dato de la tarjeta en inválido" y te pide todo de nuevo
  */
    echo '<h1>FAILURE</h1>';
    echo '<p></p>';
    echo '<p>.</p>';
    echo '<p>POST payment id</p>';
    echo '<p>'.$_GET["payment_id"].'</p>';
    echo '<p>.</p>';
    echo '<p>POST status</p>';
    echo '<p>'.$_GET["status"].'</p>';
    echo '<p>.</p>';
    echo '<p>POST external reference</p>';
    echo '<p>'.$_GET["external_reference"].'</p>';
    echo '<p>.</p>';
    echo '<p>POST merchant order id</p>';
    echo '<p>'.$_GET["merchant_order_id"].'</p>';
    echo '<p>.</p>';
    echo '<p>.</p>';

    //
  ?>
  
  </body>

</html>