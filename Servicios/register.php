<?php
    $con = mysqli_connect("localhost", "u526597556_dev", "1BLeeAgwq1*isgm&jBJe", "u526597556_kaanbal");

    
    //$name = $_POST["name"];
    $correo = $_POST["correo"];
    $password = $_POST["password"];
    
    //Corroborar que no existe el correo en base de datos
    $sql = "SELECT mail FROM user WHERE mail = '$correo'";
    $resultp = mysqli_query($con,$sql);
    $rowp = mysqli_fetch_array($resultp);
    
    if($rowp){
        

    //Si existe registrar contraseña en base de datos y responder true
          $sql = "INSERT INTO user (name, mail, password) VALUES ('$name', '$correo', '$password')";
          mysqli_query($con,$sql);

        //Enviar mail
        $cuerpo = "Password: " . $password;
        mail($correo,"Confirmacion de Registro",$cuerpo);


          if($name == ""){
         $response = array();
         $response['response'] = 'Sin nombre'; 
         
         echo json_encode($response); 
           
        }else{
          $response = array();
            $response['response'] = 'true';  
    
            echo json_encode($response);

         }
    
    }else{    
        
        //Si no existe regresar false
        $response = array();
        $response['response'] = 'El usuario no existe';  

        echo json_encode($response);
    
    }
      
?>