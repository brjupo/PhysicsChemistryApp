document.addEventListener("click", function (evt) {
  var mandarInfoAlServicio = document.getElementById("submit");
  var titulo = document.getElementById("titulo");
  targetElement = evt.target; // clicked element

  do {
    if (targetElement == mandarInfoAlServicio) {
      sentInfoToService();
      return;
    }
    if (targetElement == titulo) {
      index();
      return;
    }
    // Go up the DOM
    targetElement = targetElement.parentNode;
  } while (targetElement);
});

function index() {
  window.location.href = "https://kaanbal.net";
}

function sentInfoToService() {
  var token = document.getElementById("token").value.trim();
  var correo_e = document.getElementById("correo_e").value.trim();
  var contrasenia = document.getElementById("psw").value.trim();
  var contrasenia2 = document.getElementById("psw2").value.trim();
  if (contrasenia != contrasenia2) {
    alert("Por favor revisa los campos");
  } else {
    console.log(
      "Correo: ",
      correo_e,
      " Contras: ",
      contrasenia,
      " token: ",
      token
    );
    $(function () {
      $.ajax({
        type: "POST",
        url: "../../servicios/registro.php",
        dataType: "json",
        data: { correo: correo_e, password: contrasenia, tokenA: token },
        success: function (data) {
          console.log(data.response);
          if (data.response == "true") {
            alert("Contraseña registrada");
            window.location.href = "https://kaanbal.net";
            console.log("Registro exitoso");
          } else {
            alert("Algo fallo :/ ");
            console.log("Registro no exitoso");
          }
        },
      });
    });
  }
}
