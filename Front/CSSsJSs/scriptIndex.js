//--------------------------------------------------------------
//---------------------------ON CLIC----------------------------
//--------------------------------------------------------------
document.addEventListener("click", function(evt) {
  var mandarInfoAlServicio = document.getElementById("mandarInfoAlServicio");
  var botonContrasenaOlvidada = document.getElementById("contraOlvidada");
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
    data: { correo_e: matricula},
    success: function(data) {
      console.log(data.response);
      if (data.response == "true") {
        alert("Etcito");
        document.getElementById("emailMessage").innerHTML = 
        "Te hemos enviado un mensaje a tu correo para recuperar tu contraseña.";
        console.log("Correo enviado");
      } else {
        alert(data.response);
        document.getElementById("emailMessage").innerHTML = data.response;
      }
    }
  });
  document.getElementById("forma").style.display = "none";
  document.getElementById("emailSent").style.display = "block";
}
