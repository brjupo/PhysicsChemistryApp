<?php
   $con = mysqli_connect("localhost", "u526597556_dev", "1BLeeAgwq1*isgm&jBJe", "u526597556_kaanbal");	
    
//Validamos que los campos correo y password no lleguen vacios
      //if($correo == "" OR $password == ""){
		
		//Validar las variables de sesión
		
		 //}
    //else{
        
        //Traer todas las preguntas
        $query = "SELECT * FROM pregunta LIMIT 10"; //WHERE TEMA = 'TEMA' AND SUBTEMA = 'SUBTEMA' AND LECCION = 'LECCION'";     
        $result = mysqli_query($con,$query);
        
        //contar Numero de elementos
        $query2 = "Select count(*) FROM pregunta WHERE id_leccion = 1";// WHERE TEMA = 'TEMA' AND SUBTEMA = 'SUBTEMA' AND LECCION = 'LECCION'";
        $result2 = mysqli_query($con,$query2);
        //$total = mysqli_fetch_row($result2);
        $total = 10;
       
        //Recorrer el arreglo
        while ($row = mysqli_fetch_assoc($result)) {
        
                $array[] = $row;
                $arrayr[] = $row;
               
        }
        
       $respuestas=array('respuesta_correcta','respuesta2','respuesta3','respuesta4');
        $respuestasr=array('respuesta_correcta','respuesta2','respuesta3','respuesta4');
        
        //print_r ($array[0][$respuestas[0]]);
        //print_r ($arrayr);
        //print_r ($respuestas);
        //print_r ($total);
        
        for($j = 0; $j < $total; $j++) {
        $i = 0;
		  shuffle($respuestas);
		  		foreach ($respuestas as $val) {
            	//print_r ($val);
		  			$arrayr[$j][$respuestasr[$i]] = $array[$j][$val];
		  	 		//print_r ($i);
		  			$i = $i+1;
				}     
		}
		print_r ($arrayr); 
        
    //}

  //function imprimirTemas()
       
?>