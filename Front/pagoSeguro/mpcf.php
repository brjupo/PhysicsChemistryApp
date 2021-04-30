<?php
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++//
//++++++++++++++++++ Mercado pago CON factura PRUEBAS ++++++++++++++++++//
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++//
require "../CSSsJSs/mainCSSsJSs.php";
require "../../servicios/00DDBBVariables.php";
require "../../servicios/04paymentValidation.php";
require "../../servicios/06invoicingInformation.php";
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="shortcut icon" type="image/x-icon" href="../CSSsJSs/icons/pyramid.svg" />
  <title>Kaanbal</title>
  <link rel="stylesheet" href="../CSSsJSs/<?php echo $bootstrap441; ?>" />
  <link rel="stylesheet" href="../CSSsJSs/<?php echo $kaanbalEssentials; ?>" />
  <link rel="stylesheet" href="ml1.css" />
</head>

<body>
  <?php
  /*
  ---Idea general---
  Guardaremos la informacion del usuario con un estatus NO PAGADO.
  Al hacer el pago, deberemos validar si existe un registro (de rfc y razon social) del usuario. 
  En caso de que se encuentren los datos. Actualizar el rfc y razon social
  Se debe cambiar el status de la tabla invoicing a PAGADO - PENDIENTE POR FACTURAR, solo en caso de success
  */
  ?>
  <?php
  //1.- Tener la info del usuario y guardarla
  //1.1.- Obtener las variables de sesion y del POST. idUsuario, idAsignatura, Materia. rfc, razon social y correo
  //1.2.- Guardar en BBDD, Tabla invoicing > idUsuario, idAsignatura, rfc, razon social, id_status = 1 (NO PAGADO).
  ?>
  <?php
  // 2.- Crear las prefencias de MarketPay
  // 2.1.- Credenciales
  // 2.2.- Producto
  // 2.3.- Comprador
  // 2.4.- BackURLs
  ?>
  <?php
  //3.- Crear la vista con los datos de usuario, concepto, cantidad, precio unitario y BOTON DE MARKET PAY
  ?>
  <?php
  //1.1.- Obtener las variables de sesion y del POST. idUsuario, idAsignatura, Materia. rfc, razon social y correo
  //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++//
  //+++++++++++++++++++++++++ Variables de sesion ++++++++++++++++++++++++//
  //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++//
  session_start();
  $idUser = $_SESSION["id_usuario"];
  $materia = $_SESSION["asignaturaNavegacion"];
  $idAsignatura = $_SESSION["idAsignatura"];
  ?>
  <?php
  //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++//
  //+++++++++++++++++++++++++ Variables del POST ++++++++++++++++++++++++//
  //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++//
  $rfc = strtoupper($_POST["rfc"]);
  $razonSocial = strtoupper($_POST["razonSocial"]);
  $usuarioCorreo = strtolower($_POST["userMailWithInvoice"]);

  $rfc = str_replace(" ", "", $rfc);
  $usuarioCorreo = str_replace(" ", "", $usuarioCorreo);
  $errorDetected = 0;
  //1.2.- Validar si existe registro. Si NO existe, guardar en BBDD, Tabla invoicing > idUsuario, idAsignatura, rfc, razon social, status = "no_pagado". Si EXISTE actualizar RFC y razon social
  $idInvoicing = verifyInvoicingUserSubjectExist($idUser, $idAsignatura);
  if ($idInvoicing == 0) {
    $errorDetected = createInvoicingRegister($idUser, $idAsignatura, $rfc, $razonSocial, "no_pagado");
  } else if ($idInvoicing > 0) {
    $errorDetected = updateInvoicingRfcRazonSocial($idInvoicing, $rfc, $razonSocial);
  } else {
    $errorDetected = 1;
  }

  //echo '<p> Datos rfc=' . $rfc . '  razonSocial=' . $razonSocial . ' usuario=' . $usuarioCorreo . ' idUser=' . $idUser . '  materia=' . $materia . ' idAsignatura' . $idAsignatura . '</p>';
  ?>
  <?php
  if (is_null($rfc) || is_null($razonSocial) || is_null($usuarioCorreo) || is_null($materia) || $errorDetected != 0) {
    echo '<script  type="text/javascript"> 
    alert("Error. Por favor, verifica e inserta nuevamente tus datos
    rfc=' . $rfc . '  razonSocial=' . $razonSocial . '  
    usuario=' . $usuarioCorreo . '  materia=' . $materia . ' ");
    window.location = "../Inicio/perfil";
    </script>';
  } else {
    try {
      $json = getFirstPartMarketPayAccessToken();
      $result = json_decode($json, TRUE);
      $firstPart = hex2bin($result["value"]);

      $json = getSecondPartMarketPayAccessToken();
      $result = json_decode($json, TRUE);
      $secondPart = hex2bin($result["value"]);

      $accessToken = $firstPart . $secondPart;
      //echo "<p>".$accessToken."</p>";
      //$accessToken = "TEST-6020404437225723-102416-8ff6df5eba994e44818f40c514eb2c1a-653962800";


      //Precio de hoy
      $todayPrice = getTodayPrice();

      // SDK de Mercado Pago
      require '../../../../../../vendor/autoload.php';
      // Agrega credenciales
      MercadoPago\SDK::setAccessToken($accessToken);

      // Crea un objeto de preferencia
      $preference = new MercadoPago\Preference();

      // Crea un ítem en la preferencia
      $item = new MercadoPago\Item();
      $item->title = $idAsignatura . "@@" . $materia;
      $item->description = "Incluye el acceso a la plataforma kaanbal.net por 6 meses SIN publicidad";
      $item->quantity = 1;
      $item->currency_id = "MXN";
      $item->unit_price = $todayPrice;

      // Crear el comprador
      $payer = new MercadoPago\Payer();
      $payer->name = $razonSocial;                //Razón Social
      $payer->email = $usuarioCorreo;             //Usuario Correo
      $timeZone = new DateTimeZone('America/Mexico_City');
      $nowTime = new DateTime();
      $nowTime->setTimezone($timeZone);
      $payer->date_created = $nowTime->format('Y-m-d') . "T" . $nowTime->format('H:i:s.mP');
      //$payer->date_created = "2018-06-02T12:58:41.425-04:00";
      /*$payer->phone = array(                                //NO ES OBLIGATORIO, SE DESCARTA
        "number" => "55 1234 5678"
      );
      $payer->address = array(
        "street_name" => " Delegacion/municipio | idEstado",  //Delegacion/municipio | Estado | Pais==MEX
        "street_number" => 1234,                              //Numero
        "zip_code" => "05200 | Calle | Colonia"               //Codigo Postal | Calle | Colonia
      );*/


      //Redireccionamientos 
      $preference->back_urls = array(
        "success" => "https://www.kaanbal.net/dev/Front/pagoSeguro/p_success.php",
        "failure" => "https://www.kaanbal.net/dev/Front/pagoSeguro/p_failure.php",
        "pending" => "https://www.kaanbal.net/dev/Front/pagoSeguro/p_pending.php"
      );
      $preference->auto_return = "approved";


      // Guardar la preferencia con el item y el comprador
      $preference->items = array($item);
      $preference->payer = $payer;
      $preference->save();
    } catch (Exception $e) {
      echo '<p>Caught exception: ',  $e->getMessage(), "</p>";
    }
  }
  ?>

  <div class="container">
    <div class="row">
      <div class="text-center col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
        <p></p>
      </div>
    </div>
  </div>

  <div class="container">
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
      <div class="text-center col-1 col-sm-1 col-md-1 col-lg-1 col-xl-1"></div>
      <div class="text-center col-10 col-sm-10 col-md-10 col-lg-10 col-xl-10">
        <div class="input-group mb-3">
          <div class="input-group-prepend">
            <span class="input-group-text" id="usuarioLabel">Usuario</span>
          </div>
          <input type="text" class="form-control" id="usuario" aria-describedby="usuarioLabel" name="usuario" value="<?= $usuarioCorreo ?>" disabled />
        </div>

        <div class="input-group mb-3">
          <div class="input-group-prepend">
            <span class="input-group-text" id="conceptoLabel">Concepto</span>
          </div>
          <input type="text" class="form-control" id="concepto" aria-describedby="conceptoLabel" name="concepto" value="Licencia semestral Kaanbal - <?= $materia ?>" disabled />
        </div>

        <div class="input-group mb-3">
          <div class="input-group-prepend">
            <span class="input-group-text" id="cantidadLabel">Cantidad</span>
          </div>
          <input type="text" class="form-control" id="cantidad" aria-describedby="cantidadLabel" name="cantidad" value="1" disabled />
        </div>

        <div class="input-group mb-3">
          <div class="input-group-prepend">
            <span class="input-group-text" id="precioLabel">Precio Unitario [Incluye IVA]</span>
          </div>
          <input type="text" class="form-control" id="precio" aria-describedby="precioLabel" name="precio" value="<?= $todayPrice ?>.00 MXN" disabled />
        </div>
      </div>
      <div class="text-center col-1 col-sm-1 col-md-1 col-lg-1 col-xl-1"></div>
    </div>
  </div>

  <div class="container">
    <div class="row">
      <div class="text-center col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
        <p style="color: rgba(0, 0, 0, 1); background-color:rgba(255,255,0,0.8);">Revisa que el pago se haga con el correo que usas para inciar sesión en Kaanbal.<br> Si haces el pago con otro correo/cuenta NO se verá reflejado en tu licencia </p>
      </div>
    </div>
    <div class="row">
      <div class="text-center col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
        <p style="color: rgba(0, 0, 0, 0)">.</p>
      </div>
    </div>
  </div>
  <div class="container">
    <div class="row">
      <div class="col-4 col-sm-4 col-md-4 col-lg-4 col-xl-4">
        <img src="../CSSsJSs/images/mercadoPagoLogo.png" width="120px" style="display: block; margin: auto 0px auto auto" />
      </div>
      <div class="col-4 col-sm-4 col-md-4 col-lg-4 col-xl-4 buttonParent">
        <script src="https://www.mercadopago.com.mx/integrations/v1/web-payment-checkout.js" data-preference-id="<?php echo $preference->id; ?>">
        </script>
      </div>
      <div class="col-4 col-sm-4 col-md-4 col-lg-4 col-xl-4">
        <img src="../CSSsJSs/images/paypalLogo.png" width="120px" style="display: block; margin: auto auto auto 0px" />
      </div>
    </div>
    <div class="row">
      <div class="text-center col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
        <p style="color: rgba(0, 0, 0, 0)">.</p>
      </div>
    </div>
  </div>

  <div class="container">
    <div class="row">
      <div class="text-center col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
        <p style="color: rgba(0, 0, 0, 0)">.</p>
      </div>
    </div>
    <div class="row">
      <div class="text-center col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
        <p>Al finalizar tu pago, da clic en "Volver al sitio"</p>
      </div>
    </div>
  </div>

  <div class="container">
    <div class="row">
      <div class="text-center col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
        <p style="color: rgba(0, 0, 0, 0)">.</p>
      </div>
    </div>
    <div class="row">
      <div class="text-center col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
        <p style="color: rgba(0, 0, 0, 0)">.</p>
      </div>
    </div>
  </div>
  <div class="container">
    <div class="row">
      <div class="text-center col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
        <p style="color: rgba(0, 0, 0, 0)">.</p>
      </div>
    </div>
    <div class="row">
      <div class="text-center col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
        <p style="color: rgba(0, 0, 0, 0)">.</p>
      </div>
    </div>
  </div>
</body>

</html>