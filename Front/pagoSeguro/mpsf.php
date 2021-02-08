<?php
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
  $usuarioCorreo = $_POST["userMailNoInvoice"];
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
      // SDK de Mercado Pago
      require '../../../../../../vendor/autoload.php';
      // Agrega credenciales
      MercadoPago\SDK::setAccessToken("TEST-6020404437225723-102416-8ff6df5eba994e44818f40c514eb2c1a-653962800");

      // Crea un objeto de preferencia
      $preference = new MercadoPago\Preference();

      // Crea un ítem en la preferencia
      $item = new MercadoPago\Item();
      $item->id = "1";
      $item->title = "Licencia semestral Kaanbal [1 materia]";
      $item->description = "Incluye el acceso a la plataforma y la posibilidad de inscribirte a un grupo para que los profesores puedan acceder a tus calificaciones";
      $item->quantity = 1;
      $item->currency_id = "MXN";
      $item->unit_price = 250;

      // Crear el comprador
      $payer = new MercadoPago\Payer();
      $payer->name = "Nombre";                    //RFC
      $payer->surname = "Apellido";               //Razón Social
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
        "success" => "https://www.kaanbal.net/dev/Front/pagoSeguro/success.php",
        "failure" => "https://www.kaanbal.net/dev/Front/pagoSeguro/failure.php",
        "pending" => "https://www.kaanbal.net/dev/Front/pagoSeguro/pending.php"
      );
      $preference->auto_return = "approved";


      // Guardar la preferencia con el item y el comprador
      $preference->items = array($item);
      $preference->payer = $payer;
      $preference->save();
    } catch (Exception $e) {
      echo 'Caught exception: ',  $e->getMessage(), "\n";
    }
  }
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
      <div class="textCenter col-1 col-sm-1 col-md-1 col-lg-1 col-xl-1"></div>
      <div class="textCenter col-10 col-sm-10 col-md-10 col-lg-10 col-xl-10">
        <label for="Usuario">Usuario</label>
        <input type="text" id="Usuario" name="Usuario" value="<?= $usuarioCorreo ?>" disabled />

        <label for="Concepto">Concepto</label>
        <input type="text" id="Concepto" name="Concepto" value=" Licencia semestral Kaanbal - <?= $materia ?>" disabled />

        <label for="Cantidad">Cantidad</label>
        <input type="text" id="Cantidad" name="Cantidad" value="1" disabled />

        <label for="Precio">Precio Unitario [Incluye IVA]</label>
        <input type="text" id="PrecioU" name="PrecioU" value="250.00 MXN" disabled />
      </div>
      <div class="textCenter col-1 col-sm-1 col-md-1 col-lg-1 col-xl-1"></div>
    </div>
  </div>

  <div class="container">
    <div class="row">
      <div class="textCenter col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
        <p style="color: rgba(0, 0, 0, 0)">.</p>
      </div>
    </div>
    <div class="row">
      <div class="textCenter col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
        <p style="color: rgba(0, 0, 0, 0)">.</p>
      </div>
    </div>
  </div>
  <div class="container">
    <div class="row">
      <div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6">
        <img src="../CSSsJSs/images/mercadoPagoLogo.png" width="120px" style="display: block; margin: auto 0px auto auto" />
      </div>
      <div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6">
        <form action="/procesar-pago" method="POST">
          <script src="https://www.mercadopago.com.mx/integrations/v1/web-payment-checkout.js" data-preference-id="<?php echo $preference->id; ?>"></script>
        </form>
      </div>
    </div>
    <div class="row">
      <div class="textCenter col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
        <p style="color: rgba(0, 0, 0, 0)">.</p>
      </div>
    </div>
  </div>

  <div class="container">
    <div class="row">
      <div class="textCenter col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
        <p style="color: rgba(0, 0, 0, 0)">.</p>
      </div>
    </div>
    <div class="row">
      <div class="textCenter col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
        <p style="color: rgba(0, 0, 0, 0)">.</p>
      </div>
    </div>
  </div>
  <div class="container">
    <div class="row">
      <div class="textCenter col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
        <p style="color: rgba(0, 0, 0, 0)">.</p>
      </div>
    </div>
    <div class="row">
      <div class="textCenter col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
        <p style="color: rgba(0, 0, 0, 0)">.</p>
      </div>
    </div>
  </div>
</body>

</html>