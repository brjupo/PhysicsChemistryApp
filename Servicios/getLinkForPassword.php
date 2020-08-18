<?php
require "DDBBVariables.php";

$usuario = $_POST["usuario"];
$color = $_POST["color"];
$kaanbalUser = $_POST["kaanbalUser"];



// 

//Crear la lectura en base de datos
$id_usuario = 0;
$response["response"] = 'Error desconocido';
//Leemos el id de usuario
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stringQuery = "SELECT id_usuario FROM usuario_prueba WHERE mail = '" . $usuario . "' AND pswd = '" . $color . "'  LIMIT 1;";
    $stmt = $conn->query($stringQuery);
    while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
        $id_usuario = intval($row[0]);
    }
} catch (PDOException $e) {
    $response["response"] = "Error: " . $e->getMessage();
}
$conn = null;

if ($id_usuario === 0) {
    $response["response"] = 'El usuario NO existe';
} else {
    //Leemos si esta en la tabla de staff
    $id_staff = 0;
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stringQuery = "SELECT id_staff FROM staff WHERE id_usuario = '" . $id_usuario . "' LIMIT 1;";
        $stmt = $conn->query($stringQuery);
        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $id_staff = intval($row[0]);
        }
    } catch (PDOException $e) {
        $response["response"] = "Error: " . $e->getMessage();
    }
    $conn = null;
    if ($id_staff === 0) {
        $response["response"] = 'El usuario NO existe en staff';
    } else {
        //Leemos si tiene un tokenA de contrasenia
        $token = "0";
        try {
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stringQuery = "SELECT tokenA FROM usuario_prueba WHERE mail = '" . $kaanbalUser . "' LIMIT 1;";
            $stmt = $conn->query($stringQuery);
            while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
                $token = intval($row[0]);
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
        $conn = null;
        if ($token == "0") {
            //Escribe en la base de datos un token aleatorio
            $rand = bin2hex(random_bytes(5));
            //Agregar a la base de datos
            //Crear la escritura en base de datos
            try {
                $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                // set the PDO error mode to exception
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $sql = "UPDATE usuario_prueba SET  tokenA = '$rand' WHERE mail = '$kaanbalUser'";
                // use exec() because no results are returned
                $conn->exec($sql);
                $response["response"] = "En la siguiente liga, el usuario podrá crear su contraseña
                 https://kaanbal.net/Front/errorInfoPages/password.php?token=" . $rand . "&correo=" . $kaanbalUser;
            } catch (PDOException $e) {
                $response["response"] = "<br>" . $e->getMessage();
            }

            $conn = null;
        } else {
            $response["response"] = "En la siguiente liga, el usuario podrá crear su contraseña
                 https://kaanbal.net/Front/errorInfoPages/password.php?token=" . $token . "&correo=" . $kaanbalUser;
                
        }
    }
}

////////////////    
echo json_encode($response);
