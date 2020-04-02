//--------------------------------------------------------------
//---------------------------ON CLIC----------------------------
//--------------------------------------------------------------
//Kmara prrrooooooooo
document.addEventListener("click", function(evt) {
  var mandarInfoAlServicio = document.getElementById("mandarInfoAlServicio");
  var botonContrasenaOlvidada = document.getElementById("contraOlvidada");
  var botonLogin = document.getElementById("botonSesion");
  targetElement = evt.target; // clicked element

  do {
    if (targetElement == botonContrasenaOlvidada) {
      showContraOlvidada();
      return;
    }
    if (targetElement == mandarInfoAlServicio) {
      //servicio();
      return;
    }
    if (targetElement == botonLogin) {
      showIniciarSesion();
      return;
    }
    // Go up the DOM
    targetElement = targetElement.parentNode;
  } while (targetElement);
});

function servicio() {
  var matricula = $("#validarUsuario").val();
  var contrasenia = $("#validarPassword").val();
  console.log("Matricula: ", matricula, " Contras: ", contrasenia);
  $.ajax({
    type: "POST",
    url: "../../Servicios/inicio.php",
    dataType: "json",
    data: { studentID: matricula, password: contrasenia },
    success: function(data) {
      console.log(data.response);
      if (data.response == "true") {
        alert("Usuario registrado");
        console.log("Registro exitoso");
      } else {
        //alert(data.response);
        alert("Si olvidó su contraseña, de clic en 'Olvidé mi contraseña'");
        console.log("Registro no exitoso");
        //document.getElementById("emailMessage").innerHTML = data.response;
      }
    }
  });
}

function showContraOlvidada() {
  var matricula = $("#validarUsuario").val();
  console.log("Matricula: ", matricula);
  $.ajax({
    type: "POST",
    url: "../../Servicios/contraOlvidada.php",
    dataType: "json",
    data: { correo_e: matricula },
    success: function(data) {
      console.log(data.response);
      if (data.response == "true") {
        //alert("Etcito");
        document.getElementById("emailMessage").innerHTML =
          "Te hemos enviado un mensaje a tu correo para recuperar tu contraseña.";
        console.log("Correo enviado");
      } else {
        //alert(data.response);
        document.getElementById("emailMessage").innerHTML = data.response;
      }
    }
  });
  //document.getElementById("forma").style.display = "none";
  document.getElementById("emailSent").style.display = "block";
}

function showIniciarSesion() {
  var matricula = $("#validarUsuario").val();
  var pswd = $("#validarPassword").val();

  console.log("Matricula: ", matricula);
  console.log("Password: ", pswd);

  $.ajax({
    type: "POST",
    url: "../../Servicios/login.php",
    dataType: "json",
    data: { correo: matricula, password: pswd },
    success: function(data) {
      console.log(data.response);
      if (data.response == "Sesion iniciada correctamente") {
        //alert("Etcito");
        console.log("Sesion iniciada correctamente");
        goToTemas(data.tokenA);
        //****no location.replace("Front/Inicio/temas.php");
        //console.log(data.tokenA);
      } else {
        //alert(data.response);
        console.log("Algo salio mal");
      }
    }
  });
}

function goToTemas(token) {
  $.ajax({
    type: "POST",
    url: "../../Front/Inicio/temas.php",
    dataType: "json",
    data: {tokenA:token}
  });
  location.replace("../../Front/Inicio/temas.php");
}
