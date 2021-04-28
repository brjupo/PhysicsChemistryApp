<?php
require "../../servicios/00DDBBVariables.php";
require "../../servicios/04paymentValidation.php";
require "../../servicios/06invoicingInformation.php";
require "../CSSsJSs/mainCSSsJSs.php";
require "sendMailCustomers.php";
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
</head>

<body>
  <?php
  //Si errorDetected=1, entonces los flujos o el flujo se detendrá informando el error
  $errorDetected = 0;
  ?>
  <?php
  //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++//
  //+++++++++++++++++++++++++ Variables de sesion ++++++++++++++++++++++++//
  //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++//

  // NO SE PUEDEN USAR. ALGO SUCEDE A LA HORA DE PAGAR EN MERCADO PAGO Y SE ELIMINAN POR COMPLETO

  ?>
  <?php
  //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++//
  //+++++++++++++++++++++++++ Variables del GET ++++++++++++++++++++++++//
  //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++//
  $paymentId = $_GET["payment_id"];
  $paymentId = str_replace(" ", "", $paymentId);
  if (!is_numeric($paymentId)) {
    $errorDetected = 1;
    echo '<p>Error line 40</p>';
  }
  ?>
  <?php
  if (is_null($paymentId)) {
    $errorDetected = 1;
    // echo '<p>Error line 40</p>';
  }
  ?>
  <?php
  //1.- Obtener el mail de la persona que realizó el pago y la asignatura
  //1.1.- Obtener el bearer token de mercado pago
  //1.2.- Lanzar una consulta al endpoint de mercado pago, usando curl y con el payment id
  //1.3.- Obtener el mail del comprador, del JSON, ["results"][0]["payer"]["email"]
  //1.4.- Obtener el idAsignatura de ["results"][0]["description"] idAsignatua@@nombreAsignatura
  ?>
  <?php
  //2.- Escribir en la base de datos que el mail ya pagó
  // 2.1.- Obtener el id_usuario(mail)
  // 2.2.- Obtener el id_asignatura() [Se obtuvo en el paso 1]
  // 2.3.- Agregar vigencia date(Now)+6meses
  // 2.4.- Obtener el payment id $_GET["payment_id"]
  // 2.5.- Dado que esta es la pantalla de success, y basados en la tabla payment_status, market_pay_status = 5 [approved]
  // 2.6.- INSERT/UPDATE INTO LICENCIA id_usuario, id_asignatura, vigencia, id_market_pay, market_pay_status
  //2.7.- En caso de que el cliente haya solicitado factura. Actualizar el status a "pagado_pendiente_por_facturar"
  ?>
  <?php
  //3.- Enviar correo a $verdaderoCliente con su payment_id y su vigencia
  // 3.1.- Usar el servicio 02sendMail.php
  // 3.2.- Crear el html del correo en una función hasta abajo de este archivo. enviarMailPagado
  // 3.3.- Para el caso de pending, preparar el webhook para enviar correo en caso de que el pago haya sido validado
  // 3.4.- Para el caso de failure, enviar correo solo como confirmación del error
  ?>
  <?php
  //1.- Obtener el mail de la persona que realizó el pago
  if ($errorDetected == 0) {
    $json = getFirstPartMarketPayAccessToken();
    $result = json_decode($json, TRUE);
    $firstPart = hex2bin($result["value"]);

    $json = getSecondPartMarketPayAccessToken();
    $result = json_decode($json, TRUE);
    $secondPart = hex2bin($result["value"]);

    $bearerToken = $firstPart . $secondPart;
    //$bearerToken = "TEST-6020404437225723-102416-8ff6df5eba994e44818f40c514eb2c1a-653962800";
    $url = 'https://api.mercadopago.com/v1/payments/search?id=' . $paymentId;
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, [
      'Authorization: Bearer ' . $bearerToken,
      'Content-Type: application/x-www-form-urlencoded'
    ]);
    $response = curl_exec($curl);
    curl_close($curl);
    // echo $response . PHP_EOL;
    $result = json_decode($response, TRUE);

    $verdaderoCliente = $result["results"][0]["payer"]["email"];
    // echo '<p> // echo result["results"][0]["payer"]["email"] =  ';
    // echo $verdaderoCliente;
    // echo '</p>';
    $idAsignaturaNombre = $result["results"][0]["description"];
    $idAsignaturaNombreArray = explode("@@", $idAsignaturaNombre);
    $idAsignatura = intval($idAsignaturaNombreArray[0]);
    // echo '<p> // echo result["results"][0]["description"] =  ';
    // echo $idAsignatura;
    // echo '</p>';
  }
  if (is_null($verdaderoCliente)) {
    $errorDetected = 1;
    // echo '<p>Error line 86</p>';
  }
  ?>
  <?php
  //2.- Escribir en la base de datos que el mail ya pagó

  //2.1.- Obtener el id_usuario(mail)
  $entre = 0;
  if ($errorDetected == 0) {
    try {
      // echo '<p>Entre al try del select id usuario</p>';
      $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $stringQuery = "SELECT id_usuario FROM usuario_prueba WHERE mail = '" . $verdaderoCliente . "' LIMIT 1";
      $stmt = $conn->query($stringQuery);
      while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
        $idVerdaderoCliente = $row[0];
        $entre = 1;
      }
    } catch (PDOException $e) {
      // echo "<p> Error linea 108: " . $e->getMessage() . "\n <br>" . $stringQuery . "</p>";
      $errorDetected = 1;
    }
    $conn = null;
    if ($entre == 0) {
      //id_usuario del usuario de brandon
      $idVerdaderoCliente = 4;
      // echo '<p>Id verdadero cliente será = 4</p>';
    }
  }
  //2.2.- Obtener el id_asignatura() [Se obtuvo en el paso 1]
  if (is_null($idAsignatura)) {
    $errorDetected = 1;
    // echo '<p>Error line 116</p>';
  }
  //2.3.- Agregar vigencia date(Now)+6meses
  // echo '<p>Inicio a calcular la vigencia</p>';
  $timeZone = new DateTimeZone('America/Mexico_City');
  $nowTimePlusSixMonths = new DateTime();
  $nowTimePlusSixMonths->modify('+6 month');
  $nowTimePlusSixMonths->setTimezone($timeZone);
  $vigencia = $nowTimePlusSixMonths->format('Y-m-d H:i:s');

  //2.4.- Obtener el payment id $_GET["payment_id"]
  //---------Listo en linea 36-----------

  //2.5.- Dado que esta es la pantalla de success. Y basadonos que en la tabla payment_status approved = 5. market_pay_status = 5 [approved]

  //2.6.- INSERT/UPDATE id_usuario, id_asignatura, vigencia, id_market_pay, market_pay_status
  if ($errorDetected == 0) {
    //Primero - Busca si ya existe un registro con el mismo usuario y la misma materia
    $idLicencia = verifyUserSubjectExist($idVerdaderoCliente, $idAsignatura);
    //Segundo - Si ya existe el registro. Actualizar el estado del apgo y la vigencia
    if ($idLicencia > 0) {
      $errorDetected = updatePaymentStatus($idLicencia, $vigencia, "approved");
    }
    //Tercero - Si NO existe el registro. Crearlo.
    else if ($idLicencia == 0) {
      $errorDetected = createPaymentStatus($idVerdaderoCliente, $idAsignatura, $vigencia, $paymentId, "approved");
    } else {
      $errorDetected = 1; //En este caso, verifyuserSubjectExist regresa un numero NEGATIVO, o bien, un ERROR
    }
  }
  //2.7.- En caso de que el cliente haya solicitado factura. Actualizar el status a "pagado_pendiente_por_facturar"
  $idInvoicing = verifyInvoicingUserSubjectExist($idVerdaderoCliente, $idAsignatura);
  if ($idInvoicing > 0) {
    $errorDetected = updateInvoicingStatus($idInvoicing, "pagado_pendiente_por_facturar");
  } else if ($idInvoicing == 0) {
    $errorDetected = 0;
  } else {
    $errorDetected = 1; //En este caso NO existe el usuario en factura o hubo un error.
  }
  ?>

  <?php
  //3.- Enviar correo a $verdaderoCliente con su payment_id y su vigencia
  // 3.1.- Usar el servicio 02sendMail.php
  // 3.2.- Crear el html del correo en una función hasta abajo de este archivo. enviarMailPagado
  if ($errorDetected == 0) {
    // echo '<p>Entre al envío del email</p>';
    enviarMail($verdaderoCliente, "Comprobante de pago Kaanbal", enviarMailPagado($verdaderoCliente, $paymentId));
  }
  // 3.3.- Para el caso de pending, preparar el webhook para enviar correo en caso de que el pago haya sido validado
  // 3.4.- Para el caso de failure, no enviar correo
  ?>

  <?php
  // Aun faltan MUCHOS detalles en el webhook de desarrollo
  ?>
  <?php if ($errorDetected == 0) { ?>
    <div class="container">
      <div class="row">
        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
          <p style="color: rgba(0, 0, 0, 0)">.</p>
        </div>
      </div>
      <div class="row">
        <div class="text-center col-1 col-sm-1 col-md-1 col-lg-1 col-xl-1"></div>
        <div class="textLeft col-5 col-sm-5 col-md-5 col-lg-5 col-xl-5">
          <p class="titulo">Kaanbal</p>
        </div>
        <div class="textRight col-5 col-sm-5 col-md-5 col-lg-5 col-xl-5"></div>
        <div class="text-center col-1 col-sm-1 col-md-1 col-lg-1 col-xl-1"></div>
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
    </div>

    <div class="container">
      <div class="row">
        <div class="text-center col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
          <p style="color: rgba(0, 0, 0, 0)">.</p>
        </div>
        <div class="text-center col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
          <p style="color: rgba(0, 0, 0, 0)">.</p>
        </div>
      </div>
    </div>
  <?php
  } else { ?>
    <p>Ha ocurrido un error. Inténtelo de nuevo más tarde</p>
  <?php
  } ?>

  <div class="container">
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
      <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
        <p class="text-center" style="color: rgba(0, 0, 0, 0)">.</p>
      </div>
    </div>
    <div class="row">
      <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
        <p class="text-center" style="color: rgba(0, 0, 0, 0)">.</p>
      </div>
    </div>
    <div class="row">
      <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
        <p class="text-center">Por favor inicia sesión de nuevo. Da clic en el siguiente link:</p>
      </div>
    </div>
    <div class="row">
      <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
        <p class="text-center" style="color: rgba(0, 0, 0, 0)">.</p>
      </div>
    </div>
    <div class="row">
      <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
        <a href="https://kaanbal.net">
          <p class="titulo text-center">Kaanbal</p>
        </a>
      </div>
    </div>
    <div class="row">
      <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
        <p class="text-center" style="color: rgba(0, 0, 0, 0)">.</p>
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
  // // echo '<h1>SUCCESS</h1>';
  // // echo '<p></p>';
  // // echo '<p>.</p>';
  // // echo '<p>POST payment id</p>';
  // // echo '<p>' . $paymentId . '</p>';
  // // echo '<p>.</p>';
  // // echo '<p>POST status</p>';
  // // echo '<p>' . $_GET["status"] . '</p>';
  // // echo '<p>.</p>';
  // // echo '<p>POST external reference</p>';
  // // echo '<p>' . $_GET["external_reference"] . '</p>';
  // // echo '<p>.</p>';
  // // echo '<p>POST merchant order id</p>';
  // // echo '<p>' . $_GET["merchant_order_id"] . '</p>';
  // // echo '<p>.</p>';
  // // echo '<p>.</p>';
  //

  ?>

