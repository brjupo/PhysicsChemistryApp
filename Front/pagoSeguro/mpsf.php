<?php
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++//
//++++++++++++++++++ Mercado pago sin factura PRUEBAS ++++++++++++++++++//
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++//
require "../CSSsJSs/mainCSSsJSs.php";
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="shortcut icon" type="image/x-icon" href="../CSSsJSs/icons/pyramid.svg" />
  <title>Kaanbal</title>
  <link rel="stylesheet" href="../CSSsJSs/<?php echo $bootstrap441; ?>" />
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
  //+++++++++++++++++++++++++ Variables del POST ++++++++++++++++++++++++//
  //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++//
  $usuarioCorreo = strtolower($_POST["userMailNoInvoice"]);
  $usuarioCorreo = str_replace(" ", "", $usuarioCorreo);

  echo '<p> Datos  usuario=' . $usuarioCorreo . ' idUser=' . $iduser . '  materia=' . $materia . ' idAsignatura' . $idAsignatura . '</p>';
  ?>
  <?php
  if (is_null($usuarioCorreo) || is_null($materia)) {
    echo '<script>
    alert("Error. Por favor, verifica e inserta nuevamente tus datos 
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
      $accessToken = "TEST-6020404437225723-102416-8ff6df5eba994e44818f40c514eb2c1a-653962800";
      // SDK de Mercado Pago
      require '../../../../../../vendor/autoload.php';
      // Agrega credenciales
      MercadoPago\SDK::setAccessToken($accessToken);

      // Crea un objeto de preferencia
      $preference = new MercadoPago\Preference();

      // Crea un ítem en la preferencia
      $item = new MercadoPago\Item();
      $item->title = $idAsignatura . "@@" . $materia;
      $item->description = "Incluye el acceso a la plataforma y la posibilidad de inscribirte a un grupo para que los profesores puedan acceder a tus calificaciones";
      $item->quantity = 1;
      $item->currency_id = "MXN";
      $item->unit_price = 250;

      // Crear el comprador
      $payer = new MercadoPago\Payer();
      $payer->name = "Nombre";                    //Para con factura es Razón Social
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
          <input type="text" class="form-control" id="precio" aria-describedby="precioLabel" name="precio" value="250.00 MXN" disabled />
        </div>
      </div>
      <div class="text-center col-1 col-sm-1 col-md-1 col-lg-1 col-xl-1"></div>
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