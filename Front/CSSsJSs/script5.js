//Opcion1ConImagen

document.addEventListener("click", function (evt) {
  Opcion1ConImagen = document.getElementById("Opcion1ConImagen");
  targetElement = evt.target; // clicked element

  do {
    if (targetElement == Opcion1ConImagen) {
        cambio();
        $("body").load("mathjax.txt");
      return;
    }

    // Go up the DOM
    targetElement = targetElement.parentNode;
  } while (targetElement);
});


function cambio(){
    //textoPreguntaTipo1
    document.getElementById("textoPreguntaTipo1").innerHTML = 
    "¿Cuál es la equivalencia correcta para la expresion (\\(\\vec{B}\\))";
}