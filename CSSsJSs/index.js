/*document.addEventListener("click", function (evt) {
    var flyoutElement = document.getElementById('botonCodigo');
    var flyoutElement2 = document.getElementById('botonSesion');
    targetElement = evt.target;  // clicked element

    do {
        if(targetElement.className==="continue") {
            document.getElementById("flyout-debug").textContent = "Clicked dentro de continue";
            return;
        }
        if (targetElement == flyoutElement) {
            // This is a click inside. Do nothing, just return.
            document.getElementById("flyout-debug").textContent = "Clicked inside!";
            return;
        }
        if (targetElement == flyoutElement2) {
            // This is a click inside. Do nothing, just return.
            document.getElementById("flyout-debug").textContent = "Clicked inside!";
            return;
        }
        // Go up the DOM
        targetElement = targetElement.parentNode;
    } while (targetElement);

    // This is a click outside.
    document.getElementById("flyout-debug").textContent = "Clicked outside!";
    hideAll();
});*/

document.addEventListener("click", function (evt) {
  var botonCodigo = document.getElementById("botonCodigo");
  var botonSesion = document.getElementById("botonSesion");
  var mandarInfoAlServicio = document.getElementById("mandarInfoAlServicio");
  var botonContrasenaOlvidada = document.getElementById("contraOlvidada");
  targetElement = evt.target; // clicked element

  do {
    if (targetElement == botonCodigo) {
      console.log("Codigo");
      showCode();
      return;
    }
    if (targetElement == botonSesion) {
      console.log("Sesion");
      showSession();
      return;
    }
    if (targetElement == botonContrasenaOlvidada) {
      showContraOlvidada();
      return;
    }
    if (targetElement == mandarInfoAlServicio) {
      servicio();
      return;
    }
    // Go up the DOM
    targetElement = targetElement.parentNode;
  } while (targetElement);
});

function showCode() {
  hideAll();
  document.getElementById("seccionCodigo").style.display = "block";
}
function showSession() {
  hideAll();
  document.getElementById("seccionSesion").style.display = "block";
}

function hideAll() {
  document.getElementById("seccionCodigo").style.display = "none";
  document.getElementById("seccionSesion").style.display = "none";
  document.getElementById("emailSent").style.display = "none";
  document.getElementById("relleno").style.display = "none";
}

function showContraOlvidada() {
  hideAll();
  document.getElementById("emailSent").style.display = "block";
}

function servicio() {
  // Definimos la URL que vamos a solicitar via Ajax
  var ajax_url = "https://educapp-frontend.000webhostapp.com/registerEducapp.php";

  // El JSON a enviar
  var myjson = JSON.stringify({ name: "value", username: "value", pasword: "value2" });
  var ajax_request = new XMLHttpRequest();
  ajax_request.open("POST", ajax_url, true);

  // Establecer la cabecera Content-Type apropiada
  ajax_request.setRequestHeader("Content-Type", "application/json; charset=UTF-8");

  // Enviar la solicitud
  ajax_request.send(myjson);
  setTimeout(function () {
    //do what you need here
    console.log("enviado");
  }, 2000);

  /// Obtenemos el json enviado
  //$data = file_get_contents('php://input');
  // Los convertimos en un array
  //$data = json_decode($data, true);
}

window.onload = function () {
  //this.hideAll();
  // Fetch all the forms we want to apply custom Bootstrap validation styles to
  var forms = document.getElementsByClassName("needs-validation");
  //var forms = document.getElementById('validacion');
  // Loop over them and prevent submission
  var validation = Array.prototype.filter.call(forms, function (form) {
    form.addEventListener(
      "submit",
      function (event) {
        if (form.checkValidity() === false) {
          event.preventDefault();
          event.stopPropagation();
        }
        form.classList.add("was-validated");
      },
      false
    );
  });
};
