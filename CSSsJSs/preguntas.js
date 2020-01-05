document.addEventListener("click", function(evt) {
  var cruzCerrar = document.getElementById("cruzCerrar");
  var Opcion1 = document.getElementById("Opcion1");
  var Opcion2 = document.getElementById("Opcion2");
  var Opcion3 = document.getElementById("Opcion3");
  var Opcion4 = document.getElementById("Opcion4");
  targetElement = evt.target; // clicked element

  do {
    if (targetElement == cruzCerrar) {
      seguroRegresar();
      return;
    }
    if (targetElement == Opcion1) {
      incorrecto();
      return;
    }
    if (targetElement == Opcion2) {
      incorrecto();
      return;
    }
    if (targetElement == Opcion3) {
      correcto();
      return;
    }
    if (targetElement == Opcion4) {
      incorrecto();
      return;
    }
    // Go up the DOM
    targetElement = targetElement.parentNode;
  } while (targetElement);
});

function seguroRegresar() {
  if (
    confirm(
      "¿Estás seguro de regresar?\n Si regresas perderás todo tu avance de este tema"
    )
  ) {
    window.location.href = "subtemas.html";
  }
}
function incorrecto() {
  disableAllButtons();
  document.getElementById("incorrecto").style.display = "block";
}
function correcto() {
  disableAllButtons();
  document.getElementById("correcto").style.display = "block";
}

function disableAllButtons(){
  document.getElementById("Opcion1").disabled = true;
  document.getElementById("Opcion2").disabled = true; 
  document.getElementById("Opcion3").disabled = true; 
  document.getElementById("Opcion4").disabled = true; 
}