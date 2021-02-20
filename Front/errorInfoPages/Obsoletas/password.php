<?php
$tokenLink = htmlspecialchars($_GET['token']);
$correo_e  = htmlspecialchars($_GET['correo']);
if ($tokenLink == "" || $correo_e == "") {
  header('Location: https://kaanbal.net/');
  exit;
}
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="shortcut icon" type="image/x-icon" href="../CSSsJSs/icons/pyramid.svg" />
  <title>Kaanbal</title>
  <link rel="stylesheet" href="../CSSsJSs/bootstrap441.css" />
  <link rel="stylesheet" href="stylePassword1.css" />
  <script src="scriptPassword2.js"></script>
  <script src="../CSSsJSs/minAJAX.js"></script>
</head>

<body>
  <div class="container">
    <div class="row">
      <div class="text-center col-1 col-sm-1 col-md-1 col-lg-1 col-xl-1"></div>
      <div class="textLeft col-5 col-sm-5 col-md-5 col-lg-5 col-xl-5">
        <p class="titulo" id="titulo">Kaanbal</p>
      </div>
      <div class="textRight col-5 col-sm-5 col-md-5 col-lg-5 col-xl-5"></div>
      <div class="text-center col-1 col-sm-1 col-md-1 col-lg-1 col-xl-1"></div>
    </div>
  </div>



  <div class="container">
    <div class="row">
      <div class="text-center col-1 col-sm-1 col-md-1 col-lg-1 col-xl-1"></div>
      <div class="text-center col-10 col-sm-10 col-md-10 col-lg-10 col-xl-10">
        <form oninput='psw2.setCustomValidity(psw2.value != psw.value ? "\n Passwords do not match." : "")'>
          <?php
          //echo "<p>" . $tokenLink . "  " . $correo_e . "   ";
          ?>
          <input type="text" id="token" value="<?php echo $tokenLink ?>" style="display:none;">

          <label for="correo_e">Correo</label>
          <input type="email" id="correo_e" name="correo_e" value="<?php echo $correo_e ?>" disabled />

          <label for="psw">Password</label>
          <input type="password" id="psw" name="psw" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[@#$%^&+=]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required />

          <label for="password2">Confirm Your Password</label>
          <input type="password" id="psw2" name="psw2" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[@#$%^&+=]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required />
        </form>
      </div>
      <div class="text-center col-1 col-sm-1 col-md-1 col-lg-1 col-xl-1"></div>
    </div>
  </div>

  <div class="container">
    <div class="row">
      <div class="text-center col-2 col-sm-2 col-md-3 col-lg-3 col-xl-3"></div>
      <div class="text-center col-8 col-sm-8 col-md-6 col-lg-6 col-xl-6">
        <button class="boton2" id="submit">
          Submit
        </button>
      </div>
      <div class="text-center col-2 col-sm-2 col-md-3 col-lg-3 col-xl-3"></div>
    </div>
  </div>




  <div class="container">
    <div class="row">
      <div class="text-center col-1 col-sm-1 col-md-1 col-lg-1 col-xl-1"></div>
      <div class="text-center col-10 col-sm-10 col-md-10 col-lg-10 col-xl-10">
        <div id="message">
          <h3>Recuerda, tu contraseña debe contener:</h3>
          <p id="letter" class="invalid">Al menos 1 letra <b>minúscula</b></p>
          <p id="capital" class="invalid">
            Al menos 1 letra <b>mayúscula</b>
          </p>
          <p id="number" class="invalid">Al menos 1 <b>número</b></p>
          <p id="symbol" class="invalid">
            Al menos 1 <b>símbolo</b> @#$%^&+=
          </p>
          <p id="length" class="invalid">
            En total, mínimo <b>8 caracteres</b>
          </p>
        </div>
      </div>
      <div class="text-center col-1 col-sm-1 col-md-1 col-lg-1 col-xl-1"></div>
    </div>
  </div>

  <div class="container">
    <div class="row">
      <div class="text-center col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
        <p style="color:rgba(0,0,0,0)">.</p>
      </div>
    </div>
    <div class="row">
      <div class="text-center col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
        <p style="color:rgba(0,0,0,0)">.</p>
      </div>
    </div>
  </div>

  <div class="container">
    <div class="row">
      <div class="col-4 col-sm-4 col-md-4 col-lg-4 col-xl-4 ">
        <p class="footSubject">Nosotros</p>
      </div>
      <div class="col-4 col-sm-4 col-md-4 col-lg-4 col-xl-4 ">
        <p class="footSubject">Ayuda</p>
      </div>
      <div class="col-4 col-sm-4 col-md-4 col-lg-4 col-xl-4 ">
        <p class="footSubject">Términos</p>
      </div>
    </div>
  </div>
</body>

</html>