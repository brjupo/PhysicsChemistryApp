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