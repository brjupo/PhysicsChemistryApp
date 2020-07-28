//--------------------------------------------------------------
//---------------------------ON CLIC----------------------------
//--------------------------------------------------------------
//Kmara prrrooooooooo
document.addEventListener("click", function(evt) {
    var botonContrasenaOlvidada = document.getElementById("contraOlvidada");
    var spanish = document.getElementById("spanish");
    var english = document.getElementById("english");
    targetElement = evt.target; // clicked element
  
    do {
      if (targetElement == botonContrasenaOlvidada) {
        showContraOlvidada();
        return;
      }
      if (targetElement == spanish) {
        escribirEspanol();
        cambiarEspanol()
        return;
      }
      if (targetElement == english) {
        escribirIngles();
        return;
      }
      // Go up the DOM
      targetElement = targetElement.parentNode;
    } while (targetElement);
  });

  
            function cambiarEspanol() {
                var slogan = document.getElementById("slogan");
                slogan.innerHTML = "!Diviértete Aprendiendo!";
                var slogan = document.getElementById("usuario");
                slogan.innerHTML = "Usuario";
            } 

  
  function escribirEspanol(){
    document.getElementById("idioma").value = "e";
    document.getElementById("spanish").style.webkitFilter = "brightness(3)";
    document.getElementById("english").style.webkitFilter = "brightness(1)";
  }
  function escribirIngles(){
    document.getElementById("idioma").value = "i";
    document.getElementById("spanish").style.webkitFilter = "brightness(1)";
    document.getElementById("english").style.webkitFilter = "brightness(3)";
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
          //goToTemas(data.tokenA);
          //****no location.replace("Front/Inicio/temas.php");
          //console.log(data.tokenA);
        } else {
          //alert(data.response);
          console.log("Algo salio mal");
        }
      }
    });
  }