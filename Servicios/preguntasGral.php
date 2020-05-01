<?php
    
    //$id_usuario = $_POST["id"];
    $idL= $_POST["idLeccion"];
    //$puntosNuevos = $_POST["puntos"];
    
    /* $tokenValidar = array();

    //Consultar si existe token de usuario
    $statement = mysqli_prepare($con, "SELECT tokenSesion FROM usuario_prueba WHERE mail = ?");
    mysqli_stmt_bind_param($statement, "s", $_SESSION["mail"]);
    mysqli_stmt_execute($statement);

    mysqli_stmt_store_result($statement);
    mysqli_stmt_bind_result($statement, $tokenSesionp);

    while (mysqli_stmt_fetch($statement)) {
        $tokenValidar["tokenSesionp"] = $tokenSesionp;
    } */


    //if ($tokenValidar) {

    $con = mysqli_connect("localhost", "u526597556_dev", "1BLeeAgwq1*isgm&jBJe", "u526597556_kaanbal");
    
        //Traer todas las preguntas
        $query = "SELECT * FROM pregunta WHERE id_leccion = $idL"; //AND id_pregunta <= 5221WHERE TEMA = 'TEMA' AND SUBTEMA = 'SUBTEMA' AND LECCION = 'LECCION'";     
        $result = mysqli_query($con, $query);
        //contar Numero de elementos
        $query2 = "SELECT count(*) FROM pregunta WHERE id_leccion = $idL"; // WHERE TEMA = 'TEMA' AND SUBTEMA = 'SUBTEMA' AND LECCION = 'LECCION'";
        $result2 = mysqli_query($con, $query2);
        $total = mysqli_fetch_row($result2);
        //$total = 10;
        //Recorrer el arreglo
        while ($row = mysqli_fetch_assoc($result)) {
            $array[] = $row;
            $arrayr[] = $row;
        }
        ///////////////////////////////SEPARANDO PREGUNTAS/////////////////////////////////////////
        ///////////////////////////////NO TOCAR PRROS/////////////////////////////////////////
        for ($j = 0; $j < $total[0]; $j++) {
            // AGREGAR RESPUESTA CORRECTA A ARRAY DE RETORNO
            $arrayr[$j]["patrona"] = $array[$j]["respuesta_correcta"];
            // CONVERTIR LA CADENA DE TEXTO EN UN ARRAY
            $arreglo = str_split($arrayr[$j]["pregunta"]);
            //print_r ($arreglo);
            // LEER CON BUCLE FOR EL ARREGLO HASTA ENCONTRAR GUION BAJO Y GUARDAR LA POSICION DONDE SE ENCUENTRE
            $posicion = 0;
            $tamanho = count($arreglo);
            for ($i = 0; $i < $tamanho - 2; $i++) {
                if ($arreglo[$i] == '_' && $arreglo[$i + 1] == '_' && $arreglo[$i + 2] == '_') {
                    $posicion = $i;
                    break;
                }
            }
            // PARTIR LA PREGUNTA EN 2 CADENAS, SI POSICION = 0, SIGNIFICA QUE LA PREGUNTA NO DEBE SER PARTIDA
            if ($posicion != 0) {
                $preguntaParte1 = substr($arrayr[$j]["pregunta"], 0, $posicion - 1);
                $preguntaParte2 = substr($arrayr[$j]["pregunta"], $posicion + 4, strlen($arrayr[$j]["pregunta"]));
            } else {
                $preguntaParte1 = $arrayr[$j]["pregunta"];
                $preguntaParte2 = "";
            }
            $arrayr[$j]["preguntaParte1"] = $preguntaParte1;
            $arrayr[$j]["preguntaParte2"] = $preguntaParte2;
        }
        //print_r ($arrayr);
        ////////////////////////////////////////////////////////////////////////////////////////////

        $respuestas = array('respuesta_correcta', 'respuesta2', 'respuesta3', 'respuesta4');
        $respuestasr = array('respuesta_correcta', 'respuesta2', 'respuesta3', 'respuesta4');
        for ($j = 0; $j < $total[0]; $j++) {
            $i = 0;
            shuffle($respuestas);
            foreach ($respuestas as $val) {
                //print_r ($val);
                $arrayr[$j][$respuestasr[$i]] = $array[$j][$val];
                //print_r ($i);
                $i = $i + 1;
            }
        }

        echo json_encode($arrayr); 
        //print_r($arrayr);
  /*   } else {
        //Si NO existe un token de sesion activo se redireccionara a pagina de inicio
        $response["response"] = 'fail';
        echo json_encode($response); 
    } */

        
?>