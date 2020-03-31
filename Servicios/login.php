<?php
    $con = mysqli_connect("localhost", "u526597556_dev", "1BLeeAgwq1*isgm&jBJe", "u526597556_kaanbal");	
    
    $correo = $_POST["correo"];
    $password = $_POST["password"];
    
    if($correo == "" OR $password == ""){
        $response = array();
        $response['response'] = 'Inserte datos'; 
        
    echo json_encode($response);} 
    else{
    //declarar respuesta
    $response = array();
    $response['response'] = 'Usuario o contraseña inválida';//Si no existe el usuario 
    
    //consultar si existe usuario en tabla alumnos
    $statement = mysqli_prepare($con, "SELECT * FROM usuario_prueba WHERE mail = ? AND pswd = ?");
    mysqli_stmt_bind_param($statement, "ss", $correo, $password);
    mysqli_stmt_execute($statement);
    
    mysqli_stmt_store_result($statement);
    mysqli_stmt_bind_result($statement, $id_usuario, $mail, $pswd, $tokenA);
    
    
    while(mysqli_stmt_fetch($statement)){//si si existe el usuario
    
     //$im = file_get_contents("$foto",true);      
     //$imdata = base64_encode($im);
    
        $response['response'] = 'Sesion iniciada correctamente';  
        $response["id_usuario"] = $id_usuario;
        $response["mail"] = $mail;
        $response["pswd"] = $pswd;
        $response["tokenA"] = $tokenA;
        //$response["token"] = $token;
        //$response["token_a"] = $token_a;
        //$response["tokenp"] = $tokenp;
        //$response["tokenpp"] = $tokenpp;
        //$response["flag"] = $flag;
    }   
    
    
    echo json_encode($response);
    }
?>