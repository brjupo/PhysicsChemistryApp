<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="shortcut icon" type="image/x-icon" href="../icons/EducAppIcon.png" />
  <link rel="stylesheet" href="../CSSsJSs/bootstrap441.css" />
  <link rel="stylesheet" href="../CSSsJSs/stylePassword.css" />
  <script src="../CSSsJSs/password.js"></script>
  <script src="../CSSsJSs/minAJAX.js"></script>
</head>

<body>
  <?php
  $servername = "localhost";
  $username = "u526597556_dev";
  $password = "1BLeeAgwq1*isgm&jBJe";
  $dbname = "u526597556_kaanbal";
  ?>
  <!--$con = mysqli_connect("localhost", 
  "u526597556_dev", "1BLeeAgwq1*isgm&jBJe", "u526597556_kaanbal");
  -->
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
        <form oninput='psw2.setCustomValidity(psw2.value != psw.value ? "\n Passwords do not match." : "")'>
          <?php
          $tokenLink = $_GET['token'];
          //echo "<p>" . $tokenLink . "  ";
          $createdQuery = "SELECT id_usuario, mail, pswd, tokenA FROM usuario_prueba WHERE tokenA = '" . $tokenLink . "' LIMIT 1;";
          //echo $createdQuery . "</p>";
          ?>

          <label for="correo_e">Correo</label>
          <input type="email" id="correo_e" name="correo_e" value="          
          <?php
          try {
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $conn->query($createdQuery);
            while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
              echo $row[1];
            }
          } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
          }
          $conn = null;
          ?>
          " />

          <label for="psw">Contraseña</label>
          <input type="password" id="psw" name="psw" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[@#$%^&+=]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required />

          <label for="password2">Confirma contraseña</label>
          <input type="password" id="psw2" name="psw2" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[@#$%^&+=]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required />
          <p style="color:rgba(0,0,0,0)">.</p>
        </form>
      </div>
      <div class="textCenter col-1 col-sm-1 col-md-1 col-lg-1 col-xl-1"></div>
    </div>
  </div>

  <div class="container">
    <div class="row">
      <div class="textCenter col-2 col-sm-2 col-md-5 col-lg-5 col-xl-5"></div>
      <div class="textCenter col-8 col-sm-8 col-md-2 col-lg-2 col-xl-2">
        <button class="boton2" id="submit" >
          Submit
        </button>
      </div>
      <div class="textCenter col-2 col-sm-2 col-md-5 col-lg-5 col-xl-5"></div>
    </div>
  </div>




  <div class="container">
    <div class="row">
      <div class="textCenter col-1 col-sm-1 col-md-1 col-lg-1 col-xl-1"></div>
      <div class="textCenter col-10 col-sm-10 col-md-10 col-lg-10 col-xl-10">
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
      <div class="textCenter col-1 col-sm-1 col-md-1 col-lg-1 col-xl-1"></div>
    </div>
  </div>

  <div class="container">
    <div class="row">
      <div class="textCenter col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
        <p style="color:rgba(0,0,0,0)">.</p>
      </div>
    </div>
    <div class="row">
      <div class="textCenter col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
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