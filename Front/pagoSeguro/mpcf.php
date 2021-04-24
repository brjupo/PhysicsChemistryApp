<?php
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++//
//++++++++++++++++++ Mercado pago CON factura PRUEBAS ++++++++++++++++++//
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++//
require "../CSSsJSs/mainCSSsJSs.php";
require "../../servicios/00DDBBVariables.php";
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
  En caso de que se encuentren los datos. Obtener el registro mas reciente ORDER BY id DESC LIMIT 1
  Se debe cambiar el status de la tabla invoicing a PAGADO - PENDIENTE POR FACTURAR
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
  //1.2.- Guardar en BBDD, Tabla invoicing > idUsuario, idAsignatura, rfc, razon social, id_status = 1 (NO PAGADO).
  $errorDetected = saveCryptedInvoiceInfo($idUser, $idAsignatura, $rfc, $razonSocial, 1);

  echo '<p> Datos rfc=' . $rfc . '  razonSocial=' . $razonSocial . ' usuario=' . $usuarioCorreo . ' idUser=' . $idUser . '  materia=' . $materia . ' idAsignatura' . $idAsignatura . '</p>';
  ?>
  <?php
  if (is_null($rfc) || is_null($razonSocial) || is_null($usuarioCorreo) || is_null($materia) || $errorDetected == 1) {
    echo '<script  type="text/javascript"> 
    alert("Error. Por favor, verifica e inserta nuevamente tus datos
    rfc=' . $rfc . '  razonSocial=' . $razonSocial . '  
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
      $item->title = $idAsignatura . "@@" . $materia;
      $item->description = "Incluye el acceso a la plataforma kaanbal.net por 6 meses SIN publicidad";
      $item->quantity = 1;
      $item->currency_id = "MXN";
      $item->unit_price = 250;

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
      echo 'Caught exception: ',  $e->getMessage(), "\n";
    }
  }
  ?>
  <?php
  function saveCryptedInvoiceInfo($idUsuario, $idAsignatura, $rfc, $razonSocial, $idStatus)
  {
    //1.2.- Guardar en BBDD, Tabla invoicing > idUsuario, idAsignatura, rfc, razon social, id_status = 1 (NO PAGADO).
    global $servername, $dbname, $username, $password;
    $rfcCyph = bin2hex($rfc);
    $razonSocialCyph = bin2hex($razonSocial);
    try {
      $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
      // set the PDO error mode to exception
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      //INSERT INTO MyGuests (firstname, lastname, email) VALUES ('John', 'Doe', 'john@example.com')
      //UPDATE Customers SET ContactName = 'Alfred Schmidt', City= 'Frankfurt' WHERE CustomerID = 1
      $sql = "INSERT 
      INTO invoicing (id_usuario, id_asignatura, rfc, razon_social, id_status) 
      VALUES ('" . $idUsuario . "', '" . $idAsignatura . "', '" . $rfcCyph . "', '" . $razonSocialCyph . "', " . $idStatus . ")";
      // use exec() because no results are returned
      $conn->exec($sql);
      $errorDetected = 0;
    } catch (PDOException $e) {
      echo "<p>" . $sql . "<br>" . $e->getMessage() . "</p>";
      $errorDetected = 1;
    }
    $conn = null;
    return $errorDetected;
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
      <div class="text-center col-10 col-sm-10 col-md-10 col-lg-10 col-xl-10 input-group mb-3">
        <div class="input-group-prepend">
          <span class="input-group-text" id="usuarioLabel">Usuario</span>
        </div>
        <input type="text" class="form-control" id="usuario" aria-describedby="usuarioLabel"  name="usuario" value="<?= $usuarioCorreo ?>" disabled />


        

        <label for="Usuario">Usuario</label>
        <input type="text" id="Usuario" name="Usuario" value="<?= $usuarioCorreo ?>" disabled />

        <label for="Concepto">Concepto</label>
        <input type="text" id="Concepto" name="Concepto" value=" Licencia semestral Kaanbal - <?= $materia ?>" disabled />

        <label for="Cantidad">Cantidad</label>
        <input type="text" id="Cantidad" name="Cantidad" value="1" disabled />

        <label for="Precio">Precio Unitario [Incluye IVA]</label>
        <input type="text" id="PrecioU" name="PrecioU" value="250.00 MXN" disabled />
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