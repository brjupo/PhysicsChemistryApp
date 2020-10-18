<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="shortcut icon" type="image/x-icon" href="../CSSsJSs/icons/pyramid.svg" />
    <title>Kaanbal</title>
    <link rel="stylesheet" href="../CSSsJSs/bootstrap441.css" />
    <script src="../CSSsJSs/minAJAX.js"></script>
</head>

<body>

    <?php
    
    try {
        // SDK de Mercado Pago
        //require '../../../../../../../vendor/autoload.php';
        include '../../../../../../vendor/autoload.php';
        // Agrega credenciales
        MercadoPago\SDK::setAccessToken('PROD_ACCESS_TOKEN');

        // Crea un objeto de preferencia
        $preference = new MercadoPago\Preference();

        // Crea un ítem en la preferencia
        $item = new MercadoPago\Item();
        $item->title = 'Licencia semestral Kaanbal [1 materia]';
        $item->quantity = 1;
        $item->unit_price = 10;
        $preference->items = array($item);
        $preference->save();
    } catch (Exception $e) {
        echo 'Caught exception: ',  $e->getMessage(), "\n";
    }
    
    ?>

<div class="container">
        <div class="row">
            <div class="textCenter col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <p><?php echo __DIR__; ?></p>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="textCenter col-1 col-sm-1 col-md-1 col-lg-1 col-xl-1"></div>
            <div class="textLeft col-5 col-sm-5 col-md-5 col-lg-5 col-xl-5">
                <p class="titulo" id="titulo">Kaanbal</p>
            </div>
            <div class="textRight col-5 col-sm-5 col-md-5 col-lg-5 col-xl-5"></div>
            <div class="textCenter col-1 col-sm-1 col-md-1 col-lg-1 col-xl-1"></div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="textCenter col-1 col-sm-1 col-md-1 col-lg-1 col-xl-1"></div>
            <div class="textCenter col-10 col-sm-10 col-md-10 col-lg-10 col-xl-10">
                <input type="text" id="token" value="<?php echo $tokenLink ?>" style="display:none;">

                <label for="correo_e">Ingresa tu usuario de staff</label>
                <input type="text" id="correo_e" name="correo_e">

                <label for="psw">Ingresa tu password de staff</label>
                <input type="text" id="psw" name="psw" />

                <label for="password2">Ingresa alumno Kaanbal</label>
                <input type="text" id="psw2" name="psw2" />

                <label for="password2">Correo de alumno a enviar contraseña</label>
                <input type="text" id="correoAlumno" name="psw2" />
                </form>
            </div>
            <div class="textCenter col-1 col-sm-1 col-md-1 col-lg-1 col-xl-1"></div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="textCenter col-2 col-sm-2 col-md-3 col-lg-3 col-xl-3"></div>
            <div class="textCenter col-8 col-sm-8 col-md-6 col-lg-6 col-xl-6">
                <button class="boton2" id="submit">
                    Submit
                </button>
            </div>
            <div class="textCenter col-2 col-sm-2 col-md-3 col-lg-3 col-xl-3"></div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="textCenter col-1 col-sm-1 col-md-1 col-lg-1 col-xl-1"></div>
            <div class="textCenter col-10 col-sm-10 col-md-10 col-lg-10 col-xl-10">
                <textarea type="text" id="respuesta" style="width:100%; height:150px; overflow:scroll"></textarea>
                </form>
            </div>
            <div class="textCenter col-1 col-sm-1 col-md-1 col-lg-1 col-xl-1"></div>
        </div>
    </div>


    <div class="container">
        <div class="row">
            <div class="textCenter col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <form action="/procesar-pago" method="POST">
                    <script src="https://www.mercadopago.com.mx/integrations/v1/web-payment-checkout.js" data-preference-id="<?php echo $preference->id; ?>">
                    </script>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="textCenter col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <p style="color:rgba(0,0,0,0)">.</p>
            </div>
        </div>
    </div>
</body>

</html>