</body>

</html>

<?php

function enviarMailPagado($mail, $paymentIdMail)
{
  return '
<html>
<head>
  <meta charset="ISO-8859-1">
</head>
  <body>
    <div style="background-color: rgb(35, 85, 145)" height="30px">
      <h4
        style="
          color: rgb(250, 250, 250);
          font-size: xx-large;
          margin: 20px auto 20px 10px;
          padding: 20px 10px 20px 10px;
        "
      >
        Kaanbal
      </h4>
    </div>

    <h3>¡Bienvenida(o) a Kaanbal!</h3>
    <h4>
      Has hecho una excelente decisión al comprar la
      <strong>Plataforma educativa Kaanbal</strong>
    </h4>
    <p>
      Ahora podrás practicar, reforzar y consolidar los conceptos vistos en
      clase de forma interactiva y lúdica
    </p>
    <p>Tu <strong>usuario</strong> es el correo:</p>
    <p>' . $mail . '</p>
    <p style="color: white">.</p>
    <p>
      Tu payment id es el siguiente:
    </p>
    <p style="color: white">.</p>
    <p style="font-size: x-large;">
     ' . $paymentIdMail . '
    </p>
    <p style="color: white">.</p>
    <p>
      Conservalo para cualquier aclaración
    </p>
    <p style="color: white">.</p>
    <p>En caso de cualquier duda o comentario por favor envía un mensaje a</p>
   
    <p>Correo: <a href="mailto:aclaraciones@kaanbal.net">aclaraciones@kaanbal.net</a></p>

    <p>WhatsApp: <strong>55 4871 4593</strong>.</p>
    <p style="color: white">.</p>
    <p>Agradecemos tu confianza,</p>
    <p>
      <strong>Equipo de Plataforma Educativa Kaanbal</strong>
    </p>
    <h4 style="background-color: rgb(35, 85, 145); color: rgb(35, 85, 145)">
      .
    </h4>
  </body>
</html>

    ';
}

?>