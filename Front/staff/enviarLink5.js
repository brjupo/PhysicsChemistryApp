window.onload = function () {
  //var specialChars = "!@#$%^&*()-_=+[{]}\\|;:'\",<.>/?`~";
  var myInput = document.getElementById("psw");
  var letter = document.getElementById("letter");
  var capital = document.getElementById("capital");
  var number = document.getElementById("number");
  var length = document.getElementById("length");
  var symbol = document.getElementById("symbol");
};

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
  var emailCliente = document.getElementById("correoAlumno").value.trim();
  if (contrasenia == contrasenia2) {
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
    $.ajax({
      type: "POST",
      url: "../../servicios/passLink.php",
      dataType: "json",
      data: {
        usuario: correo_e,
        color: contrasenia,
        kaanbalUser: contrasenia2,
        emailCliente: emailCliente,
      },
      success: function (data) {
        if (data.response != "true") {
          //alert("Contraseña registrada");
          //window.location.href = "https://kaanbal.net";
          console.log(data.response);
          document.getElementById("respuesta").innerHTML = JSON.stringify(data);
          document.getElementById("psw2").value = "";
          document.getElementById("correoAlumno").value = "";
        } else {
          alert("Algo fallo :/ ");
          console.log("Registro no exitoso");
        }
      },
    });
  }
}
