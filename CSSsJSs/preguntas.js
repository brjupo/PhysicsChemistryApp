
document.addEventListener("click", function(evt) {
    var cruzCerrar = document.getElementById("cruzCerrar");
    targetElement = evt.target; // clicked element
  
    do {
      if (targetElement == cruzCerrar) {
        seguroRegresar();
        return;
      }
      // Go up the DOM
      targetElement = targetElement.parentNode;
    } while (targetElement);
  });

  function seguroRegresar() {
    if (confirm("¿Estás seguro de regresar?\n Si regresas perderás todo tu avance de este tema")) {
      window.location.href = 'subtemas.html';
    } 
  }