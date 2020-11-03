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
    echo '<h1>PEDNING</h1>';
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