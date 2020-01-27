<?php

    header("Access-Control-Allow-Origin: *"); 
    header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
    $url_envio = "localhost";
    $con = mysqli_connect($url_envio, "id12195247_brjupo_educapp", "Brajuapon1$", "id12195247_educappv1");
    if(!$con){
      echo "Error al intentarse conectar";
    }
    else{
      echo "Conexión exitosa";
    }

    
    $name = $_POST["name"];
    $correo = $_POST["username"];
    $password = $_POST["password"];
    
    //Corroborar que no existe el correo en base de datos
    $sql = "SELECT mail FROM usereducapp WHERE mail = '$correo'";
    $resultp = mysqli_query($con,$sql);
    $rowp = mysqli_fetch_array($resultp);
    

    if($rowp){
    //Si existe regresar false
            $response = array();
            $response["success"] = false;  
    
            echo json_encode($response);
    }else{     
        
        $cuerpo = "Password: " . $password;
        mail($correo,"Confirmacion de Registro",$cuerpo);
    //Si no existe registrar en base de datos y responder true
          $sql = "INSERT INTO usereducapp (name, mail, password) VALUES ('$name', '$correo', '$password')";
          mysqli_query($con,$sql);

          if($name == ""){
         $response = array();
         $response["success"] = false; 
         
         echo json_encode($response);   
        }else{
          $response = array();
            $response["success"] = true;  
    
            echo json_encode($response);

         }
    }
      
?>