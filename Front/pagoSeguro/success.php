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
  $url = 'https://api.mercadopago.com/v1/payments/search';
  $bearerToken = "TEST-6020404437225723-102416-8ff6df5eba994e44818f40c514eb2c1a-653962800";
  $data = array('id' => '1230976483');
  // use key 'http' even if you send the request to https://...
  $options = array(
    'http' => array(
      /*'header' => array(
        "Content-type: application/x-www-form-urlencoded\r\n",
        "Authorization: Bearer " . $bearerToken
      ),*/
      'method'  => 'GET',
      'content' => http_build_query($data)
    )
  );
  $context  = stream_context_create($options);
  $json = file_get_contents($url, false, $context);
  $result = json_decode($json, TRUE);
  //if (is_null($result["results"])) {
  //  echo "<h1>Error #1001. El servicio de Mercado Pago, NO está disponible por el momento. Intente más tarde</h1>";
  //} else {

  echo '<p> print_r options =  ';
  print_r($options);
  echo '</p>';

  echo '<p> print_r context =  ';
  print_r($context);
  echo '</p>';

  echo '<p> print_r json =  ';
  print_r($json);
  echo '</p>';

  echo '<p> print_r result =  ';
  print_r($result);
  echo '</p>';

  echo '<p> print_r result["results"]["payer"]["email"] =  ';
  print_r($result["results"]["payer"]["email"]);
  echo '</p>';

  echo '<p> print_r result["results"][0]["payer"]["email"] =  ';
  print_r($result["results"][0]["payer"]["email"]);
  echo '</p>';

  echo '<p> echo result["results"]["payer"]["email"] =  ';
  echo $result["results"]["payer"]["email"];
  echo '</p>';

  echo '<p> echo result["results"][0]["payer"]["email"] =  ';
  echo $result["results"][0]["payer"]["email"];
  echo '</p>';
  //}
  ?>

  <?php
  $url = 'https://kaanbal.net/DEV/Servicios/getSecondPart.php';
  $data = array('tokenHora' => 'Kn19aAe63rfSuvTy31f');
  // use key 'http' even if you send the request to https://...
  $options = array(
    'http' => array(
      'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
      'method'  => 'POST',
      'content' => http_build_query($data)
    )
  );
  $context  = stream_context_create($options);
  $json = file_get_contents($url, false, $context);
  $result = json_decode($json, TRUE);
  if (is_null($result["value"])) {
    echo "<h1>Error #1002. El servicio de Mercado Pago, NO está disponible por el momento. Intente más tarde</h1>";
  } else {
    $secondPart = hex2bin($result["value"]);
  }
  echo "<p>" . $secondPart . "</p>";
  echo '<p> print_r options =  ';
  print_r($options);
  echo '</p>';

  echo '<p> print_r context =  ';
  print_r($context);
  echo '</p>';

  echo '<p> print_r json =  ';
  print_r($json);
  echo '</p>';

  echo '<p> print_r result =  ';
  print_r($result);
  echo '</p>';
  ?>

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