<?php
    $con = mysqli_connect("localhost", "u526597556_dev", "1BLeeAgwq1*isgm&jBJe", "u526597556_kaanbal");	
    
    $correo = $_POST["correo"];
    $password = $_POST["password"];
    
    //declarar respuesta
    $response = array();
    $response["success"] = false;//Si no existe el usuario 
    
    //consultar si existe usuario en tabla de pacientes
    $statement = mysqli_prepare($con, "SELECT * FROM user WHERE mail = ? AND password = ?");
    mysqli_stmt_bind_param($statement, "ss", $correo, $password);
    mysqli_stmt_execute($statement);
    
    mysqli_stmt_store_result($statement);
    mysqli_stmt_bind_result($statement, $userID, $name, $correo, $password, $alarma, $token, $token_a, $tokenp, $tokenpp, $flag);
    
    
    while(mysqli_stmt_fetch($statement)){//si si existe el usuario
    
     //$im = file_get_contents("$foto",true);      
     //$imdata = base64_encode($im);
    
        $response["success"] = true;  
        $response["iduser"] = $userID;
        $response["name"] = $name;
        $response["mail"] = $correo;
        $response["password"] = $password;
        $response["alarma"] = $alarma;
        $response["token"] = $token;
        $response["token_a"] = $token_a;
        $response["tokenp"] = $tokenp;
        $response["tokenpp"] = $tokenpp;
        $response["flag"] = $flag;
    }   
    
    
    echo json_encode($response);
