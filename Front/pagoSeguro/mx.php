<html>

<body>
    <?php
    $url = 'https://kaanbal.net/dev/servicios/getFirstPart.php';
    $data = array('tokenHora' => 'nda0913fTY673o84KJ');
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
        echo "<h1>Error #1001. El servicio de Mercado Pago, NO está disponible por el momento. Intente más tarde</h1>";
    }
    ?>


    <p><?php echo $url; ?></p>
    <p>.</p>
    <p>.</p>
    <p><?php echo $data; ?></p>
    <p>.</p>
    <p>.</p>
    <p><?php print_r($result); ?></p>
    <p>.</p>
    <p>.</p>
    <p><?php echo $result["value"]; ?></p>
</body>

</html>