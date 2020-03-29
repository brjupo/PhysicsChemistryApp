<?php

$createdQuery = "SELECT id_usuario, mail, pswd, tokenA FROM usuario_prueba WHERE mail='" . $correo_e . "' AND tokenA = '" . $tokenLink . "' LIMIT 1;";
echo $createdQuery . "</p>";
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $conn->query($createdQuery);
    while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
        echo $row[1];
    }
} catch (PDOException $e) {
    //echo "Error: " . $e->getMessage();
    echo "Error";
}
$conn = null;
