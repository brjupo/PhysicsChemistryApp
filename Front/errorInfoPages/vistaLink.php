<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="shortcut icon" type="image/x-icon" href="../CSSsJSs/icons/pyramid.svg" />
  <title>Kaanbal</title>
  <link rel="stylesheet" href="../CSSsJSs/bootstrap441.css" />
  <link rel="stylesheet" href="stylePassword1.css" />
  <script src="vistaLink1.js"></script>
  <script src="../CSSsJSs/minAJAX.js"></script>
</head>

<body>
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

          <label for="correo_e">Usuario</label>
          <input type="text" id="correo_e" name="correo_e">

          <label for="psw">Password</label>
          <input type="text" id="psw" name="psw"/>

          <label for="password2">Alumno Kaanbal</label>
          <input type="text" id="psw2" name="psw2" />
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