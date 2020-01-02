
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
    if (confirm("Press a button!")) {
      window.location.href = 'subtemas.html';
    } 
  }