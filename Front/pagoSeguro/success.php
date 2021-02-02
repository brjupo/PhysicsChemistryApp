<?php
require "../CSSsJSs/mainCSSsJSs.php";
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="shortcut icon" type="image/x-icon" href="../CSSsJSs/icons/pyramid.svg" />
  <title>Kaanbal - Payment Success</title>
  <link rel="stylesheet" href="../CSSsJSs/<?php echo $bootstrap441; ?>" />
  <link rel="stylesheet" href="../CSSsJSs/<?php echo $kaanbalEssentials; ?>" />
  <link rel="stylesheet" href="ml.css" />
</head>

<body>

  <?php
  //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++//
  //+++++++++++++++++++++++++ Variables de sesion ++++++++++++++++++++++++//
  //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++//
  session_start();
  $iduser = $_SESSION["id_usuario"];
  $materia = $_SESSION["asignaturaNavegacion"];
  $idAsignatura = $_SESSION["idAsignatura"];
  ?>
  <?php
  //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++//
  //+++++++++++++++++++++++++ Variables del GET ++++++++++++++++++++++++//
  //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++//
  $paymentId = $_GET["payment_id"]
  ?>
  <?php
  //1.- Obtener el mail de la persona que realizó el pago
  $bearerToken = "TEST-6020404437225723-102416-8ff6df5eba994e44818f40c514eb2c1a-653962800";
  $url = 'https://api.mercadopago.com/v1/payments/search?id=' . $_GET["payment_id"];
  $curl = curl_init($url);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($curl, CURLOPT_HTTPHEADER, [
    'Authorization: Bearer ' . $bearerToken,
    'Content-Type: application/x-www-form-urlencoded'
  ]);
  $response = curl_exec($curl);
  curl_close($curl);
  echo $response . PHP_EOL;
  $result = json_decode($response, TRUE);

  $verdaderoCliente = $result["results"][0]["payer"]["email"];
  echo '<p> echo result["results"][0]["payer"]["email"] =  ';
  echo $verdaderoCliente;
  echo '</p>';
  ?>
  <?php
  //2.- Escribir en la base de datos que el mail ya pagó
  /*
  2.1.- Obtener el id_usuario(mail)
  2.2.- Obtener el id_asignatura($_SESSION["idAsignatura"])
  2.3.- Agregar vigencia date(Now)+6meses
  2.4.- Obtener el payment id $_GET["payment_id"]
  2.5.- Dado que esta es la pantalla de success, y basados en la tabla payment_status, market_pay_status = 1 [SUCCESS]
  2.6.- INSERT id_usuario, id_asignatura, pagado = 1, vigencia, id_market_pay, market_pay_status
  */
  ?>
  <?php
  //3.- Enviar correo a $verdaderoCliente con su payment_id y su vigencia
  /*
  3.1.- Usar el servicio 02sendMail.php
  3.2.- Crear el html del correo en una función hasta abajo de este archivo. enviarMailPagado
  3.3.- Para el caso de pending, preparar el webhook para enviar correo en caso de que el pago haya sido validado
  3.4.- Para el caso de failure, no enviar correo
  */
  ?>
  <?php
  // Aun faltan MUCHOS detalles en el webhook de desarrollo
  ?>
  <div class="container">
    <div class="row">
      <div class="textCenter col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
        <p></p>
      </div>
    </div>
  </div>

  <div class="container">
    <div class="row">
      <div class="textCenter col-1 col-sm-1 col-md-1 col-lg-1 col-xl-1"></div>
      <div class="textLeft col-5 col-sm-5 col-md-5 col-lg-5 col-xl-5">
        <p class="titulo">Kaanbal</p>
      </div>
      <div class="textRight col-5 col-sm-5 col-md-5 col-lg-5 col-xl-5"></div>
      <div class="textCenter col-1 col-sm-1 col-md-1 col-lg-1 col-xl-1"></div>
    </div>
  </div>

  <div class="container">
    <div class="row">
      <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
        <p style="color: rgba(0, 0, 0, 0)">.</p>
      </div>
    </div>
  </div>

  <div class="container">
    <div class="row">
      <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
        <p style="color: rgba(0, 0, 0, 0)">.</p>
      </div>
    </div>
    <div class="row">
      <div class="col-1 col-sm-1 d-md-none"></div>
      <div class="col-10 col-sm-10 col-md-12 col-lg-12 col-xl-12" style="
            background-color: rgba(35, 85, 145, 0.9);
            color: white;
            border-radius: 1vw;
          ">
        <h1 class="text-center">Pago exitoso</h1>
        <p style="color: rgba(0, 0, 0, 0)">.</p>
        <p class="text-center" style="font-size: medium">
          ¡Felicidades!, a partir de ahora podrás disfrutar de todos los
          beneficios que te da Kaanbal
        </p>
        <p style="color: rgba(0, 0, 0, 0)">.</p>
        <p class="text-center" style="font-size: medium">
          Tu usuario es: <strong><?= $verdaderoCliente ?></strong>
        </p>
        <p style="color: rgba(0, 0, 0, 0)">.</p>
        <p class="text-center" style="font-size: medium">
          Tu "payment_id" es:
          <strong><?= $paymentId ?></strong>
        </p>
        <p style="color: rgba(0, 0, 0, 0)">.</p>
        <p class="text-center" style="font-size: medium">
          Es muy importante que conserves este "payment_id" para cualquier
          futura aclaración
        </p>
        <p style="color: rgba(0, 0, 0, 0)">.</p>
        <p class="text-center" style="font-size: medium">
          Te hemos enviado un correo con esta información
        </p>
      </div>
      <div class="col-1 col-sm-1 d-md-none"></div>
    </div>
    <div class="row">
      <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
        <p style="color: rgba(0, 0, 0, 0)">.</p>
        <p style="color: rgba(0, 0, 0, 0)">.</p>
        <p class="text-center" style="font-size: medium">
          Para cualquier duda o comentario, estamos para ayudarte:
        </p>
        <p style="color: rgba(0, 0, 0, 0)">.</p>
      </div>
      <div class="col-3 col-sm-3 col-md-2 col-lg-2 col-xl-2">
        <img width="30px" src="../CSSsJSs/icons/mailWB.svg" style="display: block; margin: auto 0px auto auto" />
      </div>
      <div class="col-9 col-sm-9 col-md-4 col-lg-4 col-xl-4">
        <p class="text-left">
          <strong>aclaraciones@kaanbal.net</strong>
        </p>
      </div>

      <div class="col-3 col-sm-3 col-md-2 col-lg-2 col-xl-2">
        <img width="30px" src="../CSSsJSs/icons/whatsappWB.svg" style="display: block; margin: auto 0px auto auto" />
      </div>
      <div class="col-9 col-sm-9 col-md-4 col-lg-4 col-xl-4">
        <p class="text-left"><strong>5548714593</strong></p>
      </div>
    </div>
  </div>

  <div class="container">
    <div class="row">
      <div class="textCenter col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
        <p style="color: rgba(0, 0, 0, 0)">.</p>
      </div>
      <div class="textCenter col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
        <p style="color: rgba(0, 0, 0, 0)">.</p>
      </div>
    </div>
  </div>



  <?php

  //https://www.kaanbal.net/DEV/Front/pagoSeguro/success.php?
  //collection_id=1230886475&
  //collection_status=approved&
  //payment_id=1230886475&    //123,088,647,5
  //status=approved&
  //external_reference=null&
  //payment_type=credit_card&
  //merchant_order_id=1938752476&
  //preference_id=653962800-5a37b421-4f37-4cd1-8784-93c79606ae9b&
  //site_id=MLM&
  //processing_mode=aggregator&
  //merchant_account_id=null
  echo '<h1>SUCCESS</h1>';
  echo '<p></p>';
  echo '<p>.</p>';
  echo '<p>POST payment id</p>';
  echo '<p>' . $_GET["payment_id"] . '</p>';
  echo '<p>.</p>';
  echo '<p>POST status</p>';
  echo '<p>' . $_GET["status"] . '</p>';
  echo '<p>.</p>';
  echo '<p>POST external reference</p>';
  echo '<p>' . $_GET["external_reference"] . '</p>';
  echo '<p>.</p>';
  echo '<p>POST merchant order id</p>';
  echo '<p>' . $_GET["merchant_order_id"] . '</p>';
  echo '<p>.</p>';
  echo '<p>.</p>';
  //

  ?>

</body>

</html>