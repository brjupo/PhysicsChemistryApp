document.addEventListener("click", function(evt) {
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
  var matricula = $("#matricula").val();
  console.log(matricula.length);
  if (matricula.length < 9) {
    alert("Error en el usuario");
  } else {
    var contrasenia = $("#psw").val();
    console.log("Matricula: ", matricula, " Contras: ", contrasenia);
    $.ajax({
      type: "POST",
      url: "../../servicios/subirUno.php",
      dataType: "json",
      data: { studentID: matricula, password: contrasenia },
      success: function(data) {
        console.log(data.response);
        if (data.response == "true") {
          alert("Usuario registrado");
          console.log("Registro exitoso");
        } else {
          alert(data.response);
          console.log("Registro no exitoso");
        }
      }
    });
  }
}
